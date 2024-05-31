-- Prueba inicia
select * from prueba;

drop table if exists prueba;

create table prueba(
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    nombre varchar(80) not null unique,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

insert into prueba(nombre) values('Ana');
insert into prueba(nombre) values('Carlos');
insert into prueba(nombre) values('Tita');
insert into prueba(nombre) values('Pepe');

select * from prueba;
SELECT datetime('now');

-- Prueba termina

-- Tablas del examen
drop table if exists tipo_pago;
create table tipo_pago(
    id_tipo_pago INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    nombre_tipo varchar(80) not null unique,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modified_at TIMESTAMP null
);

drop table if exists gasto;
create table gasto(
    id_gasto INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    id_tipo_pago INTEGER NOT NULL,
    
    monto double not null,
    descripcion varchar(255) not null,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modified_at TIMESTAMP null,
    
    FOREIGN KEY(id_tipo_pago) REFERENCES tipo_pago(id_tipo_pago)
);

