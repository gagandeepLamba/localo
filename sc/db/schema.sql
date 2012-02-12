

drop table if exists sc_note;
create table sc_note(
	id int(11) NOT NULL auto_increment,
	title varchar(128) not null,
	n_type varchar(4),
	p_level varchar(4),
	user_id varchar(16),
	summary varchar(256) ,
    description TEXT ,
    tags varchar(64),
    links_json TEXT ,
    images_json TEXT,
    location varchar(32),
    category varchar(32),
	brand varchar(32),
	send_deal int default 0,
    seo_title varchar(192) not null,
	timeline varchar(32),
    created_on timestamp default '0000-00-00 00:00:00',
	updated_on timestamp default '0000-00-00 00:00:00' ,
	PRIMARY KEY (id)) ENGINE = MYISAM;
    
    
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
	PRIMARY KEY (id)) ENGINE = MYISAM;
    


  
drop table if exists sc_user;
create table sc_user(
	id int(11) NOT NULL auto_increment,
	name varchar(64) not null,
    email varchar(64) not null,
    location varchar(32) not null,
	password varchar(32) not null,
	interests varchar(256),
    created_on timestamp default '0000-00-00 00:00:00',
	updated_on timestamp default '0000-00-00 00:00:00' ,
	PRIMARY KEY (id)) ENGINE = MYISAM;
    
	


drop table if exists sc_list;
create table sc_list(
	id int(11) NOT NULL auto_increment,
	name varchar(16) not null,
    code varchar(8) not null,
    display varchar(32) not null,
	ui_order int not null ,
	PRIMARY KEY (id)) ENGINE = MYISAM;
    
	
	
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




