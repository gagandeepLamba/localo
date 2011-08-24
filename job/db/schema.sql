     
--
-- DB for job  application
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

drop table if exists job_org;
create table job_org(
	id int(11) NOT NULL auto_increment,
	name varchar(128) not null UNIQUE ,
	domain varchar(64) not null UNIQUE ,
        description TEXT ,
	is_active int not null default 1,
	p_email varchar(128) ,
        p_address varchar(1024) ,
        p_phone varchar(256),
        website varchar(128),
        created_on timestamp default '0000-00-00 00:00:00',
	updated_on timestamp default '0000-00-00 00:00:00' ,
	PRIMARY KEY (id)) ENGINE = MYISAM;
    


drop table if exists job_opening;
create table job_opening(
	id int(11) NOT NULL auto_increment,
	title varchar(128) not null ,
        description TEXT ,
        skill varchar(512),
        organization_name varchar(128),
        created_by varchar(128) not null ,
	status varchar(1) not null default 'A',
	bounty  int(11) ,
        org_id  int(11) not null ,
        location varchar(32) not null,
        application_count int default 0 ,
        expire_on timestamp default '0000-00-00 00:00:00',
        created_on timestamp default '0000-00-00 00:00:00',
	updated_on timestamp default '0000-00-00 00:00:00' ,
	PRIMARY KEY (id)) ENGINE = MYISAM;



drop table if exists job_application;
create table job_application(
	id int(11) NOT NULL auto_increment,
        forwarder_email varchar(128) ,
        cv_name varchar(128) not null ,
	cv_title varchar(256) not null ,
        cv_description TEXT ,
        cv_email varchar(128) not null ,
        cv_phone varchar(16) not null ,
        cv_education varchar(256),
        cv_company varchar(256) ,
        cv_location varchar(32) not null default 'Bangalore',
        cv_skill varchar(512),
	status varchar(8) not null default 'OPEN',
        stage varchar(8) not null default 'REVIEW',
        org_id  int(11) not null ,
        opening_id  int(11) not null ,
        user_id  int(11) not null ,
        created_on timestamp default '0000-00-00 00:00:00',
	updated_on timestamp default '0000-00-00 00:00:00' ,
	PRIMARY KEY (id)) ENGINE = MYISAM;


drop table if exists job_user;
CREATE TABLE job_user (
        id int(11) NOT NULL auto_increment,
	email varchar(128) not null,
	password varchar(64) not null,
	name varchar(128) not null,
        is_active int not null default 1,
	salt varchar(16) not null,
	created_on TIMESTAMP  default '0000-00-00 00:00:00',
	updated_on TIMESTAMP   default '0000-00-00 00:00:00',
	PRIMARY KEY (id)) ENGINE =MYISAM ;

alter table  job_user add constraint UNIQUE uniq_user_email (email);


drop table if exists job_user_profile ;
create table job_user_profile (
    id int(11) NOT NULL auto_increment,
    user_id int not null,
    title varchar(128) ,
    phone varchar(16) not null ,
    description TEXT ,
    linkedin_page varchar(256),
    education varchar(256),
    company varchar(128) ,
    experience_year int ,
    experience_month  int,
    location varchar(32),
    updated_on TIMESTAMP   default '0000-00-00 00:00:00',
    PRIMARY KEY (id)) ENGINE =MYISAM ;




drop table if exists job_admin;
CREATE TABLE job_admin (
        id int(11) NOT NULL auto_increment,
	email varchar(128) not null,
	password varchar(64) not null,
	first_name varchar(64) not null,
	last_name varchar(64) not null,
        phone varchar(16) not null ,
        is_active int not null default 1,
        company varchar(128) ,
        title varchar(128) ,
	org_id int NOT NULL,
	salt varchar(16) not null,
	created_on TIMESTAMP  default '0000-00-00 00:00:00',
	updated_on TIMESTAMP   default '0000-00-00 00:00:00',
	PRIMARY KEY (id)) ENGINE =MYISAM ;

alter table  job_admin add constraint UNIQUE uniq_admin_email (email);


drop table if exists job_document;
CREATE TABLE job_document (
        id int(11) NOT NULL auto_increment,
	mime varchar(64) not null,
	size int not null,
	store_name varchar(128) not null,
	original_name varchar(64) not null,
        entity_id int not null,
        entity_name varchar(16) not null ,
	created_on TIMESTAMP  default '0000-00-00 00:00:00',
	updated_on TIMESTAMP   default '0000-00-00 00:00:00',
	PRIMARY KEY (id)) ENGINE =MYISAM ;




DROP TRIGGER IF EXISTS trg_job_application_count;

delimiter //
CREATE TRIGGER trg_job_application_count AFTER INSERT ON job_application
    FOR EACH ROW
    BEGIN

       update job_opening set application_count = application_count + 1
       where id = NEW.opening_id ;
       

    END;//
delimiter ;
