<?php
// models/elections.php
require_once '../includes/config.php';

/**
 * Fetch elections with pagination
 */
function getElections($limit = 100, $offset = 0) {
    global $conn;
    $sql = "SELECT * FROM elections ORDER BY id DESC LIMIT ? OFFSET ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $limit, $offset);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Count total elections (for pagination)
 */
function getElectionCount() {
    global $conn;
    $sql = "SELECT COUNT(*) AS total FROM elections";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total'] ?? 0;
}

/**
 * Create new election
 */
function createElection($data) {
    global $conn;
    $sql = "INSERT INTO elections (type, scope, name, start_date, end_date, status, profile, class_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssss", 
        $data['type'], $data['scope'], $data['name'], 
        $data['start_date'], $data['end_date'], $data['status'], 
        $data['profile'], $data['class_id']
    );
    return mysqli_stmt_execute($stmt);
}