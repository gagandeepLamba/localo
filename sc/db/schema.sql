

drop table if exists sc_question;
create table sc_question(
	id int(11) NOT NULL auto_increment,
	title varchar(128) not null,
	summary varchar(256) ,
    description TEXT ,
    tags varchar(64),
    links_json TEXT ,
    images_json TEXT,
    location_id int,
    category_id int ,
    location varchar(32),
    category varchar(32),
    seo_title varchar(192) not null,
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
    
