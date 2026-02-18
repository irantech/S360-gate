{load_presentation_object filename="lottery" assign="objLotteries"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                    <li class='active'>لیست قرعه کشی ها</li>


            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">


            <div class="white-box">


                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/lottery/insert?section=lottery"
                   class="btn btn-info waves-effect waves-light mb-5" type="button">
                    <span class="btn-label"><i class="fa fa-plus"></i></span>

                        قرعه کشی جدید

                </a>

                <div class="table-responsive table-bordered">
                    <table id="myTable" class="table table-striped table-hover">
                        <thead class="thead-default">
                        <tr>
                            <th>ردیف</th>
                            <th>عنوان</th>
                            <th>عکس</th>
{*                            <th>qrCode</th>*}
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="rowNum" value=0}
                        {assign var="main_lotteries" value=$objLotteries->getAdminLotteries('lottery')}
                        {foreach $main_lotteries as $lottery}
                            {$rowNum=$rowNum+1}
                            <tr>
                                <td>{$rowNum}</td>
                                <td>{$lottery.title}</td>
                                <td><img width="50px"  src="{"/gds/pic/"|cat:$lottery.cover_image}"  /> </td>
{*                                <td class="d-flex text-center" style="flex-direction:column">*}
{*                                    <img width="50px" src="https://api.qrserver.com/v1/create-qr-code/?size=$size&data=https://{$smarty.const.CLIENT_DOMAIN}/gds/fa/lottery/{$lottery.id}"  />*}
{*                                    <a href="https://api.qrserver.com/v1/create-qr-code/?size=$size&data=https://{$smarty.const.CLIENT_DOMAIN}/gds/fa/lottery/{$lottery.id}" target="_blank">بازکردن</a>*}
{*                                </td>*}

                                <td>
                                    <a class="btn btn-sm btn-outline gap-4 btn-success"
                                       href="https://api.qrserver.com/v1/create-qr-code/?size=$size&data=https://{$smarty.const.CLIENT_DOMAIN}/gds/fa/lottery/{$lottery.id}" target="_blank">
                                               QrCode</a>
                                    <a class="btn btn-sm btn-outline gap-4 btn-primary"
                                       href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/lottery/edit?id={$lottery.id}&section=lottery"><i
                                                class="fa fa-edit"></i>ویرایش </a>
                                    <a class="btn btn-sm btn-outline gap-4 btn-warning"
                                       href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/lottery/user?id={$lottery.id}&section=lottery"><i
                                                class="fa fa-user"></i>لیست شرکت کنندگان </a>


{*                                                                        <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/lottery/gallery?id={$lottery.id}"">*}
{*                                                                        <i  class="fcbtn btn btn-outline btn-primary btn-1e fa fa-image tooltip-primary"*}
{*                                                                            data-toggle ="tooltip" data-placement="top" title=""*}
{*                                                                            data-original-title="گالری">*}

{*                                                                        </i>*}
{*                                                                        </a>*}

                                    <button class="btn btn-sm btn-outline btn-danger deleteArticle"
                                            data-id="{$lottery.id}"><i class="fa fa-trash"></i> حذف
                                    </button>
                                </td>


                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
{*                    <input   class="btn btn-info" type="button" onclick='change_order_article()' value="تغییر ترتیب"  title="حذف همه" style='margin: 20px 0 0 0;' />*}

                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/lottery.js"></script>
<style>
    .shown-on-result {

    }
</style>