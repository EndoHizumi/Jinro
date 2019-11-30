create database jinro;
use jinro;
create table members
(
    id int,
    name varchar(255),
    ready int,
    expel int,
    guard int,
    event varchar(255),
    job varchar(255),
    vote int,
    roomid varchar(255)
);
create table actors
(
    peoples int,
    Villager int,
    wolf int,
    fortune int,
    hunter int,
    cracker int,
    mystic int
);
create table room
(
    id int NOT NULL AUTO_INCREMENT,
    name varchar(255),
    pass varchar(255),
    isstart int,
    day int,
    timezone int,
    owner varchar(255),
    primary key(id)
);

create table activity_logs
(
    ID int NOT NULL AUTO_INCREMENT,
    Name varchar(255),
    Event varchar(255),
    Message varchar(255),
    time datetime,
    roomid int,
    primary key(id)
);

INSERT INTO members VALUES (0,"room",0,0,0,'',"koke",0,"hoge");
    
CREATE TRIGGER updateMember AFTER UPDATE ON members FOR EACH ROW insert into activity_logs(name,event,time) value(new.name,new.event,Now());

CREATE TRIGGER insertMember AFTER INSERT ON members FOR EACH ROW insert into activity_logs(name,event,time) value(new.name,new.event,Now());

CREATE TRIGGER deleteMember BEFORE DELETE ON members FOR EACH ROW insert into activity_logs (name,event,time) value(old.name,old.event,Now());