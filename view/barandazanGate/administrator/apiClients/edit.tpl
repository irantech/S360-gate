{if $smarty.const.TYPE_ADMIN eq 1}

{load_presentation_object filename="apiClients" assign="objapiClients"}

{assign var="apiClient" value=$objapiClients->getApiClientById($smarty.get.id)}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">

                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/apiClients/list">
                        لیست مشتریان api
                    </a>
                </li>
                <li class='active'>
                    ویرایش مشتری api
                    <span class='font-bold underdash'>{$apiClient['userName']}</span>
                </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <p class="text-muted m-b-30 textPriceChange">
                </p>

                <form id="FormAddApiClients" method="post" enctype='multipart/form-data' data-toggle="validator" >

                    <input type="hidden" name="className" value="apiClients">
                    <input type="hidden" name="method" value="updateApiClients">
                    <input type="hidden" name="id" value="{$apiClient['id']}">

                    <div class="form-group col-sm-6">
                        <label for="userName" class="control-label">نام کاربری</label>
                        <input type="text" class="form-control" name="userName" value="{$apiClient['userName']}"
                               id="userName" placeholder="نام کاربری را وارد کنید">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="keyTabdol" class="control-label">پسورد</label>
                        <input type="text" class="form-control" name="keyTabdol" value="{$apiClient['keyTabdol']}"
                               id="keyTabdol" placeholder="پسورد را وارد کنید">
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                            <div class="form-group  pull-right">
                                <button type="submit" class="btn btn-primary">ارسال اطلاعات</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<script>
  $(document).ready(function() {
    setTimeout(function() {
      removeSelect2()
      initializeSelect2Search()
    }, 500)
  })
</script>


<script type="text/javascript" src="assets/JsFiles/apiClients.js"></script>
{/if}
