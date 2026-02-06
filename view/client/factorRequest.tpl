{load_presentation_object filename="requestReservation" assign="objRequestReservation"}
{$objRequestReservation->initialize($smarty.post.serviceName)}
{assign var="targetDetail" value=$objRequestReservation->create($smarty.post)}
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 Clr">
    <div class="main-bank-box">

        <div class="mbb-preload mbb-preload-icon">
            <img src="assets/images/pre-bank.png">
        </div>
        <h4 class="justify-content-center mbb-bank-title mbb-bank-title-green">
            <span>##Successpayment## </span>
        </h4>

        <div class="mbb-detail">
            <div class="message-box-car">
                {assign var="factorNumber" value="<code>`$targetDetail['factor_number']`</code>"}
                {functions::StrReplaceInXml(["@@factorNumber@@"=>$factorNumber,"@@service@@"=>$targetDetail['service_name']],"RequestSubmitedSuccessfully")}
            </div>
        </div>

    </div>
</div>
