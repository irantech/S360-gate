
    {load_presentation_object filename="user" assign="objUser"}
    {if $objSession->IsLogin() and $objSession->getTypeUser() eq 'counter'}
    {assign var="profile" value=$objUser->getProfileGds({$objSession->getUserId()})} {*گرفتن اطلاعات کاربر*}
    {assign var="userid" value=$objSession->getUserId()}
    {assign var="transactionCreditUser" value=$objUser->transactionCreditUser()}
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

                        <div class="box-style">
                            <div class="box-style-padding">
                                <div class="passengers_header">
                                    <h2 class="title mb-0">##InventoryTransactions##</h2>
                                </div>

                                {if !empty($transactionCreditUser)}
                                    <div>
                                        <div class="content-table table_style_parent mt-4">
                                            <table id="passengerList" class="table_style mb-3 table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>##Row##</th>
{*                                                    <th>##Row##</th>*}
                                                    <th>##Invoicenumber##</th>
                                                    <th>##Amount##(##Rial##)</th>
                                                    <th>##TypeTransaction##</th>
                                                    <th>##Description##</th>
                                                    <th>##Status##</th>
                                                    <th>##Date##</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                {assign var="number" value="1"}
                                                {foreach key=key item=item from=$transactionCreditUser}
                                                   <tr>
                                                       <td data-content="##Row##" align="center">{$number++}</td>
{*                                                       <td data-content="##Invoicenumber##" align="center">{$item.id}</td>*}
                                                       <td data-content="##Invoicenumber##" align="center">{$item.factorNumber}</td>
                                                       <td data-content="##Amount##" align="center">{$item.amount|number_format}</td>
                                                       <td data-content="##Typepayment##" dir="ltr" align="center">
                                                           {if $item.reason eq 'charge'}
                                                               ##ChargeAccount##
                                                           {elseif $item.reason eq 'buy'}
                                                               ##Buy##
                                                           {elseif $item.reason eq 'giftBuyTicket'}
                                                               ##BuyTicket##
                                                           {elseif $item.reason eq 'reagent_code_presented'}
                                                               ##GiftCodeReference##
                                                           {elseif $item.reason eq 'increase'}
                                                               ##ChargeAccount## {$smarty.const.CLIENT_NAME}
                                                           {elseif $item.reason eq 'decrease'}
                                                               ##DecreaseUser## {$smarty.const.CLIENT_NAME}
                                                           {elseif $item.reason eq 'credit_deduction'}
                                                               ##DecreaseMoneyOfCreditByMember##
                                                           {/if}
                                                       </td>
                                                       <td data-content="##Description##" dir="ltr"  align="center">{$item.comment}</td>
                                                       <td data-content="##Status##" align="center">
                                                           {if $item.status eq 'success'}
                                                               <span class='success-bg-text-with-padding-and-radius text-center'>##Successpayment##  </span>
                                                           {elseif $item.status eq 'error'}
                                                               <span class='error-bg-text-with-padding-and-radius text-center'>##ErrorPayment##  </span>
                                                           {elseif $item.status eq 'progress'}
                                                               <span class='pending-bg-text-with-padding-and-radius text-center'>##Processing##  </span>
                                                           {elseif $item.status eq 'rejectAdmin'}
                                                               <span class='error-bg-text-with-padding-and-radius text-center'>##rejectByAdmin##  </span>
                                                           {/if}
                                                       </td>
                                                       <td data-content="##Date##" align="center">
                                                           {if $item.creationDateInt neq 0}
                                                           {$objDate->jdate("Y-m-d H:i:s",$item.creationDateInt)}
                                                           {/if}
                                                       </td>
                                                   </tr>
                                                {/foreach}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!--<div class="d-flex d-md-none mt-4 flex-wrap">
                                {assign var="number" value="1"}
                                {foreach key=key item=item from=$objDetail->passengers}
                                    <div class="passenger-list-item">
                                        <div class="passenger-list-item__texts">
                                            <h2>
                                                {$item['name']} {$item['family']}
                                            </h2>
                                            <div>
                                                <p>کد ملی :     <span>{if $item['NationalCode']}{$item['NationalCode']}{else}-&#45;&#45;{/if}</span></p>
                                            </div>
                                        </div>
                                        <div class="passenger-list-item__buttons">
                                            <button onclick="modalListForEditUser({$item['id']})" ><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">&lt;!&ndash;! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. &ndash;&gt;<path d="M373.2 16.97C395.1-4.901 430.5-4.901 452.4 16.97L495 59.6C516.9 81.47 516.9 116.9 495 138.8L182.3 451.6C170.9 462.9 156.9 471.2 141.5 475.8L20.52 511.3C14.9 512.1 8.827 511.5 4.687 507.3C.5466 503.2-1.002 497.1 .6506 491.5L36.23 370.5C40.76 355.1 49.09 341.1 60.44 329.7L373.2 16.97zM429.8 39.6C420.4 30.22 405.2 30.22 395.8 39.6L341 94.4L417.6 170.1L472.4 116.2C481.8 106.8 481.8 91.6 472.4 82.23L429.8 39.6zM109.6 402.4L173.4 415.2L394.1 193.6L318.4 117L96.84 338.6L109.6 402.4zM70.51 370.2C69.08 373.2 67.88 376.3 66.93 379.5L39.63 472.4L132.4 445.1C135.7 444.1 138.8 442.9 141.8 441.5L92.86 431.7C86.53 430.4 81.58 425.5 80.31 419.1L70.51 370.2z"/></svg></button>
                                            <button onclick="modalListForDeleteUser({$item['id']})" class="PassengerDelete"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">&lt;!&ndash;! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. &ndash;&gt;<path d="M144 400C144 408.8 136.8 416 128 416C119.2 416 112 408.8 112 400V176C112 167.2 119.2 160 128 160C136.8 160 144 167.2 144 176V400zM240 400C240 408.8 232.8 416 224 416C215.2 416 208 408.8 208 400V176C208 167.2 215.2 160 224 160C232.8 160 240 167.2 240 176V400zM336 400C336 408.8 328.8 416 320 416C311.2 416 304 408.8 304 400V176C304 167.2 311.2 160 320 160C328.8 160 336 167.2 336 176V400zM310.1 22.56L336.9 64H432C440.8 64 448 71.16 448 80C448 88.84 440.8 96 432 96H416V432C416 476.2 380.2 512 336 512H112C67.82 512 32 476.2 32 432V96H16C7.164 96 0 88.84 0 80C0 71.16 7.164 64 16 64H111.1L137 22.56C145.8 8.526 161.2 0 177.7 0H270.3C286.8 0 302.2 8.526 310.1 22.56V22.56zM148.9 64H299.1L283.8 39.52C280.9 34.84 275.8 32 270.3 32H177.7C172.2 32 167.1 34.84 164.2 39.52L148.9 64zM64 432C64 458.5 85.49 480 112 480H336C362.5 480 384 458.5 384 432V96H64V432z"/></svg></button>
                                        </div>
                                    </div>
                                {/foreach}
                            </div>-->
                                {else}
                                    <div class="err404_style mt-4 d-flex justify-content-center align-items-center flex-column">
                                        <div class='d-flex justify-content-center'>
                                            <img src='assets/images/404-294px.jpg' alt='404'>
                                        </div>
                                        <h2 class="title">هیچ تراکنشی در لیست شما وجود ندارد</h2>

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
        $('body').on('click' ,'.submitPassengerUpdateFormData' , function () {
          var thiss=$(this);
          // thiss.removeClass('submitPassengerUpdateFormData').addClass('disabled');
          console.log('runing');
          var form = $("#updatePassengerFormData");
          var url = form.attr("action");
          var formData = $(form).serializeArray();
          var formArray = {};
          $.each(formData, function() {
            formArray[this.name] = this.value;
          });
          var National_Code = $('#passengerNationalCode').val();
          if (National_Code != "") {
            if (National_Code.toString().length != 10) {
              $.alert({
                title: useXmltag("UpdateProfile"),
                icon: 'fa fa-refresh',
                content: useXmltag("EnteredCationalCodeNotValid"),
                rtl: true,
                type: 'red',
              });
              error = 1;
            }else {
              var NCode = checkCodeMeli(convertNumber(National_Code));
              if (!NCode) {
                $.alert({
                  title: useXmltag("UpdateProfile"),
                  icon: 'fa fa-refresh',
                  content: useXmltag("EnteredCationalCodeNotValid"),
                  rtl: true,
                  type: 'red',
                });
                error = 1;
              }else{
                var error = '0';
              }
            }

          }else{
            var error = '0';
          }
          if (error == 0) {
            $.post(amadeusPath + 'user_ajax.php',
              {
                flag: 'PassengersUpdateModalData',
                data: formArray
              },
              function(data) {
                data = jQuery.parseJSON(data);
                console.log(data.result_status);
                if (data.result_status == 'success') {

                  $.alert({
                    title: useXmltag("UpdateProfile"),
                    icon: 'fa fa-refresh',
                    content: data.result_message,
                    rtl: true,
                    type: 'green',
                  });

                } else {

                  $.alert({
                    title: useXmltag("UpdateProfile"),
                    icon: 'fa fa-refresh',
                    content: data.result_message,
                    rtl: true,
                    type: 'red',
                  });

                }
                // $(".modal_custom").remove()
                setTimeout(function() {
                  location.reload()
                }, 2000);
              });
            // thiss.addClass('submitPassengerUpdateForm').removeClass('disabled');
          }
        });
        $('body').on('click' ,'.submitPassengerAddFormData' , function () {
          var thiss=$(this);
          // thiss.removeClass('submitPassengerAddFormData').addClass('disabled');
          console.log('runing');
          var form = $("#AddPassengerFormData");
          var url = form.attr("action");
          var formData = $(form).serializeArray();
          var formArray = {};
          $.each(formData, function() {
            formArray[this.name] = this.value;
          });
          var National_Code = $('#passengerNationalCode').val();
          if (National_Code != "") {
            if (National_Code.toString().length != 10) {
              $.alert({
                title: useXmltag("UpdateProfile"),
                icon: 'fa fa-refresh',
                content: useXmltag("EnteredCationalCodeNotValid"),
                rtl: true,
                type: 'red',
              });
              error = 1;
            }else {
              var NCode = checkCodeMeli(convertNumber(National_Code));
              if (!NCode) {
                $.alert({
                  title: useXmltag("UpdateProfile"),
                  icon: 'fa fa-refresh',
                  content: useXmltag("EnteredCationalCodeNotValid"),
                  rtl: true,
                  type: 'red',
                });
                error = 1;
              }else{
                var error = '0';
              }
            }

          }else{
            var error = '0';
          }
          if (error == 0) {
            $.post(amadeusPath + 'user_ajax.php',
              {
                flag: 'PassengersAddModalData',
                data : formArray
              },
              function (data) {
                data = jQuery.parseJSON(data);
                console.log(data.result_status);
                if (data.result_status == 'success') {

                  $.alert({
                    title: useXmltag("NewPassengerRegistration"),
                    icon: 'fa fa-refresh',
                    content: data.result_message,
                    rtl: true,
                    type: 'green',
                  });
                  // $(".modal_custom").remove();
                  setTimeout(function () {
                    location.reload()
                  }, 2000);
                  // thiss.addClass('submitPassengerAddForm').removeClass('disabled');
                } else {

                  $.alert({
                    title: useXmltag("NewPassengerRegistration"),
                    icon: 'fa fa-refresh',
                    content: data.result_message,
                    rtl: true,
                    type: 'red',
                  });
                }
              });
          }
        });
        $('body').on('click' ,'.PassengerDelete' , function () {
          var thiss=$(this);
          // thiss.removeClass('PassengerDelete').addClass('disabled');
          console.log('runing');
          var form = $("#PassengerDeleteForm");
          var url = form.attr("action");
          var formData = $(form).serializeArray();
          var formArray = {};
          $.each(formData, function() {
            formArray[this.name] = this.value;
          });
          $.post(amadeusPath + 'user_ajax.php',
            {
              flag: 'PassengersDeleteModal',
              data: formArray
            },
            function(data) {
              data = jQuery.parseJSON(data);
              console.log(data.result_status);
              if (data.result_status == 'success') {

                $.alert({
                  title: useXmltag("RecordPassengerDelete"),
                  icon: 'fa fa-refresh',
                  content: data.result_message,
                  rtl: true,
                  type: 'green',
                });
              } else {

                $.alert({
                  title: useXmltag("RecordPassengerDelete"),
                  icon: 'fa fa-refresh',
                  content: data.result_message,
                  rtl: true,
                  type: 'red',
                });
              }
              $(".modal_custom").remove()
              setTimeout(function() {
                location.reload()
              }, 1000);
            });
          // thiss.addClass('submitPassengerAddForm').removeClass('disabled');
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

      function modalListForEditUser(passenger_id) {
        $.post(libraryPath + 'ModalCreatorProfile.php',
          {
            Method: 'ModalShowEdit',
            passenger_id: passenger_id
          },
          function (data) {
            $('#ModalPublic').html(data);
            $("body,html").addClass("overflow-hidden");
            $(".select2").select2();
          });
        $("#ModalPublic").show(700);
      }
      function modalListForDeleteUser(passenger_id) {
        $.post(libraryPath + 'ModalCreatorProfile.php',
          {
            Method: 'ModalShowDelete',
            passenger_id: passenger_id
          },
          function (data) {
            $('#ModalPublic').html(data);
            $("body,html").addClass("overflow-hidden");
          });
        $("#ModalPublic").show();
      }
      function modalListForAddUser(currentTarget , member_id) {
        $(currentTarget).children('.bouncing-loader').removeClass("bouncing-loader-none")
        $.post(libraryPath + 'ModalCreatorProfile.php', {
            Method: 'ModalShowAdd',
            passenger_id: member_id
          },
          function (data) {
            $("#html_modal").html(data);
            $("body,html").addClass("overflow-hidden");
            $(currentTarget).children('.bouncing-loader').addClass("bouncing-loader-none")
          });
        $(".select2").select2();
      }
    </script>

{/literal}



{else}
    {$objUser->redirectOut()}
{/if}

