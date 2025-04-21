-- sql file needed
create DATABASE backend;


use backend;


-- Eliminar tabla si exite previamente
DROP TABLE IF EXISTS users;


CREATE TABLE users(
    id int unsigned auto_increment primary key,
    name varchar(50) not null,
    age int unsigned,
    email varchar(50) not null,
    password varchar(50) not null,
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp
);
create table products(
    id int unsigned primary key auto_increment,
    name varchar(50),
    description varchar(255),
    created_at timestamp default current_timestamp
);
