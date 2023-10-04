create database escrito;

use escrito;

create table tareas(
	id int not null primary key auto_increment,
    titulo varchar(40) not null,
    contenido varchar (100) not null,
    estado varchar(20) not null,
    autor varchar (30) not null,
    created_at timestamp,
    updated_at datetime,
    deleted_at datetime
);

drop table tareas;