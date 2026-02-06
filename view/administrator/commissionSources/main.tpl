{if $smarty.const.TYPE_ADMIN eq 1}
    {load_presentation_object filename="commissionSources" assign="objSources"}
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

                <ol class="breadcrumb FloatRight">
                    <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                    <li>تنظیمات</li>
                    <li class="active">کمیسیون تامین کنندگان</li>
                </ol>
            </div>
        </div>
        <div class="row">

            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">اطلاعات کمیسیون تامین کنندگان</h3>
                    <p class="text-muted m-b-30">شما میتوانید کلیه کمیسیون ها را در این لیست مشاهده و ویرایش نمائید
                    </p>
                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped">
                            <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>نام</th>
                                <th>کد</th>
                                <th>وضعیت fare</th>
                                <th>س د ا د</th>
                                <th>س خ ا د</th>
                                <th>س خ ا خ (آمادئوسی)</th>
                                <th>س خ ا خ</th>
                                <th>چ د ا د</th>
                                <th>چ خ ا خ</th>
                                <th>چ خ ا د</th>
                            </tr>
                            </thead>
                            <tbody>
                            {assign var="number" value="0"}
                            {foreach key=key item=item from=$objSources->listCom()}
                                {$number=$number+1}
                                <tr>
                                    <td>
                                        {$number}
                                    </td>

                                    <td>
                                        {$item.name_fa}
                                    </td>

                                    <td>
                                        {$item.sourceCode}
                                    </td>

                                    <td>
                                        <select
                                                class="form-control"
                                                name="fareStatus"
                                                onchange="selectFareStatus(this)"
                                                data-sourcecode="{$item.sourceCode}">

                                            <option value=""> انتخاب کنید...</option>
                                            <option value="official" {if $item.fareStatus eq 'official'}
                                                    selected="selected"{/if}>رسمی
                                            </option>
                                            <option value="unofficial" {if $item.fareStatus eq 'unofficial'}
                                                    selected="selected"{/if}>غیر رسمی
                                            </option>
                                        </select>
                                    </td>

                                    <td>
                                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <input type="text"
                                                   class="form-control commission-source"
                                                   value="{$item.s_d_a_d * 100}"
                                                   name="s_d_a_d"
                                                   data-sourcecode="{$item.sourceCode}"
                                                   onchange="UpdateCommissionSource(this)" />
                                        </div>
                                        %
                                    </td>

                                    <td>
                                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <input type="text"
                                                   class="form-control commission-source"
                                                   value="{$item.s_kh_a_d * 100}"
                                                   name="s_kh_a_d"
                                                   data-sourcecode="{$item.sourceCode}"
                                                   onchange="UpdateCommissionSource(this)" />
                                        </div>
                                        %
                                    </td>

                                    <td>
                                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <input type="text"
                                                   class="form-control commission-source"
                                                   value="{$item.s_kh_a_kh_au * 100}"
                                                   name="s_kh_a_kh_au"
                                                   data-sourcecode="{$item.sourceCode}"
                                                   onchange="UpdateCommissionSource(this)" />
                                        </div>
                                        %
                                    </td>

                                    <td>
                                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <input type="text"
                                                   class="form-control commission-source"
                                                   value="{$item.s_kh_a_kh}"
                                                   name="s_kh_a_kh"
                                                   data-sourcecode="{$item.sourceCode}"
                                                   onchange="UpdateCommissionSource(this)" />
                                        </div>
                                        ریال
                                    </td>



                                    <td>
                                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <input type="text"
                                                   class="form-control commission-source"
                                                   value="{$item.ch_d_a_d}"
                                                   name="ch_d_a_d"
                                                   data-sourcecode="{$item.sourceCode}"
                                                   onchange="UpdateCommissionSource(this)" />
                                        </div>
                                        ریال
                                    </td>

                                    <td>
                                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <input type="text"
                                                   class="form-control commission-source"
                                                   value="{$item.ch_kh_a_kh}"
                                                   name="ch_kh_a_kh"
                                                   data-sourcecode="{$item.sourceCode}"
                                                   onchange="UpdateCommissionSource(this)" />
                                        </div>
                                        ریال
                                    </td>

                                    <td>
                                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                            <input type="text"
                                                   class="form-control commission-source"
                                                   value="{$item.ch_kh_a_d}"
                                                   name="ch_kh_a_d"
                                                   data-sourcecode="{$item.sourceCode}"
                                                   onchange="UpdateCommissionSource(this)" />
                                        </div>
                                        ریال
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

<script type="text/javascript" src="assets/JsFiles/commissionSources.js"></script>
