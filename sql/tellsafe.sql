create database tellsafe;

use tellsafe;

create table company
(
   id        int not null primary key auto_increment,
   name      varchar(100) not null,
   address   varchar(100),
   suite     varchar(10),
   city      varchar(35),
   state     varchar(2),
   zip       varchar(10),
   country   varchar(20),
   phone     varchar(30),
   website   varchar(150),
   employees int,
   active    char(1) not null,
   expires   date,
   created   date,
   billing_fname   varchar(50),
   billing_lname   varchar(50),
   billing_phone   varchar(30),
   billing_email   varchar(255),
   billing_address varchar(100),
   billing_suite   varchar(10),
   billing_city    varchar(35),
   billing_state   varchar(2),
   billing_zip     varchar(10),
   billing_country varchar(20)
);

create table contact
(
   id        int not null primary key auto_increment,
   company   int not null,
   active    char(1) not null,
   name      varchar(50) not null,
   title     varchar(100),
   username  varchar(16) not null,
   password  varchar(16) not null,
   address   varchar(100),
   suite     varchar(10),
   city      varchar(35),
   state     varchar(2),
   zip       varchar(10),
   country   varchar(20),
   phone1    varchar(30) not null,
   phone2    varchar(30),
   email     varchar(255) not null,
   question  varchar(255),
   answer    varchar(255)
);

create table complaint
(
   id        int not null primary key auto_increment,
   company   int not null,
   confirmed char(1) not null,
   created   datetime not null,
   message   text
);

create table notification
(
   id        int not null primary key auto_increment,
   complaint int not null,
   contact   int not null,
   type      tinyint not null,
   created   datetime not null
);

create table feedback
(
   id        int not null primary key auto_increment,
   created   datetime not null,
   confirmed char(1) not null,
   name      varchar(100),
   company   varchar(100),
   phone     varchar(20),
   email     varchar(255),
   ipaddress varchar(16),   
   message   text
);

grant all on company to bobbohn@localhost identified by 'qwerty';

grant all on contact to bobbohn@localhost;

grant all on complaint to bobbohn@localhost;

grant all on notification to bobbohn@localhost;

grant all on feedback to bobbohn@localhost;
