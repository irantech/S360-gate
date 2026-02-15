function sortAndRemoveDuplicates(numbers) {
    // Sort the array in ascending order
    numbers.sort((a, b) => a - b);

    // Create a new array to store unique numbers
    const uniqueNumbers = [];

    // Iterate over the sorted array
    for (let i = 0; i < numbers.length; i++) {
        // Check if the current number is different from the previous number
        if (i === 0 || numbers[i] !== numbers[i - 1]) {
            // Add the unique number to the new array
            uniqueNumbers.push(numbers[i]);
        }
    }

    return uniqueNumbers;
}
function checkAndTrigger() {
    console.log('checkAndTrigger')
    // Get the current URL
    let url = new URL(window.location.href);
    console.log('checkAndTrigger',url)
    // Check if 'goToPackage' parameter exists
    if (url.searchParams.has('goToPackage')) {
        // Trigger the click event on the button with ID 'btnFirst'
        let form = $("#editTourWithIdSameForm");
        if (form.valid()) {
            form.submit();
        }
        // Scroll to the button with ID 'btnFirst'
        document.getElementById('tourPackageEditForm').scrollIntoView();
    }
}
$(document).ready(function () {


    // Call the function to check and trigger
    setTimeout(function() {
        checkAndTrigger()
    }, 1000);










    var cover_height = ($('.cover-img-tour').height())-40
    var header = $('.header_area'),
       headerHeight = header.height(),
       treshold = 0,
       lastScroll = 0;

    // if(gdsSwitch == 'detailTour') {
    //     $(document).on('scroll', function(evt) {
    //         var newScroll = $(document).scrollTop(),
    //           diff = newScroll - lastScroll - 10;
    //         if(newScroll<cover_height){
    //         treshold = (treshold + diff > headerHeight) ? headerHeight : treshold + diff;
    //         treshold = (treshold < 0) ? 0 : treshold + 10;
    //         header.css('top', (-treshold) + 'px');
    //         lastScroll = newScroll;
    //         }else{
    //             header.css('top',(-headerHeight)+'px');
    //         }
    //     });
    //     header.addClass("position-static")
    // }


    $('.owl-accordion-day').owlCarousel({
        nav:false,
        dots:true,
        rtl:true,
        loop:false,
        navText: ["<i class='fas fa-chevron-right'></i>","<i class='fas fa-chevron-left'></i>"],
        margin:2,
        // autoplay: true,
        autoplayTimeout: 5000,
        autoplaySpeed:3000,
        responsive:{
            0:{
                items:1,
                nav:false,
            },
            600:{
                items:1,
                nav:false,
            },
            1000:{
                items:1
            }
        }
    });
    $('.owl-hotel-slider').owlCarousel({
        nav:true,
        dots:true,
        rtl:true,
        loop:true,
        navText: ["<i class='fas fa-chevron-left'></i>","<i class='fas fa-chevron-right'></i>"],
        margin:2,
        // autoplay: true,
        autoplayTimeout: 5000,
        autoplaySpeed:3000,
        responsive:{
            0:{
                items:1,
                nav:false,
            },
            600:{
                items:1,
                nav:false,
            },
            1000:{
                items:1
            }
        }
    });


    let openAccordion = document.querySelector(".open-accordion");
    let openAccordionS = document.querySelector(".open-accordion > span");
    let openAccordionI = document.querySelector(".open-accordion > i");
    if(openAccordion){
        openAccordion.addEventListener(`click`, function () {

            if (openAccordionS.innerText === `${useXmltag("OpeningAll")}`){
                openAccordionS.innerText = `${useXmltag("Closing")}`;
                // openAccordionI.classList.add('fa-light fa-lock');
                // openAccordionI.classList.remove('fa-light fa-lock-open');
            }else{
                openAccordionS.innerText = `${useXmltag("Closing")}`;
                // openAccordionI.classList.add('fa-light fa-lock-open');
                // openAccordionI.classList.remove('fa-light fa-lock');
            }
        });
    }




    const package_dates=$('[data-name="package-dates"]');

    const find = $('button.parent-date-link:not([data-capacity="0"])').first().trigger('click');

    // package_dates.find('button:first-child').trigger('click')
// malek
    if (gdsSwitch === "tours" || gdsSwitch === "resultTourLocal") {
        validateShowListTour();
    }

    //sort hotel by price or star
    $("body").delegate("#agencyRateSortSelect, #tourPriceSortSelect", 'change', function (e) {
        var selectID = $(this).attr('id');
        var selected = $(this).val();
        var current_hotel = '';
        var allTour = [];
        var temp = [];
        var current_sort_index = '';
        var current_sort_index_first = '';
        var key = '';
        var searchResult = $("#tourResult").find(".hotel-result-item");

        searchResult.each(function (index) {

            current_hotel = $(this).parent();

            if (selectID == 'agencyRateSortSelect') {

                if (current_hotel.find("#agencyRate").val() > 0){
                    current_sort_index = current_hotel.find("#agencyRate").val();
                } else {
                    current_sort_index = 0;
                }

            } else if (selectID == 'tourPriceSortSelect') {

                current_sort_index = current_hotel.find("#tourPrice").val();
                if (parseInt(current_sort_index) > 0){
                    current_sort_index = parseInt(current_sort_index.replace(/,/g, ''));
                } else {
                    current_sort_index = 0;
                }

            }

            allTour.push({
                'content': current_hotel.html(),
                'sortIndex': current_sort_index
            });
        });


        if (selected == 'asc') {

            for (var i = 0; i < parseInt(allTour.length); i++) {
                key = i;
                for (var j = i; j < parseInt(allTour.length); j++) {
                    if (allTour[j]['sortIndex'] <= allTour[key]['sortIndex']) {
                        temp = allTour[i];
                        allTour[i] = allTour[j];
                        allTour[j] = temp;
                    }
                }
            }

        } else if (selected == 'desc') {

            for (var i = 0; i < parseInt(allTour.length); i++) {
                min = allTour[i];
                key = i;
                for (var j = i; j < parseInt(allTour.length); j++) {
                    if (allTour[j]['sortIndex'] >= allTour[key]['sortIndex']) {
                        temp = allTour[i];
                        allTour[i] = allTour[j];
                        allTour[j] = temp;
                    }
                }
            }

        }

        setTimeout(function () {
            $('#tourResult').empty();
            for (i = 0; i < parseInt(allTour.length); i++) {
                // console.log(i + '======' + allTour[i]['content']);
                $("#tourResult").append('<div>' + allTour[i]['content'] + '</div>');
            }
        }, 100);

    });

    // previous rules
    // tourName: 'required',
    //   tourNameEn: 'required',
    //   tourCode: 'required',
    //   startDate: 'required',
    //   endDate: 'required',
    //   originContinent1: 'required',
    //   originCountry1: 'required',
    //   originCity1: 'required',
    //   destinationContinent1: 'required',
    //   destinationCountry1: 'required',
    //   destinationCity1: 'required'

    //insert tour
    $("#tourRegistrationForm").validate({
        rules: {
            tourName: 'required',
            tourNameEn: 'required',
            tourCode: 'required',
            startDate: 'required',
            endDate: 'required',
            originContinent1: 'required',
            originCountry1: 'required',
            originCity1: 'required',
            tourType: 'required',
            night: 'required',
            day: 'required',
            typeVehicle1 : 'required',
            airline1 : 'required',
            destinationContinent2 : 'required',
            destinationCountry2 : 'required',
            destinationCity2 : 'required',
            typeVehicle2 : 'required',
            airline2 : 'required'
        },
        messages: {},
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");
        },
        submitHandler: function (form) {

            loadingToggle($('.tour-register-button'));

            setTimeout(function(){

                $(form).ajaxSubmit({
                    type: 'POST',
                    url: amadeusPath + 'tour_ajax.php',
                    success: function (data) {

                        loadingToggle($('.tour-register-button'),false);
                        console.log(data);
                        var result = data.split(':');
                        if (data.indexOf('success') > -1) {

                            $('#fk_tour_id').val(result[3]);
                            $('#id_same').val(result[4]);
                            $('#btnFirst').addClass('displayN');
                            $('#btnSecond').removeClass('displayN');

                            if (result[2] == 'yes'){

                                $('#flagSecond').val('oneDayTourRegistration');
                                // $('.select2').select2('destroy');
                                $('.select2-num').select2('destroy');
                                $(".select2").select2();
                                $('.select2-num').select2({minimumResultsForSearch: Infinity,});
                                $('.select2-multiple-tags').select2('destroy');
                                $('.select2-multiple-tags').select2({
                                    minimumResultsForSearch: Infinity,
                                    tags: true
                                });
                                $('html, body').animate({scrollTop: $('#oneDayTour').removeClass('displayN').offset().top}, 'slow');



                            } else {


                                $.post(amadeusPath + 'tour_ajax.php',
                                   {
                                       countPackage: '1',
                                       fk_tour_id: result[3],
                                       id_same: result[4],
                                       flag: "insertRowPackage"
                                   },
                                   function (data) {
                                       $('#rowPackage').append(data);
                                       $('#countPackage').val('1');
                                       $('#btnFirst').addClass('displayNone');
                                       $(".select2").select2();
                                   });
                                $('.select2-num').select2('destroy');
                                $(".select2").select2();
                                $('.select2-num').select2({minimumResultsForSearch: Infinity,});
                                $('.select2-multiple-tags').select2('destroy');
                                $('.select2-multiple-tags').select2({
                                    minimumResultsForSearch: Infinity,
                                    tags: true
                                });
                                $('#flagSecond').val('tourPackageRegistration');
                                $('html, body').animate({scrollTop: $('#tourPackage').removeClass('displayN').offset().top}, 'slow');

                            }

                        } else {
                            loadingToggle($('.tour-register-button'),false);
                            $.alert({
                                title: useXmltag("Newtourentry"),
                                icon: 'fa fa-refresh',
                                content: result[1],
                                rtl: true,
                                type: 'red'
                            });

                        }

                    }
                });

            }, 2);





        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }


    });

    //insert one day tour OR package
    $("#tourPackageForm").validate({
        rules: {

        },
        messages: {},
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");
        },
        submitHandler: function (form) {
            loadingToggle($('.tour-register-package-button'));

            setTimeout(function(){

                let form = $('#tourPackageForm');
                let formData = form.serializeArray();
                let chunkSize = 42; // Set the number of fields to submit at once
                let currentIndex = 0;

                let typeTourWithIdSame = ($('#flagSecond').val() ==='oneDayTourRegistration') ? 'insertOneDayTour': 'insertPackageTour' ;

                $.ajax({
                    type: 'POST',
                    url: amadeusPath + 'ajax',
                    dataType: 'json',
                    data: JSON.stringify({
                        method: typeTourWithIdSame,
                        className: 'reservationTour',
                        data: formData
                    }), success: function(response) {



                        $.alert({
                            title: useXmltag("Newtourentry"),
                            icon: 'fa fa-refresh',
                            content: response.message,
                            rtl: true,
                            type: 'green'
                        });

                        // setTimeout(function () {
                        //     var url = amadeusPathByLang + "tourGallery&id=" + response.data;
                        //     window.location.href = url;
                        // }, 1000);
                        setTimeout(function () {
                            var url = amadeusPathByLang + "tourList";
                            window.location.href = url;
                        }, 1000);

                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error('Error:', textStatus, errorThrown);
                    }
                });


            }, 2);


        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }


    });

    //edit tour
    $("#editTourForm").validate({
        rules: {
            tourName: 'required',
            tourNameEn: 'required',
            tourType: 'required',
            tourCode: 'required',
            startDate: 'required',
            endDate: 'required',
            night: 'required',
            day: 'required',
            originContinent1: 'required',
            originCountry1: 'required',
            originCity1: 'required',
            destinationContinent1: 'required',
            night1: 'required',
            destinationCountry1: 'required',
            destinationCity1: 'required',
            typeVehicle1 : 'required',
            airline1 : 'required'
        },
        messages: {},
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");
        },
        submitHandler: function (form) {
            setTimeout(function(){

                $(form).ajaxSubmit({
                    type: 'POST',
                    url: amadeusPath + 'tour_ajax.php',
                    success: function (data) {

                        var result = data.split(':');
                        if (data.indexOf('success') > -1) {

                            $('#id_same').val(result[2]);
                            $('#btnFirst').addClass('displayN');
                            $('#btnSecond').removeClass('displayN');
                            $(".select2").select2();
                            $('html, body').animate({scrollTop: $('#tourPackageEdit').removeClass('displayN').offset().top}, 'slow');

                        } else {

                            $.alert({
                                title: useXmltag("Recordtourchanges"),
                                icon: 'fa fa-refresh',
                                content: result[1],
                                rtl: true,
                                type: 'red'
                            });

                        }

                    }
                });

            }, 2);

        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }


    });





    $("#changeTourPackagePricesForm").validate({
        rules: {
            // اضافه کردن rule برای بررسی حداقل یک فیلد
            customValidation: {
                required: function() {
                    return !hasAtLeastOneFieldFilled();
                }
            }
        },
        messages: {
            customValidation: useXmltag("Errorrecordinginformation")
        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            error.addClass("help-block");
            // نمایش خطا در بالای فرم
            if (element.attr("name") === "customValidation") {
                error.insertBefore($(".s-u-result-item-change"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            // بررسی مجدد قبل از ارسال
            if (!hasAtLeastOneFieldFilled()) {
                $.alert({
                    title: useXmltag("RegisteringTourPriceChanges"),
                    icon: 'fa fa-exclamation-triangle',
                    content: useXmltag("Errorrecordinginformation"),
                    rtl: true,
                    type: 'red'
                });
                return false;
            }

            // غیرفعال کردن دکمه ارسال
            $("#submitButton").prop('disabled', true).addClass('submit-disabled');
            formSubmitted = true;

            setTimeout(function(){
                $(form).ajaxSubmit({
                    type: 'POST',
                    url: amadeusPath + 'tour_ajax.php',
                    success: function (data) {
                        console.log('Response:', data);

                        var result = JSON.parse(data);

                        if (result.status === 'success') {
                            // نمایش پیام موفقیت
                            $.alert({
                                title: useXmltag("RegisteringTourPriceChanges"),
                                icon: 'fa fa-check-circle',
                                content: result[1] || 'تغییرات با موفقیت اعمال شد',
                                rtl: true,
                                type: 'green',
                                onClose: function() {
                                    $('#id_same').val(result[1]);
                                    $(".select2").select2();
                                    // رفرش صفحه برای نمایش تغییرات
                                    location.reload();
                                }
                            });

                        } else if (result.status === 'error') {
                            // نمایش پیام خطا
                            $.alert({
                                title: useXmltag("RegisteringTourPriceChanges"),
                                icon: 'fa fa-exclamation-triangle',
                                content: result[1] || 'خطا در اعمال تغییرات',
                                rtl: true,
                                type: 'red',
                                onClose: function() {
                                    // فعال کردن مجدد دکمه در صورت خطا
                                    $("#submitButton").prop('disabled', false).removeClass('submit-disabled');
                                    formSubmitted = false;
                                }
                            });

                        } else {
                            // پاسخ نامشخص
                            $.alert({
                                title: useXmltag("RegisteringTourPriceChanges"),
                                icon: 'fa fa-question-circle',
                                content: 'پاسخ نامشخص از سرور دریافت شد',
                                rtl: true,
                                type: 'orange',
                                onClose: function() {
                                    // فعال کردن مجدد دکمه در صورت خطا
                                    $("#submitButton").prop('disabled', false).removeClass('submit-disabled');
                                    formSubmitted = false;
                                }
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // خطای AJAX
                        $.alert({
                            title: useXmltag("RegisteringTourPriceChanges"),
                            icon: 'fa fa-times-circle',
                            content: 'خطا در ارتباط با سرور: ' + error,
                            rtl: true,
                            type: 'red',
                            onClose: function() {
                                // فعال کردن مجدد دکمه در صورت خطا
                                $("#submitButton").prop('disabled', false).removeClass('submit-disabled');
                                formSubmitted = false;
                            }
                        });
                    }
                });

            }, 2);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }
    });




    //insert one day tour OR package
    $("#tourPackageEditForm").validate({
        rules: {

        },
        messages: {},
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");
        },
        submitHandler: function (form) {
            loadingToggle($('.tour-edit-package-button'));
            setTimeout(function(){

                let form = $('#tourPackageEditForm');
                let formData = form.serializeArray();
                let chunkSize = 42; // Set the number of fields to submit at once
                let currentIndex = 0;

                let typeTourWithIdSame = ($('#flagSecond').val() =='oneDayTourRegistration') ? 'editOneDayTourWithIdSame': 'editPackageTourWithIdSame' ;


                $.ajax({
                    type: 'POST',
                    url: amadeusPath + 'ajax',
                    dataType: 'json',
                    data: JSON.stringify({
                        method: typeTourWithIdSame,
                        className: 'reservationTour',
                        data: formData
                    }), success: function(response) {



                        $.alert({
                            title: useXmltag("Newtourentry"),
                            icon: 'fa fa-refresh',
                            content: response.message,
                            rtl: true,
                            type: 'green'
                        });

                        setTimeout(function () {
                            // var url = amadeusPathByLang + "tourGallery&id=" + response.data;
                            var url = amadeusPathByLang + "tourList";
                            window.location.href = url;
                        }, 1000);

                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error('Error:', textStatus, errorThrown);
                    }
                });


            }, 2);


        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }


    });


    // start vote
    /*$("input[name='star']").change(function() {
        var vote = $("input[name='star']:checked").val();
        var id = $('#id').val();
        var page = $('#page').val();

        $.post(amadeusPath + 'tour_ajax.php',
            {
                vote: vote,
                id: id,
                page: page,
                flag: "userStar"
            },
            function (data) {

                var result = data.split('|');
                if(result[0] == 'SUCCESS'){

                    $('#sniper_rate_initial').val(result[2]);
                    $('#sniper_total').html(result[1]);
                    $('#sniper_average').html(result[2]);
                    $('.snippet-message').css('color','green').html('رأی شما ثبت شد، از شما سپاسگزاریم');

                } else {
                    $('.snippet-message').css('color','red').html('شما قبلا رأی داده اید، از شما سپاسگزاریم');
                }

            });

    });*/

    //insert tour gallery
    $("#galleryForm").validate({
        rules: {
            name: 'required',
            pic: 'required'
        },
        messages: {},
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");
        },
        submitHandler: function (form) {
            setTimeout(function(){

                $(form).ajaxSubmit({
                    type: 'POST',
                    url: amadeusPath + 'tour_ajax.php',
                    success: function (data) {

                        var result = data.split(':');
                        if (data.indexOf('success') > -1) {

                            $.alert({
                                title: useXmltag("Registertourgallery"),
                                icon: 'fa fa-refresh',
                                content: result[1],
                                rtl: true,
                                type: 'green'
                            });

                            setTimeout(function () {
                                location.reload();
                            }, 1000);

                        } else {

                            $.alert({
                                title: useXmltag("Registertourgallery"),
                                icon: 'fa fa-refresh',
                                content: result[1],
                                rtl: true,
                                type: 'red'
                            });

                        }

                    }
                });

            }, 2);

        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }


    });


    if($(".rate").length > 0) {
        $(".rate").rate({
            max_value: 5,
            step_size: 1,
            selected_symbol_type: 'utf8_star',
            update_input_field_name: $("#sniper_rate_value"),
            initial_value: $('#sniper_rate_initial').val(),
            change_once: true
        });
    }

    // previous rules

    // tourType: 'required',
    //   startDate: 'required',
    //   endDate: 'required',
    //   night: 'required',
    // day: 'required'

    //edit tour with idSame
    $("#editTourWithIdSameForm").validate({
        rules: {
            tourName: 'required',
            tourNameEn: 'required',
            tourCode: 'required',
            startDate: 'required',
            endDate: 'required',
            originContinent1: 'required',
            originCountry1: 'required',
            originCity1: 'required',
            destinationContinent1: 'required',
            night1: 'required',
            destinationCountry1: 'required',
            destinationCity1: 'required',
            tourType: 'required',
            night: 'required',
            day: 'required'
        },
        messages: {},
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");
        },
        submitHandler: function (form) {
            loadingToggle($('.tour-edit-button'));

            setTimeout(function(){

                $(form).ajaxSubmit({
                    type: 'POST',
                    url: amadeusPath + 'tour_ajax.php',
                    success: async function(data) {

                        var result = data.split(':');
                        if (data.indexOf('success') > -1) {

                            // Read Load in jquery
                            // Loaded #tourPackageEdit from edit page
                            await $("#tourPackagesBox").load(amadeusPathByLang + 'groupTourEdit&id=' + $('#tourIdSame').val() + " #tourPackageEdit",async ()=>{
                                await removeSelect2()
                                $('#btnFirst').addClass('displayN');
                                $('#btnSecond').removeClass('displayN');
                                $('html, body').animate({scrollTop: $('#tourPackageEdit').removeClass('displayN').offset().top}, 'slow');

                                let url = new URL(window.location.href);
                                console.log('checkAndTrigger',url)
                                // Check if 'goToPackage' parameter exists
                                if (url.searchParams.has('goToPackage')) {
                                    let goToPackageValue = url.searchParams.get('goToPackage');
                                    // Trigger the click event on the button with ID 'btnFirst'

                                    // Scroll to the button with ID 'btnFirst'
                                    document.getElementById('rowAnyPackage'+goToPackageValue).scrollIntoView();
                                }

                                loadingToggle($('.tour-edit-button'), false);
                                await initializeSelect2Search()
                            })



                        } else {
                            loadingToggle($('.tour-edit-button'), false);
                            $.alert({
                                title: useXmltag("Recordtourchanges"),
                                icon: 'fa fa-refresh',
                                content: result[1],
                                rtl: true,
                                type: 'red'
                            });

                        }



                    }
                });

            }, 2);

        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }


    });







});


// start vote
function sniperRate() {

    setTimeout(function () {

        var sniper_fk_id_page = $('#sniper_fk_id_page').val();
        var sniper_page = $('#sniper_page').val();
        var sniper_rate_value = $('#sniper_rate_value').val();


        $.post(amadeusPath + 'tour_ajax.php',
           {
               vote: sniper_rate_value,
               id: sniper_fk_id_page,
               page: sniper_page,
               flag: "agencyRate"
           },
           function (data) {

               var result = data.split('|');
               if(result[0] == 'SUCCESS'){

                   $('#sniper_rate_initial').val(result[2]);
                   $('#sniper_total').html(result[1]);
                   $('#sniper_average').html(result[2]);
                   $('.snippet-message').css('color','green').html(useXmltag("YourvotebeenrecordedThankyou"));

               } else {
                   $('.snippet-message').css('color','red').html(useXmltag("YouhavealreadyvotedThankyou"));
               }

           });
    }, 500);


}



function checkForOneDayTour(){
    var tourTypeId = $('#tourTypeId').val();
    if (!jQuery.inArray( "1", tourTypeId )){
        $('#notificationOneDayTour').removeClass('displayN');
        $('#night').val('0');
        $('#day').val('1');
    } else {
        $('#notificationOneDayTour').addClass('displayN');
        $('#night').val('');
        $('#day').val('');
    }
}

function loadingSpiner(target,status=true){
    if(status){

        target.after('<div class="ph-item-transparent spinner_div"><svg class="spinner" viewBox="0 0 50 50">\n' +
           '<circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>\n' +
           '</svg></div>');
    }else{
        target.next('.spinner_div').remove();
    }
}

///////نمایش لیست کشورها//
function fillComboCountry(row, type){
    var target=$('#' + type + 'Country' + row);
    loadingSpiner(target);
    var continent = $('#' + type + 'Continent' + row).val();
    $.post(amadeusPath + 'hotel_ajax.php',
       {
           continent: continent,
           flag: "FillComboContinent"
       },
       function (data) {
           loadingSpiner(target,false);
           target.html(data);
       })

}


function fillComboCountryByDataAttr(_this, type){
    const is_routes_changed = $('#is_routes_changed')
    if(is_routes_changed.val() == '1'){
        fillComboCountryByDataAttrInstantly(_this, type)
    }else {
        if(_this.data('previous-value') != _this.val())
            fillComboCountryByDataAttrConfirm(_this, type)
    }
}
function fillComboCountryByDataAttrConfirm(_this, type){
    $.confirm({
        theme: 'supervan' ,// 'material', 'bootstrap'
        title: useXmltag("AreYouSureWantChangeTourRoutes"),
        icon: 'fa fa-trash',
        content:  useXmltag("ByUpdateTourRoutesYouNeedToCreateNewPackage"),
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: useXmltag("Approve"),
                btnClass: 'btn-green',
                action: async function () {
                    const is_routes_changed = $('#is_routes_changed')
                    is_routes_changed.val('1')
                    fillComboCountryByDataAttrInstantly(_this, type)
                }
            },
            cancel: {
                text: useXmltag("Optout"),
                btnClass: 'btn-red',
                action: function () {

                    _this.val(_this.data('previous-value')).change()

                }

            }
        }
    });
}
function fillComboCountryByDataAttrInstantly(_this, type){
    const row = _this.attr('data-counter').replace(_this.attr('data-name'),'')
    var target=$('#' + type + 'Country' + row);
    loadingSpiner(target);
    var continent = $('#' + type + 'Continent' + row).val();
    $.post(amadeusPath + 'hotel_ajax.php',
       {
           continent: continent,
           flag: "FillComboContinent"
       },
       function (data) {
           loadingSpiner(target,false);
           target.html(data);
       })

}

///////نمایش لیست شهرها//
function fillComboCity(row, type){
    var target=$('#' + type + 'City' + row);
    loadingSpiner(target);
    var country = $('#' + type + 'Country' + row).val();
    $.post(amadeusPath + 'hotel_ajax.php',
       {
           Country: country,
           flag: "FillComboCountry"
       },
       function (data) {
           loadingSpiner(target,false);
           target.html(data);
       })

}





function fillComboCityByDataAttr(_this, type){
    const is_routes_changed = $('#is_routes_changed')
    if(is_routes_changed.val() == '1'){
        fillComboCityByDataAttrInstantly(_this, type)
    }else {
        if(_this.data('previous-value') != _this.val())
            fillComboCityByDataAttrConfirm(_this, type)
    }
}
function fillComboCityByDataAttrConfirm(_this, type){
    $.confirm({
        theme: 'supervan' ,// 'material', 'bootstrap'
        title: useXmltag("AreYouSureWantChangeTourRoutes"),
        icon: 'fa fa-trash',
        content:  useXmltag("ByUpdateTourRoutesYouNeedToCreateNewPackage"),
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: useXmltag("Approve"),
                btnClass: 'btn-green',
                action: async function () {
                    const is_routes_changed = $('#is_routes_changed')
                    is_routes_changed.val('1')
                    fillComboCityByDataAttrInstantly(_this, type)
                }
            },
            cancel: {
                text: useXmltag("Optout"),
                btnClass: 'btn-red',
                action: function () {

                    _this.val(_this.data('previous-value')).change()

                }

            }
        }
    });
}
function fillComboCityByDataAttrInstantly(_this, type){
    const row = _this.attr('data-counter').replace(_this.attr('data-name'),'')
    var target=$('#' + type + 'City' + row);
    loadingSpiner(target);
    var country = $('#' + type + 'Country' + row).val();
    $.post(amadeusPath + 'hotel_ajax.php',
       {
           Country: country,
           flag: "FillComboCountry"
       },
       function (data) {
           loadingSpiner(target,false);
           target.html(data);
       })

}

///////نمایش لیست منطقه ها//
function fillComboRegion(row, type){

    var target=$('#' + type + 'Region' + row);
    loadingSpiner(target);
    var city = $('#' + type + 'City' + row).val();
    $.post(amadeusPath + 'hotel_ajax.php',
       {
           City: city,
           flag: "FillComboCity"
       },
       function (data) {
           loadingSpiner(target,false);
           target.html(data);
       }
    )
}





function fillComboRegionByDataAttr(_this, type){
    const is_routes_changed = $('#is_routes_changed')
    if(is_routes_changed.val() == '1'){
        fillComboRegionByDataAttrInstantly(_this, type)
    }else {
        if(_this.data('previous-value') != _this.val())
            fillComboRegionByDataAttrConfirm(_this, type)
    }
}
function fillComboRegionByDataAttrConfirm(_this, type){
    $.confirm({
        theme: 'supervan' ,// 'material', 'bootstrap'
        title: useXmltag("AreYouSureWantChangeTourRoutes"),
        icon: 'fa fa-trash',
        content:  useXmltag("ByUpdateTourRoutesYouNeedToCreateNewPackage"),
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: useXmltag("Approve"),
                btnClass: 'btn-green',
                action: async function () {
                    const is_routes_changed = $('#is_routes_changed')
                    is_routes_changed.val('1')
                    fillComboRegionByDataAttrInstantly(_this, type)
                }
            },
            cancel: {
                text: useXmltag("Optout"),
                btnClass: 'btn-red',
                action: function () {

                    _this.val(_this.data('previous-value')).change()

                }

            }
        }
    });
}
function fillComboRegionByDataAttrInstantly(_this, type){
    const row = _this.attr('data-counter').replace(_this.attr('data-name'),'')
    var target=$('#' + type + 'Region' + row);
    loadingSpiner(target);
    var city = $('#' + type + 'City' + row).val();
    $.post(amadeusPath + 'hotel_ajax.php',
       {
           City: city,
           flag: "FillComboCity"
       },
       function (data) {
           loadingSpiner(target,false);
           target.html(data);
       }
    )
}


///////نمایش لیست شهرها//
function getTourCities(inputName, tourType, route){
    let thisForm = $('form[name="gds_tour"]'),
       switcher = $('input[type="radio"][name="DOM_TripMode5"]');
    if(switcher.length){
        if(switcher.val() == '2'){
            thisForm = $('form[name="gds_tour_portal"]');
        }
    }
    let target=thisForm.find('[name="tour'+inputName+'City"]');
    let category_id =  thisForm.find('[name="tourType"]').val();

    if(tourType != category_id) {
        tourType = category_id;
    }
    // loadingSpiner(target);
    let idCountry = thisForm.find('[name="tour'+inputName+'Country"]').val();
    $.post(amadeusPath + 'tour_ajax.php',
       {
           idCountry: idCountry,
           tourType: tourType,
           route: route,
           flag: "getTourCitiesAjax"
       },
       function (data) {
           console.log(data)
           // loadingSpiner(target,false);
           target.html(data);
       })

}

function getTourCountriesByType(inputName ,  route ){
    let thisForm = $('form[name="gds_tour"]'),
       switcher = $('input[type="radio"][name="DOM_TripMode5"]');
    if(switcher.length){
        if(switcher.val() == '2'){
            thisForm = $('form[name="gds_tour_portal"]');
        }
    }
    let target=thisForm.find('[name="tour'+inputName+'Country"]');
    let tourType = thisForm.find('[name="tourType"]').val();
    let idCity = '' ;
    let idCountry = '' ;
    if(inputName == 'Destination') {
        idCity = thisForm.find('[name="tourOriginCity"]').val();
        idCountry = thisForm.find('[name="tourOriginCountry"]').val();
    }
    $.post(amadeusPath + 'tour_ajax.php',
       {
           tourType: tourType,
           idCity: idCity,
           idCountry: idCountry,
           route: route,
           flag: "getTourCountriesByTypeAjax"
       },
       function (data) {
           target.html(data);
       })

}

///////نمایش لیست منطقه ها//
function getTourRegion(inputName, tourType, route){
    let thisForm = $('form[name="gds_tour"]');
    if($('input[type="radio"][name="DOM_TripMode5"]').length){
        if($('input[type="radio"][name="DOM_TripMode5"]').val() == '2'){
            thisForm = $('form[name="gds_tour_portal"]');
        }
    }
    let target=thisForm.find(`#${inputName}Region`);
    if(target.attr('type') == 'hidden'){
        return false;
    }
    loadingSpiner(target);
    let idCity = thisForm.find(`#${inputName}City`).val();
    $.post(amadeusPath + 'tour_ajax.php',
       {
           idCity: idCity,
           tourType: tourType,
           route: route,
           flag: "getTourRegionAjax"
       },
       function (data) {
           loadingSpiner(target,false);
           target.html(data).select2();
       })
}


///////نمایش لیست ایرلاین ها//
function listAirline(row){
    var target=$('#airline' + row);
    loadingSpiner(target);
    var  typeVehicle = $('#typeVehicle' + row).val();

    $.post(amadeusPath + 'hotel_ajax.php',
       {
           type_of_vehicle: typeVehicle,
           flag: "listTransportCompanies"
       },
       function (data) {
           loadingSpiner(target,false);
           target.html(data);
       })
}
function listAirlineByDataAttr(_this){
    const row = _this.attr('data-counter').replace(_this.attr('data-name'),'')
    var target=$('#airline' + row);
    loadingSpiner(target);
    var  typeVehicle = $('#typeVehicle' + row).val();

    $.post(amadeusPath + 'hotel_ajax.php',
       {
           type_of_vehicle: typeVehicle,
           flag: "listTransportCompanies"
       },
       function (data) {
           loadingSpiner(target,false);
           target.html(data);
       })
}
function initializeSelect2Search() {
    $('.select2').select2()
}
function removeSelect2(){
    if ($('.select2').data('select2')) {
        $('.select2.select2-hidden-accessible').select2('destroy')
    }
}
function insertRowPackage() {

    var fk_tour_id = $('#fk_tour_id').val();
    var id_same = $('#id_same').val();
    var count = $('#countPackage').val();
    count = parseInt(count)+1;
    $.post(amadeusPath + 'tour_ajax.php',
       {
           countPackage: count,
           fk_tour_id: fk_tour_id,
           id_same: id_same,
           flag: "insertRowPackage"
       },
       function (data) {
           $('#rowPackage').append(data);
           $('#countPackage').val(count);


           reIndexPackages();

       });

}

function deleteRowPackage(row) {
    var count = $('#countPackage').val();
    count = parseInt(count)-1;
    $('#countPackage').val(count);
    $('#rowAnyPackage' + row).remove();
    reIndexPackages();
}

function deleteRoomPackage(row , bedCount) {
    $('#customRoomPackage' + row + 'R' + bedCount).remove();
    $("#modal" + row +" select option[value='"+ bedCount + "']").attr("disabled","");
}


function deleteRowRout(row, typeRow) {

    var count = $('#countRowAnyRout').val();
    count = parseInt(count)-1;
    $('#countRowAnyRout').val(count);

    if (typeRow=='rowRout'){
        var countRowAnyDeptRout = $('#countRowAnyDeptRout').val();
        countRowAnyDeptRout = parseInt(countRowAnyDeptRout)-1;
        $('#countRowAnyDeptRout').val(countRowAnyDeptRout);

    } else if (typeRow=='rowReturnRoute') {
        var countRowAnyReturnRout = $('#countRowAnyReturnRout').val();
        countRowAnyReturnRout = parseInt(countRowAnyReturnRout)-1;
        $('#countRowAnyReturnRout').val(countRowAnyReturnRout);
    }

    $('#rowAnyRout' + row).remove();
}
async function insertRowRoutConfirm(typeRow) {
    $.confirm({
        theme: 'supervan' ,// 'material', 'bootstrap'
        title: useXmltag("AreYouSureWantChangeTourRoutes"),
        icon: 'fa fa-trash',
        content:  useXmltag("ByUpdateTourRoutesYouNeedToCreateNewPackage"),
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: useXmltag("Approve"),
                btnClass: 'btn-green',
                action: async function () {
                    const is_routes_changed = $('#is_routes_changed')
                    is_routes_changed.val('1')
                    insertRowRoutInstantly(typeRow)
                }
            },
            cancel: {
                text: useXmltag("Optout"),
                btnClass: 'btn-red',
                action: function () {

                }

            }
        }
    });
}
async function insertRowRoutInstantly(typeRow) {

    var count = $('#countRowAnyRout').val()
    count = parseInt(count)
    var number = 0
    var countRowAnyDeptRout = $('#countRowAnyDeptRout').val()
    var countRowAnyReturnRout = $('#countRowAnyReturnRout').val()
    if (typeRow == 'rowRout') {
        countRowAnyDeptRout = parseInt(countRowAnyDeptRout)
        var number = countRowAnyDeptRout
    } else if (typeRow == 'rowReturnRoute') {
        countRowAnyReturnRout = parseInt(countRowAnyReturnRout) + 1
        var number = countRowAnyReturnRout
    }


    await $.post(amadeusPath + 'tour_ajax.php',
       {
           countRowAnyRout: count,
           number: number,
           typeRow: typeRow,
           flag: 'listRoutForTour',
       },
       async function(data) {
           await $('#' + typeRow).append(data)


           $('#countRowAnyDeptRout').val(countRowAnyDeptRout)
           $('#countRowAnyReturnRout').val(countRowAnyReturnRout)

           if (typeRow == 'rowReturnRoute' && countRowAnyReturnRout != 0) {
               $('#btnReturnRoute').addClass('displayN')
           }


       })

    reIndexRoutes();


}
async function insertRowRout(typeRow) {
    const is_routes_changed = $('#is_routes_changed')
    if(is_routes_changed.val() == '1'){
        insertRowRoutInstantly(typeRow)
    }else {
        insertRowRoutConfirm(typeRow)
    }
}
async function reIndexRoutes() {
    const all_routes=$('.route_box')
    let max_count=0;
    all_routes.each(function(index){
        index=index+1
        max_count=index;
        $(this).attr('id','rowAnyRout'+index)

        $(this).find('[data-name="remove-btn"]')
           .attr('onclick',"removeRowRout('"+index+"')")


        $(this).find('[data-name="title-counter"]')
           .text(useXmltag("Destination")+' '+(index))


        $(this).find('.change_counter_js').each(function() {
            const _this=$(this);
            const attrs=$(this).data('values').split(',')
            attrs.forEach(item=>{
                _this.attr(item,_this.data('name')+index)
            })
        })
        $(this).find('[data-name="tourTitle"]').val('dept')
        if(index === all_routes.length){
            $(this).find('[data-name="tourTitle"]').val('return')
        }
    })
    $('#countRowAnyRout').val(max_count)
    await removeSelect2();
    await initializeSelect2Search();
}
async function reIndexPackages() {
    const all_packages=$('.package-box')
    let max_count=0;
    all_packages.each(function(index){
        index=index+1
        max_count=index;
        $(this).attr('id','rowAnyPackage'+index)

        $(this).find('.remove-package-box')
           .attr('onclick',"deleteRowPackage('"+index+"')")


        $(this).find('[data-name="title-counter"]')
           .text(useXmltag("Package")+' '+(index))


        $(this).find('.change_counter_js').each(function() {
            const _this=$(this);
            const attrs=$(this).data('values').split(',')
            attrs.forEach(item=>{
                _this.attr(item,_this.data('name')+index)
            })
        })
        $(this).find('.each-package-hotel').each(function(hotel_index) {
            const _this=$(this);
            _this.find('.change_counter_js').each(function() {
                const _this_hotel_item=$(this);
                const attrs=$(this).data('values').split(',')
                attrs.forEach(item=>{
                    _this_hotel_item.attr(item,_this_hotel_item.data('name')+(index)+(hotel_index))
                })
            })
        })


    })

    await removeSelect2();
    await initializeSelect2Search();
}

function removeRowRout(index_number) {
    const is_routes_changed = $('#is_routes_changed')
    const value=is_routes_changed.val()
    if(value === '1'){
        removeRowRoutInstantly(index_number)
    }else {
        removeRowRoutConfirm(index_number)
    }
}
function removeRowRoutConfirm(index_number) {
    $.confirm({
        theme: 'supervan' ,// 'material', 'bootstrap'
        title: useXmltag("AreYouSureWantChangeTourRoutes"),
        icon: 'fa fa-trash',
        content:  useXmltag("ByUpdateTourRoutesYouNeedToCreateNewPackage"),
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: useXmltag("Approve"),
                btnClass: 'btn-green',
                action: async function () {
                    const is_routes_changed = $('#is_routes_changed')
                    is_routes_changed.val('1')
                    removeRowRoutInstantly(index_number)
                }
            },
            cancel: {
                text: useXmltag("Optout"),
                btnClass: 'btn-red',
                action: function () {

                }

            }
        }
    });
}
function removeRowRoutInstantly(index_number) {

    $('#rowAnyRout'+index_number).remove()


    var count = $('#countRowAnyRout').val();
    count = parseInt(count)-1;

    var countRowAnyDeptRout = parseInt($('#countRowAnyDeptRout').val());
    var countRowAnyReturnRout = $('#countRowAnyReturnRout').val();
    countRowAnyDeptRout = parseInt(countRowAnyDeptRout)-1;



    $('#countRowAnyRout').val(count);
    count = parseInt($('#countRowAnyRout').val());
    $('#countRowAnyDeptRout').val(countRowAnyDeptRout);
    $('#countRowAnyReturnRout').val(countRowAnyReturnRout);



    reIndexRoutes();




}



function submitSearchTourLocal(local = true,_this=null) {


    let thisForm = $('form[name="gds_tour"]'),
       is_special=thisForm.find("#is_special").val(),
       originCountry = thisForm.find("#tourOriginCountry").val(),
       originCity = thisForm.find("#tourOriginCity").val(),
       originRegion = thisForm.find("#tourOriginRegion").val(),
       destinationCountry = thisForm.find("#tourDestinationCountry").val(),
       destinationCity = thisForm.find("#tourDestinationCity").val(),
       destinationRegion = thisForm.find("#tourDestinationRegion").val(),
       startDate = thisForm.find("#tourStartDate").val(),
       tourType = thisForm.find("#tourType").val();
    if(!local){
        thisForm = $('form[name="gds_tour_portal"]');
        originCountry = thisForm.find("#tourOriginCountryPortal").val();
        originCity = thisForm.find("#tourOriginCityPortal").val();
        originRegion = thisForm.find("#tourOriginRegionPortal").val();
        destinationCountry = thisForm.find("#tourDestinationCountryPortal").val();
        destinationCity = thisForm.find("#tourDestinationCityPortal").val();
        destinationRegion = thisForm.find("#tourDestinationRegionPortal").val();
        startDate = thisForm.find("#tourStartDatePortal").val();
    }
    var route = `${amadeusPathByLang}resultTourLocal`;

    if (tourType == ""){ tourType = 'all';}
    if (startDate == "") {
        $.alert({
            title:  useXmltag("Tourreservation"),
            icon: 'fa fa-cart-plus',
            content: useXmltag("Pleaseenterrequiredfields"),
            rtl: true,
            type: 'red'
        });
        return false;
    }
    let originPart = originCountry;
    if (originCity != undefined){
        originPart += `-${originCity}`;
    }
    if(originRegion != undefined && originRegion != 'all'){
        originPart += `-${originRegion}`;
    }

    let destinationPart = destinationCountry;

    if (destinationCity != undefined){
        destinationPart += `-${destinationCity}`;
    }
    if (destinationRegion != undefined){
        destinationPart += `-${destinationRegion}`;
    }

    url = `${route}/${originPart}/${destinationPart}/${startDate}/${tourType}/${is_special}`
    // console.log(url);
    // console.log({
    //     'thisForm' : thisForm,
    //     'originCity' : originCity,
    //     'originCountry' :originCountry ,
    //     'originRegion' :originRegion ,
    //     'destinationCountry' :destinationCountry ,
    //     'destinationCity' :destinationCity ,
    //     'destinationRegion' :destinationRegion ,
    //     'startDate' :startDate ,
    //     'tourType' :tourType
    // });
    // return false;
    if(_this && _this.length){
        loadingToggle(_this)
    }
    window.location.href = url;
}



//////////حذف منطقی پکیج تور///////
function logicalDeletionPackage(id)
{
    $.confirm({
        theme: 'supervan' ,// 'material', 'bootstrap'
        title: useXmltag("Removechanges"),
        icon: 'fa fa-trash',
        content:  useXmltag("Areyousureyouwantdeletechanges"),
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: useXmltag("Approve"),
                btnClass: 'btn-green',
                action: function () {
                    $.post(amadeusPath + 'tour_ajax.php',
                       {
                           id: id,
                           flag: 'deletionPackage'
                       },
                       function (data) {

                           var result = data.split(':');
                           if (data.indexOf('success') > -1)
                           {

                               $.alert({
                                   title: useXmltag("Removechanges"),
                                   icon: 'fa fa-refresh',
                                   content: result[1],
                                   rtl: true,
                                   type: 'green'
                               });

                               setTimeout(function () {
                                   location.reload();
                               }, 1000);

                           }else {

                               $.alert({
                                   title: useXmltag("Removechanges"),
                                   icon: 'fa fa-refresh',
                                   content: result[1],
                                   rtl: true,
                                   type: 'red'
                               });

                           }

                       });
                }
            },
            cancel: {
                text: useXmltag("Optout"),
                btnClass: 'btn-orange'
            }
        }
    });
}


//////////حذف منطقی پکیج تور///////
function logicalDeletionGroupPackage(idSame, numberPackage)
{
    $.confirm({
        theme: 'supervan' ,// 'material', 'bootstrap'
        title: useXmltag("Removechanges"),
        icon: 'fa fa-trash',
        content: useXmltag("Areyousureyouwantdeletechanges"),
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: useXmltag("Approve"),
                btnClass: 'btn-green',
                action: function () {
                    $.post(amadeusPath + 'tour_ajax.php',
                       {
                           idSame: idSame,
                           numberPackage: numberPackage,
                           flag: 'deletionGroupPackage'
                       },
                       function (data) {

                           var result = data.split(':');
                           if (data.indexOf('success') > -1)
                           {

                               $.alert({
                                   title: useXmltag("Removechanges"),
                                   icon: 'fa fa-refresh',
                                   content: result[1],
                                   rtl: true,
                                   type: 'green'
                               });

                               let url = new URL(window.location.href);

                               // Add or update the query parameter
                               url.searchParams.set('goToPackage', Number(numberPackage)-1);

                               // Update the browser's URL without reloading the page
                               window.history.replaceState(null, '', url.toString());

                               // Set a timeout to reload the page after 1 second (1000 milliseconds)
                               setTimeout(function() {
                                   location.reload();
                               }, 1000);

                           }else {

                               $.alert({
                                   title: useXmltag("Removechanges"),
                                   icon: 'fa fa-refresh',
                                   content: result[1],
                                   rtl: true,
                                   type: 'red'
                               });

                           }

                       });
                }
            },
            cancel: {
                text: useXmltag("Optout"),
                btnClass: 'btn-orange'
            }
        }
    });
}
function logicalDeletionGroupPackageByTourId(tour_id, numberPackage)
{
    $.confirm({
        theme: 'supervan' ,// 'material', 'bootstrap'
        title: useXmltag("Removechanges"),
        icon: 'fa fa-trash',
        content: useXmltag("Areyousureyouwantdeletechanges"),
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: useXmltag("Approve"),
                btnClass: 'btn-green',
                action: function () {
                    $.post(amadeusPath + 'tour_ajax.php',
                       {
                           tour_id: tour_id,
                           numberPackage: numberPackage,
                           flag: 'deletionGroupPackageByTourId'
                       },
                       function (data) {

                           var result = data.split(':');
                           if (data.indexOf('success') > -1)
                           {

                               $.alert({
                                   title: useXmltag("Removechanges"),
                                   icon: 'fa fa-refresh',
                                   content: result[1],
                                   rtl: true,
                                   type: 'green'
                               });

                               setTimeout(function () {
                                   location.reload();
                               }, 1000);

                           }else {

                               $.alert({
                                   title: useXmltag("Removechanges"),
                                   icon: 'fa fa-refresh',
                                   content: result[1],
                                   rtl: true,
                                   type: 'red'
                               });

                           }

                       });
                }
            },
            cancel: {
                text: useXmltag("Optout"),
                btnClass: 'btn-orange'
            }
        }
    });
}


//////////حذف منطقی مسیر///////
function logicalDeletionRout(id)
{
    $.confirm({
        theme: 'supervan' ,// 'material', 'bootstrap'
        title: useXmltag("Removechanges"),
        icon: 'fa fa-trash',
        content: useXmltag("Areyousureyouwantdeletechanges"),
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: useXmltag("Approve"),
                btnClass: 'btn-green',
                action: function () {
                    $.post(amadeusPath + 'tour_ajax.php',
                       {
                           id: id,
                           flag: 'deletionRout'
                       },
                       function (data) {

                           var result = data.split(':');
                           if (data.indexOf('success') > -1)
                           {

                               $.alert({
                                   title: useXmltag("Removechanges"),
                                   icon: 'fa fa-refresh',
                                   content: result[1],
                                   rtl: true,
                                   type: 'green'
                               });

                               setTimeout(function () {
                                   location.reload();
                               }, 1000);

                           }else {

                               $.alert({
                                   title: useXmltag("Removechanges"),
                                   icon: 'fa fa-refresh',
                                   content: result[1],
                                   rtl: true,
                                   type: 'red'
                               });

                           }

                       });
                }
            },
            cancel: {
                text: useXmltag("Optout"),
                btnClass: 'btn-orange'
            }
        }
    });
}


function selectTour(id, startDate, endDate) {
    $('#startDate').val(startDate);
    $('#endDate').val(endDate);

    $("#container").children().each(function(n, i) {
        var divId = this.id;
        $('#' + divId).children().removeClass('scrollhereactivelist');
        $('#' + divId).children().addClass('scrollherelist');
    });

    $('#selectTour-' + id).children().removeClass('scrollherelist');
    $('#selectTour-' + id).children().addClass('scrollhereactivelist');
}



function sendUserCommentsForm(){

    $("#messageInfo").html('');
    var error = 0;
    var comments = $('#comments').val();
    var fullName = $('#fullName').val();
    var email = $('#email').val();
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

    if (fullName == '' || email == '' || comments == '') {
        $("#messageInfo").css('color','red').html(useXmltag("Pleaseenteryourfulldetails"));
        error = 1;
    } else if (!emailReg.test(email)) {
        $("#messageInfo").css('color','red').html(useXmltag("Theenteredemailformatnotcorrect"));
        error = 1;
    }

    if (error == 0){

        $.ajax({
            type: 'post',
            url: amadeusPath + 'tour_ajax.php',
            data: $('#userCommentsForm').serialize(),
            success: function (data) {
                $('#userCommentsForm')[0].reset();
                if(data == 'SUCCESS'){

                    $('#messageInfo').css('color','green').html(useXmltag("YourcommenthasbeenregisteredThankyou"));

                } else {
                    $('#messageInfo').css('color','red').html(useXmltag("TherewasproblemregisteringyourcommentPleaseagain"));
                }

            }
        });

    }

}


function setParentIdUserComments(id) {
    $('#parent_id').val(id);
    $('html,body').animate({ scrollTop: $('#userCommentsForm').offset().top - 100 }, 'slow');
}

function calculatePricesTour(packageId, nameSelectCountPassengers) {


    var totalPrice = 0;
    var totalPrePaymentPrice = 0;
    var totalOriginPrice = 0;
    var totalPriceA = 0;
    var prepaymentPercentage = parseInt($('#prepaymentPercentage').val());
    var countPackage = parseInt($('#countPackage').val());
    var selectPackage = $('#selectPackage').val();
    //var selectDate = $('#selectDate').val();
    var selectDate = $('.active_col_today .lowest-date span').text();
    var prepaymentPercentageSpan = $('span[data-name="prepaymentPercentageValue"]');
    var currencyTitleFa = $('#currencyTitleFa').val();

    if (selectDate == '') {
        $.alert({
            title: useXmltag("Tourreservation"),
            icon: 'fa fa-refresh',
            content: useXmltag("Pleaseselectyourtourdatefirst"),
            rtl: true,
            type: 'red'
        });
        return false;
    }

    var COUNT_ALL_ROOM = 0;
    var countRoom = '';
    var passengerCount = 0;
    var passengerCountADT = 0;
    var passengerCountCHD = 0;
    var passengerCountINF = 0;
    var error = 0;
    var countAllRoom = 0;
    for (var i = 1; i <= countPackage; i++) {

        if (selectPackage == 'first'){
            var isBook = 'yes';
            $('#selectPackage').val('');
        } else {
            var isBook = $('#isBook' + i).val();
        }



        var countAnyRow = 0;
        for (var n = 1; n <= 6; n++) {


            var elementCountPassengers = $('#' + nameSelectCountPassengers + n + i);
            if (elementCountPassengers.val() > 0 && isBook == 'yes') {

                $('#isBook' + i).val('yes');
                $('#packageId').val(packageId);

                var price = parseInt($('#' + 'price' + n + i).val());

                var prePaymentPrice = parseInt($('#' + 'prePaymentPrice' + n + i).val());

                var originPrice = parseInt($('#' + 'originPrice' + n + i).val());
                var count = parseInt(elementCountPassengers.val());
                var priceA = parseInt($('#' + 'priceA' + n + i).val());

                countRoom = countRoom + n + ':' + count + '|' ;
                if (n == 2 || n == 3){ count = count * n; }
                totalPrice = totalPrice + (price * count);
                console.log(prePaymentPrice);
                if(prePaymentPrice != totalPrice){
                    totalPrePaymentPrice = totalPrePaymentPrice + (prePaymentPrice * count);
                }
                totalOriginPrice = totalOriginPrice + (originPrice * count);
                if (priceA > 0){
                    totalPriceA = totalPriceA + (priceA * count);
                }
                passengerCount = passengerCount + count;

                if (n == 1 || n == 2 || n == 3) {
                    passengerCountADT = passengerCountADT + count;
                } else if (n == 4){
                    passengerCountCHD = passengerCountCHD + count;
                } else if (n == 5 || n == 6){
                    passengerCountINF = passengerCountINF + count;
                }

            } else if (elementCountPassengers.val() > 0  && isBook != 'yes') {
                error++;
                elementCountPassengers.val('0');

            } else if (elementCountPassengers.val() == '0'){
                countAllRoom++;
                countAnyRow++;

            } else {
                elementCountPassengers.children("option:selected").removeAttr('selected');
                elementCountPassengers.find('option:eq(0)').prop('selected', true);
            }
        }

        if (countAnyRow == 6){
            $('#isBook' + i).val('');
        }


    }



    var packageCounter=i-1;
    var roomCounter=n-1;

    if (countAllRoom == packageCounter*roomCounter){
        $('#selectPackage').val('first');
    }
    if (error > 0){
        $.alert({
            title: useXmltag("Packageselection"),
            icon: 'fa fa-refresh',
            content: useXmltag("Youhaveselectedanotherpackagepeopleselectedpreviouspackage"),
            rtl: true,
            type: 'red'
        });
    }

    var paymentPrice = totalPrice;
    $('#passengerCount').val(passengerCount);
    $('#passengerCountADT').val(passengerCountADT);
    $('#passengerCountCHD').val(passengerCountCHD);
    $('#passengerCountINF').val(passengerCountINF);
    $('#countRoom').val(countRoom);

    $('#totalPrice').val(totalPrice);

    if(totalPrePaymentPrice > 0){
        prepaymentPercentageSpan.removeClass('d-none').addClass('d-flex');
        prepaymentPercentageSpan.find('span').html(addCommas(totalPrePaymentPrice));
    }else{
        prepaymentPercentageSpan.removeClass('d-flex').addClass('d-none');
        prepaymentPercentageSpan.find('span').html(0);
    }


    $('#totalOriginPrice').val(totalOriginPrice);
    $('#totalPriceA').val(totalPriceA);
    $('#paymentPrice').val(paymentPrice);
    if (totalPriceA > 0){
        // $('#showTotalPrice').html('<i>' + addCommas(totalPrice) + '</i>' + useXmltag('Rial')  + '<i>' + totalPriceA + '</i>' + ' ' + currencyTitleFa);
        $('.pricing-table .amount').html('<i>' + addCommas(totalPrice) + '</i>' + useXmltag('Rial')  + '<i>' + totalPriceA + '</i>' + ' ' + currencyTitleFa);

    } else {
        // $('#showTotalPrice').html('<i>' + addCommas(totalPrice) + '</i>' + useXmltag('Rial'));
        $('.pricing-table .amount').html('<i>' + addCommas(totalPrice) + '</i>' + useXmltag('Rial'));

    }
    $('#showPaymentPrice').html('<i>' + addCommas(paymentPrice) + '</i>' + useXmltag('Rial'));


}



function calculatePricesOnDayTour(isResponsive) {

    //var selectDate = $('#selectDate').val();
    var selectDate = $('.active_col_today .lowest-date span').text();
    if (selectDate == '') {
        $.alert({
            title:  useXmltag("Tourreservation"),
            icon: 'fa fa-refresh',
            content: useXmltag("Pleaseselectyourtourdatefirst"),
            rtl: true,
            type: 'red'
        });
        return false;
    }

    if (isResponsive == 'yes'){
        var aCount = parseInt($('#adultCountResponsive').val());
        var cCount = parseInt($('#childCountResponsive').val());
        var iCount = parseInt($('#infantCountResponsive').val());
        $('#adultCountOneDayTour').val(aCount);
        $('#childCountOneDayTour').val(cCount);
        $('#infantCountOneDayTour').val(iCount);
    }

    var prepaymentPercentage = parseInt($('#prepaymentPercentage').val());
    var adultPriceR = parseInt($('#adultPriceOneDayTourR').val());
    var adultCount = parseInt($('#adultCountOneDayTour').val());
    var childPriceR = parseInt($('#childPriceOneDayTourR').val());
    var childCount = parseInt($('#childCountOneDayTour').val());
    var infantPriceR = parseInt($('#infantPriceOneDayTourR').val());
    var infantCount = parseInt($('#infantCountOneDayTour').val());

    var passengerCount = 0;
    var totalPrice = 0;
    if (adultCount > 0){

        passengerCount = passengerCount + adultCount;
        totalPrice = totalPrice + (adultCount * adultPriceR);

        if (childCount > 0){
            passengerCount = passengerCount + childCount;
            totalPrice = totalPrice + (childCount * childPriceR);
        }

        if (infantCount > 0){
            passengerCount = passengerCount + infantCount;
            totalPrice = totalPrice + (infantCount * infantPriceR);
        }

    } else {
        $.alert({
            title:  useXmltag("Tourreservation"),
            icon: 'fa fa-refresh',
            content: useXmltag("Pleaseselectatleastoneadult"),
            rtl: true,
            type: 'red'
        });
        return false;
    }


    if (passengerCount > 9){

        $.alert({
            title:  useXmltag("Tourreservation"),
            icon: 'fa fa-refresh',
            content: useXmltag("Thenumberpeopleyouchooseshouldthanpeople"),
            rtl: true,
            type: 'red'
        });
        return false;

    }


    setTimeout(function () {

        var paymentPrice = Math.round((prepaymentPercentage*totalPrice)/100);

        $('#passengerCount').val(passengerCount);
        $('#totalPrice').val(totalPrice);
        $('#paymentPrice').val(paymentPrice);
        $('#showTotalPrice').html('<i>' + addCommas(totalPrice) + '</i>' + useXmltag('Rial'));
        $('#showPaymentPrice').html('<i>' + addCommas(paymentPrice) + '</i>' + useXmltag('Rial'));

    }, 100);



}

function reserveTour() {

    var typeTourReserve = $('#typeTourReserve').val();
    var selectDate = $('.active_col_today .lowest-date span').text();
    if (selectDate == ''){
        $.alert({
            title:  useXmltag("Tourreservation"),
            icon: 'fa fa-refresh',
            content: useXmltag("Pleaseselectyourtourdatefirst"),
            rtl: true,
            type: 'red'
        });
        error = 1;
        return false;
    }

    if (typeTourReserve == 'oneDayTour'){

        var error = 0;
        var passengerCount = parseInt($('#passengerCount').val());
        if (passengerCount == 0){
            $.alert({
                title:  useXmltag("Tourreservation"),
                icon: 'fa fa-refresh',
                content: useXmltag("Pleasereserveyourtournumber"),
                rtl: true,
                type: 'red'
            });
            error = 1;
            return false;
        }

        setTimeout(function () {
            if (error==0){

                $('#img').show();
                $('#buttonReserve').attr('disabled', 'disabled').css('opacity', '0.5').css('cursor', 'progress').html(useXmltag("Pending"));

                $.post(amadeusPath + 'hotel_ajax.php',
                   {
                       flag: 'CheckedLogin'
                   },
                   function (data) {

                       if (data.indexOf('successLoginHotel') > -1) {

                           BuyTourWithoutRegister();

                       } else if (data.indexOf('errorLoginHotel') > -1) {

                           $('#noLoginBuy').val(useXmltag("Bookingwithoutregistration"));
                           var isShowLoginPopup = $('#isShowLoginPopup').val();
                           var useTypeLoginPopup = $('#useTypeLoginPopup').val();
                           if (isShowLoginPopup == '' || isShowLoginPopup == '1'){
                               $("#login-popup").trigger("click");
                           } else {
                               popupBuyNoLogin(useTypeLoginPopup);
                           }

                       }

                   });

            }
        }, 2000);




    } else if (typeTourReserve == 'noOneDayTour'){



        var error = 0;
        var passengerCount = parseInt($('#passengerCount').val());
        if (passengerCount == 0){
            $.alert({
                title:  useXmltag("Tourreservation"),
                icon: 'fa fa-refresh',
                content: useXmltag("Pleasereserveyourpackage"),
                rtl: true,
                type: 'red'
            });
            error = 1;
            return false;
        }
        /*$('input[name^="passengerCountAnyRout"]').each(function(i){
            var count = parseInt($(this).val());
            if (passengerCount != count){
                $.alert({
                    title: ' useXmltag(Tourreservation)',
                    icon: 'fa fa-refresh',
                    content: 'لطفا تعداد افراد انتخابی برای اقامت در هر شهر یکی باشد. ',
                    rtl: true,
                    type: 'red'
                });
                error = 1;
                return false;
            }
        });*/
        $('#passengerCount').val(passengerCount);

        setTimeout(function () {

            $('#img').show();
            $('#buttonReserve').attr('disabled', 'disabled').css('opacity', '0.5').css('cursor', 'progress').html(useXmltag("Pending"));

            if (error == 0){

                $.post(amadeusPath + 'hotel_ajax.php',
                   {
                       flag: 'CheckedLogin'
                   },
                   function (data) {

                       if (data.indexOf('successLoginHotel') > -1) {

                           BuyTourWithoutRegister();

                       } else if (data.indexOf('errorLoginHotel') > -1) {

                           $('#noLoginBuy').val(useXmltag("Bookingwithoutregistration"));
                           $("#login-popup").trigger("click");

                       }

                   });


            }

        }, 2000);


    } else {
        $.alert({
            title:  useXmltag("Tourreservation"),
            icon: 'fa fa-refresh',
            content: useXmltag("Sorrytherecurrentlybookingoption"),
            rtl: true,
            type: 'red'
        });
        error = 1;
        return false;
    }

}

function reserveTourV2(_this,is_request=false) {
    const selected_package_id=$('#selected_package_id');
    let target_form=_this.parent().find('form')
    var typeTourReserve =target_form.find("[name='typeTourReserve']").val();
    var is_api =target_form.find("[name='is_api']").val();
    var selectDate = target_form.find('[name="selectDate"]').val();
    const package_id=target_form.find('#packageId').val()
    selected_package_id.val(package_id)

    target_form.attr('data-detected',  selected_package_id.val());
    if (selectDate == ''){
        $.alert({
            title:  useXmltag("Tourreservation"),
            icon: 'fa fa-refresh',
            content: useXmltag("Pleaseselectyourtourdatefirst"),
            rtl: true,
            type: 'red'
        });
        error = 1;
        return false;
    } else if (typeTourReserve == 'noOneDayTour'){



        let error = 0;
        let passengerCount = parseInt(target_form.find('input#passengerCount').val());
        if (passengerCount === 0){
            $.alert({
                title:  useXmltag("Tourreservation"),
                icon: 'fa fa-refresh',
                content: useXmltag("Pleasereserveyourpackage"),
                rtl: true,
                type: 'red'
            });
            error = 1;
            return false;
        }
        /*$('input[name^="passengerCountAnyRout"]').each(function(i){
            var count = parseInt($(this).val());
            if (passengerCount != count){
                $.alert({
                    title: ' useXmltag(Tourreservation)',
                    icon: 'fa fa-refresh',
                    content: 'لطفا تعداد افراد انتخابی برای اقامت در هر شهر یکی باشد. ',
                    rtl: true,
                    type: 'red'
                });
                error = 1;
                return false;
            }
        });*/
        // $('#passengerCount').val(passengerCount);
        loadingToggle(_this)


        // $('#img').show();
        // $('#buttonReserve').attr('disabled', 'disabled').css('opacity', '0.5').css('cursor', 'progress').html(useXmltag("Pending"));

        if (error == 0){

            $.post(amadeusPath + 'hotel_ajax.php',
               {
                   flag: 'CheckedLogin'
               },
               function (data) {

                   if (data.indexOf('successLoginHotel') > -1) {

                       BuyTourWithoutRegisterV2(_this,is_request);

                   } else if (data.indexOf('errorLoginHotel') > -1) {
                       console.log('errorLoginHotel _this',_this)
                       console.log('data',data);
                       $('#noLoginBuy').val(useXmltag("Bookingwithoutregistration"));
                       var isShowLoginPopup = $('#isShowLoginPopup').val();
                       var useTypeLoginPopup = $('#useTypeLoginPopup').val();
                       if (isShowLoginPopup == '' || isShowLoginPopup == '1'){
                           $("#login-popup").trigger("click");
                       } else {
                           console.log('errorLoginHotel popupBuyNoLogin _this',_this)

                           popupBuyNoLogin(useTypeLoginPopup);
                       }

                   }

               });


        }



    }else if (typeTourReserve == 'oneDayTour'){

        var error = 0;
        var passengerCount = parseInt(target_form.find('input#passengerCount').val());

        console.log('passengerCount',passengerCount);
        if (passengerCount == 0){
            $.alert({
                title:  useXmltag("Tourreservation"),
                icon: 'fa fa-refresh',
                content: useXmltag("Pleasereserveyourtournumber"),
                rtl: true,
                type: 'red'
            });
            error = 1;
            return false;
        }

        setTimeout(function () {
            if (error==0){

                $('#img').show();
                $('#buttonReserve').attr('disabled', 'disabled').css('opacity', '0.5').css('cursor', 'progress').html(useXmltag("Pending"));

                $.post(amadeusPath + 'hotel_ajax.php',
                   {
                       flag: 'CheckedLogin'
                   },
                   function (data) {

                       if (data.indexOf('successLoginHotel') > -1) {

                           BuyTourWithoutRegisterV2(_this,is_request);

                       } else if (data.indexOf('errorLoginHotel') > -1) {
                           console.log('data',data);
                           $('#noLoginBuy').val(useXmltag("Bookingwithoutregistration"));
                           var isShowLoginPopup = $('#isShowLoginPopup').val();
                           var useTypeLoginPopup = $('#useTypeLoginPopup').val();
                           if (isShowLoginPopup == '' || isShowLoginPopup == '1'){
                               $("#login-popup").trigger("click");
                           } else {
                               let _this_main = _this ;
                               popupBuyNoLogin(useTypeLoginPopup);
                           }
                       }

                   });

            }
        }, 2000);




    } else {
        $.alert({
            title:  useXmltag("Tourreservation"),
            icon: 'fa fa-refresh',
            content: useXmltag("Sorrytherecurrentlybookingoption"),
            rtl: true,
            type: 'red'
        });
        error = 1;
        return false;
    }

}

/*function memberTourLogin() {
    // Rid Errors
    var error = 0;
    $(".cd-error-message").html('');
    $(".cd-error-message").css("opacity", "0");
    $(".cd-error-message").css("visibility", "hidden");
    // Get values
    var email = $("#signin-email2").val();
    var pass = $("#signin-password2").val();
    var remember = $("#remember-me2:checked").val();
    if (remember == 'checked' || remember == 'on' || remember == 'true') {
        remember = 'on';
    } else {
        remember = 'off';
    }
    var organization = '';
    if($('#signin-organization2').length > 0){
        organization = $('#signin-organization2').val();
    }

    //check values
    if (!email) {
        $("#error-signin-email2").html('لطفا این فیلد را تکمیل نمایید');
        $("#error-signin-email2").css("opacity", "1");
        $("#error-signin-email2").css("visibility", "visible");
        error = 1;
    }

    if (!pass) {
        $("#error-signin-password2").html('لطفا این فیلد را تکمیل نمایید');
        $("#error-signin-password2").css("opacity", "1");
        $("#error-signin-password2").css("visibility", "visible");
        error = 1;
    }

    // send  for logon
    if (error == 0) {

        $.post(amadeusPath + 'user_ajax.php',
            {
                email: email,
                remember: remember,
                password: pass,
                organization: organization,
                setcoockie: "yes",
                flag: 'memberLogin'
            },
            function (data) {

                if (data.indexOf('success') > -1) { // فرد وارد شده کانتر یا مشتری آنلاین می باشد
                    $(".cd-user-modal").trigger("click");
                    BuyTourWithoutRegister();
                } else {

                    $.post(amadeusPath + 'user_ajax.php',
                        {
                            email: email,
                            remember: remember,
                            password: pass,
                            flag: 'agencyLogin'
                        },
                        function (res) {
                            if (res.indexOf('success') > -1) { // فرد وارد شده آژانس می باشد
                                $(".cd-user-modal").trigger("click");
                                BuyTourWithoutRegister();
                            } else {
                                $(".message-login").html('ایمیل وارد شده و یا کلمه عبور اشتباه می باشد');
                            }
                        })

                }
            })
    } else {
        return false;
    }

}*/



function BuyTourWithoutRegister(is_request=false) {

    let selected_form = $('#selected_package_id').val() ;

    let form_selected = $("form[data-detected='"+selected_form+"']");


    if (is_request) {
        form_selected.attr(
           "action",
           amadeusPathByLang + "submitRequest"
        )
    } else {
        form_selected.attr(
           "action",
           amadeusPathByLang + "passengerDetailReservationTour"
        )
    }
    form_selected.submit()

}
function BuyTourWithoutRegisterV2(_this,is_request=false) {
    const target_form=_this.parent().find('form')
    if(!is_request){
        target_form.attr("action", amadeusPathByLang + 'passengerDetailReservationTour');
    }else{
        target_form.attr("action", amadeusPathByLang + 'submitRequest');
    }
    target_form.submit();

}





/**
 بررسی  مسافران وارد شده قبل از ارسال به صفحه فاکتور
 page : PassengerDetailHotelLocal.tpl
 **/
function checkPassengerTourLocal(currentDate, numPassenger) {
    var error1 = 0;
    var error2 = 0;
    var error3 = 0;

    var min1 = $('.counter-analog').find('.part0').find('span:first-child').html();
    var min2 = $('.counter-analog').find('.part0').find('span:last-child').html();
    var sec1 = $('.counter-analog').find('.part2').find('span:first-child').html();
    var sec2 = $('.counter-analog').find('.part2').find('span:last-child').html();

    var timejoin = min1 + min2 + ':' + sec1 + sec2;
    $('#time_remmaining').val(timejoin);

    var adt = adultMembersTour(currentDate, numPassenger);
    if (adt == 'true') {
        error1 = 0;
    } else {
        error1 = 1;
    }

    if ($("#UsageNotLogin").val() && $("#UsageNotLogin").val() == "yes") {
        var mob = $('#Mobile').val();
        var Email_Address = $('#Email').val();
        var tel = $('#Telephone').val();
        var mm = membersForHotel(mob, Email_Address, tel);

        if (mm) {
            error2 = 0;
        } else {
            error2 = 1
        }

    }

    if (error1 == 0 && error2 == 0 && error3 == 0) {

        $.post(amadeusPath + 'hotel_ajax.php',
           {
               mobile: mob,
               telephone: tel,
               Email: Email_Address,
               flag: "register_memeberHotel"
           },
           function (data) {

               if (data != "") {
                   data =  data.replaceAll(/\s/g,'');

                   $('#idMember').val(data);

                   $('#loader_check').show();
                   $('#send_data').attr('disabled', 'disabled').css('opacity', '0.5').css('cursor', 'progress').val(useXmltag("Pending"));

                   setTimeout(
                      function () {
                          $('#loader_check').hide();
                          $('#formPassengerDetailTourLocal').submit();
                      }, 3000);

               } else {

                   $.alert({
                       title:  useXmltag("Tourreservation"),
                       icon: 'fa fa-cart-plus',
                       content: useXmltag("Errorrecordinginformation"),
                       rtl: true,
                       type: 'red'
                   });
                   return false;
               }
           });
    }

    if ($(".border-danger").length > 0) {
        $("html, body").animate({
            scrollTop: $(".border-danger").offset().top - 110
        }, 1000);
    }
}

function adultMembersTour(currentDate, numPassenger) {



    var form_result = 0;
    for (var i = 1; i <= parseInt(numPassenger); i++) {

        $('.require_check_'+i).find('.entry_div').each(function(){

            $(this).find('[required="required"]').each(function () {
                $(this).removeClass('border-danger');
            })
        })

        $("#message" + i).html('');
        var errors=[];
        var gender = '';
        gender = $("#gender" + i + " option:selected");

        if (gender.val() != 'Male' && gender.val() != 'Female') {
            $(`.gend${i}`).addClass('border-danger');
            $("#message" + i).html(useXmltag("SpecifyGender"));

            errors.push(useXmltag("SpecifyGender"));


            form_result = 1;
        }


        var custom_file_fields = '';
        custom_file_fields = $("input[name='custom_file_fields_" + i+"[]']").each(function () {
            custom_file_fields = $(this).get(0).files.length;
            if (custom_file_fields == 0) {
                $("#message" + i).html();

                errors.push(useXmltag("PleaseSelectYourFile")+'( '+$(this).attr('placeholder')+' )');

                form_result = 1;
                return false;
            }
        });



        var has_error = false ;

        $('.require_check_'+i).find('.entry_div').each(function(){

            $(this).find('[required="required"]').each(function () {
                if($(this).val() == ''){
                    has_error = true ;
                    $(this).addClass('border-danger');
                    form_result=1;
                }
                else{

                    var national_code_input=$('#NationalCode' + i+'[required="required"]');

                    if(national_code_input.length){
                        var CheckEqualNationalCode = getNationalCode(national_code_input.val(),national_code_input);
                        if (CheckEqualNationalCode == false) {
                            $("#message" + i).html('<br>'+useXmltag("NationalCodeDuplicate"));
                            if(errors.indexOf(useXmltag("NationalCodeDuplicate")) === -1){
                                errors.push(useXmltag("NationalCodeDuplicate"));
                            }
                            form_result=1;
                        }


                        var z1 = /^[0-9]*\d$/;
                        var convertedCode = convertNumber(national_code_input.val());
                        if (national_code_input.val() != "") {
                            if (!z1.test(convertedCode)) {
                                $("#message" + i).html('<br>'+useXmltag("NationalCodeNumberOnly"));
                                if(errors.indexOf(useXmltag("NationalCodeNumberOnly")) === -1){
                                    errors.push(useXmltag("NationalCodeNumberOnly"));
                                }
                                form_result=1;
                            } else if ((national_code_input.val().toString().length != 10)) {

                                $("#message" + i).html('<br>'+useXmltag("OnlyTenDigitsNationalCode"));
                                if(errors.indexOf(useXmltag("OnlyTenDigitsNationalCode")) === -1){
                                    errors.push(useXmltag("OnlyTenDigitsNationalCode"));
                                }
                                form_result=1;
                            } else {
                                var NCode = checkCodeMeli(convertNumber(national_code_input.val()));
                                if (!NCode) {
                                    $("#message" + i).html('<br>'+useXmltag("EnteredCationalCodeNotValid"));
                                    if(errors.indexOf(useXmltag("EnteredCationalCodeNotValid")) === -1){
                                        errors.push(useXmltag("EnteredCationalCodeNotValid"));
                                    }
                                    form_result=1;
                                }
                            }
                        }



                    }


                }
            })

            // $(this).find('select[required="required"]').each(function () {
            //     if($(this).val() == ''){
            //         errors.push($(this).attr('placeholder'));
            //
            //     }
            // })
        })


        if(has_error){
            errors.push(useXmltag("CompletingFieldsRequired"));
            form_result=1;
        }


        if(form_result == 1) {


            var all_errors = '';
            var error_counter = 0;
            for (var eachError in errors) {
                all_errors = all_errors + '<div class="badge badge-danger">' + errors[error_counter] + '</div>';
                error_counter = error_counter + 1;
            }

            $("#message" + i).html(all_errors);

        }

    }



    if (form_result == 0) {
        return 'true';
    } else {
        $.alert({
            title: useXmltag("RequestTourReservation"),
            icon: 'fa fa-warning',
            content: useXmltag("PleaseEnterItems"),
            rtl: true,
            type: 'red'
        });







        return 'false';
    }
}




function reserveTourTemprory(factorNumber) {

    if (!$('#RulsCheck').is(':checked')) {
        $.alert({
            title:  useXmltag("Tourreservation"),
            icon: 'fa fa-cart-plus',
            content: useXmltag("ConfirmTermsFirst"),
            rtl: true,
            type: 'red'
        });
        return false;
    }

    $('#final_ok_and_insert_passenger').text(useXmltag("Pending")).attr('disabled', 'disabled').css('opacity', '0.5').css('cursor', 'progress');
    $('#loader_check').css("display", "block");

    $.post(amadeusPath + 'tour_ajax.php',
       {
           factorNumber: factorNumber,
           flag: "preReserveTour"
       },
       function (data) {

           var result = data.split(":");
           if (data.indexOf('error') > -1) {

               $('#messageBook').html(result[1]);

           } else if (data.indexOf('success') > -1) {

               setTimeout(function () {
                   $('#final_ok_and_insert_passenger').removeAttr("onclick").attr("disabled", true).css('cursor', 'not-allowed').text(useXmltag("Accepted"));

                   $('.main-pay-content').css('display' , 'flex');
                   $('#loader_check').css("display", "none");
                   $('html, body').animate({scrollTop: $('#factor_bank').offset().top}, 'slow');
               }, 2000);

           }


       });


}



function modalListForTour(factorNumber) {

    //$('.loaderPublicForHotel').fadeIn(700);
    setTimeout(function () {
        $('.loaderPublicForHotel').fadeOut(500);
        $("#ModalPublic").fadeIn(700);
    }, 3000);

    $.post(libraryPath + 'ModalCreatorForTour.php',
       {
           Controller: 'user',
           Method: 'ModalShow',
           factorNumber: factorNumber
       },
       function (data) {
           $('#ModalPublicContent').html(data);

       });

}




function logicalDeletion(idSame, type, checkbox)
{
    // جلوگیری از تغییر وضعیت تا تصمیم کاربر
    event.preventDefault();

    $.confirm({
        theme: 'supervan',
        title: useXmltag("Removechanges"),
        icon: 'fa fa-trash',
        content: useXmltag("Areyousureyouwantdeletechanges"),
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: useXmltag("Approve"),
                btnClass: 'btn-green',
                action: function () {

                    $.post(amadeusPath + 'tour_ajax.php', {
                        idSame: idSame,
                        type: type,
                        flag: 'logicalDeletion'
                    }, function (data) {

                        var res = data.split(':');

                        if (data.indexOf('success') > -1) {

                            checkbox.checked = !checkbox.checked; // تغییر وضعیت بعد از تایید

                            $.alert({
                                title: useXmltag("Removechanges"),
                                content: res[1],
                                rtl: true,
                                type: 'green'
                            });

                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        } else {

                            $.alert({
                                title: useXmltag("Removechanges"),
                                content: res[1],
                                rtl: true,
                                type: 'red'
                            });

                        }
                    });
                }
            },
            cancel: {
                text: useXmltag("Optout"),
                btnClass: 'btn-orange',
                action: function () {
                    // هیچ کاری نکن → چک‌باکس تغییر نمی‌کند
                }
            }
        }
    });

    return false;
}

//////////حذف منطقی گالری تور///////
function logicalDeletionGalleryTour(id)
{
    $.confirm({
        theme: 'supervan' ,// 'material', 'bootstrap'
        title: useXmltag("Removechanges"),
        icon: 'fa fa-trash',
        content: useXmltag("Areyousureyouwantdeletechanges"),
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: useXmltag("Approve"),
                btnClass: 'btn-green',
                action: function () {
                    $.post(amadeusPath + 'tour_ajax.php',
                       {
                           id: id,
                           flag: 'logicalDeletionGalleryTour'
                       },
                       function (data) {

                           var res = data.split(':');
                           if (data.indexOf('success') > -1)
                           {

                               $.alert({
                                   title: useXmltag("Removechanges"),
                                   icon: 'fa fa-refresh',
                                   content: res[1],
                                   rtl: true,
                                   type: 'green'
                               });

                               setTimeout(function () {
                                   location.reload();
                               }, 1000);

                           }else {

                               $.alert({
                                   title: useXmltag("Removechanges"),
                                   icon: 'fa fa-refresh',
                                   content: res[1],
                                   rtl: true,
                                   type: 'red'
                               });

                           }

                       });
                }
            },
            cancel: {
                text: useXmltag("Optout"),
                btnClass: 'btn-orange'
            }
        }
    });
}



function isDigit(entry)
{
    var key = window.event.keyCode;
    if((key>=48 && key<=57) || key==122) {
        return true;
    } else {
        $.confirm({
            title: useXmltag("ErrorEnteringInformation"),
            content: useXmltag("Pleaseenteronlynumberfield"),
            autoClose: 'cancelAction|4000',
            escapeKey: 'cancelAction',
            type: 'red',
            buttons: {
                cancelAction: {
                    text: useXmltag("Closing"),
                    btnClass: 'btn-red'

                }
            }
        });
        return false;
    }
}

function separator(txt){
    var iDistance = 3;
    var strChar = ",";
    var strValue = txt.value;

    if(strValue != 'undefined' &&  strValue.length>3){
        var str="";
        for(var i=0;i<strValue.length;i++){
            if(strValue.charAt(i)!=strChar){
                if ((strValue.charAt(i) >= 0) && (strValue.charAt(i) <= 9)){
                    str=str+strValue.charAt(i);
                }
            }
        }

        strValue=str;
        var iPos = strValue.length;
        iPos -= iDistance;
        while(iPos>0){
            strValue = strValue.substr(0,iPos)+strChar+strValue.substr(iPos);
            iPos -= iDistance;
        }
    }
    txt.value=strValue;
}


function callFunctionResultTourPackage(val=null,Selector=null) {

    if(val != null){
        var selectDate = val;
        $('#TourDatesList').find('.active_col_today').each(function () {
            $(this).removeClass('active_col_today');
        })
        Selector.addClass('active_col_today');
    }else{
        var selectDate = $('.active_col_today .lowest-date span').text();
    }
    var date = selectDate.split('|');
    var startDate = date[0];
    var endDate = date[1];
    $('#selectDate').val(selectDate);
    var tourCode = $('#tourCode').val();
    var tour_id = $('#tour_id').val();
    var typeTourReserve = $('#typeTourReserve').val();
    getResultTourPackage_newView(tour_id,tourCode, startDate,endDate, typeTourReserve);
}


function getResultTourPackage(tourCode, startDate, typeTourReserve) {

    $('#passengerCount').val(0);
    $('#passengerCountADT').val(0);
    $('#passengerCountCHD').val(0);
    $('#passengerCountINF').val(0);
    $('#countRoom').val('');

    $('#totalPrice').val(0);
    $('#paymentPrice').val(0);
    // $('#showTotalPrice').html('<i></i>' + useXmltag('Rial'));
    $('.pricing-table .amount').html('<i></i>' + useXmltag('Rial'));
    $('#showPaymentPrice').html('<i></i>' + useXmltag('Rial'));

    //$('.loaderPublicPage').fadeIn("slow");
    $.post(amadeusPath + 'tour_ajax.php',
       {
           flag: 'getResultTourPackage',
           tourCode: tourCode,
           startDate: startDate,
           typeTourReserve: typeTourReserve
       },
       function (data) {
           if (data) {

               $(".BaseTourPackageHolder_js").html(data);

               let prices = $(".BaseTourPackageHolder_js").find('input[name*=RoomPrice]');
               let minPrice = 0;
               let maxPrice = 0;
               let flage = 0;
               prices.each(function () {
                   let price  = parseInt($(this).val());
                   if (flage == 0){
                       minPrice = price;
                       maxPrice = price;
                   } else {
                       if (price > 0 && price > maxPrice){
                           maxPrice = price;
                       }
                       if (price > 0 && price < minPrice){
                           minPrice = price;
                       }
                   }
                   flage++;
               });
               $('#inputSearchHotelMinPrice').val(minPrice);
               $('#inputSearchHotelMaxPrice').val(maxPrice);

               $("#slider-range").slider({
                   range: true,
                   min:   minPrice,
                   max:  maxPrice,
                   step: 1000,
                   animate: false,
                   values: [minPrice, maxPrice],
                   slide: function (event, ui) {

                       var minRange = ui.values[0];
                       var maxRange = ui.values[1];

                       $('#inputSearchHotelMinPrice').val(minRange);
                       $('#inputSearchHotelMaxPrice').val(maxRange);

                       $(".filter-price-text span:nth-child(2) i").html(addCommas(minRange));
                       $(".filter-price-text span:nth-child(1) i").html(addCommas(maxRange));

                   }
               });
               $(".filter-price-text span:nth-child(2) i").html(addCommas(parseInt(minPrice)));
               $(".filter-price-text span:nth-child(1) i").html(addCommas(parseInt(maxPrice)));
           }
       });

    //
    // // for responsive
    // setTimeout(function () {
    //     $.post(amadeusPath + 'tour_ajax.php',
    //         {
    //             flag: 'getResultTourPackageForResponsive',
    //             tourCode: tourCode,
    //             startDate: startDate,
    //             typeTourReserve: typeTourReserve
    //         },
    //         function (data) {
    //             if (data) {
    //                 $("#tourPackageForResponsive").html(data);
    //             }
    //
    //         });
    // }, 100);

}

function getResultTourPackage_newView(tour_id,tourCode, startDate,endDate, typeTourReserve) {

    $('#passengerCount').val(0);
    $('#passengerCountADT').val(0);
    $('#passengerCountCHD').val(0);
    $('#passengerCountINF').val(0);
    $('#countRoom').val('');
    $('#selectDate').val(startDate.replace(" ", "")+'|'+endDate.replace(" ", ""));

    $('#totalPrice').val(0);
    $('#paymentPrice').val(0);
    // $('#showTotalPrice').html('<i></i>' + useXmltag('Rial'));
    $('.pricing-table .amount').html('<i></i>' + useXmltag('Rial'));
    $('#showPaymentPrice').html('<i></i>' + useXmltag('Rial'));



    $('*[data-request-value="true"]').addClass('ph-item4').html('');
    $('*[data-request-action="LoadPackages"]').addClass('ph-item3');
    $('*[data-request-value="img"]').addClass('ph-item3').css('background-image','url("//placehold.it/140?text=IMAGE")');




    //$('.loaderPublicPage').fadeIn("slow");
    $.post(amadeusPath + 'tour_ajax.php',
       {
           flag: 'getResultTourPackage',
           tour_id: tour_id,
           tourCode: tourCode,
           startDate: startDate,
           endDate: endDate,
           typeTourReserve: typeTourReserve
       },
       function (data) {
           if (data) {
               setTimeout(function() {
                   $("#TourPackagesList").html(data);

                   let prices = $("#TourPackagesList").find('input[name*=RoomPrice]');
                   let minPrice = 0;
                   let maxPrice = 0;
                   let flage = 0;
                   prices.each(function () {
                       let price  = parseInt($(this).val());
                       if (flage == 0){
                           minPrice = price;
                           maxPrice = price;
                       } else {
                           if (price > 0 && price > maxPrice){
                               maxPrice = price;
                           }
                           if (price > 0 && price < minPrice){
                               minPrice = price;
                           }
                       }
                       flage++;
                   });
                   $('#inputSearchHotelMinPrice').val(minPrice);
                   $('#inputSearchHotelMaxPrice').val(maxPrice);

                   $("#slider-range").slider({
                       range: true,
                       min:   minPrice,
                       max:  maxPrice,
                       step: 1000,
                       animate: false,
                       values: [minPrice, maxPrice],
                       slide: function (event, ui) {

                           var minRange = ui.values[0];
                           var maxRange = ui.values[1];

                           $('#inputSearchHotelMinPrice').val(minRange);
                           $('#inputSearchHotelMaxPrice').val(maxRange);

                           $(".filter-price-text span:nth-child(2) i").html(addCommas(minRange));
                           $(".filter-price-text span:nth-child(1) i").html(addCommas(maxRange));

                       }
                   });
                   $(".filter-price-text span:nth-child(2) i").html(addCommas(parseInt(minPrice)));
                   $(".filter-price-text span:nth-child(1) i").html(addCommas(parseInt(maxPrice)));
               },1000);
           }
       });


    // for responsive
    // setTimeout(function () {
    //     $.post(amadeusPath + 'tour_ajax.php',
    //         {
    //             flag: 'getResultTourPackageForResponsive',
    //             tourCode: tourCode,
    //             startDate: startDate,
    //             typeTourReserve: typeTourReserve
    //         },
    //         function (data) {
    //             if (data) {
    //                 $("#tourPackageForResponsive").html(data);
    //             }
    //
    //         });
    // }, 100);

}

function showDetailPrice(id) {
    $('.mdi-chevron-down').toggleClass('mdi-chevron-up');
    $('#detail-prices-' + id).toggleClass('show_hotels_');
}



////تایید درخواست  رزرو تور توسط کانتر
function confirmationTourReservation(factorNumber)
{
    $.confirm({
        theme: 'supervan' ,// 'material', 'bootstrap'
        title: useXmltag("Approvaltourreservation"),
        icon: 'fa fa-trash',
        content: useXmltag("Areyousurewantconfirmrequest"),
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: useXmltag("Approve"),
                btnClass: 'btn-green',
                action: function () {
                    $.post(amadeusPath + 'tour_ajax.php',
                       {
                           factorNumber: factorNumber,
                           flag: 'confirmationTourReservation'
                       },
                       function (data) {

                           var res = data.split(':');
                           if (data.indexOf('success') > -1)
                           {
                               $.alert({
                                   title: useXmltag("Approvaltourreservation"),
                                   icon: 'fa fa-refresh',
                                   content: res[1],
                                   rtl: true,
                                   type: 'green'
                               });

                               setTimeout(function () {
                                   location.reload();
                               }, 1000);
                           } else
                           {
                               $.alert({
                                   title: useXmltag("Approvaltourreservation"),
                                   icon: 'fa fa-refresh',
                                   content: res[1],
                                   rtl: true,
                                   type: 'red'
                               });

                           }

                       });
                }
            },
            cancel: {
                text: useXmltag("Optout"),
                btnClass: 'btn-orange'
            }
        }
    });
}




function registerPassengersFileTour()
{

    var form = $('#registerPassengersFileTourForm')[0];
    var formData = new FormData(form);

    $.ajax({
        type: 'post',
        url: amadeusPath + 'tour_ajax.php',
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
            console.log(data);
            $('#registerPassengersFileTourForm')[0].reset();
            var res = data.split(':');
            if (data.indexOf('success') > -1)
            {
                $.alert({
                    title: useXmltag("Tourreservation"),
                    icon: 'fa fa-refresh',
                    content: res[1],
                    rtl: true,
                    type: 'green'
                });

                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else
            {
                $.alert({
                    title: useXmltag("Tourreservation"),
                    icon: 'fa fa-refresh',
                    content: res[1],
                    rtl: true,
                    type: 'red'
                });

            }

        }
    });
}




function showTypePaymentForTour(factorNumber, typeTrip, paymentPrice, serviceType, currencyCode, currencyEquivalent) {

    $('#payBankButton').html('');

    $.ajax({
        type: 'POST',
        url: amadeusPath + 'tour_ajax.php',
        dataType: 'JSON',
        data:
           {
               flag: 'createPayButton',
               factorNumber: factorNumber,
               typeTrip: typeTrip,
               paymentPrice: paymentPrice,
               serviceType: serviceType,
               currencyCode: currencyCode,
               currencyEquivalent: currencyEquivalent
           },
        success: function (response) {

            if(currencyCode > 0){
                $('#payCurrencyButton').html(response.result_currency);
                $('#currencyBanks').css("display", "block");
            } else{
                $('#payBankButton').html(response.result_bank);
                $('#railBanks').css("display", "block");
            }

            $('.main-pay-content').addClass('d-flex');
            $('#payCreditButton').html(response.result_credit);

            $('.s-u-p-factor-bank-change').show();
            $('#loader_check').css("display", "none");
            $('html, body').animate({scrollTop: $('#factor_bank').offset().top}, 'slow');

        }
    });

}



////کنسلی تور توسط مسافر
function tourCancellationRequest(factorNumber)
{
    $.confirm({
        theme: 'supervan' ,// 'material', 'bootstrap'
        title: useXmltag("CancelreservationTour"),
        icon: 'fa fa-trash',
        content: useXmltag("Consignmentfinedconsignmentfineissuedaskingcancell"),
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: useXmltag("Approve"),
                btnClass: 'btn-green',
                action: function () {
                    $.post(amadeusPath + 'tour_ajax.php',
                       {
                           factorNumber: factorNumber,
                           flag: 'tourCancellationRequest'
                       },
                       function (data) {

                           var res = data.split(':');
                           if (data.indexOf('success') > -1)
                           {
                               $.alert({
                                   title: useXmltag("CancelreservationTour"),
                                   icon: 'fa fa-refresh',
                                   content: res[1],
                                   rtl: true,
                                   type: 'green'
                               });

                               setTimeout(function () {
                                   location.reload();
                               }, 1000);
                           } else
                           {
                               $.alert({
                                   title:useXmltag("CancelreservationTour"),
                                   icon: 'fa fa-refresh',
                                   content: res[1],
                                   rtl: true,
                                   type: 'red'
                               });

                           }

                       });
                }
            },
            cancel: {
                text: useXmltag("Optout"),
                btnClass: 'btn-orange'
            }
        }
    });
}




////تایید کنسلی تور توسط کانتر
function tourConfirmCancellationRequest(factorNumber)
{
    $.confirm({
        theme: 'supervan' ,// 'material', 'bootstrap'
        title: useXmltag("CancelreservationTour"),
        icon: 'fa fa-trash',
        content: useXmltag("AreyousureyouwantconfirmCancellerrequest"),
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: useXmltag("Approve"),
                btnClass: 'btn-green',
                action: function () {
                    $.post(amadeusPath + 'tour_ajax.php',
                       {
                           factorNumber: factorNumber,
                           cancelPrice: $('#cancelPrice' + factorNumber).val(),
                           flag: 'tourConfirmCancellationRequest'
                       },
                       function (data) {

                           var res = data.split(':');
                           if (data.indexOf('success') > -1)
                           {
                               $.alert({
                                   title: useXmltag("CancelreservationTour"),
                                   icon: 'fa fa-refresh',
                                   content: res[1],
                                   rtl: true,
                                   type: 'green'
                               });

                               setTimeout(function () {
                                   location.reload();
                               }, 1000);
                           } else
                           {
                               $.alert({
                                   title: useXmltag("CancelreservationTour"),
                                   icon: 'fa fa-refresh',
                                   content: res[1],
                                   rtl: true,
                                   type: 'red'
                               });

                           }

                       });
                }
            },
            cancel: {
                text: useXmltag("Optout"),
                btnClass: 'btn-orange'
            }
        }
    });
}





////ثبت نهایی کنسلی تور
function successfullyCancel(factorNumber)
{
    $.confirm({
        theme: 'supervan' ,// 'material', 'bootstrap'
        title: useXmltag("CancelreservationTour"),
        icon: 'fa fa-trash',
        content: useXmltag("AreyousureyouwantconfirmCancellerrequest"),
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: useXmltag("Approve"),
                btnClass: 'btn-green',
                action: function () {
                    $.post(amadeusPath + 'tour_ajax.php',
                       {
                           factorNumber: factorNumber,
                           flag: 'successfullyCancel'
                       },
                       function (data) {

                           var res = data.split(':');
                           if (data.indexOf('success') > -1)
                           {
                               $.alert({
                                   title: useXmltag("CancelreservationTour"),
                                   icon: 'fa fa-refresh',
                                   content: res[1],
                                   rtl: true,
                                   type: 'green'
                               });

                               setTimeout(function () {
                                   location.reload();
                               }, 1000);
                           } else
                           {
                               $.alert({
                                   title: useXmltag("CancelreservationTour"),
                                   icon: 'fa fa-refresh',
                                   content: res[1],
                                   rtl: true,
                                   type: 'red'
                               });

                           }

                       });
                }
            },
            cancel: {
                text: useXmltag("Optout"),
                btnClass: 'btn-orange'
            }
        }
    });
}




function time(inputName) {
    var time = $('#' + inputName).val();
    if (time > 72) {

        $('#' + inputName).val('');
        $.confirm({
            title: useXmltag("ErrorEnteringInformation"),
            content: useXmltag("Pleaseenterstoppingtimeuptohours"),
            autoClose: 'cancelAction|4000',
            escapeKey: 'cancelAction',
            type: 'red',
            buttons: {
                cancelAction: {
                    text: useXmltag("Closing"),
                    btnClass: 'btn-red'

                }
            }
        });

        return false
    } else {

        return true;
    }

}

function deleteAndInertTourType()
{

    var form = $('#deleteAndInertTourTypeForm')[0];
    var formData = new FormData(form);

    $.ajax({
        type: 'post',
        url: amadeusPath + 'tour_ajax.php',
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
            $('#deleteAndInertTourTypeForm')[0].reset();
            var res = data.split(':');
            if (data.indexOf('success') > -1)
            {
                $.alert({
                    title: useXmltag("Tourreservation"),
                    icon: 'fa fa-refresh',
                    content: res[1],
                    rtl: true,
                    type: 'green'
                });

                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else
            {
                $.alert({
                    title: useXmltag("Tourreservation"),
                    icon: 'fa fa-refresh',
                    content: res[1],
                    rtl: true,
                    type: 'red'
                });

            }

        }
    });
}




function setDiscountTour()
{

    var form = $('#discountTourForm')[0];
    var formData = new FormData(form);

    $.ajax({
        type: 'post',
        url: amadeusPath + 'tour_ajax.php',
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
            $('#discountTourForm')[0].reset();
            let res = data.split(':');
            if (data.indexOf('success') > -1)
            {
                $.alert({
                    title: useXmltag("Tourreservation"),
                    icon: 'fa fa-refresh',
                    content: res[1],
                    rtl: true,
                    type: 'green'
                });
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else {
                $.alert({
                    title: useXmltag("Tourreservation"),
                    icon: 'fa fa-refresh',
                    content: res[1],
                    rtl: true,
                    type: 'red'
                });
            }

        }
    });
}


async function selectSortTour(obj) {
    let sortBy = $(obj).val();
    await sortTourList(sortBy);

}

async function sortTourList(sortBy) {

    let currentHotel = '';
    let allTours = [];
    let temp = [];
    let current_sort_index = '';
    let current_sort_index_first = '';
    let current_sort_index_second = '';
    let typApplication = '';
    let price = '';
    let arrayPrice = [];
    let searchResult = $("#tourResult").find(".hotelResultItem .hotel-result-item");

    await searchResult.each(function () {

        currentHotel = $(this).parent();
        typApplication = $(this).data('typeapplication');


        if (parseInt($(this).data('special')) > 0) {
            current_sort_index_second = parseInt($(this).data('special'));
        } else {
            current_sort_index_second = 0;
        }


        if (sortBy == 'max_star_code' || sortBy == 'min_star_code') {


            if (parseInt($(this).data('star')) > 0) {
                current_sort_index = parseInt($(this).data('star'));
            } else {
                current_sort_index = 0;
            }


            if (parseInt($(this).data('price')) > 0) {
                price = current_sort_index_first = parseInt($(this).data('price'));
                arrayPrice.push(price);
            } else {
                price = current_sort_index_first = 0;
            }


        } else if (sortBy == 'max_room_price' || sortBy == 'min_room_price') {

            if (parseInt($(this).data('price')) > 0) {
                price = current_sort_index = parseInt($(this).data('price'));
                arrayPrice.push(price);
            } else {
                price = current_sort_index = 0;
            }

            if (parseInt($(this).data('star')) > 0) {
                current_sort_index_first = parseInt($(this).data('star'));
            } else {
                current_sort_index_first = 0;
            }

        }

        allTours.push({
            'content': currentHotel.html(),
            'sortIndex': current_sort_index,
            'sortIndexFirst': current_sort_index_first,
            'sortIndexSecond': current_sort_index_second,
            'typApplication': typApplication,
            'price': price
        });
    });


    if (sortBy == 'min_room_price' || sortBy == 'min_star_code') {

        for (let i = 0; i < parseInt(allTours.length); i++) {
            for (let j = i; j < parseInt(allTours.length); j++) {
                if (allTours[j]['sortIndexFirst'] <= allTours[i]['sortIndexFirst']) {
                    temp = allTours[i];
                    allTours[i] = allTours[j];
                    allTours[j] = temp;
                }
            }
        }

        for (let i = 0; i < parseInt(allTours.length); i++) {
            for (let j = i; j < parseInt(allTours.length); j++) {
                if (allTours[j]['sortIndex'] <= allTours[i]['sortIndex']) {
                    temp = allTours[i];
                    allTours[i] = allTours[j];
                    allTours[j] = temp;
                }
            }
        }

    } else if (sortBy == 'max_room_price' || sortBy == 'max_star_code') {

        for (let i = 0; i < parseInt(allTours.length); i++) {
            for (let j = i; j < parseInt(allTours.length); j++) {
                if (allTours[j]['sortIndexFirst'] >= allTours[i]['sortIndexFirst']) {
                    temp = allTours[i];
                    allTours[i] = allTours[j];
                    allTours[j] = temp;
                }
            }
        }

        for (let i = 0; i < parseInt(allTours.length); i++) {
            for (let j = i; j < parseInt(allTours.length); j++) {
                if (allTours[j]['sortIndex'] >= allTours[i]['sortIndex']) {
                    temp = allTours[i];
                    allTours[i] = allTours[j];
                    allTours[j] = temp;
                }
            }
        }

    }



    await $('#countHotel').html(parseInt(allTours.length));

    // // اگر هتل رزرواسیون قیمت داشت بالاتر از همه نمایش بدهد
    for (let i = 0; i < parseInt(allTours.length); i++) {
        for (let j = i; j < parseInt(allTours.length); j++) {
            if (allTours[i]['typApplication'] == 'api' && allTours[j]['typApplication'] == 'reservation' && allTours[j]['price'] > 0) {
                temp = allTours[i];
                allTours[i] = allTours[j];
                allTours[j] = temp;
            }
        }
    }





    for (let i = 0; i < parseInt(allTours.length); i++) {
        for (let j = i; j < parseInt(allTours.length); j++) {
            if (allTours[j]['sortIndexSecond'] >= allTours[i]['sortIndexSecond']) {
                temp = allTours[i];
                allTours[i] = allTours[j];
                allTours[j] = temp;
            }
        }
    }

    setTimeout(async function () {
        /*let maxPrice = Math.max.apply(Math,arrayPrice);
        let minPrice = Math.min.apply(Math,arrayPrice);
        $(".filter-price-text span:nth-child(1) i").html(addCommas(maxPrice));
        $(".filter-price-text span:nth-child(2) i").html(addCommas(minPrice));*/
        $('#tourResult').empty();
        for (let i = 0; i < parseInt(allTours.length); i++) {
            if (allTours[i]['price'] > 0) {
                await $("#tourResult").append('<div class="hotelResultItem">' + allTours[i]['content'] + '</div>');
            }
        }
    }, 50);


    setTimeout(async function () {
        for (let i = 0; i < parseInt(allTours.length); i++) {
            if (allTours[i]['price'] == 0) {
                await $("#tourResult").append('<div class="hotelResultItem">' + allTours[i]['content'] + '</div>');
            }
        }
    }, 100);




    await $("body").on("click", ".DetailRoom_external", function () {
        $(this).parents('.roomRateItem').find('.detail_room_hotel').toggleClass('active_detail');
        $(this).find('i').toggleClass('rotate');
    });
    await $("body").on("click", ".DetailRoom_local", function () {
        $(this).parents('.hotel-detail-room-list-local').find('.detail_room_hotel').toggleClass('active_detail');
        $(this).find('i').toggleClass('rotate');
    });


    /*
        var stickyEl = new Sticksy('.filter_hotel_boxes', {
            topSpacing: 100,
        })
        stickyEl.onStateChanged = function (state) {
            if (state === 'fixed') stickyEl.nodeRef.classList.add('widget--sticky')
            else stickyEl.nodeRef.classList.remove('widget--sticky')
        }*/

    // lazyView //
    /*if ($('#tourResult').data('typeapp') == 'externalHotel') {
        setTimeout(function () {
            let newScript;
            newScript = document.createElement('script');
            newScript.type = 'text/javascript';
            newScript.src = amadeusPath + 'view/client/assets/js/lazyView/jquery.lazyView.min.js';
            document.getElementsByTagName("head")[0].appendChild(newScript);
            $('#tourResult').lazyView();
        }, 110);
    }*/
    $('[data-name="tour-loading"]').addClass('d-none').removeClass('d-flex')
    $('[data-name="tour-result"]').removeClass('d-none').addClass('d-flex')

}

const validateShowListTour = function (){
    $.ajax({
        type: 'POST',
        url: amadeusPath + 'user_ajax.php',
        dataType: 'JSON',
        data : {
            flag : 'resultTourLocalList',
        },
        beforeSend: function () {
            $('.loaderPublicForHotel').show();
            $('#tourResult').addClass('d-none');
        },
        success : function(data){
            if(data.show_result){
                $('#tourResult').removeClass('d-none');
            }else if(data.error_message != ''){
                $.confirm({
                    theme: 'supervan',// 'material', 'bootstrap'
                    title: useXmltag('NotAvailable'),
                    icon: 'fa fa-trash',
                    content: data.error_message,
                    rtl: true,
                    closeIcon: false,
                    type: 'orange',
                    buttons: {
                        confirm: {
                            text: useXmltag("Approve"),
                            btnClass: 'btn-green',
                            action: function () {
                                setTimeout(function () {
                                    window.location.href = clientMainDomain;
                                    // location.reload();
                                }, 1000);
                            }
                        }
                    }
                });
            }else if(data.show_login_popup){
                $("#login-popup").trigger("click");
            }
        },
        error : function(error){
            console.log(error);
        }
    })
};
function removeCustomFile(thiss){
    thiss.parent().remove();
}
function addCustomFile(thiss) {
    const count=$('div[data-name="custom_file_fields"]').length;



    const file_html='<div data-name="custom_file_fields" class="col-md-3 d-flex flex-wrap mt-md-0 mt-2">\n' +
       '<span class="fa fa-remove removeCustomFile" onclick="removeCustomFile($(this))"></span>' +
       '                    <div class="form-group w-100">\n' +
       '                        <label class="label-plas" for="custom_file_fields_'+count+'">نام فایل</label>\n' +
       '                        <input type="text" class="form-control"' +
       '                               name="custom_file_fields[]" '+
       '                               id="custom_file_fields_'+count+'" placeholder="نام فایل">\n' +
       '                    </div>\n' +
       '                </div>';

    thiss.before(file_html);

}

function passengerFormInit(passenger_count=1) {


    /**
     * @param {string} passengerNationality
     * @param {string} nationality
     * @param {array} requires
     */
    function nationalityCheck(passengerNationality,nationality,requires) {
        return passengerNationality === nationality && requires.includes(nationality);
    }

    /* $('.require_check input').each(function () {
         $(this).addClass('d-none').removeAttr('required');
     })
     $('.require_check select').each(function () {
         $(this).addClass('d-none').removeAttr('required');
         $(this).select2('destroy');
     })
 */
    const is_internal= $('#serviceTitle').val() === 'PrivateLocalTour' ? true : false;
    const inputs = [
        '#gender',
        '#nameEn',
        '#familyEn',
        '#nameFa',
        '#familyFa',
        '#birthday',
        '#birthdayEn',
        '#passportExpire',
        '#NationalCode',
        '#passportNumber',
        '#passportCountry',
    ];



    for (let i = 1; i <= passenger_count; i++) {
        var passengerNationality = $('#passengerNationality' + i+':checked').val() == '0' ? 'iranian':'foreign';


        var all_requirement={
            'iranian':passengerNationality,
            'foreign':passengerNationality,
            'internal':is_internal?'internal':'external',
            'external':is_internal?'internal':'external'
        };



        for (const input of inputs) {
            var each_input=$(input+i);
            var array_requires='';
            if(each_input.data('required')){
                array_requires=each_input.data('required').split('|');
            }

            var is_done=false;
            for(const each_conditions of array_requires){

                var conditions='';
                conditions=each_conditions.split(',');


                var conditions_result = false;
                for (const condition of conditions) {

                    if (condition == all_requirement[condition]) {
                        conditions_result = true;
                    }else{
                        conditions_result = false;
                        break;
                    }
                }
                if(conditions_result){
                    each_input.attr('required','required').parent().removeClass('d-none');
                    break;
                }else{
                    each_input.removeAttr('required').parent().addClass('d-none');
                }
            }

        }

    }


}
function addNewFillAbleField(_this,input_name) {
    let entry_tag="<div data-name='new-fillable-field' class=\"bg-light border border-50 d-flex flex-wrap px-3 py-2 rounded-pill gap-10\">\n" +
       "    <input type='text'\n" +
       "           placeholder='"+useXmltag("Body")+"'\n" +
       "           class='form-control h-30-p  w-auto'>\n" +
       "    <button type='button' onclick='saveNewFillAbleField($(this),\""+input_name+"\")' class=\"align-items-center border border-success btn btn-outline-success d-flex flex-wrap font-12 gap-5\">\n" +
       "        <span class='fa fa-save font-13'></span>\n" +
       useXmltag("Register") +
       "    </button>\n" +
       "    <button type='button' onclick='removeNewFillAbleField($(this))' class=\"align-items-center border border-danger btn btn-outline-danger d-flex flex-wrap font-12 gap-5\">\n" +
       "        <span class='fa fa-trash font-13'></span>\n" +
       "    </button>\n" +
       "</div>"

    _this.parent().find('[data-name="new-fillable-field"]').remove()
    _this.before(entry_tag)
}
function saveNewFillAbleField(_this,input_name) {
    const entry_tag=_this.parent()
    const fillable_input=entry_tag.find('input')
    const fillable_label=entry_tag.find('label')
    const default_fillable_data=_this.parent().parent().find('[data-name="default-fillable-data"]')
    const default_fillable_data_count=default_fillable_data.length
    const new_fillable_data='<div data-name=\'default-fillable-data\' class="bg-light border border-50 d-flex flex-wrap px-3 py-2 rounded-pill">\n' +
       '    <p class="align-items-center d-flex flex-wrap">\n' +
       '        <input type="checkbox" checked class="FilterHoteltype"\n' +
       '               value="'+fillable_input.val()+'"\n' +
       '               id="'+input_name+default_fillable_data_count+'" name="'+input_name+'[]">\n' +
       '        <label class="BaseTimelineBoth d-flex flex-wrap m-0 site-main-text-color-a"\n' +
       '               for="'+input_name+default_fillable_data_count+'">'+fillable_input.val()+'</label>\n' +
       '    </p>\n' +
       '</div>'
    entry_tag.before(new_fillable_data)
    entry_tag.remove()
}
function removeNewFillAbleField(_this) {
    _this.parent().remove()
}

function setAttrByValue(_this,item, hotel) {
    const key = Object.keys(item)[0]
    if (key === "html") {

        if((item[key] === 'final_price' || item[key] === 'price' || item[key] === 'currency_price') && key==='html'){
            if(item[key] === 'price' && hotel['price'] === hotel['final_price']) {
                _this.closest('.first-price.check_exist_discount').remove(); // حذف کامل از DOM
                return;
            }

            if(hotel[''] === hotel['price']){
                _this.parentsfinal_price().find('div.check_exist_discount').remove();
            }
            if(hotel[item[key]].toLocaleString("en-US") === '0'){
                _this.parents().find('div.check_exist_discount').remove();

                _this.addClass('d-flex flex-wrap font-13 text-muted')
                _this.next('i').remove()
            }else if(hotel['capacity'].toLocaleString("en-US") === '0' && item[key] !== 'currency_price'){
                _this.parents().find('div.check_exist_discount').remove();
                _this.html(useXmltag("FullCapacity"))
                _this.addClass('d-flex flex-wrap font-13 text-muted')
                _this.next('i').remove()
            } else{


                if(item[key] === 'currency_price' && hotel['price'] !== 0)
                {
                    _this.html('<span>+</sapn>')
                }
                if(item[key] === 'currency_price' && hotel[item[key]].toLocaleString("en-US") != ''){
                    let currency_with_price = '' ;
                    if(hotel['price'] !== 0) {
                        currency_with_price = '<span>+</span>' ;
                    }
                    currency_with_price = currency_with_price + hotel[item[key]].toLocaleString("en-US")

                    _this.html(currency_with_price)

                }else{
                    _this.html(hotel[item[key]].toLocaleString("en-US"))
                }
            }

            if(item[key] === 'final_price' && hotel['price'] === 0 && hotel['currency_price']==='') {
                _this.html(useXmltag("Unavailable"))
            }

        }else {

            if(item[key] === 'star_code' && _this.hasClass('lg-only')) {
                for (var i = 1; i <= 5; i++) {
                    var star = document.createElement('i');
                    star.classList.add('fas', 'fa-star-o', 'icone-star');

                    // Check if the current star should be filled or empty
                    if (i <= hotel[item[key]]) {
                        star.classList.add('fa','fa-star');
                        star.classList.remove('fas', 'fa-star-o');
                    }

                    // Append the star to the container
                    _this.append(star);
                }
            }else{
                if(hotel[item[key]] !== ''){
                    _this.html(hotel[item[key]])
                }
            }
        }
    } else {
        /*if(item[key] == 'name_en' && key=='data-hotel-name'){
            if( hotel[item[key]] !== undefined){
                hotel[item[key]]=hotel[item[key]].replace(' ', ' ')
            }
        }*/
        if(hotel[item[key]] !== undefined) {
            _this.attr(key, hotel[item[key]])
        }

    }
}

function create_section_package_tour_several_date(_this , start_date, tour_id, end_date) {

    let is_api = _this.data('api');
    is_api = is_api ? is_api : 0;
    let select_start_date = _this.find("[data-name='start-date-selected']").html()
    let select_end_date = _this.find("[data-name='end-date-selected']").html()

    $("[data-name='startDate']").html(select_start_date)
    $("[data-name='endDate']").html(select_end_date)



    let check_request_tour = $("#typeTourReserve").val();
    console.log(check_request_tour)
    let method_name = (check_request_tour === 'oneDayTour') ? 'getTourById':'callGetTourPackage';
    console.log(check_request_tour)

    const dates = $('[data-name="package-dates"]')
    dates.find("button").each(function () {
        $(this).removeClass(
           "active"
        )
        if (start_date === $(this).data("start-date")) {

            $(this).addClass(
               "active"
            )
        }
    })


    const link_to_package=$("[data-name='link-to-package']");
    const page_link=$("input[name='page-url']").val();

    link_to_package.attr('href',page_link+'#result-data-click');
    $('.text-package-tooltip').removeClass('tooltiptext-green').text(useXmltag("PleaseChooseYourPackage"));
    link_to_package.removeClass('tooltip-green');


    const responsive_dates = $('[data-name="package-responsive-dates"]')
    responsive_dates.find('[data-name="package-responsive-date"]').each(function () {
        $(this).removeClass(
           "active"
        )
        if (start_date === $(this).data("start-date")) {

            $(this).addClass(
               "active"
            )
        }
    })

    let result_packages_data = $("[data-name='result-data']")
    let loading_package = $("[data-name='result-loading']")
    loading_package.removeClass("d-none").addClass("d-flex")

    result_packages_data.html("")
    $.ajax({
        type: "POST",
        url: amadeusPath + "ajax",
        dataType: "json",
        data: JSON.stringify({
            method: method_name,
            className: "reservationTour",
            tour_id: tour_id,
            start_date: start_date,
            end_date: end_date,
            is_api:is_api,
            is_json: true
        }),
        success: async function (response) {

            let starts_array=[]
            response.forEach(async package => {
                let package_item = $('[data-name="package-item"]').clone()
                let package_form = package_item.find("form")


                package_form
                   .find('[name="selectDate"]')
                   .val(start_date + "|" + end_date)
                package_item.attr("data-name", "")
                package_item.removeClass("d-none")
                let package_hotels_item = package_item.find(
                   '[data-name="package-hotels-item"]'
                )


                package_item.find('[data-name="package-hotels-item"]').html("")
                let package_hotel_item = ""


                if(package.hotels.length > 0 && package.hotels !== undefined){
                    package.hotels.forEach(hotel => {
                        console.log("package.hotels.length", package.hotels.length)
                        package_hotel_item = $('[data-name="package-item"]')
                           .find(
                              '[data-name="package-hotel-item"]:first-child'
                           )
                           .clone()

                        package_hotel_item
                           .find('[data-name="has-index"]')
                           .each(function () {
                               const indexes = $(this).data("index")

                               if (indexes) {
                                   if (Array.isArray(indexes)) {
                                       indexes.forEach(item => {
                                           setAttrByValue($(this), item, hotel)
                                       })
                                   } else {
                                       setAttrByValue($(this), indexes, hotel)
                                   }
                               }
                           })

                        let hotel_facilities = package_hotel_item.find(
                           '[data-name="hotel-facilities"]'
                        )
                        hotel_facilities.html("")

                        if(hotel.facilities  !== undefined){
                            hotel.facilities.forEach((facility, facility_index) => {
                                if (facility_index < 6) {
                                    const hotel_facility = $('[data-name="package-item"]')
                                       .find('[data-name="hotel-facility"]:first-child')
                                       .clone()

                                    hotel_facility
                                       .find('[data-name="has-hotel-facility-index"]')
                                       .each(function () {
                                           const indexes = $(this).data("index")

                                           if (indexes) {
                                               if (Array.isArray(indexes)) {
                                                   indexes.forEach(item => {
                                                       setAttrByValue($(this), item, facility)
                                                   })
                                               } else {
                                                   setAttrByValue($(this), indexes, facility)
                                               }
                                           }
                                       })

                                    hotel_facilities.append(hotel_facility)
                                }
                            })
                        }


                        let hotel_gallery = package_hotel_item.find(
                           '[data-name="hotel-gallery"]'
                        )

                        if(hotel.gallery  !== undefined){
                            hotel_gallery.html("")
                            if (hotel.gallery.length > 0) {
                                hotel.gallery.forEach(gallery_item => {
                                    const hotel_gallery_item = $('[data-name="package-item"]')
                                       .find('[data-name="hotel-gallery-item"]:first-child')
                                       .clone()

                                    hotel_gallery_item
                                       .find('[data-name="has-hotel-gallery-item-index"]')
                                       .each(function () {
                                           const indexes = $(this).data("index")

                                           if (indexes) {
                                               if (Array.isArray(indexes)) {
                                                   indexes.forEach(item => {
                                                       setAttrByValue($(this), item, gallery_item)
                                                   })
                                               } else {
                                                   setAttrByValue($(this), indexes, gallery_item)
                                               }
                                           }
                                       })

                                    hotel_gallery.append(hotel_gallery_item)
                                })
                            }
                        }


                        package_hotel_item
                           .find('[data-name="hotel-facilities"]')
                           .each(function () {
                               const indexes = $(this).data("index")

                               if (indexes) {
                                   if (Array.isArray(indexes)) {
                                       indexes.forEach(item => {
                                           setAttrByValue($(this), item, hotel)
                                       })
                                   } else {
                                       setAttrByValue($(this), indexes, hotel)
                                   }
                               }
                           })

                        if(Number(hotel.star_code)> 0){
                            starts_array.push(Number(hotel.star_code))
                        }

                        package_hotels_item.last().append(package_hotel_item)
                    })
                }

                let price_rooms = package_item.find('[data-name="price-rooms"]')
                price_rooms.html("")

                package.rooms.forEach((room,room_index) => {
                    const price_room = $('[data-name="package-item"]')
                       .find('[data-name="price-room"]:first-child')
                       .clone()

                    price_room
                       .find('[data-name="has-package-room-index"]')
                       .each(function () {
                           const indexes = $(this).data("index")
                           if (indexes) {
                               if (Array.isArray(indexes)) {
                                   indexes.forEach(item => {

                                       setAttrByValue($(this), item, room)
                                   })
                               } else {
                                   setAttrByValue($(this), indexes, room)
                               }
                           }
                       })

                    price_rooms.append(price_room)
                    if(room_index > 5) {
                        price_rooms.removeClass('parent-grid-price');
                        price_rooms.addClass('owl-carousel');
                        price_rooms.addClass('owl-theme');
                        price_rooms.addClass('owl-tour-number');
                        price_rooms.addClass('owl-rtl');
                        price_rooms.addClass('owl-loaded owl-drag');
                    }
                })

                package_item
                   .find('[data-name="has-package-index"]')
                   .each(function () {
                       const indexes = $(this).data("index")

                       if (indexes) {
                           if (Array.isArray(indexes)) {
                               indexes.forEach(item => {

                                   setAttrByValue($(this), item, package)
                               })
                           } else {

                               setAttrByValue($(this), indexes, package)
                           }
                       }
                   })


                await result_packages_data.append(package_item)
                await $(".future-date").each(function () {
                    const activeItem = $(this).find(".future-date-item-active")
                    const container = $(this)

                    const containerLeft = container.offset().left
                    const activeItemLeft = activeItem.offset().left
                    const offset = activeItemLeft - containerLeft

                    container.scrollLeft(offset)
                })

            })
            initializeCarousel()
            starts_array=sortAndRemoveDuplicates(starts_array)
            if(starts_array.length){
                $("[data-name='starts_array']").removeClass('d-none')
                $("[data-name='starts_array']").find("[data-name='value']").html(starts_array.join(' '+useXmltag("And")+' '))
            }


            initHotelOwl()
            loading_package.addClass("d-none").removeClass("d-flex")



            // if($('[data-name="package-item"]').hasClass('d-none')){
            //
            //     console.log('hast')
            //     $('.tour-Internal').find('section.box-hotel1.d-none').remove()
            // }
        },
        error: function (error) {
            console.log(error.response)
        },
    })

}

function create_section_tour_one_day(tour_id, start_date,end_date){
    console.log('ssddssssssssssssssssssssss')
    const dates = $('[data-name="package-dates"]')
    dates.find("button").each(function () {
        $(this).removeClass("future-date-item-active site-bg-main-color")
        $(this).addClass(
           "site-bg-main-color-hover site-border-main-color site-main-text-color"
        )
        if (start_date === $(this).data("start-date")) {
            $(this).addClass("future-date-item-active site-bg-main-color")
            $(this).removeClass(
               "site-bg-main-color-hover site-border-main-color site-main-text-color"
            )
        }
    })
    let result_packages_data = $("[data-name='result-data']")
    let loading_package = $("[data-name='result-loading']")
    loading_package.removeClass("d-none").addClass("d-flex")
    $.ajax({
        type: "POST",
        url: amadeusPath + "ajax",
        dataType: "json",
        data: JSON.stringify({
            method: "getTourById",
            className: "reservationTour",
            tour_id,
            is_api,
            is_json: true,
        }),
        success: async function (response) {

            let package_item = $('[data-name="package-item"]').clone()
            let package_form = package_item.find("form");

            package_form
               .find('[name="selectDate"]')
               .val(start_date + "|" + end_date)
            package_item.attr("data-name", "")
            package_item.removeClass("d-none")

            let price_rooms = package_item.find('[data-name="price-rooms"]')
            price_rooms.html("")
            package.rooms.forEach(room => {
                const price_room = $('[data-name="package-item"]')
                   .find('[data-name="price-room"]:first-child')
                   .clone()

                price_room
                   .find('[data-name="has-package-room-index"]')
                   .each(function () {
                       const indexes = $(this).data("index")

                       if (indexes) {
                           if (Array.isArray(indexes)) {
                               indexes.forEach(item => {
                                   setAttrByValue($(this), item, room)
                               })
                           } else {
                               setAttrByValue($(this), indexes, room)
                           }
                       }
                   })

                price_rooms.append(price_room)
            })

        }
    })
}

function triggerTourPackages(_this , tour_id, start_date,end_date) {


    create_section_package_tour_several_date(_this , start_date, tour_id, end_date)

    get_file_package_by_id_tour(_this , start_date, tour_id, end_date)

    /*  if(check_request_tour !=='1'){
      }else{
          create_section_tour_one_day(tour_id, start_date,end_date)
      }*/
}


function get_file_package_by_id_tour(_this, start_date, tour_id, end_date) {
    $.ajax({
        type: "POST",
        url: amadeusPath + "ajax",
        dataType: "json",
        data: JSON.stringify({
            method: "getFilePackageByIdTour",
            className: "reservationTour",
            tour_id: tour_id,
            start_date: start_date,
            end_date: end_date,
            is_json: true
        }),
        success: function (response) {
            const fileLink = $("#fileUrlPackage");

            if (Array.isArray(response) && response.length > 0) {
                const tourFile = response[0]?.tour_file_package ;
                if (tourFile) {
                    const fileUrl = tourFile; // تغییر مهم
                    fileLink
                       .attr("href", fileUrl)
                       .removeClass("d-none")
                       .addClass("file_package");
                } else {
                    fileLink
                       .addClass("d-none")
                       .removeClass("file_package")
                       .attr("href", "");
                }
            } else {
                fileLink
                   .addClass("d-none")
                   .removeClass("file_package")
                   .attr("href", "");
            }
        },
        error: function (error) {
            // console.error(error.responseText || error);
            $("#fileUrlPackage")
               .addClass("d-none")
               .removeClass("file_package")
               .attr("href", "");
        },
    });
}

/**
 * The triggerPackageRoomCount function is used to increase or decrease the number of rooms in a package.
 *
 *
 * @param _this Find the hidden input field and its parent element
 * @param type Determine whether the room count is increased or decreased
 *
 * @return The total price of the package
 *
 */
function triggerPackageRoomCount(_this,type) {

    const room_input=_this.parent().find('input:hidden')
    const each_person = $('#price_per_person').val()
    const max=room_input.attr('max')
    const min=room_input.attr('min')
    const coefficient=room_input.data('coefficient')
    const price=room_input.data('price')
    const visible_value=room_input.parent().find("[data-name='value']")
    let has_custom_room = false ;
    let room_input_parent = room_input.parent().parent().parent().parent();
    let room_input_parent_box = room_input.parent().parent().parent();
    if(room_input.parent().parent().parent().parent().parent().parent().hasClass('owl-tour-number')){
        room_input_parent = room_input.parent().parent().parent().parent().parent().parent().parent();
        room_input_parent_box = room_input.parent().parent().parent().parent().parent();
        has_custom_room = true ;
    }

    const selected_package_price=room_input_parent.find('[data-name="selected-package-price"]')


    const selected_package_prepayment_price=room_input_parent.find('[data-name="selected-package-prepayment-price"]')

    const prepayment_percentage=room_input_parent.find('[data-name=prepayment-percentage]')

    const package_form=room_input_parent.find('form')

    const selected_package_id=package_form.find('input#packageId').val();






    if(type=='increase'){
        if(room_input.val() < max && room_input.data('price') > 0){
            room_input.val(Number(room_input.val())+1)
        }
    }
    if(type=='decrease'){
        if(room_input.val() > min) {
            room_input.val(room_input.val() - 1)
        }
    }

    visible_value.html(room_input.val())
    let final_package_price=0
    let final_prepayment_package_price=0
    let selected_rooms_count=0
    let selected_rooms_type={
        'adult':0,
        'child':0,
        'infant':0,
    }





    let room_string=''

    room_input_parent_box.find('input:hidden[data-name="has-package-room-index"]').each(function(room_count) {

        const each_room_input=$(this)
        const each_room_coefficient=each_room_input.data('coefficient')
        const each_room_index=each_room_input.data('index-name')
        const each_room_price=each_room_input.data('price')
        const each_room_type=each_room_input.data('type')
        const each_room_value=each_room_input.val()

        if(each_person == 1) {
            final_package_price+=(each_room_value*each_room_price*each_room_coefficient)
        }else{
            final_package_price+=(each_room_value*each_room_price)
        }


        selected_rooms_count+=Number(each_room_value*each_room_coefficient)
        if(each_room_value > 0 && each_room_type==='adult' ) {

            selected_rooms_type[each_room_type]+=Number(each_room_coefficient)
        }else{

            selected_rooms_type[each_room_type]+=Number(each_room_value)
        }

        if(each_room_value>0){
            room_string+=each_room_index+':'+each_room_value+'|'
            //     let room_type = '' ;
            //     if(each_room_coefficient == '4'){
            //         room_type = 'fourRoom';
            //         room_string+=room_type+':'+each_room_value+'|'
            //     }
            //     else if(each_room_coefficient == '5'){
            //         room_type = 'fiveRoom';
            //         room_string+=room_type+':'+each_room_value+'|'
            //     }
            //     else if(each_room_coefficient == '6'){
            //         room_type = 'sixRoom';
            //         room_string+=room_type+':'+each_room_value+'|'
            //     }else{
            //     }
        }


    })

    console.log(room_string)
    if(room_string === "" ) {
        // $.alert({
        //     title:  useXmltag("Tourreservation"),
        //     icon: 'fa fa-refresh',
        //     content: useXmltag("NotSetRialAmount"),
        //     rtl: true,
        //     type: 'red'
        // });
    }
    const link_to_package=$("[data-name='link-to-package']");
    const page_link=$("input[name='page-url']").val();

    if(selected_rooms_count > 0)
    {
        package_form.parents('section.box-hotel1').attr('id',selected_package_id);
        link_to_package.attr('href',page_link+'#'+selected_package_id);
        $('.text-package-tooltip').addClass('tooltiptext-green').text('برای رزرو کلیک کنید');
        link_to_package.addClass('tooltip-green');
    }else{

        link_to_package.attr('href',page_link+'#result-data-click');
        $('.text-package-tooltip').removeClass('tooltiptext-green').text(useXmltag("PleaseChooseYourPackage"));
        link_to_package.removeClass('tooltip-green');
    }

    final_prepayment_package_price=((final_package_price*prepayment_percentage.val())/100)
    selected_package_prepayment_price.html(final_prepayment_package_price.toLocaleString("en-US"))

    if(final_prepayment_package_price.toLocaleString("en-US") <= 0){
        selected_package_prepayment_price.hide();
    }else{
        selected_package_prepayment_price.show();
    }
    console.log('--------------------------')
    console.log(selected_rooms_type , selected_rooms_count)
    console.log('---------------------------')
    selected_package_price.html(final_package_price.toLocaleString("en-US"))
    package_form.find('[name="passengerCount"]').val(selected_rooms_count)
    package_form.find('[name="passengerCountADT"]').val(selected_rooms_type['adult'])
    package_form.find('[name="passengerCountCHD"]').val(selected_rooms_type['child'])
    package_form.find('[name="passengerCountINF"]').val(selected_rooms_type['infant'])
    package_form.find('[name="countRoom"]').val(room_string)
    package_form.find('[name="totalPrice"]').val(final_package_price)

}



function clickMe(){
    $('.panel-collapse').collapse('toggle')
}


function flightPath() {
    let sib = event.currentTarget.nextElementSibling;
    sib.classList.toggle("flight-mobile-height");

    let sibIcone = event.currentTarget.querySelector(".flight-mobile-icon > i");
    sibIcone.classList.toggle("fa-plus");
    sibIcone.classList.toggle("fa-minus");
}
function initHotelOwl() {
    $('.owl-hotel-slider1').owlCarousel({
        nav:false,
        dots:false,
        rtl:true,
        loop:false,
        // navText: ["<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 256 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z\"/></svg>","<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 256 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M246.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L178.7 256 41.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z\"/></svg>"],
        margin:2,
        autoplay: true,
        autoplayTimeout: 15000,
        autoplaySpeed:3000,
        responsive:{
            0:{
                items:1,
                nav:false,
            },
            576:{
                items:1,
                nav:false,

            },
            1000:{
                items:1
            }
        }
    });
}

$(document).ready(function(){
    $("#reservation-fix-btn").addClass('d-none');
})
$(function () {
    if(gdsSwitch == 'detailTour') {
        $(window).scroll(function() {
            const inViewport = $('#result-data-click').isInViewport();
            if (inViewport) {
                $('#reservation-fix-btn').addClass('d-none').removeClass('d-flex');
            } else {
                if (($(window).width() <= 576)) {
                    $('#reservation-fix-btn').addClass('d-flex').removeClass('d-none');
                }
            }
        })
    }
});


function getRoomsHotel(obj){
    let hotel_id = $(obj).val() ;
    console.log(hotel_id);

    $.ajax({
        type: "POST",
        url: amadeusPath + "ajax",
        dataType: "json",
        data: JSON.stringify({
            method: "getRoomsTypeHotelPackageTour",
            className: "reservationTour",
            hotel_id,
            is_json: true,
        }),
        success:  function (response){
            let obj_arrival = response.data
            let destination = $('.hotel_rooms_selected')
            destination.html(' ')
            destination.append(' <option value="">انتخاب کنید</option>')
            Object.keys(obj_arrival).forEach(key => {
                let option_text = `${obj_arrival[key]['room_name']}`;
                let option_value = `${obj_arrival[key]['room_name']}`
                let new_option = new Option(option_text, option_value, false, false)
                destination.append(new_option).trigger('open')
            })
            // destination.select2('open')

        }, error: function (error) {
            console.log(error.response)
        },
    })
}
function clickScroll(e){
    $("html").animate({
        scrollTop: $(`#${e}`).offset().top - 10
    }, 1000);
}
function addRoomToPackage(row) {
    var count = $('#countPackage').val();
    var bedCount = $('#room_count').val();
    if(bedCount == ''){
        $.alert({
            title: "error",
            icon: 'fa fa-refresh',
            content: useXmltag("fillBedCount"),
            rtl: true,
            type: 'red'
        });
    }
    if(bedCount != ''){
        $.post(amadeusPath + 'tour_ajax.php',
           {
               bedCount: bedCount,
               countPackage: count,
               flag: "insertRoomToPackage"
           },
           function (data) {
               $(`#rowRooBed${row}`).append(data);
               // $('#countPackage').val(count);
               $("#ModalPublicContent2").removeClass('d-flex');

               setTimeout(function () {
                   $(".modal-backdrop").remove()
                   $(`#modal${row} select option[value="${bedCount}"]`).attr("disabled","disabled");
               }, 500);
           });
    }
}

function closeModalBed() {

    $('#ModalPublicContent2').removeClass('d-flex');

}
function initializeCarousel(){
    $('.owl-tour-number').owlCarousel({
        rtl:true,
        loop:false,
        navText: ["<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 256 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M233 239c9.4 9.4 9.4 24.6 0 33.9L73 433c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l143-143L39 113c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0L233 239z\"/></svg>","<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 256 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M7 239c-9.4 9.4-9.4 24.6 0 33.9L167 433c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9L57.9 256 201 113c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L7 239z\"/></svg>"],
        margin:5,
        stagePadding: 50,
        dots: false,
        autoplay: false,
        autoplayTimeout: 15000,
        autoplaySpeed:3000,
        nav:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2,
            },
            1000:{
                items:5,
            }
        }
    });
}
function modalAddRoom(row) {
    var count = $('#countPackage').val();
    //$('.loaderPublicForHotel').fadeIn(700);
    setTimeout(function () {
        $('.loaderPublicForHotel').fadeOut(500);
        $("#ModalPublicContent2").toggleClass('d-flex');
    }, 300);

    $.post(amadeusPath + 'tour_ajax.php',
       {
           flag: "modalAddRoomCount" ,
           countPackage: row,
       },
       function (data) {
           $('#ModalPublicContent2').html(data);
       });

}

$.fn.isInViewport = function() {
    var elementTop = $(this).offset().top;
    var elementBottom = elementTop + $(this).outerHeight();

    var viewportTop = $(window).scrollTop();
    var viewportBottom = viewportTop + $(window).height();

    return elementBottom > viewportTop && elementTop < viewportBottom;
};
// $(window).scroll(function() {
//     let w = window.innerWidth;
//     if ($(this).scrollTop() > 300){
//         $('.box-title-tour').addClass('fixed-menu-tour');
//     }
//     else{
//         $('.box-title-tour').removeClass('fixed-menu-tour');
//     }
// });


$(window).scroll(function() {
    var scroll = $(window).scrollTop();
    var cover_height = ($('.cover-img-tour').height())-40
    let header =0
    if($('.header_area').length){
        header = $('.header_area').height()
    }
    if (($(window).width() <= 767)) {
        $('#reservation-fix-btn').addClass('d-flex').removeClass('d-none');
        if (scroll >= (header+cover_height)) {
            $(".box-title-tour").addClass("darkHeader");
            $('section.tour-Internal').css('margin-top',$(".box-title-tour").height()+'px')
        } else {
            $(".box-title-tour").removeClass("darkHeader");
            $('section.tour-Internal').css('margin-top','0px')

        }
    }
});
