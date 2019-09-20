#! /bin/bash
### BEGIN INIT INFO
# Provides:          rtk_start.sh
# Required-Start:
# Required-Stop:     
# Should-Stop:       
# Default-Start:     2 3 4 5 
# Default-Stop:      0 1 6
# Short-Description: Script di avvio del telegram bot
# Description:       Script di avvio del telegram bot
#                    bla bla bla 
#                    bla bla bla
### END INIT INFO

# variables containing paths to the configuration files 
PATH=/sbin:/usr/sbin:/bin:/usr/bin:/usr/local/bin
CONF=/home/local/COMGE/egter01/emergenze-pcge/pages/eventi

sleep 20

#cd $CONF

# dentro /etc/init.d
# sudo ln -s $CONF/avvio_bot.sh
# chmod +x /etc/init.d/avvio_bot.sh
# update-rc.d avvio_bot.sh defaults

python3 $CONF/forever.py $CONF/pc_bot_multithread_demo.py

echo "FINE SCRIPT AVVIO TELGRAM BOT DAEMON"
