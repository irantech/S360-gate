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
      <div class="title">در باره ما </div>
    </div>
    </div>
  <div class="blank-page">
    <div class="content-section">
        <h1>در باره ما </h1>
        <hr>
      <p>
          <h3><?php echo ABOUT_ME?></h3>
      </p>

    </div>
  </div>
</div>
</div>
