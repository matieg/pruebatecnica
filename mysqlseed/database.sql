CREATE DATABASE IF NOT EXISTS pruebatecnica;

USE pruebatecnica;

CREATE TABLE IF NOT EXISTS `user` (
    `id` int NOT NULL AUTO_INCREMENT,
    `name` varchar(255),
    `username` varchar(255),
    `password` varchar(255),
    PRIMARY KEY (`id`)
);

INSERT INTO `user`(`id`, `name`, `user`, `password`) VALUES
(0,'Matias', 'matias',  '$2y$10$TSoRGQw2lH/YB55ElIv5xuI5Egqh56rI1dF3p9ixntxSmMuVrvV3a');