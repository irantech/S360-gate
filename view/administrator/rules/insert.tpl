{load_presentation_object filename="rules" assign="objRule"}
{assign var="category" value=$objRule->getCategory($smarty.get.id)}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/rules/listCategory">سر دسته قوانین و مقررات</a></li>
            </ol>
        </div>
    </div>
    <div class="row margin-both-vertical-20">
        <div class='col-md-12'>
            <h5>افزودن قانون به دسته بندی {$category.title}</h5>
            <hr>
        </div>
        <div class="col-md-12 ">
            <span>عنوان قانون </span>
            <input type="text" class="form-control" name="rule" id="rule">
        </div>
        <div class="col-md-12 ">
            <span class=""> متن قانون: </span>
            <textarea class="form-control ckeditor" name="contentRules" id="contentRules"></textarea>
        </div>

        <div class="col-md-12 ">

            <button type='button' onclick="sendDataForInsertRules({$smarty.get.id})" id='btn_create_new_rule_category' class="fcbtn btn btn-outline btn-info ">##Sendinformation##</button>
        </div>
    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/rules.js"></script>