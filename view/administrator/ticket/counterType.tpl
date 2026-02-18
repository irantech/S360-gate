{load_presentation_object filename="counterType" assign="objCounter"}
{$objCounter->getAll('all')} {*گرفتن لیست انواع کانتر*}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>تنظیمات</li>
                <li class="active">نوع کانتر</li>
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
                <h3 class="box-title m-b-0">لیست نوع کانتر</h3>
                <p class="text-muted m-b-30">
                    در لیست زیر میتوانید انواع کانتر ها را مشاهده کنید
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>عنوان کانتر</th>
                            <th>درصد سیستمی اختصاصی</th>
                            <th>درصد سیستمی اشتراکی</th>
                            <th>درصد چارتری</th>
                            <th>درصد هتل</th>
                            <th>ویرایش</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objCounter->list}
                            {$number=$number+1}
                            <tr>
                                <td>{$number}</td>
                                <td>{$item.name}</td>
                                <td> {if $item.discount_system_private eq '' }0%{else}{$item.discount_system_private}%{/if}</td>
                                <td>{if $item.discount_system_public eq '' }0%{else}{$item.discount_system_public}%{/if}</td>
                                <td>{if $item.discount_charter eq '' }0%{else}{$item.discount_charter}%{/if}</td>
                                <td>{if $item.discount_hotel eq '' }0%{else}{$item.discount_hotel}%{/if}</td>
                                <td> {if $item.id eq 0}{else}<a href="counterTypeEdit&id={$item.id}">

                                    <i  class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                            data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="ویرایش نوع کانتر"></i>

                                </a> {/if}
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
