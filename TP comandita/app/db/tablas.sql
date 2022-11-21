create table pedidos(
    id_pedido int not null PRIMARY KEY AUTO_INCREMENT,
	descripcion varchar(150),
    estado varchar(100),
    tiempo_finalizacion int,
    precio int not null,
    id_mesa int not null
);

create table mozos(
    id_mozo int not null PRIMARY KEY AUTO_INCREMENT,
    id_pedido int not null,
    id_mesa int not null,
    nombre varchar(50)
);
    
create table productos(
	id_producto int not null primary KEY AUTO_INCREMENT,
    area varchar(50),
    descripcion varchar(100) not null,
    estado varchar(100) not null,
    id_pedido int not null
);

create table bartenders(

    id_bartender int not null PRIMARY KEY AUTO_INCREMENT,
    id_pedido int not null,
    estado varchar(100) not null,
    descripcion varchar(100) not null,
    estado_bartender varchar(100) not null,
    tiempo int 
);

create table cocineros(

    id_cocinero int not null PRIMARY KEY AUTO_INCREMENT,
    id_pedido int not null,
    estado varchar(100) not null,
    descripcion varchar(100) not null,
    estado_cocinero varchar(100) not null,
    tiempo int not null
);

create table cerveceros(

    id_cervecero int not null PRIMARY KEY AUTO_INCREMENT,
    id_pedido int not null,
    estado varchar(100) not null,
    descripcion varchar(100) not null,
    estado_cervecero varchar(100) not null,
    tiempo int not null
);

create table sesiones(
    area varchar(15) not null,
    clave varchar(10) not null
    );
    
    insert into sesiones(area, clave)
    values ("admin", 1234);
    insert into sesiones(area, clave)
    values ("bartender", 1234);
    insert into sesiones(area, clave)
    values ("mozo", 1234);
   	insert into sesiones(area, clave)
    values ("cervecero", 1234);
    insert into sesiones(area, clave)
    values ("cocinero", 1234);