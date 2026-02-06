{load_presentation_object filename="memberGroups" assign="objGroups"}
{assign var="groupsList" value=$objGroups->ListAll()}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="active">لیست گروه بندی اعضا</li>
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
                <h3 class="box-title m-b-0">گروه جدید</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید گروه بندی مورد نیاز برای اعضای سیستم را ثبت نمائید</p>

                <form data-toggle="validator" id="memberGroupsAdd" method="post">
                    <input type="hidden" name="flag" value="memberGroupsAdd">
                    <div class="form-group col-sm-6 ">
                        <label for="title" class="control-label">عنوان گروه</label>
                        <input type="text" class="form-control" id="title" name="title"
                               placeholder="عنوان گروه را وارد نمائید">
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary pull-right">ارسال اطلاعات</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">گروه بندی اعضا</h3>

                <div class="table-responsive">
                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>عنوان</th>
                            <th>لیست اعضا</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$groupsList}
                            {$number=$number+1}
                            <tr id="del-{$item.id}">
                                <td class="align-middle">{$number}</td>
                                <td class="align-middle">{$item.title}</td>
                                <td class="align-middle">
                                    <a href="setMembersGroup&id={$item.id}" class=""><i
                                        class="fcbtn btn btn-outline btn-info btn-1e fa fa-pencil tooltip-info"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="لیست اعضا"></i></a>
                                </td>
                                <td class="align-middle">
                                    <a href="memberGroupsEdit&id={$item.id}" class=""><i
                                        class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="ویرایش"></i></a>
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


<div class="i-section">
    <div class="i-info">
        <span> ویدیو آموزشی بخش گروه بندی اعضا</span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/402/--.html" target="_blank" class="i-btn"></a>

</div>

<script type="text/javascript" src="assets/JsFiles/memberGroups.js"></script>