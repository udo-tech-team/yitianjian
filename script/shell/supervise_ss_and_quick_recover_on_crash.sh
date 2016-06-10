#!/bin/bash
#
#   Requirements:
#   quick_recover_ssserver_related_service.sh should be in the same dir
#
#  to see if the ssserver process started by alice[manager mode] exists
#       if exists, log ok
#       if not, start quick recover send email
#

cur_dir=$(pwd)
logpath=${cur_dir}'/log'
filename='supervise.log'
logfile=$logpath/$filename

mkdir -p $logpath

# seperate with coma
emailto="515430149@qq.com,ye515430@163.com"

warning_message='ssserver process not exists!'
subject_text='vultr err'

timenow=$(date '+%Y-%m-%d %H:%M:%S')
status_ok_notice=" ok"

process_name='ssserver'



# see if process exist
ps -ef | grep "$process_name" | grep manager | grep -v grep > /dev/null
if [ $? -eq 0 ] ; then 
    log_str=${timenow}${status_ok_notice}
    echo $log_str >> $logfile
else
    # ssserver crashed or sys reboot
    echo $warning_message > last_mail_context.txt

    # quick recover ssserver service
    date '+%Y-%m-%d %H:%M:%S' >> $logfile
    sh ${cur_dir}/quick_recover_ssserver_related_service.sh 1 >> $logfile 2 >> $logfile
    ret=$?
    echo "quick recover result: $ret" >> last_mail_context.txt
    mutt -s "$subject_text"  $emailto  < last_mail_context.txt
fi
