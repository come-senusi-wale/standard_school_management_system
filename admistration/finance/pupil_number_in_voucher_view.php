<?php

    session_start();

    if (!isset($_SESSION['finance_officer_id_code'])) {
        
        header("location: finance_officer_login.php");
    }

    include('action_php/database.php');

    if (isset($_POST['submit'])) {
        $session = mysqli_real_escape_string($conn, $_POST['session']);
        $term = mysqli_real_escape_string($conn, $_POST['term']);
        $class = mysqli_real_escape_string($conn, $_POST['class']);
        $voucher_num = mysqli_real_escape_string($conn, $_POST['voucher_num']);

        if (empty($session) || empty($term) || empty($class) || empty($voucher_num)) {
            
            $fail = 'fill all the inputs';
            header("location: pupil_number_in_voucher_form.php?fail=$fail");
            exit();

        }else {

            $session_reg = "/^([0-9]{4})\/([0-9]{4})$/";
            if (!preg_match($session_reg, $session)) {
                    
                $fail = 'academic session format is incorrect';
                header("location: pupil_number_in_voucher_form.php?fail=$fail");
                exit();
            }else {
                
                $query = "SELECT * FROM pupil_class_voucher_table WHERE term = '$term' AND session = '$session' AND class = '$class' AND voucher_num = '$voucher_num'";
                $query_run = mysqli_query($conn, $query);

                $num = mysqli_num_rows($query_run);

                if ($num < 1) {
                    
                    $fail = 'no voucher for this class';
                    header("location: pupil_number_in_voucher_form.php?fail=$fail");
                    exit();

                }else {

                    $array_two = array($class, 'payment', 'table');
                    $payment_table = implode('_', $array_two);

                    $query_two = "SELECT * FROM $payment_table WHERE term = '$term' AND session = '$session' AND voucher_num = '$voucher_num'";
                    $query_run_two = mysqli_query($conn, $query_two);

                    $num_two = mysqli_num_rows($query_run_two);

                    if ($num_two < 1) {
                        
                        $fail = 'no voucher for this class';
                        header("location: pupil_number_in_voucher_form.php?fail=$fail");
                        exit();

                    }else {
                        
                        echo 'correct';
                    }

                }
            }
            
        }

    }


?>



!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pupils voucher generation form</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/links_css.css">
    <link rel="stylesheet" href="../admin_officer/css/student_registration_detail_css.css">


    <script src="../../javascript/jquery.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</head>
<body>

    <?php include('links.php') ?>

    <section id="reg_section">
        <div class="reg_header">
            <h2><?php echo $class.' '.$term ?> term payment  details</h2>
            <p id="error" style="color: red;"></p>
            <h2>academic session:<?php echo $session ?> </h2>
        </div>
    
        <div class="reg_body">
    
            <div class="reg_table">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>name</th>
                            <th>addmission No</th>
                            <th>amount</th>
                            <th>amount paid</th>
                            <th>balance</th>
                            <th>voucher ID</th>
                            <th>view</th>
                            
                        </tr>
                    </thead>
                    <tbody>

                        <?php

                            $count = 0;
                        
                            while ($row = mysqli_fetch_array($query_run_two)) {
                                
                                $count++;

                                $id = $row['id'];
                                $name = $row['name'];
                                $addmission_num = $row['addmission_num'];
                                
                                $amount = $row['amount'];
                                $amount_paid = $row['amount_paid'];
                                $balance = $row['balance'];
                                
                                $voucher_num = $row['voucher_num'];

                                $view = '<a href="single_pupil_transaction_detail_view.php?id='.$id.'&addmission_num='.$addmission_num.'&class='.$class.'&term='.$term.'&session='.$session.'&name='.$name.'" class="view_btn" id="edit'.$id.'" data-id="'.$id.'">view</a>';

                                ?>

                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $name; ?></td>
                                    <td><?php echo $addmission_num; ?></td>
                                    <td>₦<?php echo $amount; ?></td>
                                    <td>₦<?php echo $amount_paid; ?></td>
                                    <td>₦<?php echo $balance; ?></td>
                                    <td><?php echo $voucher_num; ?></td>
                                    <td><?php echo $view; ?></td>
                                    
                                </tr>

                            <?php

                                
                            }

                        ?>

                   

                    <!-- using database .....................
                        <tr>
                            <td>4444</td>
                            <td>4444</td>
                            <td>akin</td>
                            <td>wale</td>
                            <td>saheed</td>
                            <td>js 1</td>
                            <td>2020/2032</td>
                            <td>2020/2032</td>
                            <td><button type="button" class="view_btn">view</button></td>
                            <td><button type="button" class="edit_btn">edit</button></td>
                            <td><button type="button" class="delete_btn">delete</button></td>
                        </tr>
                        <tr>
                            <td>4444</td>
                            <td>4444</td>
                            <td>akin</td>
                            <td>wale</td>
                            <td>saheed</td>
                            <td>js 1</td>
                            <td>2020/2032</td>
                            <td>2020/2032</td>
                            <td><button type="button" class="view_btn" id="id" data-id="id">view</button></td>
                            <td><button type="button" class="edit_btn" id="id" data-id="id">edit</button></td>
                            <td><button type="button" class="delete_btn" id="id" data-id="id">delete</button></td>
                        </tr>
                        <tr>
                            <td>4444</td>
                            <td>4444</td>
                            <td>akin</td>
                            <td>wale</td>
                            <td>saheed</td>
                            <td>js 1</td>
                            <td>2020/2032</td>
                            <td>2020/2032</td>
                            <td><button type="button" class="view_btn">view</button></td>
                            <td><button type="button" class="edit_btn">edit</button></td>
                            <td><button type="button" class="delete_btn">delete</button></td>
                        </tr>
                        <tr>
                            <td>4444</td>
                            <td>4444</td>
                            <td>akin</td>
                            <td>wale</td>
                            <td>saheed</td>
                            <td>js 1</td>
                            <td>2020/2032</td>
                            <td>2020/2032</td>
                            <td><button type="button" class="view_btn">view</button></td>
                            <td><button type="button" class="edit_btn">edit</button></td>
                            <td><button type="button" class="delete_btn">delete</button></td>
                        </tr>
                        -->
                    
                        
                    </tbody>
                </table>
            </div>

            
            
        </div>
    </section>


    
</body>
</html>