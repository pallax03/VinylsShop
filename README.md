# Progetto web
Modificare le versioni e veder cosa usano in lab.

```bash
docker-compose up
```

Progetto/
├── docker-compose.yml       # File for configuring Docker services
├── htdocs/                  # Shared folder for Docker and XAMPP
│   ├── css/
│   │   └── styles.css        # Stylesheets
│   ├── js/
│   │   └── script.js         # JavaScript files
│   ├── images/
│   │   └── logo.png          # Images used in the site
│   ├── includes/
│   │   ├── header.php        # Common header across pages
│   │   ├── footer.php        # Common footer across pages
│   │   └── db.php            # MySQL database connection
│   ├── index.php             # Homepage
│   ├── about.php             # About page
│   └── contact.php           # Contact page
├── db_data/                  # Docker-managed MySQL data volume