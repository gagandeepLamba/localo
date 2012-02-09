        
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
       links_json TEXT,
       images_json TEXT,
       seo_title varchar(144),
       user_name varchar(32),
       user_id varchar(32),
       created_on timestamp default '0000-00-00 00:00:00',
       updated_on timestamp default '0000-00-00 00:00:00' ,
       PRIMARY KEY (id)) ENGINE = MYISAM;
       
   alter table  news_post add constraint UNIQUE uniq_skey (short_id);
   
   
   drop table if exists news_link;
   create table news_link(
       id int(11) NOT NULL auto_increment,
       description TEXT,
       link TEXT not null,
       author varchar(64),
       state varchar(1) default 'N',
       created_on timestamp default '0000-00-00 00:00:00',
       updated_on timestamp default '0000-00-00 00:00:00' ,
       PRIMARY KEY (id)) ENGINE = MYISAM;
       
       
       
       
   drop table if exists news_media;
   create table news_media(
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
    
   alter table  news_login add constraint UNIQUE uniq_email (email);
   
   
   
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
   
   
   --
   -- 29 jan 2012
  
   alter table news_post add column links_json text ;
   alter table news_post add column images_json text;
   
   --
   -- now run images_json script to populate links_json and images_json
   -- before deleting this reference
   --
   
   alter table news_media drop column post_id ;
   --
   -- @todo 
   -- update featured image before dropping s_media_id reference
   --
   
  
   alter table news_post drop column s_media_id ;
   DROP TRIGGER IF EXISTS trg_media_insert;
   DROP TRIGGER IF EXISTS trg_media_delete;
   alter table news_post drop column markdown;
   
   --
   -- 4Feb 2012
   --
   
   alter table news_post drop column owner_name ;
   alter table news_post add  column user_name varchar(32);
   alter table news_post add  column user_id varchar(32);
   update news_login set user_name = 'Jatayu Krishna' ;
   
   --
   -- update old posts with some user_name
   --
   
   
  drop table if exists gloo_news;
   create table gloo_news(
       id int(11) NOT NULL auto_increment,
       email varchar(64),
       name varchar(64),
       flag int default 0,
       created_on timestamp default '0000-00-00 00:00:00',
       updated_on timestamp default '0000-00-00 00:00:00' ,
       PRIMARY KEY (id)) ENGINE = MYISAM;
       
   alter table  gloo_news add constraint UNIQUE uniq_skey (email);
   
   --
   -- 8 Feb 2012
   --
   -- recreate news_link table
   -- 
   
   alter table news_link add column state varchar(1) default 'N' ;
   

