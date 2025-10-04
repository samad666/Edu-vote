<?php
require_once __DIR__ . '/../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Send voting emails to students using PHPMailer
 */
function sendVotingEmails($election_id, $election_name, $class_id) {
    global $conn;
    
    // Get students from the class
    $students_sql = "SELECT student_id, full_name, email FROM students WHERE class_id = '$class_id' AND status = 'Active'";
    $students_result = mysqli_query($conn, $students_sql);
    
    $sent_count = 0;
    $failed_count = 0;
    
    while ($student = mysqli_fetch_assoc($students_result)) {
        // Generate voting token
        $token = md5($student['student_id'] . $election_id);
        
        // Create voting link
        $voting_link = "http://localhost:4000/vote?electionId=$election_id&token=$token";
        
        // Send email using PHPMailer
        $mail = new PHPMailer(true);
        
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'abdulsamadofficial666@gmail.com'; // Your Gmail
            $mail->Password   = 'tgsw bzhv capi gnfr';          // Your Gmail App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            
            // Recipients
            $mail->setFrom('abdulsamadofficial666@gmail.com', 'EduVote System');
            $mail->addAddress($student['email'], $student['full_name']);
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = "Vote Now: $election_name";
            $mail->Body = "
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .header { background: #4facfe; color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
                    .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px; }
                    .vote-button { display: inline-block; background: #4facfe; color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; font-weight: bold; margin: 20px 0; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h1>🗳️ EduVote</h1>
                        <h2>Your Vote Matters!</h2>
                    </div>
                    <div class='content'>
                        <h3>Hello " . htmlspecialchars($student['full_name']) . ",</h3>
                        <p>The election <strong>" . htmlspecialchars($election_name) . "</strong> has started!</p>
                        <p>You can now cast your vote by clicking the button below:</p>
                        <p style='text-align: center;'>
                            <a href='$voting_link' class='vote-button'>VOTE NOW</a>
                        </p>
                        <p><strong>Important:</strong></p>
                        <ul>
                            <li>This link is unique to you and should not be shared</li>
                            <li>You can only vote once</li>
                            <li>Your vote is completely confidential</li>
                        </ul>
                        <p>If you have any questions, please contact the election administrator.</p>
                    </div>
                </div>
            </body>
            </html>
            ";
            
            $mail->send();
            $sent_count++;
            error_log("Email sent successfully to: {$student['email']}");
            
        } catch (Exception $e) {
            $failed_count++;
            error_log("Email failed to {$student['email']}: {$mail->ErrorInfo}");
        }
    }
    
    return [
        'sent' => $sent_count,
        'failed' => $failed_count,
        'total' => $sent_count + $failed_count
    ];
}