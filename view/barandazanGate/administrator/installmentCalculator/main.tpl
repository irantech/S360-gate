{load_presentation_object filename="installmentCalculator" assign="objAbout"}
{assign var="calculatorData" value=$objAbout->GetData()}

{assign var="priceList" value=[
'10' => '10 میلیون' ,
'20' => '20 میلیون' ,
'30' => '30 میلیون' ,
'40' => '40 میلیون' ,
'50' => '50 میلیون' ,
'60' => '60 میلیون',
'70' => '70 میلیون',
'80' => '80 میلیون',
'90' => '90 میلیون',
'100' => '100 میلیون',
'110' => '110 میلیون',
'120' => '120 میلیون',
'130' => '130 میلیون',
'140' => '140 میلیون',
'150' => '150 میلیون',
'160' => '160 میلیون',
'170' => '170 میلیون',
'180' => '180 میلیون',
'190' => '190 میلیون',
'200' => '200 میلیون'
]}

{assign var="maxMinInstallmentsList" value=[
'3' => '3 قسط' ,
'4' => '4 قسط' ,
'5' => '5 قسط' ,
'6' => '6 قسط' ,
'7' => '7 قسط' ,
'8' => '8 قسط' ,
'9' => '9 قسط' ,
'10' => '10 قسط',
'11' => '11 قسط',
'12' => '12 قسط',
'13' => '13 قسط',
'14' => '14 قسط',
'15' => '15 قسط',
'16' => '16 قسط',
'17' => '17 قسط',
'18' => '18 قسط',
'19' => '19 قسط',
'20' => '20 قسط'
]}

{assign var="initialPaymentList" value=[
'5' => '5 درصد' ,
'10' => '10 درصد' ,
'20' => '20 درصد' ,
'25' => '25 درصد' ,
'30' => '30 درصد' ,
'40' => '40 درصد' ,
'50' => '50 درصد',
'60' => '60 درصد',
'70' => '70 درصد',
'80' => '80 درصد',
'90' => '90 درصد'
]}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="active"> محاسبه گر اقساط</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">
                    محاسبه‌گر اقساط
                </h3>


                <form class='installmentCalculatorUpdate' id='installmentCalculatorUpdate' method="post" enctype='multipart/form-data'>

                    <input type='hidden' name='className' value='installmentCalculator'>
                    <input type='hidden' name='method' value='update'>
                    <p class="text-muted m-b-30">
                        اطلاعات زیر در قسمت محاسبه گر اقساط استفاده خواهد شد
                    </p>
                    <div class='d-flex flex-wrap '>

                        <div class='d-block col-md-4 col-sm-12 form-group'>
                            <label for='title'>
                                عنوان
                            </label>
                            <input type='text' class='form-control' id='title' name='title'
                                   value="{$calculatorData['title']}">
                        </div>

                        <div class='d-block col-md-4 col-sm-12 form-group'>
                            <label for='title'>
                                حداقل تعداد اقساط
                            </label>
                            <select class="form-control" name="min_installments" id='min_installments'>
                                <option>انتخاب کنید</option>
                                {foreach $maxMinInstallmentsList as $key => $item}
                                    <option {if $key == $calculatorData['min_installments']}selected{/if} value="{$key}">{$item}</option>
                                {/foreach}
                            </select>
                        </div>

                        <div class='d-block col-md-4 col-sm-12 form-group'>
                            <label for='title'>
                                حداکثر تعداد اقساط
                            </label>
                            <select class="form-control" name="max_installments" id='max_installments'>
                                <option>انتخاب کنید</option>
                                {foreach $maxMinInstallmentsList as $key => $item}
                                    <option {if $key == $calculatorData['max_installments']}selected{/if} value="{$key}">{$item}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class='d-block col-md-4 col-sm-12 form-group'>
                            <label for='title'>
                                حداقل مبلغ تور(میلیون)
                            </label>
                            <select class="form-control" name="min_price" id='min_price'>
                                <option>انتخاب کنید</option>
                                {foreach $priceList as $key => $item}
                                    <option {if $key == $calculatorData['min_price']}selected{/if} value="{$key}">{$item}</option>
                                {/foreach}
                            </select>
                        </div>

                        <div class='d-block col-md-4 col-sm-12 form-group'>
                            <label for='title'>
                                حداکثر مبلغ تور(میلیون)
                            </label>
                            <select class="form-control" name="max_price" id='max_price'>
                                <option>انتخاب کنید</option>
                                {foreach $priceList as $key => $item}
                                    <option {if $key == $calculatorData['max_price']}selected{/if} value="{$key}">{$item}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class='d-block col-md-4 col-sm-12 form-group'>
                            <label for='title'>
                                حداقل پیش پرداخت
                            </label>
                            <select class="form-control" name="initial_payment">
                                <option>انتخاب کنید</option>
                                {foreach $initialPaymentList as $key => $item}
                                    <option {if $key == $calculatorData['initial_payment']}selected{/if} value="{$key}">{$item}</option>
                                {/foreach}
                            </select>
                        </div>

                        <div class='d-block col-md-4 col-sm-12 form-group'>
                            <label for='title'>
                                درصد سود ماهانه
                            </label>
                            <input type="number" placeholder="درصد سود" min="1" max="100" name="profit_percentage" id='profit_percentage' class="form-control"    value="{$calculatorData['profit_percentage']}"/>

                        </div>


                    </div>

                    <div class='d-block mt-5 flex-wrap w-100'>
                        <button type='submit' class='btn submit-button btn-primary btn-block'>
                            ارسال اطلاعات
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>
{literal}

<script type="text/javascript" src="assets/JsFiles/installmentCalculator.js"></script>
{/literal}