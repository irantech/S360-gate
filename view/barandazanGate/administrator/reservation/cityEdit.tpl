{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{$objResult->SelectAllWithCondition('reservation_city_tb', 'id', $smarty.get.id)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                <li><a href="continent">قاره ها</a></li>
                <li class="active">ویرایش شهر</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <p class="text-muted m-b-30">شما با استفاده از فرم زیر میتوانید اطلاعات شهر را در سیستم ویرایش نمائید</p>

                <form id="EditCity" method="post">
                    <input type="hidden" name="flag" value="EditCity">
                    <input type="hidden" name="type_id" value="{$smarty.get.id}">
                    <input type="hidden" name="id_country" value="{$objResult->list['id_country']}">
                    {if $objResult->list['pic'] != ''}
                    <div class="form-group col-sm-12">
                        <img src="..\..\pic\{$objResult->list['pic']}" class="all landscape" alt="gallery" style="width:200px"/>
                    </div>
                    {/if}

                    <div class="form-group col-sm-6">
                        <label for="city_name" class="control-label">نام شهر</label>
                        <input type="text" class="form-control" name="city_name" value="{$objResult->list['name']}" {if $objResult->list['id'] < 300} disabled {/if}
                               id="city_name" placeholder=" نام شهر را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="city_name_en" class="control-label">نام انگلیسی شهر</label>
                        <input type="text" class="form-control" name="city_name_en" value="{$objResult->list['name_en']}" {if $objResult->list['id'] < 300} disabled {/if}
                               id="city_name_en" placeholder=" نام انگلیسی شهر را وارد نمائید">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="city_name_ar" class="control-label">نام عربی شهر</label>
                        <input type="text" class="form-control" name="city_name_ar" value="{$objResult->list['name_ar']}" {if $objResult->list['id'] < 300} disabled {/if}
                               id="city_name_ar" placeholder=" نام عربی شهر را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="city_abbreviation" class="control-label">نام اختصار</label>
                        <input type="text" class="form-control" name="city_abbreviation" value="{$objResult->list['abbreviation']}" {if $objResult->list['id'] < 300} disabled {/if}
                               id="city_abbreviation" placeholder="نام اختصار را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="pic" class="control-label">عکس شهر</label>
                        <input type="file" name="pic" id="pic" class="dropify" data-height="100"
                               data-default-file="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$objResult->list['logo']}"/>
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