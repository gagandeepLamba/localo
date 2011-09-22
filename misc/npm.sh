#!/bin/bash


start_nginx() 
{
	ps -ef | grep -v grep | grep nginx
	# if not found - equals to 1, start it
	if [ $? -eq 1 ]
	then
		/usr/local/sbin/nginx
		echo "started nginx ..."
		echo 
	else
		n_pid=`cat /usr/local/var/run/nginx.pid`
		echo "=> nginx is already running with pid $n_pid"
		echo ""
	fi

}

stop_nginx()
{
	/usr/local/sbin/nginx -s stop
	echo "stopped nginx ..."
	echo 

}


start_php() 
{
	ps -ef | grep -v grep | grep php
	# if not found - equals to 1, start it
	if [ $? -eq 1 ]
	then
		/usr/local/sbin/php-fpm.dSYM
		echo "started php-fpm listeners... "
		echo 
	else
		n_pid=`cat /usr/local/var/run/php-fpm.pid`
		echo "=> php-fpm  is already running with pid $n_pid"
		echo ""
	fi
}

stop_php()
{

	n_pid=`cat /usr/local/var/run/php-fpm.pid`
	kill $n_pid 
	echo "stopped php-fpm listeners ... "
	echo 

}


start_mysql ()
{
	
	ps -ef | grep -v grep | grep mysql
	# if not found - equals to 1, start it
	if [ $? -eq 1 ]
	then
		/usr/local/mysql/bin/mysqld_safe
		echo "started mysql database... "
		echo 
	else
		n_pid=`cat /usr/local/mysql/data/rjha-mbp13h.local.pid`
		echo "=> mysql  is already running with pid $n_pid"
		echo ""
	fi

}

stop_mysql()
{
	mysqladmin shutdown 
	echo "stopped  mysql database ..."
	echo 

}



func_start() 
{
	start_nginx;
	sleep 5 ;
	start_php;
	sleep 5 ;
	start_mysql;
	sleep 5 ;
}

func_stop()
{
	echo " Are you sure (y/n) ? "
	read choice
	
	case "$choice" in 
		"Y" | "y" )
			stop_mysql;
			sleep 5 ;
			stop_php;
			sleep 5 ;
			stop_nginx;
			sleep 5 ;
		;;
		* )
			echo
			echo " GoodBye! "
			echo 
		;;
	esac	

}


#read user input 

case "$1" in
	"start" )
		func_start 
	
	;;
	"stop" )
		func_stop
	;;
	* )
		echo
		echo " Usage : sudo launch.sh start|stop "
		echo
		
	;;
esac





