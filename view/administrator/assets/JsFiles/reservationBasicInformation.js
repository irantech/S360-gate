$(document).ready(function () {
    $('.js-switch').each(function() {
        new Switchery($(this)[0], $(this).data());
    });
    $('.dropify').dropify();



    /////////////////نوع وسیله نقلیه/////////////////
    ////////////////////////////////////////////////
    $("#FormTypeOfVehicle").validate({
        rules: {
            vehicle_name: "required",
            vehicle_type: "required"
        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {
                    
                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن تغییرات قیمت جدید',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location ='typeOfVehicle';
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن تغییرات قیمت جدید',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }


                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }

    });

    $("#EditTypeOfVehicle").validate({
        rules: {
            vehicle_name: "required",
            vehicle_type: "required"
        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {
                    
                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن تغییرات وسیله نقلیه',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location ='typeOfVehicleEdit&id=' + res[2];
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن تغییرات وسیله نقلیه',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }


                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }

    });



    /////////////////مدل وسیله نقلیه/////////////////
    ////////////////////////////////////////////////
    $("#FormVehicleModel").validate({
        rules: {
            vehicle_model: "required"
        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {
                    
                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن تغییرات وسیله نقلیه',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location ='vehicleModel&id=' + res[2];
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن تغییرات وسیله نقلیه',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }


                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }

    });

    $("#EditVehicleModel").validate({
        rules: {
            vehicle_model: "required"
        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {
                    
                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن تغییرات مدل وسیله نقلیه',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location ='vehicleModelEdit&id=' + res[2];
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن تغییرات مدل وسیله نقلیه',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }


                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }

    });



    /////////////////درجه وسیله نقلیه/////////////////
    ////////////////////////////////////////////////
    $("#FormVehicleGrade").validate({
        rules: {
            vehicle_grade: "required"
        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {
                    
                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن تغییرات وسیله نقلیه',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location ='vehicleGrade';
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن تغییرات وسیله نقلیه',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }


                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }

    });

    $("#EditVehicleGrade").validate({
        rules: {
            vehicle_grade: "required"
        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {
                    
                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن تغییرات درجه وسیله نقلیه',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location ='vehicleGradeEdit&id=' + res[2];
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن تغییرات درجه وسیله نقلیه',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }


                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }

    });




    /////////////////تعریف کشور / شهر/////////////////
    ////////////////////////////////////////////////
    $("#FormCountry").validate({
        rules: {
            country_code: "required"
        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {
                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        // alert('aaa');
                        // alert(res[1])
                        $.toast({
                            heading: 'افزودن کشور',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location ='country&id='+ res[2];
                        }, 1000);

                    } else {

                        $.toast({
                            heading: 'افزودن کشور',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }


                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }

    });

    $("#EditCountry").validate({
        rules: {
            country_name: "required"
        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {
                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن تغییرات کشور',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location ='countryEdit&id='+ res[2];
                        }, 1000);

                    } else {

                        $.toast({
                            heading: 'افزودن تغییرات کشور',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }


                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }

    });

    $("#FormCity").validate({
        rules: {
            city_name: "required"
        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {

                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن شهر',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location ='city&id=' + res[2];
                        }, 1000);

                    } else {

                        $.toast({
                            heading: 'افزودن شهر',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }


                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }

    });

    $("#EditCity").validate({
        rules: {
            city_name: "required"
        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {
                    
                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن تغییرات شهر',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location ='cityEdit&id=' + res[2];
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن تغییرات شهر',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }


                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }

    });

    $("#FormRegion").validate({
        rules: {
            region_name: "required"
        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {
                    
                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن منطقه',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location ='region&id=' + res[2];
                        }, 1000);

                    } else {

                        $.toast({
                            heading: 'افزودن منطقه',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }


                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }

    });

    $("#EditRegion").validate({
        rules: {
            region_name: "required"
        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {
                    
                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن تغییرات منطقه',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location ='regionEdit&id=' + res[2];
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن تغییرات منطقه',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }


                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }

    });

    //For Upload File
    $('.dropify').dropify();



    /////////////////عنوان اتاق/////////////////
    ////////////////////////////////////////////////
    $("#FormRoomType").validate({
        rules: {
            comment: "required"
        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {

                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن تغییرات عنوان اتاق',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location = res[2];
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن تغییرات عنوان اتاق',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }


                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }

    });

    $("#EditRoomType").validate({
        rules: {
            comment: "required"
        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {
                    
                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن تغییرات عنوان اتاق',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location = res[2];
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن تغییرات عنوان اتاق',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }


                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }

    });



    /////////////////اضافه کردن هتل/////////////////
    ////////////////////////////////////////////////
    $("#FormHotelAdd").validate({
        rules: {
            name: "required",
            name_en: "required"
        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
          console.log(form)
            CKEDITOR.instances.comment.updateElement()
            CKEDITOR.instances.comment_en.updateElement()
            CKEDITOR.instances.distance_to_important_places.updateElement()
            CKEDITOR.instances.distance_to_important_places_en.updateElement()
            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {

                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن تغییرات هتل',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location ='hotelAdd';
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن تغییرات هتل',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }


                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }

    });

    $("#EditHotel").validate({
        rules: {
            hotel_name: "required",
            hotel_name_en: "required"
        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            CKEDITOR.instances.comment.updateElement()
            CKEDITOR.instances.comment_en.updateElement()
            CKEDITOR.instances.distance_to_important_places.updateElement()
            CKEDITOR.instances.distance_to_important_places_en.updateElement()
            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {

                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن تغییرات هتل',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location ='hotelEdit&id=' + res[2];
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن تغییرات هتل',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }


                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }

    });


    /////////////////اضافه کردن گالری هتل/////////////////
    /////////////////////////////////////////////////////
    $("#FormGallery").validate({
        rules: {
            pic: "required"
        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {

                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن تغییرات هتل',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location = res[2];
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن تغییرات هتل',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }


                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }

    });

    $("#EditGallery").validate({
        rules: {

        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {
                    
                    var res = response.split(':');
                    var page = $('#table_name').val();
                    if (page == 'reservation_hotel_gallery_tb'){
                        var link = 'editHotelGallery';
                    }else {
                        var link = 'editRoomGallery';
                    }

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن تغییرات هتل',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location = link + '&id=' + res[2];
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن تغییرات هتل',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }


                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }

    });


    $("#EditFacilities").validate({
        rules: {
            title: "required"

        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {

                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن تغییرات هتل',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location = 'facilitiesAdd';
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن تغییرات هتل',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }


                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }

    });


    /////////////////اضافه کردن اتاق هتل/////////////////
    /////////////////////////////////////////////////////
    $("#FormHotelRoom").validate({
        rules: {
            room_title: "required",
            room_name_en: "required",
            room_capacity: "required",
            maximum_extra_beds: "required",
            maximum_extra_chd_beds:"required"
        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            let id = $('#id_hotel').val();
            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {
                    
                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن تغییرات هتل',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location ='addHotelRoom&id=' + id;
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن تغییرات هتل',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }


                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }

    });

    $("#EditHotelRoom").validate({
        rules: {
            room_title: "required",
            room_name_en: "required",
            room_capacity: "required",
            maximum_extra_beds: "required",
            maximum_extra_chd_beds:"required"
        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {
                    
                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن تغییرات هتل',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location ='editHotelRoom&id=' + res[2];
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن تغییرات هتل',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }


                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }

    });


    /////////////////اضافه کردن امکانات هتل و اتاق/////////////////
    /////////////////////////////////////////////////////
    $("#FormFacilities").validate({
        rules: {
            title: "required",
            radio: "required"
        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {
                    
                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن تغییرات هتل',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location ='facilitiesAdd';
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن تغییرات هتل',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }


                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }

    });

    $("#Facilities").validate({
        rules: {

        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {
                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن تغییرات هتل',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            window.location = res[2];
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن تغییرات هتل',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }


                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }

    });




    //// اضافه کردن شرکت حمل و نقل
    $("#FormTransportCompanies").validate({
        rules: {
            name: "required"
        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {

                    var res = response.split(':');
                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن تغییرات',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            location.reload();
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن تغییرات',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }


                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }

    });



    $("#EditTransportCompanies").validate({
        rules: {
            name: "required"
        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {

            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {

                    var res = response.split(':');
                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن تغییرات',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            location.reload();
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن تغییرات',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }


                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }

    });







    /////////////////نوع تور/////////////////
    $("#FormTouType").validate({
        rules: {
            tour_type: "required"
        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {

                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'افزودن نوع تور',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            location.reload();
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'افزودن نوع تور',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }


                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }

    });

    $("#FormTouTypeEdit").validate({
        rules: {
            tour_type: "required"
        },
        messages: {

        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'hotel_ajax.php',
                type: "post",
                success: function (response) {

                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'تغییرات نوع تور',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                        setTimeout(function(){
                            location.reload();
                        }, 1000);


                    } else {

                        $.toast({
                            heading: 'تغییرات نوع تور',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }


                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }

    });






});

function changeVisaTypeMoreDetail(thiss) {
    $.ajax({
        type: 'post',
        url: amadeusPath + 'visa_ajax.php',
        data:{
                flag:'changeVisaTypeMoreDetail',
                value:thiss.val(),
                country_id:thiss.attr('data-countryId'),
                visaType_id:thiss.attr('data-visatypeid')
            },
        success: function (data) {
            console.log(data);
            $.toast({
                heading: 'ذخیره شد',
                text: '',
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'success',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });
        }
    })
}

//////////حذف منطقی///////
function logical_deletion(id, tableName)
{
    $.confirm({
        theme: 'supervan' ,// 'material', 'bootstrap'
        title: 'حذف تغییرات',
        icon: 'fa fa-trash',
        content: 'آیا از حذف تغییرات اطمینان دارید',
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: 'تایید',
                btnClass: 'btn-green',
                action: function () {
                    $.post(amadeusPath + 'hotel_ajax.php',
                        {
                            id: id,
                            tableName: tableName,
                            flag: 'logicalDeletion'
                        },
                        function (data) {

                            var res = data.split(':');

                            if (data.indexOf('success') > -1)
                            {

                                $.toast({
                                    heading: 'حذف تغییرات',
                                    text: res[1],
                                    position: 'top-right',
                                    loaderBg: '#fff',
                                    icon: 'success',
                                    hideAfter: 3500,
                                    textAlign: 'right',
                                    stack: 6
                                });

                                setTimeout(function () {
                                    location.reload();
                                }, 1000);

                            }else {
                                $.toast({
                                    heading: 'حذف تغییرات',
                                    text: res[1],
                                    position: 'top-right',
                                    loaderBg: '#fff',
                                    icon: 'error',
                                    hideAfter: 3500,
                                    textAlign: 'right',
                                    stack: 6
                                });

                            }

                        });
                }
            },
            cancel: {
                text: 'انصراف',
                btnClass: 'btn-orange'
            }
        }
    });
}
function toggleApproveTourType(type_id) {
    $.ajax({
        type: 'post',
        url: amadeusPath + 'ajax',
        dataType:'json',
        data:JSON.stringify({
            method: 'toggleApproveTourType',
            className: 'resultTourLocal',
            type_id: type_id
        }),
        success: function (data) {
            console.log(data);
            $.toast({
                heading: 'ذخیره شد',
                text: '',
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'success',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });
        }
    })
}

function toggleFavoriteCountry(country_id) {
    $.ajax({
        type: 'post',
        url: amadeusPath + 'ajax',
        dataType:'json',
        data:JSON.stringify({
            method: 'toggleFavoriteCountry',
            className: 'country',
            country_id: country_id
        }),
        success: function (data) {
            console.log(data);
            $.toast({
                heading: 'ذخیره شد',
                text: '',
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'success',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });
            // Reload page to show updated sort order
            setTimeout(function() {
                location.reload();
            }, 1000);
        },
        error: function (xhr, status, error) {
            $.toast({
                heading: 'خطا',
                text: 'خطا در تغییر ترتیب نمایش کشور',
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'error',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });
        }
    })
}

function toggleFavoriteContinent(continent_id) {
    $.ajax({
        type: 'post',
        url: amadeusPath + 'ajax',
        dataType:'json',
        data:JSON.stringify({
            method: 'toggleFavoriteContinent',
            className: 'country',
            continent_id: continent_id
        }),
        success: function (data) {
            console.log(data);
            $.toast({
                heading: 'ذخیره شد',
                text: '',
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'success',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });
            // Reload page to show updated sort order
            setTimeout(function() {
                location.reload();
            }, 1000);
        }
    })
}

function setSortOrder(type, id, sortOrder) {
    var method, idParam;
    
    if (type === 'country') {
        method = 'toggleFavoriteCountry';
        idParam = 'country_id';
    } else if (type === 'continent') {
        method = 'toggleFavoriteContinent';
        idParam = 'continent_id';
    }
    
    var data = {
        method: method,
        className: 'country',
        sort_order: parseInt(sortOrder)
    };
    data[idParam] = id;
    
    $.ajax({
        type: 'post',
        url: amadeusPath + 'ajax',
        dataType:'json',
        data: JSON.stringify(data),
        success: function (response) {
            console.log(response);
            $.toast({
                heading: 'ذخیره شد',
                text: 'ترتیب نمایش با موفقیت تغییر یافت',
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'success',
                hideAfter: 2000,
                textAlign: 'right',
                stack: 6
            });
            // Reload page to show updated sort order
            setTimeout(function() {
                location.reload();
            }, 1000);
        },
        error: function (xhr, status, error) {
            $.toast({
                heading: 'خطا',
                text: 'خطا در تغییر ترتیب نمایش',
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'error',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });
        }
    });
}

function showHotelOnSite(idHotel, isShow) {
    if (isShow == 'yes') {
        var detail = $('#price').val();
    } else {
        var detail = $('#comment_cancel_text').val();
    }

    $.confirm({
        theme: 'supervan',// 'material', 'bootstrap'
        title: 'تائید نمایش هتل',
        icon: 'fa fa-trash',
        content: 'آیا از تائید نمایش هتل اطمینان دارید',
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: 'تایید',
                btnClass: 'btn-green',
                action: function () {
                    $.post(amadeusPath + 'hotel_ajax.php',
                      {
                          idHotel: idHotel,
                          isShow: isShow,
                          detail: detail,
                          flag: 'isShowHotel'
                      },
                      function (response) {

                          var res = response.split(':');
                          if (response.indexOf('success') > -1) {

                              $.toast({
                                  heading: 'نمایش هتل',
                                  text: res[1],
                                  position: 'top-right',
                                  loaderBg: '#fff',
                                  icon: 'success',
                                  hideAfter: 3500,
                                  textAlign: 'right',
                                  stack: 6
                              });

                              setTimeout(function () {
                                  window.location ='marketHotel'
                              }, 1000);


                          } else {

                              $.toast({
                                  heading: 'نمایش هتل',
                                  text: res[1],
                                  position: 'top-right',
                                  loaderBg: '#fff',
                                  icon: 'error',
                                  hideAfter: 3500,
                                  textAlign: 'right',
                                  stack: 6
                              });

                          }

                      });
                }
            },
            cancel: {
                text: 'انصراف',
                btnClass: 'btn-orange'
            }
        }
    });
}

function showDiv(id) {
    $('#' + id).removeClass('displayN');
    $('html, body').animate({scrollTop: $('#' + id).offset().top}, 'slow');
}
