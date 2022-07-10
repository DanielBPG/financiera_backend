CREATE TABLE amortizaciones (
    id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    id_prestamo bigint(20) unsigned NOT NULL,
    numero_pago int NOT NULL,
    fecha date NOT NULL,
    interes float NOT NULL,
    abono float NOT NULL,
  	PRIMARY KEY (id),
  	UNIQUE KEY id (id),
    FOREIGN KEY (id_prestamo) REFERENCES prestamos(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);