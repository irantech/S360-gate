
{foreach $specialPageData as $specialPage}
    {if $specialPage['position'] eq 'Flight'}
        {assign var='specialFlight' value=$specialPage}
    {/if}
    {if $specialPage['position'] eq 'Hotel'}
        {assign var='specialHotel' value=$specialPage}
    {/if}
    {if $specialPage['position'] eq 'Train'}
        {assign var='specialTrain' value=$specialPage}
    {/if}
    {if $specialPage['position'] eq 'Bus'}
        {assign var='specialBus' value=$specialPage}
    {/if}
    {if $specialPage['position'] eq 'Tour'}
        {assign var='specialTour' value=$specialPage}
    {/if}
    {if $specialPage['position'] eq 'Insurance'}
        {assign var='specialInsurance' value=$specialPage}
    {/if}
    {if $specialPage['position'] eq 'MainPage'}
        {assign var='specialMainPage' value=$specialPage}
    {/if}
{/foreach}
{if $smarty.const.GDS_SWITCH eq 'Flight'}
    <style>.baner-searchbox{ background-image: url("{$specialFlight['files']['main_file']['src']}");}</style>
{/if}
{if $smarty.const.GDS_SWITCH eq 'Hotel'}
    <style>.baner-searchbox{ background-image: url("{$specialHotel['files']['main_file']['src']}");}</style>
{/if}
{if $smarty.const.GDS_SWITCH eq 'Train'}
    <style>.baner-searchbox{ background-image: url("{$specialTrain['files']['main_file']['src']}");}</style>
{/if}
{if $smarty.const.GDS_SWITCH eq 'Bus'}
    <style>.baner-searchbox{ background-image: url("{$specialBus['files']['main_file']['src']}");}</style>
{/if}
{if $smarty.const.GDS_SWITCH eq 'Tour'}
    <style>.baner-searchbox{ background-image: url("{$specialTour['files']['main_file']['src']}");}</style>
{/if}
{if $smarty.const.GDS_SWITCH eq 'Insurance'}
    <style>.baner-searchbox{ background-image: url("{$specialInsurance['files']['main_file']['src']}");}</style>
{/if}
{if $smarty.const.GDS_SWITCH eq 'mainPage'}
    <style>.baner-searchbox{ background-image: url("{$specialMainPage['files']['main_file']['src']}");}</style>
{/if}
<script>
    {literal}
    if($(window).width() > 576){
        {/literal}
        {if $specialFlight['files']['main_file']['src']}
        {literal}
        $('#Flight-tab').click(function () {
          $('.baner-searchbox').css('background-image' , 'url("{/literal}{$specialFlight['files']['main_file']['src']}{literal}")')
        });
        {/literal}
        {/if}
        {if $specialHotel['files']['main_file']['src']}
        {literal}
        $('#Hotel-tab').click(function () {

          $('.baner-searchbox').css('background-image' , 'url("{/literal}{$specialHotel['files']['main_file']['src']}{literal}")')});
        {/literal}
        {/if}
        {if $specialTrain['files']['main_file']['src']}
        {literal}
        $('#Train-tab').click(function () {$('.baner-searchbox').css('background-image' , 'url("{/literal}{$specialTrain['files']['main_file']['src']}{literal}")')});
        {/literal}
        {/if}
        {if $specialBus['files']['main_file']['src']}
        {literal}
        $('#Bus-tab').click(function () {$('.baner-searchbox').css('background-image' , 'url("{/literal}{$specialBus['files']['main_file']['src']}{literal}")')});
        {/literal}
        {/if}
        {if $specialTour['files']['main_file']['src']}
        {literal}
        $('#Tour-tab').click(function () {$('.baner-searchbox').css('background-image' , 'url("{/literal}{$specialTour['files']['main_file']['src']}{literal}")')});
        {/literal}
        {/if}
        {if $specialInsurance['files']['main_file']['src']}
        {literal}
        $('#Insurance-tab').click(function () {$('.baner-searchbox').css('background-image' , 'url("{/literal}{$specialInsurance['files']['main_file']['src']}{literal}")')});
        {/literal}
        {/if}
        {literal}

    }
</script>
{/literal}
