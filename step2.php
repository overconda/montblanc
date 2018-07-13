<?php
if (!session_id()) {
    session_start();
}



if(!isset($_SESSION['fbId'])){
    header("Location: /montblanc/");
}
$fbId = $_SESSION['fbId'];

include("dbconnect.php");
include("phpqrcode/qrlib.php");
require_once('_image_engine.php');

$arrImageTemplates = array(
    'img-templates/1.png',
    'img-templates/2.png',
    'img-templates/3.png',
    'img-templates/4.png'
);

$imageTemplate = $arrImageTemplates[array_rand($arrImageTemplates,1)];
$ImageProfile = "avatar/" . $fbId . ".jpg";



$FacebookImage = imgMergeForFB($ImageProfile, $imageTemplate, true , 260, 260, 40, 40);





$uid=0;
$ucode = "";
$name= "";
$avatar = "";
$sql = "select * from montblanc_fbuser where fbid = '$fbId' ";
try{
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll( PDO::FETCH_ASSOC );

	foreach ($result as $row) {
        $ucode = $row['ucode'];
        $uid=$row['uid'];
        $name = $row['fbname'];
        $avatar = $row['avatar'];
	}

}catch (PDOException $ev) {
	$dbh=null;
}

//// Create QR 
$qrFile = 'qr-temp/' . $ucode . '.png';
QRcode::png($ucode, $qrFile, 'L', 4, 2);

//$AlmostFinish = $FacebookImage;
//$FacebookImage = imgMergeForFB($AlmostFinish , $qrFile, 100,100, 80, 320);
$FinalImage = "ogimage/" . $ucode . ".png";
mergeImage($qrFile, $FacebookImage, $FinalImage,118,312);

$sql = "update montblanc_fbuser set fbog='$FinalImage' where ucode='$ucode' and fbid='$fbId' ";
$stmt = $dbh->prepare($sql);
$stmt->execute();

$_SESSION['FacebookImage'] = $FinalImage;

function mergeImage($imgForeground, $imgBackground, $imgFinish, $x, $y ){
    //set the source image (foreground)
    $sourceImage = $imgForeground;

    //set the destination image (background)
    $destImage = $imgBackground;

    //get the size of the source image, needed for imagecopy()
    list($srcWidth, $srcHeight) = getimagesize($sourceImage);

    //create a new image from the source image
    $src = imagecreatefrompng($sourceImage);

    //create a new image from the destination image
    $dest = imagecreatefrompng($destImage);

    //set the x and y positions of the source image on top of the destination image
    $src_xPosition = $x; // pixels from the left
    $src_yPosition = $y; // pixels from the top

    //set the x and y positions of the source image to be copied to the destination image
    $src_cropXposition = 0; //do not crop on the side
    $src_cropYposition = 0; //do not crop at the top

    //merge the source and destination images
    imagecopy($dest,$src,$src_xPosition,$src_yPosition,$src_cropXposition,$src_cropYposition,$srcWidth,$srcHeight);

    //output the merged images to a file
    imagepng($dest,$imgFinish);

    //destroy the source image
    imagedestroy($src);

    //destroy the destination image
    imagedestroy($dest);
}
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
<link rel="stylesheet" href="style.css">

<!--[if lt IE 9]>
    <script src="bower_components/html5shiv/dist/html5shiv.min.js"></script>
    <script src="bower_components/Respond/dest/respond.min.js"></script>
<![endif]-->


<script   src="https://code.jquery.com/jquery-3.3.1.min.js"   integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="   crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

</head>

<body>

    <form method="post" action="step3.php">

<!--    <p>&nbsp;</p><br><br>
    <center>
<p class="center">
    <img src="<? echo $avatar;?>" class="avatar-cir" />
</p>
<h1 class="center">Hello <? echo $name;?></h1>

<div class="row justify-content-center">
    <div class="col-md-4 ">
        <h3>ลงทะเบียนแฟนพันธุ์แท้ เจ้าชายน้อย</h3>
    </div>
</div>
-->

<div class="row justify-content-center">
    <div class="col-md-4">
        <center>
            <img src="main-head.png" class="main-logo"/>
        </center>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <img src='<? echo $FinalImage;?>' class="fbog" />
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-6 text-center">
        <h3>ลงทะเบียนแฟนพันธุ์แท้ เจ้าชายน้อย</h3>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-4 text-center">
        ชื่อ
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-4 ">
        <input type="text" name="firstname">
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-4 text-center">
       นามสกุล
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-4 ">
        <input type="text" name="lastname">
    </div>
</div>
<div class="small-space"></div>
<div class="row justify-content-center">
    <div class="col-md-2 text-center">
        เบอร์โทรศัพท์
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-4 ">
    <input type="tel" id="phone" name="phone"
           placeholder="08x-xxx-xxxx หรือ 08xxxxxxxx"
           pattern="[0-9]{3}(|-)[0-9]{3}(|-)[0-9]{4}"
           required />
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-6 text-center">
        <span class="small-text">กรุณาใส่ข้อมูลจริงเพื่อใช้ยืนยันตัวตนเมื่อได้รับรางวัล</span>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-6">
        <center>
            <button type="submit" class="btn btn-primary">ลงทะเบียน</button>
        </center>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-6 text-center">
        <span>แล้วไปพบกับการเปิดตัวพร้อมลุ้นรับ "ปากกา Montblanc คอลเลคชั่นเจ้าชายน้อย"<br>
        วันที่ 25 ก.ค.61      ชั้น M ลานจัดงาน Hall of Mirrors <br> 
        ศูนย์การค้าสยามพารากอน 
        ตั้งแต่เวลา 17.00 – 20.00 น. 
</span>
    </div>
</div>



<!--
<div class="center">
    <h4 class="center">กรุณากรอกเบอร์โทรศัพท์เพื่อใช้สำหรับการตรวจสอบหน้างาน</h4>
</div>
<p class="center">
<input type="tel" id="phone" name="phone"
           placeholder="08x-xxx-xxxx"
           pattern="[0-9]{3}(|-)[0-9]{3}(|-)[0-9]{4}"
           required />
</div>
<p>
<input type='submit' value="กดเพื่อลงทะเบียน">
</p>
-->
</form>
<br><br><br>
</center>
</body>
</html>
