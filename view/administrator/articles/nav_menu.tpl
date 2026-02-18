<div class="row bg-title">
    <div class="col-lg-12 col-sm-12 col-md-6 col-xs-12">

        {if isset($smarty.get['service']) AND isset($getServices[$smarty.get.service])}
            <a class="btn btn-primary rounded" href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/articles/insert?service={$smarty.get.service}">
                <i class="fa fa-plus"></i>
                مقاله جدید در بخش
                <span class='font-bold'>
                    {$getServices[$smarty.get.service]['Title']}
                </span>
            </a>
        {else}
            <a class="btn btn-primary rounded" href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/articles/insert?service={$smarty.get.service}">
                <i class="fa fa-link"></i>
                نمایش آخرین مقالات
                </span>
            </a>
        {/if}


        <div class='w-100 mt-4'>
            <a class="btn btn-default rounded" href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/articles/insert?service={$smarty.get.service}">
                <i class="fa fa-tags"></i>
                دسته بندی ها
                </span>
            </a>
        </div>
    </div>
</div>