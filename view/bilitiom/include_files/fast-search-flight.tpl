


<section class="quick-search">
    <div class="container">
        <div class="title-safiran">
            <div class="text-title-safiran">
                <div class="parent-svg-title">
                    <svg height="1em" viewbox="0 0 32 32" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path d="M25.6 28.8c.4-.4.533-1.067.533-1.6l-3.467-14.4 6.4-6.4c.933-.933.933-2.533 0-3.467s-2.533-.933-3.467 0l-6.4 6.4L4.799 6c-.533-.133-1.2 0-1.6.533-.8.8-.533 2.133.4 2.667l10.267 5.333-6.4 6.4-3.733-.533c-.267 0-.533 0-.667.267l-.667.667c-.4.4-.267 1.067.133 1.333l4.267 2.4 2.4 4.267c.267.533.933.533 1.333.133l.667-.667c.133-.133.267-.4.267-.667l-.533-3.733 6.4-6.4 5.333 10.267c.667 1.067 2 1.333 2.933.533z"></path>
                    </svg>
                    <h2> جستجوی سریع بیلیتیوم </h2>
                </div>
                <p>سفر بعدیت رو از الان برنامه ریزی کن</p>
            </div>
        </div>
        <div class="quick-search-content">
            <div id="accordion1">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0 parent-accordion">
                            <button aria-controls="collapseOne" aria-expanded="true" autocomplete="off"
                                    class="btn btn-link w-100" data-target="#collapseOne" data-toggle="collapse">
                                پرواز های داخلی
                                <i class="far fa-angle-down mL-auto"></i>
                            </button>
                        </h5>
                    </div>
                    <div aria-labelledby="headingOne" class="collapse show" data-parent="#accordion1"
                         id="collapseOne" style="">
                        <div class="card-body">
                            <ul class="accordion-menu double_links">
                                {assign 'cities' ['AZD' => functions::Xmlinformation('S360AZD'),'KSH' =>functions::Xmlinformation('S360KSH'),'RAS' => functions::Xmlinformation('S360RAS') , 'ADU' => functions::Xmlinformation('S360ADU') , 'BND' =>  functions::Xmlinformation('S360BND')]}
                                {foreach $cities as $item}
                                    <li>
                                        <a onclick="calenderFlightSearch('THR','{$item@key}')"
                                           data-target="#calenderBox" data-toggle="modal">
                                            بلیط هواپیما تهران به {$item}
                                        </a>
                                    </li>
                                {/foreach}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div id="accordion2">
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h5 class="mb-0 parent-accordion">
                            <button aria-controls="collapseTwo" aria-expanded="true" autocomplete="off"
                                    class="btn btn-link w-100" data-target="#collapseTwo" data-toggle="collapse">
                                  پرواز های خارجی
                                <i class="far fa-angle-down mL-auto"></i>
                            </button>
                        </h5>
                    </div>
                    <div aria-labelledby="headingTwo" class="collapse show" data-parent="#accordion2"
                         id="collapseTwo" style="">
                        <div class="card-body">
                            <ul class="accordion-menu">
{*                                {assign 'cities' ['SYD' => functions::Xmlinformation('S360SYD'),'DXBALL' => functions::Xmlinformation('S360DXBALL'),'BERALL' => functions::Xmlinformation('S360BERALL'), 'LONALL' => functions::Xmlinformation('S360YXUALL'), 'NJF' => functions::Xmlinformation('S360NJF')]}*}
{*                                {foreach $cities as $item}*}
{*                                    <li>*}
{*                                        <a href="{$smarty.const.ROOT_ADDRESS}/international/1/IKA-{$item@key}/{$objDate->tomorrow()}/1-0-0">*}
{*                                            ##S360FlightTo## {$item}*}
{*                                        </a>*}
{*                                    </li>*}
{*                                {/foreach}*}

                                <li>
                                    <a href="{$smarty.const.ROOT_ADDRESS}/international/1/IKA-ISTALL/{$objDate->tomorrow()}/1-0-0">بلیط هواپیما تهران به استانبول</a>
                                </li>
                                <li>
                                    <a href="{$smarty.const.ROOT_ADDRESS}/international/1/ISTALL-IKA/{$objDate->tomorrow()}/1-0-0">بلیط هواپیما استانبول به تهران</a>
                                </li>
                                <li>
                                    <a href="{$smarty.const.ROOT_ADDRESS}/international/1/IKA-DXB/{$objDate->tomorrow()}/1-0-0">بلیط هواپیما تهران به دبی</a>
                                </li>
                                <li>
                                    <a href="{$smarty.const.ROOT_ADDRESS}/international/1/DXB-IKA/{$objDate->tomorrow()}/1-0-0">بلیط هواپیما دبی به تهران</a>
                                </li>
                                <li>
                                    <a href="{$smarty.const.ROOT_ADDRESS}/international/1/SYZ-TFS/{$objDate->tomorrow()}/1-0-0">بلیط هواپیما شیراز به تفلیس</a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div id="accordion3">
                <div class="card">
                    <div class="card-header" id="headingThree">
                        <h5 class="mb-0 parent-accordion">
                            <button aria-controls="collapseThree" aria-expanded="true" autocomplete="off"
                                    class="btn btn-link w-100" data-target="#collapseThree" data-toggle="collapse">
                                انواع بلیط هواپیما
                                <i class="far fa-angle-down mL-auto"></i>
                            </button>
                        </h5>
                    </div>
                    <div aria-labelledby="headingThree" class="collapse show" data-parent="#accordion3"
                         id="collapseThree" style="">
                        <div class="card-body">
                            <ul class="accordion-menu">
                                <li>
                                    <a href="{$smarty.const.ROOT_ADDRESS}/page/airplane_charter">خرید بلیط چارتری هواپیما</a>
                                </li>
                                <li>
                                    <a href="{$smarty.const.ROOT_ADDRESS}/page/airplane_last_minute">خرید بلیط لحظه آخری هواپیما</a>
                                </li>
                                <li>
                                    <a href="{$smarty.const.ROOT_ADDRESS}/page/airplane_system">خرید بلیط سیستمی هواپیما</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
