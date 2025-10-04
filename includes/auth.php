<?php
/**
 * Authentication and authorization functions
 */

function requireLogin() {
    if (!isset($_SESSION['user_type'])) {
        header('Location: /login');
        exit;
    }
}

function requireSuperAdmin() {
    requireLogin();
    if ($_SESSION['user_type'] !== 'super_admin') {
        header('Location: /login');
        exit;
    }
}

function requireClassAdmin() {
    requireLogin();
    if ($_SESSION['user_type'] !== 'class_admin') {
        header('Location: /login');
        exit;
    }
}

function isSuperAdmin() {
    return isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'super_admin';
}

function isClassAdmin() {
    return isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'class_admin';
}

function getAdminClassIds($conn) {
    if (!isClassAdmin()) {
        return [];
    }
    
    $admin_id = $_SESSION['admin_id'];
    $sql = "SELECT id FROM class WHERE admin_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $admin_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $class_ids = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $class_ids[] = $row['id'];
    }
    
    return $class_ids;
}

function filterByAdminClasses($conn, $base_query, $class_id_column = 'class_id') {
    if (isSuperAdmin()) {
        return $base_query; // Super admin sees everything
    }
    
    if (isClassAdmin()) {
        $class_ids = getAdminClassIds($conn);
        if (empty($class_ids)) {
            return $base_query . " WHERE 1=0"; // No classes assigned
        }
        
        $class_ids_str = implode(',', array_map('intval', $class_ids));
        
        // Add WHERE clause or AND clause depending on existing query
        if (stripos($base_query, 'WHERE') !== false) {
            return $base_query . " AND $class_id_column IN ($class_ids_str)";
        } else {
            return $base_query . " WHERE $class_id_column IN ($class_ids_str)";
        }
    }
    
    return $base_query . " WHERE 1=0"; // Not authorized
}