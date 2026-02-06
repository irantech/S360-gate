<?php


//if($_GET['theme']=='parvazak')
if (FRONT_TEMPLATE_NAME == 'parvazak') {
    include_once 'homeCustomer/parvazak/Parvazak.php';
} elseif (FRONT_TEMPLATE_NAME == 'noandishan') {
    include_once 'homeCustomer/noandishan/noandishan.php';
} elseif (FRONT_TEMPLATE_NAME == 'iran_tech_demo') {
    include_once 'homeCustomer/iran_tech_demo/iran_tech_demo.php';
}elseif (FRONT_TEMPLATE_NAME == 'myna') {
    include_once 'homeCustomer/myna/myna.php';
} else {
    include_once 'homeCustomer/homeDefault.php';
}

