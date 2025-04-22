CREATE DATABASE IF NOT EXISTS csit314;

use csit314;

DROP TABLE IF EXISTS ServiceCategory;
DROP TABLE IF EXISTS UserAccount;
DROP TABLE IF EXISTS UserProfile;


CREATE TABLE UserProfile (
    `id` INT AUTO_INCREMENT,
    `role` VARCHAR(64) UNIQUE NOT NULL,
    `description` VARCHAR(255) NULL,
    `isSuspend` BOOL NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
);

CREATE TABLE UserAccount (
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

CREATE TABLE ServiceCategory (
    `id` INT AUTO_INCREMENT,
    `serviceName` VARCHAR(255) NOT NULL,
    `serviceCategory` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
);


INSERT INTO UserProfile VALUES(1, "User Admin", "For User Management", 0);
INSERT INTO UserProfile VALUES(2, "Platform Management", "For Service Categories Management", 0);
INSERT INTO UserProfile VALUES(3, "Cleaner", "For cleaners to manage their services", 0);
INSERT INTO UserProfile VALUES(4, "Homeowner", "For homeowners to access Cleaner Services.", 0);

INSERT INTO UserAccount VALUES(1, 'u1', md5('u1'), 'User1', 'user1@example.com', '+65 4320-2034', 'User Admin', 0);

INSERT INTO ServiceCategory (id, serviceName, serviceCategory) VALUES
(1, 'Window Cleaning', 'Residential Cleaning'),
(2, 'Office Cleaning', 'Commercial Cleaning'),
(3, 'Carpet Shampooing', 'Specialized Cleaning'),
(4, 'Post-Renovation Cleaning', 'Deep Cleaning'),
(5, 'Regular Housekeeping', 'Residential Cleaning'),
(6, 'Industrial Floor Cleaning', 'Commercial Cleaning'),
(7, 'Move-in/Move-out Cleaning', 'Deep Cleaning'),
(8, 'Upholstery Cleaning', 'Specialized Cleaning'),
(9, 'Air Conditioning Cleaning', 'Maintenance Services'),
(10, 'Kitchen and Appliance Cleaning', 'Residential Cleaning');