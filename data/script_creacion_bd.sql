DROP DATABASE IF EXISTS tienda;
CREATE DATABASE tienda;
USE tienda;
CREATE TABLE usuarios (
   id INT AUTO_INCREMENT PRIMARY KEY,
   usuario VARCHAR(30) UNIQUE NOT NULL,
   password VARCHAR(100) NOT NULL,
   rol ENUM('admin','usuario','invitado') DEFAULT 'usuario',
   ultimo_acceso TIMESTAMP DEFAULT (CURRENT_TIMESTAMP)
);
CREATE TABLE productos (
   id_producto INT AUTO_INCREMENT PRIMARY KEY,
   nombre VARCHAR(30) NOT NULL,
   descripcion VARCHAR(100),
   precio float NOT NULL,
   magico BOOLEAN,
   fechaAnadido DATE DEFAULT(CURRENT_DATE),
   img BLOB NOT NULL,
   categoria /* Meter categoria */
);
CREATE TABLE categorias (
   id_categoria INT AUTO_INCREMENT PRIMARY KEY,
   nombre VARCHAR(10) NOT NULL,
   descripcion VARCHAR(100),
)


CREATE USER IF NOT EXISTS gamemaster@'localhost' IDENTIFIED BY '1234';
GRANT SELECT, INSERT, UPDATE, DELETE on tienda.* TO gamemaster@'localhost';