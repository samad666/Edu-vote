# Project Structure

## Directory Organization

### `/app/` - Application Core
- **`controllers/`**: Business logic handlers
  - `AuthController.php`: Authentication and authorization
  - `admin.controller.php`: Administrative operations
  - `DashboardController.php`: Dashboard data management
- **`models/`**: Data layer and database interactions
  - `User.php`: User entity and operations
  - `students.php`: Student data management
  - `classes.php`: Class management functions
  - `admins.php`: Administrative user operations
- **`views/`**: Presentation layer templates
  - Admin panels, forms, and detail pages
  - Student and class management interfaces
  - Authentication views (login, register)
- **`routes.php`**: URL routing and request handling

### `/includes/` - Shared Components
- `config.php`: Database and application configuration
- `Database.php`: Database connection and utilities
- `functions.php`: Common helper functions
- `header.php`, `footer.php`, `sidebar.php`: UI components

### `/public/` - Web Assets
- `assets/css/`: Stylesheets for admin and general UI
- `assets/js/`: JavaScript for interactive features
- `index.php`: Application entry point

### Root Configuration
- `database.sql`: Database schema and initial data
- `docker-compose.yml`: Container orchestration setup
- `init_db.php`: Database initialization script

## Architectural Pattern
**MVC (Model-View-Controller)** with clear separation of concerns:
- Models handle data persistence and business rules
- Views manage presentation and user interface
- Controllers coordinate between models and views
- Shared includes provide common functionality across components