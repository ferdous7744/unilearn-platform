# Database Setup

This folder contains the MySQL database for the project.

- **File:** `education_platform.sql`
- **Database name:** `education_platform`
- **Charset:** `utf8mb4` (supports Arabic, French and English)

## Requirements

- XAMPP (Apache + MySQL) or any PHP + MySQL/MariaDB stack
- phpMyAdmin (included with XAMPP) or the MySQL command line

## Option 1: Import with phpMyAdmin (easiest)

1. Start **Apache** and **MySQL** from the XAMPP Control Panel.
2. Open `http://localhost/phpmyadmin`.
3. Click the **Import** tab.
4. Click **Choose File** and select `education_platform.sql`.
5. Leave the default settings and click **Import** at the bottom.
6. The database `education_platform` now appears in the left sidebar.

> If you get an error saying the database does not exist, create it first:
> click **New**, name it `education_platform`, choose collation `utf8mb4_unicode_ci`,
> click **Create**, select it, then repeat the Import steps.

## Option 2: Import with the command line

```bash
mysql -u root -p < database/education_platform.sql
```

If the file does not contain `CREATE DATABASE`, run this instead:

```bash
mysql -u root -p -e "CREATE DATABASE education_platform CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
mysql -u root -p education_platform < database/education_platform.sql
```

## Connect the project to the database

Open `conf/connection.php` (or copy `conf/connection.example.php` to `conf/connection.php`) and check these values:

```php
$host     = 'localhost';
$dbname   = 'education_platform';   // must match the imported database
$username = 'root';                 // default XAMPP user
$password = '';                     // default XAMPP password is empty
```

If your MySQL user or password is different, change them here.

> The public pages use `conf/conection.php` and the admin pages use `conf/connection.php`
> (different spelling). Make sure both files exist and contain the same settings.

## Image and file folders

Uploaded files are stored on disk and only their paths are saved in the database.
Make sure these folders exist inside `admin/`:

```
admin/sp_image/
admin/subject_images/
admin/user_image/
```

The sample data has no images, so "No image" appears until you upload some from the admin panel.

## Demo login

| Field    | Value                |
|----------|----------------------|
| Email    | admin@unilearn.test  |
| Password | admin123             |

Change this password before using the project for anything real.

## Database structure

| Table      | Purpose                                              |
|------------|------------------------------------------------------|
| `users`    | Admin and user accounts                              |
| `spc`      | Specialties                                          |
| `year`     | Academic years (L1, L2, L3)                          |
| `semester` | Semesters, linked to `year`                          |
| `subjects` | Modules, linked to `spc` and `semester`              |
| `contents` | Course files, videos and links, linked to `subjects` |
| `webinfo`  | Site info (objective, email, phone, social links)    |

## Troubleshooting

| Problem | Fix |
|---|---|
| `Connection failed: Unknown database` | The database was not imported, or `$dbname` does not match. |
| `Access denied for user 'root'` | Wrong username or password in `connection.php`. |
| `Table doesn't exist` | The import stopped early. Drop the database and import again. |
| Arabic or French text shows as `???` | Import using `utf8mb4` and set `$conn->set_charset('utf8mb4');`. |
| Import fails because the file is too large | Raise `upload_max_filesize` and `post_max_size` in `php.ini`, then restart Apache. |
thank you 
Ferdous Aouf
