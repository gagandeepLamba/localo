

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
    
	

drop table if exists sc_question;

