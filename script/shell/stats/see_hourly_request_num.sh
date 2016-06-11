#!/bin/bash
# sh script.sh  begin_hour end_hour month-day[05-02]

total=0

echo "see hourly request statistics of 2016-$3:"
echo "==================="

for hour in `seq -w $1 $2` ; 
do  
    hourly_hour=$(grep "2016-$3 $hour" shadowsocks.alice.log -c ); 
    echo $hour:$hourly_hour; 
    total=$((hourly_hour+total));
done

echo "==================="
echo "total: "$total

#for hour in `seq -w  0 23 ` ; do echo $hour; grep "2016-06-01 $hour" -c shadowsocks.alice.log ; done;

