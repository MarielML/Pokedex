CREATE DATABASE IF NOT EXISTS Pokedex;
USE Pokedex;

CREATE TABLE pokemon (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero INT NOT NULL UNIQUE,
    nombre VARCHAR(255) NOT NULL,
    tipo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    imagen VARCHAR(255)
);

CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(255) NOT NULL UNIQUE,
    nombre VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE
);

INSERT INTO pokemon (numero, nombre, tipo, descripcion, imagen) VALUES
(1, 'Bulbasaur', 'imagenes/PlantaVeneno.jpg', 'Bulbasaur es un Pokémon de tipo Planta/Veneno. Es conocido por tener una planta en su espalda que crece con él.', 'imagenes/bulbasaur.png'),
(4, 'Charmander', 'imagenes/Fuego.jpg', 'Charmander es un Pokémon de tipo Fuego. Tiene una llama en la punta de su cola que se enciende cuando está feliz.', 'imagenes/charmander.png'),
(7, 'Squirtle', 'imagenes/agua.png', 'Squirtle es un Pokémon de tipo Agua. Es un pequeño Pokémon con forma de tortuga que utiliza su caparazón para protegerse.', 'imagenes/squirtle.png');

