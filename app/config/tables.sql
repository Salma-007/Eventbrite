DROP DATABASE IF EXISTS eventbrite_db;
CREATE DATABASE eventbrite_db;
USE eventbrite_db;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    id_role INT NOT NULL,
    is_banned INT DEFAULT 0,
    FOREIGN KEY (id_role) REFERENCES roles(id) ON DELETE CASCADE
);

CREATE TABLE sponsors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    logo VARCHAR(255) NOT NULL
);

CREATE TABLE villes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    type ENUM('free', 'payant') NOT NULL,
    id_ville INT,
    id_user INT,
    id_categorie INT,
    prix DECIMAL(10,2) DEFAULT 0,
    lien VARCHAR(255),
    couverture VARCHAR(255),
    status ENUM('pending', 'accepted', 'refuse') DEFAULT 'pending',
    `like` INT DEFAULT 0,
    dislike INT DEFAULT 0,
    date_event DATE NOT NULL,
    date_fin DATE NOT NULL,
    nombre_place INT NOT NULL,
    FOREIGN KEY (id_ville) REFERENCES villes(id) ON DELETE CASCADE,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (id_categorie) REFERENCES categories(id) ON DELETE CASCADE
);

CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_event INT NOT NULL,
    id_user INT NOT NULL,
    FOREIGN KEY (id_event) REFERENCES events(id) ON DELETE CASCADE,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE event_sponsor (
    id_event INT NOT NULL,
    id_sponsor INT NOT NULL,
    PRIMARY KEY (id_event, id_sponsor),
    FOREIGN KEY (id_event) REFERENCES events(id) ON DELETE CASCADE,
    FOREIGN KEY (id_sponsor) REFERENCES sponsors(id) ON DELETE CASCADE
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_reservation INT NOT NULL,
    FOREIGN KEY (id_reservation) REFERENCES reservations(id) ON DELETE CASCADE
);

CREATE TABLE paiements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mode VARCHAR(50) NOT NULL,
    id_order INT NOT NULL,
    FOREIGN KEY (id_order) REFERENCES orders(id) ON DELETE CASCADE
);
