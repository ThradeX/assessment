create database if not exists riverside;
use riverside;

create table if not exists users (
  id_user int not null auto_increment,
  first_name varchar(20) not null,
  last_name varchar(20) not null,
  username varchar(20) not null unique,
  password varchar(100) not null,
  address varchar(255) not null,
  phone_number varchar(10) not null,
  primary key (id_user));
  
  insert into users(first_name, last_name, username, password, address, phone_number)
  values("a", "a", "a", "a", "a", "a");
  
select * from users;

-- delete from users where id_user < 10;

-- drop table users;

create table if not exists shows (
	id_show int not null auto_increment,
    name_show varchar(50) not null,
    name_artist varchar(50) not null,
    image_show varchar(255) not null,
    description_show varchar(500) not null,
    price float not null,
    max_tickets int not null,
    bought int not null default 0,
    primary key (id_show)
);

insert into shows (name_show, name_artist, image_show, description_show, price, max_tickets) 
values ("testeShow", "testeArtista", "https://www.cnnbrasil.com.br/wp-content/uploads/sites/12/2022/06/GettyImages-1097661412.jpg?w=1220&h=674&crop=1", "teste descricao", 100, 150);

insert into shows (name_show, name_artist, image_show, description_show, price, max_tickets) 
values ("testeShow2", "testeArtista2", "https://cdn.vox-cdn.com/thumbor/8fHlyH3tqfMxAHz0hXowSXaZuis=/2x0:996x746/1200x800/filters:focal(2x0:996x746)/cdn.vox-cdn.com/uploads/chorus_image/image/48729983/shutterstock_93888712.0.0.jpg", "teste descricao2", 120, 200);

insert into shows (name_show, name_artist, image_show, description_show, price, max_tickets) 
values ("testeShow3", "testeArtista3", "https://www.apple.com/newsroom/images/product/music/standard/Apple-Music-Classical-hero_big.jpg.slideshow-xlarge_2x.jpg", "teste descricao3", 80, 100);

insert into shows (name_show, name_artist, image_show, description_show, price, max_tickets) 
values ("testeShow4", "testeArtista4", "https://miro.medium.com/v2/resize:fit:1220/1*hv7_fGqSXFOUi2LRcAe84A.jpeg", "teste descricao4", 180, 200);

insert into shows (name_show, name_artist, image_show, description_show, price, max_tickets) 
values ("testeShow5", "testeArtista5", "https://rmc.dk/sites/default/files/styles/background_full_wide/public/node/field_image/rmc_uddannelse_music_management_0.jpg?h=d88fbc39&itok=qdS2rNsO", "teste descricao5", 280, 150);

insert into shows (name_show, name_artist, image_show, description_show, price, max_tickets) 
values ("testeShow6", "testeArtista6", "https://cdn.vox-cdn.com/thumbor/8fHlyH3tqfMxAHz0hXowSXaZuis=/2x0:996x746/1200x800/filters:focal(2x0:996x746)/cdn.vox-cdn.com/uploads/chorus_image/image/48729983/shutterstock_93888712.0.0.jpg", "teste descricao6", 22, 300);

select * from shows;

-- delete from shows where id_show < 10;

-- drop table shows;