

--create database scdb  character set utf8 collate utf8_general_ci ;

drop table if exists sc_question;
create table sc_question(
	id int(11) NOT NULL auto_increment,
	title varchar(128) not null,
	seo_title varchar(192),
	user_email varchar(64) not null,
	user_name varchar(64) not null,
    description TEXT ,
    tags varchar(64),
    links_json TEXT ,
    images_json TEXT,
    location varchar(32),
    category_code varchar(16),
    created_on timestamp default '0000-00-00 00:00:00',
	updated_on timestamp default '0000-00-00 00:00:00' ,
	PRIMARY KEY (id)) ENGINE = InnoDB default character set utf8 collate utf8_general_ci;
    
drop table if exists sc_answer;
create table sc_answer(
	id int(11) NOT NULL auto_increment,
	question_id int not null ,
	title varchar(128) ,
	user_email varchar(64) not null,
	user_name varchar(64) not null,
    answer TEXT ,
    created_on timestamp default '0000-00-00 00:00:00',
	updated_on timestamp default '0000-00-00 00:00:00' ,
	PRIMARY KEY (id)) ENGINE = InnoDB default character set utf8 collate utf8_general_ci;
    
   
 
drop table if exists sc_media;
create table sc_media(
	id int(11) NOT NULL auto_increment,
	original_name varchar(256) not null,
    stored_name varchar(64) not null,
    bucket varchar(32) not null,
	size int not null ,
    mime varchar(64) not null,
    original_height int,
    original_width int ,
    created_on timestamp default '0000-00-00 00:00:00',
	updated_on timestamp default '0000-00-00 00:00:00' ,
	PRIMARY KEY (id)) ENGINE = InnoDB default character set utf8 collate utf8_general_ci;
    


  drop table if exists sc_user;
   CREATE TABLE sc_user (
       id int(11) NOT NULL auto_increment,
       user_name varchar(64) not null,
       password varchar(64) not null,
       first_name varchar(32) not null,
       last_name varchar(32) not null,
       email varchar(64) not null,
       is_staff int default 0 ,
       is_admin int default 0,
       is_active int not null default 1,
       salt varchar(16) not null,
       login_on TIMESTAMP  default '0000-00-00 00:00:00',
       created_on TIMESTAMP  default '0000-00-00 00:00:00',
       updated_on TIMESTAMP   default '0000-00-00 00:00:00',
       PRIMARY KEY (id)) ENGINE =InnoDB  default character set utf8 collate utf8_general_ci;
    
   alter table  sc_user add constraint UNIQUE uniq_email (email);
   
   
   


drop table if exists sc_list;
create table sc_list(
	id int(11) NOT NULL auto_increment,
	name varchar(16) not null,
    code varchar(8) not null,
    display varchar(32) not null,
	ui_order int not null ,
	PRIMARY KEY (id)) ENGINE = InnoDB default character set utf8 collate utf8_general_ci;
    

--	
-- category data  
--

	
insert into sc_list(name,ui_order,code,display) values('CATEGORY',1, 'BABY', 'Baby / Kids');
insert into sc_list(name,ui_order,code,display) values('CATEGORY',2, 'BEAUTY', 'Beauty');
insert into sc_list(name,ui_order,code,display) values('CATEGORY',3, 'BOOK', 'Books');
insert into sc_list(name,ui_order,code,display) values('CATEGORY',4, 'CLOTH', 'Clothes');

insert into sc_list(name,ui_order,code,display) values('CATEGORY',5, 'MFASHION', 'Fashion - Male');
insert into sc_list(name,ui_order,code,display) values('CATEGORY',6, 'FFASHION', 'Fashion - Female');

insert into sc_list(name,ui_order,code,display) values('CATEGORY',7, 'HEALTH', 'Health / Fitness');
insert into sc_list(name,ui_order,code,display) values('CATEGORY',8, 'HOME', 'Home + Interior');
insert into sc_list(name,ui_order,code,display) values('CATEGORY',9, 'GADGET', 'Camera/Mobiles/Gadgets');
insert into sc_list(name,ui_order,code,display) values('CATEGORY',10, 'COMPUTER', 'Computer/Laptops');
insert into sc_list(name,ui_order,code,display) values('CATEGORY',11, 'OTHER', 'Others');


DROP TRIGGER IF EXISTS trg_answer_title;

delimiter //
CREATE TRIGGER trg_answer_title BEFORE INSERT ON sc_answer
    FOR EACH ROW
    BEGIN
	DECLARE p_title  varchar(128) ;
	SELECT title into p_title from sc_question where id = NEW.question_id ;
	set NEW.title = p_title ;
	
    END;//
delimiter ;

--
-- switch engine to InnoDB
-- 

--
-- 27 Feb 2012
--



drop table if exists sc_login;
create table sc_login(
	id int(11) NOT NULL auto_increment,
	name varchar(32) not null,
    provider varchar(16) not null,
	created_on TIMESTAMP  default '0000-00-00 00:00:00',
    updated_on TIMESTAMP   default '0000-00-00 00:00:00',
	PRIMARY KEY (id)) ENGINE = InnoDB default character set utf8 collate utf8_general_ci;


-- look @ DB - select user_name,email from sc_user, provider is 3mik
insert into sc_login(name,provider) values ('Rajeev Jha','3mik');

alter table sc_user add column login_id int ;
alter table sc_question add column login_id int ;
alter table sc_answer add column login_id int ;

--
-- update sc_user (login_id vs email)
-- 1 | jha.rajeev@gmail.com
-- 
-- 

update sc_user set login_id = 1 where email = 'jha.rajeev@gmail.com';
update sc_question set login_id = 1 where user_email = 'jha.rajeev@gmail.com';
update sc_answer set login_id = 1 where user_email = 'jha.rajeev@gmail.com';

--
-- verify first
-- repeat above for multiple users
-- drop user_email
-- 

alter table sc_question drop column user_email ;
alter table sc_answer drop column user_email ;

--
-- twitter user 
-- 

drop table if exists sc_twitter;
create table sc_twitter(
	id int(11) NOT NULL auto_increment,
	twitter_id int(11) NOT NULL ,
	login_id int(11) NOT NULL ,
	name varchar(32) not null,
	screen_name varchar(32) ,
	profile_image varchar(128) ,
    location varchar(32) ,
	created_on TIMESTAMP  default '0000-00-00 00:00:00',
    updated_on TIMESTAMP   default '0000-00-00 00:00:00',
	PRIMARY KEY (id)) ENGINE = InnoDB default character set utf8 collate utf8_general_ci;


alter table  sc_twitter add constraint UNIQUE uniq_id (twitter_id);

--
-- facebook user 
-- 

drop table if exists sc_facebook;
create table sc_facebook(
	id int(11) NOT NULL auto_increment,
	facebook_id int(11) NOT NULL ,
	login_id int(11) NOT NULL ,
	name varchar(32) not null,
	first_name varchar(32) ,
	last_name varchar(32) ,
	link varchar(128) ,
    gender varchar(8) ,
    email varchar(32) ,
	created_on TIMESTAMP  default '0000-00-00 00:00:00',
    updated_on TIMESTAMP   default '0000-00-00 00:00:00',
	PRIMARY KEY (id)) ENGINE = InnoDB default character set utf8 collate utf8_general_ci;


alter table  sc_facebook add constraint UNIQUE uniq_id (facebook_id);




drop table if exists sc_feedback;
create table sc_feedback(
	id int(11) NOT NULL auto_increment,
	feedback text not null,
	created_on TIMESTAMP  default '0000-00-00 00:00:00',
    updated_on TIMESTAMP   default '0000-00-00 00:00:00',
	PRIMARY KEY (id)) ENGINE = InnoDB default character set utf8 collate utf8_general_ci;
 

 
--
-- Patch to convert tables to utf-8
-- 
alter database scdb character set utf8 collate utf8_general_ci ;

alter table sc_question convert to character set utf8 collate utf8_general_ci ;
alter table sc_answer convert to character set utf8 collate utf8_general_ci ;
alter table sc_media convert to character set utf8 collate utf8_general_ci ;
alter table sc_user convert to character set utf8 collate utf8_general_ci ;
alter table sc_list convert to character set utf8 collate utf8_general_ci ;
alter table sc_login convert to character set utf8 collate utf8_general_ci ;
alter table sc_twitter convert to character set utf8 collate utf8_general_ci ;
alter table sc_facebook convert to character set utf8 collate utf8_general_ci ;
alter table sc_feedback convert to character set utf8 collate utf8_general_ci ;

-- 
-- recreate the trigger 
-- 
alter table sc_question drop column category_code;







