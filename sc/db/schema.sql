

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
	PRIMARY KEY (id)) ENGINE = MYISAM;
    

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
       PRIMARY KEY (id)) ENGINE =MYISAM ;
    
   alter table  sc_user add constraint UNIQUE uniq_email (email);
   
   
   


drop table if exists sc_list;
create table sc_list(
	id int(11) NOT NULL auto_increment,
	name varchar(16) not null,
    code varchar(8) not null,
    display varchar(32) not null,
	ui_order int not null ,
	PRIMARY KEY (id)) ENGINE = MYISAM;
    

--	
-- drop old tables
--
drop table sc_note;

	
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


--
-- patch: 14 feb 2012
--

alter table sc_answer add column title varchar(128);



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

update sc_answer answer set answer.title = (select title from sc_question where id = answer.question_id) ;




