{load_presentation_object filename="clockTimezones" assign="objclock"}
{assign var="counter" value=$objclock->getClocksCount()}
<section class="">
        <div class="parent-clock-wrapper my-5">

                {assign var="number" value="0"}
                {assign var="number2" value="0"}
                {foreach $objclock->getClocksCount() as $key=>$counter}
                {assign var="counter" value= {$counter}}
                {/foreach}

                {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                        <script type="text/javascript" src="https://www.iran-tech.com/old/WeatherClockService/clockgroup.php?timezones={foreach $objclock->getClocks() as $key=>$clock}{$number=$number+1}{$clock['title_en']}{if $number<{$counter}},{/if}{/foreach}&titles={foreach $objclock->getClocks() as $key=>$clock}{$number2=$number2+1}{$clock['title_fa']}{if $number2<{$counter}},{/if}{/foreach}&BGColor=e3e0e0&H2Color=0066cc">

                        </script>

                {elseif $smarty.const.SOFTWARE_LANG eq 'ar'}
                <script type="text/javascript" src="https://www.iran-tech.com/old/WeatherClockService/clockgroup.php?timezones={foreach $objclock->getClocks() as $key=>$clock}{$number=$number+1}{$clock['title_en']}{if $number<{$counter}},{/if}{/foreach}&titles={foreach $objclock->getClocks() as $key=>$clock}{$number2=$number2+1}{$clock['title_en']}{if $number2<{$counter}},{/if}{/foreach}&BGColor=e3e0e0&H2Color=0066cc">

                </script>
                {else}
                        <script type="text/javascript" src="https://www.iran-tech.com/old/WeatherClockService/clockgroup.php?timezones={foreach $objclock->getClocks() as $key=>$clock}{$number=$number+1}{$clock['title_en']}{if $number<{$counter}},{/if}{/foreach}&titles={foreach $objclock->getClocks() as $key=>$clock}{$number2=$number2+1}{$clock['title_en']}{if $number2<{$counter}},{/if}{/foreach}&BGColor=e3e0e0&H2Color=0066cc">

                        </script>
                {/if}
        </div>
</section>

