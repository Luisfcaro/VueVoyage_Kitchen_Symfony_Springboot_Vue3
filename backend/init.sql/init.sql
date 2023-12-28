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

CREATE TABLE
    users (
        id INT PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(30),
        password VARCHAR(64),
        email VARCHAR(128) UNIQUE,
        type_user VARCHAR(64),
        is_active BOOL DEFAULT TRUE,
        photo VARCHAR(255),
        RT VARCHAR(20)
    );

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
    ), (
        4,
        'Pasta Paradise',
        'pastaparadise.jpg',
        '1010 Avenida de las Flores, Ciudad'
    ), (
        5,
        'Burger Town',
        'burgertown.jpg',
        '1111 Plaza del Sol, Ciudad'
    ), (
        6,
        'Tacos del Norte',
        'tacosdelnorte.jpg',
        '1212 Calle del Bosque, Ciudad'
    ), (
        7,
        'The Curry House',
        'curryhouse.jpg',
        '1313 Calle de la Luna, Ciudad'
    ), (
        8,
        'Veggie Delights',
        'veggiedelights.jpg',
        '1414 Avenida del Mar, Ciudad'
    ), (
        9,
        'French Gourmet',
        'frenchgourmet.jpg',
        '1515 Boulevard Paris, Ciudad'
    ), (
        10,
        'Pizza World',
        'pizzaworld.jpg',
        '1616 Calle Nueva, Ciudad'
    );

-- Insertar datos en la tabla categories

INSERT INTO
    categories (id, name_cat, img_cat)
VALUES (1, 'Italiana', 'italiana.jpg'), (
        2,
        'Argentina',
        'argentina.jpg'
    ), (3, 'Japonesa', 'japonesa.jpg'), (
        4,
        'Americana',
        'americana.jpg'
    ), (5, 'Mexicana', 'mexicana.jpg'), (6, 'India', 'india.jpg'), (
        7,
        'Vegetariana',
        'vegetariana.jpg'
    ), (8, 'Francesa', 'francesa.jpg'), (9, 'China', 'china.jpg'), (
        10,
        'Mediterránea',
        'mediterranea.jpg'
    );

-- Insertar datos en la tabla rest_cat

INSERT INTO
    restaurant_category (
        restaurant_id,
        category_id,
        desc_rest_cat
    )
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
    ), (
        4,
        1,
        'Experiencia italiana con un toque moderno'
    ), (
        5,
        4,
        'Hamburguesas clásicas y creativas'
    ), (
        6,
        5,
        'Los mejores tacos al estilo del norte'
    ), (
        7,
        6,
        'Sabores auténticos de la India'
    ), (
        8,
        7,
        'Deliciosas opciones vegetarianas'
    ), (
        9,
        8,
        'Cocina francesa refinada y elegante'
    ), (
        10,
        9,
        'Pizzas al estilo tradicional y contemporáneo'
    );

-- Insertar datos en la tabla Tables

INSERT INTO
    tables (
        num_table,
        id_rest,
        capacity_table,
        status_table
    )
VALUES (1, 1, 4, 'Disponible'), (2, 1, 6, 'Ocupada'), (3, 2, 8, 'Disponible'), (4, 3, 5, 'Ocupada'),     (5, 4, 4, 'Disponible'),
    (6, 4, 2, 'Ocupada'),
    (7, 5, 4, 'Disponible'),
    (8, 5, 6, 'Ocupada'),
    (9, 6, 4, 'Disponible'),
    (10, 6, 8, 'Ocupada'),
    (11, 7, 6, 'Disponible'),
    (12, 7, 2, 'Ocupada'),
    (13, 8, 4, 'Disponible'),
    (14, 8, 6, 'Ocupada'),
    (15, 9, 8, 'Disponible'),
    (16, 9, 5, 'Ocupada'),
    (17, 10, 4, 'Disponible'),
    (18, 10, 6, 'Ocupada');


-- Insertar un usuario administrador
INSERT INTO users (username, password, email, type_user, is_active, photo, RT)
VALUES
    ('admin', '$2a$10$OjVs/YFP1dEnd.XJDA6OQu9Z5VwLTn5BkDflls/ntlZ0hqFq3fXGa', 'admin@gmail.com', 'admin', TRUE, 'admin.jpg', 'patata'),
    ('kevin', 'kevinaris', 'kevin@gmail.com', 'admin', TRUE, 'kevin.jpg', 'tapa'),
    ('luis', '2a$10$OjVs/YFP1dEnd.XJDA6OQu9Z5VwLTn5BkDflls/ntlZ0hqFq3fXGa', 'luis@gmail.com', 'client', TRUE, 'luis.jpg', 'lapa');

-- -- Insertar usuarios normales
-- INSERT INTO users (username, password, email, type_user, is_active, photo)
-- VALUES
--     ('johndoe', 'jonhdoe', 'johndoe@gmail.com', 'client', TRUE, 'johndoe.jpg'),
--     ('janedoe', 'janedoe', 'janedoe@gmail.com', 'client', TRUE, 'janedoe.jpg'),
--     ('bobsmith', 'bobsmith', 'bobsmith@gmail.com', 'client', TRUE, 'bobsmith.jpg'),
--     ('emilybrown', 'emilybrown', 'emilybrown@gmail.com', 'client', TRUE, 'emilybrown.jpg');

