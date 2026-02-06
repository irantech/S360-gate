{load_presentation_object filename="visa" assign="objVisa"}
{if $smarty.const.TYPE_ADMIN eq '1'}
{assign var="visaOptions" value=$objVisa->visaOptions($smarty.get.id)}


{load_presentation_object filename="country" assign="objCountry"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>مدیریت ویزا رزرواسیون</li>
                <li class="active">تنظیمات ویزا <span class="text-success">( {$objFunctions->ClientName($smarty.get.id)} )</span> </li>
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
                <h3 class="box-title m-b-0">تنظیمات ویزا </h3>
                <p class="text-muted m-b-30 d-none">در لیست زیر ویزا ها را میتوانید مشاهده و ویرایش نمایید.
                    <span class="pull-right">
                         <a href="visaAdd" class="btn btn-info waves-effect waves-light " type="button">
                            <span class="btn-label"><i class="fa fa-plus"></i></span>افزودن ویزا
                        </a>
                    </span>
                </p>
                <div class="table-responsive">

                    <table id="myTable" class="table table-striped ">
                        <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>عنوان</th>
                                <th>وضعیت</th>

                            </tr>
                        </thead>
                        <tbody>
                            {assign var="number" value="0"}
                            {foreach $visaOptions as $item}

                                {$number = $number + 1}

                                <tr>
                                    <td>{$number}</td>
                                    <td>
                                        <a href="#">
                                            <div style='float: right;' onclick="visaOptions('{$item.id}','{$smarty.get.id}'); return false;">
                                                <input type="checkbox" class="js-switch" data-color="#99d683"
                                                       data-secondary-color="#f96262" data-size="small" {if $item.value eq 'available'}checked="checked"{/if} />
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        {$item.name}
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

<div class="i-section">
    <div class="i-info">
        <span> ویدیو آموزشی بخش لیست ویزاها  </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/392/-.html" target="_blank" class="i-btn"></a>

</div>

<script type="text/javascript" src="assets/JsFiles/visa.js"></script>
<script type="text/javascript" src="assets/JsFiles/reservationBasicInformation.js"></script>
{/if}