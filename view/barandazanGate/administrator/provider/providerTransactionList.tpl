{if $smarty.const.TYPE_ADMIN eq '1'}
    {load_presentation_object filename="transactions" assign="objTransaction"}


    <div class="container-fluid">
        <div class="row bg-title">


            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <ol class="breadcrumb FloatRight">
                    <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                    {if  $smarty.const.TYPE_ADMIN eq '1'}
                        <li class="active"><a href="providerTransactionList"></a>حسابداری تامین کنندگان</li>
                    {/if}
                </ol>
            </div>
        </div>



        <div class="row">

            <div class="col-sm-12">
                <div class="white-box">
                    {assign var="providers" value=$objTransaction->getAllProviders()}
                    <div class="table-responsive">
                        <table id="all_transactions" class="table table-striped">
                            <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>شماره اختصاصی پروایدر</th>
                                <th>نام پروایدر</th>
                                <th>نوع خدمت</th>
                                <th>وضعیت</th>
                                <th>مبلغ باقی مانده</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            {foreach key=key item=item from=$providers}
                                {$number=$number+1}
                                <tr id="del-{$item.id}" >
                                    <td>{$number}</td>
                                    <td>{$item.sourceCode}</td>
                                    <td>{$item.name_fa}</td>
                                    <td>{$item.sourceType}</td>
                                    <td>
                                        {if $item.isActive eq 1 }
                                            {'فعال'}
                                        {/if}
                                    </td>
                                    <td
                                            {if $item.total_remain_transaction < 0}
                                                style="color:red"
                                            {/if}
                                    >
                                        {if $item.total_remain_transaction < 0}
                                            {$item.total_remain_transaction = $item.total_remain_transaction * -1}
                                        {/if}
                                        {$item.total_remain_transaction|number_format}
                                    </td>
                                    <td class="align-middle">
                                        <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/provider/providerTransactions?api_id={$item.sourceCode}&sourceType={$item.sourceType}"">
                                        <i  class="fcbtn btn btn-outline btn-primary btn-1e fa fa-book tooltip-primary"
                                            data-toggle ="tooltip" data-placement="top" title=""
                                            data-original-title="جزئیات">

                                        </i>
                                        </a>
                                    </td>
                                </tr>
                            {/foreach}
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="i-section">
        <div class="i-info">
            <span> ویدیو آموزشی بخش گزارش تراکنش ها   </span>
        </div>

        <a href="https://www.iran-tech.com/whmcs/knowledgebase/367/--.html" target="_blank" class="i-btn"></a>

    </div>

    <script type="text/javascript" src="assets/JsFiles/accountcharge.js"></script>


{/if}