server {
	listen 80;
	server_name   www.news.com ;
	root /var/www/vhosts/www.news.com/htdocs  ;
	index index.php  ;

	server_name_in_redirect  off;
	try_files $uri $uri/ /index.php?q=$uri&$args;
	
	# for vhost location php context we need to set 
	# Document root explicitly, otherwise we get
	# NO INPUT file specified error
	
	location ~ \.php$ {
		fastcgi_pass 127.0.0.1:9000 ;
	}  

}
