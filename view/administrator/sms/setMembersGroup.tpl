{load_presentation_object filename="memberGroups" assign="objGroups"}
{assign var="groupMembers" value=$objGroups->getGroupMembers($smarty.get.id)}
{assign var="groupNoTMembers" value=$objGroups->getNotInGroupMembers($smarty.get.id)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="memberGroups">لیست گروه بندی اعضا</a></li>
                <li class="active">ویرایش گروه</li>
            </ol>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>

        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">ویرایش گروه</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید اعضا را با انتخاب از سمت چپ به گروه اضافه کنید و با انتخاب از سمت راست از گروه حذف کنید</p>

                <form data-toggle="validator" id="setMmembersGroup" method="post">
                    <input type="hidden" name="flag" value="setMmembersGroup">
                    <input type="hidden" name="id" value="{$smarty.get.id}">

                    <div class="form-group col-sm-12 ">
                        <label for="title" class="control-label">حذف و اضافه اعضای گروه ({$groupMembers|count})</label>
                        <select class="form-control" multiple id="groupChanges" name="groupChanges[]">
                            <option value="" disabled="disabled">اعضایی که عضو گروه نیستند ({$groupNoTMembers|count})</option>

                            {foreach key=keyMember item=itemMember from=$groupMembers}
                                <option value="{$itemMember.id}" selected="selected">{$itemMember.name} {$itemMember.family} {$itemMember.email}</option>
                            {/foreach}

                            {foreach key=keyNotMember item=itemNoTMember from=$groupNoTMembers}
                                <option value="{$itemNoTMember.id}">{$itemNoTMember.name} {$itemNoTMember.family} {$itemNoTMember.email}</option>
                            {/foreach}
                        </select>
                        <div class="button-box m-t-20"> <a id="select-all" class="btn btn-info btn-outline" href="#">انتخاب همه</a> <a id="deselect-all" class="btn btn-danger btn-outline" href="#">لغو انتخاب همه</a> </div>
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
</div>

<script type="text/javascript" src="assets/JsFiles/memberGroups.js"></script>

