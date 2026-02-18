{load_presentation_object filename="visa" assign="objVisaDocs"}
{assign var="data" value=$objVisaDocs->DocsAdditionalData($smarty.get.visaId)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/reservation/visaList">ویزا</a></li>
                <li class='active'>مدارک</li>

            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">


                <h4>درج مدارک</h4>
                <form id="EditDocs" method="post">
                    <input type="hidden" name="flag" value="updateDocs">
                    <input type="hidden" name="visa_id" value="{$smarty.get.visaId}">
                    <input type="hidden" name="docs_id" value="{$data['id']}">

                    <div class="row">

                    <div class="form-group col-sm-12 DynamicAdditionalData">






                        {if $data['AdditionalData'] eq ''}
                            {assign var="AdditionalData" value='[{"title":"", "icon":"","body":""}]'}
                        {/if}

                        {assign var="counter" value='0'}

                        {foreach key=key item=item from=$data['AdditionalData']|json_decode:true}

                            <div data-target="BaseAdditionalDataDiv" class="col-sm-12 p-0 form-group">
                                <div class="col-md-3 pr-0">
                                    <input data-parent="AdditionalDataValues" data-target="title" name="AdditionalData[{$counter}][title]" placeholder="عنوان" class="form-control"
                                           value="{$item.title}" type="text">
                                </div>
                                <div class="col-md-4">
                                    <input data-parent="AdditionalDataValues" data-target="body" name="AdditionalData[{$counter}][body]" placeholder="متن نمایش" class="form-control"
                                           value="{$item.body}" type="text">
                                </div>
                                <div class="col-md-4 pr-0">
                                    <select  dir="rtl" data-parent="AdditionalDataValues" data-target="icon"  name="AdditionalData[{$counter}][icon]" class="form-control selectpicker" style=''>
                                        <option value=''>انتخاب کنید...</option>
                                        <!-- Payment / Cards / Money -->
                                        <option {if $item['icon'] == 'fas fa-credit-card'} selected {/if} value="fas fa-credit-card" data-content="<i class='fas fa-credit-card'></i> Credit Card"></option>
                                        <option {if $item['icon'] == 'fab fa-cc-visa'} selected {/if} value="fab fa-cc-visa" data-content="<i class='fab fa-cc-visa'></i> Visa Card"></option>
                                        <option {if $item['icon'] == 'fab fa-cc-mastercard'} selected {/if} value="fab fa-cc-mastercard" data-content="<i class='fab fa-cc-mastercard'></i> Mastercard"></option>
                                        <option {if $item['icon'] == 'fab fa-cc-amex'} selected {/if} value="fab fa-cc-amex" data-content="<i class='fab fa-cc-amex'></i> Amex Card"></option>
                                        <option {if $item['icon'] == 'fab fa-cc-paypal'} selected {/if} value="fab fa-cc-paypal" data-content="<i class='fab fa-cc-paypal'></i> PayPal"></option>
                                        <option {if $item['icon'] == 'fas fa-wallet'} selected {/if} value="fas fa-wallet" data-content="<i class='fas fa-wallet'></i> Wallet"></option>
                                        <option {if $item['icon'] == 'fas fa-money-bill'} selected {/if} value="fas fa-money-bill" data-content="<i class='fas fa-money-bill'></i> Money"></option>
                                        <option {if $item['icon'] == 'fas fa-coins'} selected {/if} value="fas fa-coins" data-content="<i class='fas fa-coins'></i> Coins"></option>
                                        <option {if $item['icon'] == 'fas fa-piggy-bank'} selected {/if} value="fas fa-piggy-bank" data-content="<i class='fas fa-piggy-bank'></i> Piggy Bank"></option>
                                        <option {if $item['icon'] == 'fas fa-dollar-sign'} selected {/if} value="fas fa-dollar-sign" data-content="<i class='fas fa-dollar-sign'></i> Dollar"></option>

                                        <!-- Travel / Flight / Hotel / Luggage / Vehicles -->
                                        <option {if $item['icon'] == 'fas fa-plane'} selected {/if} value="fas fa-plane" data-content="<i class='fas fa-plane'></i> Airplane"></option>
                                        <option {if $item['icon'] == 'fas fa-plane-departure'} selected {/if} value="fas fa-plane-departure" data-content="<i class='fas fa-plane-departure'></i> Flight"></option>
                                        <option {if $item['icon'] == 'fas fa-suitcase'} selected {/if} value="fas fa-suitcase" data-content="<i class='fas fa-suitcase'></i> Suitcase"></option>
                                        <option {if $item['icon'] == 'fas fa-suitcase-rolling'} selected {/if} value="fas fa-suitcase-rolling" data-content="<i class='fas fa-suitcase-rolling'></i> Rolling Luggage"></option>
                                        <option {if $item['icon'] == 'fas fa-hotel'} selected {/if} value="fas fa-hotel" data-content="<i class='fas fa-hotel'></i> Hotel"></option>
                                        <option {if $item['icon'] == 'fas fa-map'} selected {/if} value="fas fa-map" data-content="<i class='fas fa-map'></i> Map"></option>
                                        <option {if $item['icon'] == 'fas fa-map-marker-alt'} selected {/if} value="fas fa-map-marker-alt" data-content="<i class='fas fa-map-marker-alt'></i> Location"></option>
                                        <option {if $item['icon'] == 'fas fa-route'} selected {/if} value="fas fa-route" data-content="<i class='fas fa-route'></i> Route"></option>
                                        <option {if $item['icon'] == 'fas fa-compass'} selected {/if} value="fas fa-compass" data-content="<i class='fas fa-compass'></i> Compass"></option>
                                        <option {if $item['icon'] == 'fas fa-umbrella-beach'} selected {/if} value="fas fa-umbrella-beach" data-content="<i class='fas fa-umbrella-beach'></i> Vacation"></option>

                                        <!-- Vehicles -->
                                        <option {if $item['icon'] == 'fas fa-car'} selected {/if} value="fas fa-car" data-content="<i class='fas fa-car'></i> Car"></option>
                                        <option {if $item['icon'] == 'fas fa-bus'} selected {/if} value="fas fa-bus" data-content="<i class='fas fa-bus'></i> Bus"></option>
                                        <option {if $item['icon'] == 'fas fa-ship'} selected {/if} value="fas fa-ship" data-content="<i class='fas fa-ship'></i> Ship"></option>
                                        <option {if $item['icon'] == 'fas fa-train'} selected {/if} value="fas fa-train" data-content="<i class='fas fa-train'></i> Train"></option>
                                        <option {if $item['icon'] == 'fas fa-bicycle'} selected {/if} value="fas fa-bicycle" data-content="<i class='fas fa-bicycle'></i> Bicycle"></option>
                                        <option {if $item['icon'] == 'fas fa-motorcycle'} selected {/if} value="fas fa-motorcycle" data-content="<i class='fas fa-motorcycle'></i> Motorcycle"></option>

                                        <!-- Documents / Files / ID / Contracts / Tickets -->
                                        <option {if $item['icon'] == 'fas fa-passport'} selected {/if} value="fas fa-passport" data-content="<i class='fas fa-passport'></i> Passport"></option>
                                        <option {if $item['icon'] == 'fas fa-file-alt'} selected {/if} value="fas fa-file-alt" data-content="<i class='fas fa-file-alt'></i> Document"></option>
                                        <option {if $item['icon'] == 'fas fa-file-invoice'} selected {/if} value="fas fa-file-invoice" data-content="<i class='fas fa-file-invoice'></i> Invoice"></option>
                                        <option {if $item['icon'] == 'fas fa-file-contract'} selected {/if} value="fas fa-file-contract" data-content="<i class='fas fa-file-contract'></i> Contract"></option>
                                        <option {if $item['icon'] == 'fas fa-id-card'} selected {/if} value="fas fa-id-card" data-content="<i class='fas fa-id-card'></i> ID Card"></option>
                                        <option {if $item['icon'] == 'fas fa-id-badge'} selected {/if} value="fas fa-id-badge" data-content="<i class='fas fa-id-badge'></i> ID Badge"></option>
                                        <option {if $item['icon'] == 'fas fa-stamp'} selected {/if} value="fas fa-stamp" data-content="<i class='fas fa-stamp'></i> Stamp"></option>
                                        <option {if $item['icon'] == 'fas fa-ticket-alt'} selected {/if} value="fas fa-ticket-alt" data-content="<i class='fas fa-ticket-alt'></i> Ticket"></option>
                                        <option {if $item['icon'] == 'fas fa-clipboard'} selected {/if} value="fas fa-clipboard" data-content="<i class='fas fa-clipboard'></i> Clipboard"></option>
                                        <option {if $item['icon'] == 'fas fa-briefcase'} selected {/if} value="fas fa-briefcase" data-content="<i class='fas fa-briefcase'></i> Briefcase"></option>

                                        <!-- Users / Support / Staff -->
                                        <option {if $item['icon'] == 'fas fa-user'} selected {/if} value="fas fa-user" data-content="<i class='fas fa-user'></i> Applicant"></option>
                                        <option {if $item['icon'] == 'fas fa-users'} selected {/if} value="fas fa-users" data-content="<i class='fas fa-users'></i> Passengers"></option>
                                        <option {if $item['icon'] == 'fas fa-headset'} selected {/if} value="fas fa-headset" data-content="<i class='fas fa-headset'></i> Support"></option>
                                        <option {if $item['icon'] == 'fas fa-user-tie'} selected {/if} value="fas fa-user-tie" data-content="<i class='fas fa-user-tie'></i> Staff"></option>
                                        <option {if $item['icon'] == 'fas fa-user-shield'} selected {/if} value="fas fa-user-shield" data-content="<i class='fas fa-user-shield'></i> Manager"></option>
                                        <option {if $item['icon'] == 'fas fa-user-cog'} selected {/if} value="fas fa-user-cog" data-content="<i class='fas fa-user-cog'></i> Admin"></option>
                                        <option {if $item['icon'] == 'fas fa-chalkboard-teacher'} selected {/if} value="fas fa-chalkboard-teacher" data-content="<i class='fas fa-chalkboard-teacher'></i> Instructor"></option>
                                        <option {if $item['icon'] == 'fas fa-hands-helping'} selected {/if} value="fas fa-hands-helping" data-content="<i class='fas fa-hands-helping'></i> Volunteer"></option>
                                        <option {if $item['icon'] == 'fas fa-hands'} selected {/if} value="fas fa-hands" data-content="<i class='fas fa-hands'></i> Assistance"></option>
                                        <option {if $item['icon'] == 'fas fa-user-plus'} selected {/if} value="fas fa-user-plus" data-content="<i class='fas fa-user-plus'></i> Add User"></option>

                                        <!-- Security / Locks / Keys / Shields -->
                                        <option {if $item['icon'] == 'fas fa-lock'} selected {/if} value="fas fa-lock" data-content="<i class='fas fa-lock'></i> Lock"></option>
                                        <option {if $item['icon'] == 'fas fa-key'} selected {/if} value="fas fa-key" data-content="<i class='fas fa-key'></i> Key"></option>
                                        <option {if $item['icon'] == 'fas fa-shield-alt'} selected {/if} value="fas fa-shield-alt" data-content="<i class='fas fa-shield-alt'></i> Shield"></option>
                                        <option {if $item['icon'] == 'fas fa-shield-virus'} selected {/if} value="fas fa-shield-virus" data-content="<i class='fas fa-shield-virus'></i> Security Shield"></option>
                                        <option {if $item['icon'] == 'fas fa-user-lock'} selected {/if} value="fas fa-user-lock" data-content="<i class='fas fa-user-lock'></i> User Lock"></option>
                                        <option {if $item['icon'] == 'fas fa-unlock'} selected {/if} value="fas fa-unlock" data-content="<i class='fas fa-unlock'></i> Unlock"></option>
                                        <option {if $item['icon'] == 'fas fa-exclamation-triangle'} selected {/if} value="fas fa-exclamation-triangle" data-content="<i class='fas fa-exclamation-triangle'></i> Warning"></option>
                                        <option {if $item['icon'] == 'fas fa-user-secret'} selected {/if} value="fas fa-user-secret" data-content="<i class='fas fa-user-secret'></i> Secret"></option>
                                        <option {if $item['icon'] == 'fas fa-eye-slash'} selected {/if} value="fas fa-eye-slash" data-content="<i class='fas fa-eye-slash'></i> Hidden"></option>
                                        <option {if $item['icon'] == 'fas fa-user-check'} selected {/if} value="fas fa-user-check" data-content="<i class='fas fa-user-check'></i> Verified User"></option>

                                        <!-- Misc / Calendar / Clock / Certificates / Gifts / Ratings / Info / Miscellaneous -->
                                        <option {if $item['icon'] == 'fas fa-calendar-alt'} selected {/if} value="fas fa-calendar-alt" data-content="<i class='fas fa-calendar-alt'></i> Calendar"></option>
                                        <option {if $item['icon'] == 'fas fa-clock'} selected {/if} value="fas fa-clock" data-content="<i class='fas fa-clock'></i> Clock"></option>
                                        <option {if $item['icon'] == 'fas fa-gift'} selected {/if} value="fas fa-gift" data-content="<i class='fas fa-gift'></i> Gift"></option>
                                        <option {if $item['icon'] == 'fas fa-star'} selected {/if} value="fas fa-star" data-content="<i class='fas fa-star'></i> Rating"></option>
                                        <option {if $item['icon'] == 'fas fa-certificate'} selected {/if} value="fas fa-certificate" data-content="<i class='fas fa-certificate'></i> Certificate"></option>
                                        <option {if $item['icon'] == 'fas fa-info-circle'} selected {/if} value="fas fa-info-circle" data-content="<i class='fas fa-info-circle'></i> Info"></option>
                                        <option {if $item['icon'] == 'fas fa-question-circle'} selected {/if} value="fas fa-question-circle" data-content="<i class='fas fa-question-circle'></i> Help"></option>
                                        <option {if $item['icon'] == 'fas fa-bell'} selected {/if} value="fas fa-bell" data-content="<i class='fas fa-bell'></i> Notification"></option>
                                        <option {if $item['icon'] == 'fas fa-envelope'} selected {/if} value="fas fa-envelope" data-content="<i class='fas fa-envelope'></i> Email"></option>
                                        <option {if $item['icon'] == 'fas fa-globe'} selected {/if} value="fas fa-globe" data-content="<i class='fas fa-globe'></i> Internet"></option>
                                        <option {if $item['icon'] == 'fas fa-camera'} selected {/if} value="fas fa-camera" data-content="<i class='fas fa-camera'></i> Camera"></option>


                                    </select>
                                </div>
                                <div class="col-md-1 pl-0">
                                    <div class="col-md-6 p-0">
                                        <button type="button" onclick="AddAdditionalData()" class="btn form-control btn-success">
                                            <span class="fa fa-plus"></span>
                                        </button>
                                    </div>
                                    <div class="col-md-6 p-0">
                                        <button onclick="RemoveAdditionalData($(this))" type="button" class="btn form-control btn-danger">
                                            <span class="fa fa-remove"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            {assign var="counter" value=$counter+1}
                        {/foreach}

                        {if empty($data['AdditionalData'])}
                        <div data-target="BaseAdditionalDataDiv" class="col-sm-12 p-0 form-group">
                            <div class="col-md-3 pr-0">
                                <input data-parent="AdditionalDataValues" data-target="title" name="AdditionalData[{$counter}][title]" placeholder="عنوان" class="form-control"
                                       value="" type="text">
                            </div>
                            <div class="col-md-4">
                                <input data-parent="AdditionalDataValues" data-target="body" name="AdditionalData[{$counter}][body]" placeholder="متن نمایش" class="form-control"
                                       value="" type="text">
                            </div>
                            <div class="col-md-4 pr-0">
                                <select  dir="rtl" data-parent="AdditionalDataValues" data-target="icon"  name="AdditionalData[{$counter}][icon]" class="form-control selectpicker" style=''>
                                    <option  value=''>انتخاب کنید...</option>
                                    <!-- Payment / Cards / Money -->
                                    <option value="fas fa-credit-card" data-content="<i class='fas fa-credit-card'></i> Credit Card"></option>
                                    <option value="fab fa-cc-visa" data-content="<i class='fab fa-cc-visa'></i> Visa Card"></option>
                                    <option value="fab fa-cc-mastercard" data-content="<i class='fab fa-cc-mastercard'></i> Mastercard"></option>
                                    <option value="fab fa-cc-amex" data-content="<i class='fab fa-cc-amex'></i> Amex Card"></option>
                                    <option value="fab fa-cc-paypal" data-content="<i class='fab fa-cc-paypal'></i> PayPal"></option>
                                    <option value="fas fa-wallet" data-content="<i class='fas fa-wallet'></i> Wallet"></option>
                                    <option value="fas fa-money-bill" data-content="<i class='fas fa-money-bill'></i> Money"></option>
                                    <option value="fas fa-coins" data-content="<i class='fas fa-coins'></i> Coins"></option>
                                    <option value="fas fa-piggy-bank" data-content="<i class='fas fa-piggy-bank'></i> Piggy Bank"></option>
                                    <option value="fas fa-dollar-sign" data-content="<i class='fas fa-dollar-sign'></i> Dollar"></option>

                                    <!-- Travel / Flight / Hotel / Luggage / Vehicles -->
                                    <option value="fas fa-plane" data-content="<i class='fas fa-plane'></i> Airplane"></option>
                                    <option value="fas fa-plane-departure" data-content="<i class='fas fa-plane-departure'></i> Flight"></option>
                                    <option value="fas fa-suitcase" data-content="<i class='fas fa-suitcase'></i> Suitcase"></option>
                                    <option value="fas fa-suitcase-rolling" data-content="<i class='fas fa-suitcase-rolling'></i> Rolling Luggage"></option>
                                    <option value="fas fa-hotel" data-content="<i class='fas fa-hotel'></i> Hotel"></option>
                                    <option value="fas fa-map" data-content="<i class='fas fa-map'></i> Map"></option>
                                    <option value="fas fa-map-marker-alt" data-content="<i class='fas fa-map-marker-alt'></i> Location"></option>
                                    <option value="fas fa-route" data-content="<i class='fas fa-route'></i> Route"></option>
                                    <option value="fas fa-compass" data-content="<i class='fas fa-compass'></i> Compass"></option>
                                    <option value="fas fa-umbrella-beach" data-content="<i class='fas fa-umbrella-beach'></i> Vacation"></option>

                                    <!-- Vehicles -->
                                    <option value="fas fa-car" data-content="<i class='fas fa-car'></i> Car"></option>
                                    <option value="fas fa-bus" data-content="<i class='fas fa-bus'></i> Bus"></option>
                                    <option value="fas fa-ship" data-content="<i class='fas fa-ship'></i> Ship"></option>
                                    <option value="fas fa-train" data-content="<i class='fas fa-train'></i> Train"></option>
                                    <option value="fas fa-bicycle" data-content="<i class='fas fa-bicycle'></i> Bicycle"></option>
                                    <option value="fas fa-motorcycle" data-content="<i class='fas fa-motorcycle'></i> Motorcycle"></option>

                                    <!-- Documents / Files / ID / Contracts / Tickets -->
                                    <option value="fas fa-passport" data-content="<i class='fas fa-passport'></i> Passport"></option>
                                    <option value="fas fa-file-alt" data-content="<i class='fas fa-file-alt'></i> Document"></option>
                                    <option value="fas fa-file-invoice" data-content="<i class='fas fa-file-invoice'></i> Invoice"></option>
                                    <option value="fas fa-file-contract" data-content="<i class='fas fa-file-contract'></i> Contract"></option>
                                    <option value="fas fa-id-card" data-content="<i class='fas fa-id-card'></i> ID Card"></option>
                                    <option value="fas fa-id-badge" data-content="<i class='fas fa-id-badge'></i> ID Badge"></option>
                                    <option value="fas fa-stamp" data-content="<i class='fas fa-stamp'></i> Stamp"></option>
                                    <option value="fas fa-ticket-alt" data-content="<i class='fas fa-ticket-alt'></i> Ticket"></option>
                                    <option value="fas fa-clipboard" data-content="<i class='fas fa-clipboard'></i> Clipboard"></option>
                                    <option value="fas fa-briefcase" data-content="<i class='fas fa-briefcase'></i> Briefcase"></option>

                                    <!-- Users / Support / Staff -->
                                    <option value="fas fa-user" data-content="<i class='fas fa-user'></i> Applicant"></option>
                                    <option value="fas fa-users" data-content="<i class='fas fa-users'></i> Passengers"></option>
                                    <option value="fas fa-headset" data-content="<i class='fas fa-headset'></i> Support"></option>
                                    <option value="fas fa-user-tie" data-content="<i class='fas fa-user-tie'></i> Staff"></option>
                                    <option value="fas fa-user-shield" data-content="<i class='fas fa-user-shield'></i> Manager"></option>
                                    <option value="fas fa-user-cog" data-content="<i class='fas fa-user-cog'></i> Admin"></option>
                                    <option value="fas fa-chalkboard-teacher" data-content="<i class='fas fa-chalkboard-teacher'></i> Instructor"></option>
                                    <option value="fas fa-hands-helping" data-content="<i class='fas fa-hands-helping'></i> Volunteer"></option>
                                    <option value="fas fa-hands" data-content="<i class='fas fa-hands'></i> Assistance"></option>
                                    <option value="fas fa-user-plus" data-content="<i class='fas fa-user-plus'></i> Add User"></option>

                                    <!-- Security / Locks / Keys / Shields -->
                                    <option value="fas fa-lock" data-content="<i class='fas fa-lock'></i> Lock"></option>
                                    <option value="fas fa-key" data-content="<i class='fas fa-key'></i> Key"></option>
                                    <option value="fas fa-shield-alt" data-content="<i class='fas fa-shield-alt'></i> Shield"></option>
                                    <option value="fas fa-shield-virus" data-content="<i class='fas fa-shield-virus'></i> Security Shield"></option>
                                    <option value="fas fa-user-lock" data-content="<i class='fas fa-user-lock'></i> User Lock"></option>
                                    <option value="fas fa-unlock" data-content="<i class='fas fa-unlock'></i> Unlock"></option>
                                    <option value="fas fa-exclamation-triangle" data-content="<i class='fas fa-exclamation-triangle'></i> Warning"></option>
                                    <option value="fas fa-user-secret" data-content="<i class='fas fa-user-secret'></i> Secret"></option>
                                    <option value="fas fa-eye-slash" data-content="<i class='fas fa-eye-slash'></i> Hidden"></option>
                                    <option value="fas fa-user-check" data-content="<i class='fas fa-user-check'></i> Verified User"></option>

                                    <!-- Misc / Calendar / Clock / Certificates / Gifts / Ratings / Info / Miscellaneous -->
                                    <option value="fas fa-calendar-alt" data-content="<i class='fas fa-calendar-alt'></i> Calendar"></option>
                                    <option value="fas fa-clock" data-content="<i class='fas fa-clock'></i> Clock"></option>
                                    <option value="fas fa-gift" data-content="<i class='fas fa-gift'></i> Gift"></option>
                                    <option value="fas fa-star" data-content="<i class='fas fa-star'></i> Rating"></option>
                                    <option value="fas fa-certificate" data-content="<i class='fas fa-certificate'></i> Certificate"></option>
                                    <option value="fas fa-info-circle" data-content="<i class='fas fa-info-circle'></i> Info"></option>
                                    <option value="fas fa-question-circle" data-content="<i class='fas fa-question-circle'></i> Help"></option>
                                    <option value="fas fa-bell" data-content="<i class='fas fa-bell'></i> Notification"></option>
                                    <option value="fas fa-envelope" data-content="<i class='fas fa-envelope'></i> Email"></option>
                                    <option value="fas fa-globe" data-content="<i class='fas fa-globe'></i> Internet"></option>
                                    <option value="fas fa-camera" data-content="<i class='fas fa-camera'></i> Camera"></option>
                                </select>
                            </div>
                            <div class="col-md-1 pl-0">
                                <div class="col-md-6 p-0">
                                    <button type="button" onclick="AddAdditionalData()" class="btn form-control btn-success">
                                        <span class="fa fa-plus"></span>
                                    </button>
                                </div>
                                <div class="col-md-6 p-0">
                                    <button onclick="RemoveAdditionalData($(this))" type="button" class="btn form-control btn-danger">
                                        <span class="fa fa-remove"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        {/if}

                    </div>
                </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label" for="note">نکته</label>
                            <textarea name="note" id="note" class="form-control" placeholder="نکته">{$data['note']}</textarea>
                        </div>
                    </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">ارسال اطلاعات</button>
                        </div>
                    </div>
                </div>

                </form>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/visa.js"></script>
<style>
    .shown-on-result {

    }
</style>