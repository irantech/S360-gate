{load_presentation_object filename="lottery" assign="objLotteries"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                    <li class='active'>لیست شرکت کنندگان در قرعه کشی </li>


            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">


            <div class="white-box">


{*                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/lottery/insert?section=lottery"*}
{*                   class="btn btn-info waves-effect waves-light mb-5" type="button">*}
{*                    <span class="btn-label"><i class="fa fa-plus"></i></span>*}

{*                        قرعه کشی جدید*}

{*                </a>*}

                <div class="table-responsive table-bordered">
                    <table id="myTable" class="table table-striped table-hover">
                        <thead class="thead-default">
                        <tr>
                            <th>ردیف</th>
                            <th>نام و نام خانوادگی</th>
                            <th>شماره موبایل</th>
                            <th>جایزه</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="rowNum" value=0}
                        {assign var="main_lotteries" value=$objLotteries->getAdminUserListLotteries('lottery')}
                        {foreach $main_lotteries as $lottery}
                            {$rowNum=$rowNum+1}
                            <tr {if $lottery.is_prize == 1}style="background: #039303 !important;color:#000"{/if}>
                                <td>{$rowNum}</td>
                                <td>
                                    {$lottery.name|default:'-'}{if $lottery.family} {$lottery.family}{else}-{/if}
                                </td>


                                <td>{$lottery.mobile}</td>
                                <td><img width="50px"  src="{"/gds/pic/"|cat:$lottery.image_path}"  /> </td>




                            </tr>
                        {/foreach}
                        </tbody>
                    </table>

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