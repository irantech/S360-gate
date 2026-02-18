{load_presentation_object filename="country" assign="objCountry"}
{assign var="countries" value=$objCountry->countriesList()}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="">ویزا</a></li>
                <li><a href="continentList">لیست قاره ها</a></li>
                <li class="active">لیست کشور ها</li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>

             <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">لیست کشور ها </h3>
                <p class="text-muted m-b-30">در لیست زیر کشور ها را میتوانید مشاهده و ویرایش نمایید.</p>
                <div class="table-responsive">
                    
                        <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام فارسی</th>
                            <th>نام لاتین</th>
                            <th>کد کشور</th>
                            <th>نام قاره</th>
                            <th>وضعیت</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach $countries as $item}
                            {$number=$number+1}
                            <tr>
                                <td>{$number}</td>
                                <td>{$item.titleFa}</td>
                                <td>{$item.titleEn}</td>
                                <td>{$item.code}</td>
                                <td>{$item.continentTitle}</td>
                                <td>
                                    <a href="#">
                                        <div style='float: right;' onclick="countryValidateJs('{$item.id}'); return false;">
                                            <input type="checkbox" class="js-switch countryValidateCheckJs countryValidateCheck_{$item.id}_Js" data-color="#99d683"
                                               data-secondary-color="#f96262" data-size="small" {if $item.validate eq '1'}checked="checked"{/if} />
                                        </div>
                                    </a>
                                </td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                
                </div>
            </div>
        </div>

    </div>
            
        <!-- /.col-lg-12 -->
    </div>
   
</div>

<script type="text/javascript" src="assets/JsFiles/country.js"></script>