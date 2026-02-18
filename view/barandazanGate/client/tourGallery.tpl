{if $objSession->IsLogin() and ($smarty.session.typeUser eq 'counter')}

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

    <div class="main-Content-top s-u-passenger-wrapper-change" >
        <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
            <i class="zmdi zmdi-account-box-mail zmdi-hc-fw mart10"></i> ##Addimgtour##
        </span>
        <div class="panel-default-change site-border-main-color">
            <form class="s-u-result-item-change" data-toggle="validator" id="galleryForm" method="post">
                <input type="hidden" name="flag" id="flag" value="tourGallery" />
                <input type="hidden" name="tourIdSame" id="tourIdSame" value="{$smarty.get.id}" />

                <div class="s-u-passenger-item  s-u-passenger-item-change form-group">
                    <label for="picTitle" class="flr"> ##Titleimg##:</label>
                    <input type="text" name="picTitle" id="picTitle" placeholder=" ##Titleimg##">
                </div>

                <div class="s-u-passenger-item  s-u-passenger-item-change form-group">
                    <label for="pic" class="flr">##Gallery##:</label>
                    <input type="file" name="pic" id="pic" multiple
                           accept="image/x-png, image/gif, image/jpeg, image/jpg"/>
                </div>

                <div class="userProfileInfo-btn userProfileInfo-btn-change">
                    <input class="s-u-select-flight-change site-secondary-text-color site-main-button-flat-color" type="submit" value="##Register##">
                </div>
            </form>
        </div>
    </div>


    {load_presentation_object filename="resultTourLocal" assign="objResult"}

    <div class="main-Content-bottom Dash-ContentL-B">
        <div class="main-Content-bottom-table Dash-ContentL-B-Table">
            <div class="main-Content-bottom-table-Title Dash-ContentL-B-Title site-bg-main-color">
                <i class="icon-table"></i><h3> ##Gallerytour##</h3>
            </div>

            <table id="tourGallery" class="display" cellspacing="0" width="100%">

                <thead>
                    <tr>
                        <th width="10%">##Row##</th>
                        <th width="30%"> ##Titleimg##</th>
                        <th width="60%">##Img##</th>
                        <th width="10%">##Delete##</th>
                    </tr>
                </thead>

                <tbody>
                    {assign var="number" value="1"}
                    {foreach key=key item=item from=$objResult->getTourGallery($smarty.get.id)}
                    <tr>
                        <td>{$number++}</td>
                        <td>{$item.pic_title}</td>
                        <td>
                            <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item.pic_name}"
                                 class="all landscape width30" alt="{$item.pic_title}" style="width: 30%;height: auto;"/>
                        </td>
                        <td>
                            <a onclick="logicalDeletionGalleryTour('{$item.id}'); return false;" class="btn btn-danger fa fa-times"></a>
                        </td>
                    </tr>
                    {/foreach}
                <tbody>


            </table>
        </div>
    </div>





    <div class="userProfileInfo-btn userProfileInfo-btn-change" id="btnSecond">
        <a class="s-u-select-flight-change site-secondary-text-color bgGreen"
           style="width: 40%;padding: 15px;font-size: 14px;"
           href="{$smarty.const.ROOT_ADDRESS}/listTourDates&id={$smarty.get.id}">##Nextstep## (##Show##/##Edit##/##Deletetourdates##)</a>
    </div>



    <div class="userProfileInfo-btn userProfileInfo-btn-change" id="btnSecond">
        <a class="s-u-select-flight-change site-secondary-text-color bgAmber"
           style="width: 40%;padding: 15px;font-size: 14px;"
           href="{$smarty.const.ROOT_ADDRESS}/tourList">##Listalltour##   </a>
    </div>
{if in_array($smarty.const.CLIENT_ID, $objFunctions->newLogin())}
        </div>
       </div>
    </div>
   </section>
</main>
{/if}


{else}
    <div class="userProfileInfo-messge">
        <div class="messge-login">
           ##Pleaselogin##
        </div>
    </div>
{/if}

{literal}
    <script src="assets/js/profile.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#tourGallery').DataTable();
        });
    </script>
{/literal}