<?php


function ResponseStatus($FinalResponse, $Methode, $requestNumber, $SuccessFul, $Message=null)
{

    $httpCode=SetResponseCode($FinalResponse);
    $ClientSuccessfulStatus=true;
    if(is_array($SuccessFul)){
        $ClientSuccessfulStatus=$SuccessFul['client'];
        $ProviderSuccessfulStatus=$SuccessFul['provider'];
    }else{
        $ProviderSuccessfulStatus=$SuccessFul;
    }

    $AdditionalResponseName='information';
    if($ProviderSuccessfulStatus && $ClientSuccessfulStatus){
        $ResultResponseName='data';
        if(isset($FinalResponse['response']['data'])){
            $ResultResponseIndex=$FinalResponse['response']['data'];
        }
    }else{
        $ResultResponseName='Error';
        $ResultResponseIndex=PossibleProviderMessagesResponse($FinalResponse['response']['data']);
        unset($ResultResponseIndex['HttpHeader']);
    }


    if(is_array($requestNumber)){
        $ReturnType=$requestNumber['return'];
        $requestNumber=$requestNumber['requestNumber'];
    }else{
        $ReturnType='Default';
    }

    if($ReturnType=='Default'){

        $FinalReturn=[
            'response'=>[
                'code'=>$Methode,
                'requestNumber'=>$requestNumber,
                'SuccessfulStatus'=>[
                    'client'=>$ClientSuccessfulStatus,
                    'provider'=>$ProviderSuccessfulStatus,
                    'HTTP'=>$httpCode,
                ],
                $AdditionalResponseName=>!empty($Message) ? $Message : '',
                $ResultResponseName=>!empty($ResultResponseIndex) ? $ResultResponseIndex : array(),
            ]
        ];
        if(!isset($Message['data'])){
            unset($FinalReturn['response'][$AdditionalResponseName]);
        }
        return $FinalReturn;
    }elseif($ReturnType=='DataOnly'){
        return $FinalResponse;
    }
}

function BusinessMethodCode($Method)
{
    switch($Method){
        case 'ProcessBus::busSearch':
            $MethodCode='1';
            break;
        //-------------- Safar 724 ---------------
        case 'Safar724::getAccessToken':
            $MethodCode='2-1';
            break;
        case 'Safar724::busSearch':
            $MethodCode='2-2';
            break;
        case 'Safar724::ReachAccessToken':
            $MethodCode='2-3';
            break;

        case 'Safar724::busDetail':
            $MethodCode='2-4';
            break;
        //-------------- Alterabo 724 ---------------
        case 'Alterabo::getAccessToken':
            $MethodCode='3-1';
            break;
        case 'Alterabo::busSearch':
            $MethodCode='3-2';
            break;

        default :
            if(!empty($Method)):
                $MethodCode=$Method;
            else:
                $MethodCode='0';
            endif;

    }
    return $MethodCode;
}

function ProviderStatus($SuccessFul, $Methode, $Data, $information=null)
{
    if($SuccessFul['client'] === false || $SuccessFul['provider']===false){
        $httpCode=500;
    }else{
        $httpCode=200;
    }
    $response = [
        'response'=>[
            'successfulStatus'=>$SuccessFul,
            'Methode'=>$Methode,
            'data'=>$Data,
            'information'=>$information
        ]
    ];
    $response['response']['successfulStatus']['HTTP']=$httpCode;
    return $response;
}

function SetResponseCode($CodeName, $reason=null)
{
    if(!is_numeric($CodeName)){

        if(is_array($CodeName['response']['data'])){
            $code='200';
        }else{
            $code=PossibleProviderMessagesResponse($CodeName['response']['data'])['HttpHeader'];
        }
    }else{
        $code=$CodeName;
    }

    $code=intval($code);

    if(!version_compare(phpversion(), '5.4', '>') || !is_null($reason)){
        header(trim("HTTP/1.0 $code $reason"));
    }else{
        http_response_code($code);
    }
    return $code;

}

function CheckJsonFormat($TargetJson)
{
    if(!empty($TargetJson) && !is_array($TargetJson)){
        if(is_object(json_decode($TargetJson))){
            return true;
        }
    }
    return false;
}

function PossibleProviderMessagesResponse($StatusName)
{
    switch($StatusName){
        case 'EntityIsNull':
        case 'ValidationFailed':
        case 'BadArgument':
            $errorMessage['HttpHeader']='400';
            $errorMessage['Persian']='داده های ورودی نامعتبر است.';
            $errorMessage['English']='The request data is invalid';
            break;
        case 'BadArgumentUserNamePassword':
            $errorMessage['HttpHeader']='400';
            $errorMessage['Persian']='نام کاربری یا رمز نامعتبر است.';
            $errorMessage['English']='Invalid username or password';
            break;
        case 'InvalidTicketStatus':
            $errorMessage['HttpHeader']='400';
            $errorMessage['Persian']='وضعیت بلیط برای این عملیات نامعتبر است';
            $errorMessage['English']='Ticket status is invalid for this operation';
            break;
        case 'BadRequestMethode':
            $errorMessage['HttpHeader']='400';
            $errorMessage['Persian']='ورودی های نامعتبر هدر';
            $errorMessage['English']='Response only from post methode and content-type:json';
            break;
        case 'RepetitiveRequest':
            $errorMessage['HttpHeader']='400';
            $errorMessage['Persian']='درخواست تکراری';
            $errorMessage['English']='this is repetitive request.';
            break;
        case 'InvalidAuth':
            $errorMessage['HttpHeader']='401';
            $errorMessage['Persian']='نام کاربری یا رمز عبور شما اشتباه است';
            $errorMessage['English']='Invalid username or password';
            break;
        case 'NotFound':
            $errorMessage['HttpHeader']='404';
            $errorMessage['Persian']='آدرس وارد شده نامعتبر است';
            $errorMessage['English']='Url is invalid';
            break;
        case 'InvalidRoute':
            $errorMessage['HttpHeader']='400';
            $errorMessage['Persian']='روت های خود را وارد کنید';
            $errorMessage['English']=" 'route' missing ";
            break;
            case 'InvalidOriginRoute':
            $errorMessage['HttpHeader']='400';
            $errorMessage['Persian']='روت مبدا خود را وارد کنید';
            $errorMessage['English']=" 'destinationCity' missing ";
            break;
            case 'InvalidDestinationRoute':
            $errorMessage['HttpHeader']='400';
            $errorMessage['Persian']='روت مقصد خود را وارد کنید';
            $errorMessage['English']=" 'destinationCity' missing ";
            break;
            case 'InvalidDate':
            $errorMessage['HttpHeader']='400';
            $errorMessage['Persian']='تاریخ را وارد کنید';
            $errorMessage['English']=" 'date' missing ";
            break;
        case 'InvalidSource':
            $errorMessage['HttpHeader']='400';
            $errorMessage['Persian']='منبع ورودی یافت نشد';
            $errorMessage['English']='The Source Code Wasnt Found';
            break;
        case 'SourceReaderError':
            $errorMessage['HttpHeader']='400';
            $errorMessage['Persian']='مشکلی در خواندن منابع یافت شد.';
            $errorMessage['English']='Source Read Is Under Problem Please Contact Us';
            break;
        case 'ExpiredRequestNumber':
            $errorMessage['HttpHeader']='400';
            $errorMessage['Persian']='این شماره درخواست قبلا استفاده شده است';
            $errorMessage['English']='Request number expired , You need a new one';
            break;
            case 'NeedRequestNumber':
            $errorMessage['HttpHeader']='400';
            $errorMessage['Persian']='شماره درخواست مورد نیاز است';
            $errorMessage['English']=" 'requestNumber' missing  ";
            break;

            case 'NeedBusCode':
            $errorMessage['HttpHeader']='400';
            $errorMessage['Persian']='کد اتوبوس مورد نیاز است';
            $errorMessage['English']=" 'busCode' missing  ";
            break;
            case 'NeedSourceCode':
            $errorMessage['HttpHeader']='400';
            $errorMessage['Persian']='کد منبع مورد نیاز است';
            $errorMessage['English']=" 'sourceCode' missing  ";
            break;
        case 'OutOfCredit':
            $errorMessage['HttpHeader']='400';
            $errorMessage['Persian']='همکار گرامی، اعتبار شما به پایان رسیده است';
            $errorMessage['English']='Need to charge your account';
            break;
        case 'ErrorOnCredit':
            $errorMessage['HttpHeader']='400';
            $errorMessage['Persian']='همکار گرامی، در کسر اعتبرا شما مشکلی به وجود آمده است ، لطفا با پشتیبانی تماس بگیرید';
            $errorMessage['English']='Error on Credit. Contact us please';
            break;
        case 'InvalidDepartureDate':
            $errorMessage['HttpHeader']='400';
            $errorMessage['Persian']='تاریخ عزیمت باید برابر یا بیشتر از امروز باشد';
            $errorMessage['English']='Departure date must be equal or greater than today';
            break;
        case 'NoResult':
            $errorMessage['HttpHeader']='400';
            $errorMessage['Persian']='خطایی غیر منتظره در دیتا';
            $errorMessage['English']='We received error or exception from Data';
            break;
        case 'NoAccess':
            $errorMessage['HttpHeader']='403';
            $errorMessage['Persian']='امکان دسترسی به وب سرویس فراهم نمی باشد.';
            $errorMessage['English']='No Access';
            break;
        case 'NoAccessWebservice':
            $errorMessage['HttpHeader']='403';
            $errorMessage['Persian']='اجازه دسترسی به وب سرویس برای شما امکان پذیر نیست. لطفا با پشتیبانی تماس بگیرید.';
            $errorMessage['English']='No Access';
            break;
        case 'InvalidAuthentication':
            $errorMessage['HttpHeader']='401';
            $errorMessage['Persian']='مشکل احراز هویت لطفا کد درخواست خود را تازه سازی کنید';
            $errorMessage['English']='Authentication Problem , Rebuild Your Request Number';
            break;

        case 'UnspecifiedError':
            $errorMessage['HttpHeader']='400';
            $errorMessage['Persian']='اتصال به نقطه اتصال سرویس انجام نشد از در	ستی کد مطمئن شوید';
            $errorMessage['English']='Fail Connect To End Point';
            break;
        case 'SeatNotAvailable':
            $errorMessage['HttpHeader']='400';
            $errorMessage['Persian']='صندلی درخواستی در دسترس نیست';
            $errorMessage['English']='Requested Seat Isnt Availabale';
            break;
        case 'RefundRequestIsRejected':
            $errorMessage['HttpHeader']='400';
            $errorMessage['Persian']='شرکت اصلی درخواست بازپرداخت را رد کرد. احتمالاً بلیط چاپ شده است';
            $errorMessage['English']='The underlying company rejected the refund request. Possibly the ticket was printed.';
            break;
        case 'RefundDateExpired':
            $errorMessage['HttpHeader']='400';
            $errorMessage['Persian']='تاریخ بازپرداخت منقضی شده است بلیط از طریق سیستم دیگر قابل استرداد نیست';
            $errorMessage['English']='Refund date expired. The ticket is no longer refundable through the system.';
            break;
        case 'SeatUnavailable':
            $errorMessage['HttpHeader']='400';
            $errorMessage['Persian']='';
            $errorMessage['English']='Selected seat is unavailable.';
            break;
        case 'InvalidBankAccountNumber':
            $errorMessage['HttpHeader']='400';
            //Bank account is not registered or invalid.
            $errorMessage['Persian']='خطایی از طرف ارائه دهنده دریافت کردیم. لطفا با پشتیبانی تماس بگیرید.';
            $errorMessage['English']='We received an error from the provider. Please contact support.';
            break;
        case 'InvalidBusServiceStatus':
            $errorMessage['HttpHeader']='400';
            $errorMessage['Persian']='وضعیت خدمات برای این عملیات نامعتبر است';
            $errorMessage['English']='Service status is invalid for this operation';
            break;
        case 'InsufficientCredit':
            $errorMessage['HttpHeader']='400';
            //Credit amount is not sufficient for this payment.
            $errorMessage['Persian']='خطایی از طرف ارائه دهنده دریافت کردیم. لطفا با پشتیبانی تماس بگیرید.';
            $errorMessage['English']='We received an error from the provider. Please contact support.';
            break;
        case 'InvalidDiscount':
            $errorMessage['HttpHeader']='400';
            $errorMessage['Persian']='تخفیف درخواستی برای این سرویس کاربردی نیست.';
            $errorMessage['English']='Requested discount is not applicable for this service.';
            break;
        case 'TicketWasRefunded':
            $errorMessage['HttpHeader']='400';
            $errorMessage['Persian']='بلیط درخواستی قبلاً بازپرداخت شده است';
            $errorMessage['English']='The requested ticket was already refunded.';
            break;
        case 'BookRequestIsRejected':
            $errorMessage['HttpHeader']='400';
            $errorMessage['Persian']='شرکت زیرمجموعه درخواست رزرو صندلی (های) درخواستی را رد کرد.';
            $errorMessage['English']='The underlying company rejected the booking request for the requested seat(s).';
            break;
        case 'InvalidPaymentMethod':
            $errorMessage['HttpHeader']='400';
            $errorMessage['Persian']='';
            $errorMessage['English']='Requested payment method is not applicable for this service.';
            break;
        case 'InvalidTraceNumber':
            $errorMessage['HttpHeader']='400';
            $errorMessage['Persian']='روش پرداخت درخواستی برای این سرویس کاربردی ندارد.';
            $errorMessage['English']='Provided trace number is duplicate or exceeds the maximum length';
            break;
        default:
            $errorMessage['HttpHeader']='400';
            $errorMessage['Persian']='خطایی غیر منتظره از طرف ارائه دهنده دریافت کردیم';
            $errorMessage['English']='We received error or exception from provider side';
            break;

    }
    return $errorMessage;
}

function responseSuccessfulCheck($Result)
{
    $ClientSuccessfulStatus=$Result['client'];
    $ProviderSuccessfulStatus=$Result['provider'];
    if($ProviderSuccessfulStatus && $ClientSuccessfulStatus){
        return true;
    }
    return false;
}
