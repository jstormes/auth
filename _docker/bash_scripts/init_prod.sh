#!/usr/bin/env bash
#
# This is a Docker Anti-Pattern.  I am putting all the services into
# one container and I am doing it knowing that this is NOT the way
# you should do it.   That is just how I roll...
#
# Breaking the law, breaking the law ...
#
# This is intended for development but also allows less experienced
# system operators to deploy to system like QNAP NAS server as one
# container, without having to understand how to connect and
# maintain separate services.
#
service mysql start
service apache2 start
service cron start
while /bin/true; do
  service mysql status > /dev/null
  PROCESS_1_STATUS=$?
  service apache2 status > /dev/null
  PROCESS_2_STATUS=$?
  service cron status > /dev/null
  PROCESS_3_STATUS=$?
  # If the greps above find anything, they will exit with 0 status
  # If they are not both 0, then something is wrong
  if [ $PROCESS_1_STATUS -ne 0 -o $PROCESS_2_STATUS -ne 0 -o $PROCESS_2_STATUS -ne 0 ]; then
    echo "One of the processes has died!!!!!"
    exit -1
  fi
  sleep 60
done
