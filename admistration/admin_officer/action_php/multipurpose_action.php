<?php

    session_start();

    use PHPMailer\PHPMailer\PHPMailer;

    include('database.php');

    if (isset($_POST['action'])) {
        

        // admin officer login.............

        if ($_POST['action'] == 'admin officer login') {
            
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $user = mysqli_real_escape_string($conn, $_POST['user']);
            $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);

            $query = "SELECT * FROM admin_registration_table WHERE email = '$email' AND user_name = '$user'";
            $query_run = mysqli_query($conn, $query);

            $num = mysqli_num_rows($query_run);

            if ($num < 1) {
                
                echo 'your data is not found please';
            }else{

                $row = mysqli_fetch_array($query_run);
                
                $status = $row['status'];

                $hash_pwd = $row['pwd'];

                $check_pwd = password_verify($pwd, $hash_pwd);

                if (!$check_pwd) {
                    
                    echo 'incorrect password';
                }else{

                    if ($status != 'registered') {
                        
                        echo 'your email have not been verified.....';
                    }else{

                        $id_code = substr(uniqid(), 8);

                        $query_two = "UPDATE admin_registration_table SET id_code = '$id_code' WHERE email = '$email'";
                        $query_run_two = mysqli_query($conn, $query_two);

                        if ($query_run_two) {
                            
                            $school_mail = "walesaheed@gmail.com";
                            $name = "email varification";
                            $subject = "code to varified ur email before login as admin officer";
                            $body = "copy this code  ".$id_code." into space provided and login";
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

                            $mail->Username = "waleschool20@gmail.com"; // SMTP username
                            $mail->Password = "zhapmmvvohwucrwr"; // SMTP password
                            //$Mail->Priority = 1;
                            $mail->AddAddress($email);
                            $mail->SetFrom('akinyemisaheedwale@gmail.com');
                            //$mail->AddReplyTo('akinyemisaheedwale@gmail.com');
                            $mail->Subject  = $subject;
                            $mail->Body     = $body;
                            $mail->WordWrap = 50;

                            if ($mail->send()) {

                                $_SESSION['admin_login_email'] = $email;
                                
                                echo 'send';
                                

                            }else{
                                
                                echo 'please resend your detail';
                            }
                        }

                    }

                }
            }
        }





        // admin officer idcode verification.................

        if ($_POST['action'] == 'admin officer idcode verification') {
            
            $id_code = mysqli_real_escape_string($conn, $_POST['id_code']);
            $email = $_SESSION['admin_login_email'];
            
            $query = "SELECT * FROM admin_registration_table WHERE email = '$email' AND id_code = '$id_code' AND status = 'registered'";
            $query_run = mysqli_query($conn, $query);

            $num = mysqli_num_rows($query_run);

            if ($num < 1) {
                
                echo 'incorrect ID code';
            }else{

                $_SESSION['admin_id_code'] = $id_code;
                echo 'verify';
            }
        }





        

        // student detail deleting......................................................

        if ($_POST['action'] == 'deleting student registration detail') {
            
            $id = $_POST['id'];

            $query_two = "SELECT * FROM student_registration_table WHERE id = '$id'";
            $query_run_two = mysqli_query($conn, $query_two);

            $num_two = mysqli_num_rows($query_run_two);

            if ($num_two > 0) {
                
                $row_two = mysqli_fetch_array( $query_run_two);

                $image = $row_two['image'];

                $image_path = '../../../image/student/'.$image;

                if ($image_path) {
                    
                    unlink($image_path);
                
            
            
                    $query = "DELETE FROM student_registration_table WHERE id = '$id'";
                    $query_run = mysqli_query($conn, $query);

                    if ($query_run) {
                        echo 'deleted';
                    }else{
                        echo 'data fail to delete';
                    }

                }

            }
        }




        // single student datails deleting..........................................................

        if ($_POST['action'] == 'delete single student detail') {
            
            $addmission_number = mysqli_real_escape_string($conn, $_POST['addmission_number']);

            $query = "SELECT * FROM student_registration_table WHERE addmission_num = '$addmission_number'";
            $query_run = mysqli_query($conn, $query);

            $num = mysqli_num_rows($query_run);

            if ($num < 1) {
                
                echo 'incorrect addmission number';
            }else{

                $row = mysqli_fetch_array($query_run);
                
                $image = $row['image'];

                $image_path = '../../../image/student/'.$image;

                if ($image_path) {

                    unlink($image_path);
                
                    $query_two = "DELETE FROM student_registration_table WHERE addmission_num = '$addmission_number'";
                    $query_run_two = mysqli_query($conn, $query_two);

                    if ($query_run_two) {
                        
                        echo 'data successfully deleted';
                    }else{
                        echo 'data fail to delete';
                    }

                }else{

                    echo 'incorrect old image paths';
                }
            }
        }





        // deleting staff detail from database.......................................................................

        if ($_POST['action'] == 'deleting staff detail') {
            
            $id = $_POST['id'];

            $query_two = "SELECT * FROM staff_registration_table WHERE id = '$id'";
            $query_run_two = mysqli_query($conn, $query_two);

            $num_two = mysqli_num_rows($query_run_two);

            if ($num_two > 0) {
                
                $row_two = mysqli_fetch_array($query_run_two);

                $image = $row_two['image'];

                $image_path = '../image/'.$image;

                if ($image_path) {
                    unlink($image_path);
                
                    $query = "DELETE FROM staff_registration_table WHERE id = '$id'";
                    $query_run = mysqli_query($conn, $query);

                    if ($query_run) {
                        
                        echo 'data successfully deleted';
                    }else{
                        echo 'data fail to delete';
                    }

                }

            }
        }






        // single student class insertion............................

        if ($_POST['action'] == 'insert single student to class') {
            
            $addmission_number = mysqli_real_escape_string($conn, $_POST['addmission_number']);
            $classes = mysqli_real_escape_string($conn, $_POST['classes']);
            $session = mysqli_real_escape_string($conn, $_POST['session']);
            $term = mysqli_real_escape_string($conn, $_POST['term']);

            $session_reg = "/^([0-9]{4})\/([0-9]{4})$/";

            if (!preg_match($session_reg, $session)) {
                
                echo 'incorrect session';
            }else{

                $query = "SELECT * FROM student_registration_table WHERE addmission_num = '$addmission_number'";
                $query_run = mysqli_query($conn, $query);

                $num = mysqli_num_rows($query_run);

                if ($num < 1) {
                    
                    echo 'invalid';
                }else{

                    $row = mysqli_fetch_array($query_run);
                    
                    $surname = $row['surname'];
                    $first_name = $row['first_name'];
                    $other_name = $row['other_name'];
                    $status = $row['status'];

                    if ($status != 'active') {
                        
                        echo 'not registered';
                    }else{

                        $array = array($classes, $term, 'term', 'table');

                        $table = implode('_', $array);
                        
                        $query_two = "SELECT * FROM $table WHERE addmission_number = '$addmission_number' AND academic_session = '$session'";
                        $query_run_two = mysqli_query($conn, $query_two);

                        $num_two = mysqli_num_rows($query_run_two);

                        if ($num_two > 0) {
                            
                            echo 'data already exist';
                        }else{

                            $query_tree = "INSERT INTO $table (addmission_number, surname, first_name, other_name, term, academic_session) VALUES ('$addmission_number', '$surname', '$first_name', '$other_name', '$term', '$session')";
                            
                            $query_run_tree = mysqli_query($conn, $query_tree);

                            if ($query_tree) {
                                
                                echo 'inseted';
                            }else{
                                echo 'fail to insert';
                            }
                        }
                        
                    }
                }
            }
        }







        // multiple studemt class insertion.............................

        if ($_POST['action'] == 'insert multiple student class') {
            
            $prev_session = mysqli_real_escape_string($conn, $_POST['prev_session']);
            $prev_class = mysqli_real_escape_string($conn, $_POST['prev_class']);
            $next_session = mysqli_real_escape_string($conn, $_POST['next_session']);
            $next_class = mysqli_real_escape_string($conn, $_POST['next_class']);
            $term = mysqli_real_escape_string($conn, $_POST['term']);

            $session_reg = "/^([0-9]{4})\/([0-9]{4})$/";


            if (!preg_match($session_reg, $prev_session)) {
                
                echo 'invalid prev academy session';
            }else{

                if (!preg_match($session_reg, $next_session)) {
                    
                    echo 'invalid next academy session';
                }else{

                    $explod_prev_session = explode('/', $prev_session);
                    $prev_front_session = $explod_prev_session[0];
                    $prev_year = end($explod_prev_session);

                    $explod_next_session = explode('/', $next_session);
                    $next_front_session = $explod_next_session[0];
                    $next_year = end($explod_next_session);

                    if ((($next_year - $prev_year) != 1) || (($next_front_session - $prev_front_session) != 1)) {
                        
                        echo 'the two sessions must not be thesame and next session must be greater than prev session by 1';
                    }else{

                        $prev_array = array($prev_class, $term, 'term', 'table');
                        $prev_class_table = implode('_', $prev_array);

                        $next_array = array($next_class, $term, 'term', 'table');
                        $next_class_table = implode('_', $next_array);

                        $query = "SELECT * FROM $next_class_table WHERE academic_session = '$next_session'";
                        $query_run = mysqli_query($conn, $query);

                        $num = mysqli_num_rows($query_run);

                        if ($num > 0) {
                            
                            echo 'student already existing in next academy session';
                        }else{

                            $query_two = "SELECT * FROM $prev_class_table WHERE academic_session = '$prev_session'";
                            $query_run_two = mysqli_query($conn, $query_two);

                            $num_two = mysqli_num_rows($query_run_two);

                            if ($num_two < 1) {
                                
                                echo 'no such previous academy session exist';
                            }else{

                                while ($row = mysqli_fetch_array($query_run_two)) {
                                    
                                    $addmission_number = $row['addmission_number'];
                                    $surname = $row['surname'];
                                    $first_name = $row['first_name'];
                                    $other_name = $row['other_name'];

                                    $query_tree = "SELECT * FROM student_registration_table WHERE addmission_num = '$addmission_number'";
                                    $query_run_tree = mysqli_query($conn, $query_tree);

                                    $num_tree = mysqli_num_rows($query_run_tree);

                                    if ($num_tree > 0) {
                                        
                                        $row_tre = mysqli_fetch_array($query_run_tree);

                                        $status = $row_tre['status'];

                                        if ($status == 'active') {
                                            
                                            $query_four = "INSERT INTO $next_class_table (addmission_number, surname, first_name, other_name, term, academic_session) VALUES ('$addmission_number', '$surname', '$first_name', '$other_name', '$term', '$next_session')";

                                            $query_run_four = mysqli_query($conn, $query_four);
                                        }
                                    }

                        
                                }

                                if ($query_run_four) {
                                        
                                    echo 'inserted';
                                }else{
                                    
                                    echo 'data fail to insert';
                                }
                            }
                        }
                    }

                }
            }
        }





        // deleting student from class......................

        if ($_POST['action'] == 'delete student from class') {
            
            $id = $_POST['id'];
            $term = $_POST['term'];
            $class = $_POST['classes'];

            $array = array($class, $term, 'term', 'table');
            $class_table = implode('_', $array);
            
            $query = "DELETE FROM $class_table WHERE id = '$id'";
            $query_run = mysqli_query($conn, $query);

            if ($query_run) {
                
                echo 'data sucessfully deleteed and refresh ur browser';
            }else{

                echo 'fail to delete';
            }
        }








        // editing staff daily attendance ..................................................


        if ($_POST['action'] == 'edit staff daily attendance') {
            
            $id = $_POST['id'];
            $attendance = mysqli_real_escape_string($conn, $_POST['attendance']);

            $query = "UPDATE staff_attendance_table SET attendance = '$attendance' WHERE id = '$id'";
            $query_run = mysqli_query($conn, $query);

            if ($query_run) {
                
                echo 'data successfully updated';
            }

        }





        


        // deleting student attendance from data base..............................................

        if ($_POST['action'] == 'delete student attendance creation') {
            
            $id = $_POST['id'];
            
            $query = "DELETE FROM student_attendance_creation_table WHERE id = '$id'";
            $query_run = mysqli_query($conn, $query);

            if ($query_run) {
                
                echo 'data successfully deleted';
            }else{

                echo 'data fail to delete';
            }
        }




        
        // admin officer reset password...............


        if ($_POST['action'] == 'admin officer reset password') {
            
            $code = mysqli_real_escape_string($conn, $_POST['code']);
            $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
            $confirm_pwd = mysqli_real_escape_string($conn, $_POST['confirm_pwd']);
            $token = mysqli_real_escape_string($conn, $_POST['token']);

            $hash_pwd = password_hash($pwd, PASSWORD_DEFAULT);


            $query = "SELECT * FROM admin_registration_table WHERE pwd_code = '$code' AND pwd_token = '$token'";
            $query_run = mysqli_query($conn, $query);

            $num = mysqli_num_rows($query_run);

            if ($num > 0) {
                
                $query_two = "UPDATE admin_registration_table SET pwd = '$hash_pwd' WHERE pwd_code = '$code' AND pwd_token = '$token'";
                $query_run_two = mysqli_query($conn, $query_two);

                if ($query_run_two) {
                    
                    echo 'updated';
                }else{

                    echo 'password fail to reset try again.....';
                }

            }else{

                echo 'incorrect code';
            }
        }



        




        // formmaster/formistress email verification????????????????????????????????????

        if ($_POST['action'] == 'formaster/formistress email verify') {
            
            $email_code = mysqli_real_escape_string($conn, $_POST['email_code']);

            $email_token = mysqli_real_escape_string($conn, $_POST['email_token']);

            $query_two = "SELECT * FROM student_attendance_creation_table WHERE email_token = '$email_token'";
            $query_run_two = mysqli_query($conn, $query_two);

            $num_two = mysqli_num_rows($query_run_two);

            if ($num_two < 0) {
                
                echo 'invalid id code';
            }else {

               
                
                $row_two = mysqli_fetch_array($query_run_two);

                $email_status = $row_two['email_status'];

                $email_code_from = $row_two['email_code'];

                if ($email_code != $email_code_from) {
                    

                    echo 'inalid code';
                }else {
                    
            

                    if ($email_status == 'verified') {
                        
                        echo 'email already verified';

                    }else {
                        

                        $query = "UPDATE student_attendance_creation_table SET email_status = 'verified', attendance_status = 'open' WHERE email_code = '$email_code' AND email_token = '$email_token'";

                        $query_run = mysqli_query($conn, $query);

                        if ($query_run) {
                            
                                echo 'success';
                        }else{

                                echo 'fail to verified';
                        }

                    }
                    
                }
                    

                
            }


        }




        // student pin generation ::::::::::::::::::::::::::::::::::::::::::::


        /*if (isset($_POST['action']) == 'student pin generation') {
            
            $addmission_num = mysqli_real_escape_string($conn, $_POST['addmission_num']);

            $pwd_generate = substr(uniqid(true), 8);
            
            $pwd = password_hash($pwd_generate, PASSWORD_DEFAULT);

            $query = "UPDATE student_registration_table SET pwd = '$pwd' WHERE addmission_num = '$addmission_num'";
            $query_run = mysqli_query($conn, $query);

            if ($query_run) {
                
                echo $pwd_generate;
            }else {
                
                echo 'error';
            }
            
        }*/



        // school class creation ????????????

        /*if ($_POST['action'] == 'class registration') {
            
            $class = mysqli_real_escape_string($conn, $_POST['classe']);
            $category = mysqli_real_escape_string($conn, $_POST['category']);
            $school = mysqli_real_escape_string($conn, $_POST['school']);

            if ($school == 'secondary') {
                
            

                $query = "SELECT * FROM class_category_table WHERE class = '$class'";
                $query_run = mysqli_query($conn, $query);

                $num =  mysqli_num_rows($query_run);

                if ($num > 0) {
                    
                    $output = 'class already created';
                }else {
                    
                    $query_two = "INSERT INTO class_category_table (class, category) VALUES('$class', '$category')";
                    $query_run_two = mysqli_query($conn, $query_two);

                    if ($query_run_two) {

                        
                        if ($category == 'junior') {

                            // class exam table cretion ::::::::::::

                            $arry_two = array($class, 'exam', 'table');
                            $class_exam_table = implode('_', $arry_two);

                            $query_four = "CREATE TABLE $class_exam_table(

                                id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                                name VARCHAR(255) NOT NULL,
                                addmission_num VARCHAR(255) NOT NULL,
                                session VARCHAR(255) NOT NULL,
                                term VARCHAR(255) NOT NULL,

                                eng INT(99) NOT NULL,
                                rel INT(99) NOT NULL,
                                bus INT(99) NOT NULL,
                                lan INT(99) NOT NULL,
                                cca INT(99) NOT NULL,
                                kin INT(99) NOT NULL,

                                sos INT(99) NOT NULL,
                                mat INT(99) NOT NULL,
                                b_s INT(99) NOT NULL,
                                h_e INT(99) NOT NULL,
                                agri INT(99) NOT NULL,
                                gam INT(99) NOT NULL,

                                civ INT(99) NOT NULL,
                                phe INT(99) NOT NULL,
                                b_t INT(99) NOT NULL,
                                com INT(99) NOT NULL,
                                a_c INT(99) NOT NULL,
                                woo INT(99) NOT NULL,


                                f_eng INT(99) NOT NULL,
                                f_rel INT(99) NOT NULL,
                                f_bus INT(99) NOT NULL,
                                f_lan INT(99) NOT NULL,
                                f_cca INT(99) NOT NULL,
                                f_kin INT(99) NOT NULL,

                                f_sos INT(99) NOT NULL,
                                f_mat INT(99) NOT NULL,
                                f_b_s INT(99) NOT NULL,
                                f_h_e INT(99) NOT NULL,
                                f_agri INT(99) NOT NULL,
                                f_gam INT(99) NOT NULL,

                                f_civ INT(99) NOT NULL,
                                f_phe INT(99) NOT NULL,
                                f_b_t INT(99) NOT NULL,
                                f_com INT(99) NOT NULL,
                                f_a_c INT(99) NOT NULL,
                                f_woo INT(99) NOT NULL,


                                s_eng INT(99) NOT NULL,
                                s_rel INT(99) NOT NULL,
                                s_bus INT(99) NOT NULL,
                                s_lan INT(99) NOT NULL,
                                s_cca INT(99) NOT NULL,
                                s_kin INT(99) NOT NULL,

                                s_sos INT(99) NOT NULL,
                                s_mat INT(99) NOT NULL,
                                s_b_s INT(99) NOT NULL,
                                s_h_e INT(99) NOT NULL,
                                s_agri INT(99) NOT NULL,
                                s_gam INT(99) NOT NULL,

                                s_civ INT(99) NOT NULL,
                                s_phe INT(99) NOT NULL,
                                s_b_t INT(99) NOT NULL,
                                s_com INT(99) NOT NULL,
                                s_a_c INT(99) NOT NULL,
                                s_woo INT(99) NOT NULL,

                                t_eng INT(99) NOT NULL,
                                t_rel INT(99) NOT NULL,
                                t_bus INT(99) NOT NULL,
                                t_lan INT(99) NOT NULL,
                                t_cca INT(99) NOT NULL,
                                t_kin INT(99) NOT NULL,

                                t_sos INT(99) NOT NULL,
                                t_mat INT(99) NOT NULL,
                                t_b_s INT(99) NOT NULL,
                                t_h_e INT(99) NOT NULL,
                                t_agri INT(99) NOT NULL,
                                t_gam INT(99) NOT NULL,

                                t_civ INT(99) NOT NULL,
                                t_phe INT(99) NOT NULL,
                                t_b_t INT(99) NOT NULL,
                                t_com INT(99) NOT NULL,
                                t_a_c INT(99) NOT NULL,
                                t_woo INT(99) NOT NULL,

                                

                                to_eng INT(99) NOT NULL,
                                to_rel INT(99) NOT NULL,
                                to_bus INT(99) NOT NULL,
                                to_lan INT(99) NOT NULL,
                                to_cca INT(99) NOT NULL,
                                to_kin INT(99) NOT NULL,

                                to_sos INT(99) NOT NULL,
                                to_mat INT(99) NOT NULL,
                                to_b_s INT(99) NOT NULL,
                                to_h_e INT(99) NOT NULL,
                                to_agri INT(99) NOT NULL,
                                to_gam INT(99) NOT NULL,

                                to_civ INT(99) NOT NULL,
                                to_phe INT(99) NOT NULL,
                                to_b_t INT(99) NOT NULL,
                                to_com INT(99) NOT NULL,
                                to_a_c INT(99) NOT NULL,
                                to_woo INT(99) NOT NULL,

                                total_score INT(99) NOT NULL,
                                status VARCHAR(255) NOT NULL
                                
                            )";

                            $query_run_four = mysqli_query($conn, $query_four);



                            // class first term ca table creation ::::::::::::::::::::::::::::::::::

                            $array_three = array($class, 'first', 'term', 'ca', 'table');

                            $class_first_term_ca_table = implode('_', $array_three);

                            $query_five = "CREATE TABLE $class_first_term_ca_table(

                                id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                                name VARCHAR(255) NOT NULL,
                                addmission_num VARCHAR(255) NOT NULL,
                                session VARCHAR(255) NOT NULL,
                                ca VARCHAR(255) NOT NULL,

                                eng INT(99) NOT NULL,
                                rel INT(99) NOT NULL,
                                bus INT(99) NOT NULL,
                                lan INT(99) NOT NULL,
                                cca INT(99) NOT NULL,
                                kin INT(99) NOT NULL,

                                sos INT(99) NOT NULL,
                                mat INT(99) NOT NULL,
                                b_s INT(99) NOT NULL,
                                h_e INT(99) NOT NULL,
                                agri INT(99) NOT NULL,
                                gam INT(99) NOT NULL,

                                civ INT(99) NOT NULL,
                                phe INT(99) NOT NULL,
                                b_t INT(99) NOT NULL,
                                com INT(99) NOT NULL,
                                a_c INT(99) NOT NULL,
                                woo INT(99) NOT NULL,

                                total_score INT(99) NOT NULL,

                                status VARCHAR(255) NOT NULL


                            )";

                            $query_run_five = mysqli_query($conn, $query_five);



                            // class second term ca table creation :::::::::::

                            $array_six = array($class, 'second', 'term', 'ca', 'table');

                            $class_second_term_ca_term_table = implode('_', $array_six);


                            $query_eight = "CREATE TABLE $class_second_term_ca_term_table(

                                id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                                name VARCHAR(255) NOT NULL,
                                addmission_num VARCHAR(255) NOT NULL,
                                session VARCHAR(255) NOT NULL,
                                ca VARCHAR(255) NOT NULL,

                                eng INT(99) NOT NULL,
                                rel INT(99) NOT NULL,
                                bus INT(99) NOT NULL,
                                lan INT(99) NOT NULL,
                                cca INT(99) NOT NULL,
                                kin INT(99) NOT NULL,

                                sos INT(99) NOT NULL,
                                mat INT(99) NOT NULL,
                                b_s INT(99) NOT NULL,
                                h_e INT(99) NOT NULL,
                                agri INT(99) NOT NULL,
                                gam INT(99) NOT NULL,

                                civ INT(99) NOT NULL,
                                phe INT(99) NOT NULL,
                                b_t INT(99) NOT NULL,
                                com INT(99) NOT NULL,
                                a_c INT(99) NOT NULL,
                                woo INT(99) NOT NULL,

                                total_score INT(99) NOT NULL,

                                status VARCHAR(255) NOT NULL

                            )";

                            $query_run_eight = mysqli_query($conn, $query_eight);

                            
                            // class third term ca table creation ::::::::

                            $array_eight = array($class, 'third', 'term', 'ca', 'table');

                            $class_third_term_ca_table = implode('_', $array_eight);

                            $query_ten = "CREATE TABLE $class_third_term_ca_table(

                                id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                                name VARCHAR(255) NOT NULL,
                                addmission_num VARCHAR(255) NOT NULL,
                                session VARCHAR(255) NOT NULL,
                                ca VARCHAR(255) NOT NULL,

                                eng INT(99) NOT NULL,
                                rel INT(99) NOT NULL,
                                bus INT(99) NOT NULL,
                                lan INT(99) NOT NULL,
                                cca INT(99) NOT NULL,
                                kin INT(99) NOT NULL,

                                sos INT(99) NOT NULL,
                                mat INT(99) NOT NULL,
                                b_s INT(99) NOT NULL,
                                h_e INT(99) NOT NULL,
                                agri INT(99) NOT NULL,
                                gam INT(99) NOT NULL,

                                civ INT(99) NOT NULL,
                                phe INT(99) NOT NULL,
                                b_t INT(99) NOT NULL,
                                com INT(99) NOT NULL,
                                a_c INT(99) NOT NULL,
                                woo INT(99) NOT NULL,

                                total_score INT(99) NOT NULL,

                                status VARCHAR(255) NOT NULL

                            )";

                            $query_run_ten = mysqli_query($conn, $query_ten);

                                
                        }else {


                            
                            // class exam table cretion ::::::::::::

                            $arry_two = array($class, 'exam', 'table');
                            $class_exam_table = implode('_', $arry_two);

                            $query_four = "CREATE TABLE $class_exam_table(

                                id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                                name VARCHAR(255) NOT NULL,
                                addmission_num VARCHAR(255) NOT NULL,
                                session VARCHAR(255) NOT NULL,
                                term VARCHAR(255) NOT NULL,

                                eng INT(99) NOT NULL,
                                rel INT(99) NOT NULL,
                                ent INT(99) NOT NULL,
                                phy INT(99) NOT NULL,
                                che INT(99) NOT NULL,

                                bio INT(99) NOT NULL,
                                mat INT(99) NOT NULL,
                                f_m INT(99) NOT NULL,
                                eco INT(99) NOT NULL,
                                agri INT(99) NOT NULL,

                                geo INT(99) NOT NULL,
                                com INT(99) NOT NULL,
                                civ INT(99) NOT NULL,



                                f_eng INT(99) NOT NULL,
                                f_rel INT(99) NOT NULL,
                                f_ent INT(99) NOT NULL,
                                f_phy INT(99) NOT NULL,
                                f_che INT(99) NOT NULL,

                                f_bio INT(99) NOT NULL,
                                f_mat INT(99) NOT NULL,
                                f_f_m INT(99) NOT NULL,
                                f_eco INT(99) NOT NULL,
                                f_agri INT(99) NOT NULL,

                                f_geo INT(99) NOT NULL,
                                f_com INT(99) NOT NULL,
                                f_civ INT(99) NOT NULL,



                                s_eng INT(99) NOT NULL,
                                s_rel INT(99) NOT NULL,
                                s_ent INT(99) NOT NULL,
                                s_phy INT(99) NOT NULL,
                                s_che INT(99) NOT NULL,

                                s_bio INT(99) NOT NULL,
                                s_mat INT(99) NOT NULL,
                                s_f_m INT(99) NOT NULL,
                                s_eco INT(99) NOT NULL,
                                s_agri INT(99) NOT NULL,

                                s_geo INT(99) NOT NULL,
                                s_com INT(99) NOT NULL,
                                s_civ INT(99) NOT NULL,



                                t_eng INT(99) NOT NULL,
                                t_rel INT(99) NOT NULL,
                                t_ent INT(99) NOT NULL,
                                t_phy INT(99) NOT NULL,
                                t_che INT(99) NOT NULL,

                                t_bio INT(99) NOT NULL,
                                t_mat INT(99) NOT NULL,
                                t_f_m INT(99) NOT NULL,
                                t_eco INT(99) NOT NULL,
                                t_agri INT(99) NOT NULL,

                                t_geo INT(99) NOT NULL,
                                t_com INT(99) NOT NULL,
                                t_civ INT(99) NOT NULL,



                                to_eng INT(99) NOT NULL,
                                to_rel INT(99) NOT NULL,
                                to_ent INT(99) NOT NULL,
                                to_phy INT(99) NOT NULL,
                                to_che INT(99) NOT NULL,

                                to_bio INT(99) NOT NULL,
                                to_mat INT(99) NOT NULL,
                                to_f_m INT(99) NOT NULL,
                                to_eco INT(99) NOT NULL,
                                to_agri INT(99) NOT NULL,

                                to_geo INT(99) NOT NULL,                        
                                to_com INT(99) NOT NULL,
                                to_civ INT(99) NOT NULL,

                                total_score INT(99) NOT NULL,
                                status VARCHAR(255) NOT NULL
                                
                            )";

                            $query_run_four = mysqli_query($conn, $query_four);



                            // class first term ca table creation ::::::::::::::::::::::::::::::::::

                            $array_three = array($class, 'first', 'term', 'ca', 'table');

                            $class_first_term_ca_table = implode('_', $array_three);

                            $query_five = "CREATE TABLE $class_first_term_ca_table(

                                id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                                name VARCHAR(255) NOT NULL,
                                addmission_num VARCHAR(255) NOT NULL,
                                session VARCHAR(255) NOT NULL,
                                ca VARCHAR(255) NOT NULL,

                                eng INT(99) NOT NULL,
                                rel INT(99) NOT NULL,
                                ent INT(99) NOT NULL,
                                phy INT(99) NOT NULL,
                                che INT(99) NOT NULL,

                                bio INT(99) NOT NULL,
                                mat INT(99) NOT NULL,
                                f_m INT(99) NOT NULL,
                                eco INT(99) NOT NULL,
                                agri INT(99) NOT NULL,

                                geo INT(99) NOT NULL,
                                com INT(99) NOT NULL,
                                civ INT(99) NOT NULL,

                                total_score INT(99) NOT NULL,

                                status VARCHAR(255) NOT NULL


                            )";

                            $query_run_five = mysqli_query($conn, $query_five);



                            // class second term ca table creation :::::::::::

                            $array_six = array($class, 'second', 'term', 'ca', 'table');

                            $class_second_term_ca_term_table = implode('_', $array_six);


                            $query_eight = "CREATE TABLE $class_second_term_ca_term_table(

                                id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                                name VARCHAR(255) NOT NULL,
                                addmission_num VARCHAR(255) NOT NULL,
                                session VARCHAR(255) NOT NULL,
                                ca VARCHAR(255) NOT NULL,

                                eng INT(99) NOT NULL,
                                rel INT(99) NOT NULL,
                                ent INT(99) NOT NULL,
                                phy INT(99) NOT NULL,
                                che INT(99) NOT NULL,

                                bio INT(99) NOT NULL,
                                mat INT(99) NOT NULL,
                                f_m INT(99) NOT NULL,
                                eco INT(99) NOT NULL,
                                agri INT(99) NOT NULL,

                                geo INT(99) NOT NULL,
                                com INT(99) NOT NULL,
                                civ INT(99) NOT NULL,

                                total_score INT(99) NOT NULL,

                                status VARCHAR(255) NOT NULL

                            )";

                            $query_run_eight = mysqli_query($conn, $query_eight);

                            
                            // class third term ca table creation ::::::::

                            $array_eight = array($class, 'third', 'term', 'ca', 'table');

                            $class_third_term_ca_table = implode('_', $array_eight);

                            $query_ten = "CREATE TABLE $class_third_term_ca_table(

                                id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                                name VARCHAR(255) NOT NULL,
                                addmission_num VARCHAR(255) NOT NULL,
                                session VARCHAR(255) NOT NULL,
                                ca VARCHAR(255) NOT NULL,

                                eng INT(99) NOT NULL,
                                rel INT(99) NOT NULL,
                                ent INT(99) NOT NULL,
                                phy INT(99) NOT NULL,
                                che INT(99) NOT NULL,

                                bio INT(99) NOT NULL,
                                mat INT(99) NOT NULL,
                                f_m INT(99) NOT NULL,
                                eco INT(99) NOT NULL,
                                agri INT(99) NOT NULL,

                                geo INT(99) NOT NULL,
                                com INT(99) NOT NULL,
                                civ INT(99) NOT NULL,
                                
                                total_score INT(99) NOT NULL,

                                status VARCHAR(255) NOT NULL

                            )";

                            $query_run_ten = mysqli_query($conn, $query_ten);

                            
                            
                        }
                            
                        
                        $array_one = array($class, 'attendance', 'table');
                        $class_attendance = implode('_', $array_one);

                        // create class attendance table::::::::::::::::::::::

                        $query_three = "CREATE TABLE $class_attendance(

                            id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                            name VARCHAR(255) NOT NULL,
                            addmission_num VARCHAR(255) NOT NULL,

                            attendance_status VARCHAR(255) NOT NULL,
                            formaster_name VARCHAR(255) NOT NULL,
                            term VARCHAR(255) NOT NULL,

                            session VARCHAR(255) NOT NULL,
                            date VARCHAR(255) NOT NULL

                        )";

                        $query_run_three = mysqli_query($conn, $query_three);


                        // class first term table creation :::::::::::::::


                        $array_four = array($class, 'first', 'term', 'table');

                        $class_first_term_table = implode('_', $array_four);

                        $query_six = "CREATE TABLE $class_first_term_table (

                            id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                            addmission_number VARCHAR(255) NOT NULL,
                            surname VARCHAR(255) NOT NULL,
                            first_name VARCHAR(255) NOT NULL,
                            other_name VARCHAR(255) NOT NULL,

                            term VARCHAR(255) NOT NULL,
                            academic_session VARCHAR(255) NOT NULL

                        )";

                        $query_run_six = mysqli_query($conn, $query_six);



                        // class payment table creaton:::::::::::::


                        $array_five = array($class, 'payment', 'table');

                        $class_payment_table = implode('_', $array_five);

                        $query_seven = "CREATE TABLE $class_payment_table (

                            id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                            name VARCHAR(255) NOT NULL,
                            addmission_num VARCHAR(255) NOT NULL,
                            term VARCHAR(255) NOT NULL,
                            session VARCHAR(255) NOT NULL,

                            amount INT(99) NOT NULL, 
                            amount_paid INT(99) NOT NULL, 
                            balance INT(99) NOT NULL, 
                            date VARCHAR(255) NOT NULL,
                            user_name VARCHAR(255) NOT NULL,

                            voucher_num VARCHAR(255) NOT NULL
                        
                        )";

                        $query_run_seven = mysqli_query($conn, $query_seven);


                        // class second term table creation ::::::::::::::::

                        $array_seven = array($class, 'second', 'term', 'table');

                        $class_second_term_table = implode('_', $array_seven);
                        
                        $query_nine = "CREATE TABLE $class_second_term_table(

                            id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                            addmission_number VARCHAR(255) NOT NULL,
                            surname VARCHAR(255) NOT NULL,
                            first_name VARCHAR(255) NOT NULL,
                            other_name VARCHAR(255) NOT NULL,

                            term VARCHAR(255) NOT NULL,
                            academic_session VARCHAR(255) NOT NULL

                        )";

                        $query_run_nine = mysqli_query($conn, $query_nine);




                        // class third term table creation ::::::::::::::::::::::::

                        $array_nine = array($class, 'third', 'term', 'table');

                        $class_third_term_table = implode('_', $array_nine);

                        $query_eleven = "CREATE TABLE $class_third_term_table(

                            id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                            addmission_number VARCHAR(255) NOT NULL,
                            surname VARCHAR(255) NOT NULL,
                            first_name VARCHAR(255) NOT NULL,
                            other_name VARCHAR(255) NOT NULL,

                            term VARCHAR(255) NOT NULL,
                            academic_session VARCHAR(255) NOT NULL

                        )";

                        $query_run_eleven = mysqli_query($conn, $query_eleven);




                        // class transaction table creation :::::::::::


                        $array_ten = array($class, 'transaction', 'table');

                        $class_transaction_table = implode('_', $array_ten);

                        $query_twelve = "CREATE TABLE $class_transaction_table(

                            id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                            name VARCHAR(255) NOT NULL,
                            addmission_num VARCHAR(255) NOT NULL,
                            term VARCHAR(255) NOT NULL,
                            session VARCHAR(255) NOT NULL,

                            amount INT(99) NOT NULL, 
                            date VARCHAR(99) NOT NULL, 
                            user_name VARCHAR(255) NOT NULL

                        )";

                        $query_run_twelve = mysqli_query($conn, $query_twelve);


                        
                        // class online exam question table creation :::::::::  js1_online_exam_question_table

                        $array_eleven  = array($class, 'online', 'exam', 'question', 'table');

                        $class_online_exam_question_table = implode('_', $array_eleven);


                        $query_thirteen = "CREATE TABLE $class_online_exam_question_table(

                            id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                            exam_id VARCHAR(255) NOT NULL,
                            question_id VARCHAR(255) NOT NULL,

                            question_title VARCHAR(255) NOT NULL,
                            right_option_num VARCHAR(255) NOT NULL,
                            right_option_title VARCHAR(255) NOT NULL, 

                            question_order VARCHAR(255) NOT NULL

                        )";

                        $query_run_thirteen = mysqli_query($conn, $query_thirteen);



                        // class online exam option table creation :::::::::::::::::::::::: js1_online_exam_option_table


                        $array_twelve  = array($class, 'online', 'exam', 'option', 'table');

                        $class_online_exam_option_table = implode('_', $array_twelve);

                        $query_fourteen = "CREATE TABLE $class_online_exam_option_table(

                            id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                            exam_id VARCHAR(255) NOT NULL,
                            question_id VARCHAR(255) NOT NULL,

                            option_title VARCHAR(255) NOT NULL,
                            option_num VARCHAR(255) NOT NULL
                            

                        )";

                        $query_run_fourteen = mysqli_query($conn, $query_fourteen);



                        // class student taken online exam table creation :::::::::::::::::::::: js1_online_exam_student_taken_exam_table

                        $array_thirteen  = array($class, 'online', 'exam', 'student', 'taken', 'exam', 'table');

                        $student_taken_online_exam_table = implode('_', $array_thirteen);

                        $query_fifteen = "CREATE TABLE $student_taken_online_exam_table(

                            id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                            name VARCHAR(255) NOT NULL,
                            addmission_num VARCHAR(255) NOT NULL,

                            exam_id VARCHAR(255) NOT NULL,
                            question_id VARCHAR(255) NOT NULL,
                            term VARCHAR(255) NOT NULL,

                            session VARCHAR(255) NOT NULL,
                            question VARCHAR(255) NOT NULL,
                            option_one_text VARCHAR(255) NOT NULL,

                            option_two_text VARCHAR(255) NOT NULL,
                            option_three_text VARCHAR(255) NOT NULL,
                            option_four_text VARCHAR(255) NOT NULL,

                            right_option_text VARCHAR(255) NOT NULL,
                            right_option_num VARCHAR(255) NOT NULL,
                            option_choosen VARCHAR(255) NOT NULL,

                            option_status VARCHAR(255) NOT NULL,
                            mark_status VARCHAR(255) NOT NULL,
                            mark VARCHAR(255) NOT NULL,

                            btn_click VARCHAR(255) NOT NULL
                            

                        )";

                        $query_run_fifteen = mysqli_query($conn, $query_fifteen);




                        

                        if ($query_run_three && $query_run_four && $query_run_five && $query_run_six && $query_run_seven && $query_run_eight && $query_run_nine && $query_run_ten && $query_run_eleven && $query_run_twelve && $query_run_thirteen && $query_run_fourteen && $query_run_fifteen) {

                            $output = 'created';  
                            
                        }else {
                            
                            $output = 'class table fail to be created';
                        }

                    

                    }
                }

            }else{



                // for primary school data and table creation :::::::::::::::::::::::::::::::
                // for primary school data and table creation :::::::::::::::::::::::::::::::
                // for primary school data and table creation :::::::::::::::::::::::::::::::
                // for primary school data and table creation :::::::::::::::::::::::::::::::


                $query = "SELECT * FROM pupil_class_category_table WHERE class = '$class'";
                $query_run = mysqli_query($conn, $query);

                $num =  mysqli_num_rows($query_run);

                if ($num > 0) {
                    
                    $output = 'class already created';
                }else {
                    
                    $query_two = "INSERT INTO pupil_class_category_table (class, category) VALUES('$class', '$category')";
                    $query_run_two = mysqli_query($conn, $query_two);

                    if ($query_run_two) {

                        // for pre nursery class :::::::::::::::::::::::::::::::
                        // for pre nursery class :::::::::::::::::::::::::::::::
                        // for pre nursery class :::::::::::::::::::::::::::::::
                        // for pre nursery class :::::::::::::::::::::::::::::::
                        
                        
                        if ($category == 'p_nur') {

                            // class exam table cretion ::::::::::::

                            $arry_two = array($class, 'exam', 'table');
                            $class_exam_table = implode('_', $arry_two);

                            $query_four = "CREATE TABLE $class_exam_table(

                                id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                                name VARCHAR(255) NOT NULL,
                                addmission_num VARCHAR(255) NOT NULL,
                                session VARCHAR(255) NOT NULL,
                                term VARCHAR(255) NOT NULL,

                                mat INT(99) NOT NULL,
                                eng INT(99) NOT NULL,
                                v_r INT(99) NOT NULL,
                                q_r INT(99) NOT NULL,
                                cat INT(99) NOT NULL,
                                she INT(99) NOT NULL,

                                ple INT(99) NOT NULL,
                                r_s INT(99) NOT NULL,
                                hdw INT(99) NOT NULL,
                                com INT(99) NOT NULL,
                                sed INT(99) NOT NULL,
                                mis INT(99) NOT NULL,


                                f_mat INT(99) NOT NULL,
                                f_eng INT(99) NOT NULL,
                                f_v_r INT(99) NOT NULL,
                                f_q_r INT(99) NOT NULL,
                                f_cat INT(99) NOT NULL,
                                f_she INT(99) NOT NULL,

                                f_ple INT(99) NOT NULL,
                                f_r_s INT(99) NOT NULL,
                                f_hdw INT(99) NOT NULL,
                                f_com INT(99) NOT NULL,
                                f_sed INT(99) NOT NULL,
                                f_mis INT(99) NOT NULL,



                                s_mat INT(99) NOT NULL,
                                s_eng INT(99) NOT NULL,
                                s_v_r INT(99) NOT NULL,
                                s_q_r INT(99) NOT NULL,
                                s_cat INT(99) NOT NULL,
                                s_she INT(99) NOT NULL,

                                s_ple INT(99) NOT NULL,
                                s_r_s INT(99) NOT NULL,
                                s_hdw INT(99) NOT NULL,
                                s_com INT(99) NOT NULL,
                                s_sed INT(99) NOT NULL,
                                s_mis INT(99) NOT NULL,


                                to_mat INT(99) NOT NULL,
                                to_eng INT(99) NOT NULL,
                                to_v_r INT(99) NOT NULL,
                                to_q_r INT(99) NOT NULL,
                                to_cat INT(99) NOT NULL,
                                to_she INT(99) NOT NULL,

                                to_ple INT(99) NOT NULL,
                                to_r_s INT(99) NOT NULL,
                                to_hdw INT(99) NOT NULL,
                                to_com INT(99) NOT NULL,
                                to_sed INT(99) NOT NULL,
                                to_mis INT(99) NOT NULL,

                               

                                total_score INT(99) NOT NULL,
                                status VARCHAR(255) NOT NULL
                                
                            )";

                            $query_run_four = mysqli_query($conn, $query_four);



                            // class first term ca table creation ::::::::::::::::::::::::::::::::::

                            $array_three = array($class, 'first', 'term', 'ca', 'table');

                            $class_first_term_ca_table = implode('_', $array_three);

                            $query_five = "CREATE TABLE $class_first_term_ca_table(

                                id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                                name VARCHAR(255) NOT NULL,
                                addmission_num VARCHAR(255) NOT NULL,
                                session VARCHAR(255) NOT NULL,
                                ca VARCHAR(255) NOT NULL,

                                mat INT(99) NOT NULL,
                                eng INT(99) NOT NULL,
                                v_r INT(99) NOT NULL,
                                q_r INT(99) NOT NULL,
                                cat INT(99) NOT NULL,
                                she INT(99) NOT NULL,

                                ple INT(99) NOT NULL,
                                r_s INT(99) NOT NULL,
                                hdw INT(99) NOT NULL,
                                com INT(99) NOT NULL,
                                sed INT(99) NOT NULL,
                                mis INT(99) NOT NULL,

                                total_score INT(99) NOT NULL,

                                status VARCHAR(255) NOT NULL


                            )";

                            $query_run_five = mysqli_query($conn, $query_five);



                            // class second term ca table creation :::::::::::

                            $array_six = array($class, 'second', 'term', 'ca', 'table');

                            $class_second_term_ca_term_table = implode('_', $array_six);


                            $query_eight = "CREATE TABLE $class_second_term_ca_term_table(

                                id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                                name VARCHAR(255) NOT NULL,
                                addmission_num VARCHAR(255) NOT NULL,
                                session VARCHAR(255) NOT NULL,
                                ca VARCHAR(255) NOT NULL,

                                mat INT(99) NOT NULL,
                                eng INT(99) NOT NULL,
                                v_r INT(99) NOT NULL,
                                q_r INT(99) NOT NULL,
                                cat INT(99) NOT NULL,
                                she INT(99) NOT NULL,

                                ple INT(99) NOT NULL,
                                r_s INT(99) NOT NULL,
                                hdw INT(99) NOT NULL,
                                com INT(99) NOT NULL,
                                sed INT(99) NOT NULL,
                                mis INT(99) NOT NULL,

                                total_score INT(99) NOT NULL,

                                status VARCHAR(255) NOT NULL

                            )";

                            $query_run_eight = mysqli_query($conn, $query_eight);

                            
                            // class third term ca table creation ::::::::

                            $array_eight = array($class, 'third', 'term', 'ca', 'table');

                            $class_third_term_ca_table = implode('_', $array_eight);

                            $query_ten = "CREATE TABLE $class_third_term_ca_table(

                                id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                                name VARCHAR(255) NOT NULL,
                                addmission_num VARCHAR(255) NOT NULL,
                                session VARCHAR(255) NOT NULL,
                                ca VARCHAR(255) NOT NULL,

                                mat INT(99) NOT NULL,
                                eng INT(99) NOT NULL,
                                v_r INT(99) NOT NULL,
                                q_r INT(99) NOT NULL,
                                cat INT(99) NOT NULL,
                                she INT(99) NOT NULL,

                                ple INT(99) NOT NULL,
                                r_s INT(99) NOT NULL,
                                hdw INT(99) NOT NULL,
                                com INT(99) NOT NULL,
                                sed INT(99) NOT NULL,
                                mis INT(99) NOT NULL,

                                total_score INT(99) NOT NULL,

                                status VARCHAR(255) NOT NULL

                            )";

                            $query_run_ten = mysqli_query($conn, $query_ten);

                                
                        }else if ($category == 'nur_one'){

                            // category for nursery one ::::::::::::
                            // category for nursery one ::::::::::::
                            // category for nursery one ::::::::::::
                            // category for nursery one ::::::::::::


                             // class exam table cretion ::::::::::::

                             $arry_two = array($class, 'exam', 'table');
                             $class_exam_table = implode('_', $arry_two);
 
                             $query_four = "CREATE TABLE $class_exam_table(
 
                                 id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                                 name VARCHAR(255) NOT NULL,
                                 addmission_num VARCHAR(255) NOT NULL,
                                 session VARCHAR(255) NOT NULL,
                                 term VARCHAR(255) NOT NULL,
 
                                 mat INT(99) NOT NULL,
                                 eng INT(99) NOT NULL,
                                 v_r INT(99) NOT NULL,
                                 q_r INT(99) NOT NULL,
                                 cat INT(99) NOT NULL,
                                 she INT(99) NOT NULL,
 
                                 ple INT(99) NOT NULL,
                                 r_s INT(99) NOT NULL,
                                 hdw INT(99) NOT NULL,
                                 com INT(99) NOT NULL,
                                 sed INT(99) NOT NULL,
                                 mis INT(99) NOT NULL,

                                 caf INT(99) NOT NULL,
 
 
 
                                 f_mat INT(99) NOT NULL,
                                 f_eng INT(99) NOT NULL,
                                 f_v_r INT(99) NOT NULL,
                                 f_q_r INT(99) NOT NULL,
                                 f_cat INT(99) NOT NULL,
                                 f_she INT(99) NOT NULL,
 
                                 f_ple INT(99) NOT NULL,
                                 f_r_s INT(99) NOT NULL,
                                 f_hdw INT(99) NOT NULL,
                                 f_com INT(99) NOT NULL,
                                 f_sed INT(99) NOT NULL,
                                 f_mis INT(99) NOT NULL,

                                 f_caf INT(99) NOT NULL,
 
 
 
 
                                 s_mat INT(99) NOT NULL,
                                 s_eng INT(99) NOT NULL,
                                 s_v_r INT(99) NOT NULL,
                                 s_q_r INT(99) NOT NULL,
                                 s_cat INT(99) NOT NULL,
                                 s_she INT(99) NOT NULL,
 
                                 s_ple INT(99) NOT NULL,
                                 s_r_s INT(99) NOT NULL,
                                 s_hdw INT(99) NOT NULL,
                                 s_com INT(99) NOT NULL,
                                 s_sed INT(99) NOT NULL,
                                 s_mis INT(99) NOT NULL,

                                 s_caf INT(99) NOT NULL,
 
 
                                 to_mat INT(99) NOT NULL,
                                 to_eng INT(99) NOT NULL,
                                 to_v_r INT(99) NOT NULL,
                                 to_q_r INT(99) NOT NULL,
                                 to_cat INT(99) NOT NULL,
                                 to_she INT(99) NOT NULL,
 
                                 to_ple INT(99) NOT NULL,
                                 to_r_s INT(99) NOT NULL,
                                 to_hdw INT(99) NOT NULL,
                                 to_com INT(99) NOT NULL,
                                 to_sed INT(99) NOT NULL,
                                 to_mis INT(99) NOT NULL,

                                 to_caf INT(99) NOT NULL,
 
                                
 
                                 total_score INT(99) NOT NULL,
                                 status VARCHAR(255) NOT NULL
                                 
                             )";
 
                             $query_run_four = mysqli_query($conn, $query_four);
 
 
 
                             // class first term ca table creation ::::::::::::::::::::::::::::::::::
 
                             $array_three = array($class, 'first', 'term', 'ca', 'table');
 
                             $class_first_term_ca_table = implode('_', $array_three);
 
                             $query_five = "CREATE TABLE $class_first_term_ca_table(
 
                                 id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                                 name VARCHAR(255) NOT NULL,
                                 addmission_num VARCHAR(255) NOT NULL,
                                 session VARCHAR(255) NOT NULL,
                                 ca VARCHAR(255) NOT NULL,
 
                                 mat INT(99) NOT NULL,
                                 eng INT(99) NOT NULL,
                                 v_r INT(99) NOT NULL,
                                 q_r INT(99) NOT NULL,
                                 cat INT(99) NOT NULL,
                                 she INT(99) NOT NULL,
 
                                 ple INT(99) NOT NULL,
                                 r_s INT(99) NOT NULL,
                                 hdw INT(99) NOT NULL,
                                 com INT(99) NOT NULL,
                                 sed INT(99) NOT NULL,
                                 mis INT(99) NOT NULL,

                                 caf INT(99) NOT NULL,
 
                                 total_score INT(99) NOT NULL,
 
                                 status VARCHAR(255) NOT NULL
 
 
                             )";
 
                             $query_run_five = mysqli_query($conn, $query_five);
 
 
 
                             // class second term ca table creation :::::::::::
 
                             $array_six = array($class, 'second', 'term', 'ca', 'table');
 
                             $class_second_term_ca_term_table = implode('_', $array_six);
 
 
                             $query_eight = "CREATE TABLE $class_second_term_ca_term_table(
 
                                 id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                                 name VARCHAR(255) NOT NULL,
                                 addmission_num VARCHAR(255) NOT NULL,
                                 session VARCHAR(255) NOT NULL,
                                 ca VARCHAR(255) NOT NULL,
 
                                 mat INT(99) NOT NULL,
                                 eng INT(99) NOT NULL,
                                 v_r INT(99) NOT NULL,
                                 q_r INT(99) NOT NULL,
                                 cat INT(99) NOT NULL,
                                 she INT(99) NOT NULL,
 
                                 ple INT(99) NOT NULL,
                                 r_s INT(99) NOT NULL,
                                 hdw INT(99) NOT NULL,
                                 com INT(99) NOT NULL,
                                 sed INT(99) NOT NULL,
                                 mis INT(99) NOT NULL,

                                 caf INT(99) NOT NULL,
 
                                 total_score INT(99) NOT NULL,
 
                                 status VARCHAR(255) NOT NULL
 
                             )";
 
                             $query_run_eight = mysqli_query($conn, $query_eight);
 
                             
                             // class third term ca table creation ::::::::
 
                             $array_eight = array($class, 'third', 'term', 'ca', 'table');
 
                             $class_third_term_ca_table = implode('_', $array_eight);
 
                             $query_ten = "CREATE TABLE $class_third_term_ca_table(
 
                                 id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                                 name VARCHAR(255) NOT NULL,
                                 addmission_num VARCHAR(255) NOT NULL,
                                 session VARCHAR(255) NOT NULL,
                                 ca VARCHAR(255) NOT NULL,
 
                                 mat INT(99) NOT NULL,
                                 eng INT(99) NOT NULL,
                                 v_r INT(99) NOT NULL,
                                 q_r INT(99) NOT NULL,
                                 cat INT(99) NOT NULL,
                                 she INT(99) NOT NULL,
 
                                 ple INT(99) NOT NULL,
                                 r_s INT(99) NOT NULL,
                                 hdw INT(99) NOT NULL,
                                 com INT(99) NOT NULL,
                                 sed INT(99) NOT NULL,
                                 mis INT(99) NOT NULL,

                                 caf INT(99) NOT NULL,
 
                                 total_score INT(99) NOT NULL,
 
                                 status VARCHAR(255) NOT NULL
 
                             )";
 
                             $query_run_ten = mysqli_query($conn, $query_ten);

                        }else if($category == 'nur_two') {

                            
                            // category for nursery two ::::::::::::
                            // category for nursery two ::::::::::::
                            // category for nursery two ::::::::::::
                            // category for nursery two ::::::::::::


                             // class exam table cretion ::::::::::::

                             $arry_two = array($class, 'exam', 'table');
                             $class_exam_table = implode('_', $arry_two);
 
                             $query_four = "CREATE TABLE $class_exam_table(
 
                                 id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                                 name VARCHAR(255) NOT NULL,
                                 addmission_num VARCHAR(255) NOT NULL,
                                 session VARCHAR(255) NOT NULL,
                                 term VARCHAR(255) NOT NULL,
 
                                 mat INT(99) NOT NULL,
                                 eng INT(99) NOT NULL,
                                 v_r INT(99) NOT NULL,
                                 q_r INT(99) NOT NULL,
                                 r_s INT(99) NOT NULL,
                                 cdv INT(99) NOT NULL,
 
                                 ple INT(99) NOT NULL,
                                 sos INT(99) NOT NULL,
                                 hdw INT(99) NOT NULL,
                                 com INT(99) NOT NULL,
                                 ccc INT(99) NOT NULL,
                                 she INT(99) NOT NULL,

                                 mis INT(99) NOT NULL,
 
 
 
                                 f_mat INT(99) NOT NULL,
                                 f_eng INT(99) NOT NULL,
                                 f_v_r INT(99) NOT NULL,
                                 f_q_r INT(99) NOT NULL,
                                 f_r_s INT(99) NOT NULL,
                                 f_cdv INT(99) NOT NULL,
 
                                 f_ple INT(99) NOT NULL,
                                 f_sos INT(99) NOT NULL,
                                 f_hdw INT(99) NOT NULL,
                                 f_com INT(99) NOT NULL,
                                 f_ccc INT(99) NOT NULL,
                                 f_she INT(99) NOT NULL,

                                 f_mis INT(99) NOT NULL,
 
 
 
 
                                 s_mat INT(99) NOT NULL,
                                 s_eng INT(99) NOT NULL,
                                 s_v_r INT(99) NOT NULL,
                                 s_q_r INT(99) NOT NULL,
                                 s_r_s INT(99) NOT NULL,
                                 s_cdv INT(99) NOT NULL,
 
                                 s_ple INT(99) NOT NULL,
                                 s_sos INT(99) NOT NULL,
                                 s_hdw INT(99) NOT NULL,
                                 s_com INT(99) NOT NULL,
                                 s_ccc INT(99) NOT NULL,
                                 s_she INT(99) NOT NULL,

                                 s_mis INT(99) NOT NULL,
 
 
                                 to_mat INT(99) NOT NULL,
                                 to_eng INT(99) NOT NULL,
                                 to_v_r INT(99) NOT NULL,
                                 to_q_r INT(99) NOT NULL,
                                 to_r_s INT(99) NOT NULL,
                                 to_cdv INT(99) NOT NULL,
 
                                 to_ple INT(99) NOT NULL,
                                 to_sos INT(99) NOT NULL,
                                 to_hdw INT(99) NOT NULL,
                                 to_com INT(99) NOT NULL,
                                 to_ccc INT(99) NOT NULL,
                                 to_she INT(99) NOT NULL,

                                 to_mis INT(99) NOT NULL,
 
                                
 
                                 total_score INT(99) NOT NULL,
                                 status VARCHAR(255) NOT NULL
                                 
                             )";
 
                             $query_run_four = mysqli_query($conn, $query_four);
 
 
 
                             // class first term ca table creation ::::::::::::::::::::::::::::::::::
 
                             $array_three = array($class, 'first', 'term', 'ca', 'table');
 
                             $class_first_term_ca_table = implode('_', $array_three);
 
                             $query_five = "CREATE TABLE $class_first_term_ca_table(
 
                                 id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                                 name VARCHAR(255) NOT NULL,
                                 addmission_num VARCHAR(255) NOT NULL,
                                 session VARCHAR(255) NOT NULL,
                                 ca VARCHAR(255) NOT NULL,
 
                                 mat INT(99) NOT NULL,
                                 eng INT(99) NOT NULL,
                                 v_r INT(99) NOT NULL,
                                 q_r INT(99) NOT NULL,
                                 r_s INT(99) NOT NULL,
                                 cdv INT(99) NOT NULL,
 
                                 ple INT(99) NOT NULL,
                                 sos INT(99) NOT NULL,
                                 hdw INT(99) NOT NULL,
                                 com INT(99) NOT NULL,
                                 ccc INT(99) NOT NULL,
                                 she INT(99) NOT NULL,

                                 mis INT(99) NOT NULL,
 
                                 total_score INT(99) NOT NULL,
 
                                 status VARCHAR(255) NOT NULL
 
 
                             )";
 
                             $query_run_five = mysqli_query($conn, $query_five);
 
 
 
                             // class second term ca table creation :::::::::::
 
                             $array_six = array($class, 'second', 'term', 'ca', 'table');
 
                             $class_second_term_ca_term_table = implode('_', $array_six);
 
 
                             $query_eight = "CREATE TABLE $class_second_term_ca_term_table(
 
                                 id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                                 name VARCHAR(255) NOT NULL,
                                 addmission_num VARCHAR(255) NOT NULL,
                                 session VARCHAR(255) NOT NULL,
                                 ca VARCHAR(255) NOT NULL,
 
                                 mat INT(99) NOT NULL,
                                 eng INT(99) NOT NULL,
                                 v_r INT(99) NOT NULL,
                                 q_r INT(99) NOT NULL,
                                 r_s INT(99) NOT NULL,
                                 cdv INT(99) NOT NULL,
 
                                 ple INT(99) NOT NULL,
                                 sos INT(99) NOT NULL,
                                 hdw INT(99) NOT NULL,
                                 com INT(99) NOT NULL,
                                 ccc INT(99) NOT NULL,
                                 she INT(99) NOT NULL,

                                 mis INT(99) NOT NULL,
 
                                 total_score INT(99) NOT NULL,
 
                                 status VARCHAR(255) NOT NULL
 
                             )";
 
                             $query_run_eight = mysqli_query($conn, $query_eight);
 
                             
                             // class third term ca table creation ::::::::
 
                             $array_eight = array($class, 'third', 'term', 'ca', 'table');
 
                             $class_third_term_ca_table = implode('_', $array_eight);
 
                             $query_ten = "CREATE TABLE $class_third_term_ca_table(
 
                                 id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                                 name VARCHAR(255) NOT NULL,
                                 addmission_num VARCHAR(255) NOT NULL,
                                 session VARCHAR(255) NOT NULL,
                                 ca VARCHAR(255) NOT NULL,
 
                                 mat INT(99) NOT NULL,
                                 eng INT(99) NOT NULL,
                                 v_r INT(99) NOT NULL,
                                 q_r INT(99) NOT NULL,
                                 r_s INT(99) NOT NULL,
                                 cdv INT(99) NOT NULL,
 
                                 ple INT(99) NOT NULL,
                                 sos INT(99) NOT NULL,
                                 hdw INT(99) NOT NULL,
                                 com INT(99) NOT NULL,
                                 ccc INT(99) NOT NULL,
                                 she INT(99) NOT NULL,

                                 mis INT(99) NOT NULL,
 
                                 total_score INT(99) NOT NULL,
 
                                 status VARCHAR(255) NOT NULL
 
                             )";
 
                             $query_run_ten = mysqli_query($conn, $query_ten);

                        }else {

                            // category for primary ::::::::::::
                            // category for primary ::::::::::::
                            // category for primary ::::::::::::
                            // category for primary ::::::::::::




                            
                            // class exam table cretion ::::::::::::

                            $arry_two = array($class, 'exam', 'table');
                            $class_exam_table = implode('_', $arry_two);

                            $query_four = "CREATE TABLE $class_exam_table(

                                id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                                name VARCHAR(255) NOT NULL,
                                addmission_num VARCHAR(255) NOT NULL,
                                session VARCHAR(255) NOT NULL,
                                term VARCHAR(255) NOT NULL,

                                mat INT(99) NOT NULL,
                                eng INT(99) NOT NULL,
                                v_r INT(99) NOT NULL,
                                q_r INT(99) NOT NULL,
                                cca INT(99) NOT NULL,
                                spc INT(99) NOT NULL,

                                lit INT(99) NOT NULL,
                                phe INT(99) NOT NULL,
                                agri INT(99) NOT NULL,
                                b_s INT(99) NOT NULL,
                                sos INT(99) NOT NULL,
                                com INT(99) NOT NULL,

                                civ INT(99) NOT NULL,
                                mis INT(99) NOT NULL,
                                cco INT(99) NOT NULL,
                                wrt INT(99) NOT NULL,
                                drw INT(99) NOT NULL,
                                lan INT(99) NOT NULL,



                                f_mat INT(99) NOT NULL,
                                f_eng INT(99) NOT NULL,
                                f_v_r INT(99) NOT NULL,
                                f_q_r INT(99) NOT NULL,
                                f_cca INT(99) NOT NULL,
                                f_spc INT(99) NOT NULL,

                                f_lit INT(99) NOT NULL,
                                f_phe INT(99) NOT NULL,
                                f_agri INT(99) NOT NULL,
                                f_b_s INT(99) NOT NULL,
                                f_sos INT(99) NOT NULL,
                                f_com INT(99) NOT NULL,

                                f_civ INT(99) NOT NULL,
                                f_mis INT(99) NOT NULL,
                                f_cco INT(99) NOT NULL,
                                f_wrt INT(99) NOT NULL,
                                f_drw INT(99) NOT NULL,
                                f_lan INT(99) NOT NULL,



                                s_mat INT(99) NOT NULL,
                                s_eng INT(99) NOT NULL,
                                s_v_r INT(99) NOT NULL,
                                s_q_r INT(99) NOT NULL,
                                s_cca INT(99) NOT NULL,
                                s_spc INT(99) NOT NULL,

                                s_lit INT(99) NOT NULL,
                                s_phe INT(99) NOT NULL,
                                s_agri INT(99) NOT NULL,
                                s_b_s INT(99) NOT NULL,
                                s_sos INT(99) NOT NULL,
                                s_com INT(99) NOT NULL,

                                s_civ INT(99) NOT NULL,
                                s_mis INT(99) NOT NULL,
                                s_cco INT(99) NOT NULL,
                                s_wrt INT(99) NOT NULL,
                                s_drw INT(99) NOT NULL,
                                s_lan INT(99) NOT NULL,


                                to_mat INT(99) NOT NULL,
                                to_eng INT(99) NOT NULL,
                                to_v_r INT(99) NOT NULL,
                                to_q_r INT(99) NOT NULL,
                                to_cca INT(99) NOT NULL,
                                to_spc INT(99) NOT NULL,

                                to_lit INT(99) NOT NULL,
                                to_phe INT(99) NOT NULL,
                                to_agri INT(99) NOT NULL,
                                to_b_s INT(99) NOT NULL,
                                to_sos INT(99) NOT NULL,
                                to_com INT(99) NOT NULL,

                                to_civ INT(99) NOT NULL,
                                to_mis INT(99) NOT NULL,
                                to_cco INT(99) NOT NULL,
                                to_wrt INT(99) NOT NULL,
                                to_drw INT(99) NOT NULL,
                                to_lan INT(99) NOT NULL,


                                

                                total_score INT(99) NOT NULL,
                                status VARCHAR(255) NOT NULL
                                
                            )";

                            $query_run_four = mysqli_query($conn, $query_four);



                            // class first term ca table creation ::::::::::::::::::::::::::::::::::

                            $array_three = array($class, 'first', 'term', 'ca', 'table');

                            $class_first_term_ca_table = implode('_', $array_three);

                            $query_five = "CREATE TABLE $class_first_term_ca_table(

                                id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                                name VARCHAR(255) NOT NULL,
                                addmission_num VARCHAR(255) NOT NULL,
                                session VARCHAR(255) NOT NULL,
                                ca VARCHAR(255) NOT NULL,

                                mat INT(99) NOT NULL,
                                eng INT(99) NOT NULL,
                                v_r INT(99) NOT NULL,
                                q_r INT(99) NOT NULL,
                                cca INT(99) NOT NULL,
                                spc INT(99) NOT NULL,

                                lit INT(99) NOT NULL,
                                phe INT(99) NOT NULL,
                                agri INT(99) NOT NULL,
                                b_s INT(99) NOT NULL,
                                sos INT(99) NOT NULL,
                                com INT(99) NOT NULL,

                                civ INT(99) NOT NULL,
                                mis INT(99) NOT NULL,
                                cco INT(99) NOT NULL,
                                wrt INT(99) NOT NULL,
                                drw INT(99) NOT NULL,
                                lan INT(99) NOT NULL,

                                total_score INT(99) NOT NULL,

                                status VARCHAR(255) NOT NULL


                            )";

                            $query_run_five = mysqli_query($conn, $query_five);



                            // class second term ca table creation :::::::::::

                            $array_six = array($class, 'second', 'term', 'ca', 'table');

                            $class_second_term_ca_term_table = implode('_', $array_six);


                            $query_eight = "CREATE TABLE $class_second_term_ca_term_table(

                                id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                                name VARCHAR(255) NOT NULL,
                                addmission_num VARCHAR(255) NOT NULL,
                                session VARCHAR(255) NOT NULL,
                                ca VARCHAR(255) NOT NULL,

                                mat INT(99) NOT NULL,
                                eng INT(99) NOT NULL,
                                v_r INT(99) NOT NULL,
                                q_r INT(99) NOT NULL,
                                cca INT(99) NOT NULL,
                                spc INT(99) NOT NULL,

                                lit INT(99) NOT NULL,
                                phe INT(99) NOT NULL,
                                agri INT(99) NOT NULL,
                                b_s INT(99) NOT NULL,
                                sos INT(99) NOT NULL,
                                com INT(99) NOT NULL,

                                civ INT(99) NOT NULL,
                                mis INT(99) NOT NULL,
                                cco INT(99) NOT NULL,
                                wrt INT(99) NOT NULL,
                                drw INT(99) NOT NULL,
                                lan INT(99) NOT NULL,

                                total_score INT(99) NOT NULL,

                                status VARCHAR(255) NOT NULL

                            )";

                            $query_run_eight = mysqli_query($conn, $query_eight);

                            
                            // class third term ca table creation ::::::::

                            $array_eight = array($class, 'third', 'term', 'ca', 'table');

                            $class_third_term_ca_table = implode('_', $array_eight);

                            $query_ten = "CREATE TABLE $class_third_term_ca_table(

                                id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                                name VARCHAR(255) NOT NULL,
                                addmission_num VARCHAR(255) NOT NULL,
                                session VARCHAR(255) NOT NULL,
                                ca VARCHAR(255) NOT NULL,

                                mat INT(99) NOT NULL,
                                eng INT(99) NOT NULL,
                                v_r INT(99) NOT NULL,
                                q_r INT(99) NOT NULL,
                                cca INT(99) NOT NULL,
                                spc INT(99) NOT NULL,

                                lit INT(99) NOT NULL,
                                phe INT(99) NOT NULL,
                                agri INT(99) NOT NULL,
                                b_s INT(99) NOT NULL,
                                sos INT(99) NOT NULL,
                                com INT(99) NOT NULL,

                                civ INT(99) NOT NULL,
                                mis INT(99) NOT NULL,
                                cco INT(99) NOT NULL,
                                wrt INT(99) NOT NULL,
                                drw INT(99) NOT NULL,
                                lan INT(99) NOT NULL,

                                
                                total_score INT(99) NOT NULL,

                                status VARCHAR(255) NOT NULL

                            )";

                            $query_run_ten = mysqli_query($conn, $query_ten);

                            
                            
                        }
                            
                        
                        $array_one = array($class, 'attendance', 'table');
                        $class_attendance = implode('_', $array_one);

                        // create class attendance table::::::::::::::::::::::

                        $query_three = "CREATE TABLE $class_attendance(

                            id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                            name VARCHAR(255) NOT NULL,
                            addmission_num VARCHAR(255) NOT NULL,

                            attendance_status VARCHAR(255) NOT NULL,
                            formaster_name VARCHAR(255) NOT NULL,
                            term VARCHAR(255) NOT NULL,

                            session VARCHAR(255) NOT NULL,
                            date VARCHAR(255) NOT NULL

                        )";

                        $query_run_three = mysqli_query($conn, $query_three);


                        // class first term table creation :::::::::::::::


                        $array_four = array($class, 'first', 'term', 'table');

                        $class_first_term_table = implode('_', $array_four);

                        $query_six = "CREATE TABLE $class_first_term_table (

                            id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                            addmission_number VARCHAR(255) NOT NULL,
                            surname VARCHAR(255) NOT NULL,
                            first_name VARCHAR(255) NOT NULL,
                            other_name VARCHAR(255) NOT NULL,

                            term VARCHAR(255) NOT NULL,
                            academic_session VARCHAR(255) NOT NULL

                        )";

                        $query_run_six = mysqli_query($conn, $query_six);



                        // class payment table creaton:::::::::::::


                        $array_five = array($class, 'payment', 'table');

                        $class_payment_table = implode('_', $array_five);

                        $query_seven = "CREATE TABLE $class_payment_table (

                            id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                            name VARCHAR(255) NOT NULL,
                            addmission_num VARCHAR(255) NOT NULL,
                            term VARCHAR(255) NOT NULL,
                            session VARCHAR(255) NOT NULL,

                            amount INT(99) NOT NULL, 
                            amount_paid INT(99) NOT NULL, 
                            balance INT(99) NOT NULL, 
                            date VARCHAR(255) NOT NULL,
                            user_name VARCHAR(255) NOT NULL,

                            voucher_num VARCHAR(255) NOT NULL
                        
                        )";

                        $query_run_seven = mysqli_query($conn, $query_seven);


                        // class second term table creation ::::::::::::::::

                        $array_seven = array($class, 'second', 'term', 'table');

                        $class_second_term_table = implode('_', $array_seven);
                        
                        $query_nine = "CREATE TABLE $class_second_term_table(

                            id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                            addmission_number VARCHAR(255) NOT NULL,
                            surname VARCHAR(255) NOT NULL,
                            first_name VARCHAR(255) NOT NULL,
                            other_name VARCHAR(255) NOT NULL,

                            term VARCHAR(255) NOT NULL,
                            academic_session VARCHAR(255) NOT NULL

                        )";

                        $query_run_nine = mysqli_query($conn, $query_nine);




                        // class third term table creation ::::::::::::::::::::::::

                        $array_nine = array($class, 'third', 'term', 'table');

                        $class_third_term_table = implode('_', $array_nine);

                        $query_eleven = "CREATE TABLE $class_third_term_table(

                            id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                            addmission_number VARCHAR(255) NOT NULL,
                            surname VARCHAR(255) NOT NULL,
                            first_name VARCHAR(255) NOT NULL,
                            other_name VARCHAR(255) NOT NULL,

                            term VARCHAR(255) NOT NULL,
                            academic_session VARCHAR(255) NOT NULL

                        )";

                        $query_run_eleven = mysqli_query($conn, $query_eleven);




                        // class transaction table creation :::::::::::


                        $array_ten = array($class, 'transaction', 'table');

                        $class_transaction_table = implode('_', $array_ten);

                        $query_twelve = "CREATE TABLE $class_transaction_table(

                            id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                            name VARCHAR(255) NOT NULL,
                            addmission_num VARCHAR(255) NOT NULL,
                            term VARCHAR(255) NOT NULL,
                            session VARCHAR(255) NOT NULL,

                            amount INT(99) NOT NULL, 
                            date VARCHAR(99) NOT NULL, 
                            user_name VARCHAR(255) NOT NULL

                        )";

                        $query_run_twelve = mysqli_query($conn, $query_twelve);


                        
                        // class online exam question table creation :::::::::  js1_online_exam_question_table

                        $array_eleven  = array($class, 'online', 'exam', 'question', 'table');

                        $class_online_exam_question_table = implode('_', $array_eleven);


                        $query_thirteen = "CREATE TABLE $class_online_exam_question_table(

                            id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                            exam_id VARCHAR(255) NOT NULL,
                            question_id VARCHAR(255) NOT NULL,

                            question_title VARCHAR(255) NOT NULL,
                            right_option_num VARCHAR(255) NOT NULL,
                            right_option_title VARCHAR(255) NOT NULL, 

                            question_order VARCHAR(255) NOT NULL

                        )";

                        $query_run_thirteen = mysqli_query($conn, $query_thirteen);



                        // class online exam option table creation :::::::::::::::::::::::: js1_online_exam_option_table


                        $array_twelve  = array($class, 'online', 'exam', 'option', 'table');

                        $class_online_exam_option_table = implode('_', $array_twelve);

                        $query_fourteen = "CREATE TABLE $class_online_exam_option_table(

                            id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                            exam_id VARCHAR(255) NOT NULL,
                            question_id VARCHAR(255) NOT NULL,

                            option_title VARCHAR(255) NOT NULL,
                            option_num VARCHAR(255) NOT NULL
                            

                        )";

                        $query_run_fourteen = mysqli_query($conn, $query_fourteen);



                        // class student taken online exam table creation :::::::::::::::::::::: js1_online_exam_student_taken_exam_table

                        $array_thirteen  = array($class, 'online', 'exam', 'student', 'taken', 'exam', 'table');

                        $student_taken_online_exam_table = implode('_', $array_thirteen);

                        $query_fifteen = "CREATE TABLE $student_taken_online_exam_table(

                            id INT(99) AUTO_INCREMENT PRIMARY KEY, 
                            name VARCHAR(255) NOT NULL,
                            addmission_num VARCHAR(255) NOT NULL,

                            exam_id VARCHAR(255) NOT NULL,
                            question_id VARCHAR(255) NOT NULL,
                            term VARCHAR(255) NOT NULL,

                            session VARCHAR(255) NOT NULL,
                            question VARCHAR(255) NOT NULL,
                            option_one_text VARCHAR(255) NOT NULL,

                            option_two_text VARCHAR(255) NOT NULL,
                            option_three_text VARCHAR(255) NOT NULL,
                            option_four_text VARCHAR(255) NOT NULL,

                            right_option_text VARCHAR(255) NOT NULL,
                            right_option_num VARCHAR(255) NOT NULL,
                            option_choosen VARCHAR(255) NOT NULL,

                            option_status VARCHAR(255) NOT NULL,
                            mark_status VARCHAR(255) NOT NULL,
                            mark VARCHAR(255) NOT NULL,

                            btn_click VARCHAR(255) NOT NULL
                            

                        )";

                        $query_run_fifteen = mysqli_query($conn, $query_fifteen);




                        

                        if ($query_run_three && $query_run_four && $query_run_five && $query_run_six && $query_run_seven && $query_run_eight && $query_run_nine && $query_run_ten && $query_run_eleven && $query_run_twelve && $query_run_thirteen && $query_run_fourteen && $query_run_fifteen) {

                            $output = 'created';  
                            
                        }else {
                            
                            $output = 'class table fail to be created';
                        }

                    

                    }
                }    
            }

            echo $output;
        }*/






        // school subject regitration ::::::::::::::::::::::::::::::::::::::::::::::::


        if ($_POST['action'] == 'subject registration') {
            
            $subject_name = mysqli_real_escape_string($conn, $_POST['subject_name']);
            $subject_code = mysqli_real_escape_string($conn, $_POST['subject_code']);
            $school = mysqli_real_escape_string($conn, $_POST['school']);

            if ($school == 'seconday') {
               
                $query = "SELECT * FROM subject_table WHERE name = '$subject_name' AND code = '$subject_code'";
                $query_run = mysqli_query($conn, $query);

                $num = mysqli_num_rows($query_run);

                if ($num > 0) {
                    
                    $output = 'subject already registerd';
                }else {
                    
                    $query_two = "INSERT INTO subject_table (name, code) VALUES ('$subject_name', '$subject_code')";
                    $query_run_two = mysqli_query($conn, $query_two);

                    if ($query_run_two) {
                        
                        $output = 'created';

                    }else {
                        
                        $output = 'subject fail to registered';

                    }
                }

            }else{

                $query = "SELECT * FROM pupil_subject_table WHERE name = '$subject_name' AND code = '$subject_code'";
                $query_run = mysqli_query($conn, $query);

                $num = mysqli_num_rows($query_run);

                if ($num > 0) {
                    
                    $output = 'subject already registerd';
                }else {
                    
                    $query_two = "INSERT INTO pupil_subject_table (name, code) VALUES ('$subject_name', '$subject_code')";
                    $query_run_two = mysqli_query($conn, $query_two);

                    if ($query_run_two) {
                        
                        $output = 'created';

                    }else {
                        
                        $output = 'subject fail to registered';

                    }
                }
            }


            echo $output;
        }














        // pupils pupils  pupils  pupils  pupils  pupils  pupils::::::::::::::::::

        // pupils pupils  pupils  pupils  pupils  pupils  pupils:::::::::::::::::::::



        // pupil detail deleting......................................................

        if ($_POST['action'] == 'deleting pupil registration detail') {
            
            $id = $_POST['id'];

            $query_two = "SELECT * FROM pupil_registration_table WHERE id = '$id'";
            $query_run_two = mysqli_query($conn, $query_two);

            $num_two = mysqli_num_rows($query_run_two);

            if ($num_two > 0) {
                
                $row_two = mysqli_fetch_array( $query_run_two);

                $image = $row_two['image'];

                $image_path = '../../../image/pupil/'.$image;

                if ($image_path) {
                    
                    unlink($image_path);
                
            
            
                    $query = "DELETE FROM pupil_registration_table WHERE id = '$id'";
                    $query_run = mysqli_query($conn, $query);

                    if ($query_run) {
                        echo 'deleted';
                    }else{
                        echo 'data fail to delete';
                    }

                }

            }
        }







        // single pupil datails deleting..........................................................

        if ($_POST['action'] == 'delete single pupil detail') {
            
            $addmission_number = mysqli_real_escape_string($conn, $_POST['addmission_number']);

            $query = "SELECT * FROM pupil_registration_table WHERE addmission_num = '$addmission_number'";
            $query_run = mysqli_query($conn, $query);

            $num = mysqli_num_rows($query_run);

            if ($num < 1) {
                
                echo 'incorrect addmission number';
            }else{

                $row = mysqli_fetch_array($query_run);
                
                $image = $row['image'];

                $image_path = '../../../image/pupil/'.$image;

                if ($image_path) {

                    unlink($image_path);
                
                    $query_two = "DELETE FROM pupil_registration_table WHERE addmission_num = '$addmission_number'";
                    $query_run_two = mysqli_query($conn, $query_two);

                    if ($query_run_two) {
                        
                        echo 'data successfully deleted';
                    }else{
                        echo 'data fail to delete';
                    }

                }else{

                    echo 'incorrect old image paths';
                }
            }
        }





        

        // single pupil class insertion............................

        if ($_POST['action'] == 'insert single pupil to class') {
            
            $addmission_number = mysqli_real_escape_string($conn, $_POST['addmission_number']);
            $classes = mysqli_real_escape_string($conn, $_POST['classes']);
            $session = mysqli_real_escape_string($conn, $_POST['session']);
            $term = mysqli_real_escape_string($conn, $_POST['term']);

            $session_reg = "/^([0-9]{4})\/([0-9]{4})$/";

            if (!preg_match($session_reg, $session)) {
                
                echo 'incorrect session';
            }else{

                $query = "SELECT * FROM pupil_registration_table WHERE addmission_num = '$addmission_number'";
                $query_run = mysqli_query($conn, $query);

                $num = mysqli_num_rows($query_run);

                if ($num < 1) {
                    
                    echo 'invalid';
                }else{

                    $row = mysqli_fetch_array($query_run);
                    
                    $surname = $row['surname'];
                    $first_name = $row['first_name'];
                    $other_name = $row['other_name'];
                    $status = $row['status'];

                    if ($status != 'active') {
                        
                        echo 'not registered';
                    }else{

                        $array = array($classes, $term, 'term', 'table');

                        $table = implode('_', $array);
                        
                        $query_two = "SELECT * FROM $table WHERE addmission_number = '$addmission_number' AND academic_session = '$session'";
                        $query_run_two = mysqli_query($conn, $query_two);

                        $num_two = mysqli_num_rows($query_run_two);

                        if ($num_two > 0) {
                            
                            echo 'data already exist';
                        }else{

                            $query_tree = "INSERT INTO $table (addmission_number, surname, first_name, other_name, term, academic_session) VALUES ('$addmission_number', '$surname', '$first_name', '$other_name', '$term', '$session')";
                            
                            $query_run_tree = mysqli_query($conn, $query_tree);

                            if ($query_tree) {
                                
                                echo 'inseted';
                            }else{
                                echo 'fail to insert';
                            }
                        }
                        
                    }
                }
            }
        }


        // multiple pupil class insertion.............................

        if ($_POST['action'] == 'insert multiple pupil class') {
            
            $prev_session = mysqli_real_escape_string($conn, $_POST['prev_session']);
            $prev_class = mysqli_real_escape_string($conn, $_POST['prev_class']);
            $next_session = mysqli_real_escape_string($conn, $_POST['next_session']);
            $next_class = mysqli_real_escape_string($conn, $_POST['next_class']);
            $term = mysqli_real_escape_string($conn, $_POST['term']);

            $session_reg = "/^([0-9]{4})\/([0-9]{4})$/";


            if (!preg_match($session_reg, $prev_session)) {
                
                echo 'invalid prev academy session';
            }else{

                if (!preg_match($session_reg, $next_session)) {
                    
                    echo 'invalid next academy session';
                }else{

                    $explod_prev_session = explode('/', $prev_session);
                    $prev_front_session = $explod_prev_session[0];
                    $prev_year = end($explod_prev_session);

                    $explod_next_session = explode('/', $next_session);
                    $next_front_session = $explod_next_session[0];
                    $next_year = end($explod_next_session);

                    if ((($next_year - $prev_year) != 1) || (($next_front_session - $prev_front_session) != 1)) {
                        
                        echo 'the two sessions must not be thesame and next session must be greater than prev session by 1';
                    }else{

                        $prev_array = array($prev_class, $term, 'term', 'table');
                        $prev_class_table = implode('_', $prev_array);

                        $next_array = array($next_class, $term, 'term', 'table');
                        $next_class_table = implode('_', $next_array);

                        $query = "SELECT * FROM $next_class_table WHERE academic_session = '$next_session'";
                        $query_run = mysqli_query($conn, $query);

                        $num = mysqli_num_rows($query_run);

                        if ($num > 0) {
                            
                            echo 'student already existing in next academy session';
                        }else{

                            $query_two = "SELECT * FROM $prev_class_table WHERE academic_session = '$prev_session'";
                            $query_run_two = mysqli_query($conn, $query_two);

                            $num_two = mysqli_num_rows($query_run_two);

                            if ($num_two < 1) {
                                
                                echo 'no such previous academy session exist';
                            }else{

                                while ($row = mysqli_fetch_array($query_run_two)) {
                                    
                                    $addmission_number = $row['addmission_number'];
                                    $surname = $row['surname'];
                                    $first_name = $row['first_name'];
                                    $other_name = $row['other_name'];

                                    $query_tree = "SELECT * FROM pupil_registration_table WHERE addmission_num = '$addmission_number'";
                                    $query_run_tree = mysqli_query($conn, $query_tree);

                                    $num_tree = mysqli_num_rows($query_run_tree);

                                    if ($num_tree > 0) {
                                        
                                        $row_tre = mysqli_fetch_array($query_run_tree);

                                        $status = $row_tre['status'];

                                        if ($status == 'active') {
                                            
                                            $query_four = "INSERT INTO $next_class_table (addmission_number, surname, first_name, other_name, term, academic_session) VALUES ('$addmission_number', '$surname', '$first_name', '$other_name', '$term', '$next_session')";

                                            $query_run_four = mysqli_query($conn, $query_four);
                                        }
                                    }

                        
                                }

                                if ($query_run_four) {
                                        
                                    echo 'inserted';
                                }else{
                                    
                                    echo 'data fail to insert';
                                }
                            }
                        }
                    }

                }
            }
        }


        // deleting pupil from class......................

        if ($_POST['action'] == 'delete pupil from class') {
            
            $id = $_POST['id'];
            $term = $_POST['term'];
            $class = $_POST['classes'];

            $array = array($class, $term, 'term', 'table');
            $class_table = implode('_', $array);
            
            $query = "DELETE FROM $class_table WHERE id = '$id'";
            $query_run = mysqli_query($conn, $query);

            if ($query_run) {
                
                echo 'data sucessfully deleteed and refresh ur browser';
            }else{

                echo 'fail to delete';
            }
        }























        
    }


?>