# Smart Pet Service System — Pet Sitting Service Website

Student-oriented pet sitting demo built with **HTML, CSS, Bootstrap 5, JavaScript, PHP, and MySQL**. UI uses **gradients, glassmorphism, Font Awesome, Google Fonts (Plus Jakarta Sans), and AOS** scroll animations. Includes customer registration/login, protected pages with PHP sessions, booking and contact forms (PDO prepared statements), and a separate admin panel.

## Requirements

- PHP 8.0+ (with PDO MySQL extension)
- MySQL 5.7+ or MariaDB 10.3+
- A web server that runs PHP (Apache + mod_php, nginx + PHP-FPM, or PHP’s built-in server for local testing)

## Quick start

1. **Clone or copy** this project so the site root is the `pet-sitting` folder (or configure your virtual host to point at it).

2. **Create the database** by importing the schema:
   - phpMyAdmin: Import `db/schema.sql`, or
   - Command line:  
     `mysql -u root -p < db/schema.sql`

3. **Configure database credentials** in `db/database.php`:
   - `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`

4. **Open the site** in a browser (examples):
   - XAMPP/WAMP: `http://localhost/pet-sitting/`
   - PHP built-in server (from inside `pet-sitting`):  
     `php -S localhost:8080`  
     then visit `http://localhost:8080/`

## Default admin account

After importing `db/schema.sql`:

| Field    | Value      |
|----------|------------|
| Username | `admin`    |
| Password | `password` |

**Important:** Replace this password on any public or production server. Use `password_hash()` in a one-off script or update the `admins` row directly.

## Project structure

```
pet-sitting/
├── index.php          # Home
├── services.php       # Services (cards)
├── pricing.php        # Pricing (cards)
├── booking.php        # Booking form (requires login)
├── contact.php        # Contact form (public)
├── login.php          # User login
├── register.php       # User registration
├── dashboard.php      # User dashboard (protected)
├── logout.php         # Ends user session
├── css/
│   └── style.css
├── js/
│   └── animations.js  # AOS init, smooth anchors, page fade
├── db/
│   ├── database.php   # PDO connection + auto bootstrap tables
│   └── schema.sql     # Database setup
├── includes/
│   ├── header.php           # Sticky glass navbar + CDNs
│   ├── footer.php
│   ├── auth.php
│   ├── admin_auth.php
│   ├── admin_layout_start.php
│   └── admin_layout_end.php
└── admin/
    ├── admin_login.php
    ├── admin_logout.php
    └── admin_dashboard.php  # Users, bookings (delete), contacts
```

## Features

- **Responsive UI** with Bootstrap 5; pet imagery on the home page.
- **Users:** Register, login, bcrypt passwords, session-based access to dashboard and booking.
- **Protected pages:** `includes/auth.php` redirects guests to `login.php`; `includes/admin_auth.php` redirects to `admin/admin_login.php`.
- **Booking:** Logged-in users submit bookings stored with `user_id` and related fields (including phone).
- **Contact:** Public form; messages stored in `contacts`.
- **Admin:** View users, bookings, and contact messages; delete bookings via POST.

## Security notes (student scope)

- Passwords are hashed with `password_hash()` / verified with `password_verify()`.
- SQL uses **prepared statements** via PDO.
- Forms include server-side validation.
- Session regeneration on login is used where appropriate.

For production you would also add HTTPS, stricter CSRF protection on destructive actions, rate limiting, and environment-based configuration instead of hard-coded DB settings.

## Troubleshooting

| Issue | What to check |
|-------|----------------|
| Blank page or 500 error | PHP error log; enable `display_errors` temporarily in development only. |
| Database connection failed | `db/database.php` credentials; MySQL service running; database `pet_sitting_db` exists. |
| Admin login fails | Schema imported; correct username/password; no conflicting old `admins` row (see `INSERT IGNORE` in `schema.sql`). |
| Styles missing | Open the site from the `pet-sitting` URL path so `css/style.css` resolves correctly. |

## License

Educational / student project — use and modify freely for coursework.
