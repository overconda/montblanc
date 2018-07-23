<?php
session_start();

if(!isset($_SESSION['montblancadmin'])){
    if($_SESSION['montblancadmin']!='admin'){
        header("Location: login.php");
    }
}
include("../dbconnect.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Montblanc Lucky Draw</title>

    <!-- Bootstrap core CSS -->
    <link href="https://fonts.googleapis.com/css?family=Prompt" rel="stylesheet">
    <link href="https://overall.studio/montblanc/font/MontblancType-Regular.css" rel="stylesheet">
    <link href="https://overall.studio/montblanc/font/MontblancType-Italic.css" rel="stylesheet">
    <link href="https://overall.studio/montblanc/font/MontblancType-Bold.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
    <link href="lucky.css" rel="stylesheet">

  </head>

  <body>

    <div class="row justify-content-center">
        <div class="col-md-4">
            <center>
                <img src="../main-head.png" class="main-logo"/>
            </center>
        </div>
    </div>

    <?php
    $sql = "select *  from montblanc_fbuser where (firstname is not null and lastname is not null) order by cdate desc ";
    
    $data=array();
    $i=0;
    try{
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll( PDO::FETCH_ASSOC );
    
        foreach ($result as $row) {
            
            $data[$i]['ucode'] = $row['ucode'];
            $data[$i]['fbid']  = $row['fbid'];
            $data[$i]['fbname']  = $row['fbname'];
            $data[$i]['firstname']  = $row['firstname'];
            $data[$i]['lastname']  = $row['lastname'];
            $data[$i]['avatar']  = '../'. $row['avatar'];
            $data[$i]['email']  = $row['email'];
            $data[$i]['phone']  = $row['phone'];
            $data[$i]['cdate'] = $row['cdate'];
            $i++;
        }
    }catch (PDOException $ev) {
        $dbh=null;
        echo "DB error";
    }

    shuffle_assoc($data);   // shuffle array

    foreach($data as $d){
        $text = $d['firstname'] . ' ' . $d['lastname'];
        if(trim($text)<>""){
            //Set the Content Type
            //header('Content-type: image/jpeg');

            // Create Image From Existing File
            $jpg_image = imagecreatefromjpeg('card.jpg');

            // Allocate A Color For The Text
            $black = imagecolorallocate($jpg_image, 0, 0, 0);

            // Set Path to Font File
            $font_path = '../font/MontblancType-Regular.ttf';

            // get image dimensions
            list($img_width, $img_height,,) = getimagesize("card.jpg");

            // find font-size for $txt_width = 80% of $img_width...
            $font_size = 1; 
            $txt_max_width = intval(0.8 * $img_width);  

            do {        
                $font_size++;
                $p = imagettfbbox($font_size, 0, $font_path, $text);
                $txt_width = $p[2] - $p[0];
                // $txt_height=$p[1]-$p[7]; // just in case you need it
            } while ($txt_width <= $txt_max_width);

            // now center the text
            $y = $img_height * 0.5; // baseline of text at 50% of $img_height
            $x = ($img_width - $txt_width) / 2;

            // Print Text On Image
            imagettftext($jpg_image, $font_size, 0, $x, $y, $black, $font_path, $text);

            $filename = 'card/' . $d['ucode'] . '.jpg';
            // Send Image to Browser
            imagejpeg($jpg_image , $filename);

            // Clear Memory
            imagedestroy($jpg_image);
            //echo "\n<!-- try card : $filename with $text -->";
        }
        
    }
    ?>
<center>
    <ul id='slideshow'>
        <?php
        foreach($data as $d){
            $img = $d['ucode'] . ".jpg";
            echo "\n\t\t<li><img src='card/$img' /></li>";
        }
        ?>
        <!--
  <li><img src='http://placehold.it/500x200&text=Mak Ka Veng' alt=''></li>
  <li><img src='http://placehold.it/500x200&text=Ho Kit Zi' alt=''></li>
  <li><img src='http://placehold.it/500x200&text=Aaden Chan' alt=''></li>
  <li><img src='http://placehold.it/500x200&text=Kin Ho' alt=''></li>
  <li><img src='http://placehold.it/500x200&text=Johnson Lam' alt=''></li>
  <li><img src='http://placehold.it/500x200&text=Simon Leong' alt=''></li>
  <li><img src='http://placehold.it/500x200&text=Veng Mak' alt=''></li>
  <li><img src='http://placehold.it/500x200&text=Victor Vong' alt=''></li>
    -->
</ul>

<br><br><br>
<button id='again' class="btn btn-info btn-lg">Lucky!</button>


<br><br><br><br><br><br><br><br><br><br><br><br>
    </center>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js"></script>
    <script src="firework.js"></script>
    <script language="javascript">
        /*Downloaded from https://www.codeseek.co/makzan/lucky-draw-effect-WbeXRq */
        var slides = $('#slideshow').find('li');


        // move all to the right.
        slides.addClass('in');

        // move first one to current.
        $(slides[0]).removeClass().addClass('current');

        var currentIndex = 0;
        
        var minimumCount = 50;
        var maximumCount = 200;
        var breakPointA = maximumCount - 60;
        var breakPointB = maximumCount - 40;
        var breakPointC = maximumCount - 20;
        var breakPointD = maximumCount - 10;
        var breakPointE = maximumCount - 5;
        //var 
        var count = 0;

        function nextSlide() {
            $('#again').attr('disabled','disabled');

            var interval = 240;
            
            currentIndex += 1;
            if (currentIndex >= slides.length) {
                currentIndex = 0;
            }
            
            // move any previous 'out' slide to the right side.
            $('.out').removeClass().addClass('in');
            
            // move current to left.
            $('.current').removeClass().addClass('out');
            
            // move next one to current.
            $(slides[currentIndex]).removeClass().addClass('current');
            
            
            count += 1;
            if (count > maximumCount){//} || (count > minimumCount && Math.random()>0.6) ) {
                //clearInterval(interval);
            
                
                $('#again').removeAttr('disabled');
                runFirework();
            }else{
                interval = 120;
                if(count > breakPointA){
                    interval = 260;    
                }else if(count > breakPointB){
                    interval = 500;
                }else if(count > breakPointC){
                    interval = 800;
                }else if(count > breakPointD){
                    interval = 1600;
                }else if(count > breakPointE){
                    interval = 2600;
                }

                setTimeout(nextSlide, interval);
            }
        }

        //var interval = setInterval(nextSlide, 220);


        $('#again').click(function(){  
            count = 0;
            //interval = setInterval(nextSlide, 220);
            nextSlide();
        });
    </script>
  </body>
</html>
<?php

function shuffle_assoc(&$array) {
    $keys = array_keys($array);
    shuffle($keys);
    foreach($keys as $key) {
        $new[$key] = $array[$key];
    }
    $array = $new;
    return true;
}
?>
