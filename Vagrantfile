# -*- mode: ruby -*-
# vi: set ft=ruby :

project_name = "netsocadmin"
ip_address = "172.22.22.25"

# Begin our configuration using V2 of the API
Vagrant.configure(2) do |config|
  
  config.vm.box = "Netsoc"
  config.vm.box_url = "http://files.netsoc.co/f/2e06d99781/?dl=1"
  config.vm.box_check_update = true

  # Configuration for our virtualisation provider
  config.vm.provider "VirtualBox" do |vb|
     # Memory (RAM) capped at 1024mb
    vb.customize ["modifyvm", :id, "--memory", "1024"]
  end

  # Give our new VM a fake IP Address and domain name
  # To utilise this, add the following to your /etc/hosts file
  #   172.22.22.22 netsoc.dev
  config.vm.define project_name do |node|
    node.vm.hostname = project_name + ".dev"
    node.vm.network :private_network, ip: ip_address
  end

  # Sync the containing folder to the web directory of the VM
  #   The sync will persist as you edit files, you won't have
  #   to destroy and re-up the VM each time you make a change
  #   
  config.vm.synced_folder "./", "/var/www", :owner=> 'www-data', :group=>'www-data'
  config.vm.synced_folder "./public", "/var/www/html", :owner=> 'www-data', :group=>'www-data'

  config.vm.provision "shell", inline: <<-SHELL

  	sudo apt-get update 
  	sudo apt-get install -y php5-ldap
  	sudo service apache2 restart

    # Create our database and give root all permissions
    mysql -uroot -proot -e "CREATE DATABASE IF NOT EXISTS #{project_name};"
    mysql -uroot -proot -e "GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY 'root';"
    sudo service mysql restart
    
    #Create swap space for composer's operations
    sudo /bin/dd if=/dev/zero of=/var/swap.1 bs=1M count=1024
    sudo /sbin/mkswap /var/swap.1
    sudo /sbin/swapon /var/swap.1

    # Update laravel and create all the DB tables
    cd /var/www/
    sudo composer update
    sudo php artisan migrate
    sudo php artisan db:seed
  SHELL
end
