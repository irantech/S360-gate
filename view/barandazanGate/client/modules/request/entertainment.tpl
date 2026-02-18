<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css"/>
{load_presentation_object filename="entertainment" assign="objEntertainment"}
{load_presentation_object filename="Session" assign="objSession"}
{load_presentation_object filename="dateTimeSetting" assign="dateTimeSetting"}
{load_presentation_object filename="passengersDetailLocal" assign="objDetail"}
{$objDetail->getCustomers()}
{assign var="InfoMember" value=$objFunctions->infoMember($objSession->getUserId())}
{assign var="EntertainmentData" value=$objEntertainment->GetEntertainmentData('','','','',$smarty.post.entetainmentId)}
{assign var="GetEntertainmentGalleryData" value=$objEntertainment->GetEntertainmentGalleryData($EntertainmentData['id'])}
{assign var="EntertainmentTypeData" value=$objEntertainment->GetTypes($EntertainmentData['id'],'',true)}
{assign var="GetEntertainmentGallery" value=$GetEntertainmentGalleryData|json_decode:true}
{*{assign var="EntertainmentDataTable" value=$EntertainmentData['datatable']|json_decode:true}*}
{*{$smarty.post.entetainmentId}*}
{assign var="PageUrl" value="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=aboutus"}
{assign var="discount_amount" value="0"}
{if $EntertainmentData['discount_price'] neq 0}
    {$discount_amount = $EntertainmentData['discount_price']}
{elseif $EntertainmentData['discountAmount'] neq 0}

    {$discount_amount = $EntertainmentData['discountAmount']}

{/if}


{if $smarty.const.SOFTWARE_LANG eq 'en'}
    <link rel='stylesheet' href='assets/modules/css/fun-en.css'>
{else}
    <link rel='stylesheet' href='assets/styles/fun.css'>
{/if}






<div class="col-md-12 p-0 d-flex flex-wrap mb-4">
    <div class="col-lg-9 col-md-8 p-0">
        <div class="col-md-12 p-0">
            <div class="BaseTourBox mb-0">
                <div class="w-100 BaseDivBackGroundImage">
                    <div class="DivBackGroundImage"
                         style="background-image: url('{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/entertainment/{$EntertainmentData['pic']}')">
                        <div class="Details">
                            {if $EntertainmentData['title_en'] == 0 || $EntertainmentData['title_en'] == ''}
                            <h1>{$EntertainmentData['title']}</h1>
                            {else}
                            <h1>{$EntertainmentData['title_en']}</h1>
                            {/if}
                        </div>
                    </div>
                </div>
                <div class="w-100 mt-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb CustomBreadCrumb site-bg-main-color">
                            <li class="breadcrumb-item"><a>{$EntertainmentData['BaseCategoryTitle']}</a></li>
                            <li class="breadcrumb-item"><a
                                        href="{$smarty.const.ROOT_ADDRESS}/resultEntertainment/{$EntertainmentData['country_id']}/{$EntertainmentData['city_id']}/{$EntertainmentData['CategoryId']}">
                                    {$EntertainmentData['CategoryTitle']}
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{$EntertainmentData['title']}</li>
                        </ol>
                    </nav>
                </div>
                <div class="w-100 Description">
                    <p>{$EntertainmentData['description']}</p>
                </div>
                {if $EntertainmentData['datatable']|json_decode:true != ''}
                    <div class="w-100 mt-3 Description Description-reserv2">
                        {* <div class="TourTitreDiv">
                             <span>خدمات</span>
                         </div>*}
                        <span class="s-u-last-p-pasenger2 s-u-last-p-pasenger-change site-main-text-color">
                    خدمات <i class="zmdi zmdi-ticket-star mart10  zmdi-hc-fw"></i>
                    </span>
                        <table class="table Datatable BaseTourBox">

                            <tbody>
                            {foreach key=key item=item from=$EntertainmentData['datatable']|json_decode:true}
                                <tr>
                                    <td>{$item.title}</td>
                                    <td>{$item.body}</td>
                                </tr>
                            {/foreach}
                            </tbody>
                        </table>

{*                        {foreach key=key item=item from=$EntertainmentAllTypeData}*}

{*                        {/foreach}*}

                    </div>
                {/if}
                {if $GetEntertainmentGallery['data'][0] != '' || $EntertainmentData['video']}
                    <div class="w-100 mt-3 Description Description-reserv3">
                        {* <div class="TourTitreDiv">
                             <span>##Gallery##</span>
                         </div>*}
                        <span class="TourTitreDiv s-u-last-p-pasenger2 s-u-last-p-pasenger-change site-main-text-color">
                    ##Gallery## <i class="zmdi zmdi-ticket-star mart10  zmdi-hc-fw"></i>
                </span>
                        <div class="w-100 mb-3 Description BaseTourBox">

                            {if $EntertainmentData['video'] != ''}
                                <div class="w-100 pt-3">
{*                                    {$EntertainmentData['video']}*}
                                    <iframe src="{$EntertainmentData['video']}" title="{$EntertainmentData['title']}" style='width: 100%;min-height: 400px'></iframe>

                                </div>
                            {/if}
                            {if $GetEntertainmentGallery['data'][0] != ''}

                            <div class="Entertainment-owl-carousel owl-carousel gallery">
                                {foreach key=key item=item from=$GetEntertainmentGallery['data']}
                                    <div class="item">
                                        <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/entertainment/{$item.file}">
                                            <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/entertainment/{$item.file}">
                                        </a>
                                    </div>
                                {/foreach}
                            </div>
                            {/if}
                        </div>
                    </div>
                {/if}



                <div class="">



                <div id="lightboxContainer" class="lightboxContainerOpacity"></div>
            </div>


        </div>
    </div>
</div>
<div  class="col-lg-3 col-md-4 parent-fun-padding">

    <div class="z-unset  fun_reserve">

        <div class="pricing-card basic">
            <div class="pricing-header site-bg-main-color">
                <span class="plan-title">##Reserve##</span>
                <div class="price-circle site-border-main-color">
                            <span class="price-title text-dark">

                                {if $EntertainmentData['discountAmount'] neq 0 || $EntertainmentData['discount_price'] neq 0}
                                    <strike class="strikePrice">
                                        <span class="currency text-dark priceOff CurrencyCal ThisPrice"
                                              data-target="value">
                                            {$EntertainmentData['price']|number_format}
                                        </span>
                                    </strike>
                                    <span>{$EntertainmentData['discountPrice']|number_format}</span>
                                    <small>##Rial##</small>

{else}

                                    <span>{$EntertainmentData['price']|number_format}</span>
                                    <small>##Rial##</small>
                                {/if}
                            </span>
                    {*                            <span class="info">/ Month</span>*}
                </div>
            </div>
            <div class="badge-box ">



                {if $discount_amount neq 0}

                    <span class="d-block p-2 site-bg-second-color">##Discount## {$discount_amount|number_format}%</span>
                {/if}
            </div>
            <ul class="mb-4">
                {foreach key=key item=item from=$EntertainmentTypeData}
                    <li>
                        <strong><span class="site-bg-main-color mdi {$item.logo}"></span></strong> {$item.title}
                    </li>
                {/foreach}

            </ul>
            <div class="buy-button-box d-none">
                <a href="#" class="buy-now">##Reserve##</a>
            </div>


            <div class='share_section mb-3'>
                     <span class="s-u-last-p-pasenger2 s-u-last-p-pasenger-change site-main-text-color">
                         ##subscription##  :
                    </span>
                <div class="share d-flex mt-3">
                    <a href="#"><i class="fa fa-telegram"></i></a>
                    <a href="#"><i class="fa fa-whatsapp"></i></a>
                </div>
            </div>

        </div>

    </div>
</div>
</div>

<form  method="post" id="requestForm" action="{$smarty.const.ROOT_ADDRESS}/factorRequest">
    <input type="hidden" name="idMember" id="idMember" value="">
    <input type="hidden" name="factorNumber" id="factorNumber" value="{$objFunctions->generateFactorNumber()}">
    <input type="hidden" name="EntertainmentId" id="EntertainmentId" value="{$EntertainmentData['id']}">
    <input type="hidden" name="EntertainmentTitle" id="EntertainmentTitle" value="{$EntertainmentData['title']}">
    <input type="hidden" name="EntertainmentPrice" id="EntertainmentPrice" value="{$EntertainmentData['price']}">
    <input type="hidden" name="EntertainmentRequest" id="EntertainmentRequest" value="{$EntertainmentData['is_request']}">
    <input type="hidden" name="EntertainmentDiscountAmount" id="EntertainmentDiscountAmount" value="{$discount_amount}">
</form>

{include file="`$smarty.const.FRONT_CURRENT_CLIENT`passengerPopup.tpl"}


<!-- login and register popup -->
{assign var="useType" value="entertainment"}
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentLoginRegister.tpl"}
<!-- login and register popup -->
<script src="assets/js/script.js"></script>
<script src="assets/js/jquery.fancybox.min.js"></script>
<script src="assets/js/scrollWithPage.min.js"></script>
<script src="assets/js/jquery.counter.js" type="text/javascript"></script>


<script>
  if($(window).width() > 990){
    $(".fun_reserve").scrollWithPage(".colum-se");
  }
  $(document).ready(function () {
    $('.Entertainment-owl-carousel').owlCarousel({
      rtl: true,
      loop: true,
      margin: 10,
      dots: true,
      nav: false,
      autoplay: true,
      autoplayTimeout: 3000,
      autoplayHoverPause: true,
      responsive: {
        0: {
          items: 1,
        },
        600: {
          items: 2,
        },
        1000: {
          items: 4,
        },
      },
    })
    // add all to same gallery
    $(".gallery a").attr("data-fancybox", "mygallery");
    // assign captions and title from alt-attributes of images:
    $(".gallery a").each(function () {
      $(this).attr("data-caption", $(this).find("img").attr("alt"));
      $(this).attr("title", $(this).find("img").attr("alt"));
    });
    // start fancybox:
    $(".gallery a").fancybox();
  });
</script>
