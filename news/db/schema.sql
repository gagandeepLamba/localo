     
--
-- DB for new application
-- 
-- 

--
-- word about created_on and updated on timestamp columns
--
-- MySQL is weird in the sense that it assumes ON UPDATE clause if you do not
-- supply a default timestamp !!!
--
-- With neither DEFAULT nor ON UPDATE clauses
-- it is the same as DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP.
-- http://dev.mysql.com/doc/refman/5.0/en/timestamp.html
--
--

drop table if exists news_post;
create table news_post(
	id int(11) NOT NULL auto_increment,
	title varchar(256) not null UNIQUE ,
	summary TEXT not null ,
    description TEXT ,
    created_on timestamp default '0000-00-00 00:00:00',
	updated_on timestamp default '0000-00-00 00:00:00' ,
	PRIMARY KEY (id)) ENGINE = MYISAM;
    
    