drop table emp;
drop table dept;

drop table userssession cascade constraints;
drop table users cascade constraints;

create table users (
  userid varchar2(8) primary key,
  password varchar2(14),
  admin_flag varchar2(3)
);

create table userssession (
  sessionid varchar2(32) primary key,
  userid varchar2(8),
  sessiondate date,
  foreign key (userid) references users
);
 

create table dept (
  dnumber number(5) primary key,
  dname varchar2(50) not null unique,
  location varchar2(100)
);


create table emp (
  eid number(10) primary key,
  fname varchar2(30) not null, 
  lname varchar2(30) not null, 
  start_date date,
  dnumber number(5) not null references dept 
);
insert into users values ('admin', 'admin','yes');
insert into users values ('ryadav1', 'rohan','yes');
insert into users values ('dtrent2', 'david','yes');
insert into users values ('cduff2', 'chris','yes');
insert into users values ('chad3','chad','yes');
insert into users values ('student','student','no');

commit;

