<?php
// models/admins.php
require_once '../includes/config.php';

/**
 * Fetch admins with pagination
 */
function getAdmins($limit = 100, $offset = 0) {
    global $conn;
    $sql = "SELECT * FROM admins ORDER BY id DESC LIMIT ? OFFSET ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $limit, $offset);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Count total admins (for pagination)
 */
function getAdminCount() {
    global $conn;
    $sql = "SELECT COUNT(*) AS total FROM admins";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total'] ?? 0;
}