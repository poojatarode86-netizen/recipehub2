
# RecipeHub — Pro Polish Build
Updated: 2025-08-23 17:53

## Quick Start
1) Create a database in phpMyAdmin named **recipehub**.
2) Import the SQL file: `recipehub.sql`.
3) Update DB creds if needed in `includes/db.php` (or use env vars `APP_DB_*`).
4) Place this folder in your PHP server root (e.g., `htdocs/RecipeHub`) and open `http://localhost/RecipeHub`.

## Credentials
- Register a new user from the Register page.
- Or in phpMyAdmin, create a user in `users` table (if present). Passwords should be created by the app via `password_hash` when you register.

## Notes
- Professional CSS at `public/css/style.css`.
- Image uploads go to `/uploads`. Ensure the folder is writable.
- Common components: `header.php`, `footer.php`, `includes/` helpers.
- Security: prepared statements, password hashing, session checks for protected pages.

## Troubleshooting
- **"Unknown database"** → Create DB **recipehub** and import `recipehub.sql` first.
- **Login not redirecting** → Ensure sessions enabled; check `includes/auth.php` and PHP errors log.
- **Images not showing** → Check `/uploads` permissions and file paths.

––
This build was standardized for consistency across the 6 projects.
