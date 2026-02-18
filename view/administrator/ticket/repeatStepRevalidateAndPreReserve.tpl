{load_presentation_object filename="repeatStepsPrivateTicket" assign="repeat"}
{assign var="TicketRevalidate" value=$repeat->RevalidateAndPreReserve($smarty.get.UniqueCode,$smarty.get.ClientID,$smarty.get.FlightID,$smarty.get.RequestNumber,$smarty.get.SourceId)}
{*<pre>{$TicketRevalidate|print_r}</pre>*}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="active">خرید بلیط</li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            {if $TicketRevalidate.message eq ''}
                <div class="white-box">
                    <h3 class="box-title m-b-0">مشاهده مسافرین و تایید اطلاعات</h3>

                    <form id="SearchTicketHistory" method="post"
                          action="{$smarty.const.rootAddress}repeatStepBookAndReserve">
                        <input type="hidden" name="RequestNumber" id="RequestNumber"
                               value="{$TicketRevalidate.RequestNumberOfReserve}">
                        {foreach key=key item=item from=$TicketRevalidate.UserInfo}
                            <div class="row">
                                <div class="form-group col-lg-3 col-md-3 col-xs-12 col-sm-12 ">
                                    <label for="date_of" class="control-label">نام</label>
                                    <input type="text" class="form-control" name="passenger_name"
                                           value="{$item.passenger_name}"
                                           id="passenger_name" disabled="disabled">
                                </div>

                                <div class="form-group col-lg-3 col-md-3 col-xs-12 col-sm-12 ">
                                    <label for="to_date" class="control-label">نام خانوادگی</label>
                                    <input type="text" class="form-control" name="passenger_family"
                                           value="{$item.passenger_family}" id="passenger_family" disabled="disabled">

                                </div>

                                <div class="form-group col-lg-3 col-md-3 col-xs-12 col-sm-12 ">
                                    <label for="to_date" class="control-label">Name</label>
                                    <input type="text" class="form-control" name="passenger_name_en"
                                           value="{$item.passenger_name_en}" id="passenger_name_en" disabled="disabled">
                                </div>

                                <div class="form-group col-lg-3 col-md-3 col-xs-12 col-sm-12 ">
                                    <label for="RequestNumber" class="control-label">Family</label>
                                    <input type="text" class="form-control" name="passenger_family_en"
                                           value="{$item.passenger_family_en}" id="passenger_family_en"
                                           disabled="disabled">

                                </div>

                                <div class="form-group col-lg-3 col-md-3 col-xs-12 col-sm-12 ">
                                    <label for="RequestNumber" class="control-label">کد ملی</label>
                                    <input type="text" class="form-control" name="familyEa"
                                           value="{$item.passenger_national_code}" id="familyEa" disabled="disabled">

                                </div>


                                <div class="form-group col-lg-3 col-md-3 col-xs-12 col-sm-12 ">
                                    <label for="passenger_birthday" class="control-label">تاریخ تولد</label>
                                    <input type="text" class="form-control" name="passenger_birthday"
                                           value="{if $item.passenger_birthday_en eq ''}{$item.passenger_birthday}{else}{$item.passenger_birthday_en}{/if}"
                                           id="passenger_birthday" disabled="disabled">

                                </div>


                                <div class="form-group col-lg-3 col-md-3 col-xs-12 col-sm-12 ">
                                    <label for="passenger_gender" class="control-label">جنسیت</label>
                                    <select name="passenger_gender" id="passenger_gender" class="form-control"
                                            disabled="disabled">

                                        <option value="Male" {if $item.passenger_gender eq 'Male' }selected{/if}>مرد
                                        </option>
                                        <option value="Female" {if $item.passenger_gender eq 'Female' }selected{/if}>
                                            زن
                                        </option>

                                    </select>
                                </div>

                                <div class="form-group col-lg-3 col-md-3 col-xs-12 col-sm-12 ">
                                    <label for="passportNumber" class="control-label">شماره پاسپورت</label>
                                    <input type="text" class="form-control" name="passportNumber"
                                           value="{$item.passportNumber}" id="passportNumber" disabled="disabled">
                                </div>

                                <div class="form-group col-lg-3 col-md-3 col-xs-12 col-sm-12 ">
                                    <label for="passportCountry" class="control-label">ملیت</label>
                                    <input type="text" class="form-control" name="passportCountry"
                                           value="{$item.passportCountry}" id="passportCountry" disabled="disabled">

                                </div>


                                <div class="form-group col-lg-3 col-md-3 col-xs-12 col-sm-12 ">
                                    <label for="passportExpire" class="control-label">تاریخ انقضا پاسپورت</label>
                                    <input type="text" class="form-control " name="passportExpire"
                                           value="{$item.passportExpire}" id="passportExpire" disabled="disabled">

                                </div>
                            </div>
                            <hr>
                        {/foreach}

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary pull-right">ارسال اطلاعات</button>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </form>
                </div>
            {else}
                <div class="white-box">
                    <h3 class="box-title m-b-0">{$TicketRevalidate.message} </h3>
                </div>
            {/if}

        </div>
    </div>


</div>


<script type="text/javascript" src="assets/JsFiles/listCancel.js"></script>