
{assign var="padding" value=""}

{if preg_match("/iPhone|iPad|iPod/", $smarty.server.HTTP_USER_AGENT)}
    {assign var="padding" value="pb-3"}
{/if}

<div class="menu_fixed_bottom pwa-footer main-fixed-bottom-js {$padding}">
    <div class="phone-bottom ">
        <a href="{if $smarty.const.CLIENT_ID neq '150'}{$smarty.const.ROOT_ADDRESS}/app?to=search-service{else}https://www.hoteldebitcard.ir/s/{/if}" class="nav-link {if $smarty.get.to eq 'search-service'|| ( $smarty.get.to eq '' && $smarty.const.GDS_SWITCH eq 'app')} active {/if} text-dark font-weight-bold" data-index="0">
            <i class="far fa-home-lg"></i>
            <span class="nav-text">##Home##</span>
        </a>
        {if $smarty.const.CLIENT_ID neq '150'}
        <a href="{$smarty.const.ROOT_ADDRESS}/app?to=purchase-record" class="nav-link {if $smarty.get.to eq 'purchase-record'} active {/if} text-dark font-weight-bold" data-index="1">
            <i class="far fa-suitcase-rolling"></i>
            <span class="nav-text">##Buyarchive##</span>
        </a>
            <a href="{$smarty.const.ROOT_ADDRESS}/{if Session::IsLogin()}profile{else}loginUser?referrer=app{/if}"
               class="nav-link {if $smarty.get.to eq 'profile'} active {/if} text-dark font-weight-bold"
               data-index="2">
                <i class="far fa-user"></i>
                <span class="nav-text">##userAccount##</span>
            </a>


        <a href="{$smarty.const.ROOT_ADDRESS}/app?to=information" class="nav-link align-items-center {if $smarty.get.to eq 'information'} active {/if} text-dark font-weight-bold" data-index="4">


            <svg
                    version="1.0"
                    style="    width: 26px;
    transform: rotate(90deg);
    margin-top: -1px;"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 200.000000 200.000000"
                    preserveAspectRatio="xMidYMid meet">
                <g
                        transform="translate(0.000000,200.000000) scale(0.100000,-0.100000)"
                        stroke="none">
                    <path
                            d="M890 1728 c-58 -40 -74 -71 -78 -151 -3 -60 1 -80 20 -117 33 -64 74
            -85 168 -85 94 0 135 21 168 85 31 59 28 173 -4 217 -42 56 -80 73 -164 73
            -63 0 -83 -4 -110 -22z" />
                    <path
                            d="M914 1180 c-47 -15 -91 -70 -100 -126 -9 -63 2 -144 24 -173 41 -55
            67 -66 162 -66 74 0 93 3 116 21 59 43 69 68 69 164 0 95 -10 121 -67 163 -31
            23 -152 33 -204 17z" />
                    <path
                            d="M933 621 c-87 -22 -128 -90 -121 -202 4 -76 21 -108 78 -146 48 -33
            172 -33 220 -1 58 40 74 71 78 151 6 128 -47 192 -164 202 -32 2 -74 0 -91 -4z" />
                </g>
            </svg>

            <span class="nav-text">##myAgency##</span>

        </a>

        {/if}

    </div>
</div>
<div class='fixed-overly d-none'>
    <div class='full-center'>
    <div style='    width: 27px;'>
        <img class='w-100' src='assets/images/spinner.gif'>
    </div>
    </div>
</div>
<script>
    $(document).ready(()=>{
        $('.pwa-footer a').click(function (){
            // var loading_tag="<div style='left: unset; top: 3px;' class='mx-auto loading-spinner-holder' id='loading-holder'> <img class='w-100' src='assets/images/spinner.gif'> </div>";
            // $(this).append(loading_tag);
            // $(this).find('i').addClass('invisible');
            $('.fixed-overly').removeClass('d-none');
        })
    })
</script>