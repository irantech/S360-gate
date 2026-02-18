function syncCKEditorsAll() {
    if (window.CKEDITOR) {
        for (var k in CKEDITOR.instances) {
            CKEDITOR.instances[k].updateElement();
        }
    }
}

$(document).ready(function() {
    $('.js-switch').each(function () {
        new Switchery($(this)[0], $(this).data());
    });
    $(".Select2Tag").select2();
    $("#EditEntertainment").validate({
        rules: {
            "title[]": "required",
            "price[]": "required",
            "EntertainmentSubCategory[]": "required",
            "description[]": "required",
            "EntertainmentCountryTitle[]" : "required" ,
            "EntertainmentCityTitle[]" : "required"
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
            syncCKEditorsAll();
            console.log($('[name="description[]"]').val());
            $(form).ajaxSubmit({
                url: amadeusPath + 'entertainment_ajax.php',
                type: "post",
                success: function (response) {
                    var JsonData = JSON.parse(response);


                    if (JsonData.result_status == 'success') {
                        $.toast({
                            heading: 'ثبت تغییرات',
                            text:JsonData.result_message,
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });
                        window.location.reload();

                    } else {

                        $.toast({
                            heading: 'ثبت تغییرات',
                            text: JsonData.result_message,
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
        } ,
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }

    });


    $("#AddEntertainment").validate({
        rules: {
            "title[]": "required",
            "price[]": "required",
            "tour_price[]": "required",
            "category_id[]": "required",
            "EntertainmentCountryTitle[]": "required",
            "EntertainmentCityTitle[]": "required",
            // "description[]": "required"
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
            CKEDITOR.instances.description.updateElement()
            $(form).ajaxSubmit({
                url: amadeusPath + 'entertainment_ajax.php',
                type: "post",
                success: function (response) {
                    var JsonData = JSON.parse(response);


                    if (JsonData.result_status == 'success') {
                        $.toast({
                            heading: 'ثبت تفریح جدید',
                            text:JsonData.result_message,
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });
                        window.location.reload();

                    } else {

                        $.toast({
                            heading: 'ثبت تفریح جدید',
                            text: JsonData.result_message,
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
function RemoveDataTable(thiss){
    thiss.parent().parent().parent().remove();
    var CountDivInEach=0;
    $('.DynamicDataTable input[data-parent="DataTableValues"]').each(function () {
        $(this).attr('name', 'DataTable[' + CountDivInEach + '][' + $(this).attr("data-target") + ']');
        if($(this).attr("data-target") == 'body'){
            CountDivInEach=CountDivInEach + 1;
        }
    })
}
function AddDataTable(){
    var CountDiv=$('div[data-target="BaseDataTableDiv"]').length;
    var BaseDiv=$('div[data-target="BaseDataTableDiv"]:last-child');
    var CloneBaseDiv=$('div[data-target="BaseDataTableDiv"]:last-child').clone();
    var CountDivInEach=0;

    CloneBaseDiv.find('input').val('');
    $('div[data-target="BaseDataTableDiv"]:last-child').after(CloneBaseDiv);

    $('.DynamicDataTable input[data-parent="DataTableValues"]').each(function () {
        $(this).attr('name', 'DataTable[' + CountDivInEach + '][' + $(this).attr("data-target") + ']');
        if($(this).attr("data-target") == 'body'){
            CountDivInEach=CountDivInEach + 1;
        }
    })
}

function EntertainmentTypeClick(thiss,value){
    $('div[data-target="IconBoxSelector"] .border').each(function (){
        $(this).removeClass('active');
    });
    thiss.addClass('active');
    $('input[name="EntertainmentTypeIcon"]').val(value);
}
function EntertainmentTypeEdit(thiss,id){
    EntertainmentTypeCloseEdit();
    $.ajax({
        type: 'post',
        url: libraryPath + 'ModalCreatorForEntertainment.php',
        data: {
            Controller: 'entertainment',
            Method: 'ModalGetEntertainmentTypeData',
            Param: id
        },
        success: function (data) {
            var JsonData = JSON.parse(data);

            var tr='';
            $.each(JsonData.data, function(i, item) {
                $('input[name="EntertainmentTypeName"]').val(item.title);
                $('div[data-target="IconBoxSelector"][data-value$="'+item.logo+'"] .border').addClass('active');
                $('[data-target="SubmitForm"]').html('به روز رسانی');
                $('[data-target="SubmitForm"]').after('<button data-target="CloseEditForm" type="button" onclick="EntertainmentTypeCloseEdit()" class="btn btn-danger mt-4">بستن ویرایش</button>');
                $('[name="FormStatus"]').val(item.id);
            });



        }
    });
}
function ManageAcceptEntertainment(thiss,id){


    $.ajax({
        type: 'post',
        url: amadeusPath +"/entertainment_ajax.php",
        data: {
            flag: 'manageAcceptEntertainment',
            action:thiss.data('action'),
            id: id
        },
        success: function (data) {
            var JsonData = JSON.parse(data);

            console.log(JsonData);
            console.log(thiss.data('action'));
            if(thiss.children('i').hasClass('btn-danger')){
                thiss.attr('data-action','reject');
                thiss.children('i').attr('data-original-title','تایید شده');
                thiss.children('i').addClass('btn-success').removeClass('btn-danger');
                thiss.children('i').addClass('fa-check').removeClass('fa-ban');
            }else{
                thiss.attr('data-action','accept');
                thiss.children('i').attr('data-original-title','پنهان');
                thiss.children('i').addClass('btn-danger').removeClass('btn-success');
                thiss.children('i').addClass('fa-ban').removeClass('fa-check');
            }



        }
    });
}
function EntertainmentTypeCloseEdit(){
    $('input[name="EntertainmentTypeName"]').val('');
    $('div[data-target="IconBoxSelector"] .border').each(function (){
        $(this).removeClass('active');
    });
    $('input[name="EntertainmentTypeIcon"]').val('');
    $('[data-target="SubmitForm"]').html('اضافه کردن');
    $('[data-target="CloseEditForm"]').remove();
    $('[name="FormStatus"]').val('new');
}
function GetEntertainmentTypeData(){
    $.ajax({
        type: 'post',
        url: libraryPath + 'ModalCreatorForEntertainment.php',
        data: {
            Controller: 'entertainment',
            Method: 'ModalGetEntertainmentTypeData',
            Param: ''
        },
        success: function (data) {
            var JsonData = JSON.parse(data);

            var tr='';
            $.each(JsonData.data, function(i, item) {
                tr = tr + '<tr>' +
                   '<td>'+item.title+'</td>' +
                   '<td><span class="mdi '+item.logo+'"></span></td>' +
                   '<td><button onclick="EntertainmentTypeEdit($(this),'+item.id+')" class="btn btn-info"><span class="fa fa-edit"></span></button></td>' +
                   '<td><button onclick="SubmitRemoveEntertainmentType('+item.id+')" class="btn btn-danger"><span class="fa fa-remove"></span></button></td>' +
                   '</tr>';
            });
            $('#AllEntertainmentType').html(tr);
        }
    });
}
function AddEntertainmentType(LevelId){


    $.ajax({
        type: 'post',
        url: libraryPath + 'ModalCreatorForEntertainment.php',
        data: {
            Controller: 'entertainment',
            Method: 'ModalShowAddType',
            Param: LevelId
        },
        success: function (data) {
            $('#ModalPublic').modal('show');
            $('#ModalPublic').html(data);

            GetEntertainmentTypeData();
            $('.select2').select2();
        }
    });

}
function SubmitNewEntertainmentType(){
    var FilterData = $('#NewEntertainmentType').serialize();
    $.ajax({
        type: 'post',
        url: libraryPath + 'ModalCreatorForEntertainment.php',
        data: {
            Controller: 'entertainment',
            Method: 'ModalAddType',
            Param: FilterData
        },
        success: function (data) {

            var JsonData = JSON.parse(data);
            var res = JsonData.status.split(':');
            if (JsonData.status.indexOf('success') > -1) {
                $.toast({
                    heading: 'آپشن های تفریحات',
                    text:  res[1],
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            }else{
                $.toast({
                    heading: 'آپشن های تفریحات',
                    text: res[1],
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            }
            $('[name="EntertainmentTypeName"]').val('');
            $('[name="EntertainmentTypeIcon"]').val('');
            $('div[data-target="IconBoxSelector"] .border').each(function (){
                $(this).removeClass('active');
            });
            GetEntertainmentTypeData();
        }
    });

}
function SubmitRemoveEntertainmentType(id){

    $.confirm({
        theme: 'bootstrap' ,// 'material', 'bootstrap'
        title: 'حذف',
        icon: 'fa fa-trash',
        content: 'آیا از حذف اطمینان دارید؟',
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: 'تایید',
                btnClass: 'btn-green',
                action: function () {
                    $.ajax({
                        type: 'post',
                        url: libraryPath + 'ModalCreatorForEntertainment.php',
                        data: {
                            Controller: 'entertainment',
                            Method: 'ModalRemove',
                            Param: id
                        },
                        success: function (data) {
                            var JsonData = JSON.parse(data);

                            var res = JsonData.status.split(':');
                            if (JsonData.status.indexOf('success') > -1) {
                                $.toast({
                                    heading: 'آپشن های تفریحات',
                                    text:  res[1],
                                    position: 'top-right',
                                    loaderBg: '#fff',
                                    icon: 'success',
                                    hideAfter: 3500,
                                    textAlign: 'right',
                                    stack: 6
                                });
                            }else{
                                $.toast({
                                    heading: 'آپشن های تفریحات',
                                    text: res[1],
                                    position: 'top-right',
                                    loaderBg: '#fff',
                                    icon: 'error',
                                    hideAfter: 3500,
                                    textAlign: 'right',
                                    stack: 6
                                });
                            }
                            GetEntertainmentTypeData();
                        }
                    });
                }
            },
            cancel: {
                text: 'انصراف',
                btnClass: 'btn-orange',
            }
        }
    });



}



function SubmitRemoveEntertainmentCategory(id){

    $.confirm({
        theme: 'bootstrap' ,// 'material', 'bootstrap'
        title: 'حذف',
        icon: 'fa fa-trash',
        content: 'آیا از حذف اطمینان دارید؟',
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: 'تایید',
                btnClass: 'btn-green',
                action: function () {
                    $.ajax({
                        type: 'post',
                        url: libraryPath + 'ModalCreatorForEntertainment.php',
                        data: {
                            Controller: 'entertainment',
                            Method: 'RemoveEntertainmentCategory',
                            Param: id
                        },
                        success: function (data) {
                            var JsonData = JSON.parse(data);

                            var res = JsonData.status.split(':');
                            if (JsonData.status.indexOf('success') > -1) {
                                $.toast({
                                    heading: 'دسته بندی تفریحات',
                                    text:  res[1],
                                    position: 'top-right',
                                    loaderBg: '#fff',
                                    icon: 'success',
                                    hideAfter: 3500,
                                    textAlign: 'right',
                                    stack: 6
                                });
                            }else{
                                $.toast({
                                    heading: 'دسته بندی تفریحات',
                                    text: res[1],
                                    position: 'top-right',
                                    loaderBg: '#fff',
                                    icon: 'error',
                                    hideAfter: 3500,
                                    textAlign: 'right',
                                    stack: 6
                                });
                            }
                            window.location.reload();
                        }
                    });
                }
            },
            cancel: {
                text: 'انصراف',
                btnClass: 'btn-orange',
            }
        }
    });



}
function SubmitRemoveEntertainment(id){

    $.confirm({
        theme: 'bootstrap' ,// 'material', 'bootstrap'
        title: 'حذف',
        icon: 'fa fa-trash',
        content: 'آیا از حذف اطمینان دارید؟',
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: 'تایید',
                btnClass: 'btn-green',
                action: function () {
                    $.ajax({
                        type: 'post',
                        url: libraryPath + 'ModalCreatorForEntertainment.php',
                        data: {
                            Controller: 'entertainment',
                            Method: 'RemoveEntertainment',
                            Param: id
                        },
                        success: function (data) {
                            var JsonData = JSON.parse(data);

                            var res = JsonData.status.split(':');
                            if (JsonData.status.indexOf('success') > -1) {
                                $.toast({
                                    heading: ' تفریحات',
                                    text:  res[1],
                                    position: 'top-right',
                                    loaderBg: '#fff',
                                    icon: 'success',
                                    hideAfter: 3500,
                                    textAlign: 'right',
                                    stack: 6
                                });
                            }else{
                                $.toast({
                                    heading: ' تفریحات',
                                    text: res[1],
                                    position: 'top-right',
                                    loaderBg: '#fff',
                                    icon: 'error',
                                    hideAfter: 3500,
                                    textAlign: 'right',
                                    stack: 6
                                });
                            }
                            window.location.reload();
                        }
                    });
                }
            },
            cancel: {
                text: 'انصراف',
                btnClass: 'btn-orange',
            }
        }
    });



}
function SubmitNewEntertainmentCategory(){
    var FilterData = $('#FormSubmitNewEntertainmentCategory').serialize();
    $.ajax({
        type: 'post',
        url: libraryPath + 'ModalCreatorForEntertainment.php',
        data: {
            Controller: 'entertainment',
            Method: 'ModalNewEntertainmentCategory',
            Param: FilterData
        },
        success: function (data) {
            var JsonData = JSON.parse(data);

            var res = JsonData.status.split(':');
            if (JsonData.status.indexOf('success') > -1) {
                $.toast({
                    heading: 'دسته بندی تفریحات',
                    text:  res[1],
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            }else{
                $.toast({
                    heading: 'دسته بندی تفریحات',
                    text: res[1],
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            }
            window.location.reload();
        }
    });
}

function EntertainmentEditCategory(id){

    $.ajax({
        type: 'post',
        url: libraryPath + 'ModalCreatorForEntertainment.php',
        data: {
            Controller: 'entertainment',
            Method: 'ModalShowEditCategory',
            Param: id
        },
        success: function (data) {
            $('#ModalPublic').modal('show');
            $('#ModalPublic').html(data);



        }
    });
}
function SubmitEditEntertainmentCategory(){
    var FilterData = $('#EditEntertainmentCategory').serialize();
    $.ajax({
        type: 'post',
        url: libraryPath + 'ModalCreatorForEntertainment.php',
        data: {
            Controller: 'entertainment',
            Method: 'ModalNewEntertainmentCategory',
            Param: FilterData
        },
        success: function (data) {
            var JsonData = JSON.parse(data);

            var res = JsonData.status.split(':');
            if (JsonData.status.indexOf('success') > -1) {
                $.toast({
                    heading: 'دسته بندی تفریحات',
                    text:  res[1],
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            }else{
                $.toast({
                    heading: 'دسته بندی تفریحات',
                    text: res[1],
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            }
            window.location.reload();
        }
    });
}
function GetSubCategoriesOnSelectBox(thiss){
    $.ajax({
        type: 'post',
        url: libraryPath + 'ModalCreatorForEntertainment.php',
        data: {
            Controller: 'entertainment',
            Method: 'GetSubCategories',
            Param: thiss.val()
        },
        success: function (data) {
            var JsonData = JSON.parse(data);

            var res = JsonData.status.split(':');
            if (JsonData.status.indexOf('success') > -1) {
                // console.log(JsonData.data);
                $('#EntertainmentSubCategory').html(JsonData.data);
            }else{

            }



        }
    });
}
function SubmitRemoveEntertainmentGallery(GalleryId,IsTable=false){
    $.ajax({
        type: 'post',
        url: amadeusPath +"/entertainment_ajax.php",
        data: {
            GalleryId:GalleryId,
            flag:'RemoveSingleGallery'
        },
        success: function (data) {
            var JsonData = JSON.parse(data);
            if(JsonData.result_status == 'success'){
                $.toast({
                    heading: 'ثبت تغییرات',
                    text: JsonData.result_message,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });

                if(IsTable != false){
                    IsTable.parent().parent().remove();
                }

            } else {

                $.toast({
                    heading: 'ثبت تغییرات',
                    text: JsonData.result_message,
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
}
function GetEntertainmentGalleryData(entertainment_id){
    $.ajax({
        type: 'post',
        url: amadeusPath +"/entertainment_ajax.php",
        data: {
            flag:'GetEntertainmentGalleryData',
            entertainment_id:entertainment_id,
        },
        success: function (data) {
            var JsonData = JSON.parse(data);

            var tr='';
            var counter=1;
            $.each(JsonData.data, function(i, item) {
                tr = tr + '<tr>' +
                   '<td>'+counter+'</td>' +
                   '<td><img src="..\\..\\pic\\entertainment\\'+item.file+'" alt=""></td>' +
                   '<td><button onclick="SubmitRemoveEntertainmentGallery('+item.id+',$(this))" class="btn btn-danger"><span class="fa fa-remove"></span></button></td>' +
                   '</tr>';
                counter=counter +1;
            });
            $('#AllEntertainmentGallery').html(tr);
        }
    });
}

function entertainmentCategoryApproval(id) {
    $.ajax({
        type: 'POST',
        url: amadeusPath + 'entertainment_ajax.php',
        dataType: 'JSON',
        data: {
            flag: 'changeCategoryApproval',
            id: id
        },
        success: function (response) {

            if (response.result_status == 'success') {
                var displayIcon = 'success';
            } else {
                var displayIcon = 'error';
            }

            $.toast({
                heading: 'وضعیت دسته بندی',
                text: response.result_message,
                position: 'top-right',
                loaderBg: '#fff',
                icon: displayIcon,
                hideAfter: 1000,
                textAlign: 'right',
                stack: 6
            });

        }
    });

}

function getSelectBoxCities(country_id,city_id=null) {
    var citiesArray = ""
    $.ajax({
        type: "POST",
        url: amadeusPath + "entertainment_ajax.php",
        data: {
            flag: "getEntertainmentCities",
            filter: false,
            country_id: country_id,
        },
        success: function (response) {
            var cities = JSON.parse(response)
            $.each(cities, function (index, value) {
                citiesArray +=
                   "<option " +
                   (value.id === city_id ? "selected" : "") +
                   ' value="' +
                   value.id +
                   '">' +
                   value.name +
                   "</option>"
            })

            $('#EntertainmentCityTitle').html(citiesArray)

        }
    })
}