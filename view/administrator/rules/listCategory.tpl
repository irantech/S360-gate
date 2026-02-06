{load_presentation_object filename="rules" assign="objCategory"}
{$lang = $smarty.const.SOFTWARE_LANG}
{if  $smarty.get.lang}
    {$lang = $smarty.get.lang}
{/if}

{assign var="allCategories" value=$objCategory->getAllCategories($lang)}



<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/rules/listCategory">سر دسته قوانین و مقررات</a></li>
            </ol>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="language" class="control-label">زبان</label>
            <select onchange='rulesLanguage(this.value);' class="form-control" id="language">
                {foreach $languages as $value=>$title}
                    <option {if $value eq $lang}selected{/if} value="{$value}">{$title}</option>
                {/foreach}
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    {foreach $allCategories as $key => $category}
                        {assign var="ruleCount" value=$category.rules|count}
                         <li role="presentation" class="{if $key eq '0'}active{/if}">
                                <a href="#{$category.slug}" aria-controls="{$category.slug}" role="tab" data-toggle="tab">
                                    {if $ruleCount eq 0}
                                        <button onclick="deleteCategory('{$category.id}');"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256L7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256L312.1 375z"/></svg></button>
                                    {/if}
                                    {$category.title}
                                    <span class='{$category.title}'></span>
                                </a>
                            </li>
                    {/foreach}
                    <li role="presentation">
                        <a href="#newCategory" aria-controls="newCategory" role="tab" data-toggle="tab"><i class="fa fa-plus"></i>
                            افزودن سر دسته
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    {foreach $allCategories as $key => $category}
                        <div role="tabpanel" class="tab-pane {if $key eq '0'}active{/if}" id="{$category.slug}">
                            <div class="list-group">
                                <a onclick="modalEditCategoryRule('{$category.id}')"
                                   data-toggle="modal"
                                   data-target="#ModalPublic">
                                    <i class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-plus m-1"
                                       data-toggle="tooltip"
                                       data-placement="top" title=""
                                       data-original-title="ویرایش دسته بندی">ویرایش دسته بندی</i>
                                </a>



                                <a href='{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/rules/insert?id={$category.id}'
{*                                        onclick="modalAddRules('{$category.id}');return false"*}
{*                                   data-toggle="modal"*}
{*                                   data-target="#ModalPublic"*}
                                >
                                    <i class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-plus m-1"
                                       data-toggle="tooltip"
                                       data-placement="top" title=""
                                       data-original-title="افزودن قانون جدید">افزودن قانون جدید</i>
                                </a>
                                {foreach $category.rules as $rule}
                                    <span class='position-relative'>
                                        <div class="list-group-item list-group-item-action m-t-10">
                                             <a
                                                     href='{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/rules/edit?rule_id={$rule.id}&category_id={$rule.category_id}'
{*                                                onclick="modalEditRule('{$rule.id}');return false"*}
                                                     {*                                        data-toggle="modal"*}
                                                     {*                                        data-target="#ModalPublic"*}
                                                >{$rule.title}

                                        </a>
                                            <div class="list-group-item-action-remove" onclick="deleteRule('{$rule.id}');">حذف</div>
                                        </div>

                                    </span>
                                {/foreach}
                            </div>

                        </div>
                    {/foreach}
                    <div role="tabpanel" class="tab-pane" id="newCategory">
                        <form action="/" id="newRulesCategory" class="container">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-4 form-group">
                                            <input type="hidden" name="flag" value="newRulesCategory">
                                            <input type='hidden' name='lang' value='{$lang}'>
                                            <label for="title" class="control-label">عنوان سردسته</label>
                                            <input id="title" name="title" type="text" class="form-control"
                                                   placeholder="لطفا عنوان سردسته را وارد کنید">
                                        </div>
                                        <div class="col-sm-4 form-group">
                                            <label for="slug" class="control-label">عنوان انگلیسی</label>
                                            <input id="slug" name="slug" type="text" class="form-control"
                                                   placeholder="لطفا نام انگلیسی سردسته را وارد کنید">
                                        </div>



                                        {assign var="iconList" value=[
                                        'fa fa-plane',
                                        'fa fa-hand-o-left',
                                        'fa fa-hospital-o' ,
                                        'fa fa-home' ,
                                        'fa fa-building',
                                        'fa fa-building-o',
                                        'fa fa-bullhorn',
                                        'fa fa-bus',
                                        'fa fa-tachometer',
                                        'fa fa-train',
                                        'fa fa-truck',
                                        'fa fa-sliders',
                                        'fa fa-bicycle',
                                        'fa fa-automobile',
                                        'fa fa-wheelchair',
                                        'fa fa-user',
                                        'fa fa-product-hunt',
                                        'fa fa-globe',
                                        'fa fa-heartbeat',
                                        'fa fa-heart',
                                        'fa fa-tags',
                                        'fa fa-cc-visa',
                                        'fa fa-asterisk',
                                        'fa fa-check',
                                        'fa fa-calculator',
                                        'fa fa-dollar'
                                        ]}

                                        <div class="col-md-12 mb-3">
                                            <label for="title" class="control-label" style='margin: 10px 0'>آیکون ها</label>

                                            <div class="col-md-12 mb-3 IconBox ">

                                                {foreach $iconList as $value}
                                                <div data-target="IconBoxSelector" data-value="{$value}" class="col-md-1 text-center item mb-3">
                                                    <div class="border text-center " onclick="selectCategoryIcon($(this),'{$value}')">
                                                        <span class="{$value}"></span>
                                                    </div>
                                                </div>
                                                {/foreach}
                                                <input type="hidden" value='' class="form-control" name="edited_icon_category" id="edited_icon_category">
                                                <script>
                                                  function selectCategoryIcon(item) {
                                                   alert(item)
                                                  }
                                                </script>


                                            </div>

                                        </div>




                                        <div class="col-sm-4 form-group">
                                            <label for="slug" class="control-label">&#8203;</label>
                                            <button type="submit" class="btn btn-primary d-block">افزودن</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/rules.js"></script>