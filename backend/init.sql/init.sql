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

CREATE TABLE
    bookings (
        id INT PRIMARY KEY AUTO_INCREMENT,
        id_user INT,
        id_rest INT,
        id_turn INT,
        people INT,
        state VARCHAR(255),
        date DATE
    );

CREATE TABLE
    turns (
        id INT PRIMARY KEY,
        type_turn VARCHAR(255),
        hora VARCHAR(255)
    ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE
    bookings_tables (
    id_table INT,
    id_booking INT,
    PRIMARY KEY (id_table, id_booking),
    FOREIGN KEY (id_table) REFERENCES tables(id_table),
    FOREIGN KEY (id_booking) REFERENCES bookings(id)
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
        'https://picsum.photos/200/300?random=1',
        '123 Calle Principal, Ciudad'
    ), (
        2,
        'El Asador Argentino',
        'https://picsum.photos/200/300?random=2',
        '456 Avenida Central, Ciudad'
    ), (
        3,
        'Sushi Express',
        'https://picsum.photos/200/300?random=3',
        '789 Calle Secundaria, Ciudad'
    ), (
        4,
        'Pasta Paradise',
        'https://picsum.photos/200/300?random=4',
        '1010 Avenida de las Flores, Ciudad'
    ), (
        5,
        'Burger Town',
        'https://picsum.photos/200/300?random=5',
        '1111 Plaza del Sol, Ciudad'
    ), (
        6,
        'Tacos del Norte',
        'https://picsum.photos/200/300?random=6',
        '1212 Calle del Bosque, Ciudad'
    ), (
        7,
        'The Curry House',
        'https://picsum.photos/200/300?random=7',
        '1313 Calle de la Luna, Ciudad'
    ), (
        8,
        'Veggie Delights',
        'https://picsum.photos/200/300?random=8',
        '1414 Avenida del Mar, Ciudad'
    ), (
        9,
        'French Gourmet',
        'https://picsum.photos/200/300?random=9',
        '1515 Boulevard Paris, Ciudad'
    ), (
        10,
        'Pizza World',
        'https://picsum.photos/200/300?random=10',
        '1616 Calle Nueva, Ciudad'
    );

-- Insertar datos en la tabla categories

INSERT INTO
    categories (id, name_cat, img_cat)
VALUES (
        1,
        'Italiana',
        'https://picsum.photos/200/300?random=11'
    ), (
        2,
        'Argentina',
        'https://picsum.photos/200/300?random=12'
    ), (
        3,
        'Japonesa',
        'https://picsum.photos/200/300?random=13'
    ), (
        4,
        'Americana',
        'https://picsum.photos/200/300?random=14'
    ), (
        5,
        'Mexicana',
        'https://picsum.photos/200/300?random=15'
    ), (
        6,
        'India',
        'https://picsum.photos/200/300?random=16'
    ), (
        7,
        'Vegetariana',
        'https://picsum.photos/200/300?random=17'
    ), (
        8,
        'Francesa',
        'https://picsum.photos/200/300?random=18'
    ), (
        9,
        'China',
        'https://picsum.photos/200/300?random=19'
    ), (
        10,
        'Mediterránea',
        'https://picsum.photos/200/300?random=20'
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
INSERT INTO
    users (
        username,
        password,
        email,
        type_user,
        is_active,
        photo,
        RT
    )
VALUES (
        'admin',
        '$2a$10$OjVs/YFP1dEnd.XJDA6OQu9Z5VwLTn5BkDflls/ntlZ0hqFq3fXGa',
        'admin@gmail.com',
        'admin',
        TRUE,
        'admin.jpg',
        'patata'
    ), (
        'kevin',
        '$2a$10$OjVs/YFP1dEnd.XJDA6OQu9Z5VwLTn5BkDflls/ntlZ0hqFq3fXGa',
        'kevin@gmail.com',
        'admin',
        TRUE,
        'https://avatars.githubusercontent.com/u/90612916?v=4',
        'tapa'
    ), (
        'luis',
        '$2a$10$OjVs/YFP1dEnd.XJDA6OQu9Z5VwLTn5BkDflls/ntlZ0hqFq3fXGa',
        'luis@gmail.com',
        'client',
        TRUE,
        'luis.jpg',
        'lapa'
    );


INSERT INTO turns (id, type_turn, hora)
VALUES
    (1, 'Mañana', '09:00'),
    (2, 'Tarde', '13:00'),
    (3, 'Noche', '19:00');

INSERT INTO bookings (id_user, id_rest, id_turn, people, state, date)
VALUES
    (1, 1, 1, 4, 'Confirmada', '2021-05-01'),
    (2, 2, 2, 2, 'Pendiente', '2021-05-01'),
    (3, 6, 3, 6, 'Confirmada', '2021-05-01'),
    (1, 7, 1, 3, 'Cancelada', '2021-05-02'),
    (2, 5, 2, 5, 'Confirmada', '2021-05-02');

INSERT INTO bookings_tables (id_table, id_booking)
VALUES
    (1, 1),
    (3, 2),
    (9, 3),
    (10, 3),
    (11, 4),
    (7, 5);
