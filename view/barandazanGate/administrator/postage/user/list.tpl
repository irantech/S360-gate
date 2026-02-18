{load_presentation_object filename="postage" assign="ObjPostage"}
{assign var="usersList" value=$ObjPostage->usersList()}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>

            </ol>
        </div>
    </div>



    {if $smarty.const.TYPE_ADMIN eq '1'}

    {/if}

    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">لیست درخواست ها </h3>

                <div class="table-responsive">

                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>کد درخواست</th>

                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach $usersList.data as $item}
                            {$number = $number + 1}
                            <tr>
                                <td>{$number}</td>
                                <td>
                                    <span class="bg-primary p-3">{$item['name']}</span>
                                </td>

                            </tr>
                        {/foreach}
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>





</div>

<div class="i-section">
    <div class="i-info">
        <span> ویدیو آموزشی بخش ترتیب نمایش هتل ها   </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/377/---.html" target="_blank" class="i-btn"></a>

</div>

<script>
    function postageAccessResponse(id){
        $.ajax({
            type: 'POST',
            url: amadeusPath + 'postage_ajax.php',
            dataType: 'JSON',
            data: {
                flag: 'changeAccessResponse',
                shipment_id: id
            },
            success: function (response) {

                if (response.response.status == 'success') {
                    var displayIcon = 'success';
                } else{
                    var displayIcon = 'error';
                }

                $.toast({
                    heading: 'وضعیت ویزا',
                    text: response.response.title,
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
</script>
<script type="text/javascript" src="assets/JsFiles/reservationHotel.js"></script>
<script type="text/javascript" src="assets/JsFiles/reservationBasicInformation.js"></script>