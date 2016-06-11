#!/bin/bash
# sh script.sh  begin_day end_day month
total=0
#for num in `seq -w $1 $2` ; do  daily_num=$(grep 2016-$3-$num -c shadowsocks.alice.log) ; echo $num:$daily_num; total=$((daily_num+total));done
for num in `seq -w $1 $2` ; 
do  
    daily_num=$(grep 2016-$3-$num shadowsocks.alice.log | grep 'Too many open files' -v -c ); 
    echo $num:$daily_num; total=$((daily_num+total));
done

echo "==================="
echo "total: "$total
