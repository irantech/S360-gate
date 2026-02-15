{load_presentation_object filename="country" assign="objCountry"}
{assign var="continents" value=$objCountry->continentsList()}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="active"> لیست قاره ها</li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>

        <!-- /.col-lg-12 -->
    </div>
    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">لیست قاره های اصلی</h3>
                <p class="text-muted m-b-30">در لیست زیر قاره ها را میتوانید مشاهده و ویرایش نمایید.</p>
                <div class="table-responsive">
                    
                        <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام فارسی</th>
                            <th>نام لاتین</th>
                            <th>کد قاره</th>
                            <th>تعداد کشور های قاره</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach $continents as $item}
                            {$number = $number + 1}
                            <tr id="del-{$item.id}">
                                <td>{$number}</td>
                                <td>{$item.titleFa} {$item.family}</td>
                                <td>{$item.titleEn}</td>
                                <td>{$item.code}</td>
                                <td>{$item.countryCounts}</td>
                                <td>
                                    <a href="#" onclick="continentValidateJs('{$item.id}'); return false;">
                                        {if $item.validate eq '1'}
                                        <input type="checkbox" class="js-switch continentValidateCheckJs continentValidateCheck_{$item.id}_Js" data-color="#99d683"
                                               data-secondary-color="#f96262" data-size="small" checked/>

                                        {else}
                                        <input type="checkbox" class="js-switch continentValidateCheckJs continentValidateCheck_{$item.id}_Js" data-color="#99d683"
                                               data-secondary-color="#f96262" data-size="small"/>
                                        {/if}
                                    </a>
                                </td>
                                <td>
                                    <a href="countryContinentList&id={$item.id}"><i
                                            class="fcbtn btn btn-outline btn-info btn-1f  tooltip-info ti-view-list-alt"
                                            data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="لیست کشور های قاره {$item.titleFa}"></i></a>
                                </td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/country.js"></script>