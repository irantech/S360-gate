{if $smarty.const.TYPE_ADMIN eq 1}
    {load_presentation_object filename="airline" assign="objAirline"}
    {assign var=airLineFareClasses value=$objAirline->getFareClasses()}

    <div class="container-fluid">
        <div class="row bg-title">
            <div   class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <ol class="breadcrumb FloatRight">
                    <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                    <li>تنظیمات</li>
                    <li class="active">کلاس نرخی ایرلاین ها</li>
                </ol>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <!-- فرم افزودن ایرلاین جدید -->
                    <div class="panel panel-default m-b-20">
                        <div class="panel-heading">افزودن کلاس نرخی  جدید</div>
                        <div class="panel-body">
                            <form id="addAirlineClassFareForm" class="form-horizontal">
                                <div class="form-group">

                                    <label class="col-sm-1 control-label"> کلاس نرخی : </label>
                                    <div class="col-sm-4">
                                        <input type="text" id="class_name" name="class_name" class="form-control" placeholder="کلاس نرخی مورد نظر را وارد کنید" >
                                    </div>

                                    <div class="col-sm-2">
                                        <button type="submit" class="btn btn-success" id="addAirlineBtn">
                                            <i class="fa fa-plus"></i> افزودن
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped">
                            <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>کلاس نرخی</th>
                                <th>حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            {assign var="number" value="0"}
                            {foreach key=key item=item from=$airLineFareClasses}
                                {assign var="number" value=$number+1}
                                <tr>
                                    <td>{$number}</td>
                                    <td>{$item.class_name}</td>
                                    <td>
                                        {*onclick="logical_deletion('{$item.id}', 'visa_tb'); return false"*}
                                        <a onclick="removeAirlineClassFareBtn('{$item.id}'); return false"
                                           id="DelChangePrice-2"
                                           class="popoverBox  popover-danger" data-toggle="popover" title=""
                                           data-placement="right">
                                            <i class="fcbtn btn btn-outline btn-danger btn-1c fa fa-remove "></i>
                                        </a>
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
{/if}

<script type="text/javascript" src="assets/JsFiles/airline.js"></script>
