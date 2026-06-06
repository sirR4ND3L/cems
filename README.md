# Campus Event Management System (CEMS)

CEMS is a professional-grade, web-based platform designed to streamline event registration, capacity management, and activity tracking for educational institutions.

## Key Features
* **Role-Based Access Control:** Secure Staff/Organizer portal with authentication.
* **Event CRUD:** Seamless creation, editing, and deletion of campus events.
* **Capacity Gate:** Intelligent booking limits to prevent event over-enrollment.
* **Audit Trail:** Real-time logging of all registration activities for total transparency.
* **Ticket Generation:** Unique, secure Ticket IDs for every participant.
* **Dynamic Filtering:** Automatic event status management (Upcoming vs. Past events).
* **Responsive UI:** Modern, clean interface built with HTML5, CSS3, and JavaScript.

## Tech Stack
* **Frontend:** HTML5, CSS3 (Flexbox/Grid), JavaScript.
* **Backend:** PHP.
* **Database:** MySQL.
* **Architecture:** MVC-inspired structure for modularity and scalability.

## Installation & Setup

### Prerequisites
* A web server with PHP support (e.g., XAMPP, WAMP, or MAMP).
* MySQL database server.

### Steps
1. **Clone/Copy the project:** Place the project folder into your server's root directory (e.g., `htdocs` in XAMPP).
2. **Database Setup:** - Open your database management tool (e.g., phpMyAdmin).
   - Create a new database named `cems_db`.
   - Import the `sql/schema.sql` file to initialize the tables.
3. **Configuration:** - Open `config/db.php`.
   - Update your database credentials (`DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`) to match your local environment.
4. **Access the Application:**
   - Open your browser and navigate to `http://localhost/CFMS/index.php`.
   - Use the login link to access the Staff/Organizer panel.

## Project Structure
* `/admin`: Staff and Organizer management pages.
* `/config`: Database connection and configuration files.
* `/includes`: Reusable components (e.g., navigation, alerts).
* `/sql`: Database schema files.
* `/student`: Public-facing student registration and verification pages.
* `assets/`: CSS, JS, and image files.

## Credits
Built as a comprehensive Campus Event Management solution to demonstrate web development, database management, and system integration.
