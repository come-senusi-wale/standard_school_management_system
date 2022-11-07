<?php

    include('action_php/database.php');

    $query = "SELECT * FROM news_table WHERE status = 'published' ORDER BY id DESC LIMIT 50";
    $query_run = mysqli_query($conn, $query);

    $num = mysqli_num_rows($query_run);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/headers_css.css">
    <link rel="stylesheet" href="css/news_css.css">
    <link rel="stylesheet" href="css/footers_css.css">
    <link rel="stylesheet" href="css/sidebars_css.css">

    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <title>news</title>
</head>
<body>

    <!-- header -->

    <?php include('general/header.php');  ?>


    <section id="news">

        <div id="news_header">
            <h2>school news blog</h2>
        </div>

        <section id="news_divide">

            <div id="news_container">

                <?php

                    if ($num > 0) {
                       
                        while ($row = mysqli_fetch_array($query_run)) {
                            
                            $id = $row['id'];
                            $title = $row['title'];
                            $image = $row['image'];

                            ?>

                                <div class="new_content">
                                    <a href="news_view.php?id=<?php echo $id ?>">
                                        <h3><?php echo $title ?></h3>
                                        <div class="news_img">
                                            <img src="image/news/<?php echo $image ?>" alt="">
                                        </div>
                                    </a>
                                </div>

                            <?php
                        }
                    }
                
                ?>


            </div>

            <div id="news_update">

                <div id="update_head">
                    <h2>news and updates</h2>
                </div>

                <div class="update_link_news">
                    <h3>popular stories today</h3>

                    <?php

                        $query_two = "SELECT * FROM news_table WHERE status = 'published' ORDER BY id DESC LIMIT 10";
                        $query_run_two = mysqli_query($conn, $query_two);

                        $num_two = mysqli_num_rows($query_run_two);

                        if ($num_two > 0) {
                           
                            while ($row_two = mysqli_fetch_array($query_run_two)) {
                                
                                $id_two = $row_two['id'];
                                $title_two = $row_two['title'];
                                
                                ?>

                                  <div class="update_link">
                                    <a href="news_view.php?id=<?php echo $id_two ?>">
                                        <?php echo $title_two ?>
                                    </a>
                                </div>


                                <?php
                            }
                        }
                    
                    ?>

                  
                   
                </div>

            </div>
        </section>

    </section>


  





    

    <!-- footer -->

    <?php include('general/footer.php') ?>

    


    <!--side bar section-->
    <?php include('general/sidebar.php') ?>

    

    




    <script src="javascript/home_js.js"></script>
    
</body>
</html>