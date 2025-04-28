CREATE DATABASE IF NOT EXISTS csit314;

use csit314;

DROP TABLE IF EXISTS Shortlist;
DROP TABLE IF EXISTS CleanerService;
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
    `category` VARCHAR(64) NOT NULL,
    `description` VARCHAR(64) NOT NULL DEFAULT 'No Description',
    PRIMARY KEY (`id`),
    UNIQUE (`category`)
);

CREATE TABLE CleanerService (
    `id` INT AUTO_INCREMENT,
    `serviceCategoryID` INT NOT NULL,
    `cleanerID` INT NOT NULL,
    `price` DECIMAL(10, 2) NOT NULL,
    `numViews` INT DEFAULT 0,
    `numShortlists` INT DEFAULT 0,
    `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`serviceCategoryID`) REFERENCES ServiceCategory(`id`) ON DELETE CASCADE,
    FOREIGN KEY(`cleanerID`) REFERENCES UserAccount(`id`)
);

CREATE TABLE Shortlist (
    homeownerID INT NOT NULL,
    serviceID INT NOT NULL,
    shortlistedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (homeownerID, serviceID),
    FOREIGN KEY (homeownerID) REFERENCES UserAccount(id),
    FOREIGN KEY (serviceID) REFERENCES CleanerService(id) ON DELETE CASCADE
);

INSERT INTO UserProfile VALUES(1, "User Admin", "For User Management", 0);
INSERT INTO UserProfile VALUES(2, "Platform Management", "For Service Categories Management", 0);
INSERT INTO UserProfile VALUES(3, "Cleaner", "For cleaners to manage their services", 0);
INSERT INTO UserProfile VALUES(4, "Homeowner", "For homeowners to access Cleaner Services.", 0);

INSERT INTO UserAccount VALUES(1, 'u1', md5('u1'), 'User1', 'user1@example.com', '43202034', 'User Admin', 0);
INSERT INTO UserAccount VALUES(2, 'pm1', md5('pm1'), 'User2', 'user2@example.com', '98620160', 'Platform Management', 0);
INSERT INTO UserAccount VALUES(5, 'c1', md5('c1'), 'Cleaner1', 'user5@example.com', '98628160', 'Cleaner', 0);
INSERT INTO UserAccount VALUES(6, 'c2', md5('c2'), 'Cleaner2', 'user6@example.com', '98629160', 'Cleaner', 0);
INSERT INTO UserAccount VALUES(7, 'c3', md5('c3'), 'Cleaner3', 'user7@example.com', '98621160', 'Cleaner', 0);

INSERT INTO ServiceCategory (category, description) VALUES ('Deep Cleaning Service', 'For Specialized Cleaning Services');
INSERT INTO ServiceCategory (category) VALUES ('Air Conditioning Service');
INSERT INTO ServiceCategory (category, description) VALUES ('Laundry Service', 'Wash, Fold, Iron');


INSERT INTO CleanerService (serviceCategoryID, cleanerID, price, numViews, numShortlists, createdAt, updatedAt) VALUES
(1, 5, 25.00, 5, 2, '2025-04-28 09:00:00', '2025-04-28 09:00:00'),
(2, 6, 30.50, 10, 3, '2025-04-28 11:30:00', '2025-04-28 11:30:00'),
(3, 7, 40.00, 15, 5, '2025-04-25 14:00:00', '2025-04-25 14:00:00'),
(1, 5, 28.00, 20, 7, '2025-04-24 16:45:00', '2025-04-28 13:15:00'),
(2, 6, 35.00, 8, 2, '2025-04-20 10:00:00', '2025-04-20 10:00:00'),
(3, 7, 50.00, 25, 10, '2025-01-15 18:00:00', '2025-01-15 18:00:00'),
(1, 5, 22.00, 12, 4, '2025-03-01 09:30:00', '2025-03-01 09:30:00'),
(2, 6, 38.00, 3, 1, '2025-04-28 15:00:00', '2025-04-28 16:30:00'),
(3, 7, 45.00, 18, 6, '2024-11-20 12:00:00', '2024-11-20 12:00:00'),
(1, 5, 27.50, 9, 3, '2025-04-22 08:00:00', '2025-04-26 17:45:00');