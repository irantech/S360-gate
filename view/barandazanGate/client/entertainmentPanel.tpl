{load_presentation_object filename="entertainment" assign="objEntertainment"}

{if in_array($smarty.const.CLIENT_ID, $objFunctions->newLogin())}
<main>
    <section class="profile_section mt-3 mb-3 row">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 position-static">
                    <div class="menu-profile-ris d-lg-none">
                        <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/{$MainUrlAddress}" class="logo_img"><img src='{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$smarty.const.CLIENT_LOGO}' alt='logo'></a>
                        <button onclick="openMenuProfile()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M0 88C0 74.75 10.75 64 24 64H424C437.3 64 448 74.75 448 88C448 101.3 437.3 112 424 112H24C10.75 112 0 101.3 0 88zM0 248C0 234.7 10.75 224 24 224H424C437.3 224 448 234.7 448 248C448 261.3 437.3 272 424 272H24C10.75 272 0 261.3 0 248zM424 432H24C10.75 432 0 421.3 0 408C0 394.7 10.75 384 24 384H424C437.3 384 448 394.7 448 408C448 421.3 437.3 432 424 432z"/></svg></button>
                    </div>
                    <div onclick="closeMenuProfile()" class="bg-black-profile-ris d-lg-none"></div>
                    <div class="box-style sticky-100">
                        {include file="./profileSideBar.tpl"}
                    </div>
                </div>
                <div class="col-lg-9">
    {else}
         {include file="`$smarty.const.FRONT_CURRENT_CLIENT`clientProfile.tpl"}
{/if}



{if $objSession->IsLogin() and $objFunctions->TypeUser($objSession->getUserId()) eq 'Counter' and $objEntertainment->reservationEntertainmentAuth()}
{*{assign var="check_offline" value=$objFunctions->checkClientConfigurationAccess('offline_entertainment')}*}
{*{$smarty.const.GDS_SWITCH|var_dump}*}

<div class="client-head-content">

    <style>
        table.dataTable thead .sorting{
            background-image: none !important;
        }
        .nav-tabs .nav-link{
            color:#666
        }
        .nav-link.active {
            background-color: rgb(255 255 255) !important;
            color: #000 !important;
        }
        .select2-container--open{
            z-index:9999;
        }
        .row-gap{
            row-gap: 5px;
        }
        .GalleryTable img {
            width: 160px;
            height: 100px;
        }
        .IconBox .item .active {
            border: 1px solid #0000 !important;
            box-shadow: 0 0 9px 0px #0000005c;
        }
        #entertainment_category_list_info{
            display: none;
        }
    </style>


    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item stable-tab">
            <a class="nav-link active"
               onclick="getCategoryData($('#entertainment_category_list'),'0')"
               id="all-categories-tab" data-toggle="tab" href="#all-categories" role="tab" aria-controls="all-categories" aria-selected="true">
                ##AllCategories##

            </a>
        </li>
        <li class="nav-item stable-tab">
            <a class="nav-link"
               onclick="getCategoryData($('#entertainment_category_list'),'deleted')"
               id="deleted-categories-tab" data-toggle="tab" href="#deleted-categories" role="tab" aria-controls="deleted-categories" aria-selected="true">
                ##Deleted##

            </a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active stable-tab" id="all-categories" role="tabpanel" aria-labelledby="all-categories-tab">
            <div class="col-md-12 bg-white pt-3">
                <button class="btn site-bg-main-color" type="button" data-target="#exampleModal"
                        onclick="createNewEntertainmentCategoryModal($(this))">
                    ##NewBatchHead##
                </button>
            </div>

        </div>
        <div class="tab-pane fade  stable-tab" id="deleted-categories" role="tabpanel" aria-labelledby="deleted-categories-tab">


        </div>
    </div>

    <div class="col-md-12 mb-4 bg-white p-3 content-table">
        <table onclick="" id="entertainment_category_list" class="table table-sm table-striped table-bordered">

        </table>
    </div>





    <!-- Modal -->

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header  site-bg-main-color">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" data-type="submit" class="btn site-bg-main-color">##Register##</button>
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">##Closing##</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalOptions" tabindex="-1" role="dialog" aria-labelledby="modalOptionsLabel"  aria-hidden="true"></div>



    {* ********************* editor_TinyMCE ********************* *}
    {literal}
        <script type="text/javascript" src="assets/editor_TinyMCE/editor/tinymce.min.js"></script>
        <script type="text/javascript" src="assets/editor_TinyMCE/editor.js"></script>

    {/literal}
    {* ********************* editor_TinyMCE ********************* *}



</div>

{else}
    <div class="userProfileInfo-messge">
        <div class="messge-login">
            ##Pleaselogin##
        </div>
    </div>
{/if}


{if in_array($smarty.const.CLIENT_ID, $objFunctions->newLogin())}
                </div>
            </div>
        </div>
    </section>
</main>
{/if}
<link rel="stylesheet" type="text/css" href="assets/css/ldbtn.min.css">
<script src="assets/js/profile.js"></script>
<script type="text/javascript" src="assets/js/jquery-dropzone.js"></script>
<script type="text/javascript" src="assets/js/customForEntertainment.js"></script>
<script type="text/javascript" src="assets/js/customForVisa.js"></script>

 <script type="text/javascript">
     getCategoryData($('#entertainment_category_list'));
</script>
