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
                <h3 class="box-title m-b-0">لیست کاربران </h3>

                <div class="table-responsive">

                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>کد نمایندگی</th>
                            <th>
                                نام
                                <br>
                                ایمیل
                            </th>
                            <th>شهر نمایندگی</th>
                            <th>وضعیت تایید نمایندگی</th>

                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach $usersList.data as $item}
                            {assign var="agencyInfo" value=json_decode($item.agencyInfo,true)}
                            {$number = $number + 1}
                            <tr>
                                <td>{$number}</td>
                                <td>
                                    <span class="bg-primary p-3">{$item['id']}</span>
                                </td>
                                <td>
                                    {$item['name']} {$item['family']}
                                    <br>
                                    {$item['email']}
                                </td>
                                <td>
                                    {$agencyInfo.location.state.name} - {$agencyInfo.location.city.name}
                                </td>
                                <td>
                                    <a>

                                        <div style='float: right;' onclick="postageChangeUserType('{$item.id}'); return false;"

                                        >
                                            <input type="checkbox" class="js-switch" data-color="#99d683"
                                                   data-secondary-color="#f96262" data-size="small" {if $item.userType eq 'agency' } checked="checked" {/if} />
                                        </div>
                                    </a>
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
    function postageChangeUserType(id){
        $.ajax({
            type: 'POST',
            url: amadeusPath + 'postage_ajax.php',
            dataType: 'JSON',
            data: {
                flag: 'postageChangeUserType',
                user_id: id
            },
            success: function (response) {

                if (response.response.status == 'success') {
                    var displayIcon = 'success';
                } else{
                    var displayIcon = 'error';
                }

                $.toast({
                    heading: 'تغییر نوع کاربر',
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