#!/bin/sh
BASE=/home/users
STORAGE_PATH=/var/www/storage/backups
DATE=`date +%Y-%m-%d` #Gets current date in YYYY-MM-DD format and stores it in the variable DATE

if [ "$1" = "weekly" ]; then
	TIMEFRAME="weekly"
else
	TIMEFRAME="monthly"
fi

for i in $BASE/*/ ; do
    username=$(basename "$i")
    backup_location="$STORAGE_PATH/$username/$TIMEFRAME"
    manifest_file="$backup_location/manifest.txt"
    OLD=$(head -1 $manifest_file) # Read first line

    # Put a backup in the relevant folder
    tar cvfz "${backup_location}/$DATE.tgz" "${i}public_html"

    # Delete the old backup and update manifest
    rm -f $backup_location/$OLD
    sed -i '1 d' $manifest_file
	sed -i "$ a\\$DATE" $manifest_file
done