# Development Guidelines

## Code Quality Standards

### PHP Coding Conventions
- **Class Names**: PascalCase (e.g., `AuthController`, `Database`)
- **Method Names**: camelCase (e.g., `sanitizeInput`, `getConnection`)
- **File Names**: Match class names for controllers/models, lowercase for views
- **Indentation**: 4 spaces consistently used throughout codebase
- **Line Endings**: Windows CRLF format (\r\n)

### HTML/CSS Standards
- **CSS Classes**: BEM-style naming with double hyphens (e.g., `btn--primary`, `status--success`)
- **HTML Structure**: Semantic elements with proper nesting
- **Responsive Design**: Grid-based layouts with CSS custom properties
- **Icon Usage**: Font Awesome classes consistently applied

### JavaScript Patterns
- **Event Handling**: DOMContentLoaded wrapper for initialization
- **Element Selection**: getElementById and querySelector methods
- **Chart Integration**: Chart.js with responsive configuration
- **Navigation**: Hash-based routing with fallback to server routes

## Architectural Patterns

### MVC Implementation
- **Controllers**: Handle business logic and user input validation
- **Models**: Manage data operations with database abstraction
- **Views**: Pure presentation layer with embedded PHP for data display
- **Routing**: Centralized route configuration in `routes.php`

### Database Patterns
- **Singleton Pattern**: Database class uses singleton for connection management
- **PDO Usage**: Prepared statements with parameter binding for security
- **Error Handling**: Exception-based error management with logging
- **Connection Options**: Standardized PDO configuration with proper charset

### Security Practices
- **Input Sanitization**: `htmlspecialchars()` and `strip_tags()` for user input
- **SQL Injection Prevention**: Prepared statements with parameter binding
- **Session Management**: Proper session handling for authentication
- **Password Security**: Hashed password storage (implied in User model)

## Common Implementation Patterns

### Pagination Logic
```php
$perPage = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $perPage;
```

### Status Display Pattern
```php
<span class="status <?= $row['status'] === 'Active' ? 'status--success' : 'status--danger' ?>">
    <?= htmlspecialchars($row['status']) ?>
</span>
```

### File Include Pattern
```php
require_once __DIR__ . '/../models/modelName.php';
```

### Error Response Pattern
```php
return ['error' => "Error message"];
return ['success' => "Success message", 'redirect' => '/path'];
```

## UI/UX Conventions

### Button Styling
- Primary actions: `btn btn--primary`
- Secondary actions: `btn btn--outline`
- Icon buttons: `btn btn--icon`
- Size variants: `btn--sm`, `btn--full-width`

### Table Structure
- Responsive wrapper: `table-responsive`
- Consistent table class: `data-table`
- Action buttons in rightmost column
- Status indicators with semantic classes

### Navigation Patterns
- Data attributes for page identification: `data-page="pageName"`
- Active state management with CSS classes
- Breadcrumb navigation for context
- Sidebar toggle functionality

## Development Standards

### File Organization
- Controllers in `/app/controllers/`
- Models in `/app/models/`
- Views in `/app/views/`
- Shared components in `/includes/`
- Static assets in `/public/assets/`

### Error Handling
- Database errors logged with `error_log()`
- User-friendly error messages returned to views
- Graceful degradation for missing resources
- HTTP status codes for routing errors

### Performance Considerations
- Chart.js with `maintainAspectRatio: false` for responsive charts
- CSS custom properties for theme consistency
- Minimal JavaScript with efficient DOM manipulation
- Optimized database queries with proper indexing assumptions