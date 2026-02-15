{load_presentation_object filename="user" assign="objUser"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="active">کاربران</li>
                <li class="active">لیست درخواست اعتبار هدیه کاربران </li>
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
                <h3 class="box-title m-b-0">لیست درخواست اعتبار هدیه کاربران</h3>
                <p class="text-muted m-b-30">
                در لیست زیر شما میتوانید درخواست کاربران را در مورد دریافت اعتبار هدیه ،بررسی و تایید یا رد نمایید
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام و نام خانوادگی</th>
                            <th>شماره فاکتور</th>
                            <th>میزان ریالی درخواست</th>
                            <th>تاریخ درخواست</th>
                            <th>تاریخ تایید/رد درخواست</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objUser->getRequestCreditGift()}
                            {$number=$number+1}
                            <tr id="del-{$item.id}">
                                <td>{$number}</td>
                                <td>{$item.name} {$item.family} </td>
                                <td>{$item.factorNumber}</td>
                                <td>
                                        <input type="text" name="PriceGift" id="PriceGift{$item.id}" value="{$item.amount|number_format}" class="form-control w-50 d-flex" {if $item.status eq 'success'} disabled="disabled"{/if} > </td>

                                <td>{$objDate->jdate('Y-m-d (H:i:s)', $item.creationDateInt)}</td>
                                <td>{if $item.acceptDateInt neq ''} {$objDate->jdate('Y-m-d (H:i:s)', $item.acceptDateInt)}{/if}</td>
                                <td>
                                    {if $item.status eq 'progress'}
                                        <span class="badge badge-warning">در حال بررسی</span>
                                    {elseif $item.status eq 'success'}
                                        <span class="badge badge-success">تایید شده</span>
                                    {elseif $item.status eq 'error'}
                                        <span class="badge badge-danger">رد شده</span>
                                    {/if}
                                </td>
                                <td>
                                    {if $item.status eq 'progress'}
                                    <a onclick="changeStatusRequestCredit('{$item.id}','accept');return false"
                                       style="margin: 5px 0;"  >
                                        <i class="fcbtn btn btn-outline btn-success btn-1f tooltip-success fa fa-check"
                                           data-toggle="tooltip" data-placement="top" title=""
                                           data-original-title="تایید درخواست" ></i>
                                    </a>
                                        <a onclick="changeStatusRequestCredit('{$item.id}','reject');return false"
                                           style="margin: 5px 0;" >
                                            <i class="fcbtn btn btn-outline btn-danger btn-1f tooltip-danger  fa fa-share"
                                               data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="رد  درخواست" ></i>
                                        </a>
                                    {/if}
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

<script type="text/javascript" src="assets/JsFiles/members.js"></script>