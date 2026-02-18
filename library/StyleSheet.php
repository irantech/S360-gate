<?php

require '../config/bootstrap.php';

//Set the content-type header and charset.
header("Content-Type: text/css; charset=utf-8");
function rgbToHex($rgb) {
    if (substr($rgb, 0, 1) === "#") {
        return $rgb;
    }
    preg_match_all("/([\\d.]+)/", $rgb, $matches);
    return sprintf("#%02x%02x%02x", $matches[0][0], $matches[0][1], $matches[0][2]);
}

//Setup our colour variables.
//$backgroundColor = COLOR_MAIN_BG;
$backgroundColor = rgbToHex(COLOR_MAIN_BG);

$backgroundColorHover = COLOR_MAIN_BG_HOVER;
$colorMainText = COLOR_MAIN_TEXT;


?>
:root{
--mainColor : <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?> ;
--secondColor: <?php echo !empty($backgroundColorHover) ? $backgroundColorHover : '#006699'; ?>;
}
/*------------ background color ---------------------*/
.site-bg-main-color{
background-color: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?> !important;
color: <?php echo !empty($colorMainText) ? $colorMainText : '#FFFFFF'; ?> !important;
}
.site-bg-main-color-hover:hover{
background-color: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?> !important;
color: <?php echo !empty($colorMainText) ? $colorMainText : '#FFFFFF'; ?> !important;
}
.site-bg-main-color-50{
background-color: <?php echo !empty($backgroundColor) ? $backgroundColor . '4d' : '#006699'; ?> !important;
color: '#333';
}
.site-stroke-main-color-70{
stroke: <?php echo !empty($backgroundColor) ? $backgroundColor . '8a' : '#006699'; ?> !important;
}
.site-fill-text-color{
fill: <?php echo !empty($colorMainText) ? $colorMainText : '#FFFFFF'; ?> !important;
}
.site-bg-second-color{
background-color: <?php echo !empty($backgroundColorHover) ? $backgroundColorHover : '#006699'; ?> !important;
color: <?php echo !empty($colorMainText) ? $colorMainText : '#FFFFFF'; ?> !important;
}
.site-color-main-color-before:before{
color: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?> !important;
}
.site-bg-main-color-after-for-loader:after{
border-bottom-color: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?> !important;
}
.site-bg-main-color-after:after{
background-color: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?> !important;
}
.site-bg-main-color-before:before{
background-color: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?> !important;
}
.site-bg-svg-color {
fill: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?> !important;
}
.active-tab{
background-color: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?> !important;
color: <?php echo !empty($colorMainText) ? $colorMainText : '#FFFFFF'; ?> !important;
}
.nav-link.active{
background-color: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?> !important;
color: <?php echo !empty($colorMainText) ? $colorMainText : '#FFFFFF'; ?> !important;
}
.site-bg-main-color-b::before{
background-color: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699 '; ?>;
}
.site-bg-main-color-a::after{
background-color: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?>;
}
.site-bg-tsxt-color-b::before{
background-color: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?>;
color: <?php echo !empty($colorMainText) ? $colorMainText : '#FFFFFF'; ?>;
}
.site-bg-color-border-b::before{
border-color: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?> !important;
}

.site-bg-color-border-a::after{
border-color: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?> !important;
}
.site-bg-color-border-bottom::after{
border-bottom-color: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?>!important;

}
.site-bg-color-border-top::after{
border-top-color: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?>!important;
}
.site-bg-color-border-right::after{
border-right-color: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?>;
}
.site-bg-color-border-left::after{
border-left-color: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?>;
}

.site-bg-color-border-bottom-b::before{
border-bottom-color: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?>;
}
.site-bg-color-border-top-b::before{
border-top-color: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?>;
}
.site-bg-color-border-right-b::before{
border-right-color: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?> !important;
}
.site-bg-color-border-left-b::before{
border-left-color: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?>;
}
.site-bg-color-dock-border-right-b::before{
border-right-color: <?php echo !empty($backgroundColorHover) ? $backgroundColorHover : '#004b71'; ?>;
}
.site-bg-color-dock-border-left-b::before{
border-left-color: <?php echo !empty($backgroundColorHover) ? $backgroundColorHover : '#004b71'; ?>;
}
.site-bg-color-dock-border-top::after{
border-top-color: <?php echo !empty($backgroundColorHover) ? $backgroundColorHover : '#004b71'; ?> !important;
}
.site-bg-color-dock-border-left-a::after{
border-left-color: <?php echo !empty($backgroundColorHover) ? $backgroundColorHover : '#004b71'; ?>;
}

.site-bg-color-dock-border-right-a::after{
border-radius: 8px 8px 0 0;right-color: <?php echo !empty($backgroundColorHover) ? $backgroundColorHover : '#004b71'; ?>;
}
.site-bg-color-dock-border{
border-color: <?php echo !empty($backgroundColorHover) ? $backgroundColorHover : '#004b71'; ?> !important;
}
.custom-checkbox .custom-control-input:checked ~ .custom-control-label::before{
background-color:<?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?> !important;
}
/*------------ border color ---------------------*/
.site-border-text-color{
border:1px solid <?php echo !empty($colorMainText) ? $colorMainText : '#FFFFFF'; ?>;
}
.site-border-main-color{
border-color:  <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?> !important;;
}

.site-border-top-main-color{
border-top-color :   <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?> !important;
}
.site-border-right-main-color{
border-right-color :   <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?> !important;
}
.site-border-secondary-color{
border-color:<?php echo !empty($colorMainText) ? $colorMainText : '#FFFFFF'; ?>;
}
/*------------ text color ---------------------*/
.site-main-text-color {
color: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?> !important;
}
.site-main-text-color-a::after{
color: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?>;
}

.site-main-text-color-h {
color: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?>;
}

.site-main-bg-color-h:hover {
background-color: <?php echo !empty($backgroundColorHover) ? $backgroundColorHover : '#004b71'; ?> !important;
}


.site-main-text-color-h:hover {
color: <?php echo !empty($backgroundColorHover) ? $backgroundColorHover : '#004b71'; ?> !important;
}

.site-main-text-color-drck {
color: <?php echo !empty($backgroundColorHover) ? $backgroundColorHover : '#004b71'; ?> !important;
}

.site-secondary-text-color{
color: <?php echo !empty($colorMainText) ? $colorMainText : '#aaa'; ?> !important;
}
.site-secondary-text-color:hover{
color: #eee;
}


/*------------ button color ---------------------*/
.site-main-button-color {
border: 1px solid <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?>;
background: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?>;
background: -webkit-gradient(linear, left top, left bottom, from(<?php echo !empty($backgroundColorHover) ? $backgroundColorHover : '#004b71'; ?>), to(<?php echo $backgroundColor ?>));
background: -webkit-linear-gradient(top, <?php echo !empty($backgroundColorHover) ? $backgroundColorHover : '#004b71'; ?>, <?php echo $backgroundColor ?>);
background: -moz-linear-gradient(top, <?php echo !empty($backgroundColorHover) ? $backgroundColorHover : '#004b71'; ?>, <?php echo $backgroundColor ?>);
background: -ms-linear-gradient(top, <?php echo !empty($backgroundColorHover) ? $backgroundColorHover : '#004b71'; ?>, <?php echo $backgroundColor ?>);
background: -o-linear-gradient(top, <?php echo !empty($backgroundColorHover) ? $backgroundColorHover : '#004b71'; ?>, <?php echo $backgroundColor ?>);

}

.site-main-button-color:hover {
border: 1px solid <?php echo !empty($backgroundColorHover) ? $backgroundColorHover : '#004b71'; ?>;;
background: <?php echo !empty($backgroundColorHover) ? $backgroundColorHover : '#004b71'; ?>;;
background: -webkit-gradient(linear, left top, left bottom, from(<?php echo $backgroundColor ?>), to(<?php echo !empty($backgroundColorHover) ? $backgroundColorHover : '#004b71'; ?>));
background: -webkit-linear-gradient(top, <?php echo $backgroundColor ?>, <?php echo !empty($backgroundColorHover) ? $backgroundColorHover : '#004b71'; ?>);
background: -moz-linear-gradient(top, <?php echo $backgroundColor ?>, <?php echo !empty($backgroundColorHover) ? $backgroundColorHover : '#004b71'; ?>);
background: -ms-linear-gradient(top, <?php echo $backgroundColor ?>, <?php echo !empty($backgroundColorHover) ? $backgroundColorHover : '#004b71'; ?>);
background: -o-linear-gradient(top, <?php echo $backgroundColor ?>, <?php echo !empty($backgroundColorHover) ? $backgroundColorHover : '#004b71'; ?>);

}

.site-main-button-flat-color {background: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?>;}
.site-main-button-flat-color:hover {background: <?php echo !empty($backgroundColorHover) ? $backgroundColorHover : '#004b71'; ?>}

.site-main-button-color-hover:hover{
background: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?>;
border-color: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?>;
color: <?php echo !empty($colorMainText) ? $colorMainText : '#FFFFFF'; ?>;
}
.site-main-button-color-hover-active:active{
background-color: <?php echo !empty($backgroundColorHover) ? $backgroundColorHover : '#006699'; ?> !important;
}
.site-main-button-color-hover-active.active{
background-color: <?php echo !empty($backgroundColorHover) ? $backgroundColorHover : '#006699'; ?> !important;

}
/*------------filter slider  color ---------------------*/
.addui-slider .addui-slider-track .addui-slider-range, .site-bg-filter-color.checked{
background-color: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?>
}

/*------------ select2 ------------------------------*/
.childAge-dropdown::after ,
.form-item.form-item-sort .select2-container--default .select2-selection--single .select2-selection__arrow b,
.s-u-class-pick-change .select2-container--default .select2-selection--single .select2-selection__arrow b,
.change-bor .select2-container--default .select2-selection--single .select2-selection__arrow b{
border-top-color: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?>
}

.select2-container--default .select2-results__option--highlighted[aria-selected] {
background-color: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?> ;
color: <?php echo !empty($colorMainText) ? $colorMainText : '#FFFFFF'; ?> ;
}
/* --------------- pop login ------------------------------- */
.cd-switcher .selected {
background-color:<?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?>;
color :<?php echo !empty($colorMainText) ? $colorMainText : '#FFFFFF'; ?> !important;
}
/* --------------- azm colors ------------------------------- */
.sorting-active-color-main {
border-bottom:3px solid <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?> !important;

}
.sorting-active-color-main svg , .sorting-active-color-main span  {
color:<?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?> !important;
}
.sorting-inner.price:hover *  , .sorting-inner.time:hover * {
color:<?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?> !important;
transition:0.2s;
}
.sorting-inner.price:hover *  , .sorting-inner.time:hover * ,.timeline .event:hover .fa-arrow-down{
color:<?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?> !important;
transition:0.2s;
}
.activing_grid .tour-result-item-right a{
background-color: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?> ;
color: <?php echo !empty($colorMainText) ? $colorMainText : '#FFFFFF'; ?> ;
}
.BaseTimelineBoth .timeline li:first-child .title{
color: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?> ;
}
.timeline .event:hover,
.timeline .event:hover .four_child ,.timeline .event:hover .three_child,.timeline .event:hover .two_child ,
.timeline .event:hover .T-flight-info ul,.timeline .event:hover .T-flight-info ul li:first-child ,
.timeline .event:hover .T-flight-info .class ,.timeline .event:hover .T-flight-info .departure,
.timeline .event:hover .HotelIntroduce div,.InfoCommentBox,.InfoCommentBox .card-header {
border-color:<?php echo !empty($backgroundColor) ? $backgroundColor . '57' : '#006699'; ?> !important;
transition:0.2s;
}
.timeline .event:hover:after{
background:<?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?> !important;
transition:0.2s;
}
.Container-progessbar li.active:before, .Container-progessbar li.active::after {
background-color: <?php echo !empty($backgroundColor) ? $backgroundColor : '#006699'; ?>;
color: <?php echo !empty($colorMainText) ? $colorMainText : '#FFFFFF'; ?>;
border-color: <?php echo !empty($backgroundColorHover) ? $backgroundColorHover : '#006699'; ?>;
}