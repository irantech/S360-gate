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
{if $objSession->IsLogin() and ($smarty.session.typeUser eq 'counter')}

    {load_presentation_object filename="reservationTour" assign="objResult"}
    {assign var="list" value=$objResult->getListTourDates($smarty.get.id)}

    <div class="main-Content-bottom-table Dash-ContentL-B-Table ">
        <div class="main-Content-bottom-table-Title Dash-ContentL-B-Title site-bg-main-color">
            <i class="icon-table"></i><h3>##Listtourdates## {$list[0]['tour_name']} ({$list[0]['tour_code']})</h3>
        </div>

        <table id="tourList"  class="display" cellspacing="0" width="100%">

            <thead>
                <tr>
                    <th>##Row##</th>
                    <th>   ##Datetravelwent##</th>
                    <th>  ##Datewentback##</th>
                    <th>##Edit##</th>
                    <th>##Showinsite##</th>
                    <th>##IncreaseDecreasePrice##</th>
                </tr>
            </thead>

            <tbody>
            {assign var="number" value="0"}
            {foreach key=key item=item from=$list}
{*                {var_dump($item['is_del'])}*}
                {$number=$number+1}

                <tr>
                    <td>{$number}</td>
                    <td>{$objFunctions->convertDate($item['start_date'])}</td>
                    <td>{$objFunctions->convertDate($item['end_date'])}</td>
                    <td>
                        <a href="{$smarty.const.ROOT_ADDRESS}/editTour&id={$item['id']}" class="btn btn-bitbucket fa fa-pencil-square-o"></a>
                    </td>
                    <td class="d-flex justify-content-center align-items-center">
{*                        <a onclick="logicalDeletion('{$item.id}', 'id'); return false;" class="btn btn-danger fa fa-times"></a>*}

{*                        <label class="switchery">*}
{*                            <input type="checkbox" id="deletionInput_{$item.id}"*}
{*                                   onchange="logicalDeletion('{$item.id}', 'id', this.checked);"*}
{*                                   {if $item['is_del'] == 'yes'}checked{/if}>*}
{*                            <span class="slider"></span>*}







                        <label class="switchery switchery-custom-for-listTourDates">
                            <input type="checkbox"
                                   class="js-switch"
                                   id="deletionInput_{$item.id}"
                                   onclick="return logicalDeletion('{$item.id}', 'id', this);" {if $item.is_del == 'no'}checked{/if}>
                        </label>




                    </td>
                    <td>
                        <a href="{$smarty.const.ROOT_ADDRESS}/changePackagePrice&id={$item['id']}" class="btn btn-info fa fa-sort"></a>
                    </td>
                </tr>
            {/foreach}

        </table>
    </div>


    <div class="userProfileInfo-btn userProfileInfo-btn-change" id="btnSecond">
        <a class="s-u-select-flight-change site-secondary-text-color bgAmber"
           style="width: 40%;padding: 15px;font-size: 14px;"
           href="{$smarty.const.ROOT_ADDRESS}/tourList">##Listalltour##</a>
    </div>

{if in_array($smarty.const.CLIENT_ID, $objFunctions->newLogin())}
                </div>
            </div>
        </div>
    </section>
</main>
{/if}
{literal}
    <script type="text/javascript">
        $(document).ready(function () {
            $('#tourList').DataTable();
           $('.js-switch').each(function () {
              new Switchery(this, {
                 size: 'small'
              });
           });


        });
        $(function () {
            $(document).tooltip();
        });



    </script>
    {/literal}

{else}
    <div class="userProfileInfo-messge">
        <div class="messge-login">
            ##Pleasslogin##
        </div>
    </div>
{/if}
<script src="assets/js/profile.js"></script>