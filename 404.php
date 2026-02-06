<!DOCTYPE html>
<html>
<head>
	<title>404 :(</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>
<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
?>
<body style="height:100vh" class="d-flex justify-content-center align-items-center">
	<div class="container ">
		<div class="col-lg-8 col-12 mx-auto d-flex justify-content-center align-items-center flex-column">
			<img class="w-100" src="<?php echo $protocol. $_SERVER['HTTP_HOST']?>/gds/404.png" alt="404">
			<a href="/" class="btn btn-primary">بازگشت به خانه</a>
		</div>
	</div>
</body>
</html>