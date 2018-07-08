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
<title>Mont Blanc Test</title>

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
<script>
/*
var uid=localStorage.getItem('uid');
if(!isNaN(uid)){
	window.location = "step2.php";
}
*/
</script>
</head>

<body class="bg">



	<section class="mainContent step step-facebook">
		<div class="container-fluid">


			<div class="row ext-box">
				<div class="col-xs-12 col-sm-6 int-box">
					<div class="content">

						<!--<a href="step2.php" class="btn btn-lg btn-primary">Play Now</a>-->

					<!--<a href="javascript:void(0)" onclick="FB.login(function(response) {if (response.authResponse) {window.location='prize.html';}}, {scope: 'public_profile,email'});" class="btn-connect-fb"><img src="assets/images/buttons/btn_connect_fb.png"></a>-->
					<!--<fb:login-button scope="public_profile,email" onlogin="checkLoginState();" style="display:none" id="fbbtn"></fb:login-button>-->
					<!--<fb:login-button scope="public_profile,email" onlogin="window.location.reload(true);" style="display:none" id="fbbtn"></fb:login-button>-->

					<!--
					<a href="javascript:void(0)" onclick="FB.login(function(response) {if (response.authResponse) {window.location='step2.php';}}, {scope: 'public_profile,email'});" class="btn-connect-fb"><img src="assets/images/buttons/btn_connect_fb.png" ></a>
					<button class="fb-login-sim">Connect with Facebook<button>
					<fb:login-button scope="public_profile,email" onlogin="window.location.reload(true);" style="display:none" id="fbbtn"></fb:login-button>
				-->

				<!--
				<fb:login-button scope="public_profile,email" onlogin="checkLoginState();" style="display:none;"></fb:login-button>
				<div class="fb-login-button" data-max-rows="1" data-size="large" data-button-type="continue_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="false" onlogin="checkLoginState();"></div>
			-->

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
                echo "<button class=\"loginBtn loginBtn--facebook\" onclick=\"window.location.href='$loginUrl'\"> Register Mont Blanc with Facebook </button>";
				 ?>

				</div>
			</div>
		</div>

	</div>
</section>
<!--/section .mainContent-->

<form id="myForm">
<input type=hidden name="fbId" value="">
<input type=hidden name="fbName" value="">
<input type=hidden name="fbAvatar" value="">
</form>

<footer class="nav-footer nav-footer-fixed">
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12">
				<a href="index.html" class="btn btn-lg btn-primary">Back Home</a>
			</div>
		</div>
	</div>
</footer>
<!--/footer-->


<!-- javascript -->






</body>
</html>
