<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<style>
    .mce-panel {
        top:0!important;
    }
</style>
<div class="col-md-12 bg-white p-2 mb-4">
    <div class="form-row">
        <div class="col-md-12">
            <nav class="nav nav-pills d-flex ">
                <span class="p-2 m-1 h6 text-dark">
                    ویزاهایی که میتوانید برای مسافر تهیه کنید را برای تبلیغات در جستجوگر هوشمند
                    <span class="mx-2 font-weight-bold">{$smarty.const.CLIENT_NAME}</span>
                    وارد نمایید
                </span>


                <a class="text-sm-center border mr-auto nav-link {if $smarty.const.GDS_SWITCH eq 'visaNew'} site-bg-main-color {/if}"
                   href="{$smarty.const.ROOT_ADDRESS}/visaNew">جدید</a>
                <a class="text-sm-center border mr-2 nav-link {if $smarty.const.GDS_SWITCH eq 'visaList'} site-bg-main-color {/if}"
                   href="{$smarty.const.ROOT_ADDRESS}/visaList">لیست</a>


            </nav>
        </div>
    </div>
</div>