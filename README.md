# netflix-style-web-app-using-tmdb-api

Netflix-style web app built with **PHP, JavaScript and MySQL**, powered by the **TMDB REST API**, featuring authentication, protected pages and dynamic movie & TV browsing.

The project was created to explore:
- REST API consumption  
- Backend proxying to protect API keys  
- User authentication with PHP + MySQL  
- Dynamic rendering of movies and TV series  
- Multi-page frontend architecture  

This project runs locally (Apache + PHP + MySQL).  
API keys, database credentials and email credentials are not included for security reasons.

---

## Features

- Movies and TV series from TMDB  
- Home, Movies, TV Series and Details pages  
- Genre-based recommendations  
- User authentication (sign up / login / logout)  
- Protected pages (movies, tv series, details, settings)  
- Backend proxy for TMDB API calls  
- Email notifications on registration and login (via PHPMailer)  
- Responsive UI built with Bootstrap  

---

## Tech Stack

- PHP  
- JavaScript (Vanilla)  
- MySQL  
- Bootstrap  
- TMDB REST API  
- PHPMailer (email notifications)  

---

## How to run the project locally

### 1. Requirements

You need:
- Apache (or similar web server)  
- PHP  
- MySQL  

XAMPP, MAMP or similar stacks are fine.

---

### 2. Clone the repository

Clone the repository from GitHub and place it inside your local server folder, for example:

xampp/htdocs/fakeflix  

(or the equivalent for your local stack)

---

### 3. Create the database

Create a new MySQL database called:

fakeflix  

Then create this table:

registered_users  

Fields:
- id (INT, auto-increment, primary key)  
- username (VARCHAR 100, not null)  
- email (VARCHAR 150, not null)  
- password (VARCHAR 255, not null)  
- otp (INT)  
- join_date (TIMESTAMP, default CURRENT_TIMESTAMP)  

These fields match the registration and login system used by the app.

---

## Important: Config files

For security reasons, this repository does **not** include real configuration files.

Instead, it includes two template files:

- config.example.php  
- php/api_private_request.example.php  

These files contain the correct structure and comments, but no private data.

To run the project, you must create the real config files by copying them:

In the project root:

config.example.php → config.php  

In the php/ folder:

api_private_request.example.php → api_private_request.php  

These two new files (config.php and api_private_request.php) are the ones actually used by the application.

They are listed in .gitignore and will **not** be committed to GitHub.

---

### 4. Configure database connection

Open the file:

config.php  

Set your local database credentials:

DB_SERVER = localhost  
DB_USERNAME = your_database_username  
DB_PASSWORD = your_database_password  
DB_NAME = fakeflix  

---

### 5. Add your TMDB API key

Open this file:

php/api_private_request.php  

Find this line:

$apiAuthKey = '[MY API KEY]';  

Replace it with:

$apiAuthKey = 'api_key=YOUR_TMDB_API_KEY';  

You can get a free API key from:  
https://www.themoviedb.org/settings/api  

---

### 6. Install PHPMailer (email notifications)

This project uses **PHPMailer** to send email notifications when:
- a user completes registration  
- a user successfully logs in  

PHPMailer is **not included in this repository** and must be added locally.

#### Step 1 — Download PHPMailer  
Download PHPMailer from:  
https://github.com/PHPMailer/PHPMailer  

You only need the `src` folder or the classic `class.phpmailer.php` version.

#### Step 2 — Add it to the project  
Create this folder inside the project root:

fakeflix/PHPMailer  

Then place the PHPMailer files inside it, for example:

fakeflix/PHPMailer/class.phpmailer.php  

(or the equivalent files depending on the PHPMailer version you download)

#### Step 3 — Configure email sending  
The files `login.php` and `signup.php` use PHPMailer to send notification emails.  
You may need to configure SMTP settings inside those files depending on your local environment or hosting provider.

---

### 7. Run the project

Start Apache and MySQL.

Then open in your browser:

http://localhost/fakeflix  

You can now:
- Register a user  
- Log in  
- Browse movies and TV series  
- Open details pages  
- See recommendations based on genres  

---

## Security note

For security reasons, the following are **not** included in this repository:

- TMDB API key  
- Database credentials  
- Email (SMTP) credentials  

They must be added locally in:

- php/api_private_request.php  
- config.php  
- (optional) PHPMailer configuration inside login.php and signup.php  

This prevents exposing private credentials in a public GitHub repository.

---

## What this project demonstrates

- REST API integration  
- Backend proxying to protect API keys  
- User authentication with PHP and MySQL  
- Email notifications on user actions  
- Dynamic frontend rendering  
- Handling different API structures (movies vs TV series)  
- Real-world full-stack project structure

## Copyright
This project is a personal, non-commercial educational exercise. All images, logos, and media belong to their respective copyright holders and are used here for demonstration purposes only
