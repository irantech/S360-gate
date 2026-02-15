{load_presentation_object filename="user" assign="objUser"}
{assign var="typeMember" value=$objFunctions->TypeUser($objSession->getUserId())}
{if $objSession->IsLogin() and $objSession->getTypeUser() eq 'counter'}
    {assign var="profile" value=$objUser->getProfile({$objSession->getUserId()})} {*گرفتن اطلاعات کاربر*}
    {assign var="country_name" value=$objUser->getCountryName({$profile['passport_country_id']})}
    {assign var="userid" value=$objSession->getUserId()}

    <main>
        <section class="profile_section mt-3 mb-3 row">
            <div class="container">
                <div class="row">

                    {include file="./profileSideBar.tpl"}
                    <div class="col-lg-9">
                        {include file="./profileHead.tpl"}

                        <form class=" s-u-result-item-change" data-toggle="validator" id="UpdateUserProfile" method="post">
                            <input type="hidden" value="UpdateUserProfile" name="flag" >
                            <div class="box-style">
                                <div class="box-style-padding">
                                    <h2 class="title">##ChangePassword##</h2>


                                    <div class="form-profile">
                                        <label class="label_style">
                                            <span>##NameFaProfile##</span>
                                            <input type="text" name="name" id="name" onkeypress=" return persianLetters(event, 'name')" value="{$profile['name']}" placeholder="##NameFaProfile##">
                                        </label>
                                        <label class="label_style">
                                            <span>##FamilyFaProfile##</span>
                                            <input type="text" name="family" id="family" onkeypress=" return persianLetters(event, 'family')" value="{$profile['family']}" placeholder="##FamilyFaProfile##">
                                        </label>
                                        <label class="label_style">
                                            <span>##NameEnProfile##</span>
                                            <input type="text" name="name_en" id="name_en" onkeypress="return isAlfabetKeyFields(event, 'name_en')" value="{$profile['name_en']}" placeholder="##NameEnProfile##">
                                        </label>
                                        <label class="label_style">
                                            <span>##FamilyEnProfile##</span>
                                            <input type="text" name="family_en" id="family_en" onkeypress="return isAlfabetKeyFields(event, 'family_en')" value="{$profile['family_en']}" placeholder="##FamilyEnProfile##">
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="box_btn">
                                <button  type="submit" >##Save##</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </section>
    </main>




{literal}

    <script src="assets/js/profile.js"></script>

    <script>
      function imageMemberProfile(member_id) {
        $.post(libraryPath + 'ModalUploadPicProfile.php', {
            Method: 'ModalShow',
            passenger_id: member_id
          },
          function (data) {
            $("#html_modal_upload_pic").html(data);
          });
        $(".modal_div_upload").addClass("modal_div_active");
      }
      function modalCloseInfoImage() {
        $(".modal_show").remove();
        location.reload()
      }



      $('body').on('click' ,'.submitMemberUploadPic' , function () {
        $("#uploadImageProfileUser").validate({
          rules: {
          },
          messages: {
          },
          submitHandler: function (form) {
            console.log('sss');
            $(form).ajaxSubmit({
              type: 'POST',
              url: amadeusPath + 'user_ajax.php',
              success: function (response) {

                var res = response.split(':');

                if (response.indexOf('success') > -1) {
                  var statusType = 'green';
                } else {
                  var statusType = 'red';
                }

                $.alert({
                  title: useXmltag("SendOrderServices"),
                  icon: 'fa fa-refresh',
                  content: res[1],
                  rtl: true,
                  type: statusType
                });

                if (response.indexOf('success') > -1) {
                  $('#name').val('');
                  $('#age').val('');
                  $('#numberOfRequests').val('');
                  $('#mobile').val('');
                  $('#email').val('');
                  $('#address').val('');
                  $('#comment').val('');
                  $('#date_start').val('');
                  $('#date_end').val('');
                  $('#fileText').val('');
                  $('#file').val('');
                  $('#kind_service').val('');
                  $(".select2").select2();
                  $('#country').val('');
                  $(".selectCountry").select2();
                }

              }
            });
          },

        })
      });
    </script>
    <script src="assets/js/dropzoneProfile.js"></script>

{/literal}

{else}
    {$objUser->redirectOut()}
{/if}
