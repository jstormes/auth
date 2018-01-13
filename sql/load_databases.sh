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
   until echo "show databases;" | mysql -h ${COMPOSE_PROJECT_NAME}_mysql >/dev/null 2>&1; do
       echo -n "."; sleep 0.2
   done
}

create_database () {
    echo
    echo "Verifying database '$1' exists."
    echo "CREATE DATABASE IF NOT EXISTS $1;" | mysql
}

run_sql_files () {
    if [ -d "$1" ]; then
        cwd=$(pwd)
        cd $1
        if ls *.sql 1> /dev/null 2>&1; then
            for f in `ls *.sql | sort -V`;
                do
                    echo "Processing file '$f'"
                    mysql ${MYSQL_DATABASE_NAME} < ${f}
                done
        fi
        cd ${cwd}
    fi
}

#############################################################################
##################################### Main ##################################
#############################################################################

# Set defaults in ~/.my.cnf
MYSQL_HOST="${COMPOSE_PROJECT_NAME}_mysql"

echo "[client]"                        >  ~/.my.cnf
echo "password=\"${MYSQL_PWD}\""      >> ~/.my.cnf
echo "host=${MYSQL_HOST}"             >> ~/.my.cnf

sleep 3
echo "Waiting for MySQL to start"
echo
wait_for_mysql

# Set the default database
create_database $MYSQL_DATABASE_NAME
echo "database=$MYSQL_DATABASE_NAME"  >> ~/.my.cnf

# Load .sql files
echo "Running MySQL *.sql files"
run_sql_files "sql/1_schema"
run_sql_files "sql/2_triggers"
run_sql_files "sql/3_lookup_data"
run_sql_files "sql/4_development_data"

echo
echo
echo "**********************************************************************"
echo "*                                                                     "
echo "* To connect from the host system use IP address 127.0.0.1 port ${EXTERNAL_MYSQL_PORT}  "
echo "* user id 'root' password is '${MYSQL_PWD}'.                          "
echo "*                                                                     "
echo "* To connect from another Docker container use the DNS name $MYSQL_HOST "
echo "* port 3306.  Be sure to link to this containers using the            "
echo "* --link option (--link $MYSQL_HOST:$MYSQL_HOST)                      "
echo "*                                                                     "
echo "* ALL DATABASE CHANGES WILL BE LOST WHEN YOU STOP THE $MYSQL_HOST     "
echo "* CONTAINER!!!                                                        "
echo "*                                                                     "
echo "**********************************************************************"
echo
echo

#exec bash
