{assign var="check_is_counter" value=$objUser->checkIsCounter()}
{assign var="about_user" value=$about_user}
{assign var="typeMember" value=$objFunctions->TypeUser($objSession->getUserId())}

<div class="box-style">
    <div class="box-style-padding">
        <div class="row">
            <div class="col-xl-7 d-flex flex-wrap align-items-center">
                <div class="img-profile">
                    <svg class="percent" style="--ratio: .{$profile['score_circle']};">
                        <circle cx="55" cy="55" r="55"></circle>
                        <circle cx="55" cy="55" r="55"></circle>
                    </svg>
                    {if $profile['gender'] == 'Female'}
                        <img src="assets/images/profile/woman.png" alt="profile">
                    {else}
                        <img src="assets/images/profile/man.png" alt="profile">
                    {/if}
{*                    <button class="add_img" ><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M144 288C144 226.1 194.1 176 256 176C317.9 176 368 226.1 368 288C368 349.9 317.9 400 256 400C194.1 400 144 349.9 144 288zM256 224C220.7 224 192 252.7 192 288C192 323.3 220.7 352 256 352C291.3 352 320 323.3 320 288C320 252.7 291.3 224 256 224zM362.9 64.82L373.3 96H448C483.3 96 512 124.7 512 160V416C512 451.3 483.3 480 448 480H64C28.65 480 0 451.3 0 416V160C0 124.7 28.65 96 64 96H138.7L149.1 64.82C155.6 45.22 173.9 32 194.6 32H317.4C338.1 32 356.4 45.22 362.9 64.82H362.9zM64 144C55.16 144 48 151.2 48 160V416C48 424.8 55.16 432 64 432H448C456.8 432 464 424.8 464 416V160C464 151.2 456.8 144 448 144H338.7L317.4 80H194.6L173.3 144H64z"/></svg></button>*}
                </div>
                <div class="text-profile">

                    <h2 class="title">
                        {$profile['name']} {$profile['family']}
                    </h2>
                    {if $check_is_counter eq true}
                        <p class="mb-2">
                            (
                            {$objUser->getAgencyName($profile['fk_agency_id'])}
                            -
                            {$objUser->getTypeCounterEn({$objUser->getTypeCounter($profile['fk_counter_type_id'])})}
                            )
                        </p>
                    {/if}

                    <span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M376.1 71.03c-9.375-9.375-24.56-9.375-33.94 0l-336 336c-9.375 9.375-9.375 24.56 0 33.94C11.72 445.7 17.84 448 24 448s12.28-2.344 16.97-7.031l336-336C386.3 95.59 386.3 80.41 376.1 71.03zM64 176c26.51 0 48-21.49 48-48S90.51 80 64 80C37.49 80 16 101.5 16 128S37.49 176 64 176zM320 336c-26.51 0-48 21.49-48 48s21.49 48 48 48c26.51 0 48-21.49 48-48S346.5 336 320 336z"/></svg>
                      {$profile['score']}
                    </span>
{*                    <p>##ByCompletingYourUserInformation## <br>*}
{*                        5000*}
{*                        ##YouGetPointsInTheClubMastercard##*}
{*                    </p>*}
                </div>

            </div>
            <div class="col-xl-5 mt-4 mt-xl-0">
                <div class="row h-100">

                    {if $typeMember neq 'Counter'}
                        <div class="col-6 price-profile-header">
                            <h6>##AccountBalance##</h6>
                        <span>
                         {assign var="remain_credit" value=$objUser->getCreditMember()}
                                {$remain_credit|number_format}
                        <span>##Rial##</span>
                        </span>
                            {if $smarty.post.client_id neq '239'}
                            <a onclick="profileIncreaseAccountBalance(event.currentTarget)" href="javascript:">
                                <span>##IncreaseInventory##</span>
                                <div class="bouncing-loader bouncing-loader-none">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg>
                            </a>
                            {/if}
                            <a onclick="decreaseMoneyMember(event.currentTarget ,{$profile['id']})" href="javascript:">
                                <span>##DecreaseMoney##</span>
                                <div class="bouncing-loader bouncing-loader-none">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg>
                            </a>
                        </div>
                    {/if}
                    <div class="price-profile-header">
                        {if empty($about_user)}
                            {load_presentation_object filename="user" assign="objUser"}
                            {assign var="about_user" value = $objUser->getAboutClub()}
                        {/if}
                        <h6>{$about_user['about_title_customer_club']}</h6>
                        <span>
                          {assign var="member_point"  value=$objUser->getPointOfClub()}
                            {$member_point}
                         <span>##Point##</span>
                         </span>
                        <span class='d-flex align-items-center'>
                                {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                    {$register_date = $objFunctions->DateJalali($profile['register_date'])}
                                {else}
                                    {$register_date = date('Y-m-d',strtotime($profile['register_date']))}
                                {/if}

                                ##Setupdate##: <span class='s-u-passenger-date d-flex mr-2'>{$register_date}</span>
                            </span>
                        <a href="{$smarty.const.ROOT_ADDRESS}/listPointClubUser">
                            ##ViewDetails##
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div  class="modal_div  modal_div_upload modal_show">

        <div class="container" id="html_modal_upload_pic">

        </div>

    </div>
</div>
<div id="html_modal_incearse_credit"></div>
{literal}
<script>
  function profileIncreaseAccountBalance(currentTarget) {
    $(currentTarget).children('.bouncing-loader').removeClass("bouncing-loader-none")
    $.post(libraryPath + 'ModalIncreaseAccountBalance.php', {
        Method: 'ModalShow',
        member_id: 1
      },
      function (data) {
        $("#html_modal_incearse_credit").html(data);
        $(currentTarget).children('.bouncing-loader').addClass("bouncing-loader-none")
      });
  }




  function decreaseMoneyMember(currentTarget , member_id) {
    $(currentTarget).children('.bouncing-loader').removeClass("bouncing-loader-none")
    $.post(libraryPath + 'ModalCreatorProfile.php', {
        Method: 'ModalShowDecreaseMoney',
        passenger_id: member_id
      },
      function (data) {
        $("#html_modal_incearse_credit").html(data);
        $(currentTarget).children('.bouncing-loader').addClass("bouncing-loader-none")
      });
  }



  $(document).ready(function() {
    $('body').on('click' ,'.submitRequestMoneyUser' , function (event) {
      let currentTarget = $(event.currentTarget)
      var thiss=$(this);
      // thiss.removeClass('submitRequestMoneyUser').addClass('disabled');
      console.log('runing');
      var form = $("#memberRequestedMoneyOfCredit");
      var url = form.attr("action");
      var formData = $(form).serializeArray();
      var formArray = {};
      $.each(formData, function() {
        formArray[this.name] = this.value;
      });

      var requested_amount = formArray['requested_amount'];
      var card_number = formArray['card_number'];
      // alert(card_number);
      // alert(card_number.length);


      if (requested_amount == "" ) {
        // alert('1111111');
        $.alert({
          title: useXmltag("DecreaseMoneyMemberTitle"),
          icon: 'fa fa-trash',
          content: useXmltag("PleaseEnterPriceForCredit"),
          rtl: true,
          type: 'red',
        });
      } else if (requested_amount < 1000000) {
        // alert('2222222');
        $.alert({
          title: useXmltag("DecreaseMoneyMemberTitle"),
          icon: 'fa fa-trash',
          content: useXmltag("MinimumWithdrawalAmountOneHundredThousandTomans"),
          rtl: true,
          type: 'red'
        });
      }
      else if (card_number == '') {
        // alert('333333');
        $.alert({
          title: useXmltag("DecreaseMoneyMemberTitle"),
          icon: 'fa fa-trash',
          content: useXmltag("PleaseEnterNumberCard"),
          rtl: true,
          type: 'red'
        });

      } else if (card_number.length < 16) {
        // alert('444444');
        $.alert({
          title: useXmltag("DecreaseMoneyMemberTitle"),
          icon: 'fa fa-trash',
          content: useXmltag("PleaseEnterNumberCardIncorrect"),
          rtl: true,
          type: 'red'
        });
      }
      else {
        // alert('555555');
        currentTarget.children('.bouncing-loader').removeClass("bouncing-loader-none")
        $.post(amadeusPath + 'user_ajax.php',
          {
            requested_amount: requested_amount,
            card_number: card_number,
            flag: 'UserCreditWithdrawal'
          },
          function (data) {
            console.log(currentTarget.children('.bouncing-loader').addClass("bouncing-loader-none"))
            var res = data.split(':');
            if (data.indexOf('success') > -1) {
              $.alert({
                title: useXmltag("DecreaseMoneyMemberTitle"),
                icon: 'fa fa-trash',
                content: res[1],
                rtl: true,
                type: 'green',
              });
              setTimeout(function () {
                $('#memberRequestedMoneyOfCredit')[0].reset();
              }, 1000);
              setTimeout(function() {
                location.reload()
              }, 2000);
            } else {
              $.alert({
                title: useXmltag("DecreaseMoneyMemberTitle"),
                icon: 'fa fa-trash',
                content: res[1],
                rtl: true,
                type: 'red',
              });
            }
          });
      }
    });
  });


</script>
{/literal}