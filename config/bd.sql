CREATE DATABASE shiftsys;

USE shiftsys;

    CREATE TABLE customer (
        id_customer INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255),
        email VARCHAR(255) UNIQUE,
        pass VARCHAR(144)
    );

    CREATE TABLE admin (
        id_admin INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(255) UNIQUE NOT NULL,
        password VARCHAR(144) NOT NULL,
        rol VARCHAR(50) DEFAULT 'admin',
        activo BOOLEAN DEFAULT TRUE
    );
    
    CREATE TABLE shifts (
    	id_shifts INT AUTO_INCREMENT PRIMARY KEY,
        day DATE NOT NULL,
        hour TIME NOT NULL,
        available BOOLEAN DEFAULT TRUE
    );
    
    CREATE TABLE application (
    	id_application INT AUTO_INCREMENT PRIMARY KEY,
        id_customer INT NOT NULL,
        id_shifts INT NOT NULL,
        id_admin INT NULL,
        estado ENUM('pendiente', 'aprobado', 'rechazado') DEFAULT 'pendiente',
        fecha_solicitud DATETIME DEFAULT CURRENT_TIMESTAMP,

        FOREIGN KEY (id_customer) REFERENCES customer(id_customer),
        FOREIGN KEY (id_shifts) REFERENCES shifts(id_shifts),
        FOREIGN KEY (id_admin) REFERENCES admin(id_admin)
);