<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;

include('database.php');

if (isset($_POST['submit'])) {
    

    $academic_email = mysqli_real_escape_string($conn, $_POST['resend_email']);


    $query = "SELECT * FROM finance_clerk_registration_table WHERE email = '$academic_email'";

    $query_run = mysqli_query($conn, $query);

    $num = mysqli_num_rows($query_run);

    if ($num > 0) {
        
        $row = mysqli_fetch_array($query_run);
        
        $academic_status = $row['status'];

        if ($academic_status == 'registered') {
            
            exit('you have already registered');

        }else{

            $academic_email_code = substr(uniqid(), 7);
            $academic_email_token = rand(64228999, 90252082);

            $query_two = "UPDATE finance_clerk_registration_table SET email_code = '$academic_email_code', email_token = '$academic_email_token' WHERE email = '$academic_email'";

            $query_run_two = mysqli_query($conn, $query_two);

            if ($query_run_two) {
                
                $school_mail = "eduspringofgrace@gmail.com";
                $name = "email varification";
                $subject = "code to varified ur email before register as finance";
                $body = "copy this code  ".$academic_email_code." into space provide and continue the registration";
                $pwd = "08104322128";
                
                require_once "phpmailer/PHPMailer.php";
                require_once "phpmailer/SMTP.php";
                require_once "phpmailer/Exception.php";
                
                $mail = new PHPMailer();

                
                $mail->IsSMTP();  // telling the class to use SMTP
                //$mail->SMTPDebug = 2;
                $mail->Mailer = "smtp";
                $mail->Host = "ssl://smtp.gmail.com";
                //$mail->Port = 587;
                $mail->Port = 465;
                $mail->SMTPAuth = true; // turn on SMTP authentication
                
                $mail->Username = "eduspringofgrace@gmail.com"; // SMTP username
                $mail->Password = "qcygveozmfpfacjw"; // SMTP password
                
                $mail->AddAddress($academic_email);
                $mail->SetFrom($school_mail, $name);
                //$mail->AddReplyTo('akinyemisaheedwale@gmail.com');
                $mail->Subject  = $subject;
                $mail->Body     = $body;
                $mail->WordWrap = 50;

                if ($mail->send()) {
                    
                    header("location: ../finance_officer_email_verification.php?email_code=$academic_email_token");

                    

                }else{
                    
                    exit('fail to send code to your email please resend email....');
                }
            }

            

        }
        

    }else{

        exit('you not start any registration please....');


    }
}


?>