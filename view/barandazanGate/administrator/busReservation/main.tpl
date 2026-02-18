{load_presentation_object filename="busPanel" assign="objResult"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="active">مدیریت بلیط رزرواسیون اتوبوس</li>
        
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <a class='btn btn-primary' href='list'>لیست اتوبوس ها</a>
                <a class='btn btn-primary' href='new'>ایجاد اتوبوس جدید</a>
                <a class='btn btn-primary' href='stations'>پایانه ها</a>
                <a class='btn btn-primary' href='companies'>شرکت های مسافربری اتوبوس</a>
            </div>

        </div>
    </div>

</div>
{*
{literal}
    <script>
        $(document).ready(function (){
          function formatData (data) {
            if (!data.id) { return data.text; }
            var $result= $(
              '<span><img src="/Ressources/Images/Locked.png"/> ' + data.text + '</span>'
            );
            return $result;
          };

          $(".select2-img").select2({
            templateResult: formatData,
            templateSelection: formatData

          });
        })
    </script>

{/literal}*}
