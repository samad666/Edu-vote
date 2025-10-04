# Technology Stack

## Core Technologies
- **PHP**: Server-side scripting language (version not specified, modern PHP assumed)
- **MySQL 8.0**: Relational database management system
- **HTML5/CSS3**: Frontend markup and styling
- **JavaScript**: Client-side interactivity and AJAX

## Database
- **MySQL 8.0** with UTF8MB4 character set
- **Engine**: InnoDB for ACID compliance and foreign key support
- **Schema**: Includes users table with auto-increment IDs and timestamps

## Development Environment
- **Docker**: Containerized development with docker-compose
- **MySQL Container**: Official MySQL 8.0 image
- **Port Configuration**: MySQL on port 3306
- **Volume Persistence**: mysql_data volume for data persistence

## Frontend Libraries
- **Font Awesome**: Icon library for UI elements
- **Chart.js**: Data visualization and analytics charts
- **Custom CSS**: Responsive design with modern UI components

## Architecture Components
- **MVC Pattern**: Model-View-Controller architecture
- **Database Layer**: PDO/MySQLi for database interactions
- **Session Management**: PHP sessions for user authentication
- **Routing System**: Custom PHP routing implementation

## Development Commands
```bash
# Start development environment
docker-compose up -d

# Initialize database
php init_db.php

# Access application
http://localhost (configure web server)
```

## Configuration Files
- `includes/config.php`: Database connection settings
- `docker-compose.yml`: Container orchestration
- `database.sql`: Schema initialization