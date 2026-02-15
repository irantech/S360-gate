
{load_presentation_object filename="user" assign="objUser"}
{if $objSession->IsLogin() and $objSession->getTypeUser() eq 'counter'}
    {assign var="profile" value=$objUser->getProfileGds({$objSession->getUserId()})} {*گرفتن اطلاعات کاربر*}
    {assign var="userid" value=$objSession->getUserId()}
    {assign var="final_points" value=$objUser->pointsClubUser()}
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
                        {include file="./profileHead.tpl"}
                        {assign var="member_point"  value=$objUser->getPointOfClub()}
                        <div class="box-style">
                            <div class="box-style-padding">
                                <div class="passengers_header flex-wrap">
                                    <h2 class="title mb-0">##listYourPoints##</h2>
                                    <button onclick="convertPointToPrice(event.currentTarget , '{$member_point}')" >
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M447.1 272.2c-8.766-1.562-16.97 4.406-18.42 13.12C415.3 370.3 342.3 432 255.1 432c-49.96 0-95.99-21.56-128.5-56.8l59.88-59.88C191.9 310.8 193.3 303.8 190.8 297.9C188.3 291.9 182.5 288 176 288h-128C39.16 288 32 295.2 32 304v128c0 6.469 3.891 12.31 9.875 14.78C43.86 447.6 45.94 448 48 448c4.156 0 8.25-1.625 11.31-4.688l45.6-45.6C143.3 438.9 197.4 464 256 464c101.1 0 188.3-72.91 205.1-173.3C462.6 281.9 456.7 273.7 447.1 272.2zM64 393.4V320h73.38L64 393.4zM470.1 65.22C468.1 64.41 466.1 64 464 64c-4.156 0-8.25 1.625-11.31 4.688l-45.6 45.6C368.7 73.15 314.6 48 256 48c-102 0-188.3 72.91-205.1 173.3C49.42 230.1 55.3 238.3 64.02 239.8c8.766 1.562 16.97-4.406 18.42-13.12C96.69 141.7 169.7 80 256 80c49.96 0 96.02 21.56 128.6 56.8l-59.88 59.88c-4.578 4.562-5.953 11.47-3.469 17.44C323.7 220.1 329.5 224 336 224h128C472.8 224 480 216.8 480 208v-128C480 73.53 476.1 67.69 470.1 65.22zM448 192h-73.38L448 118.6V192z"/></svg>
                                        ##convertPointToPrice##
                                        <div class="bouncing-loader bouncing-loader-none">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </button>
                                </div>

                                {if !empty($final_points)}
                                    <div>
                                        <div class="content-table table_style_parent mt-4">
                                            <table id="passengerList" class="table_style mb-3 table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>##Row##</th>
                                                    <th>##Invoicenumber##</th>
                                                    <th>##Point##</th>
                                                    <th>##Type##</th>
                                                    <th>##Description##</th>
                                                    <th>##Service##</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                {assign var="number" value="1"}
                                                {foreach key=key item=item from=$final_points}
                                                   <tr>
                                                       <td data-content="##Row##" align="center">{$number++}</td>
                                                       <td data-content="##Invoicenumber##" align="center">{$item.factor_number}</td>
                                                       <td data-content="##Point##" align="center">{$item.point}</td>
                                                       <td data-content="##Type##" align="center">{$item.type_point}</td>
                                                       <td data-content="##Description##" align="center">{$item.comment}</td>
                                                       <td data-content="##Service##" align="center">{if $item.type_service neq ''} {$item.type_service}  {else}-----{/if}</td>
                                                   </tr>
                                                {/foreach}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                {else}
                                    <div class="err404_style mt-4 d-flex justify-content-center align-items-center flex-column">
                                        <div class='d-flex justify-content-center'>
                                            <img src='assets/images/404-294px.jpg' alt='404'>
                                        </div>
                                        <h2 class="title">##ThereAreNoPoints##</h2>

                                    </div>
                                {/if}


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <div id="ModalPublicAdd" class="modal">

        <div class="modal_custom" onclick="modalClosePassengerAdd()" id="ModalPublicContentAdd">


        </div>

    </div>
    <div id="ModalPublic"></div>
    <div class="modal_div">
        <div class="container" id="html_modal"></div>
    </div>

{literal}

    <script src="assets/js/profile.js"></script>

    <script type="text/javascript">
      $(document).ready(function () {
        $('#passengerList').DataTable();
        $('body').on('click' ,'.convertPointToCredit' , function () {
          let point= $('#point_user').val()
          if(point == ""){
            $.alert({
              title: useXmltag("convertPointToPrice"),
              icon: 'fa fa-refresh',
              content: useXmltag("AmountPointRequired"),
              rtl: true,
              type: 'red',
            });
            return false;
          }

          $.ajax({
            url: amadeusPath + 'ajax',
            type: 'POST',
            dataType: 'JSON',
            data: JSON.stringify({
                    className:'memberCredit',
                    method:'setGifPointToCreditUser',
                    point
            }),
            success: function (response) {
              $.alert({
                title: useXmltag("convertPointToPrice"),
                icon: 'fa fa-refresh',
                content: response.message,
                rtl: true,
                type: 'green',
              });
            },
            error:function(error) {
              $.alert({
                title: useXmltag("convertPointToPrice"),
                icon: 'fa fa-refresh',
                content: error.responseJSON.message,
                rtl: true,
                type: 'red',
              });
            }
          })


        });
        $('body').on('click' ,'.close_modal_passenger' , function () {
          $(".modal_custom").remove();
          $("body,html").removeClass("overflow-hidden");
        });
        $('html , body').click(() => {
          $(".profile_dropdown_custom > div").hide()
          $(".list_calender_profile").hide()
        })
      });
      function convertPointToPrice(currentTarget , point) {
        $(currentTarget).children('.bouncing-loader').removeClass("bouncing-loader-none")
        $.post(libraryPath + 'ModalCreatorProfile.php',
          {
            Method: 'ModalConvertPoint',
            passenger_id: point
          },
          function (data) {
            $('#ModalPublic').html(data);
            $("body,html").addClass("overflow-hidden");
            $(".select2").select2();
            $(currentTarget).children('.bouncing-loader').addClass("bouncing-loader-none")
          });
        $("#ModalPublic").show(700);
      }
    </script>

{/literal}
{else}
    {$objUser->redirectOut()}
{/if}

