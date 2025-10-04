<?php
// models/candidates.php
require_once '../includes/config.php';

/**
 * Get candidates for a specific election
 */
function getCandidatesByElection($election_type) {
    global $conn;
    $sql = "SELECT c.*, s.full_name, s.email, s.class, s.photo 
            FROM candidates c 
            JOIN students s ON c.student_id = s.student_id 
            WHERE c.election_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $election_type);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Add candidate to election
 */
function addCandidate($election_id, $student_id) {
    global $conn;
    $sql = "INSERT INTO candidates (election_id, student_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $election_id, $student_id);
    return mysqli_stmt_execute($stmt);
}

/**
 * Remove candidate from election
 */
function removeCandidate($election_id, $student_id) {
    global $conn;
    $sql = "DELETE FROM candidates WHERE election_id = ? AND student_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $election_id, $student_id);
    return mysqli_stmt_execute($stmt);
}

/**
 * Get available students for candidacy (not already candidates)
 */
function getAvailableStudents($election_id, $class_id = null) {
    global $conn;
    $sql = "SELECT s.* FROM students s 
            WHERE s.student_id NOT IN (
                SELECT c.student_id FROM candidates c WHERE c.election_id = ?
            ) AND s.status = 'Active'";
    
    if ($class_id) {
        $sql .= " AND s.class_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $election_id, $class_id);
    } else {
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $election_id);
    }
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}