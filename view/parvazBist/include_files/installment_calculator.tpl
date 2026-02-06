{load_presentation_object filename="installmentCalculator" assign="objAbout"}
{assign var="calculatorData" value=$objAbout->GetData()}
{if $calculatorData['initial_payment'] != '' && $calculatorData['initial_payment'] != '' && $calculatorData['max_installments'] != '' && $calculatorData['max_price'] != '' && $calculatorData['max_price'] != '' }
<section class="installmentCalculator py-5">
    <div class="container">
        <div class="installmentCalculator_box row">
            <div class="col-lg-6 col-12">
                <div class="installmentCalculator_box_div1">
                    {if $calculatorData['title'] != ''}
                    <h2>{$calculatorData['title']}</h2>
                    {else}
                    <h2>محاسبه‌گر اقساط</h2>
                    {/if}
                    <input type="hidden" id='initial_payment' name='initial_payment' value='{$calculatorData['initial_payment']}'>
                    <div>
                        <div class="header">
                            <h3>تعداد اقساط</h3>
                            <div class="div-rangeslider">
                                <h6>{$calculatorData['min_installments']}</h6>
                                <span>قسط</span>
                            </div>
                        </div>
                        <div dir="ltr">
                            <input  onchange="getInfoCalculator()" id='installments' data-rangeslider="" max="{$calculatorData['max_installments']}" min="{$calculatorData['min_installments']}" type="range" value="0"/>
                        </div>
                    </div>
                    <div>
                        <div class="header">
                            <h3>مبلغ حدودی هر تور</h3>
                            <div class="div-rangeslider2">
                                <h6>{$calculatorData['min_price']}</h6>
                                <span>میلیون</span>
                            </div>
                        </div>
                        <div dir="ltr">
                            <input onchange="getInfoCalculator()" id='price' data-rangeslider2="" max="{$calculatorData['max_price']}" min="{$calculatorData['min_price']}" step="10" type="range" value="0"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="installmentCalculator_box_div2">
                    <h3>مبلغ هر قسط:</h3>
                    <div class="main_price">
                        <h3 id='amount_each_installment'></h3>
                        <p>تومان</p>
                    </div>
                    <div class="box_price">
                        <div>
                            <p>مبلغ کل تور</p>
                            <h3 id='price_all'></h3>
                            <span>تومان</span>
                        </div>
                        <div>
                            <p>پیش پرداخت</p>
                            <h3 id='result_calculate'></h3>
                            <span>تومان</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="AdvancedInstallmentCalculatorBox">
            <h2>محاسبه‌گر پیشرفته اقساط</h2>
            <div>
                <div>
                    <p>مبلغ تور (تومان)</p>
                    <input id="priceInput" name='priceInput' oninput="formatPrice()" placeholder="مبلغ تور مورد نظر خود را وارد کنید" type="text"/>
                </div>
                <div>
                    <h6 class="title-2">پیش پرداخت

                        <div>
                            <button class="anAmount_btn">مبلغی</button>
                            <button class="percentage_btn active">درصدی</button>
                        </div>
                    </h6>
                    <div class="plus_minus_box percentage">
                        <i onclick="plus_box_percentage(event)"><svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.5.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"></path></svg></i>
                        <span id="persent_discount">20%</span>
                        <i onclick="minus_box_percentage(event)"><svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.5.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M432 256c0 17.7-14.3 32-32 32L48 288c-17.7 0-32-14.3-32-32s14.3-32 32-32l352 0c17.7 0 32 14.3 32 32z"></path></svg></i>
                    </div>
                    <div class="anAmount">
                        <input id='anAmount_tour' name='anAmount_tour'  placeholder="مبلغ پیش پرداخت" type="text"/>
                    </div>
                </div>
                <div>
                    <p>تعداد اقساط</p>
                    <div class="plus_minus_box">
                        <i onclick="plus_box_NumberOfInstallments(event)"><svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.5.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"></path></svg></i>
                        <span id="number_installments">4</span>
                        <i onclick="minus_box_NumberOfInstallments(event)"><svg viewbox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.5.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M432 256c0 17.7-14.3 32-32 32L48 288c-17.7 0-32-14.3-32-32s14.3-32 32-32l352 0c17.7 0 32 14.3 32 32z"></path></svg></i>
                    </div>
                </div>
                <div>
                    <button class="Main_AdvancedInstallmentCalculatorBtn" onclick="Main_AdvancedInstallmentCalculatorBtn()">محاسبه‌گر پیشرفته اقساط</button>
                </div>
            </div>
        </div>
        <div id='error_show_price' class="alert alert-danger" role="alert"></div>
        <div class="AdvancedInstallmentCalculatorBox_response_hide" id='AdvancedInstallmentCalculatorBox_response_hide'>
            <div class="AdvancedInstallmentCalculatorBox_response">
                <div>
                    <h2>مبلغ هر قسط:</h2>
                    <div>
                        <h3 id='amount_each_installment_calculater'></h3>
                        <span>تومان</span>
                    </div>
                </div>
                <div>
                    <h2>جمع کل پرداختی:</h2>
                    <div>
                        <h3 id='price_all_calculater'></h3>
                        <span>تومان</span>
                    </div>
                </div>
                <div>
                    <h2>پیش پرداخت:</h2>
                    <div>
                        <h3 id='result_calculater'></h3>
                        <span>تومان</span>
                    </div>
                </div>
            </div>
        </div>
        <button class="AdvancedInstallmentCalculatorBtn" onclick="AdvancedInstallmentCalculatorBtn()">
            <span class="AdvancedInstallmentCalculatorBtn__open">محاسبه‌گر پیشرفته اقساط</span>
            <span class="AdvancedInstallmentCalculatorBtn__close">بستن</span>
        </button>
    </div>
</section>
{/if}

