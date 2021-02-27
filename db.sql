DROP DATABASE IF EXISTS proyecto1;
CREATE DATABASE IF NOT EXISTS proyecto1;
USE proyecto1;


DROP TABLE IF EXISTS usuario;
CREATE TABLE IF NOT EXISTS usuario (
id              int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
nombres         varchar(150) DEFAULT NULL,
apellidos       varchar(150) DEFAULT NULL,
edad            int(11) DEFAULT NULL,
correo          varchar(150) DEFAULT NULL,
telefono        varchar(20) DEFAULT NULL,
fecha_registro  timestamp NULL DEFAULT NULL,
PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

