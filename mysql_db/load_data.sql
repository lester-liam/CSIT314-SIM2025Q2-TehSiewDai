CREATE DATABASE IF NOT EXISTS csit314;

use csit314;

DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS UserProfile;


CREATE TABLE UserProfile (
    `id` INT AUTO_INCREMENT,
    `role` VARCHAR(64) UNIQUE NOT NULL,
    `description` VARCHAR(255) NULL,
    `isSuspend` BOOL NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
);

CREATE TABLE User (
    `id` INT AUTO_INCREMENT,
    `username` VARCHAR(64) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `fullName` VARCHAR(64) NOT NULL,
    `email` VARCHAR(64) NOT NULL,
    `phone` VARCHAR(64) NOT NULL,
    `userProfile` VARCHAR(64) NOT NULL,
    `isSuspend` BOOL NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`userProfile`) REFERENCES UserProfile(`role`),
    UNIQUE (`username`)
);


INSERT INTO UserProfile VALUES(1, "User Admin", "For User Management", 0);
INSERT INTO UserProfile VALUES(2, "Platform Management", "For Service Categories Management", 0);
INSERT INTO UserProfile VALUES(3, "Cleaner", "For cleaners to manage their services", 0);
INSERT INTO UserProfile VALUES(4, "Homeowner", "For homeowners to access Cleaner Services.", 0);

INSERT INTO User VALUES(1, 'u1', md5('u1'), 'User1', 'user1@example.com', '+65 4320-2034', 'User Admin', 0)