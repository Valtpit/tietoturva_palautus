drop database if exists n0piri01;

CREATE DATABASE n0piri01;

use n0piri01;

CREATE TABLE users (
    username varchar(50) NOT NULL,
    password varchar(150) NOT NULL,
    PRIMARY KEY (username)
);

INSERT INTO users VALUES ("esimerkkiErkki", "Salasana1");

CREATE TABLE secrets (
    username varchar(50) NOT NULL,
    secret varchar(150) NOT NULL,
    PRIMARY KEY (username)
);

INSERT INTO secrets VALUES ("esimerkkiErkki", "esimerkki salainen teksti.");