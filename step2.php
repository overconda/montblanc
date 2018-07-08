<?php
if (!session_id()) {
    session_start();
}

include("dbconnect.php");

$fbId = $_SESSION['fbId'];

$uid=0;
$name= "";
$avatar = "";
$sql = "select * from montblanc_fbuser where fbid = '$fbId' ";
try{
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll( PDO::FETCH_ASSOC );

	foreach ($result as $row) {
        $uid=$row['uid'];
        $name = $row['fbname'];
        $avatar = $row['avatar'];
	}

}catch (PDOException $ev) {
	$dbh=null;
}

?>
<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>Mont Blanc</title>

<meta name="title" content="Mont Blanc" />
<meta name="description" content="" />
<meta name="keyword" content="" />


<!-- CSS -->
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">

<!--[if lt IE 9]>
    <script src="bower_components/html5shiv/dist/html5shiv.min.js"></script>
    <script src="bower_components/Respond/dest/respond.min.js"></script>
<![endif]-->


<script   src="https://code.jquery.com/jquery-3.3.1.min.js"   integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="   crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

</head>

<body>
    <form method="post" action="step3.php">
    <p>&nbsp;</p><br><br>
    <center>
<p class="center">
    <img src="<? echo $avatar;?>" class="avatar-cir" />
</p>
<h1 class="center">Hello <? echo $name;?></h1>

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
</form>
</center>
</body>
</html>
