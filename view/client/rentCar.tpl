{load_presentation_object filename="rentCar" assign="objCar"}
{assign var="type_data" value=['is_active'=>1 ,'catId'=>$smarty.const.CAR_TYPE] }
{assign var='list_car' value=$objCar->listCar($type_data)}

<section class="car-reservation">
    {if $list_car}
    <div class="container">
        <div class="parent-car-grid">

            {foreach $list_car as $item}
            <a href="{$smarty.const.ROOT_ADDRESS}/reserveCar/{$item.id}/{$smarty.const.CAR_TYPE}/{$smarty.const.RENT_DATE}/{$smarty.const.RENT_PLACE}/{$smarty.const.DELIVERY_DATE}/{$smarty.const.DELIVERY_PLACE}" class="item-link-car">
                <div class="parent-img-card">
                    {if $item.pic}
                    <img src="{$item.pic_show}" alt="{$item.title}" title='{$item.title}'>
                    {/if}
                </div>
                <div class="parent-text-car">
                    <h2>{$item.title}</h2>
                    {if $item.price_customer}
                    <div class="price-car">
                        <svg class="bi bi-filter-right" width="1.2em" height="1.2em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M14 10.5a.5.5 0 00-.5-.5h-3a.5.5 0 000 1h3a.5.5 0 00.5-.5zm0-3a.5.5 0 00-.5-.5h-7a.5.5 0 000 1h7a.5.5 0 00.5-.5zm0-3a.5.5 0 00-.5-.5h-11a.5.5 0 000 1h11a.5.5 0 00.5-.5z" clip-rule="evenodd"></path>
                        </svg>

                        <h3>{$item.price_customer}</h3>
                    </div>
                    {/if}
                    {if $item.code}
                    <div class="code-car">
                        <svg class="bi bi-hash" width="1.2em" height="1.2em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.39 12.648a1.32 1.32 0 00-.015.18c0 .305.21.508.5.508.266 0 .492-.172.555-.477l.554-2.703h1.204c.421 0 .617-.234.617-.547 0-.312-.188-.53-.617-.53h-.985l.516-2.524h1.265c.43 0 .618-.227.618-.547 0-.313-.188-.524-.618-.524h-1.046l.476-2.304a1.06 1.06 0 00.016-.164.51.51 0 00-.516-.516.54.54 0 00-.539.43l-.523 2.554H7.617l.477-2.304c.008-.04.015-.118.015-.164a.512.512 0 00-.523-.516.539.539 0 00-.531.43L6.53 5.484H5.414c-.43 0-.617.22-.617.532 0 .312.187.539.617.539h.906l-.515 2.523H4.609c-.421 0-.609.219-.609.531 0 .313.188.547.61.547h.976l-.516 2.492c-.008.04-.015.125-.015.18 0 .305.21.508.5.508.265 0 .492-.172.554-.477l.555-2.703h2.242l-.515 2.492zm-1-6.109h2.266l-.515 2.563H6.859l.532-2.563z"></path>
                        </svg>
                        <span>{$item.code}</span>
                    </div>
                    {/if}
                    {if $item.content}
                    <p>
                        {$item.content}
                    </p>
                    {/if}
                    <button type="button" class="reservation-car">
                        ##Reservation##
                    </button>
                </div>
            </a>
            {/foreach}

        </div>
    </div>
    {else}
        <div class=" error" style="text-align: right;">
            <p >
                ##NotResultsFound##
            </p>
        </div>
    {/if}
</section>
{literal}
    <script src="assets/js/rentCar.js"></script>
{/literal}