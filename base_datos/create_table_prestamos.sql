CREATE TABLE prestamos (
    id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    id_cliente bigint(20) unsigned NOT NULL,
    monto int NOT NULL,
    plazo int NOT NULL,
  	PRIMARY KEY (id),
  	UNIQUE KEY id (id),
    FOREIGN KEY (id_cliente) REFERENCES clientes(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);