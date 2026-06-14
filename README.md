# PinkBite Restaurant Management System

PinkBite is a web-based restaurant management system with a pink-themed UI, built using PHP and MySQL. The application supports two types of users, customer and admin, each with features tailored to restaurant operations.

## Features

### Customer
- Account registration and login
- View food and drink menu
- Table reservation (date, time, and party size)
- Queueing system to take a queue number
- Customer dashboard to view reservation and queue status
- About and Contact pages

### Admin
- Admin dashboard to view customer, reservation, and queue data
- Manage menu (add, edit, delete menu items including images)
- Manage tables (add, edit, delete, and assign tables)
- Manage customer reservations (edit, delete, update status)
- Manage queue (call queue, delete queue entries)
- Manage customer data

## Tech Stack

- PHP (native, no framework)
- MySQL / MariaDB
- Bootstrap 5
- Font Awesome
- AOS (Animate On Scroll) for animations

## Database Structure

The database is named `bismillah` and contains the following tables:

- `users` – login accounts (admin and customer)
- `customers` – customer profile data
- `menu` – food and drink menu data
- `tables` – restaurant table data
- `table_assignments` – table assignment data
- `reservations` – customer reservation data
- `queue` – customer queue data

The full SQL file is available in `bismillah.sql`.

## Installation

1. Clone or download this repository
2. Move the project folder to your local server directory (e.g. `htdocs` if using XAMPP)
3. Create a new database named `bismillah` in phpMyAdmin
4. Import `bismillah.sql` into the `bismillah` database
5. Update the database connection settings in `config.php` if needed:
   ```php
   $host = 'localhost';
   $user = 'root';
   $pass = '';
   $db   = 'bismillah';
   $port = 3307;
   ```
6. Start your local server (Apache/MySQL) and open the project in your browser, e.g.:
   ```
   http://localhost/your-project-folder/index.php
   ```

## Folder Structure

```
├── images/                  # images for menu and pages
├── uploads/                 # images uploaded via admin
├── ERD.jpg                  # entity relationship diagram
├── bismillah.sql            # database structure and data
├── config.php               # database connection settings
├── header.php               # shared header (customer)
├── header_admin.php         # shared header (admin)
├── footer.php               # shared footer
├── index.php                # homepage
├── login.php                # login page
├── logout.php                # logout handler
├── register.php             # registration page
├── about.php                 # about page
├── contact.php               # contact page
├── menu.php                  # menu page
│
├── customer_dashboard.php    # customer dashboard
├── reservation.php           # reservation page
├── reservation_add.php       # create reservation
├── reservation_edit.php      # edit reservation
├── seat_reservation.php       # seat assignment for reservation
├── submit_reservation.php     # handle reservation form submission
├── delete_reservation.php     # delete reservation
├── edit_reservation.php       # edit reservation (admin)
│
├── queueing.php               # customer queueing page
├── call_queue.php             # call next queue (admin)
├── delete_queue.php           # delete queue entry (admin)
│
├── admin_dashboard.php        # admin dashboard
├── admin_menu.php             # menu management (admin)
├── add_menu.php               # add menu item
├── edit_menu.php              # edit menu item
├── admin_customers.php        # customer management (admin)
├── edit_customers.php         # edit customer data
│
├── add_table.php              # add table
├── edit_table.php             # edit table
├── delete_table.php           # delete table
├── free_table.php             # free up a table
├── assign_table.php           # assign table to reservation
├── process_add_table.php      # handle add table form
└── process_edit_table.php     # handle edit table form
```

## Notes

This project was built as part of a group assignment (Group 10) for a web programming course. The database ERD can be found in `ERD.jpg`.
