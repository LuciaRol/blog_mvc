DROP DATABASE IF EXISTS blog;
CREATE DATABASE blog;
USE blog;

SET NAMES utf8mb4;
-- Creamos las tablas

DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios (
    id INT(255) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100),
    email VARCHAR(255) NOT NULL UNIQUE, -- el identificador de que usuario sea único será el mail
    password VARCHAR(255)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS entradas;
CREATE TABLE entradas (
    id INT(255) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT(255) NOT NULL,
    categoria_id INT(255),
    titulo VARCHAR(255),
    descripcion MEDIUMTEXT,
    fecha DATE
)ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS categorias;
CREATE TABLE categorias (
    id INT(255) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100)
)ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


ALTER TABLE entradas
ADD CONSTRAINT fk_categoria
FOREIGN KEY (categoria_id) REFERENCES categorias(id)
ON DELETE CASCADE;


ALTER TABLE entradas
ADD CONSTRAINT fk_usuario
FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
ON DELETE CASCADE;;