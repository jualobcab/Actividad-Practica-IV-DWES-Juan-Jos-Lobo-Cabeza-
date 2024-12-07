DROP DATABASE IF EXISTS tienda;
CREATE DATABASE tienda;
USE tienda;
CREATE TABLE Usuarios (
   id INT AUTO_INCREMENT PRIMARY KEY,
   usuario VARCHAR(30) UNIQUE NOT NULL,
   contrasenya VARCHAR(100) NOT NULL,
   rol ENUM('admin','usuario','invitado') DEFAULT 'usuario',
   ultimo_acceso TIMESTAMP DEFAULT (CURRENT_TIMESTAMP)
);

CREATE TABLE Categorias (
   id_categoria INT AUTO_INCREMENT PRIMARY KEY,
   nombre VARCHAR(10) UNIQUE NOT NULL,
   descripcion VARCHAR(100)
);

CREATE TABLE Productos (
   id_producto INT AUTO_INCREMENT PRIMARY KEY,
   nombre VARCHAR(30) NOT NULL,
   descripcion VARCHAR(100),
   precio float NOT NULL,
   magico BOOLEAN,
   fechaAnadido DATE DEFAULT(CURRENT_DATE),
   id_categoria INT NOT NULL,
   FOREIGN KEY (id_categoria) REFERENCES Categorias(id_categoria)
);

CREATE USER IF NOT EXISTS gamemaster@'localhost' IDENTIFIED BY '1111';
GRANT SELECT, INSERT, UPDATE, DELETE on tienda.* TO gamemaster@'localhost';

INSERT INTO Usuarios(usuario,contrasenya,rol) VALUES ('gamemaster',md5('1111'),'admin');
INSERT INTO Usuarios(usuario,contrasenya,rol) VALUES ('jugador1',md5('1234'),'usuario');

-- Inserts categorias
INSERT INTO Categorias(nombre,descripcion) VALUES ('Arma','Herramienta diseñada para atacar o defender en combate');
INSERT INTO Categorias(nombre,descripcion) VALUES ('Armadura','Protección que reduce el daño en combate');
INSERT INTO Categorias(nombre,descripcion) VALUES ('Equipo','Equipo variado como pergaminos, pociones ...');

-- Inserts productos
INSERT INTO Productos(nombre,descripcion,precio,magico,id_categoria) VALUES ("Alabarda",null,12.4,false,1);
INSERT INTO Productos(nombre,descripcion,precio,magico,id_categoria) VALUES ("Espada Vorpalina",null,925.9,true,1);
INSERT INTO Productos(nombre,descripcion,precio,magico,id_categoria) VALUES ("Poción",null,5,true,3);
INSERT INTO Productos(nombre,descripcion,precio,magico,id_categoria) VALUES ("Pergamino: Bola de Fuego",null,50,true,3);
INSERT INTO Productos(nombre,descripcion,precio,magico,id_categoria) VALUES ("Armadura de placas",null,149.99,false,2);
INSERT INTO Productos(nombre,descripcion,precio,magico,id_categoria) VALUES ("Escudo",null,25,false,2); 