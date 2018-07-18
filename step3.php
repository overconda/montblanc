<?php
if (!session_id()) {
    session_start();
}
if(!isset($_SESSION['fbId'])){
    header("Location: /montblanc/");
}

include("dbconnect.php");

$fbId = $_SESSION['fbId'];

//$fullname = $_POST['fullname'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$phone = $_POST['phone'];

$sql = "update montblanc_fbuser set firstname = '$firstname', lastname='$lastname' , phone = '$phone' where fbid='$fbId' ";

$stmt = $dbh->prepare($sql);
$stmt->execute();


$uid=0;
$name= "";
$avatar = "";
$ucode = "";
$sql = "select * from montblanc_fbuser where fbid = '$fbId' ";
try{
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll( PDO::FETCH_ASSOC );

	foreach ($result as $row) {
        $uid=$row['uid'];
        $name = $row['fbname'];
        $avatar = $row['avatar'];
        $ucode = $row['ucode'];
	}

}catch (PDOException $ev) {
	$dbh=null;
}

$FacebookImage = $_SESSION['FacebookImage'];

?>
<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>Montblanc</title>

<meta name="title" content="Mont Blanc" />
<meta name="description" content="" />
<meta name="keyword" content="" />


<!-- CSS -->
<link href="https://fonts.googleapis.com/css?family=Prompt" rel="stylesheet">
<link href="https://overall.studio/montblanc/font/MontblancType-Regular.css" rel="stylesheet">
<link href="https://overall.studio/montblanc/font/MontblancType-Italic.css" rel="stylesheet">
<link href="https://overall.studio/montblanc/font/MontblancType-Bold.css" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="style.css">


<!--[if lt IE 9]>
    <script src="bower_components/html5shiv/dist/html5shiv.min.js"></script>
    <script src="bower_components/Respond/dest/respond.min.js"></script>
<![endif]-->


<script   src="https://code.jquery.com/jquery-3.3.1.min.js"   integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="   crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

</head>

<body>
<div class="row justify-content-center">
    <div class="col-md-4">
        <center>
            <img src="main-head.png" class="main-logo"/>
        </center>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <img src='<? echo $FacebookImage;?>' class="fbog" />
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-6">
        <h3 class=" text-center">คุณลงทะเบียนแฟนพันธุ์แท้ <br>เจ้าชายน้อย เรียบร้อยแล้ว</h3>
        <span>
        แล้วไปพบกันในงานเปิดตัว ปากกา  Montblanc Le Petit Prince collection 
พร้อมลุ้นเป็นผู้โชคดีที่จะได้เป็นเจ้าของ ปากกา  Montblanc Le Petit Prince collection มูลค่ากว่า 40,000 บาท
ในวันที่ 25 กรกฎาคม 2561 ชั้น M ลานจัดงาน Hall of Mirrors  ศูนย์การค้าสยามพารากอน ตั้งแต่เวลา 17.00 – 20.00 น. 

</span>
    </div>
</div>

<script>
    window.fbAsyncInit = function() {
        FB.init({
        appId            : '1940665059558112',
        autoLogAppEvents : true,
        xfbml            : true,
        version          : 'v3.0'
        });
    };
    
    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
<div class="row justify-content-center">
    <div class="col-md-6">
        <center>
        <a href="#" class="fa fa-facebook" id="shareBtn"><span class='fa--sep'>|</span> Share ความเป็นเจ้าชายน้อยในตัวคุณ</a>
    </center>
    
    </div>
</div>
<!--
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0&appId=1940665059558112&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="row justify-content-center">
    <div class="col-md-6">
<div class="fb-share-button " data-href="https://overall.studio/montblanc/view/<?php echo $ucode;?>" data-layout="button" data-size="large" data-mobile-iframe="false" ><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2Foverall.studio%2Fmontblanc%2Fview%2F<?php echo $ucode?>" class="fb-xfbml-parse-ignore">Share ความเป็นเจ้าชายน้อยของคุณ</a></div>
    </div></div>
-->
<br><br><br>
<script>
        document.getElementById('shareBtn').onclick = function() {
          FB.ui({
            method: 'share',
            display: 'popup',
            href: 'http://overall.studio/montblanc/view/<?php echo $ucode;?>',
          }, function(response){});
        }
        </script>  
</center>
</body>
</html>
