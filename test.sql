CREATE database librosdb;
USE librosdb;

CREATE TABLE libros (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(255) NOT NULL,
  autor VARCHAR(255) NOT NULL,
  año_publicacion INT,
  genero VARCHAR(255)
);
drop table libros;

-- Insertando 5 libros de ejemplo

INSERT INTO libros (titulo, autor, año_publicacion, genero) VALUES
('El principito', 'Antoine de Saint-Exupéry', 1943, 'Fantasía'),
('Cien años de soledad', 'Gabriel García Márquez', 1967, 'Realismo mágico'),
('1984', 'George Orwell', 1949, 'Distopía'),
('La sombra del viento', 'Carlos Ruiz Zafón', 2001, 'Misterio'),
('Orgullo y prejuicio', 'Jane Austen', 1813, 'Romántico');


CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO usuarios (nombre, email, contrasena) VALUES
('Ana Pérez', 'ana.perez@email.com', 'contrasena123'),
('Carlos López', 'carlos.lopez@example.org', 'miclave456'),
('Sofía Gómez', 'sofia.gomez@mi-correo.net', 'seguro789'),
('Javier Vargas', 'javier.vargas@otrodominio.com', 'claveunica'),
('Valentina Ruiz', 'valentina.ruiz@mail.info', 'passwordfacil');

CREATE TABLE publicaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES usuarios(id)
);