     
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
	title varchar(256) not null UNIQUE,
	summary TEXT not null ,
    description TEXT ,
    s_media_id int ,
    seo_title varchar(256),
    link varchar(256),
    is_link int default 0,
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






    