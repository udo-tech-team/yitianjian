#!/bin/bash
#########################################
#
#  this script process a quick recover for ssserver related services
#   1. check if ssserver alice, if alive, exit, else then:
#   2. check port_manager process exists, if exists, kill and restart as daemon
#   3. start recover message sender, let yitianjian web server send port info to ss
#
#
#########################################

cur_dir=$(pwd)
logpath=${cur_dir}'/log'
filename='quick_recover.log'

mkdir -p $logpath
logfile=$logpath/$filename

process_name='ssserver'
recover_working_dir='/home/alice/script'

# see if process exists
ps -ef | grep "$process_name" | grep manager | grep -v grep > /dev/null

ps_ret=$?
if [[ $ps_ret -eq 0 ]]; then
    log_str=$(date '+%Y-%m-%d %H:%M:%S')
    proc_res="$process_name exists!"
    log_str=${log_str}${proc_res}

    # append log
    echo $log_str >> $logfile
    exit 0
fi

# process not exists
# exit when any cmd exec fail
set -e
cd $recover_working_dir 

info_log='ss_server_start.log'
err_log='ss_server_start.log.err'
port_manager_py='port_manager_server.v3.py'
recover_message_sender='ss_message_sender.py'

# start ssserver
date '+%Y-%m-%d %H:%M:%S' >> $info_log 
date '+%Y-%m-%d %H:%M:%S' >> $err_log
sh start_v2.cmd 1 >> $info_log 2 >> $err_log

# kill daemon port_manager process, ignore failure
set +e
port_manager_process=$(ps ux | grep port_manager | grep -v grep | awk '{print $2}')
kill -9 $port_manager_process

set -e
# start port_manager as daemon process
python $port_manager_py &

# send recover message to yitianjian web server
python $recover_message_sender

