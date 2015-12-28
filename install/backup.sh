#!/bin/sh
BASE=/home/users
STORAGE_PATH=$1
DATE=`date +%Y-%m-%d` #Gets current date in YYYY-MM-DD format and stores it in the variable DATE


if [ -z ${1+x} ]; then
    echo "Please enter the storage path. EG: ./backup.sh /var/www/storage/backups"
    exit 1
fi

if [ "$2" = "weekly" ]; then
	TIMEFRAME="weekly"
else
	TIMEFRAME="monthly"
fi

for i in $BASE/*/ ; do
    username=$(basename "$i")
    backup_location="$STORAGE_PATH/$username/$TIMEFRAME"
    manifest_file="$backup_location/manifest.txt"

    if [ ! -d $STORAGE_PATH/$username ]; then
        mkdir "$STORAGE_PATH/$username"
        mkdir "$STORAGE_PATH/$username/$TIMEFRAME"
    fi

    if [ ! -f $manifest_file ]; then
        echo "0000-00-00\n0000-00-00\n0000-00-00\n0000-00-00" > $manifest_file
    fi

    OLD=$(head -1 $manifest_file) # Read first line

    # Put a backup in the relevant folder
    tar cvfz "${backup_location}/$DATE.tgz" "${i}public_html"

    # Delete the old backup and update manifest
    rm -f $backup_location/$OLD
    sed -i '1 d' $manifest_file
	sed -i "$ a\\$DATE" $manifest_file

    chown -R www-data:www-data $STORAGE_PATH
done