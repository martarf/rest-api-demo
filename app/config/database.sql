SET NAMES 'utf-8';
CREATE DATABASE antevenio;
CREATE DATABASE antevenioTestdb;

CREATE USER 'antevenio'@'localhost' IDENTIFIED BY 'antevenio';
grant ALL ON antevenio.* TO 'antevenio'@'localhost';
grant ALL ON antevenioTestdb.* TO 'antevenio'@'localhost';

USE antevenio;
CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(3) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
INSERT INTO country VALUES (1, 'España','ES');
INSERT INTO country VALUES (2, 'Italia','IT');
INSERT INTO country VALUES (3, 'Francia','FR');