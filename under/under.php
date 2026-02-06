<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<title>سایت در دست ساخت</title>

<!--CSS-->
<link rel="stylesheet" href="./gds/under/css/style.css">
<link rel="stylesheet" href="./gds/under/css/bootstrap-light.css">

<!--/CSS-->
<?php
		$date = date('Y-m-d',strtotime('+30 Days'));

		$explode_date = explode('-',$date);

?>
<!--JS-->

<script src="./gds/under/js/jquery-3.3.1.min.js"></script>
<script src="./gds/under/js/jquery.plugin.js"></script>
<script src="./gds/under/js/jquery.countdown.js"></script>
<script>
$(function () {
	$('#defaultCountdown').countdown({until: new Date(<?php echo $explode_date[0]?>,<?php echo $explode_date[1]?>, <?php echo $explode_date[2]?>)});
	//Replace above date with your own, to find out more visit http://keith-wood.name/countdown.html
});
</script>
<!--/JS-->

</head>

<body>

<!--DARK OVERLAY-->
<div class="overlay"></div>
<!--/DARK OVERLAY-->

<!--WRAP-->
<div id="wrap">
	<!--CONTAINER-->
	<div class="container">
		<img src="./gds/under/images/under.png" alt="Paper Plane" class="image-align" style="width:150px ; height:150px"/>

		<h1>
			در حال طراحی <span class="yellow">برای ظاهری زیبا</span>
		</h1>

		<div id="defaultCountdown"></div>

		<p class="copyright">طراحی توسط <a href="https://iran-tech.com/" target="_blank">ایران تکنولوژی</a></p>
	</div>
	<!--/CONTAINER-->
</div>
<!--/WRAP-->

</body>
</html>
