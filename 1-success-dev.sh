#! /bin/bash

CHAT_ID="-1001753900564"
BOT_TOKEN=5661991500:AAGCoupSna5pCqe7oH-KMaUh0KloW6gxnsw


HASH=$(git log -n 1 |grep commit)
AUTHOR=$(git show $HASH | grep Author)
# MESSAGE=$(git show -s --format=%s)
Log=$(git log -n 1 --pretty=format:"<b>COMMITER</b>: %cN %n<b>DATE</b>: %ci %n<b>MESSAGE</b>: %s")

MSG="<b>STAGE</b>: KNK HOMEAPPLINCE API%0A<b>STATUS</b>: Success%0A${Log}"


if [ -z "${Log}" ]; then
    echo "String is empty"
    else
    curl -s -X POST https://api.telegram.org/bot${BOT_TOKEN}/sendMessage -d chat_id=${CHAT_ID} -d text="${MSG}" -d parse_mode="HTML"
fi