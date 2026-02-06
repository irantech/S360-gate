{load_presentation_object filename="aboutUs" assign="objAboutt"}
{assign var="about"  value=$objAboutt->getData()}
{assign var="socialLinks"  value=$about['social_links']|json_decode:true}


{if $smarty.session.layout neq 'pwa'}
 {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}

  <footer class="i_modular_footer footer">
   <div class="parent_btn_top" id="scroll-top">
    <a class="fixicone" href="javascript:">
     <svg viewbox="0 0 384 512" xmlns="http://www.w3.org/2000/svg">
      <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
      <path d="M352 352c-8.188 0-16.38-3.125-22.62-9.375L192 205.3l-137.4 137.4c-12.5 12.5-32.75 12.5-45.25 0s-12.5-32.75 0-45.25l160-160c12.5-12.5 32.75-12.5 45.25 0l160 160c12.5 12.5 12.5 32.75 0 45.25C368.4 348.9 360.2 352 352 352z">
      </path>
     </svg>
    </a>
   </div>
   <div class="counseling">
    <a href="{$smarty.const.ROOT_ADDRESS}/appointment">
     <svg viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
      <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
      <path d="M191.1 224c0-17.62-14.37-32.04-32-32.04l-32.01 0c-35.38 0-64 28.62-64 63.1L63.96 319.6c0 35.38 28.63 64 64.01 64h32c17.63 0 32-14.38 32-32L191.1 224zM159.1 351.6h-32c-17.63 0-32-14.38-32-32V256c0-17.62 14.38-32 32-32l32.02-.0001L159.1 351.6zM383.1 383.6c35.38 0 64.01-28.62 64.01-64l.0026-63.63c0-35.38-28.62-63.1-64-63.1l-31.1 0c-17.63 0-32 14.42-32 32.04l-.0105 127.6c0 17.62 14.38 32 32 32H383.1zM351.1 224l31.1 .0001c17.63 0 32 14.38 32 32V319.6c0 17.62-14.38 32-32 32h-32L351.1 224zM280.2 1.131c-153.5-14.29-276.2 108.1-280.2 254.9l-.0206 15.92C-.0459 280.8 7.155 288 16 288c8.755 0 15.96-7.162 16-15.92l.0838-16.08C35.52 128.6 142.5 20.63 276.9 32.96c116.3 10.68 203.1 112.3 203.1 229.1v169.1c0 26.51-21.49 48-48 48h-83.01c4.081-10.88 4.609-23.54-2.282-36.69c-9.093-17.35-28.04-27.31-47.62-27.31L241.8 416c-23.21 0-44.49 15.69-48.87 38.49C187 485.2 210.4 512 239.1 512l191.1 .0001c44.19 0 80.01-35.82 80.01-79.1V262.9C512 129.6 412.9 13.49 280.2 1.131zM303.1 480H239.1c-8.876 0-16-7.125-16-16s7.126-16 16-16h64.01c8.876 0 16 7.125 16 16S312.9 480 303.1 480z">
      </path>
     </svg>
    </a>
   </div>
   <div class="footer_main container">
    <ul class="m-0 p-0 glideLayout">
     <li class="call">
      <h6 href="{$smarty.const.ROOT_ADDRESS}/contactUs">
       تماس با ما
      </h6>
      <span>
     <i>
      <svg viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
       <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
       <path d="M480.3 320.3L382.1 278.2c-21.41-9.281-46.64-3.109-61.2 14.95l-27.44 33.5c-44.78-25.75-82.29-63.25-108-107.1l33.55-27.48c17.91-14.62 24.09-39.7 15.02-61.05L191.7 31.53c-10.16-23.2-35.34-35.86-59.87-30.19l-91.25 21.06C16.7 27.86 0 48.83 0 73.39c0 241.9 196.7 438.6 438.6 438.6c24.56 0 45.53-16.69 50.1-40.53l21.06-91.34C516.4 355.5 503.6 330.3 480.3 320.3zM463.9 369.3l-21.09 91.41c-.4687 1.1-2.109 3.281-4.219 3.281c-215.4 0-390.6-175.2-390.6-390.6c0-2.094 1.297-3.734 3.344-4.203l91.34-21.08c.3125-.0781 .6406-.1094 .9531-.1094c1.734 0 3.359 1.047 4.047 2.609l42.14 98.33c.75 1.766 .25 3.828-1.25 5.062L139.8 193.1c-8.625 7.062-11.25 19.14-6.344 29.14c33.01 67.23 88.26 122.5 155.5 155.5c9.1 4.906 22.09 2.281 29.16-6.344l40.01-48.87c1.109-1.406 3.187-1.938 4.922-1.125l98.26 42.09C463.2 365.2 464.3 367.3 463.9 369.3z">
       </path>
      </svg>
     </i>
     <a class="__phone_class__" href="tel:{$smarty.const.CLIENT_PHONE}">
      {$smarty.const.CLIENT_PHONE}
     </a>
    </span>
      <span>
     <i>
      <svg viewbox="0 0 384 512" xmlns="http://www.w3.org/2000/svg">
       <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
       <path d="M304 0h-224c-35.35 0-64 28.65-64 64v384c0 35.35 28.65 64 64 64h224c35.35 0 64-28.65 64-64V64C368 28.65 339.3 0 304 0zM320 448c0 8.822-7.178 16-16 16h-224C71.18 464 64 456.8 64 448V64c0-8.822 7.178-16 16-16h224C312.8 48 320 55.18 320 64V448zM224 400H160c-8.836 0-16 7.164-16 16s7.164 16 16 16h64c8.838 0 16-7.164 16-16S232.8 400 224 400z">
       </path>
      </svg>
     </i>
     <a class="__mobile_class__" href="tel:{$smarty.const.CLIENT_MOBILE}">
      {$smarty.const.CLIENT_MOBILE}
     </a>
    </span>
      <span>
     <i>
      <svg viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
       <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
       <path d="M0 128C0 92.65 28.65 64 64 64H448C483.3 64 512 92.65 512 128V384C512 419.3 483.3 448 448 448H64C28.65 448 0 419.3 0 384V128zM48 128V150.1L220.5 291.7C241.1 308.7 270.9 308.7 291.5 291.7L464 150.1V127.1C464 119.2 456.8 111.1 448 111.1H64C55.16 111.1 48 119.2 48 127.1L48 128zM48 212.2V384C48 392.8 55.16 400 64 400H448C456.8 400 464 392.8 464 384V212.2L322 328.8C283.6 360.3 228.4 360.3 189.1 328.8L48 212.2z">
       </path>
      </svg>
     </i>
     <a class="__email_class__" href="mailto:{$smarty.const.CLIENT_EMAIL}">
      {$smarty.const.CLIENT_EMAIL}
     </a>
    </span>
      <span>
     <i>
      <svg viewbox="0 0 384 512" xmlns="http://www.w3.org/2000/svg">
       <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
       <path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z">
       </path>
      </svg>
     </i>
     <span class="__address_class__">
      آدرس :  {$smarty.const.CLIENT_ADDRESS}
     </span>
    </span>
      {assign var="socialLinks"  value=$about['social_links']|json_decode:true}
      {assign var="socialLinksArray" value=['telegram'=>'telegramHref','whatsapp'=> 'whatsappHref','instagram' => 'instagramHref','aparat' => 'aparatHref','youtube' => 'youtubeHref','facebook' => 'facebookHref','linkeDin' => 'linkeDinHref']}

      {foreach $socialLinks as $key => $val}
       {assign var=$socialLinksArray[$val['social_media']] value=$val['link']}
      {/foreach}
      <div class="__social_class__ footer_icons">
       <a class="__instagram_class__ footer_instagram" href="{if $instagramHref}{$instagramHref}{/if}">
        <svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
         <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
         <path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z">
         </path>
        </svg>
       </a>
       <a class="__whatsapp_class__ footer_whatsapp" href="{if $whatsappHref}{$whatsappHref}{/if}">
        <svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
         <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
         <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z">
         </path>
        </svg>
       </a>
       <a class="__telegram_class__ footer_telegram" href="{if $telegramHref}{$telegramHref}{/if}">
        <svg viewbox="0 0 496 512" xmlns="http://www.w3.org/2000/svg">
         <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
         <path d="M248,8C111.033,8,0,119.033,0,256S111.033,504,248,504,496,392.967,496,256,384.967,8,248,8ZM362.952,176.66c-3.732,39.215-19.881,134.378-28.1,178.3-3.476,18.584-10.322,24.816-16.948,25.425-14.4,1.326-25.338-9.517-39.287-18.661-21.827-14.308-34.158-23.215-55.346-37.177-24.485-16.135-8.612-25,5.342-39.5,3.652-3.793,67.107-61.51,68.335-66.746.153-.655.3-3.1-1.154-4.384s-3.59-.849-5.135-.5q-3.283.746-104.608,69.142-14.845,10.194-26.894,9.934c-8.855-.191-25.888-5.006-38.551-9.123-15.531-5.048-27.875-7.717-26.8-16.291q.84-6.7,18.45-13.7,108.446-47.248,144.628-62.3c68.872-28.647,83.183-33.623,92.511-33.789,2.052-.034,6.639.474,9.61,2.885a10.452,10.452,0,0,1,3.53,6.716A43.765,43.765,0,0,1,362.952,176.66Z">
         </path>
        </svg>
       </a>
      </div>
     </li>
     <li>
      <h6>
       دسترسی آسان
      </h6>
      <div class="asan">
{*       <a class="asan_link" href="{$smarty.const.ROOT_ADDRESS}/page/residence">*}
{*        اقامت*}
{*       </a>*}
       <a class="asan_link" href="{$smarty.const.ROOT_ADDRESS}/page/visa">
        ویزا
       </a>

       <a class="asan_link" href="{$smarty.const.ROOT_ADDRESS}/appointment">
        وقت سفارت
       </a>
       <a class="asan_link" href="{$smarty.const.ROOT_ADDRESS}/sendDocuments">
        ارسال مدارک
       </a>
       <a class="asan_link" href="{$smarty.const.ROOT_ADDRESS}/orderServices">
        درخواست خدمات
       </a>
       <a class="asan_link" href="{$smarty.const.ROOT_ADDRESS}/recommendation">
        نظر مشتریان
       </a>
       <a class="asan_link" href="{$smarty.const.ROOT_ADDRESS}/rules">
        قوانین و مقررات
       </a>
       <a class="asan_link" href="{$smarty.const.ROOT_ADDRESS}/contactUs">
        تماس با ما
       </a>
       <a class="asan_link" href="{$smarty.const.ROOT_ADDRESS}/aboutUs">
        درباره ما
       </a>
      </div>
     </li>
     <li class="d-flex flex-column aboutUs">
      <h6 href="{$smarty.const.ROOT_ADDRESS}/aboutUs">
       درباره ما
      </h6>
      <span>
     <span class="__aboutUs_class__">
      {$htmlContent = $about['body']|strip_tags}{$htmlContent|truncate:300}
     </span>
    </span>
      <a href="__aboutUs_class_href__">
       بیشتر
       <svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
        <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
        <path d="M447.1 256c0 13.25-10.76 24.01-24.01 24.01H83.9l132.7 126.6c9.625 9.156 9.969 24.41 .8125 33.94c-9.156 9.594-24.34 9.938-33.94 .8125l-176-168C2.695 268.9 .0078 262.6 .0078 256S2.695 243.2 7.445 238.6l176-168C193 61.51 208.2 61.85 217.4 71.45c9.156 9.5 8.812 24.75-.8125 33.94l-132.7 126.6h340.1C437.2 232 447.1 242.8 447.1 256z">
        </path>
       </svg>
      </a>
      <div class="namads">
       <!--                    <a href="javascript:"><img src="project_files/images/certificate1.png" alt="Enamad1"></a>-->
       <!--                    <a href="javascript:"><img src="project_files/images/certificate5.png" alt="namad-1"></a>-->
       <!--                    <a href="javascript:"><img src="project_files/images/certificate3.png" alt="namad-2"></a>-->
       <!--                    <a href="javascript:"><img src="project_files/images/certificate4.png" alt="namad-3"></a>-->
      </div>
     </li>
    </ul>
   </div>
   <div class="last_text col-12">
    <a class="last_a" href="https://www.iran-tech.com/" target="_blank">
     طراحی سایت گردشگری
    </a>
    <p class="last_p_text">
     : ایران تکنولوژی
    </p>
   </div>
  </footer>

 {/if}
{else}
 {include file="`$smarty.const.FRONT_CURRENT_CLIENT`pwaFooter.tpl"}
{/if}