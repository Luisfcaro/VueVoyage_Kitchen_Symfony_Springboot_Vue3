DROP DATABASE IF EXISTS VueVoyage;

CREATE DATABASE IF NOT EXISTS VueVoyage;

USE VueVoyage;

CREATE TABLE
    restaurant (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name_rest VARCHAR(255),
        img_rest VARCHAR(255),
        location_rest VARCHAR(255)
    );

CREATE TABLE
    categories (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name_cat VARCHAR(255),
        img_cat VARCHAR(255)
    );

CREATE TABLE
    restaurant_category (
        restaurant_id INT,
        category_id INT,
        desc_rest_cat TEXT,
        FOREIGN KEY (restaurant_id) REFERENCES restaurant(id),
        FOREIGN KEY (category_id) REFERENCES categories(id)
    );

CREATE TABLE
    tables (
        id_table INT PRIMARY KEY AUTO_INCREMENT,
        num_table INT,
        id_rest INT,
        capacity_table INT,
        status_table VARCHAR(50),
        FOREIGN KEY (id_rest) REFERENCES restaurant(id)
    );

-- Insertar datos en la tabla restaurant

INSERT INTO
    restaurant (
        id,
        name_rest,
        img_rest,
        location_rest
    )
VALUES (
        1,
        'La Trattoria',
        'latrattoria.jpg',
        '123 Calle Principal, Ciudad'
    ), (
        2,
        'El Asador Argentino',
        'elasador.jpg',
        '456 Avenida Central, Ciudad'
    ), (
        3,
        'Sushi Express',
        'sushiexpress.jpg',
        '789 Calle Secundaria, Ciudad'
    );

-- Insertar datos en la tabla categories

INSERT INTO
    categories (id, name_cat, img_cat)
VALUES (1, 'Italiana', 'italiana.jpg'), (
        2,
        'Argentina',
        'argentina.jpg'
    ), (3, 'Japonesa', 'japonesa.jpg');

-- Insertar datos en la tabla rest_cat

INSERT INTO
    restaurant_category (restaurant_id, category_id, desc_rest_cat)
VALUES (
        1,
        1,
        'Auténtica cocina italiana en un ambiente acogedor'
    ), (
        2,
        2,
        'Carnes asadas a la parrilla en el estilo argentino'
    ), (
        3,
        3,
        'Variedad de sushi fresco y delicioso'
    );

-- Insertar datos en la tabla Tables

INSERT INTO
    tables (
        num_table,
        id_rest,
        capacity_table,
        status_table
    )
VALUES (1, 1, 4, 'Disponible'), (2, 1, 6, 'Ocupada'), (3, 2, 8, 'Disponible'), (4, 3, 5, 'Ocupada');