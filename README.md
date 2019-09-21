# WordPress
Task for WordPress to make plugin with custom database and CRUD system.

# Download
Clone the priject using git clone https://github.com/AlaaBadr/WordPress.git or Download it as a zip and extract it inside your server directory.

# Project Setup
1. Create a new empty database schema with Collation.
2. Create a .env file by copying .env.example in bedrock directory.
3. Change the following attributes in the .env file:
    DB_NAME      //database name
    DB_USER      //your MySQL user e.g root
    DB_PASSWORD  //your MySQL password
    WP_HOME      //http://{example.com}/WordPress/bedrock/web
4. cd bedrock directory and hit "composer install" command in your terminal.
5. Start your server services.
6. Run the website in your browser using the WP_HOME and complete WordPress installation.
7. Login as administrator and activate Events Plugin from Plugins tab in the left-side menu bar.

# Plugin Description
It Shows 2 items in the menu bar, one for settings and other for CRUD operations.

In the frontend listing page it lists only upcoming events, and if admin enabled showing past events it will show a link to view them.
Also, events will be shown in categories as past/upcoming ones.

Plugin has its own database table that holds the events entries and retrieves custom fields to view them.

Archive and Category pages paginate events based on the number entered in the plugin settings.
