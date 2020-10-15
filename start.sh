
#!/bin/bash

x="\x1b["
R=$x"38;5;7m"
AB=$x"38;05;86m"
FL=$x"38;05;204m"
A=$x"38;05;193m"
echo -e "[$AB AB $R] $A Please wait..$R"
sleep 1
apt-get install screen php5-common libapache2-mod-php5 php5-cli -y
apt-get update -y
apt-get upgrade -y
sudo apt-get install screen php5-common libapache2-mod-php5 php5-cli -y
sudo apt-get update -y
sudo apt-get upgrade -y
clear
sleep 1

if [ "$1" = "A-Antibadges" ]
then
screen -A -m -d -S antibadges php AntiBadges.php
echo -e "[$AB AB $R] $A Activated $R"
elif [ "$1" = "D-Antibadges" ]
then
pkill -f antibadges
echo -e "[$AB AB $R] $FL Deactivated $R"
elif [ "$1" = "R-AntiBadges"
then
pkill -f antibadges
sleep 1
screen -A -m -d -S antibadges php AntiBadges.php
else
echo -e "$FL Ouh.. Command does not exist.$A\n Use:\n $AB./start.sh A-AntiBadges (Activate AntiBadges)\n ./start.sh D-AntiBadges (Deactivate Antibadges)\n ./start.sh R-AntiBadges (Restart AntiBadges)\n $R"
fi
