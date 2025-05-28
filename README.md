## CSIT314 - SIM2025Q2-TehSiewDai

[Try our app on Render](https://csit314-sim2025q2-tehsiewdai-app.onrender.com/)

---

![collage-showcase.jpg](https://i.ibb.co/60ygHbcG/collage-showcase.jpg>)

This project is part of CSIT314 - Software Development Methodology Module, it aims to
develop a system for C2C Freelance Home Cleaners Service that acts as a platform
to connect freelance home cleaners with homeowners. The service will support various
key features and functionalities such as:

* User Admin to manage different user accounts and profiles
* Platform Management to manage the different service categories offered as well as access to reports (Daily, Weekly, Monthly)
* Homeowners to view different cleaner services, shortlist them and view past bookings.
* Cleaners to create different cleaning service offers, and view past completed services.

### Group Members
* Lester Liam Chong Bin (7558752)
* Kenneth Lee Jun Han (7772427)
* Teo Choun Meng (7919591)
* Jinghan Wu (8246580)
* Koh Yong Shen Alois (7893449)
* Andre Matthew Lau Jun Jie (7026304)
* Dinglin 8222782

### Explore Our Documentation/Showcase
* [Documents/Showcase Video](https://docs.google.com/document/d/1QD3kkQlSZlbpLJABsi_e2Dk3EjVsRq1cdDz0Y2VuYxM/edit?usp=sharing)

## Project Structure
The repository is organized as follows:
```
csit314
├── mysql_db/       MySQL Database Loading Script
├── src/            Boundary, Controller and Entity Files
├── tests/          Test Scripts to Insert Tests Data / Test Functions (phpunit)
├── Dockerfile      Contains instructions for building the Docker image for the application
├── README.md       This file
├── .dockerignore   Files and directories to exclude when building Docker images
├── composer.json   Defines PHP Dependencies (phpunit)
├── composer.lock   Exact versions of PHP dependencies
```

## Setup & Run the Application

To run the application, you need to have Docker and Docker Compose installed on your system. You can find installation instructions for Docker [here](https://docs.docker.com/get-started/get-docker/).

1.  **Unzip content of `TehSiewDai-SourceCode.zip` file.**
    ```bash
    cd csit314
    ```
    Navigate to project directory `csit314` that was extracted after unzipping.

2.  **Starting the Application using Docker Compose:**
    ```bash
    docker-compose up --build
    ```
    This command will build the Docker images (if necessary) and start the containers defined in the `docker-compose.yml` file, which are `php:8.2-apache` for PHP, `mariadb:10.11` for MySQL Database and `phpmyadmin:5.2-apache` to manage the database.

    During container building, the script will automatically create and insert a few sample records for you via the `mysql_db/load_data.sql` script.

3.  **Accessing the Application:**

    Once the containers are running, you can access the application through the following URLs in your web browser:
    * **Login Page:** [`http://localhost:9000`](http://localhost:9000)
    * **phpMyAdmin Panel:** [`http://localhost:8080`](http://localhost:8080)

4.  **Stopping the Application:**

    To stop the running containers, use the following command in the project directory:
    ```bash
    docker-compose down
    ```

## Demo Credentials

The following credentials are created automatically to explore different user roles within the application as well as access the database panel for phpMyAdmin.

* **User Admin:**
    * Username: `u1`
    * Password: `u1`
* **Platform Management:**
    * Username: `pm1`
    * Password: `pm1`
* **Cleaner:**
    * Username: `c1`
    * Password: `c1`
* **Homeowner:**
    * Username: `ho1`
    * Password: `ho1`
* **phpMyAdmin Panel**
    * Username: `root`
    * Password: `csit314`

## Insert Tests Data / Running Test Script

This project includes multiple PHP scripts that can be used to insert test data into the application's database. To run this script within the Docker environment, follow these steps:

**Execute the PHP script within the Docker container:**

Use the `docker-compose exec` command to run the PHP script within the PHP application container.

```bash
# Insert Test Data
docker-compose exec server php tests/CreateUserAccount.php
docker-compose exec server php tests/CreateServiceCategory.php
docker-compose exec server php tests/CreateCleanerService.php
docker-compose exec server php tests/CreateServiceHistory.php
docker-compose exec server php tests/CreateShortlist.php

# PHP Unit for Login Function
docker-compose exec server ./vendor/bin/phpunit tests/LoginTest.php
```

You will see output in your terminal indicating the progress or success of the data insertion.

**Rarely**, the console may log *"Script ran successfully, but with errors, check console or logs"*. This behavior is normal due to unique constraint violation in certain tables, and the script is made to skip that insert and continue.

---

### Acknowledgements
The following resources were used in the development of this project:

**Image Icon:** [Cleaning icons created by monkik - Flaticon](https://www.flaticon.com/free-icons/cleaning)

1. W3Schools n.d., CSS Dropdowns, W3Schools, viewed 17 May 2025, <<https://www.w3schools.com/css/css_dropdowns.asp>>.
2. W3Schools n.d., How To Create Column Cards, W3Schools, viewed 17 May 2025, <<https://www.w3schools.com/howto/howto_css_column_cards.asp>>.
3. W3Schools n.d., How To Make a Modal Box With CSS and JavaScript, W3Schools, viewed 17 May 2025, <<https://www.w3schools.com/howto/howto_css_modals.asp>>.
