<?php

class credit_detail_tb extends Model {
    protected $table = 'credit_detail_tb';
    protected $pk = 'id';

    function getAll($agencyID) {
        $result = parent::select("
        SELECT 
            t.*,
            CASE 
                WHEN t.type = 'increase' THEN t.credit 
                ELSE -t.credit 
            END AS amount,
            SUM(
                CASE 
                    WHEN t.type = 'increase' THEN t.credit 
                    ELSE -t.credit 
                END
            ) OVER (ORDER BY t.register_date, t.id) AS balance_after
        FROM {$this->table} t
        WHERE 
            t.fk_agency_id = '$agencyID'
            AND (t.PaymentStatus = 'success' OR t.PaymentStatus IS NULL)
        ORDER BY t.{$this->pk} DESC
    ");

        return $result;
    }




	function getAllCharge($agencyID) {
		$result = parent::select("SELECT * FROM {$this->table} WHERE  fk_agency_id='$agencyID' AND type='increase' AND (PaymentStatus='success' OR PaymentStatus IS NULL) ORDER BY {$this->pk} DESC");

		return $result;
	}

	function getAll_credit_desc($id) {

		$Sql = "SELECT sum(credit) AS desc_credit FROM {$this->table} WHERE fk_agency_id='$id'  AND type='decrease' AND (PaymentStatus='success' OR PaymentStatus IS NULL)  ORDER BY {$this->pk} ASC";
		$result = parent::load($Sql);

		return $result;
	}

	function getAll_credit_asc($id) {
		$result = parent::load("SELECT sum(credit) AS asc_credit FROM {$this->table} WHERE fk_agency_id='$id'  AND type='increase' AND (PaymentStatus='success' OR PaymentStatus IS NULL)  ORDER BY {$this->pk} ASC");

		return $result;
	}

	function get($id) {
		$result = parent::load("SELECT * FROM {$this->table} WHERE id='$id' ");

		return $result;
	}

	function getCreditIncrease($agencyId, $factorNumber, $type) {
		$result = parent::load("SELECT * FROM {$this->table} WHERE requestNumber='{$factorNumber}' AND type='{$type}' AND fk_agency_id='{$agencyId}'  AND (PaymentStatus='success' OR PaymentStatus IS NULL)");

		return $result;
	}

	function credit_detail_insert($data = array()) {

		$detail['fk_agency_id'] = $data['fk_agency_id'];
		$detail['credit'] = $data['credit'];
		$detail['type'] = $data['type'];
		$detail['credit_date'] = $data['credit_date'];
		$detail['reason'] = $data['reason'];
		$detail['member_id'] = $data['member_id'];
		$detail['requestNumber'] = $data['requestNumber'];
		$detail['comment'] = $data['comment'];
		$detail['currency_code'] = $data['currency_code'];
		$detail['currency_equivalent'] = $data['currency_equivalent'];
		$detail['factorNumber'] =isset( $data['factorNumber']) ?  $data['factorNumber'] : '';
		$detail['creation_date_int'] = time();
		$detail['PaymentStatus'] = 'success';

		return parent::insertLocal($detail);
	}

	function getByRequestNumber($requestNumber) {
		$result = parent::load("SELECT * FROM {$this->table} WHERE requestNumber='$requestNumber' ");

		if (!empty($result)) {
			return $result;
		} else {
			return '0';
		}
	}

	function decrease($userAgencyId, $amount, $InfoBook = array(), $Type = null) {
        /** @var agencyModel $agency_model */
        $agency_model = Load::getModel('agencyModel');
	    $info_agency =  $agency_model->get()->where('id',$userAgencyId)->find();
		$detail['fk_agency_id'] = $userAgencyId;
		$detail['currency_code'] = $InfoBook['currency_code'];
		$detail['currency_equivalent'] = $InfoBook['currency_equivalent'];
		$detail['credit'] = $amount;
		$detail['type'] = "decrease";
		$detail['PaymentStatus'] = "success";
		$detail['credit_date'] = dateTimeSetting::jdate("Y-m-d", time());
		$detail['reason'] = 'buy';
		$detail['creation_date_int'] = time();
		if ($Type == 'ReservationTicket') {

			$detail['member_id'] = $InfoBook['member_id'];
			$detail['requestNumber'] = $InfoBook['factor_number'];
			$comment = ' خرید بلیط ' . $InfoBook['typeReservation'] . ' رزرواسیون ' . $InfoBook['multiWay'] . " به صورت کسر از اعتبار به شماره فاکتور " . " " . $InfoBook['factor_number'];
			$detail['comment'] = $comment;

		} elseif ($Type == 'Hotel') {

			$detail['member_id'] = $InfoBook['member_id'];
			$detail['requestNumber'] = $InfoBook['factor_number'];
			if ($InfoBook['type_application'] == 'api') {
				$detail['comment'] = " رزرو هتل اشتراکی داخلی به صورت کسر از اعتبار به شماره فاکتور " . $InfoBook['factor_number'];

			} elseif ($InfoBook['type_application'] == 'externalApi') {
				$detail['comment'] = " رزرو هتل اشتراکی خارجی به صورت کسر از اعتبار به شماره فاکتور " . $InfoBook['factor_number'];

			} elseif ($InfoBook['type_application'] == 'reservation') {
				$detail['comment'] = " رزرو هتل رزرواسیون به صورت کسر از اعتبار به شماره فاکتور " . $InfoBook['factor_number'];
			}

		} elseif ($Type == 'Bus') {

			$detail['member_id'] = $InfoBook['member_id'];
			$detail['requestNumber'] = $InfoBook['passenger_factor_num'];
            if ( $InfoBook['WebServiceType'] == 'private' ) {
                $detail['comment'] = " رزرو اتوبوس رزرواسیون به صورت کسر از اعتبار به شماره فاکتور " . $InfoBook['passenger_factor_num'];
            }else{
                $detail['comment'] = " رزرو اتوبوس اشتراکی به صورت کسر از اعتبار به شماره فاکتور " . $InfoBook['passenger_factor_num'];
            }

		}
        elseif ($Type == 'visaExpiration') {

            $detail['member_id'] = $InfoBook['member_id'];
            $detail['requestNumber'] = $InfoBook['visa_id'];
            $detail['comment'] = "خرید پلن ".$InfoBook['monthNumber']." ماهه برای ویزای ".$InfoBook['visa_title'].' ('.$InfoBook['visa_id'].') ';


        }
		elseif ($Type == 'Europcar') {

			$detail['member_id'] = $InfoBook['member_id'];
			$detail['requestNumber'] = $InfoBook['factor_number'];
			$detail['comment'] = " اجاره خودرو اشتراکی داخلی به صورت کسر از اعتبار به شماره فاکتور " . $InfoBook['factor_number'];

		} elseif ($Type == 'reservationTour') {

			$detail['member_id'] = $InfoBook['member_id'];
			$detail['requestNumber'] = $InfoBook['factor_number'];
			if ($InfoBook['status'] == 'TemporaryPreReserve') {
				$detail['comment'] = " پیش رزرو تور رزرواسیون به صورت کسر از اعتبار به شماره فاکتور " . $InfoBook['factor_number'];

			} elseif ($InfoBook['status'] == 'PreReserve') {
				$detail['comment'] = " رزرو قطعی تور رزرواسیون به صورت کسر از اعتبار به شماره فاکتور " . $InfoBook['factor_number'];
			}

		}
        elseif ($Type == 'exclusiveTour') {

			$detail['member_id'] = $InfoBook['member_id'];
			$detail['requestNumber'] = $InfoBook['factor_number'];
            $detail['comment'] = " رزرو تور به صورت کسر از اعتبار به شماره فاکتور " . $InfoBook['factor_number'];


		}
        elseif ($Type == 'Insurance') {

			$detail['member_id'] = $InfoBook['member_id'];
			$detail['requestNumber'] = $InfoBook['factor_number'];
			$detail['comment'] = "خرید بیمه به شماره فاکتور {$InfoBook['factor_number']} به صورت کسر از اعتبار";

		} elseif ($Type == 'reservationVisa') {

			$detail['member_id'] = $InfoBook['member_id'];
			$detail['requestNumber'] = $InfoBook['factor_number'];
			$detail['comment'] = "رزرو ویزا رزرواسیون به شماره فاکتور {$InfoBook['factor_number']} به صورت کسر از اعتبار";

		} elseif ($Type == 'gasht') {

			$detail['member_id'] = $InfoBook['member_id'];
			$detail['requestNumber'] = $InfoBook['passenger_factor_num'];
			$detail['comment'] = "رزرو گشت و ترانسفر به شماره فاکتور {$InfoBook['passenger_factor_num']} به صورت کسر از اعتبار";

		} elseif ($Type == 'Train') {

			$detail['member_id'] = $InfoBook[0]['member_id'];
			$detail['requestNumber'] = $InfoBook[0]['factor_number'];
			$detail['comment'] = "رزرو بلیط قطار به شماره فاکتور {$InfoBook[0]['factor_number']} به صورت کسر از اعتبار";

		} else {
			$detail['member_id'] = $InfoBook['member_id'];
			$detail['factorNumber'] = $InfoBook['factor_number'];
			$detail['requestNumber'] = $InfoBook['request_number'];
			$detail['comment'] = "خرید بلیط به شماره رزرو {$InfoBook['request_number']} به صورت کسر از اعتبار";
		}

		return $this->credit_detail_insert($detail);
	}

	function increase($userAgencyId, $InfoBook = array(), $Type = null) {
		$result = $this->getCreditIncrease($userAgencyId, $InfoBook['factor_number'], "increase");
		if (empty($result)) {
			$detail['fk_agency_id'] = $userAgencyId;
			$detail['credit'] = $InfoBook['total_price'];
			$detail['type'] = "increase";
			$detail['credit_date'] = dateTimeSetting::jdate("Y-m-d", time());
			$detail['reason'] = 'buy';
			$detail['PaymentStatus'] = 'success';
			$detail['creation_date_int'] = time();
			if ($Type == 'Europcar') {

				$detail['member_id'] = $InfoBook['member_id'];
				$detail['requestNumber'] = $InfoBook['factor_number'];
				$detail['comment'] = 'لغو رزرو اجاره خودرو به شماره فاکتور:  ' . $InfoBook['factor_number'];

			}

			return $this->credit_detail_insert($detail);
		}

	}


}