{load_presentation_object filename="embassies" assign="objEmbassies"}
{assign var="embassies" value=$objEmbassies->getEmbassies()}
{if $smarty.const.SOFTWARE_LANG eq 'en'}
    <link rel='stylesheet' href='assets/styles/css/modules-en/embassies-en.css'>
{else}
    <link rel='stylesheet' href='assets/modules/css/embassies.css'>
{/if}


<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
      integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
      crossorigin="" />

<section class="search-embassy">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-sm-12 col-12 parent-form-search-embassy">
                <form>
                    <label for="search_embassy">
                        <input id="search_embassy" type="text" placeholder="##CountryName##..." onkeyup="findType(this)">
                        <a class="btn_search_embassy" href="javascript:">
                            <i class="fa fa-search"></i>
                        </a>
                    </label>
                </form>
            </div>
        </div>
    </div>
</section>
<section class="embassy">
    <div class="embassy-modal">
        <div class="parent-embassy-modal">
            <div class="header-modal">
                <h3>
                </h3>
                <i class="fa fa-times icone-xmark" aria-hidden="true"></i>
            </div>
            <div class="modal-map">
                <div id="g-map">

                </div>
            </div>
            <div class='w-100 flex-wrap d-flex description-embassy'>
                    <span class='w-100 flex flex-wrap text-muted mb-1'>
                       ##Description## :
                    </span>
                <p class=' text-description-embassy'></p>
            </div>
<!--            <div class="footer-modal">
                <a href="javascript:" class="parent-share">
                    <i class="fa fa-light fa-share-nodes"></i>
                </a>
                <div class="parent-multiplication">
                    <i class="fa fa-light fa-xmark-large"></i>
                </div>
            </div>-->
        </div>
    </div>
    <div class="">
        <div class="embassy-grid">
            {foreach $embassies as $embassy}
                <div class="embassy-parent">
                    <h3>
                        <div class='flex flex-wrap'>
                            <span data-name='name' >{$embassy['name']}</span>
                            <span class='small text-muted'>
                                {if $smarty.const.SOFTWARE_LANG == 'fa'}
                                    ( {$embassy['country']['titleFa']} )
                                    {else}
                                    ( {$embassy['country']['titleEn']} )
                                {/if}
                            </span>
                        </div>
                        <img src="{$embassy['flag']}" class='rounded' alt="embassy-logo">
                    </h3>
                    <div class="contact-information">

                        <span class='d-none' data-name='description'>{$embassy['description']}</span>


                        {foreach $embassy['contact_information'] as $item}
                            <a  class="phone-embassy">
                                <div class="icone-phone-embassy">
                                    <span>{$item['title']}</span>
                                    <i class="fa fa-angle-left"></i>
                                </div>
                                <div class="phone-number-embassy">
                                    {$item['number']}
                                </div>
                            </a>
                        {/foreach}

                    </div>
                    <div class="embassy-address">
                        <i class="fa-light fa-location-dot"></i>
                        {$embassy['address']}
                    </div>
                    <div class="embassy-map">
                        <a onclick="map_click($(this),'{$embassy['lat']}', '{$embassy['lng']}')" href="javascript:"
                           class="embassy-link-share" title="نقشه">
                            <i class="fa fa-light fa-map-pin"></i>
                            ##SeeMap##
                        </a>
                    </div>
                </div>
            {/foreach}

        </div>
    </div>
</section>

<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
        integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
        crossorigin=""></script>
<script src='assets/modules/js/embassies.js'></script>
<script src='assets/js/jquery.lookingfor.min.js'></script>
