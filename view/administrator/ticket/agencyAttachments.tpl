{load_presentation_object filename="agency" assign="objAgency"}
{$objAgency->getCounterType()}
{assign var="profile" value=$objAgency->getAgency($smarty.get.id)} {*گرفتن اطلاعات کاربر*}
{assign var="attachments" value=$objAgency->getAgencyAttachments($smarty.get.id)}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="agencyList">همکاران</a></li>
                <li class="active">لیست مدارک آژانس همکار</li>
            </ol>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

        </div>

        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">{if $smarty.get.type eq 'acceptWhiteLabel'}مشاهده{else}ویرایش{/if} همکار </h3>
                <p class="text-muted m-b-30">در اینجا میتوانید لیست مدارک آژانس را ببینید</p>
                <div class="attachments container">
                <div class="row">
                    {if count($attachments) gt 0}
                        {foreach $attachments as $key => $attachment}
                            {assign var='ext' value=$objFunctions->getExtensionImage($attachment.file_path)}
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 preview-attachment attachment-{$attachment.id}">
                                {if in_array($ext,['jpg','gif','png','tif' ,'jpeg'])}
                                    {assign var='file_url' value="`$smarty.const.ROOT_ADDRESS_WITHOUT_LANG`/pic/agencyPartner/`$smarty.const.CLIENT_ID`/attachments/`$attachment.file_path`" }
                                    {assign var='img_url' value="`$smarty.const.ROOT_ADDRESS_WITHOUT_LANG`/pic/agencyPartner/`$smarty.const.CLIENT_ID`/attachments/`$attachment.file_path`" }

                                {else}
                                    {assign var='file_url' value="`$smarty.const.ROOT_ADDRESS_WITHOUT_LANG`/pic/agencyPartner/`$smarty.const.CLIENT_ID`/attachments/`$attachment.file_path`" }
                                    {assign var='img_url' value="`$smarty.const.ROOT_ADDRESS_WITHOUT_LANG`/pic/ext-icons/`$ext`.png" }
                                {/if}
                                <figure class="figure">
                                    <a target="_blank" href="{$file_url}">
                                        <img src="{$img_url}" class="figure-img img-responsive img-fluid rounded" alt="{$attachment.file_path}">
                                    </a>
                                    <figcaption class="figure-caption text-xs-right">
                                        <a target="_blank" href="{$file_url}">
                                            <small>{$objFunctions->getNameImage($attachment.file_path)}</small>
                                        </a>
                                        <button type="button" class="remove-attachment btn btn-circle btn-sm btn-danger"
                                                data-id="{$attachment.id}">&times;
                                        </button>
                                    </figcaption>
                                </figure>
                            </div>
                        {/foreach}
                    {/if}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>