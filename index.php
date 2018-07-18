<?php

if (!session_id()) {
    session_start();
}

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>Montblanc Le Petit Prince collection</title>

<meta name="title" content="Montblanc Le Petit Prince collection" />
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
<script>
/*
var uid=localStorage.getItem('uid');
if(!isNaN(uid)){
	window.location = "step2.php";
}
*/
</script>
</head>

<body >

	<div class="row justify-content-center">
    <div class="col-md-4">
        <center>
            <img src="main-head.png" class="main-logo"/>
        </center>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-6 text-center">
        <h3>ลุ้นเป็นผู้โชคดีที่จะได้เป็นเจ้าของ ปากกา Montblanc Le Petit Prince collection
			<br> มูลค่ากว่า 40,000 บาท

	</h3>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-6 text-center">
	<?php
				require_once 'src/Facebook/autoload.php';

				$fb = new Facebook\Facebook([
				  'app_id' => '1940665059558112',
				  'app_secret' => 'd3bc38e32f45c296702b4e8494f54e57',
				  'default_graph_version' => 'v3.0',
				  ]);

				$helper = $fb->getRedirectLoginHelper();

				$permissions = ['email']; // Optional permissions
				$loginUrl = $helper->getLoginUrl('https://overall.studio/montblanc/fb-callback.php', $permissions);

				//echo '<a href="' . htmlspecialchars($loginUrl) . '">Continue with Facebook</a>';

                //echo '<a class="btn btn-block btn-social btn-facebook" href="' . htmlspecialchars($loginUrl) . '"><i class="fb-icon"></i> Continue with Facebook </a>';
                //echo '<fb:login-button size="xlarge" onlogin="Log.info.bind(\'onlogin callback\')">MMMBBB</fb:login-button>';
                echo "<button class=\"loginBtn loginBtn--facebook\" onclick=\"window.location.href='$loginUrl'\"> ลงทะเบียนด้วย Facebook </button>";
				 ?>
    </div>
</div>

	
<!--/section .mainContent-->

<form id="myForm">
<input type=hidden name="fbId" value="">
<input type=hidden name="fbName" value="">
<input type=hidden name="fbAvatar" value="">
</form>

<!--/footer-->


<!-- javascript -->






</body>
</html>
