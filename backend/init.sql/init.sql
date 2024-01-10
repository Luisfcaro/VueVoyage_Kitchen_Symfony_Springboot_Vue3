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