#! /bin/bash

CHAT_ID="-1001753900564"
BOT_TOKEN=5661991500:AAGCoupSna5pCqe7oH-KMaUh0KloW6gxnsw

# HASH=$(git log -n 1 |grep commit)
# AUTHOR=$(git show $HASH | grep Author)
# MESSAGE=$(git show -s --format=%s)
L="------------------------------------------------------"
Log=$(git log -n 1 --pretty=format:"<b>COMMITER</b>: %cN %n<b>DATE</b>: %ci %n<b>MESSAGE</b>: %s")
Server="<b>Server</b>: DevAP-01%0A<b>Local IP</b>: xxx.xx.xx.x%0A<b>Sub Domain</b>: dev-api-bank.mpwt.gov.kh"
MSG="${L}%0A<b>PROJECT</b>: DUMMY BANK%0A<b>APPLICATION</b>: API%0A<b>STATUS</b>:  Success%0A<b>VERSION</b>: ${BUILD_NUMBER}%0A${L}%0A${Log}%0A${L}%0A${Server}%0A${L}"


# echo "$MSG"

if [ -z "${Log}" ]; then
    echo "String is empty"
    else
    curl -s -X POST https://api.telegram.org/bot${BOT_TOKEN}/sendMessage -d chat_id=${CHAT_ID} -d text="${MSG}" -d parse_mode="HTML"
fi  
