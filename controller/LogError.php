<?php

/**
 * Class LogError
 * @property LogError $LogError
 */
class LogError extends clientAuth
{

    public $listBank;
    public $info;
    public $ClientId;

    /**
     * if form was send  "get data-> upload logo -> insert DB"
     */
    public function __construct(){
        parent::__construct();

    }

    public function InfoShow($id = NULL){

        $client_id = !empty($id) ? $id : CLIENT_ID;

        $admin = Load::controller('admin');

        $sql = " SELECT * FROM log_flight_tb WHERE message <> '' AND clientId <> '' ORDER BY creation_date_int DESC ";
        $res = $admin->ConectDbClient($sql, $client_id, "SelectAll", "", "", "");

        foreach ($res as $key => $row) {
            $sql = "SELECT origin_city,desti_city,flight_type,flight_number  FROM book_local_tb WHERE request_number='{$row['request_number']}'";
            $ticket = $admin->ConectDbClient($sql, $client_id, "Select", "", "", "");
            $res[$key]['OriginFind'] = $ticket['origin_city'];
            $res[$key]['DestinationFind'] = $ticket['desti_city'];
            $res[$key]['FlightType'] = $ticket['flight_type'];
            $res[$key]['FlightNumber'] = $ticket['flight_number'];
        }

        return $res;
    }

    public function ListLogErrorAdmin()
    {

        $ModelBase = Load::library('ModelBase');

        $sql = " SELECT * FROM clients_tb";
        $res = $ModelBase->select($sql);


        $admin = Load::controller('admin');


        $Time = time() - (7 * 24 * 60 * 60);
        $NowTime = time();

        foreach ($res as $each) {

            if ($each['id'] > '1') {

                $sql = " SELECT * FROM log_flight_tb  WHERE message <> '' AND clientId <> '' AND  creation_date_int > {$Time} AND creation_date_int < {$NowTime} ORDER BY creation_date_int DESC ";
                $clientError = $admin->ConectDbClient($sql, $each['id'], "SelectAll", "", "", "");
            }

            foreach ($clientError as $key => $error) {
                $ShowClientError[] = $error;
            }
        }


        $Error = array();
        foreach ($ShowClientError as $key => $row) {

            $Error['creation_date_int'][$key] = $row['creation_date_int'];

        }

        array_multisort($Error['creation_date_int'], SORT_DESC, $ShowClientError);

        foreach ($ShowClientError as $key => $req) {
            $sql = "SELECT origin_city,desti_city,flight_type,flight_number,client_id FROM report_tb WHERE request_number='{$req['request_number']}'";
            $ticket = $ModelBase->load($sql);
            $ShowClientError[$key]['AgencyName'] = functions::ClientName($ticket['client_id']);
            $ShowClientError[$key]['OriginFind'] = $ticket['origin_city'];
            $ShowClientError[$key]['DestinationFind'] = $ticket['desti_city'];
            $ShowClientError[$key]['FlightType'] = $ticket['flight_type'];
            $ShowClientError[$key]['FlightNumber'] = $ticket['flight_number'];
        }
//        echo '<pre>' . print_r($ShowClinetError, true) . '</pre>';


        return $ShowClientError;
    }


    public function ErrorShow($message)
    {

        switch ($message) {
            case "UsernameOrPasswordIsEmpty":
                return "وارد کردن نام کاربري و رمز عبور الزامي مي باشد";
                break;
            case "FlightIsInvalid":
                return "پروازي با اين اطلاعات وجود ندارد";
                break;
            case "AirlineCodeNotValid":
                return "کد ايرلاين نامعتبر است";
                break;
            case "AdultCountIsInvalid":
                return "تعداد مسافران به درستي وارد نشده است در صورت تکرار اين خطا با پشتيبان تماس بگيريد";
                break;
            case "UsernameNotExist":
                return "نام کاربري مورد نظر موجود نمي باشد";
                break;
            case "PasswordIsWrong":
                return "نام کاربري و يا رمز عبور اشتباه است";
                break;
            case "UserNotApproved":
                return "نام کاربري مورد نظر تاييد شده نيست";
                break;
            case "UserNotActive":
                return "نام کاربري مورد نظر فعال نمي باشد ";
                break;
            case "UserNotAnyRole":
                return "نام کاربري مورد نظر دسترسي لازم را ندارد";
                break;
            case "UserNotRole":
                return "نام کاربري مورد نظر دسترسي لازم را ندارد";
                break;
            case "FlightNotExist":
                return "متاسفانه پرواز مورد نظر موجود نمي باشد و يا ظرفيت آن به اتمام رسيده پرواز ديگري را خريد نماييد";
                break;
            case "FlightNotReservable":
                return "امکان رزرو در حال حاضر وجود ندارد. هم اکنون مي توانيد براي خريد بليط ديگري اقدام نماييد";
                break;
            case "LowCapacity":
                echo "در این لحظه ظرفیت نرخ مورد نظر شما بیشتر از ظرفیت موجود است،لطفا از نرخ های دیگر خریداری نمائید";
                break;
            case "SessionIDTerminated":
                return "درخواست شما منقضي شده است لطفا از ابتدا تلاش کنيد";
                break;
            case "LowCredit":
                return "خطاي غيرمنتظره رخ داده است";
                break;
            case "UserPassWrong":
                return "خطا در نام کاربری یا رمز عبور";
                break;
            case "ProviderDown":
                return "موقتا ارتباط با مرکز رزرواسيون ارائه دهنده بليط قطع ميباشد.دقايقي ديگر تلاش کنيد.";
                break;
            case "ProviderTimeOut":
                return "متاسفانه ارتباط با مرکز مقدور نميباشد لطفا دقايقي ديگر اقدام به خريد نماييد";
                break;
            case "NoReservable":
                return "پرواز مورد نظر قابليت رزرو ندارد";
                break;
            case "Error":
                return "خطاي رخ داده است در صورت تکرار اين خطا لطفا با پشتيباني تماس حاصل فرماييد";
                break;
            case "UnSuccessful":
                return "خطاي سيستمي رخ داده است در صورت تکرار اين خطا لطفا با پشتيباني تماس حاصل فرماييد";
                break;
            case "FlightIsNotInTheList":
                return "پرواز مورد نظر موجود نمي باشد";
                break;
            case "InvalidManufacturer":
                return "سازنده نرم افزار امکان رزرو اين پرواز را ندارد";
                break;
            case "NewRequestError":
                return "خطاي در ثبت اطلاعات درخواست شما رخ داده است، لطفا دوباره تلاش کنيد و  در صورت تکرار با پشتيبان تماس بگيريد";
                break;
            case "ErrorInEditRequest":
                return "خطاي در ويرايش اطلاعات درخواست شما رخ داده است، لطفا دوباره تلاش کنيد و  در صورت تکرار با پشتيبان تماس بگيريد";
                break;
            case "FlightIsFull":
                echo "در این لحظه ظرفیت نرخ مورد نظر شما به اتمام رسیده است،لطفا از نرخ های دیگر خریداری نمائید";
                break;
            case "HttpError":
                return "اختلال در شبکه - لطفا دقايقي ديگر تلاش نماييد و يا با پشتيبان سايت تماس بگيريد";
                break;
            case "NoCapacity":
                return "ظرفيت پرواز تکميل شده است , لطفا پرواز ديگري را خريد کنيد";
                break;
            case "AccessDenied":
                return "شما دسترسي لازم به اين بخش را نداريد";
                break;
            case "DuplicatePassengerName":
                return "نام مسافر در پرواز تکراري ست و مسافري با همين مشخصات در اين پرواز وجود دارد";
                break;
            case "PersianFirstNameAndLastNameIsRequired":
                return "مشخصات فارسي بايد وارد شود";
                break;
            case "PersianFirstNameOrLastNameIsNonPersian":
                return "در بخش مشخصات فارسي اطلاعات را بايد فارسي وارد نماييد";
                break;
            case "EnglishFirstNameOrLastNameIsNonEnglish":
                return "در بخش مشخصات انگليسي اطلاعات را بايد انگليسي وارد نماييد";
                break;
            case "EnglishFirstNameAndLastNameIsRequired":
                return "مشخصات انگليسي بايد وارد شود";
                break;
            case "DateOfBirthIsRequired":
                return "تاريخ تولد بايد وارد شود";
                break;
            case "DateOfBirthIsInvalid":
                return "تاريخ تولد به درستي وارد نشده";
                break;
            case "ChildAgeIsBiggerThan12":
                return "مسافر کودک نبايد بيشتر از 12 سال داشته باشد";
                break;
            case "InfantAgeIsBiggerThan2":
                return "مسافر نوزاد نبايد بيشتر از 2 سال داشته باشد";
                break;
            case "NationalCodeIsRequired":
                return "کد ملي را وارد نماييد";
                break;
            case "PassportNumberIsRequired":
                return "شماره پاسپورت را وارد نماييد";
                break;
            case "PassportExpiryDateIsInvalid":
                return "تاريخ پاسپورت معتبر نيست";
                break;
            case "InvalidPassportNumber":
                return "شماره گذرنامه معتبر نمي باشد";
                break;
            case "InvalidPassportExpiryDate":
                return "تاريخ گذرنامه صحيح وارد نشده";
                break;
            case "InvalidNationalCode":
                return "کد ملي معتبر نيست";
                break;
            case "NameHasSpace":
                return "نام و نام خانوادگي خود را بدون فاصله وارد نماييد";
                break;
            case "NameIsInvalid":
                return "نام وارد شده صحيح نمي باشد";
                break;
            case "InvalidDateOfBirth":
                return "تاريخ تولد معتبر نيست";
                break;
            case "InvalidMobileNumber":
                return "شماره همراه وارد شده صحيح نمي باشد";
                break;
            case "InvalidEmail":
                return "آدرس ايميل وارد شده صحيح نمي باشد";
                break;
            case "InvalidPassengerName":
                return "فرمت وارد شده نام خانوادگي معتبر نمي باشد";
                break;
            case "AutenticateError":
                return "خطا احراز هويت لطفا با پشتيباني تماس بگيريد";
                break;
            case "TryLater":
                return "خطايي رخ داده لطفا مراحل رزرو را از ابتدا انجام دهيد";
                break;
            case "PIDBusy":
                return "پید مشغول است";
                break;
            case "PIDStoped":
                return "شبکه شلوغ بوده لطفا دقايقي صبر کرده و دوباره دکمه رزرو را بزنيد و در صورت تکرار با پشتيبان تماس بگيريد";
                break;
            case "ServerError":
                return "خطايي رخ داده لطفا مراحل رزرو را از ابتدا انجام دهيد و در صورت تکرار با پشتيبان تماس بگيريد";
                break;
            case "PriceChanged":
                return "بليط مورد نظر از سوي ايرلاين تغيير نرخ پيدا کرده.لطفا براي دريافت آخرين نرخ مجددا مراحل رزرو را از ابتدا انجام دهيد";
                break;
            case "UnableIssueTicket":
                return "امکان صدور بليط درخواستي در حال حاضر وجود ندارد. هم اکنون مي توانيد براي خريد بليط ديگري اقدام نماييد";
                break;
            case "RequestNumberIsEmpty":
                return "ارسال شماره درخواست الزامي مي باشد";
                break;
            case "RequestNotFind":
                return "شماره درخواست مورد نظر يافت نشد";
                break;
            case "UsernameIsEmpty":
                return "نام کاربري يافت نشد";
                break;
            case "RequestNumberTerminated":
                return "درخواست شما منقضي شده است لطفا دوباره تلاش کنيد";
                break;
            case "LowBalance":
                return "دسترسی منبع محدود شده است";
                break;
            case "TimeExpired":
                return "زمان رزرو شما منقضي شده است لطفا مراحل رزرو را از ابتدا انجام دهيد";
                break;
            case "UpdateBalanceFailed":
                return "مشکل در بروزرساني اطلاعات حساب کاربري، مراحل رزرو را از ابتدا انجام دهيد و يا به پشتيباني اطلاع دهيد";
                break;
            case "FlightIDEmpty":
                return "کد پرواز نمي تواند خالي باشد";
                break;
            case "RequestNotFound":
                return "شماره پرواز نا مشخص است";
                break;
            case "Passport ID Is Incorrect":
                return "شماره پاسپورت صحیح نمی باشد";
                break;
            case "Credit  problem  ticket price":
                return "اعتبار پید شما در منبع کافی نمی باشد";
                break;
            case "Fligt capacity error (210)":
                return "در این لحظه ظرفیت نرخ مورد نظر شما بیشتر از ظرفیت موجود است،لطفا از نرخ های دیگر خریداری نمائید";
                break;
            case "Fligt capacity error (163)":
                return "در این لحظه ظرفیت نرخ مورد نظر شما بیشتر از ظرفیت موجود است،لطفا از نرخ های دیگر خریداری نمائید";
                break;
            case "Repetitive Passenger In This Flight ":
                return "نام مسافر در پرواز تکراري ست و مسافري با همين مشخصات در اين پرواز وجود دارد";
                break;
            case "Passport ID Is Incorrect":
                return "شماره پاسپورت صحیح نمی باشد";
                break;
            case "TimeExpired":
                return "زمان رزرو شما منقضی شده است لطفا مراحل رزرو را از ابتدا انجام دهید";
                break;
            case "Repetitive Passenger In This Flight ":
                return "نام مسافر در پرواز تکراری ست و مسافری با همین مشخصات در این پرواز وجود دارد";
                break;
            case '10122':
                return 'تاریخ ارسالی نامعتیر است';
                break;
            case '10131':
                return 'درخواست ارسالی نا معتیر است';
                break;
            case '10201':
                return 'خطای سیستمی با پشتیبان خود تماس بگیرید';
                break;
            case '-203':
                return 'تاریخ نا معتبر است';
                break;
            case '-2':
                return 'خطا در ارسال درخواست';
                break;
            case '-202':
                return 'مبدا یا مقصد نا معتبر است';
                break;
            case '10150':
                return 'تاریخ تولد نا معتبر است';
                break;
            case '1':
                return 'قیمت بلیط توسط ایرلاین تغییر کرده است';
                break;
            case '10207':
                return 'بلیط مورد نظر امکان رزور ندارد،مجددا سعی کنید و در صورت تکرار با پشتیبان خود تماس بگیرید';
                break;
            case '10202':
                return 'ظرفیت پرواز مورد نظر پر شده،یا پرواز مورد نظر موجود نمی باشد';
                break;
            case '10142':
                return 'رزرو تایید نشده با پشتیبان تماس بگیرید';
                break;
            case '10226':
                return 'ساعت و یا تاریخ پروازی که انتخاب کرده اید تغییر کرده است';
                break;
            case '10167':
                return 'اطلاعات مسافران شما ،قبلا در پرواز ثبت شده و تکراری می باشد ';
                break;
            case '10216':
                return 'ظرفیت پرواز پر شده است';
                break;
            case '10151':
                return 'تاریخ تولد یا نوع مسافر اشتباه میباشد	';
                break;
            case '10152':
                return 'نام  یا نام خانوادگی مسافر اشتباه است 	';
                break;
            case '10155':
                return 'کد ملی مسافر اشتباه است';
                break;
            case '10170':
                return 'شماره پاسپورت مسافر اشتباه است';
                break;
            case '10107':
                return 'ایمیل وارد شده معتبر نیست';
                break;
            case '-3':
                return 'خطا در ارسال درخواست،لطفا مجددا اقدام نمائید و در صورت تکرار با پشتیبان خود تماس بگیرید';
                break;
            case '10171':
                return 'تاریخ انقضای پاسپورت اشتباه است';
                break;
            case '-305':
                return 'پرواز یافت نشد لطفا مجددا اقدام نمائید و در صورت تکرار با پشتیبان خود تماس حاصل نمائید';
                break;
            case '-402':
                return 'اطلاعات وارد شده معتبر نمی باشد';
                break;
            case '-403':
                return 'ایمیل وارد شده معتبر نمی باشد';
                break;
            case '-404':
                return 'شماره همراه وارد شده معتبر نمی باشد';
                break;
            case '-405':
                return 'تعداد مسافرین معتبر نمی باشد';
                break;
            case '-408':
                return 'درخواست شما منقضی شده است ،لطفا مجددا اقدام نمائید';
                break;
            case '-409':
                return 'تاریخ پرواز مورد نظر تغییر کرده است';
                break;
            case '-410':
                return 'زمان پرواز مورد نظر تغییر کرده است';
                break;
            case '-411':
                return 'کد امنیتی وارد شده اشتباه است';
                break;
            case '-412':
                return ' نوع مسافر فقط باید(بزرگسال،کودک،نوزاد) باشد';
                break;
            case '-413':
                return ' نوع مسافر فقط باید(بزرگسال،کودک،نوزاد) باشد';
                break;
            case '-414':
                return 'نام یا نام خانوادگی لاتین معتبر نمی باشد';
                break;
            case '-415':
                return 'نام یا نام خانوادگی فارسی معتبر نمی باشد';
                break;
            case '-416':
                return 'جنسیت مسافر معتبر نمی باشد';
                break;
            case '-417':
                return 'کد ملی مسافر معتبر نمی باشد';
                break;
            case '-418':
                return 'کد ملی معتبر نمی باشد';
                break;
            case '-419':
                return 'ملیت مسافر معتبر نیست';
                break;
            case '-420':
                return 'تاریخ اعتبار پاسپورت مسافر معتبر نیست';
                break;
            case '-421':
                return 'تاریخ تولد مسافر بزرگسال معتبر نیست';
                break;
            case '-422':
                return 'تاریخ تولد مسافر کودک معتبر نیست';
                break;
            case '-423':
                return 'تاریخ تولد مسافر نوزاد معتبر نیست';
                break;
            case '-424':
                return 'تاریخ تولد مسافر  معتبر نیست';
                break;
            case '-430':
                return 'قیمت ایرلاین تغییر کرده است';
                break;
            case '-458':
                return 'کد امنیتی وارد شده اشتباه است';
                break;
            case '-777':
                return 'قیمت پرواز مورد نظر تغییر کرده است';
                break;
            case '10225':
                return 'اعتبار کافی نیست';
                break;
            case '10253':
                return 'منبع نا مشخص';
                break;
            case '10157':
                return 'ایمیل وارد شده اشتباه است';
                break;
            case '10168':
                return 'شماره ملی یا شماره پاسپورت مسافر قبلا ثبت شده است';
                break;
            case '10000777':
                return 'کمبود اعتبار پید';
                break;
            case '909090':
                return 'قیمت پرواز مورد نظر تغییر کرده است';
                break;
            case 'ERROR111':
                return 'در حال حاضر پرواز مورد نظر شما،برای رزرو با مشکل مواجه شده است،لطفا مجددا اقدام نمائید و در صورت تکرار با پشتیبان خود تماس حاصل نمائید';
                break;
            case '-506':
                return 'خرید نا موفق است';
                break;
            case '10175':
                return 'کد ملی معتیر نمی باشد';
                break;
            default:
                return " خطاي غيرمنتظره رخ داده است لطفا با پشتيباني تماس حاصل فرماييد";
                break;
        }
    }


    //region getErrorMessage
    /**
     * @param $request_number
     * @return mixed
     */
    public function getErrorMessage($request_number){
        return $this->getModel('logFlightModel')->get()->where('request_number',$request_number)->where('message','','<>')->find();
    }
    //endregion

    public function getErrorMessageOfAdmin($request_number,$client_id){

        $sql= "SELECT * FROM log_flight_tb WHERE request_number='{$request_number}' AND message !=''" ;
        $data_error = $this->getController('admin')->ConectDbClient( $sql, $client_id, "Select", "", "", "" );

        $data_error['text_message'] = $this->ErrorShow($data_error['messageCode']).'---'.$data_error['message'] ;

        return $data_error ;

    }

}

?>
