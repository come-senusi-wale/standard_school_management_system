

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/headers_css.css">
    <link rel="stylesheet" href="css/contact_usss_css.css">
    <link rel="stylesheet" href="css/footers_css.css">
    <link rel="stylesheet" href="css/sidebars_css.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    

    <link rel="stylesheet" href="fontawesome/css/all.min.css">

    <script src="javascript/jquery.js"></script>
    <title>contact us</title>

    
</head>
<body>

    <!-- header -->

    <?php include('general/header.php');  ?>


    
    <div id="contact_header">
        <h3>contact us</h3>
    </div>

    <div id="map"></div>

    <section id="contact_us">

        <div id="contact_content">

            <div id="contact_location">

                <div class="contect">

                    <div class="icon">
                        <i class='fas fa-map-marker-alt'></i>
                    </div>

                    <div class="content">
                        <h3>location:</h3>
                        <p>Ankpa-Anyigba Express Way, Ejegbo Byepass Ankpa, Kogi State</p>
                    </div>

                </div>

                <div class="contect">

                    <div class="icon">
                        <i class="fa fa-envelope"></i>
                    </div>

                    <div class="content">
                        <h3>email:</h3>
                        <p>eduspringofgrace@gmail.com</p>
                    </div>

                </div>

                <div class="contect">

                    <div class="icon">
                        <i class="fa fa-phone"></i>
                    </div>

                    <div class="content">
                        <h3>call:</h3>
                        <p>+234 8062 6396 69, +234 7034 1405 15</p>
                    </div>

                </div>

            </div>

            <div id="contact_meg">

                <div id="contect_error">
                    <p id="correct"></p>
                    <p id="error"></p>
                </div>

                <div class="email_name_contanere">

                    <div class="email_name">
                        <input type="text" name="name" id="name" placeholder="Your Name">
                    </div>

                    <div class="email_name">
                        <input type="email" name="email" id="email" placeholder="Your Email">
                    </div>

                </div>

                <div class="subject">
                    <input type="text" name="subject" id="subject" placeholder="Subject">
                </div>

                <div class="msg">
                    <textarea name="msg" id="msg" placeholder="Message"></textarea>
                </div>

                <div class="submit">
                    <input type="submit" id="submit" name="submit" value="send message">
                </div>

            </div>

        </div>
    </section>


    

    

    <!-- footer -->

    <?php include('general/footer.php') ?>

    


    <!--side bar section-->
    <?php include('general/sidebar.php') ?>

    

    




    
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

    <script src="javascript/home_js.js"></script>

    <script>
        var map = L.map('map').setView([7.4197, 7.6184], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.marker([7.4197, 7.6184]).addTo(map)
            .bindPopup('Spring of Grace Group of School')
            .openPopup();
    </script>


<script>
    $(document).ready(function(){

        $('#submit').click(function(event){

            event.preventDefault();
            
            var name = $('#name').val();
            var email = $('#email').val();
            var subject = $('#subject').val();
            var msg = $('#msg').val();

            if (name == '' || email == '' || subject == '' || msg == '') {
                
              
                $('#error').text('fill all the inputs');
            }else{

                $.ajax({
                    url: 'action_php/contact_action.php',
                    data: {action: 'contact us', name, email, subject, msg},
                    method: 'POST',
                    dataType: 'text',
                    beforeSend: function(){
                        $('#submit').val('sending.......');
                        $('#submit').attr('disabled', 'disabled');
                    },

                    success: function(data){
                       
                        if (data == 'send') {

                            $('#correct').text('message successfully sent');

                            var name = $('#name').val('');
                            var email = $('#email').val('');
                            var subject = $('#subject').val('');
                            var msg = $('#msg').val('');

                            
                        }else{

                            $('#error').text(data);

                        }

                        
                        $('#submit').val('send message');
                        $('#submit').attr('disabled', false);
                    }
                })
            }

            setTimeout(() => {

            $('#error').text('');
            $('#correct').text('');
            }, 15000);

        })
    })
</script>

</body>
</html>