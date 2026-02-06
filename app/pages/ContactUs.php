<?php

require '../../config/bootstrap.php';
require LIBRARY_DIR . 'Load.php';
spl_autoload_register(array('Load', 'autoload'));
?>
<div class="page" data-page="ruls">

  <div class="page-content">
    <div class="nav-info">
    <div class="nav-info-inner site-bg-main-color">
      <div class="back-link">
        <a href="#" class="link back">
			<span></span>
        </a>
      </div>
      <div class="title">تماس با ما</div>
    </div>
    </div>
  <div class="blank-page">
    <div class="content-section">
        <h1>تماس با <?php echo CLIENT_NAME?></h1>
        <hr>
        <h2>شما میتوانید از راه های زیر با ما تماس حاصل کنید </h2>
        <hr>
      <p>
        <h3> شماره تماس:<a href="tel:<?php echo CLIENT_PHONE?>" class="link external"><?php echo CLIENT_PHONE?></a>  </h3>
      </p>

        <p>
            <h3>پست الکترونیک:<?php echo CLIENT_EMAIL?></h3>
        </p>


        <p>
            <h3>آدرس:<?php echo CLIENT_ADDRESS?></h3>
        </p>
    </div>
  </div>
</div>
</div>
