$(document).ready(function() {
    $("#add").click(function() {
        var fieldWrapper = addInput();
        $("#insert_row").append(fieldWrapper);
    });

});

function addInput() {

    var inputs = `
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" name="origin[]" value="" class="form-control origin" placeholder="مبدا را وارد نمایید">
            </div>
             <div class="col-md-4">
                <input type="text" name="destination[]" value="" class="form-control destination" placeholder="مقصد را وارد نمایید">
            </div> 
             <div class="col-md-4">
                <a  href="#" type="button"  value="حذف" class=" fcbtn btn btn-outline btn-danger" onclick="removeRow(this)">حذف <i class="fa fa-trash-o"></i> </a>
            </div>
        </div>
    `;
    return $(inputs);
}


function removeRow(obj) {
    $(obj).parent().parent().remove();
}

function sendDataRoutSpecial() {
    let origin = $('.origin');
    let destination = $('.destination');

    if (origin.length > 0 && destination.length > 0) {
        $.ajax({
            type: 'POST',
            url: amadeusPath + 'ajax',
            data : $("#rout_special").serialize(),
            success: function (response) {
                $.toast({
                    heading: 'تعیین کمیسیون مشتریان در وایت لیبل ',
                    text: response.message,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });

                setTimeout(function () {

                    location.href = "listClientCommission&id=" + client_id_parent
                }, 1000);

            },
            error: function (error) {
                $.toast({
                    heading: 'تعیین کمیسیون مشتریان در وایت لیبل ',
                    text: error.responseJSON.message,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            }
        });

    } else {
        $.toast({
            heading: 'افزودن مسیر جدید',
            text: 'حداقل یک مسیر باید انتخاب شود',
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'error',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
        });
    }
}


function originCity(obj) {
    var Code = $(obj).val();
    $('#LoaderForeignDep').show();
    if (Code.length >= 3) {
        $(".SelectDeparture").show();
        $.post(amadeusPath + 'user_ajax.php',
            {
                Code: Code,
                Type: 'origin',
                flag: 'liveSearchDestination'
            },
            function (response) {
                setTimeout(function () {
                    $(".SelectDeparture").hide();
                    $('#LoaderForeignDep').hide();
                    if (response != "") {
                        $('#ListAirPort').html(response);
                    } else {
                        $('#ListAirPort').html('<li>' + useXmltag("NothingFound") + '</li>');
                    }
                    $('#ListAirPort').show();

                }, 10);
            });
    } else {
        $('#ListAirPort').html('<li>' + useXmltag("EnterThreeLetters") + '</li>');
        $('#ListAirPort').show();
    }

}

