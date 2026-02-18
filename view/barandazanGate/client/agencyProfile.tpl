{load_presentation_object filename="agency" assign="objAgency"}
{load_presentation_object filename="banks" assign="objBanks"}
{assign var="bank_list" value=$objBanks->getBankList()}
{if $objSession->IsLogin() and $objSession->getTypeUser() eq 'agency'}

    {assign var="profile" value=$objAgency->getAgency($objSession->getAgencyId())} {*گرفتن اطلاعات کاربر*}
    {assign var="agency_id" value=$objSession->getAgencyId()}

    {if $profile.hasSite eq '1'}
        {$agency_id = $smarty.const.SUB_AGENCY_ID}
    {/if}
    {assign var="attachments" value=$objAgency->getAgencyAttachments($agency_id)}

    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`agencyMenu.tpl"}
    {assign var="allCities" value=$objFunctions->cityIataList()}
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
                <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                    <i class="zmdi zmdi-account-box-mail zmdi-hc-fw mart10"></i> ##InformationprofileAgency##
                </span>
                <div class="panel-default-change border-0">
                    <form class=" s-u-result-item-change" data-toggle="validator" id="UpdateAgency" method="post">
                        <input type="hidden" value="update_agency" name="flag">
                        <input type="hidden" id="agencyId" value="{$agency_id}" name="agencyId">
                        <input type="hidden" id="edit_id" value="{$agency_id}" name="edit_id">
                        <div class="w-100">
                            <div class="parent-grids w-100">
                                <div class="s-u-passenger-item s-u-passenger-item-change">
                                    <label for="name_fa" class="flr">##Nameagency##:</label>
                                    <input type="text" name="nameFa" id="nameFa" value="{$profile['name_fa']}"
                                           placeholder="##Name##">
                                </div>
                                <div class="s-u-passenger-item s-u-passenger-item-change no-star">
                                    <label for="name_en" class="flr"> ##NameagencyEn##:</label>
                                    <input type="text" name="nameEn" id="nameEn" value="{$profile['name_en']}"
                                           placeholder="##Family## ">
                                </div>
                                <div class="s-u-passenger-item s-u-passenger-item-change">
                                    <label for="phone" class="flr"> ##Phone##:</label>
                                    <input type="text" name="phone" id="phone" value="{$profile['phone']}"
                                           placeholder=" ##phone##" class="">
                                </div>
                                <div class="s-u-passenger-item s-u-passenger-item-change">
                                    <label for="mobile" class="flr">##Phonenumber##:</label>
                                    <input type="text" name="mobile" id="mobile" value="{$profile['mobile']}"
                                           placeholder="##Phonenumber##">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="s-u-passenger-item  s-u-passenger-item-change form-group no-star">
                                    <label for="manager" class="flr"> ##managerName##:</label>
                                    <input type="text" name="manager" id="manager" value="{$profile['manager']}"
                                           placeholder=" ##managerName##" class="">
                                </div>


                                <div class="s-u-passenger-item  s-u-passenger-item-change form-group">
                                    <label for="accountant" class="flr">##accountantName##:</label>
                                    <input type="text" name="accountant" id="accountant"
                                           value="{$profile['accountant']}"
                                           placeholder="##accountantName##">
                                </div>




{*                                <div class="s-u-passenger-item  s-u-passenger-item-change form-group no-star">*}
{*                                    <label for="fax" class="flr"> ##Fax##:</label>*}
{*                                    <input type="text" name="fax" id="fax" value="{$profile['fax']}"*}
{*                                           placeholder="##fax##">*}
{*                                </div>*}

                                <div class="s-u-passenger-item  s-u-passenger-item-change form-group no-star">
                                    <label for="postal_code" class="flr"> ##Postalcode##:</label>
                                    <input type="text" name="postal_code" id="postal_code" value="{$profile['postal_code']}"
                                           placeholder="##postal_code##">
                                </div>

                                <div class="s-u-passenger-item  s-u-passenger-item-change form-group">
                                    <label for="email" class="flr"> ##Email##:</label>
                                    <input type="text" name="email" id="email" value="{$profile['email']}"
                                           placeholder="##Email##"
                                           disabled="disabled">
                                </div>






                                <div class="s-u-passenger-item  s-u-passenger-item-change form-group no-star">
                                    <label for="birthday" class="flr"> ##Happybirthday##:</label>
                                    <input type="text" autocomplete="off" class="shamsiBirthdayCalendar" name="birthday" id="birthday" value="{$profile['birthday']}"
                                           placeholder="##Happybirthday##">
                                </div>
{*                                <div class="s-u-passenger-item  s-u-passenger-item-change form-group no-star">*}
{*                                    <label for="staff_number" class="flr"> ##StaffNumber##:</label>*}
{*                                    <input type="text" name="staff_number" id="staff_number" value="{$profile['staff_number']}"*}
{*                                           placeholder="##StaffNumber##">*}
{*                                </div>*}

                                <div class="s-u-passenger-item  s-u-passenger-item-change form-group no-star">
                                    <label for="economic_code" class="flr"> ##EconomicCode##:</label>
                                    <input type="text" name="economic_code" id="economic_code" value="{$profile['economic_code']}"
                                           placeholder="##EconomicCode##">
                                </div>
{*                                <div class="s-u-passenger-item  s-u-passenger-item-change form-group no-star">*}
{*                                    <label for="agency_national_code" class="flr"> ##AgencyNationalID##:</label>*}
{*                                    <input type="text" name="agency_national_code" id="agency_national_code" value="{$profile['agency_national_code']}"*}
{*                                           placeholder="##AgencyNationalID##">*}
{*                                </div>*}





{*                                <div class="s-u-passenger-item  s-u-passenger-item-change form-group">*}
{*                                    <label for="mobile" class="flr"> ##Setupdate##:</label>*}
{*                                    <input type="text" value="{$objFunctions->DateJalali($profile['register_date'])}"*}
{*                                           disabled="disabled">*}
{*                                </div>*}

{*                                <div class="s-u-passenger-item  s-u-passenger-item-change form-group">*}
{*                                    <label for="mobile" class="flr"> ##Setupdate##:</label>*}
{*                                    <input type="text" value="{$profile['seat_charter_code']}"*}
{*                                           disabled="disabled">*}
{*                                </div>*}
                            </div>
                        </div>
                        <div class="w-100 align-items-end mt-4">
                            <div class="col-lg-12 p-0">
{*                            <div class="s-u-passenger-item no-margin s-u-passenger-item-change form-group">*}
{*                                <label for="last_modify" class="flr">##Lastchangeupdate## :</label>*}
{*                                <input type="text" value="{$objFunctions->DateJalali($profile['last_modify'])}"*}
{*                                       disabled="disabled">*}
{*                            </div>*}
                            <div class="s-u-passenger-item no-margin s-u-passenger-item-change form-group ">
                                <label for="logo" class="flr">##Loadingagencylogo## :</label>
                                <div class="field">
                                    <i class="btn-upload-file fa fa-upload"></i>
                                    <input type="text" name="logoText" value="" size="40" class="file_input_replacement"
                                           placeholder="##Loadingagencylogo##">
                                    <input type="file" id="logo" name="logo" class="file_input_with_replacement">
                                </div>
                            </div>
                            <div class="s-u-passenger-item no-margin s-u-passenger-item-change form-group ">
                                <label for="aboutMePic" class="flr">##Image## ##AboutUs## :</label>
                                <div class="field">
                                    <i class="btn-upload-file fa fa-upload"></i>
                                    <input type="text" name="AboutMePicText" value="" size="40" class="file_input_replacement" placeholder="##Image## ##AboutUs##">
                                    <input type="file" id="aboutMePic" name="aboutMePic" class="file_input_with_replacement">
                                </div>
                            </div>
                            <div class="s-u-passenger-item no-margin s-u-passenger-item-change form-group">
                                <label for="city_iata" class="flr">##City## :</label>
                                <select name="city_iata" id="city_iata" class="form-control select2">
                                    <option value="">شهر مورد نظر را انتخاب نمائید</option>
                                    {foreach $allCities as $city}
                                        <option value="{$city.city_iata}" {if $profile.city_iata eq $city.city_iata}selected="selected"{/if}>{$city.city_name}</option>
                                    {/foreach}
                                </select>
                            </div>

                        </div>
                        </div>
                        <div class="w-100">
                            <div class="">
                                <div class="s-u-passenger-item  s-u-passenger-item-textarea s-u-passenger-item-change form-group no-star">
                                    <label for="addressFa" class="flr">##Address##:</label>
                                    <textarea class="text_area_address" type="text" name="addressFa"
                                              id="addressFa">{$profile['address_fa']}</textarea>
                                </div>
                                <div class="s-u-passenger-item  s-u-passenger-item-textarea s-u-passenger-item-change form-group no-star">
                                <label for="address_en" class="flr">##EnAddress##:</label>
                                <textarea class="text_area_address" type="text" name="address_en"
                                          id="address_en">{$profile['address_en']}</textarea>

                            </div>
                            </div>
                        </div>




                        <div class="w-100 mt-4">

                            <hr>

                        </div>
                        <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                         <i class="zmdi zmdi-account-box-mail zmdi-hc-fw mart10"></i> ##Bankaccountdetail##
                         </span>
                        {assign var="bank_data" value=$profile['bank_data']|json_decode:true}





                        {if empty($bank_data[0])}
                            {assign var="bank_data" value=[['bank_list' => '', 'name' => '', 'account_number' => '', 'card_number' => '', 'shaba' => '']]}
                        {/if}

                        {foreach $bank_data as $key=>$item}

                            <div class="w-100">
                                <div class="s-u-passenger-item  s-u-passenger-item-change form-group no-star">
                                    <label for="bank_data[{$key}][bank_list]" class="control-label">نام بانک</label>
                                    <select name="bank_data[{$key}][bank_list]" id="bank_data[{$key}][bank_list]" aria-required="true"
                                            class="form-control select2">
                                        <option value="">انتخاب کنید ...</option>
                                        {foreach $bank_list as $bank}
                                            <option {if $item['bank_list'] == $bank.id} selected {/if} value="{$bank.id}">{$bank.title}</option>
                                        {/foreach}

                                    </select>
                                </div>
                        </div>
                            <div class="w-100">
                                <div class="s-u-passenger-item  s-u-passenger-item-change form-group no-star">
                                    <label for="bank_data[{$key}][name]" class="control-label">
                                        نام صاحب حساب
                                    </label>
                                    <input type="text" class=""
                                           name="bank_data[{$key}][name]"
                                           id="bank_data[{$key}][name]"
                                           value="{$item['name']}"/>
                                </div>
                                <div class="s-u-passenger-item  s-u-passenger-item-change form-group no-star">
                                    <label for="bank_data[{$key}][account_number]" class="control-label">
                                        شماره حساب اول
                                    </label>
                                    <input type="text" class="dir_l "
                                           name="bank_data[{$key}][account_number]"
                                           id="bank_data[{$key}][account_number]"
                                           value="{$item['account_number']}"/>
                                </div>
                                <div class="s-u-passenger-item  s-u-passenger-item-change form-group no-star">
                                    <label for="bank_data[{$key}][card_number]" class="control-label">
                                        شماره کارت اول
                                    </label>
                                    <input type="text" class="dir_l input-mask "
                                           name="bank_data[{$key}][card_number]"
                                           id="bank_data[{$key}][card_number]"
                                           placeholder="9999-9999-9999-9999"
                                           data-inputmask="'mask':'9999-9999-9999-9999'"
                                           value="{$item['card_number']}"/>
                                </div>
                                <div class="s-u-passenger-item  s-u-passenger-item-change form-group no-star">
                                    <label for="bank_data[{$key}][shaba]" class="control-label">
                                        شماره شبا اول
                                    </label>
                                    <input type="text" class="dir_l input-mask "
                                           name="bank_data[{$key}][shaba]"
                                           id="bank_data[{$key}][shaba]"
                                           data-inputmask="'mask':'IR99-9999-9999-9999-9999-9999-99'"
                                           value="{$item['shaba']}"/>
                                </div>
                            </div>

                        {/foreach}




{*                        <div class="row">*}
{*                            <div class="form-group col-sm-6 col-md-3">*}
{*                                <label for="colorMainBg" class="control-label">رنگ اصلی</label>*}
{*                                <input type="text" class="form-control as-colorpicker" name="colorMainBg" id="colorMainBg" value="{$profile.colorMainBg}">*}
{*                            </div>*}
{*                            <div class="form-group col-sm-6 col-md-3">*}
{*                                <label for="colorMainBgHover" class="control-label">رنگ اصلی دوم</label>*}
{*                                <input type="text" class="form-control as-colorpicker" name="colorMainBgHover" id="colorMainBgHover" value="{$profile.colorMainBgHover}">*}
{*                            </div>*}
{*                            <div class="form-group col-sm-6 col-md-3">*}
{*                                <label for="colorMainText" class="control-label">رنگ متن</label>*}
{*                                <input type="text" class="form-control as-colorpicker" name="colorMainText" id="colorMainText" value="{$profile.colorMainText}">*}
{*                            </div>*}
{*                            <div class="form-group col-sm-6 col-md-3">*}
{*                                <label for="colorMainTextHover" class="control-label">رنگ متن انتخاب شده</label>*}
{*                                <input type="text" class="form-control as-colorpicker" name="colorMainTextHover" id="colorMainTextHover" value="{$profile.colorMainTextHover}">*}
{*                            </div>*}
{*                        </div>*}
{*                        <div class="row">*}
{*                            <div class="col-sm-12 white-box">*}
{*                                <h3 class="box-title">فایلهای آپلود شده</h3>*}
{*                                <div class="row attachments">*}
{*                                    {if $profile['logo'] neq ''}*}
{*                                        <div class="col-12 col-sm-6 col-md-3 col-lg-2 preview-logo">*}
{*                                            <figure class="figure">*}
{*                                                <img class="figure-img img-fluid rounded" title="Logo"*}
{*                                                     src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/agencyPartner/{$smarty.const.CLIENT_ID}/logo/{$profile['logo']}"/>*}
{*                                                <figcaption class="figure-caption text-xs-right">##AgencyLogo##</figcaption>*}
{*                                            </figure>*}
{*                                        </div>*}
{*                                    {/if}*}

{*                                    {if $profile['aboutMePic'] neq ''}*}
{*                                        <div class="col-12 col-sm-6 col-md-3 col-lg-2 preview-license">*}
{*                                            <figure class="figure">*}
{*                                                <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/agencyPartner/{$smarty.const.CLIENT_ID}/aboutMePic/{$profile['aboutMePic']}" class="figure-img img-fluid rounded" alt="">*}
{*                                                <figcaption class="figure-caption text-xs-right">##Image## ##AboutUs##</figcaption>*}
{*                                            </figure>*}
{*                                        </div>*}
{*                                    {/if}*}

{*                                    {if count($attachments) gt 0}*}
{*                                        {foreach $attachments as $attachment}*}
{*                                            {assign var='ext' value=$objFunctions->getExtensionImage($attachment.file_path)}*}
{*                                            <div class="col-12 col-sm-6 col-md-3 col-lg-2 preview-attachment attachment-{$attachment.id}">*}
{*                                                {if in_array($ext,['jpg','gif','png','tif'])}*}
{*                                                    {assign var='file_url' value="`$smarty.const.ROOT_ADDRESS_WITHOUT_LANG`/pic/agencyPartner/`$smarty.const.CLIENT_ID`/attachments/`$attachment.file_path`" }*}
{*                                                    {assign var='img_url' value="`$smarty.const.ROOT_ADDRESS_WITHOUT_LANG`/pic/agencyPartner/`$smarty.const.CLIENT_ID`/attachments/`$attachment.file_path`" }*}

{*                                                {else}*}
{*                                                    {assign var='file_url' value="`$smarty.const.ROOT_ADDRESS_WITHOUT_LANG`/pic/agencyPartner/`$smarty.const.CLIENT_ID`/attachments/`$attachment.file_path`" }*}
{*                                                    {assign var='img_url' value="`$smarty.const.ROOT_ADDRESS_WITHOUT_LANG`/pic/ext-icons/`$ext`.png" }*}
{*                                                {/if}*}
{*                                                <figure class="figure">*}
{*                                                    <a href="{$file_url}">*}
{*                                                        <img src="{$img_url}" class="figure-img img-fluid rounded" alt="{$attachment.file_path}">*}
{*                                                    </a>*}
{*                                                    <figcaption class="figure-caption text-xs-right">*}
{*                                                        <a target="_blank" href="{$file_url}">*}
{*                                                            <small>{$objFunctions->getNameImage($attachment.file_path)}</small>*}
{*                                                        </a>*}
{*                                                        <button type="button" class="remove-attachment btn btn-circle btn-sm btn-danger"*}
{*                                                                data-id="{$attachment.id}">&times;*}
{*                                                        </button>*}
{*                                                    </figcaption>*}
{*                                                </figure>*}
{*                                            </div>*}
{*                                        {/foreach}*}
{*                                    {/if}*}
{*                                </div>*}
{*                            </div>*}
{*                        </div>*}
{*                        <div class="row">*}
{*                            <div class="col-sm-12">*}
{*                                <div class="white-box col-md-12">*}
{*                                    <h3 class="box-title m-b-0">##AgencyProfilePictureTitle##</h3>*}
{*                                    <p class="text-muted m-b-30 textPriceChange"></p>*}
{*                                    <div class="col-md-12">*}
{*                                        <div id="actions" class="row">*}
{*                                            <div class="col-lg-7">*}
{*                                                <!-- The fileinput-button span is used to style the file input field as button -->*}
{*                                                <span class="btn btn-success fileinput-button dz-clickable"><i*}
{*                                                            class="glyphicon glyphicon-plus"></i><span>Add files...</span></span>*}
{*                                                <button type="submit" class="btn btn-primary start d-none">*}
{*                                                    <i class="glyphicon glyphicon-upload"></i>*}
{*                                                    <span>Start upload</span>*}
{*                                                </button>*}
{*                                                <button type="reset" class="btn btn-warning cancel d-none">*}
{*                                                    <i class="glyphicon glyphicon-ban-circle"></i>*}
{*                                                    <span>Cancel upload</span>*}
{*                                                </button>*}
{*                                            </div>*}

{*                                            <div class="col-lg-5">*}
{*                                                <!-- The global file processing state -->*}
{*                                                <span class="fileupload-process">*}
{*                                                    <div id="total-progress" class="progress active" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">*}
{*                                                      <div class="progress-bar progress-bar-striped progress-bar-success" role="progressbar" style="width: 0%"*}
{*                                                           data-dz-uploadprogress=""></div>*}
{*                                                    </div>*}
{*                                                  </span>*}
{*                                            </div>*}
{*                                        </div>*}
{*                                        <div class="table table-striped files" id="attachments">*}
{*                                            <div id="template" class="file-row dz-image-preview">*}
{*                                                <!-- This is used as the file preview template -->*}
{*                                                <div>*}
{*                                                    <span class="preview"><img data-dz-thumbnail></span>*}
{*                                                </div>*}
{*                                                <div>*}
{*                                                    <p class="name" data-dz-name></p>*}
{*                                                    <strong class="error text-danger" data-dz-errormessage></strong>*}
{*                                                </div>*}
{*                                                <div>*}
{*                                                    <p class="size" data-dz-size></p>*}
{*                                                    <div class="progress progress-striped active" role="progressbar"*}
{*                                                         aria-valuemin="0"*}
{*                                                         aria-valuemax="100" aria-valuenow="0">*}
{*                                                        <div class="progress-bar progress-bar-success" style="width:0%;"*}
{*                                                             data-dz-uploadprogress></div>*}
{*                                                    </div>*}
{*                                                </div>*}
{*                                                <div class="btn-actions">*}
{*                                                    <div class="btn-group" role="group" aria-label="Basic example">*}
{*                                                        <button type="button" class="btn btn-primary start"><i class="fa fa-upload"></i> آپلود*}
{*                                                        </button>*}
{*                                                        <button data-dz-remove type="button" class="btn btn-warning cancel"><i class="fa fa-ban"></i>*}
{*                                                            لغو*}
{*                                                        </button>*}
{*                                                    </div>*}

{*                                                </div>*}
{*                                            </div>*}
{*                                        </div>*}

{*                                    </div>*}


{*                                </div>*}

{*                            </div>*}
{*                        </div>*}


{*                        <div class='row'>*}
{*                            {if count($attachments) gt 0}*}
{*                                <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>*}
{*                                    <h4 class='align-items-center d-flex flex-wrap font-bold gap-10 m-0 px-4 py-3'>*}
{*                                        ##DisplayFiles##*}
{*                                    </h4>*}
{*                                </div>*}
{*                                <hr class='m-0 mb-4 w-100'>*}
{*                                <div class='drop_zone-new-parent-gallery-dakheli'>*}
{*                                    {foreach $attachments as $attachment}*}
{*                                        {assign var='ext' value=$objFunctions->getExtensionImage($attachment.file_path)}*}
{*                                        <div class="drop_zone-new-dakheli ">*}

{*                                            {if in_array($ext,['jpg','gif','png','tif', 'jpeg'])}*}
{*                                                {assign var='file_url' value="`$smarty.const.ROOT_ADDRESS_WITHOUT_LANG`/pic/agencyPartner/`$smarty.const.CLIENT_ID`/attachments/`$attachment.file_path`" }*}
{*                                                {assign var='img_url' value="`$smarty.const.ROOT_ADDRESS_WITHOUT_LANG`/pic/agencyPartner/`$smarty.const.CLIENT_ID`/attachments/`$attachment.file_path`" }*}

{*                                            {else}*}
{*                                                {assign var='file_url' value="`$smarty.const.ROOT_ADDRESS_WITHOUT_LANG`/pic/agencyPartner/`$smarty.const.CLIENT_ID`/attachments/`$attachment.file_path`" }*}
{*                                                {assign var='img_url' value="`$smarty.const.ROOT_ADDRESS_WITHOUT_LANG`/pic/ext-icons/`$ext`.png" }*}
{*                                            {/if}*}
{*                                            <div class='drop_zone-new-item-gallery-link-dakheli'  >*}
{*                                                <a href='{$file_url}'>*}
{*                                                <img class="border d-flex imageThumb rounded-xl w-100"*}
{*                                                     src='{$img_url}'*}
{*                                                     title="{$attachment.file_path}"/>*}
{*                                                </a>*}
{*                                                <div class='drop_zone-new-parent-btn-dakheli'>*}
{*                                                    <div class=''>*}
{*                                                        <button class='dropzone-btn-trash-dakheli remove text-danger'*}
{*                                                                type='button'*}
{*                                                                onclick='SubmitRemoveAgencyFileGallery("{$attachment['id']}",$(this))'*}
{*                                                                data-index="0" >*}
{*                                                            ##Delete##*}
{*                                                        </button>*}
{*                                                    </div>*}
{*                                                    <div class=''>*}
{*                                                        <small class='dropzone-small-dakheli'>{$objFunctions->getNameImage($attachment.file_path)}</small>*}
{*                                                    </div>*}
{*                                                </div>*}
{*                                            </div>*}
{*                                        </div>*}
{*                                    {/foreach}*}
{*                                </div>*}
{*                            {/if}*}


{*                            <div class="drop_zone-new-parent-label-dakheli">*}
{*                                <label for='gallery_files'*}
{*                                       id="drop_zone"*}
{*                                       class='d-flex flex-wrap justify-content-center align-items-center  p-5 w-100'*}
{*                                       ondrop="dropHandler(event,false , false);"*}
{*                                       ondragover="dragOverHandler(event);">*}
{*                                    <p>##DropFiles##</p>*}
{*                                </label>*}
{*                            </div>*}


{*                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">*}
{*                                <div class="d-flex flex-wrap form-group gap-5 w-100">*}
{*                                    <label for="gallery_files" class="control-label d-none">##Selectfile##</label>*}
{*                                    <input onchange="dropHandler(event,false , false)" type='file' accept="image/*,pdf"*}
{*                                           class=' d-none'*}
{*                                           multiple name='gallery_files[]' id='gallery_files'>*}

{*                                    <div id='preview-gallery' class='drop_zone-new-parent-gallery'></div>*}
{*                                </div>*}
{*                            </div>*}



{*                        </div>*}



                        <div class="userProfileInfo-btn userProfileInfo-btn-change">
                            <input class="s-u-select-flight-change site-secondary-text-color site-main-button-flat-color"
                                   type="submit" value="##ChangeInformation## ">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {*end charge user*}
    </div>
    <div id="ModalPublic" class="modal">
        <div class="modal-content" id="ModalPublicContent">
            <div class="modal-header site-bg-main-color">
                <span class="close" onclick="modalClose('{$item.request_number}')">&times;</span>
                <h6 class="modal-h"></h6>
            </div>

            <div class="modal-body">

            </div>
        </div>
    </div>
{literal}

    <!-- Color picker plugins css -->
    <link href="assets/plugins/jquery-colorpicker/css/asColorPicker.css" rel="stylesheet">
    <style>
        .remove-attachment {
            position: absolute;
            left: 1rem;
            padding: 0 0.3rem;
        }

        .field {
            position: relative;
            overflow: hidden;
            display: block;
            width: 100%;
        }


        .asColorPicker-wrap{
            display: flex;

        }
        .asColorPicker-wrap .form-control{
            -webkit-border-radius: 0 4px 4px 0;
            -moz-border-radius: 0 4px 4px 0;
            border-radius: 0 4px 4px 0;
        }
        .asColorPicker-wrap .form-control:focus{
            -webkit-box-shadow: none;
            -moz-box-shadow: none;
            box-shadow: none;
            outline:none;
            border-color: #000;
        }
        .asColorPicker-trigger{
            height:33.5px;
            width: 33.5px;
            border:none;
            overflow: hidden;
            -webkit-border-radius: 4px 0 0 4px;
            -moz-border-radius: 4px 0 0 4px;
            border-radius: 4px 0 0 4px;
        }

        .asColorPicker-wrap:hover .asColorPicker-clear{
            display: none;
        }
        .asColorPicker-dropdown{
            max-width: 300px;
        }
    </style>
    <script src="assets/js/dropzone.js"></script>
    <script type="text/javascript" src="assets/plugins/jquery-colorpicker/libs/jquery-asColor.js"></script>
    <script type="text/javascript" src="assets/plugins/jquery-colorpicker/libs/jquery-asGradient.js"></script>
    <script type="text/javascript" src="assets/plugins/jquery-colorpicker/dist/jquery-asColorPicker.min.js"></script>
    <script>
        $(".as-colorpicker").asColorPicker({
            mode: 'gradient',
//            hideInput: true
        });

    </script>
{/literal}
{literal}
    <script type="text/javascript">
        $(document).ready(function () {
            $('#userProfile').DataTable();
            $('body').on('click', '.submitPassengerUpdateForm', function () {
                var thiss = $(this);
                thiss.removeClass('submitPassengerUpdateForm').addClass('disabled');
                console.log('runing');
                var form = $("#updatePassengerForm");
                var url = form.attr("action");
                var formData = $(form).serializeArray();
                var formArray = {};
                $.each(formData, function () {
                    formArray[this.name] = this.value;
                });

                $.post(amadeusPath + 'user_ajax.php',
                    {
                        flag: 'PassengersUpdateModal',
                        data: formArray
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
        $(function () {
            $('.file_input_replacement').click(function () {
                //This will make the element with class file_input_replacement launch the select file dialog.
                var assocInput = $(this).siblings("input[type=file]");
                console.log(assocInput);
                assocInput.click();
            });
            $('.file_input_with_replacement').change(function () {
                //This portion can be used to trigger actions once the file was selected or changed. In this case, if the element triggering the select file dialog is an input, it fills it with the filename
                var thisInput = $(this);
                var assocInput = thisInput.siblings("input.file_input_replacement");
                if (assocInput.length > 0) {
                    var filename = (thisInput.val()).replace(/^.*[\\\/]/, '');
                    assocInput.val(filename);
                }
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
            hiddenField2.setAttribute("name", 'price');
            hiddenField2.setAttribute("value", Price);

            form.appendChild(hiddenField2);

            if (TypeCharge == 'increaseCreditAgency') {
                var factorNumber = 'AC' + (Math.floor(Math.random() * 888888) + 100000).toString();
            } else {
                var factorNumber = 'UC' + (Math.floor(Math.random() * 888888) + 100000).toString();
            }


            var hiddenField2 = document.createElement("input");
            hiddenField2.setAttribute("type", "hidden");
            hiddenField2.setAttribute("name", 'factorNumber');
            hiddenField2.setAttribute("value", factorNumber);

            form.appendChild(hiddenField2);

            document.body.appendChild(form);
//            console.log(form);
            form.submit();
            document.body.removeChild(form);
        }

    </script>
    <script type="text/javascript" src="assets/js/jquery.inputmask.min.js"></script>

    <script>
        $(document).ready(function () {

            $(".input-mask").inputmask();
        });
    </script>
    <script>
        function SubmitRemoveAgencyFileGallery(GalleryId, IsTable = false) {
        if (confirm('آیا مطمئن هستید ؟')) {
            $.ajax({
            type: 'post',
            url: amadeusPath + 'ajax',
            data: JSON.stringify({
              className: 'agency',
              method: 'RemoveSingleFile',
              GalleryId: GalleryId,
            }),
            success: function(data) {
              if (data.success) {

                console.log('IsTable', IsTable)
                if (IsTable) {
                  IsTable.parent().parent().parent().parent().remove()
                }

              } else {
                alert('error')

              }


            },
          })
        }
      }
    </script>
{/literal}
{else}
    {$objFunctions->redirectOutAgency()}
{/if}