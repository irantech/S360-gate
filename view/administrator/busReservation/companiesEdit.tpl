{load_presentation_object filename="busTicketPriceChanges" assign="objBusCompany"}
{assign var="busCompany" value=$objBusCompany->getBusCompany($smarty.get.id)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href='main'>
                        مدیریت بلیط رزرواسیون اتوبوس
                    </a>
                </li>
                <li>
                    <a href='companies'>
                        شرکت های مسافربری اتوبوس
                    </a>
                </li>
                <li class="active">ویرایش شرکت مسافربری اتوبوس</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <form id="formBaseCompaniesBusEdit" method="post">
                    <input type="hidden" name="flag" value="flagUpdateBaseCompanyBus">
                    <input type="hidden" name="id" value="{$smarty.get.id}">


                    <div class="form-group col-sm-4">
                        <label for="name_fa" class="control-label">نام</label>
                        <input type="text" class="form-control" name="name_fa" value="{$busCompany['name_fa']}"
                               id="name_fa" placeholder=" نام شرکت حمل و نقل را وارد نمائید">
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="name_en" class="control-label">نام انگلیسی</label>
                        <input type="text" class="form-control" name="name_en" value="{$busCompany['name_en']}"
                               id="name_en" placeholder=" نام انگلیسی شرکت حمل و نقل را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="pic" class="control-label">عکس</label>
                        <input type="file" name="pic" id="pic" class="dropify" data-height="100"
                               data-default-file="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/companyBusImages/{$busCompany['logo']}"/>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                            <div class="form-group  pull-right">
                                <button type="submit" class="btn btn-primary">ارسال اطلاعات</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

</div>

<script type="text/javascript" src="assets/JsFiles/busPanel.js"></script>