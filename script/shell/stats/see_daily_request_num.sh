#!/bin/bash
# sh script.sh  begin_day end_day month
info_total=0
warning_total=0
error_total=0
#for num in `seq -w $1 $2` ; do  daily_num=$(grep 2016-$3-$num -c shadowsocks.alice.log) ; echo $num:$daily_num; total=$((daily_num+total));done
for num in `seq -w $1 $2` ; 
do  
    if [ $2 -lt 10 ]; then
        num='0'${num}
    fi
    info_daily_num=$(grep 2016-$3-$num shadowsocks.alice.log | grep INFO -c ); 
    info_total=$((info_daily_num+info_total));

    warning_daily_num=$(grep 2016-$3-$num shadowsocks.alice.log | grep WARNING -c ); 
    warning_total=$((warning_daily_num+warning_total));

    error_daily_num=$(grep 2016-$3-$num shadowsocks.alice.log | grep ERROR -c ); 
    error_total=$((error_daily_num+error_total));


    echo $num:info=${info_daily_num},warning=${warning_daily_num},err=${error_daily_num};
done

echo "==================="
echo "info_total: "${info_total}", warning_total:"${warning_total}", error_total:"${error_total}
