<?php
require_once 'Facebook/autoload.php';
$fb = new Facebook\Facebook([
  'app_id' => '221982878480421', // Replace {app-id} with your app id
  'app_secret' => 'c8e24b5e89b1e0901574897190ff5e72',
  'default_graph_version' => 'v2.2',
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email','user_photos']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://localhost/rtCamp/fb-callback.php', $permissions);

//echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="bootstrap-4.1.3-dist/css/bootstrap.css">
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
	<title>Log In</title>
</head>
<body>
	<div class="container" style="margin-top: 100px">
			<div class="row justify-content-center">
				<div class="col-md-6 col-md-offset-3 table-bordered" align="center">
					<h6 style="font-family: Montserrat;color:#7c2c7b" class="glyphicon-font">rtCamp Challenge by Rana Digvijaysinh</h6>
					<img style="padding: 20" height="40px" width="40px" src="images/login.png">
					<form method="POST">
					<input type="button" name="btnLogin" onclick="window.location = '<?php echo $loginUrl ?>';" class="btn btn-info" value="Facebook">
					</form>
			</div>
		</div>
	</div>
</body>
</html>