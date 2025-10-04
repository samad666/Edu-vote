<?php
// Test token generator
require_once 'includes/config.php';

// Get a student from database
$student_sql = "SELECT student_id, full_name FROM students LIMIT 1";
$result = mysqli_query($conn, $student_sql);
$student = mysqli_fetch_assoc($result);

// Get an election
$election_sql = "SELECT id, name FROM elections LIMIT 1";
$election_result = mysqli_query($conn, $election_sql);
$election = mysqli_fetch_assoc($election_result);

if ($student && $election) {
    $student_id = $student['student_id'];
    $election_id = $election['id'];
    
    // Generate token (same logic as in vote.php)
    $token = md5($student_id . $election_id);
    
    echo "<h2>Test Voting Link</h2>";
    echo "<p><strong>Student:</strong> {$student['full_name']} ({$student_id})</p>";
    echo "<p><strong>Election:</strong> {$election['name']} (ID: {$election_id})</p>";
    echo "<p><strong>Token:</strong> {$token}</p>";
    echo "<br>";
    echo "<a href='/vote?electionId={$election_id}&token={$token}' target='_blank'>";
    echo "http://localhost:4000/vote?electionId={$election_id}&token={$token}";
    echo "</a>";
} else {
    echo "No students or elections found. Please create some test data first.";
}
?>