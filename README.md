# Malawi Rugby Union (MARU) Player Registration System

The MARU Web-Based Online Player Registration System is a centralized platform designed to streamline the registration and management of rugby players and coaches across Malawi. It replaces traditional paper-based methods with a modern, secure, and efficient digital solution.

## Features

- **Player Management**: Players can register, maintain profiles, and upload required documents securely.
- **Coach Portal**: Coaches can register, manage their team rosters, and track player registration statuses.
- **Admin Dashboard**: System administrators can oversee all users, verify uploaded documents, manage teams, and monitor system metrics.
- **Document Verification**: A robust workflow for players to submit identification documents and admins to approve or reject them.

## Tech Stack

- **Backend**: Vanilla PHP 8+ using a custom MVC architecture.
- **Database**: MySQL.
- **Frontend**: HTML5, custom Vanilla CSS Design System, and JavaScript.

## Prerequisites

Before you begin, ensure you have met the following requirements:
- **PHP**: Version 8.0 or higher.
- **Database**: MySQL 8.0+ or MariaDB equivalent.
- **Web Server**: Apache, Nginx, or a similar web server environment.
- **Composer** (optional, depending on external dependencies in the future).

## Installation

Follow these steps to set up the project locally:

2. **Set Up the Database**
   - Create a new MySQL database (e.g., `maru_db`).
   - Import the provided SQL schema and seed data from the `database/` directory (if applicable):
     ```bash
     mysql -u your_username -p maru_db < database/schema.sql
     ```

3. **Configure the Environment**
   - Copy the example configuration file or update the existing configuration file.
   - Update `config/database.php` or `.env` with your local database credentials:
     ```php
     // Example configuration
     'host' => 'localhost',
     'dbname' => 'maru_db',
     'user' => 'root',
     'password' => 'secret'
     ```

4. **Serve the Application**
   - If using Apache/Nginx, point the document root to the `public/` directory.
   - Alternatively, use PHP's built-in server for quick local testing:
     ```bash
     php -S localhost:8000 -t public/
     ```

## Directory Structure

```
Allstar/
├── config/           # Configuration files (e.g., database connection)
├── public/           # Document root (index.php, CSS, JS, images, uploads)
├── src/              # Application source code (MVC)
│   ├── Controllers/  # Application controllers
│   ├── Models/       # Database models
│   └── Helpers/      # Utility classes (Router, Session, Validator, etc.)
├── views/            # Frontend templates and views
│   ├── layouts/      # Main page wrappers
│   ├── pages/        # Specific page content
│   └── partials/     # Reusable UI components
└── README.md         # Project documentation
```

## License & Contact

This project is licensed under the [MIT License](LICENSE).

For support or inquiries, please contact [insert contact info].
