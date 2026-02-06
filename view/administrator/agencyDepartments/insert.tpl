{load_presentation_object filename="agencyDepartments" assign="objAgencyDepart"}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/agencyDepartments/list">لیست واحدها</a></li>
                <li class="active">ثبت جدید</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <form data-toggle="validator" method="post" id="insertAgencyDepart" enctype='multipart/form-data'>
                    <input type="hidden" name="className" value="agencyDepartments">
                    <input type="hidden" name="method" value="insertAgencyDepart">

                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label for="title" class="form-label">عنوان واحد</label>
                            <input type="text" class="form-control" id="title" name="title" value="" required>
                        </div>

                        <div class="col-sm-6 mb-3">
                            <label for="code" class="form-label">کد واحد</label>
                            <input type="text" class="form-control" id="code" name="code" value="">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label for="description" class="form-label">توضیحات</label>
                            <textarea class="form-control" id="description" name="description" rows="6"></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">ذخیره</button>
                </form>
            </div>
        </div>
    </div>

</div>
<script type="text/javascript" src="assets/JsFiles/agencyDepartments.js"></script>