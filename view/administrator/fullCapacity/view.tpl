
{load_presentation_object filename="fullCapacity" assign="objFullCapacity"}
{assign var="get_info" value=$objFullCapacity->getFullCapacitySite(1)}
{*{$get_info|var_dump}*}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-3 col-md-6 col-xs-12">
                <ol class="breadcrumb FloatRight">
                    <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                    <li class="active"> دریافت اطلاعات</li>
                </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">
                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>دریافت اطلاعات</h4>
                        </div>

                        <hr class='m-0 mb-4 w-100'>

                        <img src='{$get_info['pic_url']}' width='400' alt='{$get_info['pic_title']}'>

                        <hr class='m-0 mb-4 w-100'>

                    </div>

                </div>
            </div>


    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
</div>


<script type="text/javascript" src="assets/JsFiles/fullCapacity.js">

