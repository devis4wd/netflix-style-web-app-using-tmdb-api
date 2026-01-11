# netflix-style-web-app-using-tmdb-api
Netflix-style web app built with PHP, JavaScript and MySQL, powered by the TMDB REST API, featuring authentication, protected pages and dynamic movie &amp; TV browsing.

The project was created to explore:
- REST API consumption
- backend proxying to protect API keys
- user authentication with PHP + MySQL
- dynamic rendering of movies and TV series
- multi-page frontend architecture

This project runs locally (Apache + PHP + MySQL).
API keys and database credentials are not included for security reasons.


--------------------------------------------------
FEATURES
--------------------------------------------------

- Movies and TV series from TMDB
- Home, Movies, TV Series and Details pages
- Genre-based recommendations
- User authentication (sign up / login / logout)
- Protected pages (movies, tv series, details, settings)
- Backend proxy for TMDB API calls
- Responsive UI built with Bootstrap


--------------------------------------------------
TECH STACK
--------------------------------------------------

- PHP
- JavaScript (Vanilla)
- MySQL
- Bootstrap
- TMDB REST API


--------------------------------------------------
HOW TO RUN THE PROJECT LOCALLY
--------------------------------------------------

1) REQUIREMENTS

You need:
- Apache (or similar web server)
- PHP
- MySQL

XAMPP, MAMP or similar stacks are fine.


2) CLONE THE REPOSITORY

Clone the repository from GitHub and place it inside your local server folder, for example:

xampp/htdocs/fakeflix

(or the equivalent for your local stack).


3) CREATE THE DATABASE

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

--------------------------------------------------
IMPORTANT: CONFIG FILES
--------------------------------------------------

For security reasons, this repository does NOT include real configuration files.

Instead, it includes two template files:

- config.example.php
- php/api_private_request.example.php

These files contain the correct structure and comments, but no private data.

To run the project, you must create the real config files by copying them:

1) In the project root:

Copy  
config.example.php → config.php  

2) In the php/ folder:

Copy  
api_private_request.example.php → api_private_request.php  

These two new files (config.php and api_private_request.php) are the ones actually used by the application.

They are listed in .gitignore and will NOT be committed to GitHub.



4) CONFIGURE DATABASE CONNECTION

Open the file:

config.php

Set your local database credentials:

DB_SERVER = localhost  
DB_USERNAME = your database username  
DB_PASSWORD = your database password  
DB_NAME = fakeflix  


5) ADD YOUR TMDB API KEY

Open this file:

php/api_private_request.php

Find this line:

$apiAuthKey = '[MY API KEY]';

Replace it with:

$apiAuthKey = 'api_key=YOUR_TMDB_API_KEY';

You can get a free API key from:
https://www.themoviedb.org/settings/api


6) RUN THE PROJECT

Start Apache and MySQL.

Then open in your browser:

http://localhost/fakeflix

You can now:
- Register a user
- Log in
- Browse movies and TV series
- Open details pages
- See recommendations based on genres


--------------------------------------------------
SECURITY NOTE
--------------------------------------------------

For security reasons, the TMDB API key and database credentials are NOT included in this repository.

They must be added locally in:

- php/api_private_request.php
- config.php

This prevents exposing private credentials in a public GitHub repository.


--------------------------------------------------
WHAT THIS PROJECT DEMONSTRATES
--------------------------------------------------

- REST API integration
- Backend proxying to protect API keys
- User authentication with PHP and MySQL
- Dynamic frontend rendering
- Handling different API structures (movies vs TV series)
- Real-world full-stack project structure

