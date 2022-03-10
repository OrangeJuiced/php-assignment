create database assignment;

use assignment;

create table bicycles
(
    id          bigint unsigned auto_increment
        primary key,
    model       varchar(255)   not null,
    description longtext       null,
    price       decimal(10, 2) not null
);

create table suppliers
(
    id   bigint unsigned auto_increment
        primary key,
    name varchar(255) not null
);

create table bicycle_supplier
(
    id          bigint unsigned auto_increment
        primary key,
    bicycle_id  bigint unsigned not null,
    supplier_id bigint unsigned not null,
    constraint bicycle_supplier_bicycles_id_fk
        foreign key (bicycle_id) references bicycles (id),
    constraint bicycle_supplier_suppliers_id_fk
        foreign key (supplier_id) references suppliers (id)
);