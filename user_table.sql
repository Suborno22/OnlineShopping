create database if not exists OnlineShopping;
use OnlineShopping;
CREATE TABLE if not exists `user_table` (
    id int auto_increment PRIMARY KEY,
    first_name varchar(255) NOT NULL,
    last_name varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    password varchar(255),
    profile_image varchar(255)
);
