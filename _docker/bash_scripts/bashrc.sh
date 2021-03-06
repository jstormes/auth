#!/usr/bin/env bash
#
# ~/.bashrc: executed by bash(1) for non-login shells.

# Note: PS1 and umask are already set in /etc/profile. You should not
# need this unless you want different defaults for root.
# PS1='${debian_chroot:+($debian_chroot)}\h:\w\$ '
# umask 022

# You may uncomment the following lines if you want `ls' to be colorized:
# export LS_OPTIONS='--color=auto'
# eval "`dircolors`"
# alias ls='ls $LS_OPTIONS'
# alias ll='ls $LS_OPTIONS -l'
# alias l='ls $LS_OPTIONS -lA'
#
# Some more alias to avoid making mistakes:
# alias rm='rm -i'
# alias cp='cp -i'
# alias mv='mv -i'


copy_ssh.sh

MYSQL_HOST="${COMPOSE_PROJECT_NAME}_mysql"

echo "[client]"                  >  ~/.my.cnf
echo "password=\"${MYSQL_PWD}\"" >> ~/.my.cnf
echo "host=${MYSQL_HOST}"        >> ~/.my.cnf

echo
echo
echo " **********************************************************************"
echo " * This Docker container is for an interactive BASH shell.  It has     "
echo " * the following tools pre-loaded:                                     "
echo " *                                                                     "
echo " * composer"
echo " * phpunit"
echo " * phpunit/dbunit"
echo " * phing "
echo " * phpcpd "
echo " * phploc "
echo " * phpmd "
echo " * phpcs "
echo " * mysql - should automatically connect to linked mysql server. "
echo " * curl "
echo " * net-tool "
echo " *                                                                     "
echo " * NOTE: If you cannot connect to mysql wait a few second for the mysql"
echo " * server to start."
echo " **********************************************************************"
echo
echo

#exec bash

