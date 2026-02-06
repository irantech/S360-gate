<!DOCTYPE html>
<html>
	<head>
		<title>403 Forbidden</title>
<!--			<meta http-equiv="refresh" content="10 ; url= /">-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
	</head>
	<body style="text-align: center;padding: 0;margin: 0;height: 100vh;display: flex;justify-content: center;align-items: center;">
  <div class='container'>
    <div class='flex flex-column' style='margin: 0 auto;'>
      <div class='parent-img' style='width: 400px; height: 400px; margin:0 auto'>
        <img src="<?php echo ROOT_ADDRESS_WITHOUT_LANG ?>/403.png" style="margin:auto; width:100%; height:100%;object-fit: contain;" alt="oops!" title="oops!">
      </div>
      <div class='col-lg-12 col-md-6' style='font-weight:bold'>
          به نظر میرسه درخواست شما حاوی پارامترهای مشکوک ویا مخرب هست و یا شما دسترسی به این صفحه ندارید لطفا آدرس صحیح را وارد نمایید و یا از طریق این لینک به صفحه اصلی مراجعه کنید

          <a style="display: flex; width:fit-content; margin:10px auto" href="<?php echo SERVER_HTTP . CLIENT_DOMAIN ?>" class="btn btn-primary">
            صفحه اصلی
          </a>
        </div>
    </div>

  </div>


  </body>
</html>