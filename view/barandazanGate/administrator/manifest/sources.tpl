{load_presentation_object filename="manifestController" assign="objManifestController"}
{load_presentation_object filename="settingCore" assign="settingCore"}

{assign var="flightSources" value=$settingCore->ListServer()}
{assign var="flightSources" value=$objManifestController->checkManifestSources($flightSources)}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin">خانه</a></li>
                <li class='active'>مدیریت چارترکنندگان</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="box-title m-b-0">منابع پرواز</h3>
                        <p class="text-muted m-b-30">تنظیمات منابع پرواز برای آپلود مانیفست</p>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="flightSourcesTable" class="table table-striped table-hover">
                        <thead class="thead-default">
                        <tr>
                            <th>ردیف</th>
                            <th>نام منبع</th>
                            <th>کد منبع</th>
                            <th>وضعیت مانیفست</th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach from=$flightSources item=source name=sourceLoop}
                            <tr class="odd gradeX">
                                <td>{$smarty.foreach.sourceLoop.iteration}</td>
                                <td>{$source.name_fa}</td>
                                <td>{$source.sourceCode}</td>
                                <td>
                                    <a href="#" onclick="manifest_toggle_status('{$source.sourceCode}'); return false;">
                                        {if $source.has_manifest}
                                            <input type="checkbox" class="js-switch" 
                                                   data-color="#99d683"
                                                   data-secondary-color="#f96262" 
                                                   data-size="small" 
                                                   checked/>
                                        {else}
                                            <input type="checkbox" class="js-switch" 
                                                   data-color="#99d683"
                                                   data-secondary-color="#f96262" 
                                                   data-size="small"/>
                                        {/if}
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
<script type="text/javascript" src="assets/JsFiles/manifest.js"></script>
<script>
    jQuery(document).ready(function() {
        // Initialize DataTable
        $('#flightSourcesTable').DataTable({
            "language": {
                "url": "/assets/global/plugins/datatables/Persian.json"
            }
        });
    });
</script>
 
     