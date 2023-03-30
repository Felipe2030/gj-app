CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    abc VARCHAR(255) NOT NULL
);

CREATE TABLE ordens (
    id INT PRIMARY KEY AUTO_INCREMENT,
    numero VARCHAR(255)  NOT NULL,
    id_categorias INT NOT NULL,
    id_usuario INT NOT NULL,
    id_fornecedor INT NOT NULL
);

CREATE TABLE fornecedor (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255)  NOT NULL,
    ganho_entrega VARCHAR(255)  NOT NULL,
    id_usuario INT NOT NULL
);

CREATE TABLE categorias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255)  NOT NULL,
    id_usuario INT NOT NULL
);


CREATE TABLE statusxordens (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_ordens VARCHAR(255)  NOT NULL,
    status VARCHAR(255)  NOT NULL,
    data TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);