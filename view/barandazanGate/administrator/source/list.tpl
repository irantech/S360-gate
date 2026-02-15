{if $smarty.const.TYPE_ADMIN eq 1}
{load_presentation_object filename="sources" assign="objSources"}
{assign var="listSources" value=$objSources->listAllSource()}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin">خانه</a></li>
                <li class='active'>مدیریت تامین کنندگان</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">افزودن یا ویرایش تامین کننده</h3>
                <br>
                <form id="sourceForm" class="form-horizontal" method="post">
                    <input type="hidden" name="id" id="id"/>

                    <!-- ردیف ۱ -->
                    <div class="row">
                        <div class="col-sm-2 form-group">
                            <label>نام (انگلیسی)</label>
                            <input type="text" dir="ltr" name="name" id="name" class="form-control" placeholder="مثلاً PublicParto">
                        </div>
                        <div class="col-sm-2 form-group" style="margin-right: 1px;">
                            <label>نام فارسی</label>
                            <input type="text" name="name_fa" id="name_fa" class="form-control" placeholder="مثلاً پرواز پرتو اشتراکی">
                        </div>
                        <div class="col-sm-2 form-group" style="margin-right: 1px;">
                            <label>نام اختصار</label>
                            <input type="text" name="nickName" id="nickName" class="form-control" placeholder="مثلاً Source10">
                        </div>
                        <div class="col-sm-2 form-group" style="margin-right: 1px;">
                            <label>نوع منبع</label>
                            <input type="text" name="sourceType" id="sourceType" class="form-control" placeholder="نوع flight">
                        </div>
                        <div class="col-sm-2 form-group" style="margin-right: 1px;">
                            <label>کد منبع</label>
                            <input type="number" name="sourceCode" id="sourceCode" class="form-control" placeholder="مثلا 11">
                        </div>
                        <div class="col-sm-2 form-group" style="margin-right: 1px;">
                            <label>وضعیت نرخ</label>
                            <select name="fareStatus" id="fareStatus" class="form-control">
                                <option value="">انتخاب کنید</option>
                                <option value="official">رسمی</option>
                                <option value="unofficial">غیررسمی</option>
                            </select>
                        </div>
                    </div>

                    <!-- ردیف ۲ -->
                    <div class="row">
                        <div class="col-sm-1 form-group">
                            <label>s_d_a_d</label>
                            <input type="text" name="s_d_a_d" id="s_d_a_d" class="form-control" value="0">
                        </div>
                        <div class="col-sm-1 form-group" style="margin-right: 1px;">
                            <label>s_kh_a_kh</label>
                            <input type="number" name="s_kh_a_kh" id="s_kh_a_kh" class="form-control" value="0">
                        </div>
                        <div class="col-sm-1 form-group"  style="margin-right: 1px;">
                            <label>s_kh_a_d</label>
                            <input type="text" name="s_kh_a_d" id="s_kh_a_d" class="form-control" value="0">
                        </div>
                        <div class="col-sm-1 form-group" style="margin-right: 1px;">
                            <label>ch_d_a_d</label>
                            <input type="number" name="ch_d_a_d" id="ch_d_a_d" class="form-control" value="0">
                        </div>
                        <div class="col-sm-1 form-group" style="margin-right: 1px;">
                            <label>ch_kh_a_kh</label>
                            <input type="number" name="ch_kh_a_kh" id="ch_kh_a_kh" class="form-control" value="0">
                        </div>
                        <div class="col-sm-1 form-group" style="margin-right: 1px;">
                            <label>ch_kh_a_d</label>
                            <input type="number" name="ch_kh_a_d" id="ch_kh_a_d" class="form-control" value="0">
                        </div>
                        <div class="col-sm-1 form-group" style="margin-right: 1px;">
                            <label>s_kh_a_kh_au</label>
                            <input type="text" name="s_kh_a_kh_au" id="s_kh_a_kh_au" class="form-control" value="0">
                        </div>
                        <div class="col-sm-1 form-group" style="margin-right: 1px;">
                            <label>وضعیت فعال</label><br>
                            <input type="checkbox" name="isActive" id="isActive">
                        </div>
                    </div>

                    <!-- ردیف 3 -->
                    <div class="row">
                        <div class="col-sm-2 form-group" >
                            <label>نام کاربری</label>
                            <input type="text" dir="ltr" name="username" id="username" class="form-control" >
                        </div>
                        <div class="col-sm-2 form-group" style="margin-right: 1px;">
                            <label>کلمه عبور</label>
                            <input type="text" dir="ltr" name="password" id="password" class="form-control" >
                        </div>
                        <div class="col-sm-2 form-group" style="margin-right: 1px;">
                            <label>توکن</label>
                            <input type="text" dir="ltr" name="token" id="token" class="form-control" >
                        </div>
                        <div class="form-actions text-center m-t-20">
                            <button type="submit" class="btn btn-success">ذخیره</button>
                            <button type="reset" class="btn btn-default">انصراف</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <div class="table-responsive">
                    <table id="listSourcesTable" class="table table-striped table-hover">
                        <thead class="thead-default">
                        <tr>
                            <th>ردیف</th>
                            <th> نام (انگلیسی)</th>
                            <th> نام فارسی</th>
                            <th> نام اختصار</th>
                            <th> نوع منبع</th>
                            <th> کد منبع</th>
                            <th>وضعیت</th>
                            <th>ویرایش</th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach from=$listSources item=source name=sourceLoop}
                            <tr class="odd gradeX">
                                <td>{$smarty.foreach.sourceLoop.iteration}</td>
                                <td>{$source.name}</td>
                                <td>{$source.name_fa}</td>
                                <td>{$source.nickName}</td>
                                <td>{$source.sourceType}</td>
                                <td>{$source.sourceCode}</td>
                                <td>
                                    <a href="#" onclick="FunSourceStatus('{$source.id}'); return false;">
                                        {if $source.isActive eq '1'}
                                            <input type="checkbox" class="js-switch" data-color="#99d683"
                                                   data-secondary-color="#f96262" data-size="small" checked/>
                                        {else}
                                            <input type="checkbox" class="js-switch" data-color="#99d683"
                                                   &id={$source.id}  data-secondary-color="#f96262" data-size="small"/>
                                        {/if}
                                    </a>
                                </td>
                                <td>
                                    <a href="#" onclick="editSource('{$source.id}')">
                                        <i class="fcbtn btn btn-outline btn-primary btn-1f tooltip-primary ti-pencil-alt"
                                           data-toggle="tooltip" data-placement="top"
                                           title="ویرایش تامین کننده"></i>
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
    <script type="text/javascript" src="assets/JsFiles/source.js"></script>
{/if}