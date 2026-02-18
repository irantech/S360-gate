{load_presentation_object filename="user" assign="objUser"}

{assign var="typeMember" value=$objFunctions->TypeUser($objSession->getUserId())}

{if $objSession->IsLogin() and $objSession->getTypeUser() eq 'counter'}

    {load_presentation_object filename="Emerald" assign="objUserEmerald"}
    {load_presentation_object filename="Session" assign="objSession"}
    {load_presentation_object filename="members" assign="objMembers"}
    {assign var="infoZomorod" value=$objMembers->infoZomorod($objSession->getUserId())}
    {assign var="profileEmerald" value=$objUserEmerald->getProfile({$objSession->getUserId()})}
    {assign var="infoBank" value=$objFunctions->InfoBank()} {* گرفتن لیست بانک ها *}
    {load_presentation_object filename="passengersDetailLocal" assign="objDetail"}

    {assign var="profile" value=$objUser->getProfile({$objSession->getUserId()})} {*گرفتن اطلاعات کاربر*}

    {$objDetail->getCustomers()}              {*گرفتن اطلاعات مربوط به مسافران هر مشتری*}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`clientProfile.tpl"}

    {assign var="classNameBirthdayCalendar" value="shamsiBirthdayCalendar"}
    {if $smarty.const.SOFTWARE_LANG neq 'fa'}
        {$classNameBirthdayCalendar="gregorianBirthdayCalendar"}
    {/if}

    <div class="client-head-content">

        <div class="client-head-content_c_">
            <div class="d-none main-Content-top s-u-passenger-wrapper-change">
               {*<span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                    <i class="zmdi zmdi-account-box-mail zmdi-hc-fw mart10"></i>
                </span>*}
                <div class="panel-default-change border-0">
                    <div class="s-u-result-item-change">
                        {{functions::StrReplaceInXml(["@@click@@"=>"<a href='http://{$smarty.const.CLIENT_MAIN_DOMAIN}/{$MainUrlAddress}' style='color:red'>##ClickHere##</a>"],"InformationNotMandatory")}}
                    </div>
                </div>
            </div>
            <div class="main-Content-top s-u-passenger-wrapper-change">
                <div class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                    <span>
                        <i class="zmdi zmdi-account-box-mail zmdi-hc-fw mart10"></i> ##Informationprofile##
                    </span>
                    <span>
                         {if $profile['last_modify'] neq 0}
                             {$last_modify_date = date('Y-m-d',strtotime($profile['last_modify']))}
                             {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                 {$last_modify_date = $objFunctions->DateJalali($profile['last_modify'])}
                             {/if}
                         {/if}
                        ##Lastchangeupdate## : <span class='s-u-passenger-date'>{$last_modify_date}</span>
                    </span>
                    <span>
                          {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                              {$register_date = $objFunctions->DateJalali($profile['register_date'])}
                            {else}
                              {$register_date = date('Y-m-d',strtotime($profile['register_date']))}
                          {/if}

                        ##Setupdate##: <span class='s-u-passenger-date'>{$register_date}</span>
                    </span>

                </div>
                <div class="panel-default-change border-0">
                    <form class=" s-u-result-item-change" data-toggle="validator" id="UpdateUser" method="post">
                        <input type="hidden" value="UpdateUser" name="flag">

                        <div class="s-u-passenger-item  s-u-passenger-item-change form-group">
                            <label for="name" class="flr">##Name##:</label>
                            <input type="text" name="name" id="name" value="{$profile['name']}" placeholder="##Name##">
                        </div>

                        <div class="s-u-passenger-item  s-u-passenger-item-change form-group">
                            <label for="family" class="flr"> ##Family##:</label>
                            <input type="text" name="family" id="family" value="{$profile['family']}"
                                   placeholder="##Family## ">
                        </div>

                        <div class="s-u-passenger-item  s-u-passenger-item-change form-group no-star">
                            <label for="gender" class="flr">##Sex##:</label>
                            <select name="gender">
                                <option value="" disabled="disabled" selected="selected">##Sex##</option>
                                <option value="Male" {if $profile['gender'] eq 'Male'}selected="selected"{/if}>##Male##
                                </option>
                                <option value="Female" {if $profile['gender'] eq 'Female'}selected="selected"{/if}>
                                    ##Female##
                                </option>
                            </select>
                        </div>

                        <div class="s-u-passenger-item  s-u-passenger-item-change form-group no-star">
                            <label for="birthday" class="flr"> ##Happybirthday##:</label>
                            <input type="text" name="birthday" id="birthday" value="{$profile['birthday']}"
                                   placeholder=" ##Happybirthday##" class="{$classNameBirthdayCalendar}">
                        </div>

                        <div class="d-none s-u-passenger-item  s-u-passenger-item-change form-group no-star">
                            <label for="marriage" class="flr"> ##Maritalstatus##:</label>
                            <select name="marriage">
                                <option value="" disabled="disabled" selected="selected"> ##Maritalstatus##</option>
                                <option value="Single" {if $profile['marriage'] eq 'Single'}selected="selected"{/if}>
                                    ##Single##
                                </option>
                                <option value="Married" {if $profile['marriage'] eq 'Married'}selected="selected"{/if}>
                                    ##Married##
                                </option>
                            </select>
                        </div>


                        <div class="s-u-passenger-item  s-u-passenger-item-change form-group">
                            <label for="mobile" class="flr">##Phonenumber##:</label>
                            <input type="text" name="mobile" id="mobile" value="{$profile['mobile']}"
                                   placeholder="##Phonenumber##">
                        </div>

                        <div class="s-u-passenger-item  s-u-passenger-item-change form-group no-star">
                            <label for="address" class="flr">##Address##:</label>
                            <input type="text" name="address" id="address" value="{$profile['address']}"
                                   placeholder="##Address##">
                        </div>

                        <div class="s-u-passenger-item  s-u-passenger-item-change form-group">
                            <label for="email" class="flr"> ##Email##:</label>
                            <input type="text" name="email" id="email" value="{$profile['email']}"
                                   placeholder="##Email##"
                                   >
                        </div>
{*                        <div class="s-u-passenger-item  s-u-passenger-item-change form-group">*}
{*                            <label for="mobile" class="flr"> ##Setupdate##:</label>*}

{*                            {if $smarty.const.SOFTWARE_LANG eq 'fa'}*}
{*                                <input type="text" value="{$objFunctions->DateJalali($profile['register_date'])}"*}
{*                                       disabled="disabled">*}
{*                            {else}*}
{*                                <input type="text" value="{date('Y-m-d',strtotime($profile['register_date']))}"*}
{*                                       disabled="disabled">*}
{*                            {/if}*}

{*                        </div>*}

{*                        <div class="s-u-passenger-item  s-u-passenger-item-change form-group no-star">*}
{*                            <label for="mobile" class="flr">##Lastchangeupdate## :</label>*}
{*                            {assign var="last_modify_date" value=''}*}
{*			    *}
{*                            {if $profile['last_modify'] neq 0}*}
{*                                {$last_modify_date = date('Y-m-d',strtotime($profile['last_modify']))}*}
{*                                {if $smarty.const.SOFTWARE_LANG eq 'fa'}*}
{*                                    {$last_modify_date = $objFunctions->DateJalali($profile['last_modify'])}*}
{*                                {/if}*}
{*                            {/if}*}

{*                            <input type="text" value="{$last_modify_date}"*}
{*                                   disabled="disabled">*}

{*                        </div>*}

                        {if $typeMember eq 'Counter'}
                            <div class="s-u-passenger-item  s-u-passenger-item-change form-group">
                                <label for="mobile" class="flr"> ##Typecounter##:</label>
                                <input type="text" value="{$objUser->getTypeCounterEn({$objUser->getTypeCounter($profile['fk_counter_type_id'])})}"
                                       disabled="disabled">
                            </div>
                        {/if}

                        {if $typeMember eq 'Counter'}
                            <div class="s-u-passenger-item  s-u-passenger-item-change form-group">
                                <label for="mobile" class="flr"> ##Namedependentagency##:</label>
                                <input type="text" value="{$objUser->getAgencyName($profile['fk_agency_id'])}"
                                       disabled="disabled">
                            </div>
                        {/if}

                        {if $profile['is_member'] eq '1' && $profile['fk_counter_type_id'] eq '5'}
                            <div class="reagent-code-box site-bg-second-color pull-right w-100">
                                <p>{functions::StrReplaceInXml(["@@code@@"=>$profile['reagent_code']],"Getrivalbygivingthiscode")}</p>
{*                                <p>##Yourcode##: (##Getrivalbygivingthiscode##)</p>*}
{*                                <span class="site-bg-color-dock-border">{$profile['reagent_code']}</span>*}
                            </div>
                        {/if}

                        <div class="userProfileInfo-btn userProfileInfo-btn-change">
                            <input class="s-u-select-flight-change site-secondary-text-color site-main-button-flat-color"
                                   type="submit" value="##ChangeInformation## ">
                        </div>

                    </form>
                </div>
            </div>


            {*charge user*}
            {*{if $smarty.const.SOFTWARE_LANG eq 'fa'}

                <span class='d-none'>
                    {$smarty.session.layout}
                </span>
            {if $smarty.session.layout neq 'pwa'}
                {if $objFunctions->TypeUser($objSession->getUserId()) neq 'Counter'}
                    <div class="main-Content-top s-u-passenger-wrapper-change">
                    <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                        <i class="zmdi zmdi-account-box-mail zmdi-hc-fw mart10"></i> ##ChargeAccount##
                    </span>
                    <div class="panel-default-change border-0" style="padding: 10px;">
                        <div class="s-u-passenger-item s-u-passenger-item-change s-u-passenger-item-change_u form-group ">
                            <label for="name" class="flr"> ##Amount##:</label>
                            <input type="text" name="Price" id="Price" value=""
                                   placeholder="##InterPrice##">
                        </div>
                        <div class="row banks_ha">
                            {if $infoBank|count > 0}
                                <div class="s-u-select-bank mart30 onlinePaymentBox">
                                    <div class="main-banks-logo main-banks-logo1">
                                        {foreach $infoBank as $key => $bank}
                                            <div class="bank-logo bank-logo1">
                                                <div class="bank_logo_c">
                                                    <i class="fa fa-check tick_bank"></i>
                                                <input class="input_bank" type="radio" name="bank" value="{$bank['bank_dir']}"
                                                       id="{$bank['bank_dir']}" {if $key eq 0}checked="checked"{/if}>
                                                <label for="{$bank['bank_dir']}">
                                                    <img src="assets/images/bank/bank{$bank['title_en']}.png"
                                                         alt="{$bank['title']}" class="s-u-bank-logo s-u-bank-logo-bank">
                                                </label>
                                                </div>
                                            </div>
                                        {/foreach}
                                        {assign var="bankInputs" value=['serviceType' => 'chargeAccountUser']}
                                        {assign var="bankAction" value="`$smarty.const.ROOT_ADDRESS`/goBankLocal"}
                                        <input type="hidden" value="increaseCreditAgency" name="TypeCharge" id="TypeCharge">
                                    </div>
                                    ##Thesupermarketacceptsallbankcardnetworkmembershurry##
                                </div>
                            {else}
                                <div class="s-u-select-update-wrapper">
                                    <a href="javascript:;"
                                       class="s-u-select-update text-dark s-u-select-update-change disabledButtonPayOnline">##Unfortunatelythereisactivebank##</a>
                                </div>
                            {/if}
                        </div>
                        <div class="userProfileInfo-btn userProfileInfo-btn-change">
                            <input class="s-u-select-flight-change site-secondary-text-color site-main-button-flat-color"
                                   type="submit" value="##Payment##" onclick='SendDataForBank("{$bankAction}", {$bankInputs|json_encode})'>
                        </div>

                    </div>
                </div>
                {/if}
            {/if}

            {/if}*}
        </div>
        {*end charge user*}



        <div class="main-Content-top s-u-passenger-wrapper-change">
    <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
        <i class="zmdi zmdi-account-box-mail zmdi-hc-fw mart10"></i> ##Setpassenger##
    </span>
            <div class="panel-default-change border-0">
                <form class=" s-u-result-item-change" data-toggle="validator" id="PassengersAdd" method="post">
                    <input type="hidden" name="flag" value="PassengersAdd">

                    <div class="panel-body-change">

                        <div class="col-md-12 txtRight {if $smarty.const.SOFTWARE_LANG neq 'fa'} d-none {/if}">
                            <span class="hidden-xs-down">##Nation##:</span>

                            <span class="kindOfPasenger">
						<label class="control--checkbox">
                            <span>##Iranian##</span>
                            <input type="radio" name="passengerNationality" value="0" class="nationalityChange"
                                   checked="checked">
                            <div class="checkbox">
                                <div class="filler"></div>
                                <svg width="20px" height="20px" viewBox="0 0 20 20">
                                    <polyline points="4 11 8 15 16 6"></polyline>
                                </svg>
                            </div>
                        </label>
                    </span>
                            <span class="kindOfPasenger">
						<label class="control--checkbox">
                            <span>##Noiranian## </span>
                            <input type="radio" name="passengerNationality" value="1" class="nationalityChange">
                            <div class="checkbox">
                                <div class="filler"></div>
                                <svg width="20px" height="20px" viewBox="0 0 20 20">
                                    <polyline points="4 11 8 15 16 6"></polyline>
                                </svg>
                            </div>
                        </label>
                    </span>
                        </div>

                        <div class="s-u-passenger-item  s-u-passenger-item-change form-group">
                            <select name="passengerGender">
                                <option value="" disabled="disabled" selected="selected">##Sex##</option>
                                <option value="Male">##Male##</option>
                                <option value="Female">##Female##</option>
                            </select>
                        </div>

                        <div class="s-u-passenger-item  s-u-passenger-item-change form-group">
                            <input type="text" name="passengerName" value="" placeholder="##Name##">
                        </div>

                        <div class=" s-u-passenger-item  s-u-passenger-item-change form-group">
                            <input type="text" name="passengerFamily" value="" placeholder="##Family## ">
                        </div>

                        <div class=" s-u-passenger-item  s-u-passenger-item-change form-group justIranian">
                            <input class="{$classNameBirthdayCalendar}" type="text" name="passengerBirthday" value=""
                                   readonly="readonly" placeholder=" ##Happybirthday##">
                        </div>

                        <div class="s-u-passenger-item  s-u-passenger-item-change form-group justIranian">
                            <input type="text" name="passengerNationalCode" value=""
                                   placeholder="##Nationalnumber## ">
                        </div>

                        <div class="s-u-passenger-item  s-u-passenger-item-change form-group">
                            <input type="text" name="passengerNameEn" value="" placeholder=" ##Nameenglish##">
                        </div>

                        <div class=" s-u-passenger-item  s-u-passenger-item-change form-group">
                            <input type="text" name="passengerFamilyEn" value="" placeholder="##Familyenglish##  ">
                        </div>

                        <div class=" s-u-passenger-item  s-u-passenger-item-change form-group no-star noneIranian">
                            <input class="gregorianBirthdayCalendar" type="text" name="passengerBirthdayEn" value=""
                                   readonly="readonly" placeholder="##miladihappybirthday##">
                        </div>

                        <div class="s-u-passenger-item  s-u-passenger-item-change select-meliat form-group no-star noneIranian">
                            <select name="passengerPassportCountry" class="select2">
                                <option value="" disabled="disabled" selected>##Countryissuingpassport##</option>
                                {foreach $objFunctions->CountryCodes() as $Country}
                                    <option value="{$Country['code']}">{$Country['titleFa']}</option>
                                {/foreach}
                            </select>
                        </div>

                        <div class="s-u-passenger-item  s-u-passenger-item-change form-group no-star">
                            <input type="text" name="passengerPassportNumber" value=""
                                   placeholder="##Numpassport##">
                        </div>

                        <div class="s-u-passenger-item  s-u-passenger-item-change form-group no-star">
                            <input class="gregorianFromTodayCalendar" type="text" name="passengerPassportExpire"
                                   value="" readonly="readonly" placeholder="##Expirationdatepassport##">
                        </div>

                        <div class="userProfileInfo-btn userProfileInfo-btn-change">
                            <input class="s-u-select-flight-change site-secondary-text-color site-main-button-flat-color"
                                   type="submit" value=" ##SubmitInformation##">
                        </div>

                    </div>

                    <div class="userProfileInfo-messge passengerAddMessage">
                        <div class="userProfileInfo-messge-Success {$objUser->classMessage}">
                            {$addPassengerResult.result_message}
                        </div>

                        <div class="userProfileInfo-messge-Error {$objUser->classError}">
                            {$addPassengerResult.result_message}
                        </div>
                    </div>
                </form>
            </div>
        </div>



        <div class="main-Content-bottom Dash-ContentL-B">
            <div class="main-Content-bottom-table Dash-ContentL-B-Table">
                <div class="main-Content-bottom-table-Title Dash-ContentL-B-Title site-bg-main-color">
                    <i class="icon-table"></i>
                    <h3> ##Listyourcustomer## </h3>
                </div>

                <div class="content-table">
                    <table id="userProfile" class="display" cellspacing="0" width="100%">

                    <thead>
                    <tr>
                        <th>##Row##</th>
                        <th>##Namepersion##</th>
                        <th>##Nameenglish##</th>
                        <th>##Familypersion##</th>
                        <th>##Familyenglish##</th>
                        <th>##Sex##</th>
                        <th>##Happybirthday##</th>
                        <th>##Nationalnumber##</th>
                        <th>##Edit##</th>
                    </tr>
                    </thead>

                    <tbody>
                    {assign var="number" value="1"}
                    {foreach key=key item=item from=$objDetail->passengers}
                        <tr>
                            <td data-content="##Row##">{$number++}</td>
                            <td data-content="##Namepersion##">{$item['name']}</td>
                            <td data-content="##Nameenglish##">{$item['name_en']}</td>
                            <td data-content="##Familypersion##">{$item['family']}</td>
                            <td data-content="##Familyenglish##">{$item['family_en']}</td>
                            {assign var="type" value="0"}
                            {if $item['birthday'] eq '0000-00-00'}
                                {$type = $objDetail->type_user($objFunctions->ConvertToMiladi($item['birthday_fa']))}
                            {else}
                                {$type = $objDetail->type_user($item['birthday'])}
                            {/if}

                            <td data-content="##Sex##">{if $item['gender'] eq 'Male'}
                                    {if $type eq 'Adt'}
                                        ##Sir##
                                    {elseif $type eq 'Chd'}
                                        ##Boy##
                                    {elseif $type eq 'Inf'}
                                        ##Baby##
                                    {/if}
                                {elseif $item['gender'] eq 'Female'}
                                    {if $type eq 'Adt'}
                                        ##Lady##
                                    {elseif $type eq 'Chd'}
                                        ##Girl##
                                    {elseif $type eq 'Inf'}
                                        ##Baby##
                                    {/if}
                                {/if}
                            </td>
                            <td data-content="##Happybirthday##">{$item['birthday_fa']}</td>
                            <td data-content="##Nationalnumber##">{if $item['NationalCode'] eq '0000000000'} {$item['passportNumber']}{else}{$item['NationalCode']}{/if}</td>
                            <td data-content="##Edit##">
                                <a onclick="modalListForEditUser({$item['id']})">
                                    <span class="edit-user fa fa-edit"></span>
                                </a>
                            </td>
                        </tr>

                    {/foreach}
                    <tbody>


                </table>
                </div>
            </div>
        </div>

    </div>
    </div>
    <div id="ModalPublic" class="modal w-100">
        <div class="modal-content w-100 container p-0" id="ModalPublicContent">
            <div class="modal-header site-bg-main-color">
                <span class="close" onclick="modalClose('{$item.request_number}')">&times;</span>
                <h6 class="modal-h"></h6>
            </div>

            <div class="modal-body">

            </div>
        </div>
    </div>
{literal}
    <script type="text/javascript">
        $(document).ready(function () {
            $('#userProfile').DataTable();


            $('body').on('click' ,'.submitPassengerUpdateForm' , function () {
                var thiss=$(this);
                thiss.removeClass('submitPassengerUpdateForm').addClass('disabled');
                console.log('runing');
                var form = $("#updatePassengerForm");
                var url = form.attr("action");
                var formData = $(form).serializeArray();
                var formArray = {};
                $.each(formData, function() {
                    formArray[this.name] = this.value;
                });

                $.post(amadeusPath + 'user_ajax.php',
                    {
                        flag: 'PassengersUpdateModal',
                        data : formArray
                    },
                    function (data) {
                    data = jQuery.parseJSON(data);
                    console.log(data.result_status);
                        if (data.result_status == 'success') {

                            $.alert({
                                title: useXmltag("UpdateProfile"),
                                icon: 'fa fa-refresh',
                                content: data.result_message,
                                rtl: true,
                                type: 'green',
                            });

                        } else {

                            $.alert({
                                title: useXmltag("UpdateProfile"),
                                icon: 'fa fa-refresh',
                                content: data.result_message,
                                rtl: true,
                                type: 'red',
                            });

                        }
                    });
                thiss.addClass('submitPassengerUpdateForm').removeClass('disabled');
            });

        });

        function modalListForEditUser(passenger_id) {


            $.post(libraryPath + 'ModalCreatorForPassenger.php',
                {
                    Method: 'ModalShow',
                    passenger_id: passenger_id
                },
                function (data) {
                    $('#ModalPublicContent').html(data);
                });

            $('.loaderPublicForHotel').fadeOut(500);
            $("#ModalPublic").fadeIn(700);
            // $('#ModalPublicContent').html();


        }

        function SendDataForBank(link, inputs) {

            var Price = $('#Price').val();
            var TypeCharge = $('#TypeCharge').val();
            var bank = $("input[name='bank']").is(':checked');

            if (Price == "" || bank == false) {
                $.alert({
                    title: useXmltag("ChargeAccount"),
                    icon: 'fa fa-cart-plus',
                    content: useXmltag("MessageEmpty"),
                    rtl: true,
                    type: 'red'
                });
                return false;
            }
            var form = document.createElement("form");
            form.setAttribute("method", "POST");
            form.setAttribute("action", link);

            $.each(inputs, function (i, item) {
                if (typeof item === 'object' && item !== null) {
                    $.each(item, function (j, item2) {
                        var hiddenField = document.createElement("input");
                        hiddenField.setAttribute("type", "hidden");
                        hiddenField.setAttribute("name", i + '[' + j + ']');
                        hiddenField.setAttribute("value", item2);
                        form.appendChild(hiddenField);

                    });
                } else {
                    var hiddenField = document.createElement("input");
                    hiddenField.setAttribute("type", "hidden");
                    hiddenField.setAttribute("name", i);
                    hiddenField.setAttribute("value", item);
                    form.appendChild(hiddenField);

                }
            });

            var bank = document.createElement("input");
            bank.setAttribute("type", "hidden");
            bank.setAttribute("name", "bankType");
            var radioValue = $("input[name='bank']:checked").val();
            bank.setAttribute("value", radioValue);
            form.appendChild(bank);

            var hiddenField2 = document.createElement("input");
            hiddenField2.setAttribute("type", "hidden");
            hiddenField2.setAttribute("name",'price');
            hiddenField2.setAttribute("value", Price);

            form.appendChild(hiddenField2);

            if(TypeCharge=='increaseCreditAgency')
                {
                    var factorNumber = 'AC' + (Math.floor(Math.random() * 888888) + 100000).toString();
                }else{
                    var factorNumber = 'UC' +(Math.floor(Math.random() * 888888) + 100000).toString();
                    }



            var hiddenField2 = document.createElement("input");
            hiddenField2.setAttribute("type", "hidden");
            hiddenField2.setAttribute("name",'factorNumber');
            hiddenField2.setAttribute("value", factorNumber);

            form.appendChild(hiddenField2);

            document.body.appendChild(form);
//            console.log(form);
            form.submit();
            document.body.removeChild(form);
        }

    </script>

{/literal}




{else}
    {$objUser->redirectOut()}
{/if}
