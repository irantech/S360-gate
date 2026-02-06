
{$specialFlightPic='flight-bg-js.jpg'}
{$specialHotelPic='hotel-bg-js.jpg'}
{$specialBusPic='bus-bg-js.jpg'}
{$specialTourPic='tour-bg-js.jpg'}
{$specialInsurancePic='bimeh-bg-js.jpg'}
{$specialVisaPic='visa-bg-js.jpg'}
{$specialTafrihPic='tafrihat-bg-js.jpg'}
<style>
    .banner-demo {
    {if $page.files.main_file.src && $smarty.const.GDS_SWITCH eq 'page'}
        {if $page['slug'] eq 'flight'}
            background-image: url("project_files/images/{$specialFlightPic}");
        {elseif $page['slug'] eq 'hotel'}
            background-image: url("project_files/images/{$specialHotelPic}");
        {elseif $page['slug'] eq 'bus'}
            background-image: url("project_files/images/{$specialBusPic}");
        {elseif $page['slug'] eq 'tour'}
            background-image: url("project_files/images/{$specialTourPic}");
        {elseif $page['slug'] eq 'insurance'}
            background-image: url("project_files/images/{$specialInsurancePic}");
        {elseif $page['slug'] eq 'visa'}
            background-image: url("project_files/images/{$specialVisaPic}");
        {elseif $page['slug'] eq 'tafrih'}
            background-image: url("project_files/images/{$specialTafrihPic}");
        {/if}
    {else}
        background-image: url("project_files/images/{$specialVisaPic}");
    {/if}
    }
</style>

<script>
    {literal}
    if($(window).width() > 576){
        {/literal}
        {if $specialFlightPic}
        {literal}
      $('#Flight-tab').click(function () {$('.banner-demo').css('background-image' , 'url("project_files/images/{/literal}{$specialFlightPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialHotelPic}
        {literal}
      $('#Hotel-tab').click(function () {$('.banner-demo').css('background-image' , 'url("project_files/images/{/literal}{$specialHotelPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialTrainPic}
        {literal}
      $('#Train-tab').click(function () {$('.banner-demo').css('background-image' , 'url("project_files/images/{/literal}{$specialTrainPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialBusPic}
        {literal}
      $('#Bus-tab').click(function () {$('.banner-demo').css('background-image' , 'url("project_files/images/{/literal}{$specialBusPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialTourPic}
        {literal}
      $('#Tour-tab').click(function () {$('.banner-demo').css('background-image' , 'url("project_files/images/{/literal}{$specialTourPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialInsurancePic}
        {literal}
      $('#Insurance-tab').click(function () {$('.banner-demo').css('background-image' , 'url("project_files/images/{/literal}{$specialInsurancePic}{literal}")')});
        {/literal}
        {/if}
        {if $specialVisaPic}
        {literal}
      $('#Visa-tab').click(function () {$('.banner-demo').css('background-image' , 'url("project_files/images/{/literal}{$specialVisaPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialTafrihPic}
        {literal}
      $('#Entertainment-tab').click(function () {$('.banner-demo').css('background-image' , 'url("project_files/images/{/literal}{$specialTafrihPic}{literal}")')});
        {/literal}
        {/if}
        {literal}

    }
</script>
{/literal}

