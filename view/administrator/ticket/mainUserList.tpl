{load_presentation_object filename="members" assign="objCounter"}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="active"> کاربران اصلی</li>
            </ol>
        </div>
    </div>
    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">لیست کاربران اصلی</h3>
                <p class="text-muted m-b-30"> در لیست زیر شما میتوانید لیست کاربران ثبت نام کرده در سیستم خود را مشاهده نمائید
                    {if isset($smarty.session.AgencyPartner) && $smarty.session.AgencyPartner neq 'AgencyHasLogin'}
                        <span class="pull-right">
                         <a href="mainUserAdd" class="btn btn-info waves-effect waves-light " type="button">
                            <span class="btn-label"><i class="fa fa-user-plus"></i></span>افزودن کاربر جدید
                         </a>
                    </span>
                        <span class="pull-right">
                             <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/memberCreditList"
                                class="btn btn-success waves-effect waves-light " type="button">
                                    <span class="btn-label"><i class="fa fa-user-plus"></i></span>مشاهده درخواست اعتبار هدیه کاربران
                             </a>
                        </span>
                    {/if}

                </p>
                <div class="table-responsive">
                    <table onclick="" id="membersAgency" class="table table-sm">
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="i-section">
    <div class="i-info">
        <span> ویدیو آموزشی بخش کاربران اصلی</span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/372/-.html" target="_blank" class="i-btn"></a>

</div>

<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ویرایش کاربر</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <a href="#" class="mainUserEdit"><i class="fcbtn btn btn-outline btn-primary btn-1f tooltip-primary ti-pencil-alt" data-toggle="tooltip" data-placement="top" title="" data-original-title=" ویرایش کاربر "></i></a>

                    <a href="#" class="passengerListUser"><i class="fcbtn btn btn-outline btn-info btn-1f  tooltip-info ti-view-list-alt " data-toggle="tooltip" data-placement="top" title="" data-original-title="لیست مسافران کاربر "></i></a>

                    <a href="#" class="CounterOnline" onclick="return false" data-toggle="modal" data-target="#ModalPublic"><i class="fcbtn btn btn-outline btn-success btn-1f  tooltip-success icon-user-follow " data-toggle="tooltip" data-placement="top" data-original-title="افزودن به عنوان کانتر "></i></a>

                    <a class="presentedList" href="#"><i class="fcbtn btn btn-outline btn-warning btn-1f  tooltip-warning icon-user-following" data-toggle="tooltip" data-placement="top" title="" data-original-title="لیست استفاده کنندگان از کد معرف"></i></a>

                    <a class="mainUserBankEdit" href="#"><i class="fcbtn btn btn-outline btn-danger btn-1f  tooltip-danger ti-money " data-toggle="tooltip" data-placement="top" title="" data-original-title=" مشخصات حساب بانکی "></i></a>

                    <a class="mainUserBuy" href="#"><i class="fcbtn btn btn-outline btn-info btn-1f  tooltip-info  ti-shopping-cart " data-toggle="tooltip" data-placement="top" title="" data-original-title=" سوابق خرید "></i></a>

                    <a class="creditDetails" href="#" target='_blank'><i class="fcbtn btn btn-outline btn-warning btn-1c fa fa-money fa-lg tooltip-warning " data-toggle="tooltip" data-placement="top" title="" data-original-title=" جزئیات اعتبار "></i></a>


                </div>
            </div>

        </div>
    </div>
</div>
{literal}
    <script>
        $(document).ready(function () {
            membersDatatable($('#membersAgency'));
        });

        const membersDatatable = function (targetTable){
            targetTable.dataTable({
                iDisplayLength: 20,
                pageLength: 20,
                lengthMenu: [20,25,50,100],
                bProcessing: true,
                serverSide: true,
                dataSrc: 'data.response',
                ajax: {
                    url: amadeusPath + "user_ajax.php",
                    type: "POST",
                    cache: false,
                    data: {
                        flag: "adminGetMainUser",
                    },
                    headers: {"cache-control": "no-cache"},
                    complete : function(){
                        $('.js-switch').each(function () {
                            new Switchery($(this)[0], $(this).data());
                        });
                    }
                },
                columns: [
                    {title: "ردیف", data: "rowNumber"},
                    {title: "نام و نام خانوادگی", data: "nameAndFamily"},
                    {title: "نام کاربری", data: "user_name"},
                    {title: "تاریخ", data: "date"},
                    {title: "وضعیت", data: "status"},
                    {title: "عملیات", data: "modal_button"},
                ],
                columnDefs: [
                    {bSortable: false, targets: [3,4]}
                ]
            });
        }

        $('#editUserModal').on('show.bs.modal', event => {
            var button = $(event.relatedTarget);
            var currentId = button.data('id');
            var type = button.data('type-id');
            var modal = $('#editUserModal').find('.modal-body');
            modal.find('.mainUserEdit').attr('href','mainUserEdit&id='+currentId);
            modal.find('.passengerListUser').attr('href','passengerListUser&id='+currentId);
            if(type == 5){
                modal.find('.CounterOnline').attr('onClick',"ModalAddCounterOfUser('"+currentId+"');return false").show();
            }else{
                modal.find('.CounterOnline').hide();
            }
            modal.find('.presentedList').attr('href','presentedList&id='+currentId);
            modal.find('.mainUserBankEdit').attr('href','mainUserBankEdit&id='+currentId);
            modal.find('.mainUserBuy').attr('href','counterTicketHistory&id='+currentId);
            modal.find('.creditDetails').attr('href','usersWalletList&id='+currentId);

        });
    </script>
{/literal}
<script type="text/javascript" src="assets/JsFiles/mainUser.js"></script>