drop database valutazionelpi;
create database valutazionelpi;
use valutazionelpi;
create table role(
	id int primary key auto_increment,
    name varchar(100) not null
);
create table user(
	id int primary key auto_increment,
    name varchar(100) not null,
    surname varchar(100) not null,
    email varchar(100) not null unique,
    phone varchar(50) not null unique,
    password varchar(255) not null,
    confirmed tinyint(1) not null,
    id_role int not null,
    foreign key(id_role) references role(id)
);
create table token(
	id_user int primary key,
    token varchar(255) not null,
    foreign key(id_user) references user(id)
);
create table point(
	code varchar(10) primary key,
    title varchar(100) not null,
    description varchar(255),
    type tinyint(1) not null
);
create table justification(
	id int primary key auto_increment,
    text varchar(255) not null,
    id_point varchar(10) not null,
    foreign key(id_point) references point(code)
);
create table form(
	id int primary key auto_increment,
    title varchar(255) not null,
    created timestamp not null,
    modified timestamp,
    deleted timestamp,
    student_name varchar(100) not null,
    student_surname varchar(100) not null,
    student_email varchar(100) not null,
    student_phone varchar(50) not null,
    teacher_name varchar(100) not null,
    teacher_surname varchar(100) not null,
    teacher_email varchar(100) not null,
    teacher_phone varchar(50) not null,
    expert1_name varchar(100),
    expert1_surname varchar(100),
    expert1_email varchar(100),
    expert1_phone varchar(50),
    expert2_name varchar(100),
    expert2_surname varchar(100),
    expert2_email varchar(100),
    expert2_phone varchar(50),
    id_user int not null,
    foreign key(id_user) references user(id)
);
create table contains(
	id_justification int,
    id_form int,
    primary key(id_justification, id_form),
    foreign key(id_justification) references justification(id),
    foreign key(id_form) references form(id)
);
















