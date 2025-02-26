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

INSERT INTO roles (name) VALUES ('admin'), ('organisateur'), ('participant');

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    id_role INT NOT NULL,
    is_banned TINYINT(1) DEFAULT 0,
    FOREIGN KEY (id_role) REFERENCES roles(id) ON DELETE CASCADE
);

/*ajouter colonne pour l'image de users apartir de leure profile*/
ALTER TABLE users
ADD COLUMN profile_image VARCHAR(255) NULL;

CREATE TABLE roles_users (
    id_user int ,
    id_role int,
    Foreign Key (id_user) REFERENCES users(id) ON DELETE CASCADE,
    Foreign Key (id_role) REFERENCES roles(id) ON DELETE CASCADE
);




CREATE TABLE sponsors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    logo VARCHAR(255) NOT NULL
);

CREATE TABLE `region` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(40) NOT NULL
);



CREATE TABLE `villes` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    id_region INT NOT NULL,
    FOREIGN KEY (id_region) REFERENCES region(id) ON DELETE CASCADE
);


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
    status ENUM('pending', 'accepted', 'refused') DEFAULT 'pending',
    likes INT DEFAULT 0,
    dislikes INT DEFAULT 0,
    date_event DATETIME ,
    date_fin DATETIME ,
    nombre_place INT,
    event_type ENUM('live', 'presentiel') ,
    adresse VARCHAR(255),
    description TEXT,
    FOREIGN KEY (id_ville) REFERENCES villes(id) ON DELETE CASCADE,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (id_categorie) REFERENCES categories(id) ON DELETE CASCADE
);
ALTER TABLE events
ADD COLUMN annulation ENUM('non', 'oui') DEFAULT 'non';





CREATE TABLE event_sponsor (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_event INT NOT NULL,
    id_sponsor INT NOT NULL,
    FOREIGN KEY (id_event) REFERENCES events(id) ON DELETE CASCADE,
    FOREIGN KEY (id_sponsor) REFERENCES sponsors(id) ON DELETE CASCADE
);

CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_event INT NOT NULL,
    id_user INT NOT NULL,
    status ENUM('reserved', 'paid', 'cancelled') DEFAULT 'reserved',
    FOREIGN KEY (id_event) REFERENCES events(id) ON DELETE CASCADE,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_reservation INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_reservation) REFERENCES reservations(id) ON DELETE CASCADE
);


CREATE TABLE paiements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mode ENUM('PayPal', 'Carte Bancaire', 'Espèces') NOT NULL,
    id_order INT NOT NULL,
    payment_status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_order) REFERENCES orders(id) ON DELETE CASCADE
);



CREATE TABLE `dislikes_event` (
  `id_event` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `likes_event` (
  `id_event` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
