{load_presentation_object filename="requestReservation" assign="objRequestReservation"}
{load_presentation_object filename="reservationTour" assign="objTour"}
{*{$smarty.post.entetainmentId|json_encode}*}
{$objRequestReservation->initialize($smarty.post.serviceName)}
{load_presentation_object filename="members" assign="objMembers"}
{assign var="user_info" value=$objMembers->getMember()}



{assign var="targetDetail" value=$objRequestReservation->getTargetDetail($smarty.post)}
{*{$targetDetail|var_dump}*}
{if $smarty.post.serviceName eq 'tour'}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/request/tourDetail.tpl" targetDetail=$targetDetail}
{elseif $smarty.post.serviceName eq 'hotel'}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/request/hotel.tpl" targetDetail=$targetDetail}
{elseif $smarty.post.serviceName eq 'entertainment'}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/request/entertainment.tpl" targetDetail=$targetDetail}

{/if}

<div class='container d-flex justify-content-center my-5 p-5 s-u-passenger-wrapper-change w-100'>
    <div class=' col-lg-12 col-md-12 col-sm-12 d-flex flex-wrap  w-100'>
        <input type='hidden' id='serviceName' value='{$smarty.post.serviceName}'>

        <div class='col-lg-4 col-md-12 col-sm-12 mb-3 col-12'>
            <div class='from-group'>
                <input type='text' class='form-control'

                        {if !empty($user_info)}
                            value="{$user_info['name']} {$user_info['family']}" disabled
                        {/if}

                       id='requestedMemberName' placeholder='##Namefamily##'>
            </div>
        </div>
        <div class='col-lg-4 col-md-12 col-sm-12 mb-3 col-12'>
            <div class='from-group'>
                <input type='text' class='form-control' id='requestedMemberPhoneNumber'
                        {if !empty($user_info)}
                            value="{$user_info['mobile']}" disabled
                        {/if}

                       placeholder='##YourMobileNumber##'>
            </div>
        </div>
        <div class='col-lg-4 col-md-12 col-sm-12 mb-3 col-12 '>
            <input type='hidden' name='is_api' id='is_api' value='{$smarty.post.is_api}'>
            <button onclick='submitRequest($(this))' class='btn btn-primary w-100'>
                ##Submitapplication##
            </button>
        </div>
    </div>
</div>

<script src="assets/modules/js/request.js"></script>