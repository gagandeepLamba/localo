     
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
    short_id varchar(8) not null,
	title varchar(128) not null,
	summary TEXT not null ,
    description TEXT ,
    markdown TEXT,
    s_media_id int ,
    seo_title varchar(144),
    owner_name varchar(64),
    created_on timestamp default '0000-00-00 00:00:00',
	updated_on timestamp default '0000-00-00 00:00:00' ,
	PRIMARY KEY (id)) ENGINE = MYISAM;
    
alter table  news_post add constraint UNIQUE uniq_skey (short_id);


drop table if exists news_link;
create table news_link(
	id int(11) NOT NULL auto_increment,
	title varchar(256) not null UNIQUE,
	summary TEXT not null ,
    link varchar(256),
    owner_name varchar(64),
    created_on timestamp default '0000-00-00 00:00:00',
	updated_on timestamp default '0000-00-00 00:00:00' ,
	PRIMARY KEY (id)) ENGINE = MYISAM;
    
    
    
    
drop table if exists news_media;
create table news_media(
	id int(11) NOT NULL auto_increment,
    post_id int not null,
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
    

--
-- password column should be > 40 chars
-- SHA1 digest is a 40-character hexadecimal number
-- 
drop table if exists news_login;
CREATE TABLE news_login (
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

alter table  news_login add constraint UNIQUE uniq_login (user_name);
alter table  news_login add constraint UNIQUE uniq_email (email);



DROP TRIGGER IF EXISTS trg_media_delete;

delimiter //
CREATE TRIGGER trg_media_delete AFTER DELETE ON news_media
    FOR EACH ROW
    BEGIN
        DECLARE ps_media_id int ;
        DECLARE ps_new_media_id int ;
        
        SELECT s_media_id into ps_media_id from news_post where id = OLD.post_id;
        --
        -- deleted media was cover of post
        -- 
        IF(ps_media_id IS NOT NULL AND (ps_media_id = OLD.id)) THEN
                --
                -- update post with another - if post has more media
                -- 
                SELECT max(id) into ps_new_media_id from news_media where post_id = OLD.post_id;
                IF (ps_new_media_id IS NOT NULL ) THEN
                    update news_post set s_media_id = ps_new_media_id where id = OLD.post_id ;
                END IF;
        
        END IF;

    END;//
delimiter ;




DROP TRIGGER IF EXISTS trg_media_insert;

delimiter //
CREATE TRIGGER trg_media_insert AFTER INSERT ON news_media
    FOR EACH ROW
    BEGIN
        DECLARE ps_media_id int ;
        
        SELECT s_media_id into ps_media_id from news_post where id = NEW.post_id;
        --
        -- post has no cover
        -- 
        IF(ps_media_id IS NULL) THEN
                --
                -- make this media post cover
                update news_post set s_media_id = NEW.id , updated_on = now() where id = NEW.post_id;  
                
        END IF;

    END;//
delimiter ;



--
-- patch
-- 05 Dec 2011
-- 
--
alter table news_post add column markdown TEXT ;

--
-- 9 Dec 2011
--

alter table news_post drop column is_link ;
alter table news_post drop column link;
alter table news_login modify column user_name varchar(64);
alter table news_login modify column email varchar(64);
alter table news_post add column owner_name varchar(64) ;

drop table if exists news_link;
create table news_link(
	id int(11) NOT NULL auto_increment,
	title varchar(256) not null UNIQUE,
	summary TEXT not null ,
    link varchar(256),
    owner_name varchar(64),
    created_on timestamp default '0000-00-00 00:00:00',
	updated_on timestamp default '0000-00-00 00:00:00' ,
	PRIMARY KEY (id)) ENGINE = MYISAM;
    
    
--
-- 13 dec 2011
--

alter table news_post modify column title varchar(128);
alter table news_post drop index title;

alter table news_post modify column seo_title varchar(144);
alter table news_post add column short_id varchar(8) not null ;

--
-- run the db/scripts/post-shortid.php script now
--
-- Add UNIQUE constraint

alter table  news_post add constraint UNIQUE uniq_skey (short_id);


    
