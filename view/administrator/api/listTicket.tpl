{load_presentation_object filename="infoApi" assign="objapi"}
{load_presentation_object filename="bookshow" assign="objbook"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>گزارش خرید</li>
                <li class="active"> گزارش خرید api</li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">سوابق خرید</h3>
                <p class="text-muted m-b-30">کلیه سوابق خرید را در این لیست میتوانید مشاهده کنید
                </p>
                <div class="table-responsive">
                    <table id="ticketHistory" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>شماره واچر</th>
                            <th>مبدا</th>
                            <th>مقصد</th>
                            <th>نام ایرلاین</th>
                            <th>تاریخ(ساعت)پرواز</th>
                            <th>pnr</th>
                            <th>نام آژانس</th>
                            <th>تاریخ ثبت</th>
                        </tr>
                        </thead>
                        <tbody>

                        {assign var="number" value="0"}
                        {assign var="remain" value=$objAccount->total_transaction}

                        {foreach key=key item=item from=$objapi->listTicket()}
                            {$number=$number+1}
                            <tr id="del-{$item.id}">
                                <td>{$number}</td>

                                <td style="direction: ltr">

                                    {$item.RequestNumber}

                                </td>

                                <td>
                                    {$item.OriginCity}
                                </td>
                                <td>
                                    {$item.DestinationCity}
                                </td>
                                <td>
                                    {$item.AirlineName}
                                </td>

                                <td>
                                    {$item.DateFlight}
                                    <hr style="margin:3px">
                                    {$item.TimeFlight}
                                </td>
                                <td>
                                    {$item.Pnr}
                                </td>

                                <td>
                                    {$item.AgencyName}
                                </td>
                                <td>
                                    {$objbook->DateJalali(date('Y-m-d (H:i:s)',$item.CreationDateInt))}
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

{if $smarty.post.checkBoxAdvanceSearch neq ''}
{literal}
    <script type="text/javascript">
        $('document').ready(function () {


            $('.showAdvanceSearch').fadeIn();
            $('#checkBoxAdvanceSearch').attr('checked', true);


        });
    </script>
{/literal}
{/if}


<script type="text/javascript" src="assets/JsFiles/bookshow.js"></script>
