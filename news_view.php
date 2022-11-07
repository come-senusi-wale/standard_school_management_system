<?php


    include('action_php/database.php');

    if (isset($_GET['id'])) {
        
        $id = $_GET['id'];

        $query = "SELECT * FROM news_table WHERE id = '$id' AND status = 'published'";
        $query_run = mysqli_query($conn, $query);

        $row = mysqli_fetch_array($query_run);
        
        $title = $row['title'];
        $body = $row['body'];
        $image = $row['image'];
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/headers_css.css">
    <link rel="stylesheet" href="css/news_views_css.css">
    <link rel="stylesheet" href="css/footers_css.css">
    <link rel="stylesheet" href="css/sidebars_css.css">

    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <title>news</title>
</head>
<body>

    <!-- header -->

    <?php include('general/header.php');  ?>


    <section id="news_view">

        <div id="news_view_head">
            <h2><?php echo $title ?></h2>
        </div>

        <div id="news_view_img">
            <img src="image/news/<?php echo $image ?>" alt="">
        </div>

        <div id="news_view_content">

            <?php 

                $body_arr = explode('..', $body);
                foreach ($body_arr as $value) {
                   
                    ?>
                        <p><?php echo $value ?>.</p>

                    <?php
                }
            
            ?>
           
        </div>
        
    </section>


    

  





    

    <!-- footer -->

    <?php include('general/footer.php') ?>

    


    <!--side bar section-->
    <?php include('general/sidebar.php') ?>

    

    




    <script src="javascript/home_js.js"></script>
    
</body>
</html>