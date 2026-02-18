





let btnDay = document.querySelectorAll(".btn-day");


btnDay.forEach(item =>{
  item.addEventListener("click", function (){
    item.classList.toggle("toggle-bg");
  })
})

$(document).ready(function(){

  $("body").delegate(".delete-item", "click", function () {
    $(this).closest('.parent-form-job,.parent-form-professional,.parent-form-education,.parent-form-language').remove();
  });



  $(document).on('click','.plus1',function(){
    clone =$(this).closest('.duplicate-form1').find('.duplicate-lang1').clone();
    clone.find('input[type="text"]').val("");
    clone.removeClass('duplicate-lang1');
    $('.duplicate-form1').append(clone);
    clone.find(".minus1").last().after('<a class="min1" href="javascript:void(0)"> <i class="delete-item">\n' +
      '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256L7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256L312.1 375z"/></svg></i></a>');
  });
  $(document).on('click','.plus2',function(){
    $(this).closest(".duplicate-form2").find('.myform2').find($('select')).select2("destroy");
    clone =$(this).closest('.duplicate-form2').find('.duplicate-lang2').clone();
    clone.find('input[type="text"]').val("");
    clone.removeClass('duplicate-lang2');
    $('.duplicate-form2').append(clone);
    $(".select2").select2();
    clone.find(".minus2").last().after('<a class="min2" href="javascript:void(0)"> <i class="delete-item">\n' +
      '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256L7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256L312.1 375z"/></svg></i></a>');
  });
  $(document).on('click','.plus3',function(){
    clone =$(this).closest('.duplicate-form3').find('.duplicate-lang3').clone();
    clone.find('input[type="text"]').val("");
    clone.removeClass('duplicate-lang3');
    clone.find('.employment-date').each(function() {
      $(this).removeAttr('id').removeClass('hasDatepicker');
      $(this).datepicker({
        changeMonth: true,
        changeYear: true,
        maxDate: 'Y/M/D',
        yearRange: "-100:+10",
        dateFormat: 'yy-mm-dd'
      });
    });
    $('.duplicate-form3').append(clone);
    clone.find(".minus3").last().after('<a class="min3" href="javascript:void(0)"> <i class="delete-item">\n' +
      '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256L7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256L312.1 375z"/></svg></i></a>');
  });

  $(document).on('click','.plus4',function(){
    $(this).closest(".duplicate-form4").find('.myform4').find($('select')).select2("destroy");
    clone =$(this).closest('.duplicate-form4').find('.duplicate-lang4').clone();
    clone.find('input[type="text"]').val("");
    clone.removeClass('duplicate-lang4');
    $('.duplicate-form4').append(clone);
    $(".select2").select2();
    clone.find(".minus4").last().after('<a class="min4" href="javascript:void(0)"> <i class="delete-item">\n' +
      '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256L7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256L312.1 375z"/></svg></i></a>');
  });


  // start js programmer

  $('#reserve-employment').validate({
    rules: {
      'employment-name': {
        required: true,
        maxlength: 255
      },
      'employment-birth': {
        required: true,
      },
      'employment-gender': {
        required: true,
      },
      'employment-married': {
        required: true,
      },
      'employment-major': {
        required: true,
        maxlength: 255
      },
      'employment-last_educational_certificate': {
        required: true,
      },
      'employment-email': {
        required: true,
        email: true
      },
      'employment-mobile': {
        required: true,
        phone: true,
        maxlength: 11
      },
      'employment-phone': {
        required: true,
        maxlength: 11
      },
      'employment-province': {
        required: true,
      },
      'employment-address': {
        required: true,
      },
      'employment-requested_job': {
        required: true,
      },
      'employment-requested_salary': {
        required: true,
      },
      'employment-cooperation_type': {
        required: true,
      },
    },
    messages: {
      'employment-name': {
        'required': useXmltag("PleaseEnterNameLastName"),
        'maxlength': useXmltag("LongNameLastNameError")
      },
      'employment-birth': {
        'required': useXmltag("DateOfBirthIsRequire"),
      },
      'employment-gender': {
        'required': useXmltag("SpecifyGender"),
      },
      'employment-married': {
        'required': useXmltag("PleaseEnterMarried"),
      },
      'employment-major': {
        'required': useXmltag("PleaseEnterMajor"),
        'maxlength': useXmltag("LongMajorError")
      },
      'employment-last_educational_certificate': {
        'required': useXmltag("PleaseEnterLastEducationalCertificate"),
      },
      'employment-email': {
        'email': useXmltag("Invalidemail"),
        'maxlength': useXmltag("Emaillong")
      },
      'employment-mobile': {
        'required': useXmltag("PleaseenterPhoneNumber"),
        'phone': useXmltag("PhoneNumberError"),
        'maxlength': useXmltag("LongPhoneNumberError")
      },
      'employment-phone': {
        'required': useXmltag("PleaseEnterPhoneEerror"),
        'maxlength': useXmltag("LongPhoneNumbersError")
      },
      'employment-province': {
        'required': useXmltag("PleaseEnterProvince"),
      },
      'employment-address': {
        'required': useXmltag("PleaseenterAddress"),
      },
      'employment-requested_job': {
        'required': useXmltag("PleaseEnterRequestedJob"),
      },
      'employment-requested_salary': {
        'required': useXmltag("PleaseEnterRequestedSalary"),
      },
      'employment-cooperation_type': {
        'required': useXmltag("PleaseEnterCooperationType"),
      },

    },
    submitHandler: function(form) {


      $("#employmentButton").html(useXmltag('Pleasewait'));
      $('#employmentButton').prop('disabled', true);
      var name = $('#employment-name').val();
      var birth = $('#employment-birth').val();
      var gender = $('#employment-gender').val();
      var military = $('#employment-military').val();
      var married = $('#employment-married').val();
      var major = $('#employment-major').val();
      var last_educational_certificate = $('#employment-last_educational_certificate').val();
      var email = $('#employment-email').val();
      var mobile = $('#employment-mobile').val();
      var phone = $('#employment-phone').val();
      var city = $('#employment-city').val();
      var address = $('#employment-address').val();
      var file = $('#employment-file').val();
      var requested_job = $('#employment-requested_job').val();
      var requested_salary = $('#employment-requested_salary').val();
      var cooperation_type = [];
      {
        $('#myDiv :checked').each(function() {
          if(cooperation_type.indexOf($(this).val()) === -1){
            cooperation_type.push($(this).val());
          }
        });
      }

      if($("input[name='education[educational_cross][]']").val()!='') {
        var experience_0 = $("input[name='experience[company_post][]']").map(function() {
          return $(this).val();
        }).get();
        var experience_1 = $("input[name='experience[company_name][]']").map(function() {
          return $(this).val();
        }).get();
        var experience_2 = $("input[name='experience[company_tell][]']").map(function() {
          return $(this).val();
        }).get();
        var experience_3 = $("input[name='experience[employment_period][]']").map(function() {
          return $(this).val();
        }).get();
        var experience_4 = $("input[name='experience[receive_salary][]']").map(function() {
          return $(this).val();
        }).get();
        var experience_5 = $("input[name='experience[reason_left][]']").map(function() {
          return $(this).val();
        }).get();
        var experience = [experience_0, experience_1, experience_2, experience_3, experience_4, experience_5];
      }else {
        var experience = null;
      }
      if($("input[name='skills[skill_name][]']").val()!='') {
        var skills_0 = $("input[name='skills[skill_name][]']").map(function() {
          return $(this).val();
        }).get();
        var skills_1 = $("select[name='skills[ability_level][]']").map(function() {
          return $(this).val();
        }).get();
        var skills = [skills_0, skills_1];
      }else {
        var skills = null;
      }
      if($("input[name='education[educational_cross][]']").val()!='') {
        var education_0 = $("input[name='education[educational_cross][]']").map(function(){return $(this).val();}).get();
        var education_1 = $("input[name='education[educational_field][]']").map(function(){return $(this).val();}).get();
        var education_2 = $("input[name='education[educational_name_institution][]']").map(function(){return $(this).val();}).get();
        var education_3 = $("input[name='education[educational_institute_location][]']").map(function(){return $(this).val();}).get();
        var education_4 = $("input[name='education[educational_start_date][]']").map(function(){return $(this).val();}).get();
        var education_5 = $("input[name='education[educational_end_date][]']").map(function(){return $(this).val();}).get();
        var education_6 = $("input[name='education[average][]']").map(function(){return $(this).val();}).get();
        var education_7 = $("input[name='education[project_title][]']").map(function(){return $(this).val();}).get();
        var education = [education_0 , education_1, education_2, education_3, education_4, education_5, education_6, education_7];
      }else {
        var education = null;
      }
      if($("input[name='languages[language_name][]']").val()!='') {
        var languages_0 = $("input[name='languages[language_name][]']").map(function(){return $(this).val();}).get();
        var languages_1 = $("select[name='languages[language_conversational_skill_level][]']").map(function(){return $(this).val();}).get();
        var languages_2 = $("select[name='languages[language_correspondence_skill_level][]']").map(function(){return $(this).val();}).get();
        var languages_3 = $("select[name='languages[language_translation_skill_level][]']").map(function(){return $(this).val();}).get();
        var languages_4 = $("select[name='languages[language_certified][]']").map(function(){return $(this).val();}).get();
        var languages = [languages_0 , languages_1 , languages_2 , languages_3 , languages_4];
      }else {
        var languages = null;
      }

// console.log($("input[name='education[educational_start_date][]']").val())
      $.post(amadeusPath + 'user_ajax.php',
        {
          name: name,
          birth: birth,
          gender: gender,
          military: military,
          married: married,
          major: major,
          last_educational_certificate: last_educational_certificate,
          email: email,
          mobile: mobile,
          phone: phone,
          city: city,
          address: address,
          file: file,
          requested_job: requested_job,
          requested_salary: requested_salary,
          cooperation_type: cooperation_type,
          experience: experience,
          skills: skills,
          education: education,
          languages: languages,
          flag: 'employment'
        },
        function(data) {

          var res = JSON.parse(data);

          if (res.success) {
            $.alert({
              title: useXmltag("reserveEmployment"),
              icon: 'fa fa-check',
              content: res.message,
              rtl: true,
              type: 'green'
            });


            $('#reserve-employment').find(':input:visible').val('');
            $('#reserve-employment').find('select').select2();

          } else {
            $.alert({
              title: useXmltag("reserveEmployment"),
              icon: 'fa fa-user',
              content: res.message,
              rtl: true,
              type: 'red'
            });
          }
          $("#employmentButton").html(useXmltag('Submitapplication'));
          $('#employmentButton').prop('disabled', false);
        })
    }
  });

  // $('#employment-birth').datepicker({
  //   numberOfMonths: 1,
  //   showButtonPanel: !0,
  //   maxDate: 'Y/M/D',
  //   beforeShow: function(n) {
  //     e(n, !0);
  //     $("#ui-datepicker-div").addClass("INH_class_Datepicker")
  //   }
  // });

  // $('.employment-date').datepicker({
  //   numberOfMonths: 1,
  //   showButtonPanel: !0,
  //   beforeShow: function(n) {
  //     e(n, !0);
  //     $("#ui-datepicker-div").addClass("INH_class_Datepicker")
  //   }
  // });

});


