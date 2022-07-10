CREATE TABLE clientes (
    id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    nombre varchar(50) NOT NULL DEFAULT '',
    telefono varchar(10) NOT NULL DEFAULT '',
    edad smallint(3) NOT NULL DEFAULT 0,
  	PRIMARY KEY (id),
  	UNIQUE KEY id (id)
);