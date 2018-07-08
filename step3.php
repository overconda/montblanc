<?php
if (!session_id()) {
    session_start();
}

include("dbconnect.php");

$fbId = $_SESSION['fbId'];

$phone = $_POST['phone'];

$sql = "update montblanc_fbuser set phone = '$phone' where fbid='$fbId' ";
$stmt = $dbh->prepare($sql);
$stmt->execute();


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
    <p>&nbsp;</p><br><br>
    <center>
<p class="center">
    <img src="<? echo $avatar;?>" class="avatar-cir" />
</p>
<h1 class="center">คุณ <? echo $name;?></h1>
<h2>ได้ลงทะเบียนเรียบร้อยแล้ว</h2>

<?php
// img width 280;
?>

</center>
</body>
</html>
