{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{load_presentation_object filename="visa" assign="objvisa"}
{load_presentation_object filename="visaType" assign="objVisaType"}
{$objResult->SelectAllWithCondition('reservation_country_tb', 'id', $smarty.get.id)}
{assign var="visaTypeList" value=$objVisaType->allVisaTypeList()}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                <li><a href="continent">قاره ها</a></li>
                <li><a href="country">کشور ها</a></li>
                <li class="active"> ویرایش جزئیات ویزا {$objResult->list['name']} </li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <p class="text-muted m-b-30">شما با استفاده از فرم زیر میتوانید لیست توضیحات بیشتر در مورد ویزای خود را ویرایش نمائید</p>

                <form id="EditCountry" method="post">
                    <input type="hidden" name="flag" value="EditCountry">
                    <input type="hidden" name="type_id" value="{$smarty.get.id}">
                    <input type="hidden" name="id_continent" value="{$objResult->list['id_continent']}">

                    <div class="form-group p-0 col-sm-12">
                        <label for="comments_visa" class="col-md-12 mb-3 border-bottom control-label"> توضیحات برای ویزا {$objResult->list['name']}</label>
                        {foreach $visaTypeList as $each}
                            {assign var="visaTypeMoreDetail" value=$objvisa->getVisaTypeMoreDetail(['country_id'=>$smarty.get.id,'type_id'=>$each.id])}
                            <div class="form-group col-sm-4">
                                <label for="country_abbreviation" class="control-label">{$each.title}</label>
                                <input onchange="changeVisaTypeMoreDetail($(this))"
                                       type="text"
                                       style="direction: ltr;"
                                       data-countryId="{$smarty.get.id}"
                                       data-visaTypeId="{$each.id}"
                                       class="form-control"
                                       name="country_abbreviation"
                                       value="{$visaTypeMoreDetail['url']}"
                                       id="country_abbreviation" placeholder="https:// ... ">
                            </div>
                        {/foreach}
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                            <div class="form-group  pull-right">
                                <button type="submit" class="btn btn-primary">ارسال اطلاعات</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

</div>

<script type="text/javascript" src="assets/JsFiles/reservationBasicInformation.js"></script>