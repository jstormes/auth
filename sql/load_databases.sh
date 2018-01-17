#!/usr/bin/env bash
#
# Script to populate a MySql from a discreet set of directories
# containing *.sql files.  All files are run in 'sort -V' order.
#
# Author James Stormes (jstormes@stormes.net)
#

wait_for_mysql () {
   until mysqladmin ping  >/dev/null 2>&1; do
       echo -n "."; sleep 0.2
   done
   until echo "show databases;" | mysql >/dev/null 2>&1; do
       echo -n "."; sleep 0.2
   done
}

create_database () {
    echo "CREATE DATABASE IF NOT EXISTS $1;" | mysql
}

load_from_directory() {
    # Load .sql files from directory $1
    echo "Loading database $(basename $1)"
    create_database "$(basename $1)"
    for D in ${1}/*.sql; do
        if [[ -f ${D} ]]; then
            echo "Processing ${D}"
            mysql "$(basename $1)" < ${D}
        fi
    done
}

#############################################################################
##################################### Main ##################################
#############################################################################

# CD to same directory that scrip is in.
cd "$(dirname $0)"

for D in *; do
    if [ -d "${D}" ]; then
        load_from_directory "${D}"
    fi
done

