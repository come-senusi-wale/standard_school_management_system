<?php
    

    session_start();
    if (!isset($_SESSION['admin_id_code'])) {
        
        header("location: admin_officer_login.php");
    }

    include('action_php/database.php');

    



    //if (isset($_POST['submit'])) {

        $limit = 50;

        if (isset($_GET['page']) && isset($_GET['session'])) {
            
            $page = $_GET['page'];
            $academic_session = $_GET['session'];
            
        }else{

            $page = 1;
            $academic_session = mysqli_real_escape_string($conn, $_POST['session']);
            
        }



        $start_from = ($page - 1) * $limit;


        //counting.................

        $query_two = "SELECT count(*) AS total FROM student_registration_table WHERE session = '$academic_session' ORDER BY current_class";
        $query_run_two = mysqli_query($conn, $query_two);

        $row_two = mysqli_fetch_array($query_run_two);
        $total_data = $row_two['total'];

        $total_page = ceil($total_data/$limit);

        if ($page >= $total_page) {
            $next = $total_page;
        }else{
            $next = $page + 1;
        }

        if ($page <= 1) {
            
            $prev= 1;
        }else{
            $prev = $page - 1;
        }

        
        
        //$academic_session = mysqli_real_escape_string($conn, $_POST['session']);
        // select student data................................
        $query = "SELECT * FROM student_registration_table WHERE session = '$academic_session' ORDER BY current_class LIMIT $start_from, $limit ";

        $query_run = mysqli_query($conn, $query);


        $num = mysqli_num_rows($query_run);

        if ($num < 1) {

            $out = 'no result found check ur input';
            
            header("location: student_registration_details_form.php? result=$out");
            
        }else{

        





?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>student details</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/links_css.css">
    <link rel="stylesheet" href="css/student_registration_detail_css.css">
    

    <script src="javascript/jquery.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    
</head>
<body>


    <?php include('links.php'); ?>
    

    <section id="reg_section">
        <div class="reg_header">
            <h2>student details</h2>
            <p id="error" style="color: red;"></p>
            <h2>academic session: <?php echo $academic_session; ?></h2>
        </div>
    
        <div class="reg_body">
    
            <div class="reg_table">
                <table>
                    <thead>
                        <tr>
                            <th>addmission number</th>
                            <th>surname</th>
                            <th>first name</th>
                            <th>other name</th>
                            <th>current class</th>
                            <th>academic session</th>
                            <th>view</th>
                            <th>edit</th>
                            <th>delete</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php

                           
                                while ($row = mysqli_fetch_array($query_run)) {
                                    $id = $row['id'];
                                    $addmission_num = $row['addmission_num'];
                                    $surname = $row['surname'];
                                    $first_name = $row['first_name'];
                                    $other_name = $row['other_name'];
                                    $current_class = $row['current_class'];
                                    $session = $row['session'];

                                    $view ='<a href="student_detail_view.php?id='.$id.'" class="view_btn" id="view'.$id.'" data-id="'.$id.'">view</a>';
                                    $edit = '<a href="student_details_editing.php?id='.$id.'" class="edit_btn" id="edit'.$id.'" data-id="'.$id.'">edit</a>';
                                    
                                    $delete = '<button type="button" class="delete_btn" id="delete'.$id.'" data-id="'.$id.'">delete</button>';

                                    ?>

                                        <tr>
                                            <td><?php echo $addmission_num; ?></td>
                                            <td><?php echo $surname; ?></td>
                                            <td><?php echo $first_name; ?></td>
                                            <td><?php echo $other_name; ?></td>
                                            <td><?php echo $current_class; ?></td>
                                            <td><?php echo $session; ?></td>
                                            <td><?php echo $view; ?></td>
                                            <td><?php echo $edit; ?></td>
                                            <td><?php echo $delete; ?></td>
                                        </tr>

                                    <?php


                                }
                                
                            }
                       // }

                    ?>

                    <!-- load infomation from data base......................
                        <tr>
                            <td>4444</td>
                            <td>akin</td>
                            <td>wale</td>
                            <td>saheed</td>
                            <td>js 1</td>
                            <td>2020/2032</td>
                            <td><button type="button" class="view_btn">view</button></td>
                            <td><button type="button" class="edit_btn">edit</button></td>
                            <td><button type="button" class="delete_btn">delete</button></td>
                        </tr>
                        <tr>
                            <td>4444</td>
                            <td>akin</td>
                            <td>wale</td>
                            <td>saheed</td>
                            <td>js 1</td>
                            <td>2020/2032</td>
                            <td><button type="button" class="view_btn" id="id" data-id="id">view</button></td>
                            <td><button type="button" class="edit_btn" id="id" data-id="id">edit</button></td>
                            <td><button type="button" class="delete_btn" id="id" data-id="id">delete</button></td>
                        </tr>
                        <tr>
                            <td>4444</td>
                            <td>akin</td>
                            <td>wale</td>
                            <td>saheed</td>
                            <td>js 1</td>
                            <td>2020/2032</td>
                            <td><button type="button" class="view_btn">view</button></td>
                            <td><button type="button" class="edit_btn">edit</button></td>
                            <td><button type="button" class="delete_btn">delete</button></td>
                        </tr>
                        <tr>
                            <td>4444</td>
                            <td>akin</td>
                            <td>wale</td>
                            <td>saheed</td>
                            <td>js 1</td>
                            <td>2020/2032</td>
                            <td><button type="button" class="view_btn">view</button></td>
                            <td><button type="button" class="edit_btn">edit</button></td>
                            <td><button type="button" class="delete_btn">delete</button></td>
                        </tr>
                    -->
                        
                    </tbody>
                </table>
            </div>

            <div class="page">
                <ul></ul>
                
                <ul id="pages">
                    
                    <li><a data-id="prev" href="student_registration_detail.php?page=<?php echo $prev ?>&amp;session=<?php echo $academic_session?>">prev</a></li>
                    <?php
                        for ($i=1; $i <= $total_page; $i++) { 
                    ?>
                            <li><a data-id="<?php echo $i ?>" href="student_registration_detail.php?page=<?php echo $i ?>&amp;session=<?php echo $academic_session?>"><?php echo $i ?></a></li>
                    <?php
                        }
                    ?>
                    <li><a data-id="next" href="student_registration_detail.php?page=<?php echo $next ?>&amp;session=<?php echo $academic_session?>">next</a></li>
                </ul>
            </div>
            
        </div>
    </section>



    <script>
        $(document).ready(function(){



            // deleting student detail with ajax....................................

            $(document).on('click', '.delete_btn', function(event){

                if (confirm('are you sure you want to delete this detail')) {
                    
                    var id = event.target.getAttribute('data-id');
                    
                    $.ajax({
                        url: 'action_php/multipurpose_action.php',
                        data: {action: 'deleting student registration detail', id: id},
                        method: 'POST',
                        dataType: 'text', 

                        beforeSend: function(){
                            $('#delete'+id).text('deleting.......');
                            $('#delete'+id).attr('disabled', 'disabled');
                            
                        }, 

                        success: function(data){
                            $('#delete'+id).text('delete');
                            $('#delete'+id).attr('disabled', false);

                            if (data == 'deleted') {
                                
                                alert('data successfully deleted');

                                $('#error').text('data successfully deleted');
                                
                                setTimeout(function(){

                                    $('#error').text('');
                                }, 10000);

                            }else{
                                
                                $('#error').text(data);
                                
                                setTimeout(function(){

                                    $('#error').text('');
                                }, 10000);

                            }
                            
                            
                        }
                    })

                }
            })














        })
    </script>

    

</body>
</html>