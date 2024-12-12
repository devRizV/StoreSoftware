# StoreSoftware - Inventory Management System


<div class="container">
## Overview
StoreSoftware is an open-source inventory management system designed to streamline and optimize inventory-related tasks for businesses.

## Features
- User-friendly interface
- Inventory tracking and management
- Product categorization and organization
- Add and use product tracking
- Monthly spending tracking
- Daily spending tracking
- Exporting to excel
- Reporting and analytics

## Technologies Used
- Frontend: HTML, CSS, JS, Bootstrap
- Backend: PHP, laravel
- Database: MySQL
        <hr>
        <h2>Requirements</h2>
        <p>Before setting up the project, ensure your system meets the following requirements:</p>
        <ul>
            <li><strong>PHP</strong>: Version 8.1 or higher</li>
            <li><strong>Composer</strong>: Dependency manager for PHP</li>
            <li><strong>Web Server</strong>: Apache/Nginx</li>
            <li><strong>Database</strong>: MySQL/MariaDB</li>
        </ul>
        <hr>
        <h2>Setup Instructions</h2>
        <h3>Step 1: Clone the Repository</h3>
        <pre><code>git clone https://github.com/devRizV/StoreSoftware.git
cd repository</code></pre>
        <h3>Step 2: Install Dependencies</h3>
        <pre><code>composer install</code></pre>
        <h3>Step 3: Configure the Environment</h3>
        <p>Copy the example <code>.env</code> file to create your own environment configuration:</p>
        <pre><code>cp .env.example .env</code></pre>
        <p>Edit the <code>.env</code> file and update the database connection details:</p>
        <pre><code>DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password</code></pre>
        <h3>Step 4: Import the Database</h3>
        <p>Import the provided SQL file into your MySQL database:</p>
        <pre><code>mysql -u username -p your_database_name &lt; db/storesoft.sql</code></pre>
        <h3>Step 5: Generate the Application Key</h3>
        <pre><code>php artisan key:generate</code></pre>
        <h3>Step 6: Set Directory Permissions</h3>
        <p>Ensure the appropriate file permissions are set for the <code>storage</code> and <code>bootstrap/cache</code> directories:</p>
        <pre><code>chmod -R 775 storage bootstrap/cache</code></pre>
        <h3>Step 7: Start the Development Server</h3>
        <p>Launch the development server:</p>
        <pre><code>php artisan serve</code></pre>
        <p>Open the application in your browser at: <a href="http://localhost:8000" target="_blank">http://localhost:8000</a></p>
        <hr>
        <h2>Additional Notes</h2>
        <ul>
            <li>Make sure the database is running before starting the development server.</li>
            <li>The project follows standard MVC architecture and is built with Laravel.</li>
        </ul>
        <hr>
    </div>