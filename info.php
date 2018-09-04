<?php
	session_start();

	if (!isset($_SESSION['fb_access_token'])) {
		header('Location: login.php');
		exit();
	}
	
		//header('Location: index.php');
?>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script type="text/javascript">
		$(window).load(function() {
		  $('.flexslider').flexslider({
		    animation: "slide"
		  });
		});
	</script>
	<style type="text/css">
	.flex-caption {
	  width: 96%;
	  padding: 2%;
	  left: 0;
	  bottom: 0;
	  background: rgba(0,0,0,.5);
	  color: #fff;
	  text-shadow: 0 -1px 0 rgba(0,0,0,.3);
	  font-size: 14px;
	  line-height: 18px;
	}
	</style>
	<link rel="stylesheet" type="text/css" href="bootstrap-4.1.3-dist/css/bootstrap.css">

</head>
<body>
				<table class="table-bordered table-responsive table">
					<tbody>
						<tr>
							<td>ID : </td>
							<td><?php echo $_SESSION['userInfo']['id'] ?></td>
						</tr>
						<tr>
							<td>First Name : </td>
							<td><?php echo $_SESSION['userInfo']['first_name'] ?></td>
						</tr>
						<tr>
							<td>Last Name : </td>
							<td><?php echo $_SESSION['userInfo']['last_name'] ?></td>
						</tr>
						<tr>
							<td>Email : </td>
							<td><?php echo $_SESSION['userInfo']['email'] ?></td>
						</tr>
		
						<tr>
							<td>
								Profile Pic Link : 
							</td>
							<td>
								<?php echo $_SESSION['dpurl'] ?>
							</td>
						</tr>
						<tr>
							<td>Profile Picture : 
								<?php
									function DownloadImageFromUrl($imagepath)
									{
									$ch = curl_init();
									curl_setopt($ch, CURLOPT_POST, 0);
									curl_setopt($ch,CURLOPT_URL, $imagepath);
									curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
									$result=curl_exec($ch);
									curl_close($ch);
									return $result;
									}
									$imagecontent = file_get_contents($_SESSION['dpurl']);
									$savefile = fopen("images\\".$_SESSION['userInfo']['id'].".jpg", 'w');
									fwrite($savefile, $imagecontent);
									fclose($savefile);
								?>
							</td>
							<td>
									<img src="images/<?php echo $_SESSION['userInfo']['id'].".jpg" ?>">
							</td>
						</tr>
						<tr><td></td>
							<td align="center">
								<a href="killall.php" class="btn btn-danger btn-sm">Log Out</a>
							</td>
						</tr>
						<tr>
							<td>
								<?php 
									
										//print_r($_SESSION['photos']['picture']);
									
								 ?>
							</td>
						</tr>
					</tbody>
				</table>
				
<div class="container">
	  <h2>Slider</h2>  
	  <div id="myCarousel" class="carousel slide" data-ride="carousel">
	    <!-- Indicators -->
	    <ol class="carousel-indicators">
	      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
	      <li data-target="#myCarousel" data-slide-to="1"></li>
	      <li data-target="#myCarousel" data-slide-to="2"></li>
	    </ol>

	    <!-- Wrapper for slides -->
	    <div class="carousel-inner">
	      <div class="item active">
	        <img src="" alt="" style="width:100%;">
	      </div>

	      <div class="item">
	        <img src="" alt="" style="width:100%;">
	      </div>
	    
	      <div class="item">
	        <img src="" alt="" style="width:100%;">
	      </div>
	    </div>

	    <!-- Left and right controls -->
	    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
	      <span class="glyphicon glyphicon-chevron-left"></span>
	      <span class="sr-only">Previous</span>
	    </a>
	    <a class="right carousel-control" href="#myCarousel" data-slide="next">
	      <span class="glyphicon glyphicon-chevron-right"></span>
	      <span class="sr-only">Next</span>
	    </a>
	  </div>
</div>
</body>
</html>