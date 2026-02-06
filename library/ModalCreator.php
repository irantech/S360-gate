<?php
require '../config/bootstrap.php';
require CONFIG_DIR . 'config.php';
require LIBRARY_DIR . 'Load.php';
require CONFIG_DIR . 'application.php';
spl_autoload_register(array('Load', 'autoload'));

class ModalCreator extends clientAuth {
	#region variable

	public $Controller;
	public $Method;
	public $target;
	public $id;

	#endregion
	#region __construct

	public function __construct() {

		$this->Controller = $_POST['Controller'];
		$Method = $_POST['Method'];
      $Param = isset($_POST['Param']) ? $_POST['Param'] : '';
		$Param2 = isset($_POST['ParamId']) ? $_POST['ParamId'] : '';
		$Param3 = isset($_POST['ParamClientId']) ? $_POST['ParamClientId'] : '';
		self::$Method($Param, $Param2, $Param3);
	}

	#endregion
	#region modalCancel

	public function ModalCancel($Param, $param2) {
		$user = Load::controller($this->Controller);
		$InfoCancelTicket = $user->InfoModalTicketCancel($Param, $param2);

        if (isset($param2) && $param2 == 'flight') {
			$Fee = functions::FeeCancelFlight($InfoCancelTicket[0]['airline_iata'], $InfoCancelTicket[0]['cabin_type']);
		}

		?>

		<div class="modal-header site-bg-main-color">
			<span class="close" onclick="modalClose()">&times;</span>
			<h2>  <?php echo functions::Xmlinformation("Cancelpurchasebookingnumber") ?>
				:<?php echo $Param ?> </h2>
			<input type="hidden" name="typeService" id="typeService" value="<?php echo $param2 ?>">
		</div>

		<div class="modal-body">
			<div class="modal-padding-bottom-15">
				<div class="row">
					<div class="col-md-12 modal-text-center modal-h ">   <?php echo functions::Xmlinformation("Pleaseselectthedesiredpassenger") ?></div>
				</div>
				<div class="row">
					<?php
					foreach ($InfoCancelTicket as $i => $info) {

					    if($param2 == 'bus' ){
					        $info['passenger_age'] = 'Adt';
                  $info['factor_number'] =  $info['passenger_factor_num'];
					        $NationalCodeUser = $info['passenger_national_code'] ;
					    }else{
					        $NationalCodeUser = $info['NationalCode'] ? $info['NationalCode'] : $info['passportNumber'] ;
					    }

//						(!empty($info['passenger_national_code']) && $info['passenger_national_code'] != '0000000000') ? $info['passenger_national_code'] : $info['passportNumber'];
						if ($i < 1) {
							?>
							<input type="hidden" value="<?php echo $info['factor_number'] ?>" name="FactorNumber"
							       id="FactorNumber"/>
							<input type="hidden" value="<?php echo $info['member_id'] ?>" name="MemberId"
							       id="MemberId"/>
							<?php
						}
						?>

						<div class="col-md-1 "><input class="form-control SelectUser" type="checkbox"
						                              name="SelectUser[]" id="SelectUser"
						                              value="<?php echo ($info['passenger_national_code'] != '0000000000' && $info['passenger_national_code'] != null) ? $info['passenger_national_code'] . '-' . $info['passenger_age'] : $info['passportNumber'] . '-' . $info['passenger_age'] ?>"
								<?php
								echo (!empty($info['Status']) && !empty($NationalCodeUser) && ($info['Status'] != 'Nothing' && $info['Status'] != 'close')) ? 'disabled ="disabled"' : '';
								?>

							></div>
						<div class="col-md-2">
							<span><?php echo $info['passenger_name'] . ' ' . $info['passenger_family']; ?></span>
						</div>

						<div class="col-md-3 "><span
							><?php echo functions::Xmlinformation("Nationalnumber") ?>
								/<?php echo functions::Xmlinformation("Passport") ?>

								:</span><span><?php

                    echo ($info['passenger_national_code'] != '0000000000' && $info['passenger_national_code']  != null && $info['passenger_national_code']  != "") ? $info['passenger_national_code'] : $info['passportNumber'] ?></span>
						</div>
						<div class="col-md-2 "><span
							><?php echo functions::Xmlinformation("DateOfBirth") ?>
								: </span><span><?php echo (!empty($info['passenger_birthday'])) ? $info['passenger_birthday'] : $info['passenger_birthday_en'] ?></span>
						</div>

						<div class="col-md-1 "> <span><?php
								switch ($info['passenger_age']) {

								case 'Adt':
									echo functions::Xmlinformation("Adult");
									break;

								case 'Chd':
									echo functions::Xmlinformation("Child");
									break;

								case 'Inf':
									echo functions::Xmlinformation("Baby");
									break;
								}
								?></span></div>

						<div class="col-md-3 col-lg-3 col-xs-12 col-sm-12 txtCenter"><?php

							if (!empty($info['Status']) && !empty($NationalCodeUser) && $info['Status'] != 'Nothing') {
								if ($info['Status'] == 'SetCancelClient') {
									?>
									<div class="btn btn-danger"><?php echo functions::Xmlinformation("Deniedrequest") ?></div>
									<?php
								} elseif($info['Status'] !='close') {
									?>
									<div class="btn btn-warning"><?php echo functions::Xmlinformation("Actionhasalreadybeentaken") ?></div>

									<?php
								}
							}
							?></div>
						<?php
					}
					?>

				</div>
				<?php
				if (functions::TypeUser(Session::getUserId()) == 'Ponline') {
					?>
					<div class="row">

						<div class="col-md-12 modal-text-center modal-h ">
							<label for="ReasonUser"><?php echo functions::Xmlinformation("Pleaseenteryourinformationreturningmoneyyouraccount") ?></label>
						</div>
						<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 nopad  " style="direction: rtl;margin: 10px">
							<label style="float:right;"><?php echo functions::Xmlinformation("CardOrShebanumber") ?></label>

							<input class="form-control " type="text" id="CardNumber" name="CardNumber"
							       style="float: right;margin-right: 10px">
						</div>
						<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 nopad  " style="direction: rtl;margin: 10px">
							<label style="float:right;"><?php echo functions::Xmlinformation("Namebankowner") ?></label>
							<input class="form-control " type="text" id="AccountOwner" name="AccountOwner"
							       style="float: right;margin-right: 10px">
						</div>

						<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12 nopad  " style="direction: rtl;margin: 10px">
							<label style="float:right;"><?php echo functions::Xmlinformation("Cardname") ?></label>
							<input class="form-control " type="text" id="NameBank" name="NameBank"
							       style="float: right;margin-right: 10px">
						</div>


					</div>
				<?php }

				if (isset($param2) && $param2 == 'flight') {
					if (!empty($Fee) && strtolower($InfoCancelTicket[0]['flight_type']) == 'system') {
						?>
						<div class="cancel-policy cancel_modal">
							<div class="cancel-policy-head">
								<div class="cancel-policy-head-text"><?php echo functions::Xmlinformation("DetailMoneyCancel") ?></div>
								<div class="cancel-policy-class">


									<span><?php echo functions::Xmlinformation("Classflight") ?>
										:</span><span> <?php echo $Fee['TypeClass'] ?> </span></div>


								<div class="cancel-policy-class">


									<span><?php


           						 $diff_time = functions::dateDiff(date('Y-m-d',time()),$InfoCancelTicket[0]['date_flight']) ;

										if($diff_time > 3){
                                            $percent_indemnity = is_numeric($Fee['ThreeDaysBefore']) ? $Fee['ThreeDaysBefore'] : -1 ;
										}if($diff_time < 3 && $diff_time >=1){
                                            $percent_indemnity =  is_numeric($Fee['OneDaysBefore']) ? $Fee['OneDaysBefore'] : -1 ;
										}elseif($diff_time < 1){
                                            $time1 = $InfoCancelTicket[0]['time_flight'];

                                            $time2 = date('H:i:s',time());

// Create DateTime objects
                                            $dateTime1 = new DateTime($time1);
                                            $dateTime2 = new DateTime($time2);

// Calculate the difference
                                            $timeDifference = $dateTime1->diff($dateTime2);

											if($timeDifference->h > 3){
												$percent_indemnity =  is_numeric($Fee['ThreeHoursBefore']) ? $Fee['ThreeHoursBefore'] : -1 ;
											}elseif($timeDifference->m > 30){
												$percent_indemnity =  is_numeric($Fee['ThirtyMinutesAgo']) ? $Fee['ThirtyMinutesAgo'] : -1 ;
											}else{
												$percent_indemnity =  is_numeric($Fee['OfThirtyMinutesAgoToNext']) ? $Fee['OfThirtyMinutesAgoToNext'] : -1 ;
											}
										}
										list($TotalPrice,$fare) = functions::TotalPriceCancelTicketSystem($InfoCancelTicket);
										$InfoCancelTicket[0]['PercentIndemnity'] = $percent_indemnity;
										$PricePenalty = functions::CalculatePenaltyPriceCancel($TotalPrice,$fare, $InfoCancelTicket[0]);
										$indemnityPrice =round($PricePenalty - (30000 * count($InfoCancelTicket)));

									echo ' میزان مبلغ استرداد احتمالی در حال حاضر' ?>
										:</span><span> <?php echo $percent_indemnity > 0 ? number_format($indemnityPrice) .'ریال' : ' بعد از ثبت درخواست مشخص میشود' ;  ?> </span></div>
							</div>
							<div class="cancel-policy-inner">
								<div class="cancel-policy-item cancel_modal">
									<span class="cancel-policy-item-text"><?php echo functions::Xmlinformation("Fromthetimeticketissueuntilnoondaysbeforeflight") ?></span>
									<span class="cancel-policy-item-pnalty site-bg-main-color"><?php echo is_numeric($Fee['ThreeDaysBefore']) ? $Fee['ThreeDaysBefore'] . functions::Xmlinformation("PenaltyPercent") : $Fee['ThreeDaysBefore']; ?> </span>
								</div>

								<div class="cancel-policy-item cancel_modal">
									<span class="cancel-policy-item-text"><?php echo functions::Xmlinformation("Fromnoondaysbeforeflightnoondaybeforeflight") ?></span>
									<span class="cancel-policy-item-pnalty site-bg-main-color"><?php echo is_numeric($Fee['OneDaysBefore']) ? $Fee['OneDaysBefore'] . functions::Xmlinformation("PenaltyPercent") : $Fee['OneDaysBefore']; ?> </span>
								</div>
								<div class="cancel-policy-item cancel_modal">

									<span class="cancel-policy-item-text"><?php echo functions::Xmlinformation("Fromnoondaybeforeflighthoursbeforeflight") ?></span>
									<span class="cancel-policy-item-pnalty site-bg-main-color"><?php echo is_numeric($Fee['ThreeHoursBefore']) ? $Fee['ThreeHoursBefore'] . functions::Xmlinformation("PenaltyPercent") : $Fee['ThreeHoursBefore']; ?> </span>
								</div>
								<div class="cancel-policy-item cancel_modal">
									<?php echo functions::Xmlinformation("Fromnoondaybeforeflighthoursbeforeflight") ?>
									<span class="cancel-policy-item-text"><?php echo functions::Xmlinformation("Fromhoursbeforeflighttominutesbeforeflight") ?></span>
									<span class="cancel-policy-item-pnalty site-bg-main-color"><?php echo is_numeric($Fee['ThirtyMinutesAgo']) ? $Fee['ThirtyMinutesAgo'] . functions::Xmlinformation("PenaltyPercent") : $Fee['ThirtyMinutesAgo']; ?> </span>
								</div>

								<div class="cancel-policy-item cancel_modal">
									<span class="cancel-policy-item-text">   <?php echo functions::Xmlinformation("Minutesbeforetheflight") ?></span>
									<span class="cancel-policy-item-pnalty site-bg-main-color"><?php echo is_numeric($Fee['OfThirtyMinutesAgoToNext']) ? $Fee['OfThirtyMinutesAgoToNext'] . functions::Xmlinformation("PenaltyPercent") : $Fee['OfThirtyMinutesAgoToNext']; ?> </span>
								</div>
							</div>
						</div>
					<?php } else if (empty($Fee) && strtolower($InfoCancelTicket[0]['flight_type']) == 'system') { ?>
						<div class="cancel-policy cancel_modal cancel-policy-charter1">
							<div class="cancel-policy-head">

								<div class="cancel-policy-head-text"><?php echo functions::Xmlinformation("DetailMoneyCancel") ?></div>
							</div>
							<span class="site-bg-main-color"><?php echo functions::Xmlinformation("Contactbackupunitinformationaboutamountconsignmentfines") ?></span>
						</div>

					<?php } else { ?>
						<div class="cancel-policy cancel_modal cancel-policy-charter1">
							<div class="cancel-policy-head">
								<div class="cancel-policy-head-text"><?php echo functions::Xmlinformation("DetailMoneyCancel") ?></div>
							</div>
							<span class="site-bg-main-color"><?php echo functions::Xmlinformation("ThecharterflightscharterunderstandingCivilAviationOrganization") ?></span>
						</div>
						<?php
					}
				}
				?>
				<div class="row">
					<div class="col-md-12 modal-text-center modal-h mb-3">
						<label for="ReasonUser"><?php echo functions::Xmlinformation("Pleaseselectyourdesiredoptions") ?></label>
					</div>
					<div class="col-md-3 col-lg-3 col-sm-12  nopad ">
						<select class="form-control mart5" name="ReasonUser"
						        id="ReasonUser">
							<option value=""> <?php echo functions::Xmlinformation("Choosereasonfortheconsole") ?></option>
							<option value="PersonalReason"><?php echo functions::Xmlinformation("Canselforpersonalreasons") ?></option>
							<?php if (isset($param2) && $param2 == 'flight') { ?>
								<option value="DelayTwoHours"><?php echo functions::Xmlinformation("Delaymorethantwohours") ?></option>
								<option value="CancelByAirline"><?php echo functions::Xmlinformation("AbandonedbyAirline") ?></option>
							<?php } elseif($param2 == 'train') { ?>
								<option value="DelayTwoHours"><?php echo functions::Xmlinformation("delayTrain") ?></option>
							<?php }else{
							    //else
							} ?>
						</select>
					</div>

					<?php
					if (isset($param2) && $param2 == 'flight') {
						if (empty($Fee) && strtolower($InfoCancelTicket[0]['flight_type']) != 'system') { ?>
							<div class="col-md-5 col-lg-5 col-sm-12  nopad ">
								<div class="col-md-1 col-lg-1 col-sm-12 col-xs-12 nopad">
									<input class="form-control " type="checkbox" id="PercentNoMatter"
									       name="PercentNoMatter"
									       style="height: 40px">
								</div>
								<div class="col-md-11 col-lg-11 col-sm-12 col-xs-12 lh45 nopad">
									<?php echo functions::Xmlinformation("Idonotcareaboutthepercentagepenaltypleasebesurecancel") ?>
								</div>
							</div>
						<?php }
					} ?>
					<div class="mr-auto d-flex nopad align-items-center">
						<div class="input_s">
							<input class="form-control" type="checkbox" id="Ruls" name="Ruls" style="height: 40px">
						</div>
						<div class="mr-2 lh45">
							<?php echo functions::Xmlinformation("Iam") ?> <a
									href="<?php echo URL_RULS ?>"
									style="margin-top: 5px"><?php echo functions::Xmlinformation("Seerules") ?></a> <?php echo functions::Xmlinformation("IhavestudiedIhavenoobjection") ?>
						</div>
					</div>
					<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
						<div class="DescriptionReason showContentTextModal" style="display : none"></div>
					</div>
				</div>
        <div class="row">
            <?php
            if (isset($param2) && $param2 == 'train') {
                ?>
                <ol class="list-group">
                    <li class="list-group-item"><?php echo functions::Xmlinformation("liOneTrainCancel") ?></li>
                    <li class="list-group-item"><?php echo functions::Xmlinformation("liTwoTrainCancel") ?></li>
                    <li class="list-group-item"><?php echo functions::Xmlinformation("liTreeTrainCancel") ?></li>
                    <li class="list-group-item"><?php echo functions::Xmlinformation("liFourTrainCancel") ?></li>
                </ol>
            <?php }
            ?>
        </div>

			</div>
		</div>
		<div class="modal-footer site-bg-main-color">
			<div class="col-md-12" style="text-align:left; position: relative;
        overflow: hidden;">
				<button class="btn btn-primary btn-send-information pull-left" id='btn-information' onclick="SelectUser('<?php echo $Param ?>')">
            <?php echo functions::Xmlinformation("Sendinformation") ?>
          <div class="spinner-border" id='btn-send-information-load' role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </button>


<!--        <div class="donut"></div>-->
			</div>
		</div>

		<?php
	}

	#endregion
	#region ModalShow

	public function ModalShow($Param) {
		$user = Load::controller($this->Controller);
		$Tickets = functions::info_flight_client($Param);
		?>

		<div class="modal-header site-bg-main-color">
			<span class="close" onclick="modalClose()">&times;</span>
			<h2><?php echo functions::Xmlinformation("Viewpurchasetobookingnumber") ?>
				:<?php echo $Param; ?> </h2>
		</div>
		<div class="modal-body">
			<?php
			foreach ($Tickets as $key => $view) {
				if ($key < 1) {
					?>
					<div class="row margin-both-vertical-20">
						<div class="col-md-12 modal-text-center modal-h">
							<span> <?php echo functions::Xmlinformation("Flightprofile") ?></span></div>
					</div>

					<div class="row">
						<div class="col-md-4 ">
							<span><?php echo functions::Xmlinformation("Date"); ?> <?php echo $view['payment_type'] == 'cash' ? functions::Xmlinformation("Payment") : functions::Xmlinformation("Buy"); ?>
								: </span>
							<span dir="rtl"><?php echo !empty($view['payment_date']) ? functions::set_date_payment($view['payment_date']) : functions::Xmlinformation("Unpaid") ?></span>
						</div>

						<div class="col-md-4 ">

							<span><?php echo functions::Xmlinformation("Reservationdate") ?> : </span>
							<span dir="rtl"><?php echo $user->set_date_reserve($view['creation_date']) ?></span></div>
						<div class="col-md-4 ">
							<span><?php echo functions::Xmlinformation("WachterNumber") ?> :</span>

							<span><?php echo $view['request_number'] ?></span>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 ">

							<span><?php echo functions::Xmlinformation("Origin") ?>
								/ <?php echo functions::Xmlinformation("Destination") ?>
								: </span><span><?php echo $view['origin_city'] ?>
								/ <?php echo $view['desti_city'] ?></span>
						</div>
						<div class="col-md-4 ">
							<span><?php echo functions::Xmlinformation("Count") ?>
								:</span><span><?php echo $view['CountId']; ?></span>
						</div>


						<div class="col-md-4 "><span><?php echo functions::Xmlinformation("Dateandtimeofflight") ?>
								:</span>
							<span> <?php echo $user->format_hour($view['time_flight']) . ' ' . $user->DateJalali($view['date_flight']) ?></span>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 ">

							<span> <?php echo functions::Xmlinformation("Nameairline") ?> :</span>
							<span><?php echo $view['airline_name'] ?></span>
						</div>
						<div class="col-md-4 ">

							<span><?php echo functions::Xmlinformation("Classflight") ?>: </span>
							<span><?php echo ($view['seat_class'] == 'C' || $view['seat_class'] == 'B') ? functions::Xmlinformation("BusinessType") : functions::Xmlinformation("EconomicsType") ?> </span>
						</div>

						<div class="col-md-4 "><span> <?php echo functions::Xmlinformation("Typeflight") ?>: </span>
							<span><?php echo $view['flight_type'] == 'system' ? functions::Xmlinformation("SystemType") : functions::Xmlinformation("CharterType") ?> </span>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 ">

							<span><?php echo functions::Xmlinformation("Numflight") ?>
								:</span><span><?php echo $view['flight_number'] ?> </span>
						</div>
						<div class="col-md-4 ">
							<span dir="rtl"><?php echo functions::Xmlinformation("PnrCode") ?>
								:</span><span><?php echo $view['pnr']; ?></span>
						</div>

						<div class="col-md-4 "><span><?php echo functions::Xmlinformation("Amount") ?> :</span>
							<span> <?php
								if ($view['percent_discount'] > 0) {
								    list($amount,$fare) = $user->total_price($view['request_number']) ;
									echo '<span style="text-decoration: line-through;">' . number_format($amount) . '</span>,' . ' ' . '<span>' . number_format(functions::calcDiscountCodeByFactor(functions::CalculateDiscount($view['request_number']), $view['factor_number'])) . '</span>';
								} else {
									echo '<span>' . number_format(functions::calcDiscountCodeByFactor($amount, $view['factor_number'])) . '</span>';
								}
								?><?php echo functions::Xmlinformation("Rial") ?>
                            </span>
						</div>
					</div>
					<div class="row margin-top-10">
						<div class="col-md-12 modal-text-center modal-h">
							<span><?php echo functions::Xmlinformation("Travelerprofile") ?></span></div>
					</div>
				<?php } ?>

				<div class="row modal-padding-bottom-15">
					<div class="col-md-3 ">


						<span><?php echo functions::Xmlinformation("Namefamily") ?> :</span>
						<span><?php echo $view['passenger_name'] . ' ' . $view['passenger_family'] ?></span>
					</div>
					<div class="col-md-3 ">
						<span><?php echo functions::Xmlinformation("Nationalnumber"); ?>
							/<?php echo functions::Xmlinformation("Passport"); ?>:</span>
						<span><?php echo ($view['passenger_national_code'] != '0000000000') ? $view['passenger_national_code'] : $view['passportNumber'] ?></span>
					</div>
					<div class="col-md-3 ">
						<span dir="rtl"><?php echo functions::Xmlinformation("DateOfBirth") ?>: </span>
						<span><?php echo (!empty($view['passenger_birthday'])) ? $view['passenger_birthday'] : $view['passenger_birthday_en'] ?></span>
					</div>
					<div class="col-md-3 ">
						<span dir="rtl"><?php echo functions::Xmlinformation("Ticketnumber") ?>: </span>
						<span><?php echo $view['eticket_number']; ?></span>
					</div>
				</div>

			<?php } ?>
		</div>
		<div class="modal-footer site-bg-main-color">

		</div>

		<?php
	}

	#endregion

	#region ModalShowProof

	public function ModalShowProof($Param) {

		$reservationProof = Load::controller($this->Controller);

		$Tickets = functions::info_flight_client($Param['requestNumber']);
    $file = $reservationProof->getProofFile($Param['requestNumber'] , $Param['type']);


     $ext = pathinfo($file['file_path'], PATHINFO_EXTENSION) ;
      if(in_array($ext,['jpg','gif','png','tif', 'jpeg'])) {
        $file_url = ROOT_ADDRESS_WITHOUT_LANG . '/pic/proof/' . $file['file_path'];
        $image_url =ROOT_ADDRESS_WITHOUT_LANG . '/pic/proof/' . $file['file_path'];
      }else {
        $file_url = ROOT_ADDRESS_WITHOUT_LANG . '/pic/proof/' . $file['file_path'];
        $image_url = ROOT_ADDRESS_WITHOUT_LANG . '/pic/ext-icons/'.$ext.'.png';
      }
		?>

		<div class="modal-header site-bg-main-color">
			<span class="close" onclick="modalClose()">&times;</span>
			<h2><?php echo functions::Xmlinformation("Viewpurchasetobookingnumber") ?>
				:<?php echo $Param['requestNumber']; ?> </h2>
		</div>
		<div class="modal-body">
			<?php
			foreach ($Tickets as $key => $view) {
				if ($key < 1) {
					?>
					<div class="row margin-both-vertical-20">
						<div class="col-md-12 modal-text-center modal-h">
							<span> <?php echo functions::Xmlinformation("Flightprofile") ?></span></div>
					</div>

					<div class="row">
						<div class="col-md-4 ">
							<span><?php echo functions::Xmlinformation("Date"); ?> <?php echo $view['payment_type'] == 'cash' ? functions::Xmlinformation("Payment") : functions::Xmlinformation("Buy"); ?>
								: </span>
							<span dir="rtl"><?php echo !empty($view['payment_date']) ? functions::set_date_payment($view['payment_date']) : functions::Xmlinformation("Unpaid") ?></span>
						</div>


						<div class="col-md-4 ">
							<span><?php echo functions::Xmlinformation("WachterNumber") ?> :</span>

							<span><?php echo $view['request_number'] ?></span>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 ">

							<span><?php echo functions::Xmlinformation("Origin") ?>
								/ <?php echo functions::Xmlinformation("Destination") ?>
								: </span><span><?php echo $view['origin_city'] ?>
								/ <?php echo $view['desti_city'] ?></span>
						</div>
						<div class="col-md-4 ">
							<span><?php echo functions::Xmlinformation("Count") ?>
								:</span><span><?php echo $view['CountId']; ?></span>
						</div>



					</div>
					<div class="row">
						<div class="col-md-4 ">

							<span> <?php echo functions::Xmlinformation("Nameairline") ?> :</span>
							<span><?php echo $view['airline_name'] ?></span>
						</div>
						<div class="col-md-4 ">

							<span><?php echo functions::Xmlinformation("Classflight") ?>: </span>
							<span><?php echo ($view['seat_class'] == 'C' || $view['seat_class'] == 'B') ? functions::Xmlinformation("BusinessType") : functions::Xmlinformation("EconomicsType") ?> </span>
						</div>

						<div class="col-md-4 "><span> <?php echo functions::Xmlinformation("Typeflight") ?>: </span>
							<span><?php echo $view['flight_type'] == 'system' ? functions::Xmlinformation("SystemType") : functions::Xmlinformation("CharterType") ?> </span>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 ">

							<span><?php echo functions::Xmlinformation("Numflight") ?>
								:</span><span><?php echo $view['flight_number'] ?> </span>
						</div>
						<div class="col-md-4 ">
							<span dir="rtl"><?php echo functions::Xmlinformation("PnrCode") ?>
								:</span><span><?php echo $view['pnr']; ?></span>
						</div>


					</div>
					<div class="row margin-top-10">
						<div class="col-md-12 modal-text-center modal-h">
							<span><?php echo functions::Xmlinformation("Travelerprofile") ?></span></div>
					</div>
				<?php } ?>

				<div class="row modal-padding-bottom-15">
					<div class="col-md-3 ">


						<span><?php echo functions::Xmlinformation("Namefamily") ?> :</span>
						<span><?php echo $view['passenger_name'] . ' ' . $view['passenger_family'] ?></span>
					</div>
					<div class="col-md-3 ">
						<span><?php echo functions::Xmlinformation("Nationalnumber"); ?>
							/<?php echo functions::Xmlinformation("Passport"); ?>:</span>
						<span><?php echo ($view['passenger_national_code'] != '0000000000') ? $view['passenger_national_code'] : $view['passportNumber'] ?></span>
					</div>
					<div class="col-md-3 ">
						<span dir="rtl"><?php echo functions::Xmlinformation("DateOfBirth") ?>: </span>
						<span><?php echo (!empty($view['passenger_birthday'])) ? $view['passenger_birthday'] : $view['passenger_birthday_en'] ?></span>
					</div>
					<div class="col-md-3 ">
						<span dir="rtl"><?php echo functions::Xmlinformation("Ticketnumber") ?>: </span>
						<span><?php echo $view['eticket_number']; ?></span>
					</div>
				</div>

			<?php } ?>

				<div class="row margin-both-vertical-20">
						<div class="col-md-12 modal-text-center modal-h">
							<span> <?php echo functions::Xmlinformation("proofFile") ?> </span>
						</div>
						<div class="row">
						<?php
              if($file && isset($file) && !empty($file)){
                ?>
                <div class="col-md-12 ">
                <span dir="rtl">
                <a href='<?php echo $file_url ?>' target='_blank' class='d-flex py-2' style = "width: 200px; height: 200px;">
                  <img src="<?php echo $image_url?>" class='w-100 h-100' alt="<?php echo $file['file_title']?>">
                </a>


                </span>
              </div>
            <?php
                }else {

            ?>
              <div class="col-md-12 ">
                <p><?php echo functions::Xmlinformation("notUploadedProof") ?></p>
              </div>
            <?php
               }
            ?>

					</div>
				</div>

		</div>
		<div class="modal-footer site-bg-main-color">

		</div>

		<?php
	}

	#endregion

	#region ModalTrackingCancelTicket

	public function ModalTrackingCancelTicket($Param, $id) {


		$user = Load::controller($this->Controller);

		$InfoCancelTicket = $user->ShowInfoModalTicketCancel($Param, $id);
		?>
		<div class="modal-dialog modal-lg"></div>
		<div class="modal-header site-bg-main-color">


			<span class="close" onclick="modalClose()">&times;</span>
			<h2><?php echo functions::Xmlinformation("SeeConsolidationRequestFlightNumber"); ?>
				:<?php echo $Param ?> </h2>
		</div>
		<div class="modal-body ">
			<div class=" modal-padding-bottom-15">

				<div class="row">
					<div class="col-md-12 pull-left "><?php echo functions::Xmlinformation("PassengersList"); ?></div>
				</div>
				<hr>

					<?php
					foreach ($InfoCancelTicket as $i => $info) {

						if ($i < 1) {
							?>
							<input type="hidden" value="<?php echo $info['factor_number'] ?>" name="FactorNumber"
							       id="FactorNumber"/>
							<input type="hidden" value="<?php echo $info['member_id'] ?>" name="MemberId"
							       id="MemberId"/>
							<?php
						}
						?>
						<div class="row modal-padding-bottom-15 modaling_">
							<div class="col-md-2 col-lg-3 col-sm-12 col-xs-12">
								<span><?php echo $info['passenger_name'] . ' ' . $info['passenger_family']; ?></span>
							</div>
							<div class="col-md-3  col-lg-3 col-sm-12 col-xs-12">
								<span><?php echo functions::Xmlinformation("Nationalnumber"); ?>
									/ <?php echo functions::Xmlinformation("Passport"); ?> :: </span>
								<span> <?php echo ($info['passenger_national_code'] != '0000000000') ? $info['passenger_national_code'] : $info['passportNumber'] ?></span>
							</div>
							<div class="col-md-2 col-lg-2 col-sm-12 col-xs-12 ">
								<span> <?php echo functions::Xmlinformation("DateOfBirth"); ?>: </span>
								<span> <?php echo (!empty($info['passenger_birthday'])) ? $info['passenger_birthday'] : $info['passenger_birthday_en'] ?></span>
							</div>
							<div class="col-md-1 col-lg-1 col-sm-12 col-xs-12 "> <span><?php
									switch ($info['passenger_age']) {

									case 'Adt':
										echo functions::Xmlinformation("Adult");
										break;

									case 'Chd':
										echo functions::Xmlinformation("Child");
										break;

									case 'Inf':
										echo functions::Xmlinformation("Baby");
										break;
									}
									?></span></div>
							<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
								<div class="<?php
								switch ($info['Status']) {
								case 'RequestMember' :
									echo !empty($info['NationalCode']) ? 'btn btn-primary' : '';
									break;
								case 'SetCancelClient' :
									echo !empty($info['NationalCode']) ? 'btn btn-danger' : '';
									break;
								case 'RequestClient' :
									echo !empty($info['NationalCode']) ? 'btn btn-warning' : '';
									break;
								case 'SetIndemnity' :
									echo !empty($info['NationalCode']) ? 'btn btn-warning' : '';
									break;
								case 'SetFailedIndemnity' :
									echo !empty($info['NationalCode']) ? 'btn btn-danger' : '';
									break;
								case 'close' :
									echo !empty($info['NationalCode']) ? 'btn btn-danger' : '';
									break;
								case 'ConfirmClient' :
									echo !empty($info['NationalCode']) ? 'btn btn-warning' : '';
									break;
								case 'ConfirmCancel' :
									echo !empty($info['NationalCode']) ? 'btn btn-success' : '';
									break;
								}
								?>">
									<?php
									switch ($info['Status']) {
									case 'RequestMember' :
										echo !empty($info['NationalCode']) ? functions::Xmlinformation("UserRequest") : '';
										break;
									case 'SetCancelClient' :
										echo !empty($info['NationalCode']) ? functions::Xmlinformation("Rejectrequest") : '';
										break;
									case 'RequestClient' :
										echo !empty($info['NationalCode']) ? functions::Xmlinformation("Pending") : '';
										break;
									case 'SetIndemnity' :
										echo !empty($info['NationalCode']) ? functions::Xmlinformation("Pending") : '';
										break;
									case 'SetFailedIndemnity' :
										echo !empty($info['NationalCode']) ? functions::Xmlinformation("Rejectrequest") : '';
										break;
									case 'close' :
										echo !empty($info['NationalCode']) ? functions::Xmlinformation("closeTicket") : '';
										break;
									case 'ConfirmClient' :
										echo !empty($info['NationalCode']) ? functions::Xmlinformation("Pending") : '';
										break;
									case 'ConfirmCancel' :
										echo !empty($info['NationalCode']) ? functions::Xmlinformation("AcceptRequest") : '';
										break;
									}
									?>
								</div>
							</div>
						</div>


						<?php
					}
					?>

					<div class="row modal-padding-bottom-15 modaling_">
						<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
							<?php echo functions::Xmlinformation("PurchaseNumber"); ?>
							:<?php echo $info['RequestNumber']; ?>
						</div>
						<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
							<span style="float: right"><?php echo functions::Xmlinformation("CancellationApplicationDate"); ?>
								:</span> <?php echo dateTimeSetting::jdate('(H:i:s) Y-m-d', $info['DateRequestMemberInt']); ?>
						</div>
						<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
							<?php echo functions::Xmlinformation("Approvaldate"); ?>
							/<?php echo functions::Xmlinformation("Rejectrequest"); ?> :<?php
							if ($info['DateSetCancelInt'] != '0' || $info['DateConfirmCancelInt'] != '0' || $info['DateSetFailedIndemnityInt'] != '0') {
								if ($info['Status'] == 'SetCancelClient') {
									echo dateTimeSetting::jdate('(H:i:s) Y-m-d', $info['DateSetCancelInt']);
								} else if ($info['Status'] == 'ConfirmCancel') {
									echo dateTimeSetting::jdate('(H:i:s) Y-m-d', $info['DateConfirmCancelInt']);
								} else if ($info['Status'] == 'SetFailedIndemnity') {
									echo dateTimeSetting::jdate('(H:i:s) Y-m-d', $info['DateConfirmCancelInt']);
								} else {
									echo ' -----';
								}
							} else {
								echo ' -----';
							}
							?>
						</div>
						<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
							<?php echo functions::Xmlinformation("Percentagepenalty"); ?>:<?php
							if ($info['Status'] == 'ConfirmCancel') {
								echo $info['PercentIndemnity'] . '%';
							} else {
								echo ' -----';
							}
							?>
						</div>
						<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
							<?php echo functions::Xmlinformation("RefundAmount"); ?>:<?php
							if ($info['Status'] == 'ConfirmCancel') {
								echo number_format($info['PriceIndemnity']) . functions::Xmlinformation("Rial");
							} else {
								echo ' -----';
							}
							?>
						</div>

						<?php if ($info['Status'] == "SetCancelClient"): ?>
							<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
								<?php echo functions::Xmlinformation("Description"); ?>:<?php
								if (!empty($InfoCancelTicket[0]['DescriptionClient'])) {
									?>
									<span><?php echo $InfoCancelTicket[0]['DescriptionClient']; ?></span>
									<?php
								} else {
									?>
									<span>-------</span>
									<?php
								}
								?>
							</div>
						<?php endif; ?>
						<?php if (functions::TypeUser(CLIENT_ID) == 'Ponline') {
							?>
							<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
								<div class="col-md-3 col-lg-4 col-sm-12 col-xs-12"><?php echo functions::Xmlinformation("CardNotificationNumber"); ?>
									:<span><?php echo $InfoCancelTicket[0]['CardNumber'] ?></span></div>
								<div class="col-md-3 col-lg-4 col-sm-12 col-xs-12"><?php echo functions::Xmlinformation("NameAccountHolder"); ?>
									:<span><?php echo $InfoCancelTicket[0]['AccountOwner'] ?></span></div>
								<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12"><?php echo functions::Xmlinformation("BankAssociatedCard"); ?>
									:<span><?php echo $InfoCancelTicket[0]['NameBank'] ?></span></div>

							</div>
						<?php } ?>
					</div>


			</div>
		</div>
		<div class="modal-footer site-bg-main-color">

		</div>

		<?php
	}

	#endregion
	#region ModalShowBook

	/**
	 * @param $Param
	 * @param $type
	 */
	public function ModalShowBook($Param, $type) {

		$typeFlight = ($type == 'flight' || $type == '');
		$objDiscountCode = Load::controller('discountCodes');
		if ($typeFlight) {
			/** @var bookshow $objbook */
			$objbook = Load::controller($this->Controller);
			$ticketsInfo = functions::info_flight_directions($Param);
		} elseif ($type == 'train') {
			$ticketsInfo = functions::info_train_directions($Param, 'yes');
		} elseif ($type == 'bus') {
		   $objbook = Load::controller($this->Controller);
			$ticketsInfo = functions::info_bus_directions($Param);
		}
    elseif ($type == 'insurance') {
        $objbook = Load::controller($this->Controller);
        $ticketsInfo = functions::info_insurance_directions($Param);
    }
    elseif ($type == 'hotel') {
        $objbook = Load::controller($this->Controller);
        $ticketsInfo = functions::info_hotel_directions($Param);
    }

		$info_cancel_ticket = $ticketsInfo['info_detail_cancel'] ;
		unset($ticketsInfo['info_detail_cancel']);

			$array_national = [];
		if(!empty($info_cancel_ticket)){
			foreach($info_cancel_ticket as $item){
				$array_national[] = $item['NationalCode'];
			}
		}
		?>

		<div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">مشاهده مشخصات بلیط
						&nbsp; <?php echo !empty($ticketsInfo[0]['member_name']) ? 'کاربر اصلی ' : 'کاربرمهمان' ?></h4>
				</div>
				<div class="modal-body">
					<?php
					$agency = Load::model("agency");
					foreach ($ticketsInfo as $key => $view) {




					    if($type == 'bus' || $type == 'hotel'){
						    $view['mobile_buyer'] = $view['member_mobile'];
						    $view['email_buyer'] = $view['member_email'];


						}
              if($type != 'flight') {
                  $agencyInfo = $Client = functions::infoClient($view['client_id']);
              }


						if(isset($typeFlight) && $typeFlight){
                            $requestNumber = $view['request_number'];
                        }elseif($type == 'bus'){
						    $requestNumber = $view['order_code'];
                        }
            elseif($type == 'hotel' || $type == 'insurance'){
                $requestNumber = $view['factor_number'];
            }
            elseif($type == 'insurance'){
                $requestNumber = $view['order_code'];
            }
            else{
						     $requestNumber =$view['requestNumber'];
                        }
						?>

						<?php
							if($key==0 && !empty($info_cancel_ticket) && TYPE_ADMIN ==1){
								?>
									<div class="row margin-both-vertical-20">
										<div class="col-md-12 text-center text-bold" style="color: #fb002a;">
												<span>اطلاعات کنسلی</span>
										</div>
									<div class="row margin-both-vertical-20">
										<div class="col-md-4 ">

											<span>اهمیت درصد کنسلی  : </span><span><?php echo ($info_cancel_ticket[0]['PercentNoMatter'] == 'No' ? 'مهم نیست' : 'مهم هست') ?></span>

										</div>


										<div class="col-md-4 ">

											<span>توضیحات مشتری : </span><span><?php echo ($info_cancel_ticket[0]['DescriptionClient']) ?></span>

										</div>


											<div class="col-md-4 ">

											<span>یادداشت </span><span><?php echo ($info_cancel_ticket[0]['note_admin']) ?></span>

										</div>
									</div>

							<?php
							}
						?>

						<?php if ($key == 0) { ?>
							<div class="row margin-both-vertical-20">
								<div class="col-md-12 text-center text-bold" style="color: #fb002a;">
									<span>مشخصات کاربر</span></div>
							</div>

							<div class="row margin-both-vertical-20">
								<div class="col-md-4 ">
									<span>نام و نام خانوادگی  : </span><span><?php echo $view['member_name'] ?></span>
								</div>
								<div class="col-md-4 ">
									<span class=""> شماره تلفن موبایل: </span><span
											class="yn"><?php echo $view['member_mobile'] ?></span>
								</div>
								<div class="col-md-4 ">
									<span>ایمیل :</span><span><?php echo $view['member_email'] ?></span>
								</div>
							</div>


							<hr style="margin: 5px 0;"/>

							<div class="row margin-both-vertical-20">
								<div class="col-md-12 text-center text-bold" style="color: #fb002a;"><span>اطلاعات خریدار </span>
								</div>
							</div>

							<div class="row margin-both-vertical-20">
								<div class="col-md-6 ">
									<span>شماره تماس  : </span><span><?php echo $view['mobile_buyer'] ?></span>
								</div>
								<div class="col-md-6 ">
									<span class=""> ایمیل: </span><span
											class="yn"><?php echo $view['email_buyer'] ?></span>
								</div>
							</div>
							<hr style="margin: 5px 0;"/>

							<div class="row margin-both-vertical-20">
								<div class="col-md-12 text-center text-bold " style="color: #fb002a;"><span>مشخصات پرداخت</span>
								</div>
							</div>

							<div class="row margin-both-vertical-20">
								<div class="col-md-4">
									<span class=" pull-left">تاریخ پرداخت : </span>
									<span class="yn"><?php echo($view['payment_date'] != '' ? functions::set_date_payment($view['payment_date']) : 'پرداخت نشده'); ?></span>
								</div>
								<div class="col-md-4">
									<span>نوع پرداخت: </span>
									<span><?php
										if ($view['payment_type'] == 'cash') {
											echo 'نقدی';
										} else if ($view['payment_type'] == 'credit' || $view['payment_type'] == 'member_credit') {
											echo 'اعتباری';
										}
										?></span>
								</div>
								<div class="col-md-4">
									<span>کد پیگیری بانک: </span>
									<span class="yn"><?php echo !empty($view['tracking_code_bank']) ? $view['tracking_code_bank'] : 'ندارد' ?></span>
								</div>
								<?php if (TYPE_ADMIN == '1' && $view['payment_type'] == 'cash') { ?>
									<div class="col-md-4">
										<span>نام بانک: </span>
										<span><?php echo $objbook->namebank($view['name_bank_port'], $view['client_id']) ?></span>
									</div>
									<div class="col-md-4">
										<span class="">شماره درگاه: </span>
										<span class="yn"><?php echo $objbook->numberPortBnak($view['name_bank_port'], $view['client_id']) ?></span>
									</div>
									<div class="col-md-4">
										<span>صاحب امتیاز درگاه: </span>
										<span><?php echo $objbook->numberPortBnak($view['name_bank_port'], $view['client_id']) == '379918' ? 'ایران تکنولوژی' : $objbook->nameAgency($view['client_id']) ?></span>
									</div>
								<?php } ?>
							</div>
							<hr style="margin: 5px 0;"/>
						<?php } ?>

						<div class="row margin-both-vertical-20">
							<div class="col-md-12 text-center text-bold " style="color: #fb002a;">
                                    <span>مشخصات ارائه دهنده بلیط <?php

	                                    if (count($ticketsInfo) > 1) {
		                                    if ($typeFlight) {
			                                    echo($view['direction'] == 'dept' ? 'رفت' : 'برگشت');
		                                    } else if($type == 'bus') {
			                                    echo($view['Route_Type'] == '1' ? 'رفت' : 'برگشت');
		                                    }
	                                    }


	                                    ?></span>
							</div>
						</div>

						<div class="row margin-both-vertical-20">
							<div class="col-md-4 ">
								<span>نام آژانس  : </span>
								<span>
								<?php
                    if($type != 'flight'){

                        if(TYPE_ADMIN == '1' ) {
                            $agencyInfo = $Client = functions::infoClient($ticketsInfo[0]['client_id']);
                        }else{
                            $agencyInfo = $Client = functions::infoClient(CLIENT_ID);
                        }

                        echo $agencyInfo['AgencyName'];
                    }else{


                        if ($view['pid_private'] == '1' && $typeFlight && isset($view['client_id'])) {
                            $Client = functions::infoClient($view['client_id']);
                        }


                        echo ($typeFlight && $view['pid_private'] == '1') ? $Client['AgencyName'] : ($view['flight_type'] == 'system' ? 'ایران تکنولوژی' : $view['supplier_name']);
                    }
								 ?>
								</span>
							</div>
							<div class="col-md-4 ">
								<span> نام مدیر آژانس: </span>
								<span>

								<?php

								 if($type != 'flight'){
                                        echo $agencyInfo['Manager'];
                                    }else{
                                        echo ($typeFlight && $view['pid_private'] == '1') ? $Client['Manager'] : ($view['flight_type'] == 'system' ? 'اباذر افشار' : $view['supplier_manager']);
								 }

								  ?>
								</span>
							</div>
							<div class="col-md-4 ">
								<span class=""> شماره تلفن   </span>
								<span class="yn">
								<?php

								 if($type != 'flight'){
                                        echo $agencyInfo['Phone'];
                                    }else{
                                        echo ($typeFlight && $view['pid_private'] == '1') ? $Client['Phone'] : ($view['flight_type'] == 'system' ? '021-88866609' : $view['supplier_phone1'] . ',' . $view['supplier_phone2']);
								 }

								  ?>

								</span>
							</div>
							<div class="col-md-4 ">
								<span>وب سایت :</span>
								<span>
									<?php

								 if($type != 'flight'){
                                        echo $agencyInfo['MainDomain'];
                                    }else{
                                        echo ($typeFlight && $view['pid_private'] == '1') ? $Client['MainDomain'] : ($view['flight_type'] == 'system' ? 'iran-tech.com' : $view['supplier_website']);
								 }

								  ?>
								</span>
							</div>
							<div class="col-md-8 ">
								<span>آدرس:</span>
									<span><?php

								 if($type != 'flight'){
                                        echo $agencyInfo['Address'];
                                    }else{
                                        echo ($typeFlight && $view['pid_private'] == '1') ? $Client['Address'] : ($view['flight_type'] == 'system' ? 'مطهری-بعد از مفتح -شماره180 واحد 1' : $view['supplier_address']);
								 }

								  ?>

							</div>
						</div>
						<hr style="margin: 5px 0;"/>


						<div class="row margin-both-vertical-20">
							<div class="col-md-12 text-center text-bold " style="color: #fb002a;">
                                <span>مشخصات <?php

	                                if ($typeFlight) {
		                                if (count($ticketsInfo) > 1) {
			                                echo($view['direction'] == 'dept' ? 'رفت' : 'برگشت');
		                                } elseif ($view['direction'] == 'TwoWay') {
			                                echo 'دو طرفه';
		                                }
	                                }


	                                ?></span>
							</div>
						</div>


						<?php if ($type == 'bus' && $view['direction'] == 'TwoWay') {
						  ?>
						  	   <div class="row margin-both-vertical-20">

                  <div class="col-md-8">
                    <span class=" pull-left">تاریخ رزرو بلیط : </span>
                    <span class="yn" dir="ltr"><?php echo dateTimeSetting::jdate('Y-m-d (H:i:s)', $view['creation_date_int']) ?></span>
                  </div>

						    </div>
              <?php

                  $detail_routes = $this->getController('BookRoutes')->getDetailFlightOfReportRoute($view['request_number']);

                  foreach ($detail_routes as $key_routes=>$item_routes) {
                        ?>
                          <div class="row margin-both-vertical-20">
                             <div class='col-md-12'>
                                <span class=" pull-left"> اطلاعات <?php  echo  ($key_routes == 'dept') ? 'رفت' : 'برگشت' ; ?> : </span>
                              </div>
                          </div>
                          <?php
                            foreach ($item_routes as $item_route) {
                              ?>
                                <div class="row margin-both-vertical-20">
                              <div class="col-md-4 ">
                                <span>مبدا /مقصد: </span>
                                  <span>
                                      <?php
                                           echo $item_route['OriginCity'].'/'.$item_route['DestinationCity'] ;
                                      ?>
                                  </span>
                              </div>
                              <div class="col-md-4 ">
                                  <span >ساعت و تاریخ حرکت:</span>
                                  <span class="yn"><?php
                                      echo functions::format_hour($item_route['DepartureTime']) . ' ' . functions::DateJalali($item_route['DepartureDate']); ?>
                                  </span>
                              </div>
                                     <div class="col-md-4 ">
                                  <span class=>ساعت و تاریخ رسیدن:</span>
                                  <span class="yn"><?php
                                      echo functions::format_hour($item_route['ArrivalTime']) . ' ' . functions::DateJalali($item_route['ArrivalDate']); ?>
                                  </span>
                              </div>
                            </div>
                                <div class="row margin-both-vertical-20">
                              <div class="col-md-4 ">
                                <span>شناسه نرخی: </span>
                                  <span>
                                      <?php
                                           echo $item_route['CabinType'] ;
                                      ?>
                                  </span>
                              </div>
                              <div class="col-md-4 ">
                                  <span class=" pull-left22">شماره پرواز:</span>
                                  <span class="yn"><?php
                                      echo $item_route['FlightNumber']; ?>
                                  </span>
                              </div>

                                <div class="col-md-4 ">
                                  <span class="">نام ایرلاین:</span>
                                  <span><?php
                                      $airline_info = $this->getController('airline')->getByAbb($item_route['Airline_IATA']);
                                      echo  $airline_info['name_fa']?>
                                  </span>
                              </div>
                            </div>
                              <?php
                            }
                  }
						}else{
						  ?>
						  <div class="row margin-both-vertical-20">

							<div class="col-md-4">
								<span class=" ">تاریخ رزرو بلیط : </span>
								<span class="yn"
								      dir="ltr"><?php echo dateTimeSetting::jdate('Y-m-d (H:i:s)', $view['creation_date_int']) ?></span>
							</div>
							<?php


								 if($type != 'bus' && $type != 'hotel' && $type != 'insurance'){ ?>

								 <div class="col-md-4 ">
										<span class="">شماره پرواز:</span>
										<span class="yn"><?php echo $view['flight_number'] ?> </span>
									</div>
                   <?php } ?>
              <?php  if($type == 'insurance'){ ?>

                <div class="col-md-4 ">
                  <span class="">شماره بیمه:</span>
                  <span class="yn"><?php echo $view['pnr'] ?> </span>
                </div>
              <?php } ?>
                  <?php  if($type == 'hotel' ){ ?>

                    <div class="col-md-4 ">
                      <span class="">کد پیگیری:</span>
                      <span class="yn"><?php echo $view['pnr'] ?> </span>
                    </div>
                  <?php } ?>
              <?php  if($type != 'bus'){ ?>
                <div class="col-md-4">

								<span>شماره واچر :</span>
								<span class="yn"><?php echo $requestNumber ?></span>
							</div>
							<?php } ?>
						</div>
						<div class="row margin-both-vertical-20">
							<div class="col-md-4 ">
								<span>مبدا /مقصد: </span>
								<span><?php


								 if($type == 'bus'){
                  echo $view['OriginName']. '/' . $view['DestinationName'];
              }
                 else if($type == 'insurance'){
                        echo $view['destination'];
                 }else if($type == 'hotel'){
                     echo $view['city_name'] . '/ هتل ' . $view['hotel_name'];
                 }else{
								     if ($typeFlight) {
										echo $view['origin_city'] . '/' . $view['desti_city'];
									} else {
										echo $view['Departure_City'] . '/' . $view['Arrival_City'];
									}


								 }



									?>
									</span>
							</div>
							<div class="col-md-4 ">
								<span>تعداد :</span>
								<span><?php echo $view['CountTicket']; ?></span>
							</div>
              <?php if($type != 'hotel' && $type != 'insurance'){ ?>
							<div class="col-md-4 ">
								<span class="">ساعت و تاریخ حرکت:</span>
								<span class="yn"><?php


								if($type == 'bus'){
                                        echo $view['TimeMove']. '<span class="border-left border mx-2"></span>' . $view['DateMove'];
                                    }else{


                                    if ($typeFlight) {
										echo functions::format_hour($view['time_flight']) . ' ' . functions::DateJalali($view['date_flight']);
									} else {
										echo functions::format_hour($view['ExitTime']) . ' ' . functions::DateJalali($view['ExitDate']);
									}


								 }





									?> </span>

							</div>
              <?php  } ?>
						</div>
						<div class="row margin-both-vertical-20">
							<div class="col-md-4 ">
								<?php
								if ($typeFlight) {
									?>
									<span>نام ایرلاین/شناسه نرخی :</span>
									<span><?php echo $view['airline_name'] ?>/<?php echo $view['cabin_type']; ?></span>

									<?php
								} else {
								    if($type == 'bus'){?>
									<span>نام شرکت مسافربری :</span>
									<span>
                                        <?php echo $view['CompanyName'] ?>
									</span>

									<?php
								    }
								        ?>


                                        <?php
								}
								?>
							</div>
							<?php
							if ($typeFlight) { ?>
								<div class="col-md-4 ">
									<span class="">کلاس پرواز: </span>
									<span><?php echo ($view['seat_class'] == 'C' || $view['seat_class'] == 'B') ? 'بیزینس' : 'اکونومی' ?></span>
								</div>


								<div class="col-md-4 ">
									<span>نوع پروازی: </span>
									<span> <?php
										if ($view['flight_type'] == 'system') {
											if ($view['pid_private'] == '1') {
												echo 'سیستمی اختصاصی';
											} else {

												echo 'سیستمی اشتراکی';
											}
										} else if ($view['flight_type'] == 'charter') {
											echo 'چارتری';
										} else if ($view['flight_type'] == 'charterPrivate') {
											echo 'چارتری اختصاصی';
										}
										?> </span>
								</div>
								<?php
							}
							?>
						</div>
            <?php
						}?>

						<div class="row margin-both-vertical-20">
							<?php
							if ($typeFlight) {
								if ($view['type_app'] != 'Reservation') { ?>


									<div class="col-md-4 ">
										<span class="">شماره pnr :</span>
										<span class="yn"><?php echo $view['pnr'] ?></span>
									</div>

								<?php }
							} else {


								    if($type == 'bus'){
?>
									<span class="">شماره پی ان آر :</span>
									<span>
                                        <?php echo $view['pnr'] ?>
									</span>

									<?php
								    }
								        ?>



								<?php
							} ?>

							<div class="col-md-4 ">
								<span>مبلغ :</span>
								<span class="yn">
                                <?php

                                if ($typeFlight) {
	                                $Tickets = functions::info_flight_client($requestNumber);

	                                $totalPriceWithDiscount = 0;
	                                if ($view['type_app'] != 'Reservation') {
		                               list($totalPrice,$fare) = $objbook->total_price($view['request_number']);
		                                if ($view['flight_type'] != 'system') {
		                                    $countTicket = $view['CountTicket'];
			                                $totalPrice +=($countTicket * $view['irantech_commission']);
		                                }
                                    $totalPriceWithDiscount = functions::CalculateDiscount($view['request_number']);
	                                } else {
                                    if($type == 'bus') {

                                        $totalPrice = $view['total_price'];
                                    }else if ($type == 'insurance'){
                                        $totalPrice = $view['base_price'];
                                    }else if ($type == 'hotel'){
                                        $totalPrice = $view['total_price'];
                                    }

		                                $totalPriceWithDiscount = 0;
	                                }

	                                if ($totalPriceWithDiscount > 0) {
		                                echo '<span style="text-decoration: line-through;">' . number_format($totalPrice) . '</span>, ';
		                                echo ' <span>' . number_format($totalPriceWithDiscount) . '</span>';
	                                } else {
		                                echo '<span>' . number_format($totalPrice) . '</span>';
	                                }
                                } else {



                                if($type == 'bus'){
                                    $Tickets = $ticketsInfo;
                                    echo number_format($view['total_price']);

                                }else if($type == 'insurance'){
                                    echo number_format($view['base_price']);
                                }else if($type == 'hotel'){
                                    echo number_format($view['total_price']);
                                }
                                else if($type == 'train'){
                                    $Tickets = functions::info_train_directions($requestNumber);
                                    $train = Load::controller('bookingTrain');
                                    echo number_format($train->TotalPriceByFactorNumber($view['factor_number']));
                                }



                                }
                                ?></span> <span>ریال</span>
							</div>

						</div>

						<div class="row">
							<?php if ($typeFlight && !empty($view['amount_added']) && $view['amount_added'] > 0) { ?>
								<div class="col-md-4">
									<span>مبلغ افزایش یافته توسط کانتر در بلیط :</span>
									<span><?php echo number_format($view['amount_added']); ?> ریال</span>
								</div>
							<?php } ?>
						</div>


						<?php
						if(!empty($view['special_discount_type']) && $view['special_discount_amount'] > 0){?>
						    <div class="row">
								<div class="col-md-12 ">
									<span>کد تخفیف ویژه:</span>
									<span class="yn"><?php echo $view['special_discount_amount'] .($view['special_discount_type']=='cash' ? 'ریال' : 'درصد'); ?></span>
								</div>

							</div>
						<?php }
						if($type != 'bus'){
						$discountCodeInfo = $objDiscountCode->getDiscountCodeByFactor($view['factor_number']);
						if (!empty($discountCodeInfo) ) {
							?>
							<div class="row">
								<div class="col-md-4 ">
									<span>کد تخفیف:</span>
									<span class="yn"><?php echo $discountCodeInfo['discountCode']; ?></span>
								</div>
								<div class="col-md-4 ">
									<span>قیمت پس از اعمال کد تخفیف</span>
									<span class="yn"><?php echo number_format(($totalPriceWithDiscount > 0 ? $totalPriceWithDiscount : $totalPrice) - $discountCodeInfo['amount']); ?></span>
									<span>ریال</span>
								</div>
							</div>
						<?php }
						} ?>

						<hr style="margin: 5px 0;"/>


					<?php }
          if($type != 'train'){ ?>

					<div class="row margin-top-10 margin-both-vertical-20">
						<div class="col-md-12 text-center text-bold " style="color: #fb002a;">
							<span>مشخصات مسافرین</span></div>
					</div>

					<?php

              if($type == 'hotel' ){
                  $Tickets = $ticketsInfo;
              }


					foreach ($Tickets as $view) {

						?>
						<div class="row modal-padding-bottom-15 margin-both-vertical-20" >
							<div class="col-md-4 ">
								<span>نام فارسی:</span>
								<span><?php echo $view['passenger_name'] . ' ' . $view['passenger_family'] . ' (' . $view['passportCountry'] . ') '; ?> </span>
							</div>
							<div class="col-md-4 ">
								<span class=" ">تولد شمسی:</span>
								<span class="yn"><?php echo !empty($view['passenger_birthday']) ? $view['passenger_birthday'] : '----' ?></span>
							</div>
							<div class="col-md-4 ">
								<span>شماره پاسپورت:</span>
								<span class="yn"><?php echo !empty($view['passportNumber']) ? $view['passportNumber'] : '----' ?></span>
							</div>
							<div class="col-md-4 ">
								<span class=" ">شماره بلیط:</span>
								<span class="yn"><?php echo !empty($view['eticket_number']) ? $view['eticket_number'] : '----' ?></span>
							</div>
							<div class="col-md-4 ">
								<span>نام انگلیسی:</span>
								<span><?php echo $view['passenger_name_en'] . ' ' . $view['passenger_family_en'] . ' (' . $view['passportCountry'] . ') '; ?> </span>
							</div>
							<div class="col-md-4 ">
								<span class=" ">تولد میلادی:</span>
								<span class="yn"><?php echo !empty($view['passenger_birthday_en']) ? $view['passenger_birthday_en'] : '----' ?></span>
							</div>
							<div class="col-md-4 ">
								<span class="">انقضای پاسپورت:</span>
								<span class="yn"><?php echo !empty($view['passportExpire']) ? $view['passportExpire'] : '----' ?></span>
							</div>
							<?php if ($typeFlight) {
								?>
								<div class="col-md-4 ">

									<span>هزینه بلیط:</span>
									<?php

									if ($view['percent_discount'] > 0) {
										echo '<span class="yn"><span>' . number_format(functions::CalculatePriceTicketOnePerson($view['request_number'], $view['passenger_national_code'] == '0000000000' ? $view['passportNumber'] : $view['passenger_national_code'], 'yes')) . ' </span> </span> <span>ریال</span>';
//                                  . number_format(functions::CalculateDiscountOnePerson($view['request_number'], $view['passenger_national_code'] == '0000000000' ? $view['passportNumber'] : $view['passenger_national_code'], 'yes'))
									} else {
										echo '<span class="yn">' . number_format(functions::CalculatePriceTicketOnePerson($view['request_number'], $view['passenger_national_code'] == '0000000000' ? $view['passportNumber'] : $view['passenger_national_code'], 'yes')) . '</span> <span>ریال</span>';
									}


									if ($view['request_cancel'] == 'confirm') {
										echo '(<span style="color : red ;">کنسل شده</span>)';
									}
									?>
								</div>
								<?php
							} ?>
							<div class="col-md-4 ">
								<span>شماره ملی:</span>
								<span class="yn"><?php echo $view['passenger_national_code'] != '0000000000' ? $view['passenger_national_code'] : '----' ?><?php echo (!empty($array_national) && (in_array($view['passenger_national_code'],$array_national) || in_array($view['passportNumber'],$array_national))) ? '(<span style="color:red">کنسل شده</span>)' : '' ?> </span>
							</div>
<!--							<div class="col-md-4 ">-->
<!--								--><?php //if (TYPE_ADMIN == '1') {
//									if ($view['flight_type'] == 'system') {
//										?>
<!--										<span>fare:</span>-->
<!--										--><?php //if ($view['adt_price'] > 0) { ?>
<!--											<span class="yn">--><?php //echo number_format($view['adt_fare']) ?><!--</span>-->
<!--										--><?php //} elseif ($view['chd_price'] > 0) { ?>
<!--											<span class="yn">--><?php //echo number_format($view['chd_fare'])  ?><!--</span>-->
<!--										--><?php //} elseif ($view['inf_price'] > 0) { ?>
<!--											<span class="yn">--><?php //echo number_format($view['inf_fare']) ?><!--</span>-->
<!--										--><?php //}
//									}
//								} else {
//									if ($view['flight_type'] == 'system' ) {
//										?>
<!---->
<!--										<span>fare:</span>-->
<!--										--><?php //if ($view['adt_price'] > 0) {
//											if ($view['adt_fare'] > 0) {
//												?>
<!--												<span class="yn">--><?php //echo number_format($view['adt_fare']) ?><!--</span>-->
<!--												--><?php
//											} else {
//												?>
<!--												<span class="yn">--><?php //echo number_format(functions::calculateFareForOnePersonCustomer($view['adt_price'])) ?><!--</span>-->
<!--												--><?php
//											}
//										} elseif ($view['chd_price'] > 0) {
//											if ($view['chd_fare'] > 0) {
//												?>
<!--												<span class="yn">--><?php //echo number_format($view['chd_fare']) ?><!--</span>-->
<!--												--><?php
//											} else {
//												?>
<!--												<span class="yn">--><?php //echo number_format(functions::calculateFareForOnePersonCustomer($view['chd_price'])) ?><!--</span>-->
<!--												--><?php
//											}
//										} elseif ($view['inf_price'] > 0) {
//											if ($view['inf_fare'] > 0) {
//												?>
<!--												<span class="yn">--><?php //echo number_format($view['inf_fare']) ?><!--</span>-->
<!--												--><?php
//											} else {
//												?>
<!--												<span class="yn">--><?php //echo number_format(functions::calculateFareForOnePersonCustomer($view['inf_price'])) ?><!--</span>-->
<!--												--><?php
//											}
//										}
//									}
//                           else { ?>
<!--										<span>fare:</span>-->
<!--                                        <span class="yn">--><?php //echo number_format($totalPrice) ?><!--</span>-->
<!---->
<!--                                    --><?php //	}
//								} ?>
<!--							</div>-->
						</div>

					<?php } ?>

					<div class="modal-footer site-bg-main-color"></div>
					<?php } ?>
				</div>
			</div>

		</div>

		<?php
	}



      public function ModalShowBookForExclusiveTour($Param, $type) {
          $objbook = Load::controller($this->Controller);
          $ticketsInfo = functions::info_exclusive_tour_directions($Param);
          ?>

         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">جزئیات خرید تور</h4>
               </div>

               <div class="modal-body">

                   <?php if (empty($ticketsInfo)) { ?>
                      <div class="text-center" style="padding:20px; color:#999;">
                         اطلاعاتی برای نمایش موجود نیست.
                      </div>
                   <?php } else { ?>

                       <?php
                       // اطلاعات اصلی تور/پرواز/هتل از اولین آیتم
                       $first = $ticketsInfo[0];
                       ?>

                      <!-- مشخصات کاربر -->
                      <div class="row mb-3 section-row">
                         <div class="col-md-12 text-center text-bold text-danger section-title">مشخصات کاربر</div>
                         <div class="col-md-4"><strong>نام و نام خانوادگی:</strong> <?= isset($first['member_name']) ? $first['member_name'] : '-' ?></div>
                         <div class="col-md-4"><strong>شماره موبایل:</strong> <?= isset($first['member_mobile']) ? $first['member_mobile'] : '-' ?></div>
                         <div class="col-md-4"><strong>ایمیل:</strong> <?= isset($first['member_email']) ? $first['member_email'] : '-' ?></div>
                      </div>

                      <!-- مشخصات پرداخت -->
                      <div class="row mb-3 section-row">
                         <div class="col-md-12 text-center text-bold text-danger section-title">مشخصات پرداخت</div>
                         <div class="col-md-4"><strong>تاریخ پرداخت:</strong> <?= !empty($first['payment_date']) ? functions::set_date_payment($first['payment_date']) : 'پرداخت نشده' ?></div>
                         <div class="col-md-4"><strong>نوع پرداخت:</strong>
                             <?php
                             if($first['payment_type']=='cash') echo 'نقدی';
                             else if($first['payment_type']=='credit' || $first['payment_type']=='member_credit') echo 'اعتباری';
                             else echo '-';
                             ?>
                         </div>
                         <div class="col-md-4"><strong>کد پیگیری بانک:</strong> <?= !empty($first['tracking_code_bank']) ? $first['tracking_code_bank'] : '-' ?></div>
                      </div>

                      <!-- مشخصات رفت و برگشت -->
                      <div class="row mb-3 section-row">
                         <div class="col-md-12 text-center text-bold text-danger section-title">مشخصات پرواز</div>
                         <div class="col-md-4"><strong>مبدا / مقصد:</strong> <?= $first['desti_city'] ?> / <?= $first['origin_city'] ?></div>
                         <div class="col-md-4"><strong>تاریخ و ساعت رفت:</strong> <?= implode('-', array_reverse(explode('-', $first['date_flight']))) . ' ' . $first['time_flight'] ?></div>
                         <div class="col-md-4"><strong>نام ایرلاین:</strong> <?= $first['airline_name'].' ('.$first['airline_iata'].')' ?></div>
                         <div class="col-md-4"><strong>تاریخ و ساعت برگشت:</strong> <?= implode('-', array_reverse(explode('-', $first['ret_date_flight']))) . ' ' . $first['ret_time_flight'] ?></div>
                         <div class="col-md-4"><strong>نام ایرلاین برگشت:</strong> <?= $first['ret_airline_name'].' ('.$first['ret_airline_iata'].')' ?></div>
                         <div class="col-md-4"><strong>کلاس پرواز:</strong> <?= $first['seat_class'] ?></div>
                         <div class="col-md-4"><strong>شماره پرواز رفت:</strong> <?= $first['flight_number'] ?></div>
                         <div class="col-md-4"><strong>شماره پرواز برگشت:</strong> <?= $first['ret_flight_number'] ?></div>
                      </div>

                      <!-- مشخصات هتل و اتاق -->
                      <div class="row mb-3 section-row">
                         <div class="col-md-12 text-center text-bold text-danger section-title">مشخصات هتل</div>
                         <div class="col-md-4"><strong>نام هتل:</strong> <?= $first['hotel_name'] ?></div>
                         <div class="col-md-4">
                            <strong>اطلاعات اتاق:</strong>
                             <?php
                             $rooms = json_decode($first['room_info'], true);
                             if(!empty($rooms)) {
                                 echo '<ul style="list-style:none; padding-left:0; margin-top:10px;">';
                                 foreach($rooms as $room){
                                     echo '<li style="margin-bottom:8px; padding:8px; border:1px solid #cbd5e1; border-radius:6px; background:#f1f5f9;">';
                                     echo '<strong>'.$room['name'].' ('.$room['Type'].')</strong> | ';
                                     echo '<span class="fa fa-user"></span> '.$room['Children'].' | ';
                                     echo '<span class="fa fa-child"></span> '.$room['Adults'];
                                     echo '</li>';
                                 }
                                 echo '</ul>';
                             } else { echo '-'; }
                             ?>
                         </div>
                         <div class="col-md-4"><strong>تاریخ ورود:</strong> <?= implode('-', array_reverse(explode('-', $first['check_in']))) ?></div>
                         <div class="col-md-4"><strong>تاریخ خروج:</strong> <?= implode('-', array_reverse(explode('-', $first['check_out']))) ?></div>
                      </div>
                      <div class="row mb-3 section-row">
                         <div class="col-md-12 text-center text-bold text-danger section-title">
                            تفریحات انتخاب‌شده
                         </div>

                         <div class="col-md-12">
                             <?php
                             if (!empty($first['entertainment_data_json'])) {

                                 $entData = json_decode($first['entertainment_data_json'], true);

                                 if (is_array($entData) && count($entData)) {

                                     echo '<div class="ent-grid">';

                                     foreach ($entData as $ent) {

                                         $title = isset($ent['tourTitle']) && $ent['tourTitle'] != ''
                                             ? $ent['tourTitle']
                                             : 'تفریح';

                                         $price = isset($ent['final_price']) && $ent['final_price'] != ''
                                             ? number_format($ent['final_price'])
                                             : '0';

                                         echo '<div class="ent-item">';
                                         echo '<div class="ent-title">'.$title.'</div>';
                                         echo '<div class="ent-price">'.$price.' تومان</div>';
                                         echo '</div>';
                                     }

                                     echo '</div>';

                                 } else {
                                     echo '<span style="color:#888">بدون تفریح</span>';
                                 }

                             } else {
                                 echo '<span style="color:#888">بدون تفریح</span>';
                             }
                             ?>
                         </div>
                      </div>

                      <!-- مشخصات مسافران -->
                      <div class="row mb-3 section-row">
                         <div class="col-md-12 text-center text-bold text-danger section-title">مشخصات مسافران</div>

                           <?php foreach($ticketsInfo as $passenger) { ?>
                              <div class="col-md-4" style="margin-bottom:10px;">
                                 <div style="border:1px solid #cbd5e1; border-radius:8px; padding:12px; background:#eef2ff;">
                                    <strong>نام و نام خانوادگی:</strong> <?= trim((isset($passenger['passenger_name']) ? $passenger['passenger_name'] : '').' '.(isset($passenger['passenger_family']) ? $passenger['passenger_family'] : '')) != '' ? trim((isset($passenger['passenger_name']) ? $passenger['passenger_name'] : '').' '.(isset($passenger['passenger_family']) ? $passenger['passenger_family'] : '')) : '-' ?><br>

                                    <strong>تولد:</strong> <?= isset($passenger['passenger_birthday']) && $passenger['passenger_birthday'] != '' ? implode('-', array_reverse(explode('-', $passenger['passenger_birthday']))) : '-' ?><br>

                                    <strong>کد ملی:</strong> <?= isset($passenger['passenger_national_code']) && $passenger['passenger_national_code'] != '' ? $passenger['passenger_national_code'] : '-' ?><br>

                                    <strong>شماره پاسپورت:</strong> <?= isset($passenger['passportNumber']) && $passenger['passportNumber'] != '' ? $passenger['passportNumber'] : '-' ?><br>

                                    <strong>رده سنی:</strong> <?= isset($passenger['passenger_age']) && $passenger['passenger_age'] != '' ? $passenger['passenger_age'] : '-' ?>
                                 </div>
                              </div>
                           <?php } ?>
                      </div>
                   <?php } ?>

               </div>

               <div class="modal-footer site-bg-main-color"></div>
            </div>
         </div>

         <style>
             .modal-content {
                 border-radius: 10px;
                 overflow: hidden;
                 background: #ffffff;
                 border: 1px solid #f87171; /* قرمز ملایم */
                 box-shadow: 0 8px 20px rgba(248, 113, 113, 0.3);
             }

             .modal-header {
                 background: #f03c52; /* قرمز رسمی */
                 color: #ffffff !important;
                 padding: 15px 20px;
                 border-bottom: 1px solid #b91c1c;
             }

             .modal-header .close {
                 color: #ffffff;
                 opacity: 1;
                 font-size: 1.4rem;
             }

             .modal-title {
                 font-weight: bold;
                 font-size: 1.15rem;
                 letter-spacing: 0.5px;
                 color: #ffff;
             }

             .modal-body {
                 background: #fff5f5; /* پس‌زمینه قرمز روشن */
                 padding: 20px;
                 max-height: 75vh;
                 overflow-y: auto;
             }

             .row.section-row {
                 padding: 12px 15px;
                 border-radius: 6px;
                 background: #ffffff;
                 border: 1px solid #f87171; /* خطوط قرمز */
                 margin-bottom: 12px;
                 transition: background 0.2s ease, transform 0.2s ease;
             }

             .row.section-row:hover {
                 background: #fee2e2; /* هایلایت روشن قرمز */
                 transform: translateY(-2px);
             }

             .section-title {
                 font-size: 1.05rem;
                 margin-bottom: 10px;
                 font-weight: 600;
                 background: linear-gradient(to right, #f87171, #b91c1c);
             }

             hr {
                 border: none;
                 margin: 12px 0;
             }

             .modal-footer {
                 background: #f87171; /* پایینه رسمی قرمز */
                 height: 12px;
                 border-top: 1px solid #dc2626;
             }

             /* کارت مسافران */
             .passenger-card {
                 border: 1px solid #f87171;
                 border-radius: 8px;
                 padding: 12px;
                 margin-bottom: 10px;
                 background: #fff5f5;
                 transition: background 0.2s ease, transform 0.2s ease;
             }

             .passenger-card:hover {
                 background: #fee2e2;
                 transform: translateY(-2px);
             }

             /* Scrollbar */
             .modal-body::-webkit-scrollbar {
                 width: 8px;
             }

             .modal-body::-webkit-scrollbar-thumb {
                 background: #f03c52;
                 border-radius: 10px;
             }

             .modal-body::-webkit-scrollbar-track {
                 background: #ffe4e4;
             }

             /* آیکون‌ها */
             .fa-user, .fa-child {
                 margin-right: 4px;
             }
             .ent-grid {
                 display: grid;
                 grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
                 gap: 12px;
             }

             .ent-item {
                 border: 1px solid #cbd5e1;
                 border-radius: 8px;
                 padding: 10px;
                 background: #eef2ff;
                 text-align: center;
             }

             .ent-title {
                 font-weight: 600;
                 margin-bottom: 6px;
             }

             .ent-price {
                 font-size: 0.95rem;
                 color: #14532d;
                 font-weight: 500;
             }

         </style>


          <?php
      }







      #endregion
	#region ModalTrackingCancelTicketAdmin

	public function ModalTrackingCancelTicketAdmin($Param, $id) {


		$user = Load::controller($this->Controller);
		$transportType=$_POST['transportType'];

    $InfoCancelTicket = $user->ShowInfoModalTicketCancel($Param, $id);

		if (empty($InfoCancelTicket)) {
			$InfoCancelTicket = array();
		}

		// echo Load::plog($InfoCancelTicket);

		foreach ($InfoCancelTicket as $i => $ticket) {

			$NationalCodes[] = @$ticket['NationalCode'];
		}
		?>
		<div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"> مشاهده درخواست کنسلی <?php
					echo $transportType == 'flight'?'پرواز':null;
					echo $transportType == 'bus'?'اتوبوس':null;
					echo $transportType == 'hotel'?'هتل':null;
					echo $transportType == 'insurance'?'بیمه':null;
					?> به شماره : <span
								class="yn font15"><?php echo $Param ?></span></h4>
				</div>
				<div class="modal-body">
            <?php
               if (!in_array ( $transportType, array ( 'hotel', 'tour') ) ) {
            ?>
					<div class="row">
						<div class="col-md-2 pull-left ">
							لیست مسافران
							<hr>
						</div>

					</div>
					<?php } ?>

					<?php
					foreach ($InfoCancelTicket as $i => $info) {


					    if($transportType == 'bus'){
					        $info['passenger_age']='Adt';
					    }

						$NationalCodeUser = (!empty($info['passenger_national_code']) && $info['passenger_national_code'] != '0000000000') ? $info['passenger_national_code'] : $info['passportNumber'];
						if ($i < 1) {
							?>
							<input type="hidden" value="<?php echo $info['factor_number'] ?>" name="FactorNumber"
							       id="FactorNumber"/>
							<input type="hidden" value="<?php echo $info['member_id'] ?>" name="MemberId"
							       id="MemberId"/>
							<?php
						}
						?>
						<div class="row margin-10">
							<div class="col-md-2 col-lg-2 col-sm-12 col-xs-12 margin-both-vertical-20">
								<span><?php

								 echo (!empty($info['passenger_name'])) ?  $info['passenger_name'] . ' ' . $info['passenger_family'] : $info['passenger_name_en'] . ' ' . $info['passenger_family_en'] ; ?></span>
							</div>
							<div class="col-md-3  col-lg-3 col-sm-12 col-xs-12 margin-both-vertical-20">
						<?php
               if (!in_array ( $transportType, array ( 'hotel', 'tour') ) ) {
            ?>
                <span>شماره ملی/پاسپورت:</span>
                <?php } ?>
                <span
										class="yn"><?php echo ($info['passenger_national_code'] != '0000000000') ? $info['passenger_national_code'] : $info['passportNumber'] ?></span>
							</div>
							<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12 margin-both-vertical-20">
							  <?php
               if (!in_array ( $transportType, array ( 'hotel', 'tour') ) ) {
               ?>
								<span class="FloatRight">تاریخ تولد: </span>
								<?php } ?>
                <?php if($transportType != 'insurance'){ ?>
                <span class="yn"><?php echo (!empty($info['passenger_birthday'])) ? $info['passenger_birthday'] : $info['passenger_birthday_en'] ?></span>
                <?php }else{?>
                  <span class="yn"><?php echo (!empty($info['passenger_birth_date'])) ? $info['passenger_birth_date'] : $info['passenger_birth_date_en'] ?></span>

                <?php  } ?>
							</div>
							<div class="col-md-1 col-lg-1 col-sm-12 col-xs-12 margin-both-vertical-20"> <span><?php
									switch ($info['passenger_age']) {

									case 'Adt':
										echo 'بزرگسال';
										break;

									case 'Chd':
										echo 'کودک';
										break;

									case 'Inf':
										echo 'نوزاد';
										break;
									}
									?></span></div>
							<div class="col-md-2 col-lg-2 col-sm-12 col-xs-12">
								<div class="<?php
								switch ($info['Status']) {
								case 'RequestMember' :
									echo in_array($NationalCodeUser, $NationalCodes) ? 'btn btn-primary' : '';
									break;
								case 'SetCancelClient' :
									echo in_array($NationalCodeUser, $NationalCodes) ? 'btn btn-danger' : '';
									break;
								case 'RequestClient' :
									echo in_array($NationalCodeUser, $NationalCodes) ? 'btn btn-warning' : '';
									break;
								case 'SetIndemnity' :
									echo in_array($NationalCodeUser, $NationalCodes) ? 'btn btn-warning' : '';
									break;
								case 'SetFailedIndemnity' :
									echo in_array($NationalCodeUser, $NationalCodes) ? 'btn btn-danger' : '';
									break;
								case 'ConfirmClient' :
									echo in_array($NationalCodeUser, $NationalCodes) ? 'btn btn-warning' : '';
									break;
								case 'ConfirmCancel' :
									echo in_array($NationalCodeUser, $NationalCodes) ? 'btn btn-success' : '';
									break;
								}
								?>">
									<?php
									switch ($info['Status']) {
									case 'RequestMember' :
										echo in_array($NationalCodeUser, $NationalCodes) ? 'درخواست کاربر' : '';
										break;
									case 'SetCancelClient' :
										echo in_array($NationalCodeUser, $NationalCodes) ? 'رد درخواست ' : '';
										break;
									case 'RequestClient' :
										echo in_array($NationalCodeUser, $NationalCodes) ? 'انتظار تعیین درصد' : '';
										break;
									case 'SetIndemnity' :
										echo in_array($NationalCodeUser, $NationalCodes) ? 'تعیین درصد جریمه' : '';
										break;
									case 'SetFailedIndemnity' :
										echo in_array($NationalCodeUser, $NationalCodes) ? 'رد درصد توسط آژانس' : '';
										break;
									case 'ConfirmClient' :
										echo in_array($NationalCodeUser, $NationalCodes) ? 'در حال رسیدگی و واریز' : '';
										break;
									case 'ConfirmCancel' :
										echo in_array($NationalCodeUser, $NationalCodes) ? 'واریز شد' : '';
										break;
									}
									?>
								</div>
							</div>
						</div>


						<?php
					}

					?>


					<div class="row margin-10">
						<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 margin-10 ">
							شماره درخواست خرید: <span
									class="yn"><?php echo $InfoCancelTicket[0]['RequestNumber']; ?></span>
						</div>
						<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 margin-10">
							<span style="float: right">تاریخ درخواست کنسلی :</span> <?php echo dateTimeSetting::jdate('(H:i:s) Y-m-d', $InfoCancelTicket[0]['DateRequestMemberInt']); ?>
						</div>
						<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 margin-10">
							تاریخ تایید /رد درخواست :<?php
							if ($InfoCancelTicket[0]['DateSetCancelInt'] != '0' || $InfoCancelTicket[0]['DateConfirmCancelInt'] != '0') {
								if ($InfoCancelTicket[0]['Status'] == 'SetCancelClient') {
									echo dateTimeSetting::jdate('(H:i:s) Y-m-d', $InfoCancelTicket[0]['DateSetCancelInt']);
								} else if ($InfoCancelTicket[0]['Status'] == 'ConfirmCancel') {
									echo dateTimeSetting::jdate('(H:i:s) Y-m-d', $InfoCancelTicket[0]['DateConfirmCancelInt']);
								}
							} else {
								echo ' -----';
							}
							?>
						</div>
						<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 margin-10">
							درصد جریمه:<?php
							if ($InfoCancelTicket[0]['Status'] == 'SetIndemnity' || $InfoCancelTicket[0]['Status'] == 'SetFailedIndemnity' || $InfoCancelTicket[0]['Status'] == 'ConfirmClient' || $InfoCancelTicket[0]['Status'] == 'ConfirmCancel') {
								echo $InfoCancelTicket[0]['PercentIndemnity'] . '%';
							} else {
								echo ' -----';
							}
							?>
						</div>
						<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 margin-10">
							مبلغ استرداد:<?php
							echo '----';
							?>
						</div>

						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 margin-10">
							توضیحات آژانس:<?php
							if (!empty($InfoCancelTicket[0]['DescriptionClient'])) {
								?>
								<span><?php echo $InfoCancelTicket[0]['DescriptionClient']; ?></span>
								<?php
							} else {
								?>
								<span>-------</span>
								<?php
							}
							?>
						</div>
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 margin-10">
							توضیحات کارگزار:<?php
							if (!empty($InfoCancelTicket[0]['DescriptionAdmin'])) {
								?>
								<span><?php echo $InfoCancelTicket[0]['DescriptionAdmin']; ?></span>
								<?php
							} else {
								?>
								<span>-------</span>
								<?php
							}
							?>
						</div>
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 margin-10">
							اهمیت درصد برای کاربر:<?php
							if ($InfoCancelTicket[0]['PercentNoMatter'] == 'Yes') {
								?>
								<span><?php echo 'اهمیت ندارد' ?></span>

								<?php
							} else {
								?>
								<span><?php echo 'با اهمیت است' ?></span>

								<?php
							}
							?>
						</div>
						<div class="row margin-10">
							<div class="col-md-3 col-lg-4 col-sm-12 col-xs-12">شماره کارت اعلام
								شده:<span><?php echo $InfoCancelTicket[0]['CardNumber'] ?></span></div>
							<div class="col-md-3 col-lg-4 col-sm-12 col-xs-12">نام صاحب
								حساب:<span><?php echo $InfoCancelTicket[0]['AccountOwner'] ?></span></div>
							<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">نام بانک مرتبط با
								کارت:<span><?php echo $InfoCancelTicket[0]['NameBank'] ?></span></div>
              <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                توضیح کاربر برای کنسلی:

                <span><?php echo $InfoCancelTicket[0]['comment_user'] ?></span></div>
						</div>



					</div>

					<div class="modal-footer site-bg-main-color">


					</div>
				</div>
			</div>

		</div>

		<?php
	}

	#endregion
	#region ShowModalConfirmCancel

	public function ShowModalConfirmCancel($Param, $id) {


		$CancellationFeeSettingController = Load::controller('cancellationFeeSetting');
		$listCancelController = Load::controller('listCancel');
		$InfoCancel = $listCancelController->infoCancel($id);

		$infoMember = functions::infoMember($InfoCancel['MemberId']);
		$InfoFlight = functions::InfoFlight($Param);


		$flighTypeCancel = ($InfoCancel['TypeCancel'] == 'flight' || $InfoCancel['TypeCancel'] == '') ? true : false;
		if ($flighTypeCancel) {
			$CalculateIndemnity = $CancellationFeeSettingController->CalculateIndemnity($Param);
		}

		?>
		<div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">تایید در خواست کنسلی</h4>
				</div>
				<div class="modal-body">
				<input type="hidden" name="typeCancel" id="typeCancel" value="<?php echo $InfoCancel['TypeCancel']?>" >
					<?php
					if ($flighTypeCancel) {
						?>
						<div class="row">


							<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
								<div class="form-group">
									<label for="DescriptionClient">میزان درصد جریمه
									</label>

									<input type="text" class="form-control"
									       value="<?php echo $CalculateIndemnity . ' ' . (is_numeric($CalculateIndemnity) ? 'درصد از Fare' : 'قوانین كنسلی پروازهای چارتری بر اساس تفاهم چارتر كننده و سازمان هواپیمایی كشوری می باشد') ?>"
									       readonly="readonly">
									<input type="hidden" name="indemnity" id="indemnity"
									       value="<?php echo $CalculateIndemnity; ?>">


								</div>
							</div>

						</div>
						<?php
					}
					?>

					<div class="row">

						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label for="DescriptionClient">توضیحات
									<small>(شما میتوانید توضیحات مربوط به در خواست خود را در اینجا وارد نمائید)</small>
								</label>
								<textarea class="form-control" id="DescriptionClient"
								          placeholder="متن توضیحات خود را وارد نمائید"></textarea>
							</div>
						</div>

						<?php if ($infoMember['fk_counter_type_id'] != '5' && $InfoFlight['payment_type']=='credit'){?>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="checkbox checkbox-info">
                                        <input id="isCreditPayment" name="isCreditPayment" type="checkbox">
                                        <label for="isCreditPayment"> واریز وجه استرداد 	<small>(درصورتی که تمایل دارید بعد از استرداد وجه ،مستقیما به اعتبار همکار خریدار بلیط واریز شود این  گزینه  را تیک بزنید)</small></label>
                                    </div>
                                </div>
                            </div>
						<?php }?>

					</div>

				</div>

				<div class="modal-footer site-bg-main-color">

					<button type="button" class="btn btn-primary  pull-left"
					        onclick="ConfirmCancelByAgency('<?php echo $Param; ?>', '<?php echo $id; ?>', '<?php echo (isset($CalculateIndemnity) && is_numeric($CalculateIndemnity)) ? $CalculateIndemnity : '' ?>')">
						قبول دارم
					</button>


				</div>
			</div>
		</div>

		</div>
		<?php
	}

	#endregion
	#region ShowModalFailedCancel

	public function ShowModalFailedCancel($Param, $id) {
		?>
		<div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">رد در خواست کنسلی</h4>
				</div>
				<div class="modal-body">

					<div class="row">

						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label for="DescriptionClient">توضیحات
									<small>(شما میتوانید توضیحات مربوط به دلیل خود را در اینجا وارد نمائید)</small>
								</label>
								<textarea class="form-control" id="DescriptionClient"
								          placeholder="متن توضیحات خود را وارد نمائید"></textarea>
							</div>
						</div>
					</div>

				</div>

				<div class="modal-footer site-bg-main-color">

					<button type="button" class="btn btn-primary  pull-left"
					        onclick="FailedCancelByAgency('<?php echo $Param; ?>', '<?php echo $id; ?>')">ارسال اطلاعات
					</button>

				</div>
			</div>
		</div>

		</div>

		<?php
	}

	#endregion
	#region ModalShowInfoCancelForAdmin

	public function ModalShowInfoCancelForAdmin_old($Param, $ClientId, $id) {
		$listCancel = Load::controller($this->Controller);

    $transportType = $_POST['transportType'];
		$InfoCancelTicket = $listCancel->ShowInfoModalTicketCancel($Param,$id, $ClientId );

		foreach ($InfoCancelTicket as $i => $ticket) {

			$NationalCodes[] = $ticket['NationalCode'];
		}
		?>
		<div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">مشاهده درخواست کنسلی پرواز به شماره :<?php echo $Param ?></h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-2 pull-left ">
							لیست مسافران
							<hr>
						</div>

					</div>

					<?php
					foreach ($InfoCancelTicket as $i => $info) {
						$NationalCodeUser = (!empty($info['passenger_national_code']) && $info['passenger_national_code'] != '0000000000') ? $info['passenger_national_code'] : $info['passportNumber'];
						if ($i < 1) {
							?>
							<input type="hidden" value="<?php echo $info['factor_number'] ?>" name="FactorNumber"
							       id="FactorNumber"/>
							<input type="hidden" value="<?php echo $info['member_id'] ?>" name="MemberId"
							       id="MemberId"/>
							<?php
						}
						?>
						<div class="row margin-10">
							<div class="col-md-2 col-lg-2 col-sm-12 col-xs-12">
								<span><?php echo ($info['passenger_name'] != "" ? $info['passenger_name'] : $info['passenger_name_en']) . ' ' . ($info['passenger_family'] != "" ? $info['passenger_family'] : $info['passenger_family_en']); ?></span>
							</div>
							<div class="col-md-3  col-lg-3 col-sm-12 col-xs-12">
								<span>شماره ملی/پاسپورت:</span><span><?php echo ($info['passenger_national_code'] != '0000000000') ? $info['passenger_national_code'] : $info['passportNumber'] ?></span>
							</div>
							<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12 ">
                <span>تاریخ تولد: </span>
                <?php if($transportType != 'insurance') { ?>
                <span><?php echo (!empty($info['passenger_birthday'])) ? $info['passenger_birthday'] : $info['passenger_birthday_en'] ?></span>
                <?php  }else { ?>
                  <span><?php echo (!empty($info['passenger_birth_date'])) ? $info['passenger_birth_date'] : $info['passenger_birth_date_en'] ?></span>

                <?php } ?>
							</div>
							<div class="col-md-1 col-lg-1 col-sm-12 col-xs-12 "> <span><?php
									switch ($info['passenger_age']) {

									case 'Adt':
										echo 'بزرگسال';
										break;

									case 'Chd':
										echo 'کودک';
										break;

									case 'Inf':
										echo 'نوزاد';
										break;
									}
									?></span></div>
							<div class="col-md-2 col-lg-2 col-sm-12 col-xs-12">
								<div class="<?php
								switch ($info['Status']) {
								case 'RequestMember' :
									echo in_array($NationalCodeUser, $NationalCodes) ? 'btn btn-primary' : '';
									break;
								case 'SetCancelClient' :
									echo in_array($NationalCodeUser, $NationalCodes) ? 'btn btn-danger' : '';
									break;
								case 'RequestClient' :
									echo in_array($NationalCodeUser, $NationalCodes) ? 'btn btn-warning' : '';
									break;
								case 'SetIndemnity' :
									echo in_array($NationalCodeUser, $NationalCodes) ? 'btn btn-warning' : '';
									break;
								case 'SetFailedIndemnity' :
									echo in_array($NationalCodeUser, $NationalCodes) ? 'btn btn-danger' : '';
									break;
								case 'close' :
									echo in_array($NationalCodeUser, $NationalCodes) ? 'btn btn-danger' : '';
									break;
								case 'ConfirmClient' :
									echo in_array($NationalCodeUser, $NationalCodes) ? 'btn btn-info' : '';
									break;
								case 'ConfirmCancel' :
									echo in_array($NationalCodeUser, $NationalCodes) ? 'btn btn-success' : '';
									break;
								}
								?>">
									<?php
									switch ($info['Status']) {
									case 'RequestMember' :
										echo in_array($info['passenger_national_code'], $NationalCodes) ? 'درخواست کاربر' : '';
										break;
									case 'SetCancelClient' :
										echo in_array($NationalCodeUser, $NationalCodes) ? 'رد درخواست ' : '';
										break;
									case 'RequestClient' :
										echo in_array($NationalCodeUser, $NationalCodes) ? 'انتظار تعیین درصد' : '';
										break;
									case 'SetIndemnity' :
										echo in_array($NationalCodeUser, $NationalCodes) ? 'تعیین درصد جریمه' : '';
										break;
									case 'SetFailedIndemnity' :
										echo in_array($NationalCodeUser, $NationalCodes) ? 'رد درصد توسط آژانس' : '';
										break;
									case 'close' :
										echo in_array($NationalCodeUser, $NationalCodes) ? 'بسته شده' : '';
										break;
									case 'ConfirmClient' :
										echo in_array($NationalCodeUser, $NationalCodes) ? 'در حال رسیدگی و واریز' : '';
										break;
									case 'ConfirmCancel' :
										echo in_array($NationalCodeUser, $NationalCodes) ? 'واریز شد' : '';
										break;
									}
									?>
								</div>
							</div>
						</div>


						<?php
					}
					?>

					<div class="row margin-10">
						<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 margin-10">
							<span style="float: right">  شماره درخواست خرید:</span> <?php echo $InfoCancelTicket[0]['RequestNumber']; ?>
						</div>
						<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 margin-10">
							<span style="float: right">تاریخ درخواست کنسلی :</span> <?php echo dateTimeSetting::jdate('(H:i:s) Y-m-d', $InfoCancelTicket[0]['DateRequestMemberInt']); ?>
						</div>
						<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 margin-10">
							<span style="float: right"> تاریخ تایید /رد درخواست :</span> <?php
							if ($InfoCancelTicket[0]['DateSetCancelInt'] != '0' || $InfoCancelTicket[0]['DateConfirmCancelInt'] != '0') {
								if ($InfoCancelTicket[0]['Status'] == 'SetCancelClient') {
									echo dateTimeSetting::jdate('(H:i:s) Y-m-d', $InfoCancelTicket[0]['DateSetCancelInt']);
								} else if ($InfoCancelTicket[0]['Status'] == 'ConfirmCancel') {
									echo dateTimeSetting::jdate('(H:i:s) Y-m-d', $InfoCancelTicket[0]['DateConfirmCancelInt']);
								}
							} else {
								echo '-----';
							}
							?>
						</div>
						<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 margin-10">
							<span style="float: right">  درصد جریمه:</span> <?php
							if ($InfoCancelTicket[0]['Status'] == 'SetIndemnity' || $InfoCancelTicket[0]['Status'] == 'SetFailedIndemnity' || $InfoCancelTicket[0]['Status'] == 'ConfirmClient' || $InfoCancelTicket[0]['Status'] == 'ConfirmCancel') {
								echo $InfoCancelTicket[0]['PercentIndemnity'] . '%';
							} else {
								echo ' -----';
							}
							?>
						</div>
						<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 margin-10">
							<span style="float: right">  مبلغ استرداد:</span> <?php
							if (!empty($InfoCancelTicket[0]['Status']) && $InfoCancelTicket[0]['Status'] !== '0') {
								echo number_format($InfoCancelTicket[0]['PriceIndemnity']) . 'ریال';
							} else {
								echo '----';
							}
							?>
						</div>

						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 margin-10">
							<span style="float: right">  توضیحات آژانس:</span> <?php
							if (!empty($InfoCancelTicket[0]['DescriptionClient'])) {
								?>
								<span><?php echo $InfoCancelTicket[0]['DescriptionClient']; ?></span>
								<?php
							} else {
								?>
								<span>-------</span>
								<?php
							}
							?>
						</div>
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 margin-10">
							<span style="float: right">  توضیحات کارگزار:</span> <?php
							if (!empty($InfoCancelTicket[0]['DescriptionAdmin'])) {
								?>
								<span><?php echo $InfoCancelTicket[0]['DescriptionAdmin']; ?></span>
								<?php
							} else {
								?>
								<span>-------</span>
								<?php
							}
							?>
						</div>

						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 margin-10">
							اهمیت درصد برای کاربر:<?php
							if ($InfoCancelTicket[0]['PercentNoMatter'] == 'Yes') {
								?>
								<span><?php echo 'با اهمیت است' ?></span>
								<?php
							} else {
								?>
								<span><?php echo 'اهمیت ندارد' ?></span>
								<?php
							}
							?>
						</div>
						<div class="row margin-10">
							<div class="col-md-3 col-lg-4 col-sm-12 col-xs-12">شماره کارت اعلام
								شده:<span><?php echo $InfoCancelTicket[0]['CardNumber'] ?></span></div>
							<div class="col-md-3 col-lg-4 col-sm-12 col-xs-12">نام صاحب
								حساب:<span><?php echo $InfoCancelTicket[0]['AccountOwner'] ?></span></div>
							<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">نام بانک مرتبط با
								کارت:<span><?php echo $InfoCancelTicket[0]['NameBank'] ?></span></div>
						</div>

            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 margin-10">
              یادداشت ادمین:<?php
                if (!empty($InfoCancelTicket[0]['note_admin'])) {
                    ?>
                  <span><?php echo $InfoCancelTicket[0]['note_admin']; ?></span>
                    <?php
                } else {
                    ?>
                  <span>-------</span>
                    <?php
                }
                ?>
            </div>

					</div>
				</div>

				<div class="modal-footer site-bg-main-color">


				</div>
			</div>
		</div>

		</div>

		<?php
	}
    public function ModalShowInfoCancelForAdmin($Param, $ClientId, $id)
    {
        $listCancel     = Load::controller($this->Controller);
        $transportType  = isset($_POST['transportType']) ? $_POST['transportType'] : 'flight';

        // اطلاعات اصلی درخواست کنسلی (flight/bus/insurance ...)
        $InfoCancelTicket = $listCancel->ShowInfoModalTicketCancel_new($Param, $id, $ClientId);

        /* ===============================
         *  Percent / Refund Calculation
         * =============================== */
        $busRefund       = null;
        $dataCancelView  = null;

        /* -------- BUS -------- */
        if ($transportType === 'bus') {

            $apiBus = Load::library('apiBus');
            $user   = Load::controller('user');

            $InfoCancelTicketBus = $user->getInfoTicketBusCancel($Param, $ClientId);

            if (!empty($InfoCancelTicketBus) && !empty($InfoCancelTicketBus[0]['passenger_factor_num'])) {

                $busRefundCheck = $apiBus->busRefundCheck(
                    $InfoCancelTicketBus[0]['passenger_factor_num'],
                    $ClientId
                );

                if (
                    !empty($busRefundCheck['response']['SuccessfulStatus']['client']) &&
                    !empty($busRefundCheck['response']['SuccessfulStatus']['provider'])
                ) {
                    $totalRefundableAmount = $busRefundCheck['response']['data']['totalRefundableAmount'];
                    $totalPenaltyAmount    = $busRefundCheck['response']['data']['totalPenaltyAmount'];

                    $busRefund = [
                        'percentage'       => functions::getPercentage($InfoCancelTicketBus[0]['total_price'], $totalRefundableAmount) . '%',
                        'PenaltyAmount'    => $totalPenaltyAmount,
                        'RefundableAmount' => $totalRefundableAmount,
                        'totalPrice'       => $InfoCancelTicketBus[0]['total_price'],
                        'refundable'       => true,
                    ];
                } else {
                    // هم‌ارز نسخه قدیمی (هیچ کلیدی جا نیفتد)
                    $busRefund = [
                        'percentage'       => '0%',
                        'PenaltyAmount'    => 0,
                        'RefundableAmount' => 0,
                        'totalPrice'       => !empty($InfoCancelTicketBus[0]['total_price']) ? $InfoCancelTicketBus[0]['total_price'] : 0,
                        'refundable'       => false,
                    ];
                }

            } else {
                // fallback خیلی امن
                $busRefund = [
                    'percentage'       => '0%',
                    'PenaltyAmount'    => 0,
                    'RefundableAmount' => 0,
                    'totalPrice'       => 0,
                    'refundable'       => false,
                ];
            }
        }

        /* -------- FLIGHT -------- */
        if ($transportType === 'flight') {

            $user      = Load::controller('user');
            $infoFlight = functions::InfoFlight($Param);

            // فقط برای api_id=10 محاسبه پنالتی داریم (مثل قبل)
            if (!empty($infoFlight['api_id']) && $infoFlight['api_id'] == '10') {

                $infoCancelFlight = $user->InfoModalTicketCancel($Param, $transportType, $ClientId);
                $apiFlight        = Load::library('apiLocal');

                $caseTitle = 2; // default مثل قبل
                if (!empty($infoCancelFlight) && isset($infoCancelFlight[0]['ReasonMember'])) {
                    switch ($infoCancelFlight[0]['ReasonMember']) {
                        case 'CancelByAirline': $caseTitle = 1; break;
                        case 'PersonalReason':  $caseTitle = 2; break;
                        case 'DelayTwoHours':   $caseTitle = 3; break;
                    }
                }

                $dataCancel = [
                    'FlightRefundType' => 1,
                    'FlightReasonType' => $caseTitle,
                    // نسخه جدید: array_column (مثل تو) ولی حتماً array باشد
                    'passportNumber'   => !empty($infoCancelFlight) ? array_values(array_filter(array_column($infoCancelFlight, 'passportNumber'))) : []
                ];

                $viewCancel = $apiFlight->getAmountPenaltyAltrabo($Param, $dataCancel);

                // کلیدهای نسخه قدیمی MUST: responseSuccessfull, penaltyAmount, totalPayAmount, totalAmount
                $responseOk = (!empty($viewCancel['response']['successful']));

                $dataCancelView = [
                    'responseSuccessfull' => $responseOk ? true : false,
                    'penaltyAmount'       => '—',
                    'totalPayAmount'      => 0,
                    'totalAmount'         => 0,
                ];

                if ($responseOk && !empty($viewCancel['data'])) {
                    $crcnType = !empty($viewCancel['data']['penaltyPassengers'][0]['crcnType'])
                        ? $viewCancel['data']['penaltyPassengers'][0]['crcnType']
                        : 'Value';

                    $dataCancelView['totalAmount']    = !empty($viewCancel['data']['totalAmount']) ? $viewCancel['data']['totalAmount'] : 0;
                    $dataCancelView['totalPayAmount'] = !empty($viewCancel['data']['totalPayAmount']) ? $viewCancel['data']['totalPayAmount'] : 0;

                    $totalPenaltyAmount = !empty($viewCancel['data']['totalPenaltyAmount']) ? $viewCancel['data']['totalPenaltyAmount'] : 0;
                    $dataCancelView['penaltyAmount']  = ($crcnType === 'Value')
                        ? ($totalPenaltyAmount . ' ریال')
                        : ($totalPenaltyAmount . ' درصد');
                }
            }
        }

        if (empty($InfoCancelTicket)) {
            echo 'داده‌ای یافت نشد';
            return;
        }

        $flight = $InfoCancelTicket[0];


        $apiProviders = [
            '1'  => 'سرور 5',
            '5'  => 'سرور 4',
            '8'  => 'سرور 7',
            '10' => 'سرور 9',
            '11' => 'سرور 10',
            '12' => 'سرور 12',
            '13' => 'سرور 13',
            '14' => 'سرور 14',
            '15' => 'سرور 15',
            '16' => 'سرور 16',
            '17' => 'سرور 17',
            '18' => 'سرور 18',
            '19' => 'سرور 19',
            '20' => 'سپهر',
            '21' => 'چارتر118',
            '43' => 'سیتی نت',
        ];

        $apiId = isset($flight['api_id']) ? $flight['api_id'] : null;
        $DataFlightType = isset($apiProviders[$apiId]) ? $apiProviders[$apiId] : 'نامشخص';

        // مثل نسخه قدیمی: مدال تعیین درصد فقط وقتی RequestClient بود «فعال» باشد
        $canSetPercent = (!empty($flight['Status']) && $flight['Status'] === 'RequestClient');
        ?>
       <div class="modal-dialog modal-lg cancel-modal">
          <div class="modal-content cancel-modal__content">

             <!-- Header -->
             <div class="modal-header cancel-modal__header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <div class="cancel-modal__title-wrap">
                   <h4 class="cancel-modal__title">
                      مشاهده درخواست کنسلی
                      <span class="cancel-modal__req"><?php echo $Param; ?></span>
                   </h4>
                   <span class="cancel-modal__date" style="font-size: 16px;">
                      <?php
                      if (!empty($flight['DateRequestMemberInt'])) {
                          $jdate = dateTimeSetting::jdate('Y/m/d - H:i', $flight['DateRequestMemberInt']);
                          $gdate = date('Y/m/d', $flight['DateRequestMemberInt']);
                          echo $jdate . ' (' . $gdate . ')';
                      } else {
                          echo '—';
                      }
                      ?>
                  </span>
                </div>
             </div>

             <div class="modal-body">

                <!-- BOX 1 : Flight Info -->
                 <?php if ($transportType === 'flight'): ?>
                    <div class="cancel-box">
                       <div class="cancel-box__title">اطلاعات پرواز</div>
                       <div class="cancel-grid">
                          <div><strong>ایرلاین:</strong> <?php echo !empty($flight['airline_name']) ? $flight['airline_name'] : '—'; ?></div>
                          <div><strong>شماره پرواز:</strong> <?php echo !empty($flight['flight_number']) ? $flight['flight_number'] : '—'; ?></div>
                          <div><strong>مبدأ:</strong> <?php echo !empty($flight['origin_city']) ? $flight['origin_city'] : '—'; ?> (<?php echo !empty($flight['origin_airport_iata']) ? $flight['origin_airport_iata'] : '—'; ?>)</div>
                          <div><strong>مقصد:</strong> <?php echo !empty($flight['desti_city']) ? $flight['desti_city'] : '—'; ?> (<?php echo !empty($flight['desti_airport_iata']) ? $flight['desti_airport_iata'] : '—'; ?>)</div>
                          <div><strong>تاریخ رفت:</strong>
                              <?php
                              if (!empty($flight['date_flight'])) {
                                  // تبدیل تاریخ میلادی به timestamp اگر رشته است
                                  $timestamp = strtotime($flight['date_flight']);
                                  if ($timestamp !== false) {
                                      // تاریخ شمسی
                                      $jdate = dateTimeSetting::jdate('Y/m/d', $timestamp);
                                      // تاریخ میلادی اصلی
                                      $gdate = date('Y/m/d', $timestamp);
                                      echo $jdate . ' (' . $gdate . ')';
                                  } else {
                                      echo $flight['date_flight'];
                                  }
                              } else {
                                  echo '—';
                              }
                              ?>
                          </div>
                          <div><strong>تاریخ برگشت:</strong>
                              <?php
                              if (!empty($flight['date_flight_arrival'])) {
                                  // تبدیل تاریخ میلادی به timestamp اگر رشته است
                                  $timestamp = strtotime($flight['date_flight_arrival']);
                                  if ($timestamp !== false) {
                                      // تاریخ شمسی
                                      $jdate = dateTimeSetting::jdate('Y/m/d', $timestamp);
                                      // تاریخ میلادی اصلی
                                      $gdate = date('Y/m/d', $timestamp);
                                      echo $jdate . ' (' . $gdate . ')';
                                  } else {
                                      echo $flight['date_flight_arrival'];
                                  }
                              } else {
                                  echo '—';
                              }
                              ?>
                          </div>
                          <div><strong>پروایدر:</strong> <?php echo $DataFlightType; ?></div>
                          <div dir="rtl"><strong>PNR:</strong> <?php echo $flight['pnr']; ?></div>
                       </div>
                    </div>
                 <?php endif; ?>

                <!-- BOX 2 : Passengers -->
                <div class="cancel-box">
                   <div class="cancel-box__title">لیست مسافران</div>

                   <div class="passenger-table">
                      <div class="passenger-table__head">
                         <span>نام مسافر</span>
                         <span>کد ملی / پاسپورت</span>
                         <span>تاریخ تولد</span>
                         <span>نوع</span>
                         <span>وضعیت</span>
                      </div>

                       <?php foreach ($InfoCancelTicket as $p): ?>
                           <?php
                           $isCanceledPassenger = !empty($p['cancel_national_code']);
                           $status = $isCanceledPassenger ? (!empty($p['Status']) ? $p['Status'] : 'danger') : 'danger';
                           ?>
                          <div class="passenger-table__row <?php echo !$isCanceledPassenger ? 'passenger-table__row--danger' : ''; ?>">
                             <span><?php echo trim((!empty($p['passenger_name_en']) ? $p['passenger_name_en'] : '') . ' ' . (!empty($p['passenger_family_en']) ? $p['passenger_family_en'] : '')); ?></span>

                             <span>
                                    <?php
                                    echo !empty($p['passenger_national_code'])
                                        ? $p['passenger_national_code']
                                        : (!empty($p['passportNumber']) ? $p['passportNumber'] : '—');
                                    ?>
                                </span>

                             <span>
                                    <?php
                                    if ($transportType !== 'insurance') {
                                        if (!empty($p['passenger_birthday'])) echo $p['passenger_birthday'];
                                        else if (!empty($p['passenger_birthday_en'])) echo $p['passenger_birthday_en'];
                                        else echo '—';
                                    } else {
                                        echo !empty($p['passenger_birth_date_en']) ? $p['passenger_birth_date_en'] : '—';
                                    }
                                    ?>
                                </span>

                             <span><?php echo !empty($p['passenger_age']) ? $p['passenger_age'] : '—'; ?></span>

                             <span class="passenger-status passenger-status--<?php echo $status; ?>">
                                    <?php
                                    if (!$isCanceledPassenger) {
                                        echo 'این مسافر کنسل نشده است';
                                    } else {
                                        switch (!empty($p['Status']) ? $p['Status'] : '') {
                                            case 'RequestMember':       echo 'درخواست کاربر'; break;
                                            case 'SetCancelClient':     echo 'رد درخواست'; break;
                                            case 'RequestClient':       echo 'انتظار تعیین درصد'; break;
                                            case 'SetIndemnity':        echo 'تعیین درصد جریمه'; break;
                                            case 'SetFailedIndemnity':  echo 'رد درصد'; break;
                                            case 'ConfirmClient':       echo 'در حال رسیدگی'; break;
                                            case 'ConfirmCancel':       echo 'واریز شد'; break;
                                            case 'close':               echo 'بسته شده'; break;
                                            default:                    echo 'کنسل شده';
                                        }
                                    }
                                    ?>
                                </span>
                          </div>
                       <?php endforeach; ?>
                   </div>
                </div>

                <!-- BOX 3 : Refund Info -->
                <div class="cancel-box">
                   <div class="cancel-box__title">جزئیات استرداد</div>
                   <div class="cancel-grid">
                      <div>
                         <strong>تاریخ تایید / رد درخواست:</strong>
                          <?php
                          if (!empty($flight['DateSetCancelInt']) && $flight['DateSetCancelInt'] != '0' && !empty($flight['Status']) && $flight['Status'] == 'SetCancelClient') {
                              echo dateTimeSetting::jdate('(H:i:s) Y-m-d', $flight['DateSetCancelInt']);
                          } elseif (!empty($flight['DateConfirmCancelInt']) && $flight['DateConfirmCancelInt'] != '0' && !empty($flight['Status']) && $flight['Status'] == 'ConfirmCancel') {
                              echo dateTimeSetting::jdate('(H:i:s) Y-m-d', $flight['DateConfirmCancelInt']);
                          } else {
                              echo '—';
                          }
                          ?>
                      </div>

                      <div><strong>درصد جریمه:</strong> <?php echo ($flight['PercentIndemnity'] !== '' && $flight['PercentIndemnity'] !== null) ? ($flight['PercentIndemnity'] . '%') : '—'; ?></div>
                      <div><strong>مبلغ استرداد:</strong> <?php echo isset($flight['PriceIndemnity']) ? number_format($flight['PriceIndemnity']) . ' ریال' : '—'; ?></div>
                   </div>
                </div>

                <!-- BOX 4 : تعیین درصد کنسلی (تمام دکمه‌ها حفظ شده، فقط در غیر RequestClient غیرفعال می‌شود) -->
                <div class="cancel-box">
                   <div class="cancel-box__title">تعیین درصد کنسلی</div>

                    <?php if (!$canSetPercent): ?>
                       <div class="alert alert-warning" style="margin-bottom: 12px;">
                          در این وضعیت شما قادر به گذاشن درصد کنسلی از این بخش نمیباشید.
                       </div>
                    <?php endif; ?>

                   <div class="cancel-grid">

                       <?php if ($transportType === 'bus'): ?>

                           <?php if (!empty($busRefund) && !empty($busRefund['refundable'])): ?>
                             <div><strong>کل پرداختی:</strong> <?php echo number_format($busRefund['totalPrice']); ?></div>
                             <div><strong>جریمه سیستم:</strong> <?php echo $busRefund['percentage']; ?></div>
                             <div><strong>مبلغ جریمه:</strong> <?php echo number_format($busRefund['PenaltyAmount']); ?></div>
                             <div><strong>قابل استرداد:</strong> <?php echo number_format($busRefund['RefundableAmount']); ?></div>
                           <?php else: ?>
                             <div class="text-success">بدون جریمه</div>
                           <?php endif; ?>

                       <?php elseif ($transportType === 'flight'): ?>

                           <?php if (!empty($dataCancelView) && !empty($dataCancelView['responseSuccessfull'])): ?>
                             <div><strong>کل پرداختی:</strong> <?php echo number_format($dataCancelView['totalAmount']); ?></div>
                             <div><strong>جریمه سیستم:</strong> <?php echo $dataCancelView['penaltyAmount']; ?></div>
                             <div><strong>قابل استرداد:</strong> <?php echo number_format($dataCancelView['totalPayAmount']); ?></div>

                             <!-- دکمه کنسل کردن (دقیقاً مثل نسخه قدیمی) -->
                             <div class="cancel-action">
                                <button
                                   type="button"
                                   class="btn-cancel-action"
                                   onclick="cancelAltrabo('<?php echo $Param; ?>','<?php echo $transportType; ?>','<?php echo $ClientId; ?>')">
                                   کنسل کردن
                                </button>
                             </div>
                           <?php else: ?>
                             <div class="text-warning">از بخش فنی استعلام گرفته شود</div>
                           <?php endif; ?>

                       <?php endif; ?>

                   </div>

                   <!-- فرم درصد و توضیحات + دکمه ارسال (حفظ کامل، فقط در غیر RequestClient disable) -->
                   <div class="form-group mt-3">
                      <label class="PercentLabel">
                         تعیین درصد
                         <small>(شما میتوانید درصد جریمه مربوط را در اینجا وارد نمائید)</small>
                      </label>

                      <!-- مثل نسخه قدیمی: input + % از fare -->
                      <div style="display:flex; gap:10px; align-items:center;">
                         <input
                            class="form-control LimitInput"
                            id="PercentIndemnity"
                            placeholder="درصد"
                             <?php echo $canSetPercent ? '' : 'disabled'; ?>
                         >
                         <span>% از fare</span>
                      </div>
                   </div>

                   <div class="form-group">
                      <label>توضیحات</label>
                      <textarea
                         class="form-control"
                         id="DescriptionAdmin"
                         placeholder="توضیحات"
                            <?php echo $canSetPercent ? '' : 'disabled'; ?>
                        ></textarea>
                   </div>

                   <div class="cancel-action">
                      <button
                         type="button"
                         class="btn-submit-action"
                         onclick="SendPercentForAgency('<?php echo $Param; ?>','<?php echo $id; ?>','<?php echo $ClientId; ?>')"
                          <?php echo $canSetPercent ? '' : 'disabled'; ?>
                      >
                         ارسال اطلاعات
                      </button>
                   </div>
                </div>

             </div>
          </div>
       </div>

       <style>
           .cancel-modal {
               font-size: 1.15rem;
               line-height: 1.7;
           }
           .cancel-box{background:#fff;border:1px solid #e6e6e6;border-radius:10px;padding:15px;margin-bottom:15px;font-size: 13px; }
           .cancel-box__title{font-weight:700;margin-bottom:10px;border-right:4px solid #2a5298;padding-right:8px}
           .cancel-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:10px}

           .passenger-table__head,.passenger-table__row{
               display:grid;grid-template-columns:1.2fr 1.2fr 1fr .6fr 1fr;gap:10px;padding:8px 10px;align-items:center
           }
           .passenger-table__head{background:#f1f5f9;font-weight:700;border-radius:6px}
           .passenger-table__row{border-bottom:1px solid #eee}
           .passenger-table__row--danger{background:#fff5f5}

           .passenger-status{padding:4px 8px;border-radius:6px;font-size:12px;font-weight:700;text-align:center;color:#fff}
           .passenger-status--ConfirmCancel{background:#198754}
           .passenger-status--ConfirmClient{background:#0dcaf0;color:#000}
           .passenger-status--SetIndemnity,
           .passenger-status--RequestClient{background:#ffc107;color:#000}
           .passenger-status--SetCancelClient,
           .passenger-status--SetFailedIndemnity,
           .passenger-status--close{background:#dc3545}
           .passenger-status--RequestMember{background:#0d6efd}
           .passenger-status--danger{background:#dc3545}

           /* ===== Cancel Action Button ===== */
           .cancel-action { margin-top: 15px; text-align: left; position: relative; z-index: 20; }

           .btn-cancel-action {
               background: linear-gradient(135deg, #0d6efd, #084298);
               border: none;
               color: #fff;
               padding: 10px 26px;
               font-size: 14px;
               font-weight: 700;
               border-radius: 10px;
               cursor: pointer;
               min-width: 160px;
               transition: all .25s ease;
               box-shadow: 0 6px 18px rgba(13,110,253,.35);
           }
           .btn-cancel-action:hover {
               transform: translateY(-1px);
               box-shadow: 0 10px 26px rgba(13,110,253,.45);
               background: linear-gradient(135deg, #0b5ed7, #06357a);
           }
           .btn-cancel-action:active { transform: translateY(0); box-shadow: 0 4px 12px rgba(13,110,253,.35); }
           .btn-cancel-action:disabled { background: #94a3b8; cursor: not-allowed; box-shadow: none; }

           .btn-submit-action {
               background: linear-gradient(135deg,#198754,#0f5132);
               border: none;
               color: #fff;
               padding: 10px 30px;
               font-weight: 800;
               border-radius: 10px;
               cursor: pointer;
               box-shadow: 0 6px 18px rgba(25,135,84,.35);
           }
           .btn-submit-action:disabled {
               background:#94a3b8;
               cursor:not-allowed;
               box-shadow:none;
           }
       </style>
        <?php
    }


	#endregion
	#region ShowModalPercent

	public function ShowModalPercent($Param, $id, $ClientId) {


	    $transportType=$_POST['transportType'];
	    $user = Load::controller('user');
	    if($transportType == 'bus'){
	        $apiBus=Load::library('apiBus');

	        $InfoCancelTicket = $user->getInfoTicketBusCancel($Param,$ClientId);


	        $busRefundCheck=$apiBus->busRefundCheck($InfoCancelTicket[0]['passenger_factor_num'],$ClientId);

	        if($busRefundCheck['response']['SuccessfulStatus']['client'] && $busRefundCheck['response']['SuccessfulStatus']['provider']){
	            $totalRefundableAmount=$busRefundCheck['response']['data']['totalRefundableAmount'];
	            $totalPenaltyAmount=$busRefundCheck['response']['data']['totalPenaltyAmount'];

	            $busRefund=[
                    'percentage'=>functions::getPercentage($InfoCancelTicket[0]['total_price'],$totalRefundableAmount).'%',
                    'PenaltyAmount'=>$totalPenaltyAmount,
                    'RefundableAmount'=>$totalRefundableAmount,
                    'refundable'=>true,
	            ];
	        }else{
	            $busRefund=[
                    'percentage'=>'0%',
                    'refundable'=>false,
	            ];
	        }

	    }
	    elseif($transportType == 'flight'){
	          $infoFlight = functions::InfoFlight($Param);
            if($infoFlight['api_id']=='10'){
                    $infoCancelFlight = $user->InfoModalTicketCancel($Param,$transportType,$ClientId);
                    $apiFlight = Load::library('apiLocal');
                    $caseTitle  = '';
                    switch ($infoCancelFlight[0]['ReasonMember']){
                        case 'CancelByAirline':
                            $caseTitle = 1;
                            break;
                        case 'PersonalReason':
                            $caseTitle = 2;
                            break;
                        case 'DelayTwoHours':
                            $caseTitle = 3;
                            break;
                    }
                    $dataCancel['FlightRefundType'] = 1 ;
                    $dataCancel['FlightReasonType'] = $caseTitle ;
                        foreach ($infoCancelFlight as $passenger)
                        {
                             $dataCancel['passportNumber'][] = $passenger['passportNumber'] ;
                        }

                   $viewCancel = $apiFlight->getAmountPenaltyAltrabo($Param,$dataCancel);

                  $dataCancelView['responseSuccessfull'] = ($viewCancel['response']['successful']) ? true : false  ;
                  $dataCancelView['penaltyAmount'] = ($viewCancel['data']['penaltyPassengers'][0]['crcnType']=='Value') ? $viewCancel['data']['totalPenaltyAmount'].' '.'ریال' : $viewCancel['data']['totalPenaltyAmount'].' '.'درصد';
                  $dataCancelView['totalPayAmount'] = $viewCancel['data']['totalPayAmount'] ;
                  $dataCancelView['totalAmount'] = $viewCancel['data']['totalAmount'] ;
            }


	    }
		?>
		<div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
				    <div class="row">



                    </div>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">تعیین درصد کنسلی </h4>
				</div>

				<div class="modal-body">

					<div class="row">

						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
							<div class="form-group">

							<?php
							if($transportType == 'bus'){ ?>
							        <div class="d-flex flex-wrap">

                            <?php
							if($busRefund['refundable']){ ?>
								 <span class="PercentLabel w-100 mb-3 text-secondary">کل پرداختی :
									<small><?php echo number_format($InfoCancelTicket[0]['total_price']); ?></small>
								</span>


							    <span class="PercentLabel w-100 mb-3 text-danger">جریمه ی سیستم :
									<small><?php echo $busRefund['percentage']; ?></small>
								</span>



								<span class="PercentLabel w-100 mb-3 text-danger">جریمه :
									<small><?php echo number_format($busRefund['PenaltyAmount']); ?></small>
								</span>

                                <span class="PercentLabel w-100 mb-3 text-success">قابل استرداد :
                                        <small><?php echo number_format($busRefund['RefundableAmount']); ?></small>
								</span>
							<?php
								}else{

							?>
                                <span class="PercentLabel w-100 text-success">
                                    بدون جریمه
                                </span>
							<?php
								}

							?>

                            </div>
							<?php
								}else{?>
                                     <div class="d-flex flex-wrap">
                                      <?php
							if(isset($dataCancelView) && $dataCancelView['responseSuccessfull']){ ?>
								 <span class="PercentLabel w-100 mb-3 text-secondary">کل پرداختی :
									<small><?php echo number_format($dataCancelView['totalAmount']); ?></small>
								</span>


							    <span class="PercentLabel w-100 mb-3 text-danger">جریمه ی سیستم :
									<small><?php echo $dataCancelView['penaltyAmount']; ?></small>
								</span>



                                <span class="PercentLabel w-100 mb-3 text-success">قابل استرداد :
                                        <small><?php echo number_format($dataCancelView['totalPayAmount']); ?></small>
								</span>

								<span class="PercentLabel w-100 mb-3 text-success">
                                      <button type="button" class="btn btn-primary  pull-left"  onclick="cancelAltrabo('<?php echo $Param; ?>', '<?php echo $_POST['transportType']; ?>', '<?php echo $ClientId ?>')">
                                            کنسل کردن
					                  </button>
								</span>
							<?php
								}else{

							?>
                                <span class="PercentLabel w-100 text-success">
                                    از بخش فنی استعلام گرفته شود
                                </span>
							<?php }
							}
							?>

                            </div>

								<label for="DescriptionClient" class="PercentLabel">تعیین درصد
									<small>  (شما میتوانید درصد جریمه مربوط را در اینجا وارد نمائید)</small>
								</label>
								<input class="form-control LimitInput " id="PercentIndemnity" placeholder="درصد"><span>% از fare</span>
							</div>
						</div>
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label for="DescriptionClient"> توضیحات

								</label>
								<textarea class="form-control" id="DescriptionAdmin" placeholder="توضیحات"></textarea>
							</div>
						</div>
					</div>

				</div>

				<div class="modal-footer site-bg-main-color">

					<button type="button" class="btn btn-primary  pull-left"
					        onclick="SendPercentForAgency('<?php echo $Param; ?>', '<?php echo $id; ?>', '<?php echo $ClientId ?>')">
						ارسال اطلاعات
					</button>

				</div>
			</div>
		</div>
		</div>

		</div>

		<?php
	}
    public function UserShowModalPercent($Param, $id, $ClientId) {

        $transportType=$_POST['transportType'];
        $user = Load::controller('user');
        if($transportType == 'bus'){
            $apiBus=Load::library('apiBus');

            $InfoCancelTicket = $user->getInfoTicketBusCancel($Param,$ClientId);


            $busRefundCheck=$apiBus->busRefundCheck($InfoCancelTicket[0]['passenger_factor_num'],$ClientId);

            if($busRefundCheck['response']['SuccessfulStatus']['client'] && $busRefundCheck['response']['SuccessfulStatus']['provider']){
                $totalRefundableAmount=$busRefundCheck['response']['data']['totalRefundableAmount'];
                $totalPenaltyAmount=$busRefundCheck['response']['data']['totalPenaltyAmount'];

                $busRefund=[
                    'percentage'=>functions::getPercentage($InfoCancelTicket[0]['total_price'],$totalRefundableAmount).'%',
                    'PenaltyAmount'=>$totalPenaltyAmount,
                    'RefundableAmount'=>$totalRefundableAmount,
                    'refundable'=>true,
                ];
            }else{
                $busRefund=[
                    'percentage'=>'0%',
                    'refundable'=>false,
                ];
            }

        }
        elseif($transportType == 'flight'){
            $infoFlight = functions::InfoFlight($Param);
            if($infoFlight['api_id']=='10'){
                $infoCancelFlight = $user->InfoModalTicketCancel($Param,$transportType,$ClientId);
                $apiFlight = Load::library('apiLocal');
                $caseTitle  = '';
                switch ($infoCancelFlight[0]['ReasonMember']){
                    case 'CancelByAirline':
                        $caseTitle = 1;
                        break;
                    case 'PersonalReason':
                        $caseTitle = 2;
                        break;
                    case 'DelayTwoHours':
                        $caseTitle = 3;
                        break;
                }
                $dataCancel['FlightRefundType'] = 1 ;
                $dataCancel['FlightReasonType'] = $caseTitle ;
                foreach ($infoCancelFlight as $passenger)
                {
                    $dataCancel['passportNumber'][] = $passenger['passportNumber'] ;
                }

                $viewCancel = $apiFlight->getAmountPenaltyAltrabo($Param,$dataCancel);

                $dataCancelView['responseSuccessfull'] = ($viewCancel['response']['successful']) ? true : false  ;
                $dataCancelView['penaltyAmount'] = ($viewCancel['data']['penaltyPassengers'][0]['crcnType']=='Value') ? $viewCancel['data']['totalPenaltyAmount'].' '.'ریال' : $viewCancel['data']['totalPenaltyAmount'].' '.'درصد';
                $dataCancelView['totalPayAmount'] = $viewCancel['data']['totalPayAmount'] ;
                $dataCancelView['totalAmount'] = $viewCancel['data']['totalAmount'] ;
            }


        }
        ?>
       <div class="modal-dialog modal-lg">

          <!-- Modal content-->
          <div class="modal-content">
             <div class="modal-header site-bg-main-color">
                <div class="row">



                </div>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">تعیین درصد کنسلی </h4>
             </div>

             <div class="modal-body">

                <div class="row">

                   <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                      <div class="form-group">

                          <?php
                          if($transportType == 'bus'){ ?>
                             <div class="d-flex flex-wrap">

                                 <?php
                                 if($busRefund['refundable']){ ?>
                                    <span class="PercentLabel w-100 mb-3 text-secondary">کل پرداختی :
									<small><?php echo number_format($InfoCancelTicket[0]['total_price']); ?></small>
								</span>


                                    <span class="PercentLabel w-100 mb-3 text-danger">جریمه ی سیستم :
									<small><?php echo $busRefund['percentage']; ?></small>
								</span>



                                    <span class="PercentLabel w-100 mb-3 text-danger">جریمه :
									<small><?php echo number_format($busRefund['PenaltyAmount']); ?></small>
								</span>

                                    <span class="PercentLabel w-100 mb-3 text-success">قابل استرداد :
                                        <small><?php echo number_format($busRefund['RefundableAmount']); ?></small>
								</span>
                                     <?php
                                 }else{

                                     ?>
                                    <span class="PercentLabel w-100 text-success">
                                    بدون جریمه
                                </span>
                                     <?php
                                 }

                                 ?>

                             </div>
                              <?php
                          }else{?>
                         <div class="d-flex flex-wrap">
                             <?php
                             if(isset($dataCancelView) && $dataCancelView['responseSuccessfull']){ ?>
                                <span class="PercentLabel w-100 mb-3 text-secondary">کل پرداختی :
									<small><?php echo number_format($dataCancelView['totalAmount']); ?></small>
								</span>


                                <span class="PercentLabel w-100 mb-3 text-danger">جریمه ی سیستم :
									<small><?php echo $dataCancelView['penaltyAmount']; ?></small>
								</span>



                                <span class="PercentLabel w-100 mb-3 text-success">قابل استرداد :
                                        <small><?php echo number_format($dataCancelView['totalPayAmount']); ?></small>
								</span>

                                <span class="PercentLabel w-100 mb-3 text-success">
                                      <button type="button" class="btn btn-primary  pull-left"  onclick="cancelAltrabo('<?php echo $Param; ?>', '<?php echo $_POST['transportType']; ?>', '<?php echo $ClientId ?>')">
                                            کنسل کردن
					                  </button>
								</span>
                                 <?php
                             }else{

                                 ?>
                                <span class="PercentLabel w-100 text-success">
                                    از بخش فنی استعلام گرفته شود
                                </span>
                             <?php }
                             }
                             ?>

                         </div>

                         <label for="DescriptionClient" class="PercentLabel">تعیین درصد
                            <small>  (شما میتوانید درصد جریمه مربوط را در اینجا وارد نمائید)</small>
                         </label>
                         <input class="form-control LimitInput " id="PercentIndemnity" placeholder="درصد"><span>% از fare</span>
                      </div>
                   </div>
                   <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                      <div class="form-group">
                         <label for="DescriptionClient"> توضیحات

                         </label>
                         <textarea class="form-control" id="DescriptionAdmin" placeholder="توضیحات"></textarea>
                      </div>
                   </div>
                </div>

             </div>

             <div class="modal-footer site-bg-main-color">

                <button type="button" class="btn btn-primary  pull-left"
                        onclick="UserSendPercentForAgency('<?php echo $Param; ?>', '<?php echo $id; ?>', '<?php echo $ClientId ?>')">
                   ارسال اطلاعات
                </button>

             </div>
          </div>
       </div>
       </div>

       </div>

        <?php

    }
	#endregion
	#region FinalConfirm

	public function FinalConfirm($Param, $id, $ClientId) {
       $request_number = $Param['RequestNumber'];
       $pnr = $Param['pnr'];

       $listCancel = Load::controller('listCancel');
		$Cancel = $listCancel->InfoCancelTicket($request_number, $id, $ClientId);
		$typeFlightCancel = ($Cancel[0]['TypeCancel'] == 'flight' || $Cancel[0]['TypeCancel'] == '');
        $indemnityPrice = '0';

		if ($typeFlightCancel) {
			 if($Cancel[0]['flight_type'] == 'system' && $Cancel[0]['IsInternal'] == '1') {
			list($TotalPrice,$fare) = functions::TotalPriceCancelTicketSystem($Cancel);
			   $PricePenalty = functions::CalculatePenaltyPriceCancel($TotalPrice,$fare, $Cancel[0]);
			   $indemnityPrice =round($PricePenalty-(30000 * count($Cancel)));

			 }elseif($Cancel[0]['flight_type'] == 'charter'){
			    $TotalPrice = functions::TotalPriceNetTicketCharter($Cancel);

			   $indemnityPrice = round(functions::CalculatePenaltyPriceCancelCharter($TotalPrice, $Cancel[0]));


			 }
		}elseif($Cancel[0]['TypeCancel'] == 'bus'){

		    $admin = Load::controller('admin');
		    $priceBusSql = "SELECT * FROM book_bus_tb WHERE order_code='{$Param}'";
		    $priceBookBus = $airlineClientCharter = $admin->ConectDbClient($priceBusSql, $ClientId, "Select", "", "", "");

		    $indemnityPrice = ($priceBookBus['price_api']-($priceBookBus['price_api']*($Cancel[0]['PercentIndemnity']/100))) ;

		}elseif($Cancel[0]['TypeCancel'] == 'insurance'){
        $admin = Load::controller('admin');
        $priceInsuranceSql = "SELECT * FROM book_insurance_tb WHERE factor_number='{$Param}'";
        $priceBookInsurance = $airlineClientCharter = $admin->ConectDbClient($priceInsuranceSql, $ClientId, "Select", "", "", "");
        $indemnityPrice = ($priceBookInsurance['base_price']-($priceBookInsurance['base_price']*($Cancel[0]['PercentIndemnity']/100))) ;
    }elseif($Cancel[0]['TypeCancel'] == 'hotel'){
        $admin = Load::controller('admin');
        $priceHotelSql = "SELECT * FROM book_hotel_local_tb WHERE factor_number='{$Param}'";
        $priceBookHotel = $airlineClientCharter = $admin->ConectDbClient($priceHotelSql, $ClientId, "Select", "", "", "");
        $indemnityPrice = ($priceBookHotel['total_price']-($priceBookHotel['total_price']*($Cancel[0]['PercentIndemnity']/100))) ;
    }
		?>
		<div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
            <div class="modal-header site-bg-main-color">
            <div style="display:flex; gap:5px;">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">تعیین مبلغ کنسلی </h4>

               <h4 class="modal-title"> (<?php echo $request_number; ?>) </h4>

               <h4 class="modal-title">(<?php echo $pnr; ?>)</h4>
            </div>
				<div class="modal-body">

					<div class="row">

						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label for="DescriptionClient" class="PercentLabel">تعیین مبلغ
									<small>(شما میتوانید مبلغ استرداد مربوط را در اینجا وارد نمائید)</small>
								</label>
                        <input class="form-control" id="PriceIndemnity"
                               placeholder="مبلغ مورد نظر را به ریال  وارد نمائید"
                               onkeyup="javascript:separator(this);"
                               value="<?php echo number_format($indemnityPrice);?>">
							</div>
						</div>

					</div>

				</div>

				<div class="modal-footer site-bg-main-color">

					<button type="button" class="btn btn-primary  pull-left"
					        onclick="SendPriceForCalculate('<?php echo $Param; ?>', '<?php echo $id; ?>', '<?php echo $ClientId ?>')">
						ارسال اطلاعات
					</button>

				</div>
			</div>
		</div>


		<?php
	}

	#endregion
	#region ModalShowLogErrorServer

	public function ModalShowLogErrorServer($Param) {


		/** @var LogErrorServer $Log */
		$Log = Load::controller($this->Controller);

		$InfoLog = $Log->ShowLog($Param);
		?>
		<div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">مشاهده جزئیات سوابق سرور</h4>
				</div>

				<div class="modal-body">
					<div class="row margin-10">
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 margin-10">
							<span style="float: right">  جزئیات خطا:</span>
							<span><?php echo $InfoLog['message']; ?></span>
						</div>
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 margin-10">
							<span style="float: right">  جزئیات نتیجه بازگشستی:</span>
							<pre><?php echo $InfoLog['json_result']; ?></pre>
						</div>

					</div>
				</div>

				<div class="modal-footer site-bg-main-color">


				</div>
			</div>
		</div>
		<?php
	}

	#endregion
	#region ModalAddCounterOfUser

	public function ModalAddCounterOfUser($Param) {
		/** @var agency $agency */
		$agency = Load::controller($this->Controller);
		$agency->getCounterType();
		$agency->getAll();
		?>
		<div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">افزودن کاربر به عنوان کانتر</h4>
				</div>
				<div class="modal-body">

					<div class="row">

						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">


							<div class="form-group col-sm-6 ">

								<label for="typeCounterId" class="control-label"> کانتر </label>
								<select class="form-control" name="typeCounterId" id="typeCounterId">
									<option value="">انتخاب کنید...</option>
									<?php
									foreach ($agency->option as $counterType) {
										if ($counterType['id'] != '5') {
											?>
											<option value="<?php echo $counterType['id'] ?>"><?php echo $counterType['name'] ?></option>
											<?php
										}
									}
									?>
								</select>
							</div>
							<div class="form-group col-sm-6 ">

								<label for="title" class="control-label"> انتخاب آژانس پذیرنده کانتر</label>
								<select class="form-control" name="agency_id" id="agency_id">
									<option value="">انتخاب کنید...</option>
									<?php foreach ($agency->list as $agency) { ?>
										<option value="<?php echo $agency['id'] ?>"><?php echo $agency['name_fa'] ?></option>
										<?php
									}
									?>
								</select>
							</div>

						</div>


					</div>

				</div>

				<div class="modal-footer site-bg-main-color">

					<button type="button" class="btn btn-primary  pull-right"
					        onclick="ActiveAsCounter('<?php echo $Param; ?>')">
						ارسال اطلاعات
					</button>

				</div>
			</div>
		</div>


		<?php
	}

	#endregion
	#region ModalShowMessage

	public function ModalShowMessage($Param) {


		$message = Load::controller($this->Controller);

		$message->seenMessage($Param);

		$view = $message->viewMessage($Param);
		?>
		<div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">مشاهده پیام</h4>
				</div>
				<div class="modal-body">

					<div class="row">

						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">


							<div class="form-group col-sm-6 ">

								<label for="title" class="control-label"> عنوان </label>
								<input class="form-control" name="title" id="title"
								       value="<?php echo $view['title']; ?>" readonly>
							</div>
							<div class="form-group col-sm-12 ">

								<label for="message" class="control-label">محتوای پیام</label>
								<textarea name="message" id="message" class="form-control textareaMessage"
								          readonly><?php echo $view['message']; ?></textarea>
							</div>

						</div>


					</div>

				</div>

				<div class="modal-footer site-bg-main-color">

					<button type="button" class="btn btn-primary  pull-right" data-dismiss="modal">
						بستن
					</button>

				</div>
			</div>
		</div>


		<?php
	}

	#endregion
	#region ModalShowMessageAdmin

	public function ModalShowMessageAdmin($Param, $ClientId) {


		$message = Load::controller($this->Controller);

		$view = $message->viewMessageAdmin($Param);
		?>
		<div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">مشاهده پیام</h4>
				</div>
				<div class="modal-body">

					<div class="row">

						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">


							<div class="form-group col-sm-6 ">

								<label for="title" class="control-label"> عنوان </label>
								<input class="form-control" name="title" id="title"
								       value="<?php echo $view['title']; ?>" readonly>
							</div>
							<div class="form-group col-sm-12 ">

								<label for="message" class="control-label">محتوای پیام</label>
								<textarea name="message" id="message" class="form-control textareaMessage"
								          readonly><?php echo $view['message']; ?></textarea>
							</div>

						</div>


					</div>

				</div>

				<div class="modal-footer site-bg-main-color">

					<button type="button" class="btn btn-primary  pull-right" data-dismiss="modal">
						بستن
					</button>

				</div>
			</div>
		</div>


		<?php
	}

	#endregion
	#region ModalConfirmCancelPrivate

	public function ModalConfirmCancelPrivate($Param, $id) {
		$ClientId = CLIENT_ID;
		?>
		<div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">تعیین درصد و مبلغ کنسلی </h4>
				</div>
				<div class="modal-body">

					<div class="row">

						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label for="DescriptionClient" class="PercentLabel">تعیین درصد
									<small>(شما میتوانید درصد جریمه مربوط را در اینجا وارد نمائید)</small>
								</label>
								<input class="form-control LimitInput " id="PercentIndemnity" placeholder="درصد">
							</div>
						</div>
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label for="PriceIndemnity" class="PercentLabel">تعیین مبلغ استرداد
									<small>(شما میتوانید مبلغ استرداد را در اینجا وارد نمائید)</small>
								</label>
								<input class="form-control LimitInput " id="PriceIndemnity" placeholder="مبلغ">
							</div>
						</div>
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label for="DescriptionClient"> توضیحات

								</label>
								<textarea class="form-control" id="DescriptionClient" placeholder="توضیحات"></textarea>
							</div>
						</div>
					</div>

				</div>

				<div class="modal-footer site-bg-main-color">

					<button type="button" class="btn btn-primary  pull-left"
					        onclick="savePercentAndPriceIndemnity('<?php echo $Param; ?>', '<?php echo $id; ?>', '<?php echo $ClientId ?>')">
						ارسال اطلاعات
					</button>

				</div>
			</div>
		</div>

		</div>

		<?php
	}

	#endregion
	#region ModalShowUsersForMessage

	public function ModalShowUsersForMessage($Param) {
		$ClientId = CLIENT_ID;
		$message = Load::controller($this->Controller);

		$view = $message->ShowClientMessage($Param);
		?>
		<div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">مشاهده کاربرانی که پیام برای آن ها ارسال شده است </h4>
				</div>
				<div class="modal-body">

					<div class="row">

						<?php
						$Clients = json_decode($view['clientIDs']);
						foreach ($Clients as $key => $client_id):
							$btn = '';
							if ($message->delMessageByClient($client_id, $view['unique_code']) == 'ok') {
								$btn = 'btn-default';
							} else {
								if ($message->viewMessageByClient($client_id, $view['unique_code']) == 'ok') {
									$btn = 'btn-success';
								} else if ($message->viewMessageByClient($client_id, $view['unique_code']) == 'nok') {
									$btn = 'btn-danger';
								}
							}
							?>
							<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12 fcbtn btn btn-outline <?php echo $btn ?> btn-1f  mdi <?php echo($message->delMessageByClient($client_id, $view['unique_code']) == 'ok' ? 'mdi-account-remove' : ($message->viewMessageByClient($client_id, $view['unique_code']) == 'ok' ? 'mdi-account-check' : 'mdi-account')); ?> margin-10 padding10"
							     style="margin-right: 40px !important;"><?php if ($message->delMessageByClient($client_id, $view['unique_code']) == 'nok') {
									?>
									<i class="mdi mdi-close-circle del-message-user"
									   onclick="DelMessageForUser('<?php echo $view['unique_code']; ?>', '<?php echo $client_id ?>');"></i>
									<?php
								}
								?>
								<?php echo functions::ClientName($client_id) ?>
							</div>
						<?php endforeach; ?>
					</div>

				</div>

			</div>
		</div>

		</div>

		<?php
	}

	#endregion
	#region modalLogAdmin

	public function modalLogAdmin($Param) {
		$ClientId = CLIENT_ID;
		$Log = Load::controller($this->Controller);

		$viewLog = $Log->modalLogLoginAdmin($Param);

		?>
		<div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">مشاهده سه ورود آخر به پنل مدیریت </h4>
				</div>
				<div class="modal-body">
					<div class="row padding-left-10 padding-right-10">
						<table class="table full-color-table full-success-table hover-table">
							<thead>
							<tr>
								<th>#</th>
								<th>ip</th>
								<th>تاریخ</th>
							</tr>
							</thead>
							<tbody>

							<?php
							if (!empty($viewLog)):
								foreach ($viewLog as $key => $item) :
									?>
									<tr>
										<td><?php echo $key + 1; ?></td>
										<td><?php echo $item['ip']; ?></td>
										<td><?php echo dateTimeSetting::jdate("(H:i:s) Y-m-d ", $item['creation_date_int']); ?></td>
									</tr>
									<?php
								endforeach;
							else:
								?>
								<tr>
									<td colspan="3" class="text-center">اطلاعاتی وجود ندارد</td>
								</tr>
							<?php endif; ?>
							</tbody>
						</table>
					</div>

				</div>

			</div>
		</div>

		</div>

		<?php
	}

	#endregion
	#region ModalSendSms

	public function ModalSendSms($Param) {
		$ClientId = CLIENT_ID;

		$InfoTicket = functions::InfoFlight($Param);

      if ($InfoTicket['passenger_name']=='' && $InfoTicket['passenger_family']=='') {
          $InfoTicket['passenger_name'] = $InfoTicket['passenger_name_en'];
          $InfoTicket['passenger_family'] = $InfoTicket['passenger_family_en'];
      }
		?>
		<div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">ارسال پیام</h4>
				</div>
				<div class="modal-body">

					<div class="row">

						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label for="Reason"> دلیل پیام</label>
								<select class="form-control" name="Reason" id="Reason" onchange='selectTextMessage($(this))'>
									<option value="">انتخاب کنید...</option>
									<option value="Delay">تاخیر</option>
									<option value="HurryUp">تعجیل</option>
									<option value="Cancel">کنسلی</option>

								</select>
							</div>
						</div>
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label for="DescriptionClient"> متن پیام</label>
								<input type='hidden' name='sample_sms_text' value='مسافر گرامی (<?php echo $InfoTicket['passenger_name'] . ' ' . $InfoTicket['passenger_family'] ?>) با عرض پوزش ، پرواز شماره <?php echo $InfoTicket['flight_number'] ?> از <?php echo $InfoTicket['origin_city'] ?> به <?php echo $InfoTicket['desti_city'] ?> ،هواپیمایی <?php echo $InfoTicket['airline_name'] ?> در  تاریخ <?php echo functions::ConvertToJalali($InfoTicket['date_flight'],'/');?>'>
								<textarea class="form-control" id="contentSms"
								          placeholder="متن پیام">مسافر گرامی (<?php echo $InfoTicket['passenger_name'] . ' ' . $InfoTicket['passenger_family'] ?>) با عرض پوزش ، پرواز شماره <?php echo $InfoTicket['flight_number'] ?> از <?php echo $InfoTicket['origin_city'] ?> به <?php echo $InfoTicket['desti_city'] ?> ،هواپیمایی <?php echo $InfoTicket['airline_name'] ?> در  تاریخ <?php echo functions::ConvertToJalali($InfoTicket['date_flight']).' در صورت عدم تمایل به استفاده از پرواز در ساعت جدید لطفا حداکثر تا ساعت 00:00 مورخ --/--/-- جهت استرداد بلیط اقدام نمایید .'; ?>
                                </textarea>

							</div>
						</div>
					</div>

				</div>

				<div class="modal-footer site-bg-main-color">

					<button type="button" class="btn btn-primary  pull-left"
					        onclick="sendSms('<?php echo $Param; ?>')">
						ارسال اطلاعات
					</button>

				</div>
			</div>
		</div>

		</div>

		<?php
	}

	#endregion



  #region ModalUploadProof

	public function ModalUploadProof($Param) {

    $reservationProofController = Load::controller('reservationProof');

    $reservation_proof = $reservationProofController->getProofFile($Param['requestNumber'] , $Param['type'] ) ;



		?>
		<div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">آپلود فاکتور </h4>
				</div>
				<?php
				  if(!$reservation_proof) {
            ?>
            	<form data-toggle="validator" method="post" id="uploadProofFile" name='uploadProofFile' enctype='multipart/form-data'>

            <input type="hidden" name="flag" value="uploadProof">
            <input type="hidden" name="request_number" value="<?php echo $Param['requestNumber'] ?>">
            <input type="hidden" name="service_type" value="<?php echo $Param['type'] ?>">
					<div class="modal-body">

						<div class="row">
              <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                <p>شما تنها میتوانید فایل با  این پسوندها را انتخاب نمایید : jpeg - jpeg - png - gif - pdf - doc - docx - mp4 - webm   </p>
                <p>حجم فایل آپلودی : حجم فایل باید کمتر از 488.3 کیلوبایت  باشد </p>
              </div>
							<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
							  <div class="form-group ">
                          <label for="proof_file" class="control-label">انتخاب فایل</label>
                          <input  type='file'  name='proof_file' name='proof_file'>
                </div>
							</div>
							<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
							  <div class="form-group my-parent-input-label">
                          <label for="proof_title" class="control-label">عنوان فایل :</label>
                          <input class='my-input-modal' type='text'  name='proof_title' name='proof_title' placeholder="عنوان فایل را وارد کنید...">
                </div>
							</div>

						</div>

					</div>

					<div class="modal-footer site-bg-main-color">

						<button type="button" class="btn btn-primary  pull-right" data-dismiss="modal">بستن</button>
						<button type="submit" class="btn btn-success pull-right">آپلود فایل</button>

					</div>

				</form>

				<script type="text/javascript">
            $("#uploadProofFile").validate({
                        rules: {
                            proof_title: {
                                required: true
                            },
                            proof_file: {
                                required: true
                            },
                        },
                        messages: {},
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
                                url: amadeusPath + 'user_ajax.php',
                                type: "post",
                                success: function (response) {
                                  console.log(response)
                                    var res = response.split(':');

                                    if (response.indexOf('success') > -1) {
                                        $.toast({
                                            heading: 'آپلود فاکتور با موفقیت انجام شد.',
                                            text: res[1],
                                            position: 'top-right',
                                            loaderBg: '#fff',
                                            icon: 'success',
                                            hideAfter: 3500,
                                            textAlign: 'right',
                                            stack: 6
                                        });

                                        setTimeout(function () {
                                            $('#ModalPublic').modal('hide');
                                        }, 1000);


                                    } else {

                                        $.toast({
                                            heading: 'آپلود فاکتور',
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
				</script>

        <?php

				  }else {
            $ext = pathinfo($reservation_proof['file_path'], PATHINFO_EXTENSION) ;
            if(in_array($ext,['jpg','gif','png','tif', 'jpeg'])) {
              $file_url = ROOT_ADDRESS_WITHOUT_LANG . '/pic/proof/' . $reservation_proof['file_path'];
              $image_url =ROOT_ADDRESS_WITHOUT_LANG . '/pic/proof/' . $reservation_proof['file_path'];
            }else {
              $file_url = ROOT_ADDRESS_WITHOUT_LANG . '/pic/proof/' . $reservation_proof['file_path'];
              $image_url = ROOT_ADDRESS_WITHOUT_LANG . '/pic/ext-icons/'.$ext.'.png';
            }
            ?>
            <div class="modal-body">

						<div class="row">

							<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
							   <a href="<?php echo $file_url ?>" target="_blank" >
							        <img class='my-img-modal' src="<?php  echo $image_url ?> " alt="'<?php echo $reservation_proof['file_title'] ?>'">
                  </a>
                  <div class='parent-titr-modal'>
                    <span>عنوان:</span>
                    <span class='my-titr-img-modal'><?php echo $reservation_proof['file_title'] ?></span>
                  </div>
							</div>


						</div>

					</div>

					  <div class="modal-footer site-bg-main-color">

						<button type="button" class="btn btn-primary  pull-right" data-dismiss="modal">بستن</button>


					</div>
            <?php

				  }
				?>

			</div>
		</div>

		</div>

		<?php
	}
	#endregion

	#region ModalSendInteractiveSms

	public function ModalSendInteractiveSms($Param) {
		$buyController = Load::controller($this->Controller);
		$buyInfo = $buyController->info_flight_client($Param);

		$output = '';
		$offCodeController = Load::controller('interactiveOffCodes');

		foreach ($buyInfo as $item) {
			$memberID = $item['member_id'];

			if (empty($output)) {
				$output = $offCodeController->getReSendableGroups($item['factor_number'], $item['member_id'], $item['serviceTitle'], $item['origin_airport_iata'], $item['desti_airport_iata']);
			}
		}
		?>
		<div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">ارسال مجدد پیامک کد ترانسفر</h4>
				</div>
				<div class="modal-body">

					<?php if (!empty($output)) { ?>

						<div class="row">

							<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
								<p>انتخاب یکی از کدهای ترانسفر برای ارسال (توجه: تنها تخفیف هایی نمایش داده می شوند که
									خرید مذکور، مشمول شرایط آن گردد)</p>
								<div class="form-group">

									<?php
									foreach ($output as $key => $offCode) {
										echo '
                                    <div class="col-md-4 col-sm-12">
                                        <input type="radio" name="offCodeGroup" id="offCodeGroup' . $key . '" value="' . $offCode['id'] . '" ' . ($key == 0 ? 'checked="checked"' : '') . ' />
                                        <label for="offCodeGroup' . $key . '">' . $offCode['title'] . '</label>
                                    </div>
                                    ';
									}
									?>
								</div>
							</div>
						</div>

					<?php } else { ?>
						<p>چنین عملیاتی امکان پذیر نمی باشد</p>
					<?php } ?>

				</div>

				<div class="modal-footer site-bg-main-color">

					<?php if (!empty($output)) { ?>
						<button type="button" class="btn btn-primary  pull-left"
						        onclick="sendInteractiveSms('<?php echo $Param; ?>', '<?php echo $memberID; ?>')">
							ارسال پیامک
						</button>
					<?php } ?>

				</div>
			</div>
		</div>

		</div>

		<?php
	}

	#endregion


	#region ModalShowInsurance
	public function ModalShowInsurance($Param) {
		$user = Load::controller($this->Controller);
		$records = $user->info_insurance_client($Param);


      ?>

		<div class="modal-header site-bg-main-color">

			<h4 class='text-rigt'><?php echo functions::Xmlinformation("ViewPurchaseInvoiceNumber"); ?>
				:<?php echo $Param; ?> </h4>
			<span class="close" onclick="modalClose('')">&times;</span>
		</div>
		<div class="modal-body text-right">
			<?php
			foreach ($records as $key => $view) {
				if ($key < 1) {
					?>
					<div class="row margin-both-vertical-20">
						<div class="col-md-12 modal-text-center modal-h">
							<span><?php echo functions::Xmlinformation("InsurancePolicyProfile"); ?> <?php echo $view['source_name_fa']; ?></span>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6 ">
							<span><?php echo functions::Xmlinformation("Date"); ?> <?php echo $view['payment_type'] == 'cash' ? functions::Xmlinformation("Payment") : functions::Xmlinformation("Buy"); ?>
								: </span>
							<span dir="ltr"><?php echo $view['payment_date'] != '0000-00-00 00:00:00' ? functions::set_date_payment($view['payment_date']) : functions::Xmlinformation("Unpaid"); ?></span>
						</div>
						<div class="col-md-6 ">
							<span dir="rtl"><?php echo functions::Xmlinformation("DateBookingInsurancePolicy"); ?>
								: </span>
							<span style=''><?php echo $user->set_date_reserve(substr($view['creation_date'], 0, 10)) ?></span>
						</div>
						<div class="col-md-6 ">
							<span><?php echo functions::Xmlinformation("Destination"); ?>: </span>
							<span><?php echo $view['destination'] ?></span>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 ">
							<span><?php echo functions::Xmlinformation("Count"); ?> :</span>
							<span style=''><?php echo $user->count; ?></span>
						</div>
						<div class="col-md-6 ">
							<span><?php echo functions::Xmlinformation("Durationtrip"); ?>:</span>
							<span> <?php echo $view['duration'] ?><?php echo functions::Xmlinformation("Day"); ?></span>
						</div>
						<div class="col-md-6 ">
							<span><?php echo functions::Xmlinformation("Amount"); ?> :</span>
							<span> <?php echo number_format(functions::calcDiscountCodeByFactor($user->total_price_insurance($view['factor_number']), $view['factor_number'])) ?>
								<?php echo functions::Xmlinformation("Rial"); ?> </span>


              <br>
                <?php

                $priceFara = functions::getMemberCreditPayment($view['tracking_code_bank'], $view['total_price'] ) ;
                $credit_price = $priceFara[0];
                $bank_price = $priceFara[1];
                if ($credit_price > 0 ){
                    ?>
                  <br>
                  <span>
                               پرداخت اعتباری : <?php echo  $credit_price ?>
                          </span>
                  <br>
                  <span>
                               پرداخت بانکی :  <?php echo $bank_price ?>
                          </span>
                    <?php
                }
                ?>

						</div>
					</div>
					<div class="row margin-top-10">
						<div class="col-md-12 modal-text-center modal-h">
							<span><?php echo functions::Xmlinformation("Travelerprofile"); ?></span></div>
					</div>
				<?php } ?>

				<div class="row modal-padding-bottom-15">
					<div class="col-md-6 ">
						<span><?php echo functions::Xmlinformation("Namefamily"); ?> :</span>
						<span><?php echo $view['passenger_name'] . ' ' . $view['passenger_family'] ?></span>
					</div>
					<div class="col-md-6 ">
						<span><?php echo functions::Xmlinformation("Passport"); ?>:</span>
						<span><?php echo $view['passport_number'] ?></span>
					</div>
					<div class="col-md-6 ">
						<span><?php echo functions::Xmlinformation("DateOfBirth"); ?>: </span>
						<span dir="rtl"><?php echo (!empty($view['passenger_birth_date'])) ? $view['passenger_birth_date'] : $view['passenger_birth_date_en'] ?></span>
					</div>
					<div class="col-md-6 ">
						<span><?php echo functions::Xmlinformation("GetInsurancePolicy"); ?>:</span>
						<span>
            <?php if ($view['status'] == 'book') { ?>
	            <a href="<?php echo $user->get_insurance_pdf($view['source_name'], $view['pnr']) ?>"
	               target="_blank"><i class="fa fa-print"></i></a>
	            <?php
            } else {
	            echo 'ـــــ';
            }
            ?>
                        </span>
					</div>
				</div>

			<?php } ?>
		</div>
		<div class="modal-footer site-bg-main-color">

		</div>

		<?php
	}
	#endregion

	#region ModalShowInsuranceBook
	public function ModalShowInsuranceBook($Param) {
		$objbook = Load::controller($this->Controller);
		$objDiscountCode = Load::controller('discountCodes');

		$books = $objbook->bookRecordsByFactorNumber($Param);
		?>

		<div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">مشاهده مشخصات بیمه
						&nbsp; <?php echo !empty($books[0]['member_name']) ? 'کاربر اصلی ' : 'کاربرمهمان' ?></h4>
				</div>
				<div class="modal-body">
					<?php
					foreach ($books as $key => $view) {

						if ($key < 1) {
							?>

							<div class="row margin-both-vertical-20">
								<div class="col-md-12 text-center text-bold" style="color: #fb002a;">
									<span>مشخصات کاربر</span></div>
							</div>

							<div class="row margin-both-vertical-20">
								<div class="col-md-4 ">
									<span>نام و نام خانوادگی  : </span>
									<span><?php echo $view['member_name'] ?></span>
								</div>
								<div class="col-md-4 ">
									<span class=""> شماره تلفن موبایل: </span>
									<span class="yn"><?php echo $view['member_mobile'] ?></span>
								</div>
								<div class="col-md-4 ">
									<span>ایمیل :</span>
									<span><?php echo $view['member_email'] ?></span>
								</div>
							</div>

							<hr style="margin: 5px 0;"/>

							<div class="row margin-both-vertical-20">
								<div class="col-md-12 text-center text-bold" style="color: #fb002a;">
									<span>اطلاعات خریدار </span>
								</div>
							</div>

							<div class="row margin-both-vertical-20">
								<div class="col-md-6 ">
									<span>شماره تماس  : </span>
									<span><?php echo $view['mobile_buyer'] ?></span>
								</div>
								<div class="col-md-6 ">
									<span class=""> ایمیل: </span>
									<span class="yn"><?php echo $view['email_buyer'] ?></span>
								</div>
							</div>
							<hr style="margin: 5px 0;"/>

							<div class="row margin-both-vertical-20">
								<div class="col-md-12 text-center text-bold " style="color: #fb002a;">
									<span>مشخصات پرداخت</span>
								</div>
							</div>

							<div class="row margin-both-vertical-20">
								<div class="col-md-4">
									<span class=" pull-left">تاریخ پرداخت : </span>
									<span class="yn"
									      dir="ltr"><?php echo($view['payment_date'] != '0000-00-00 00:00:00' ? functions::set_date_payment($view['payment_date']) : 'پرداخت نشده'); ?></span>
								</div>
								<div class="col-md-4"><span>نوع پرداخت: </span>
									<span><?php
										if ($view['payment_type'] == 'cash') {
											echo 'نقدی';
										} else if ($view['payment_type'] == 'credit' || $view['payment_type'] == 'member_credit') {
											echo 'اعتباری';
										}
										?>  </span>
								</div>

								<div class="col-md-4">
									<span>کد پیگیری بانک: </span>
									<span class="yn"><?php echo !empty($view['tracking_code_bank']) ? $view['tracking_code_bank'] : 'ندارد' ?></span>
								</div>
								<?php if (TYPE_ADMIN == '1' && $view['payment_type'] == 'cash') {
									?>
									<div class="col-md-4">
										<span>نام بانک: </span>
										<span><?php echo $objbook->namebank($view['name_bank_port'], $view['client_id']) ?></span>
									</div>
									<div class="col-md-4">
										<span class="">شماره درگاه: </span>
										<span class="yn"><?php echo $objbook->numberPortBnak($view['name_bank_port'], $view['client_id']) ?></span>
									</div>
									<div class="col-md-4">
										<span>صاحب امتیاز درگاه: </span>
										<span><?php echo $objbook->numberPortBnak($view['name_bank_port'], $view['client_id']) == '379918' ? 'ایران تکنولوژی' : $objbook->nameAgency($view['client_id']) ?></span>
									</div>
								<?php } ?>
							</div>
							<hr style="margin: 5px 0;"/>

							<div class="row margin-both-vertical-20">
								<div class="col-md-12 text-center text-bold " style="color: #fb002a;">
									<span>مشخصات بیمه</span></div>
							</div>
							<div class="row margin-both-vertical-20">

								<div class="col-md-4">
									<span class=" pull-left">تاریخ رزرو بیمه : </span>
									<span class="yn"><?php echo dateTimeSetting::jdate('Y-m-d', $view['creation_date_int']) ?></span>
								</div>
								<div class="col-md-4"><span>شماره فاکتور :</span><span
											class="yn"><?php echo $view['factor_number'] ?></span></div>
								<div class="col-md-4 "><span>مدت :</span><span><?php echo $view['duration']; ?>
										روز </span></div>
							</div>
							<div class="row margin-both-vertical-20">
                <?php if(isset($view['origin']) && !empty($view['origin'])) {  ?>
                <div class="col-md-4 ">
                  <span>مبدا: </span><span><?php echo $view['origin'] ?></span>
                </div>
                <?php  } ?>
								<div class="col-md-4 ">
									<span>مقصد / نوع بیمه: </span><span><?php echo $view['destination'] . ' / ' . $view['source_name_fa'] ?></span>
								</div>
								<div class="col-md-4 "><span
											class=" pull-left">عنوان بیمه:</span><span><?php echo $view['caption'] ?></span>
								</div>
								<div class="col-md-4 ">
									<span class=" pull-left">مبلغ کل:</span>
									<span class="yn"><?php echo number_format($view['totalPriceIncreased']) ?></span>
									ریال
								</div>
							</div>
							<?php
							$discountCodeInfo = $objDiscountCode->getDiscountCodeByFactor($view['factor_number']);
							if (!empty($discountCodeInfo)) {
								?>
								<div class="row margin-both-vertical-20">
									<div class="col-md-4 ">
										<span>کد تخفیف:</span>
										<span class="yn"><?php echo $discountCodeInfo['discountCode']; ?></span>
									</div>
									<div class="col-md-8 ">
										<span>قیمت پس از اعمال کد تخفیف</span>
										<span class="yn"><?php echo number_format($view['totalPriceIncreased'] - $discountCodeInfo['amount']); ?>
											ریال</span>
									</div>
								</div>
							<?php } ?>

							<hr style="margin: 5px 0;"/>

							<div class="row margin-top-10 margin-both-vertical-20">
								<div class="col-md-12 text-center text-bold " style="color: #fb002a;">
									<span>مشخصات مسافرین</span>
								</div>
							</div>
						<?php } ?>

						<div class="row modal-padding-bottom-15 margin-both-vertical-20">
							<div class="col-md-3 ">
								<span>نام و نام خانوادگی:</span>
								<span><?php echo $view['passenger_name'] . ' ' . $view['passenger_family']; ?> </span>
							</div>
							<div class="col-md-2 ">
								<span>پاسپورت:</span>
								<span class="yn"><?php echo $view['passport_number'] ?></span>
							</div>
							<div class="col-md-2 ">
								<span>هزینه:</span>
								<span class="yn"><?php echo number_format($view['totalPriceIncreased']) ?></span>
								ریال
							</div>
							<div class="col-md-2 ">
								<span class=" pull-left">سهم آژانس:</span>
								<span class="yn"><?php echo number_format($view['agency_commission']) ?></span>
							</div>
							<?php if ($view['status'] == 'book') { ?>
                  <?php if (isset($view['pnr']) && !empty($view['pnr'])) { ?>
								  <div class="col-md-2 "><span>کد بیمه:</span><span
											class="yn"><?php echo $view['pnr'] ?></span></div>

                  <div class="col-md-1 "><span>پرینت:</span>
                    <span class="yn text-medium"><a
                          href="<?php echo $objbook->getReservePdf($view['source_name'], $view['pnr']) ?>"
                          target="_blank"><i class="fa fa-print"></i></a></span>
                  </div>
                <?php }else{?>
                  <div class="col-md-2 "><span>خطا در رزرو این بیمه نامه</span></div>
                <?php  }?>
							<?php } ?>
						</div>

					<?php } ?>
					<div class="modal-footer site-bg-main-color">


					</div>
				</div>
			</div>

		</div>

		<?php
	}
	#endregion

	#region ModalShowLogSms
	public function ModalShowLogSms($id, $ClientId) {

		$LogSms = Load::controller($this->Controller);

		$view = $LogSms->viewLog($id, $ClientId);
		?>
		<div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">مشاهده پیام</h4>
				</div>
				<div class="modal-body">

					<div class="row">

						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">

							<div class="form-group col-sm-12 ">

								<label for="message" class="control-label">محتوای پیام</label>
								<textarea name="message" id="message" class="form-control textareaMessage"
								          readonly><?php echo $view['Content']; ?></textarea>
							</div>

						</div>


					</div>

				</div>

				<div class="modal-footer site-bg-main-color">

					<button type="button" class="btn btn-primary  pull-right" data-dismiss="modal">
						بستن
					</button>

				</div>
			</div>
		</div>


		<?php
	}

	#endregion
	#region  editInfoPassenger
 public function editInfoPassenger($id, $ClientId) {
        $TicketInfo = Load::controller($this->Controller);

        $Tickets = $TicketInfo->ShowInfoTicketForInsertPnr($id, $ClientId);
        $airlineList = functions::AirlineList();

        list($gy, $gm, $gd) = explode('-', substr($Tickets[0]['date_flight'],0,10));
        $jalaliDateFlight = dateTimeSetting::gregorian_to_jalali($gy, $gm, $gd, '-');

         $time_flight = $Tickets[0]['time_flight']; // مثلا "14:35:00"
          list($hour, $minute) = explode(':', $time_flight);
        ?>
	      <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header site-bg-main-color">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">ویرایش اطلاعات مسافران</h4>
        </div>
        <form id="EditPassengerForm" name="EditPassengerForm" method="post">
            <input type="hidden" value="EditInfoPassenger" name="flag" id="flag">
            <input type="hidden" value="<?php echo $id ?>" name="RequestNumber" id="RequestNumber">
            <input type="hidden" value="<?php echo $ClientId ?>" name="ClientID" id="ClientID">

            <div class="modal-body">
                <div class="row">
                    <!-- اطلاعات پرواز (یکبار) -->
                   <div class="form-group col-md-3">
                      <label class="right">ساعت پرواز</label>
                      <div class="row">
                         <div class="col-md-4 col-sm-4">
                            <select class="form-control" name="flightMinute" id="flightMinute">
                                <?php for ($m = 0; $m < 60; $m+=5):
                                    $selected = ($m == intval($minute)) ? "selected" : ""; ?>
                                   <option value="<?php echo sprintf('%02d', $m); ?>" <?php echo $selected; ?>>
                                       <?php echo sprintf('%02d', $m); ?>
                                   </option>
                                <?php endfor; ?>
                            </select>
                         </div>
                         <div class="col-md-4 col-sm-4">
                            <select class="form-control" name="flightHour" id="flightHour">
                                <?php for ($h = 0; $h < 24; $h++):
                                    $selected = ($h == intval($hour)) ? "selected" : ""; ?>
                                   <option value="<?php echo sprintf('%02d', $h); ?>" <?php echo $selected; ?>>
                                       <?php echo sprintf('%02d', $h); ?>
                                   </option>
                                <?php endfor; ?>
                            </select>
                         </div>
                      </div>
                   </div>
                    <div class="form-group col-md-3">
                        <label>تاریخ پرواز</label>
                        <input type="text" class="form-control datepicker" value="<?php echo $jalaliDateFlight;?>"
                               name="flightDate" id="flightDate"/>
                    </div>

                   <div class="form-group col-md-4">
                      <label>ایرلاین</label>
                      <select class="form-control select2" name="airline" id="airline">
                         <option value="">انتخاب کنید...</option>
                          <?php
                          $SElectedAirLine = $Tickets[0]["airline_iata"] . '|' . $Tickets[0]["airline_name"];

                          foreach ($airlineList as $airline) {
                              $value = $airline['abbreviation'] . '|' . $airline['name_fa'];
                              $selected = ($value == $SElectedAirLine) ? ' selected' : '';
                              echo '<option value="' . $value . '"' . $selected . '>' . $airline['name_fa'] . '</option>';
                          }
                          ?>
                      </select>
                   </div>
                </div>
               <div class="row">
                   <!-- لیست مسافران -->
                    <?php foreach ($Tickets as $ticket) { ?>
                       <div class="form-group col-md-3 col-lg-3 col-sm-12 col-xs-12">
                          <label>نام (فارسی)</label>
                          <input type="text" class="form-control"
                                 value="<?php echo $ticket['passenger_name'];?>"
                                 name="passengerNameFa[]"
                                 id="passengerNameFa[]"/>
                       </div>

                       <div class="form-group col-md-3 col-lg-3 col-sm-12 col-xs-12">
                          <label>نام خانوادگی (فارسی)</label>
                          <input type="text" class="form-control"
                                 value="<?php echo $ticket['passenger_family'];?>"
                                 name="passengerFamilyFa[]"
                                 id="passengerFamilyFa[]"/>
                       </div>

                       <div class="form-group col-md-3 col-lg-3 col-sm-12 col-xs-12">
                          <label>نام (انگلیسی)</label>
                          <input type="text" class="form-control"
                                 value="<?php echo $ticket['passenger_name_en'];?>"
                                 name="passengerNameEn[]"
                                 id="passengerNameEn[]"/>
                       </div>

                       <div class="form-group col-md-3 col-lg-3 col-sm-12 col-xs-12">
                          <label>نام خانوادگی (انگلیسی)</label>
                          <input type="text" class="form-control"
                                 value="<?php echo $ticket['passenger_family_en'];?>"
                                 name="passengerFamilyEn[]"
                                 id="passengerFamilyEn[]"/>
                       </div>
                       <input type="hidden"
                              value="<?php echo ($ticket['passenger_national_code'] != '0000000000')
                                  ? $ticket['passenger_national_code']
                                  : $ticket['passportNumber']; ?>"
                              name="nationalCode[]" />
                    <?php } ?>

                </div>
            </div>

            <div class="modal-footer site-bg-main-color">
                <button type="button" class="btn btn-primary pull-right" data-dismiss="modal">بستن</button>
                <button type="submit" class="btn btn-success pull-right">ذخیره تغییرات</button>
            </div>
        </form>

        <script type="text/javascript">
            $(document).ready(function () {
                $("#EditPassengerForm").validate({
                    rules: {
                        flightTime: "required",
                        flightDate: "required",
                        airline: "required"
                    },
                    messages: {},
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
                            url: amadeusPath + 'user_ajax.php',
                            type: "post",
                            success: function (response) {
                                var res = response.split(':');
                                if (response.indexOf('Success') > -1) {
                                    $.toast({
                                        heading: 'ویرایش اطلاعات',
                                        text: res[1],
                                        position: 'top-right',
                                        loaderBg: '#fff',
                                        icon: 'success',
                                        hideAfter: 3500,
                                        textAlign: 'right',
                                        stack: 6
                                    });
                                    setTimeout(function () {
                                        $('#ModalPublic').modal('hide');
                                    }, 1000);
                                } else {
                                    $.toast({
                                        heading: 'ویرایش اطلاعات',
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
                    highlight: function (element) {
                        $(element).parents(".form-group").addClass("has-error").removeClass("has-success");
                    },
                    unhighlight: function (element) {
                        $(element).parents(".form-group").addClass("has-success").removeClass("has-error");
                    }
                });
            });
        </script>
    </div>
</div>
    <?php
    }
   #endregion

	#region insertPnr

	public function insertPnr($id, $ClientId) {
		$TicketInfo = Load::controller($this->Controller);

		$Tickets = $TicketInfo->ShowInfoTicketForInsertPnr($id, $ClientId);
		$airlineList = functions::AirlineList();
		?>
		<div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">وارد کردن شماره pnr و بلیط</h4>
				</div>
				<form id="AddPnr" name="AddPnr" method="post">
					<input type="hidden" value="AddPnr" name="flag" id="flag">
					<input type="hidden" value="<?php echo $id ?>" name="RequestNumber" id="RequestNumber">
					<input type="hidden" value="<?php echo $ClientId ?>" name="ClientID" id="ClientID">
					<div class="modal-body">
						<div class="row">
							<div class="form-group col-md-12 col-lg-12 col-sm-12 col-xs-12 ">
								<label>شماره pnr را وارد نمایید</label>
								<input type="text" class="form-control" value="" name="pnr" id="pnr"/>
							</div>

							<div class="form-group col-md-6 col-lg-6 col-sm-12 col-xs-12 ">
								<label>ایرلاین</label>
								<select class="form-control select2" name="airline" id="airline">
									<option value="">انتخاب کنید...</option>
									<?php
                           $SElectedAirLine = $Tickets[0]["airline_iata"] . '|' . $Tickets[0]["airline_name"];

                           foreach ($airlineList as $airline) {
                               $value = $airline['abbreviation'] . '|' . $airline['name_fa'];
                               $selected = ($value == $SElectedAirLine) ? ' selected' : '';
                               echo '<option value="' . $value . '"' . $selected . '>' . $airline['name_fa'] . '</option>';
                           }
									?>
								</select>
							</div>

							<div class="form-group col-md-6 col-lg-6 col-sm-12 col-xs-12 ">
								<label>شماره پرواز</label>
								<input type="text" class="form-control" value="<?php echo $Tickets[0]["flight_number"];?>" name="flightNo" id="flightNo"/>
							</div>

							<div class="form-group col-md-6 col-lg-6 col-sm-12 col-xs-12 ">
								<label>کلاس پرواز</label>
								<input type="text" class="form-control" value="<?php echo $Tickets[0]["cabin_type"];?>" name="flightClass" id="flightClass"/>
							</div>

							<div class="form-group col-md-6 col-lg-6 col-sm-12 col-xs-12 ">
								<label>ساعت پرواز</label>
								<input type="text" class="form-control" value="<?php echo $Tickets[0]["time_flight"];?>" name="flightTime" id="flightTime"/>
							</div>

							<?php foreach ($Tickets as $ticket) { ?>
								<div class="form-group col-md-4 col-lg-4 col-sm-12 col-xs-12 ">

									<?php echo $ticket['passenger_name'] . ' ' . $ticket['passenger_family'] ?>

								</div>
								<div class="form-group col-md-4 col-lg-4 col-sm-12 col-xs-12 ">

									<input type="text" class="form-control"
									       value="<?php echo ($ticket['passenger_national_code'] != '0000000000') ? $ticket['passenger_national_code'] : $ticket['passportNumber'] ?>"
									       name="nationalCode[]"
									       id="nationalCode[]" readonly="readonly"/>
								</div>

								<div class="form-group col-md-4 col-lg-4 col-sm-12 col-xs-12 ">
									<input type="text" class="form-control" value=""
									       name="eTicketNumber[]"
									       id="eTicketNumber[]" placeholder="شماره بلیط را وارد کنید"/>
								</div>
							<?php } ?>

						</div>


					</div>

					<div class="modal-footer site-bg-main-color">

						<button type="button" class="btn btn-primary  pull-right" data-dismiss="modal">بستن</button>
						<button type="submit" class="btn btn-success pull-right">ارسال اطلاعات</button>


					</div>
				</form>

				<script type="text/javascript">
                    $(document).ready(function () {
                        $("#AddPnr").validate({
                            rules: {
                                pnr: "required"
                            },
                            messages: {},
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
                                    url: amadeusPath + 'user_ajax.php',
                                    type: "post",
                                    success: function (response) {
                                        var res = response.split(':');

                                        if (response.indexOf('Success') > -1) {
                                            $.toast({
                                                heading: 'افزودن pnr ',
                                                text: res[1],
                                                position: 'top-right',
                                                loaderBg: '#fff',
                                                icon: 'success',
                                                hideAfter: 3500,
                                                textAlign: 'right',
                                                stack: 6
                                            });

                                            setTimeout(function () {
                                                $('#ModalPublic').modal('hide');
                                            }, 1000);


                                        } else {

                                            $.toast({
                                                heading: 'افزودن  pnr',
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
                    })

				</script>
			</div>
		</div>


		<?php
	}

	#endregion


		#region insertPnr

	public function insertHotelPnr($requestNumber, $ClientId) {

		$HotelInfo = Load::controller($this->Controller);
		$hotels = $HotelInfo->ShowHotelInfoInsertPnr($requestNumber, $ClientId);

		?>
		<div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">وارد کردن شماره pnr و واچر</h4>
				</div>
				<form id="AddHotelPnr" name="AddHotelPnr" method="post">
					<input type="hidden" value="AddHotelPnr" name="flag" id="flag">
					<input type="hidden" value="<?php echo $requestNumber ?>" name="RequestNumber" id="RequestNumber">
					<input type="hidden" value="<?php echo $ClientId ?>" name="ClientID" id="ClientID">
					<div class="modal-body">
						<div class="row">
							<div class="form-group col-md-6 col-lg-6 col-sm-12 col-xs-12 ">
								<label>شماره pnr را وارد نمایید</label>
								<input type="text" class="form-control" value="" name="pnr" id="pnr"/>
							</div>
							<div class="form-group col-md-6 col-lg-6 col-sm-12 col-xs-12 ">
								<label>شماره واچر</label>
								<input type="text" class="form-control" value="" name="voucher_No" id="voucher_No"/>
							</div>
						</div>
					</div>

					<div class="modal-footer site-bg-main-color">

						<button type="button" class="btn btn-primary  pull-right" data-dismiss="modal">بستن</button>
						<button type="submit" class="btn btn-success pull-right">ارسال اطلاعات</button>


					</div>
				</form>

				<script type="text/javascript">
                    $(document).ready(function () {
                        $("#AddHotelPnr").validate({
                            rules: {
                                pnr: "required"
                            },
                            messages: {},
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
                                    url: amadeusPath + 'user_ajax.php',
                                    type: "post",
                                    success: function (response) {
                                        var res = response.split(':');

                                        if (response.indexOf('Success') > -1) {
                                            $.toast({
                                                heading: 'افزودن pnr ',
                                                text: res[1],
                                                position: 'top-right',
                                                loaderBg: '#fff',
                                                icon: 'success',
                                                hideAfter: 3500,
                                                textAlign: 'right',
                                                stack: 6
                                            });

                                            setTimeout(function () {
                                                $('#ModalPublic').modal('hide');
                                            }, 1000);


                                        } else {

                                            $.toast({
                                                heading: 'افزودن  pnr',
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
                    })

				</script>
			</div>
		</div>


		<?php
	}

	#endregion


    #region changePendingHotel

    public function changePendingHotel($factorNumber, $ClientId) {

        $HotelInfo = Load::controller($this->Controller);
        $hotels = $HotelInfo->ShowPendingHotelByFactorNumber($factorNumber, $ClientId);

        ?>
      <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header site-bg-main-color">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">در صورت پرداخت قطعی این رزرو شماره واچر را وارد کنید.</h4>
          </div>
          <form id="bookPendingHotel" name="bookPendingHotel" method="post">
            <input type="hidden" value="bookPendingHotel" name="flag" id="flag">
            <input type="hidden" value="<?php echo $factorNumber ?>" name="factorNumber" id="factorNumber">
            <input type="hidden" value="<?php echo $ClientId ?>" name="ClientID" id="ClientID">
            <div class="modal-body">
              <div class="row">
                <div class="form-group col-md-6 col-lg-6 col-sm-12 col-xs-12 ">
                  <label>شماره pnr را وارد نمایید</label>
                  <input type="text" class="form-control" value="" name="pnr" id="pnr"/>
                </div>
              </div>
            </div>

            <div class="modal-footer site-bg-main-color">

              <button type="button" class="btn btn-primary  pull-right" data-dismiss="modal">بستن</button>
              <button type="submit" class="btn btn-success pull-right">ارسال اطلاعات</button>


            </div>
          </form>

          <script type="text/javascript">
            $(document).ready(function () {
              $("#bookPendingHotel").validate({
                rules: {
                  pnr: "required"
                },
                messages: {},
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
                    url: amadeusPath + 'user_ajax.php',
                    type: "post",
                    success: function (response) {
                      var res = response.split(':');

                      if (response.indexOf('Success') > -1) {
                        $.toast({
                          heading: 'افزودن pnr ',
                          text: res[1],
                          position: 'top-right',
                          loaderBg: '#fff',
                          icon: 'success',
                          hideAfter: 3500,
                          textAlign: 'right',
                          stack: 6
                        });

                        setTimeout(function () {
                          $('#ModalPublic').modal('hide');
                        }, 1000);


                      } else {

                        $.toast({
                          heading: 'افزودن  pnr',
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
            })

          </script>
        </div>
      </div>


        <?php
    }

    #endregion
	#region FlightCreditToBook

	public function FlightConvertToBook($id, $ClientId) {
		$TicketInfo = Load::controller($this->Controller);

		$Tickets = $TicketInfo->ShowInfoTicketForInsertPnr($id, $ClientId);
		$airlineList = functions::AirlineList();
		?>
		<div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">وارد کردن شماره pnr و بلیط</h4>
				</div>
				<form id="convertToBook" name="convertToBook" method="post">
					<input type="hidden" value="convertToBook" name="flag" id="flag">
					<input type="hidden" value="<?php echo $id ?>" name="RequestNumber" id="RequestNumber">
					<input type="hidden" value="<?php echo $ClientId ?>" name="ClientID" id="ClientID">
					<div class="modal-body">
						<div class="row">
							<div class="form-group col-md-12 col-lg-12 col-sm-12 col-xs-12 ">
								<label>شماره pnr را وارد نمایید</label>
								<input type="text" class="form-control" value="" name="pnr" id="pnr"/>
							</div>

							<?php foreach ($Tickets as $ticket) { ?>
								<div class="form-group col-md-4 col-lg-4 col-sm-12 col-xs-12 ">

									<?php echo $ticket['passenger_name'] . ' ' . $ticket['passenger_family'] ?>

								</div>
								<div class="form-group col-md-4 col-lg-4 col-sm-12 col-xs-12 ">

									<input type="text" class="form-control"
									       value="<?php echo ($ticket['passenger_national_code'] != '0000000000') ? $ticket['passenger_national_code'] : $ticket['passportNumber'] ?>"
									       name="nationalCode[]"
									       id="nationalCode[]" readonly="readonly"/>
								</div>

								<div class="form-group col-md-4 col-lg-4 col-sm-12 col-xs-12 ">

									<input type="text" class="form-control" value="<?php ?>"
									       name="eTicketNumber[]"
									       id="eTicketNumber[]" placeholder="شماره بلیط را وارد کنید"/>
								</div>
							<?php } ?>

						</div>


					</div>

					<div class="modal-footer site-bg-main-color">

						<button type="button" class="btn btn-primary  pull-right" data-dismiss="modal">بستن</button>
						<button type="submit" class="btn btn-success pull-right">ارسال اطلاعات</button>


					</div>
				</form>

				<script type="text/javascript">
                    $(document).ready(function () {
                        $("#convertToBook").validate({
                            rules: {
                                pnr: "required"
                            },
                            messages: {},
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
                                    url: amadeusPath + 'user_ajax.php',
                                    type: "post",
                                    success: function (response) {
                                        var res = response.split(':');

                                        if (response.indexOf('Success') > -1) {
                                            $.toast({
                                                heading: 'افزودن pnr ',
                                                text: res[1],
                                                position: 'top-right',
                                                loaderBg: '#fff',
                                                icon: 'success',
                                                hideAfter: 3500,
                                                textAlign: 'right',
                                                stack: 6
                                            });

                                            setTimeout(function () {
                                                $('#ModalPublic').modal('hide');
                                            }, 1000);


                                        } else {

                                            $.toast({
                                                heading: 'افزودن  pnr',
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
                    })

				</script>
			</div>
		</div>


		<?php
	}

	#endregion
	#region ModalSendEmailForOther

	public function ModalSenEmailForOther($Param, $ClientID) {
		?>
		<div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">ارسال ایمیل بلیط برای دیگران</h4>
				</div>
				<form method="post" id="SendEmailForOtherModal" name="SendEmailForOtherModal">
					<input type="hidden" name="flag" value="SendEmailForOther">
					<input type="hidden" name="request_number" value="<?php echo $Param ?>">
					<input type="hidden" name="ClientID" value="<?php echo $ClientID ?>">
					<div class="modal-body">

						<div class="row">

							<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
								<div class="form-group">
									<label for="Reason">ایمیل گیرنده</label>
									<input type="text" class="form-control" name="email" id="email">
								</div>
							</div>

						</div>

					</div>

					<div class="modal-footer site-bg-main-color">

						<button type="button" class="btn btn-primary  pull-right" data-dismiss="modal">بستن</button>
						<button type="submit" class="btn btn-success pull-right">ارسال اطلاعات</button>

					</div>

				</form>
				<script type="text/javascript">
                    $("#SendEmailForOtherModal").validate({
                        rules: {
                            email: {
                                required: true,
                                email: true
                            }
                        },
                        messages: {},
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
                                url: amadeusPath + 'user_ajax.php',
                                type: "post",
                                success: function (response) {
                                    var res = response.split(':');

                                    if (response.indexOf('success') > -1) {
                                        $.toast({
                                            heading: 'ارسال ایمیل به دیگران',
                                            text: res[res.length - 1],
                                            position: 'top-right',
                                            loaderBg: '#fff',
                                            icon: 'success',
                                            hideAfter: 3500,
                                            textAlign: 'right',
                                            stack: 6
                                        });

                                        setTimeout(function () {
                                            $('#ModalPublic').modal('hide');
                                        }, 1000);


                                    } else {

                                        $.toast({
                                            heading: 'ارسال ایمیل به دیگران',
                                            text: res[res.length - 1],
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
				</script>
			</div>
		</div>

		</div>

		<?php
	}
	#endregion

	#region ModalShowVisa
	public function ModalShowVisa($Param) {
		$user = Load::controller($this->Controller);
		$records = $user->info_visa_client($Param);

		?>

		<div class="modal-header site-bg-main-color">
			<span class="close" onclick="modalClose('')">&times;</span>
			<h2><?php echo functions::Xmlinformation("ViewPurchaseInvoiceNumber"); ?>
				:<?php echo $Param; ?> </h2>
		</div>
		<div class="modal-body">
			<?php
			foreach ($records as $key => $view) {
				if ($key < 1) {
					?>
					<div class="row margin-both-vertical-20">
						<div class="col-md-12 modal-text-center modal-h">
							<span><?php echo functions::Xmlinformation("Specifications"); ?><?php echo $view['visa_title']; ?></span>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4 ">
							<span><?php echo functions::Xmlinformation("Date"); ?> <?php echo $view['payment_type'] == 'cash' ? functions::Xmlinformation("Payment") : functions::Xmlinformation("Buy"); ?>
								: </span>
							<span dir="ltr"><?php echo $view['payment_date'] != '0000-00-00 00:00:00' ? functions::set_date_payment($view['payment_date']) : functions::Xmlinformation("Unpaid"); ?></span>
						</div>
						<div class="col-md-4 ">
							<span dir="rtl"><?php echo functions::Xmlinformation("DateVisaReservation"); ?> : </span>
							<span style=''><?php echo $user->set_date_reserve(substr($view['creation_date'], 0, 10)) ?></span>
						</div>
						<div class="col-md-4 ">
							<span><?php echo functions::Xmlinformation("NumberPurchases"); ?>:</span>
							<span style=''><?php echo $user->count; ?></span>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 ">
							<span><?php echo functions::Xmlinformation("Destination"); ?>: </span>
							<span><?php echo $view['visa_destination'] ?></span>
						</div>
						<div class="col-md-4 ">
							<span><?php echo functions::Xmlinformation("Type"); ?>:</span>
							<span style=''><?php echo $view['visa_type'] ?></span>
						</div>
						<div class="col-md-4 ">
							<span><?php echo functions::Xmlinformation("DeliveryTime"); ?>:</span>
							<span> <?php echo $view['visa_deadline'] ?></span>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 ">
							<span><?php echo functions::Xmlinformation("ValidityDuration"); ?>:</span>
							<span> <?php echo $view['visa_validity_duration'] ?></span>
						</div>
						<div class="col-md-4 ">
							<span><?php echo functions::Xmlinformation("Countenter"); ?>:</span>
							<span> <?php echo $view['visa_allowed_use_no'] ?> بار</span></div>
						<div class="col-md-4 ">
							<span><?php echo functions::Xmlinformation("Amount"); ?> :</span>
							<span> <?php echo number_format(functions::calcDiscountCodeByFactor($view['total_price'], $view['factor_number'])) ?>
								<?php echo functions::Xmlinformation("Rial"); ?></span>
						</div>
					</div>
					<div class="row margin-top-10">
						<div class="col-md-12 modal-text-center modal-h">
							<span><?php echo functions::Xmlinformation("Travelerprofile"); ?></span></div>
					</div>
				<?php } ?>

				<div class="row modal-padding-bottom-15">
					<div class="col-md-3 ">
						<span><?php echo functions::Xmlinformation("Namefamily"); ?> :</span>
						<span><?php echo $view['passenger_name'] . ' ' . $view['passenger_family'] ?></span>
					</div>
					<div class="col-md-3 ">
						<span><?php echo functions::Xmlinformation("Passport"); ?>:</span>
						<span><?php echo $view['passport_number'] ?></span>
					</div>
					<div class="col-md-3 ">
						<span><?php echo functions::Xmlinformation("DateOfBirth"); ?>: </span>
						<span dir="rtl"><?php echo (!empty($view['passenger_birthday'])) ? $view['passenger_birthday'] : $view['passenger_birthday_en'] ?></span>
					</div>
					<div class="col-md-3 ">
						<span><?php echo functions::Xmlinformation("GetWatcher"); ?>:</span>
						<span>
                            <?php if ($view['status'] == 'book') { ?>
	                            <a href="<?php echo ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=bookingVisa&id=' . $view['unique_code'] ?>"
	                               target="_blank"><i class="fa fa-print"></i></a>
	                            <?php
                            } else {
	                            echo 'ـــــ';
                            }
                            ?>
                            <a href="<?php echo ROOT_ADDRESS . '/visaDetailReview&factor_number=' . $view['factor_number'] ?>"
	                               target="_blank"><i class="fa fa-list"></i></a>
                        </span>
					</div>
				</div>

			<?php } ?>
		</div>
		<div class="modal-footer site-bg-main-color">

		</div>

		<?php
	}
	#endregion

	#region ModalShowVisaBook
	public function ModalShowVisaBook($Param) {
		$objbook = Load::controller($this->Controller);
		$objDiscountCode = Load::controller('discountCodes');
		$books = $objbook->bookRecords($Param);
       functions::insertLog('$books: ' . json_encode($Param) , '000shojaee');

       ?>

		<div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">مشاهده مشخصات ویزا
						&nbsp; <?php echo !empty($books[0]['member_name']) ? 'کاربر اصلی ' : 'کاربرمهمان' ?></h4>
				</div>
				<div class="modal-body">
					<?php
					foreach ($books as $key => $view) {

						if ($key < 1) {
							?>

							<div class="row margin-both-vertical-20">
								<div class="col-md-12 text-center text-bold" style="color: #fb002a;">
									<span>مشخصات کاربر</span></div>
							</div>

							<div class="row margin-both-vertical-20">
								<div class="col-md-4 ">
									<span>نام و نام خانوادگی  : </span>
									<span><?php echo $view['member_name'] ?></span>
								</div>
								<div class="col-md-4 ">
									<span class=""> شماره تلفن موبایل: </span>
									<span class="yn"><?php echo $view['member_mobile'] ?></span>
								</div>
								<div class="col-md-4 ">
									<span>ایمیل :</span>
									<span><?php echo $view['member_email'] ?></span>
								</div>

							</div>

							<hr style="margin: 5px 0;"/>

							<div class="row margin-both-vertical-20">
								<div class="col-md-12 text-center text-bold" style="color: #fb002a;">
									<span>اطلاعات خریدار </span>
								</div>
							</div>

							<div class="row margin-both-vertical-20">
								<div class="col-md-6 ">
									<span>شماره تماس  : </span>
									<span><?php echo $view['mobile_buyer'] ?></span>
								</div>
								<div class="col-md-6 ">
									<span class=""> ایمیل: </span>
									<span class="yn"><?php echo $view['email_buyer'] ?></span>
								</div>
							</div>
							<hr style="margin: 5px 0;"/>

							<div class="row margin-both-vertical-20">
								<div class="col-md-12 text-center text-bold " style="color: #fb002a;">
									<span>مشخصات پرداخت</span>
								</div>
							</div>

							<div class="row margin-both-vertical-20">
								<div class="col-md-4">
									<span class=" pull-left">تاریخ پرداخت: </span>
									<span class="yn"
									      dir="ltr"><?php echo($view['payment_date'] != '0000-00-00 00:00:00' ? functions::set_date_payment($view['payment_date']) : 'پرداخت نشده'); ?></span>
								</div>
								<div class="col-md-4"><span>نوع پرداخت: </span>
									<span><?php
										if ($view['payment_type'] == 'cash') {
											echo 'نقدی';
										} else if ($view['payment_type'] == 'credit' || $view['payment_type'] == 'member_credit') {
											echo 'اعتباری';
										}
										 else if ($view['status']=='book') {
											echo 'بدون پرداخت ( حالت رزرو )';
										}
										?>  </span>
								</div>

								<div class="col-md-4">
									<span>کد پیگیری بانک: </span>
									<span class="yn"><?php echo !empty($view['tracking_code_bank']) ? $view['tracking_code_bank'] : 'ندارد' ?></span>
								</div>
								<?php if (TYPE_ADMIN == '1' && $view['payment_type'] == 'cash') {
									?>
									<div class="col-md-4">
										<span>نام بانک: </span>
										<span><?php echo $objbook->namebank($view['name_bank_port'], $view['client_id']) ?></span>
									</div>
									<div class="col-md-4">
										<span class="">شماره درگاه: </span>
										<span class="yn"><?php echo $objbook->numberPortBnak($view['name_bank_port'], $view['client_id']) ?></span>
									</div>
									<div class="col-md-4">
										<span>صاحب امتیاز درگاه: </span>
										<span><?php echo $objbook->numberPortBnak($view['name_bank_port'], $view['client_id']) == '379918' ? 'ایران تکنولوژی' : $objbook->nameAgency($view['client_id']) ?></span>
									</div>
								<?php } ?>
							</div>
							<hr style="margin: 5px 0;"/>

							<div class="row margin-both-vertical-20">
								<div class="col-md-12 text-center text-bold " style="color: #fb002a;">
									<span>مشخصات ویزا</span>
								</div>
							</div>
							<div class="row margin-both-vertical-20">

								<div class="col-md-4">
									<span class=" pull-left">تاریخ رزرو ویزا: </span>
									<span class="yn"><?php echo dateTimeSetting::jdate('Y-m-d', $view['creation_date_int']) ?></span>
								</div>
								<div class="col-md-4">
									<span>شماره فاکتور: </span>
									<span class="yn"><?php echo $view['factor_number'] ?></span>
								</div>
								<div class="col-md-4 ">
									<span>تعداد: </span>
									<span><?php echo $bookCount = count($books); ?> نفر</span>
								</div>
							</div>
							<div class="row margin-both-vertical-20">
								<div class="col-md-4 ">
									<span class=" pull-left">عنوان ویزا: </span><span><?php echo $view['visa_title'] ?></span>
								</div>
								<div class="col-md-4 ">
									<span>نوع ویزا: </span><span><?php echo $view['visa_type'] ?></span>
								</div>
								<div class="col-md-4 ">
									<span>مقصد: </span><span><?php echo $view['visa_destination'] ?></span>
								</div>
							</div>
							<div class="row margin-both-vertical-20">
								<div class="col-md-4 ">
									<span class=" pull-left">زمان تحویل: </span><span><?php echo $view['visa_deadline'] ?></span>
								</div>
								<div class="col-md-4 ">
									<span>مدت اعتبار: </span><span><?php echo $view['visa_validity_duration'] ?></span>
								</div>
								<div class="col-md-4 ">
									<span>تعداد ورود: </span><span><?php echo $view['visa_allowed_use_no'] ?></span>
								</div>
							</div>
							<div class="row margin-both-vertical-20">
								<div class="col-md-4 ">
									<span class=" pull-left">مبلغ کل:</span>
									<span class="yn"><?php echo number_format($view['total_price']) ?></span> ریال
								</div>
								<div class="col-md-4 ">
									<span class=" pull-left">مجموع پیش پرداخت:</span>
									<span class="yn"><?php echo number_format($view['visa_prepayment_cost'] * $bookCount) ?></span>
									ریال
								</div>
								<div class="col-md-4 ">
									<span class=" pull-left">مجموع مانده:</span>
									<span class="yn"><?php echo number_format($view['total_price'] - ($view['visa_prepayment_cost'] * $bookCount)) ?></span>
									ریال
								</div>
							</div>
							<?php
							$discountCodeInfo = $objDiscountCode->getDiscountCodeByFactor($view['factor_number']);
							if (!empty($discountCodeInfo)) {
								?>
								<div class="row margin-both-vertical-20">
									<div class="col-md-4 ">
										<span>کد تخفیف:</span>
										<span class="yn"><?php echo $discountCodeInfo['discountCode']; ?></span>
									</div>
									<div class="col-md-8 ">
										<span>قیمت پس از اعمال کد تخفیف</span>
										<span class="yn"><?php echo number_format($view['visa_prepayment_cost'] - $discountCodeInfo['amount']); ?>
											ریال</span>
									</div>
								</div>
							<?php } ?>

							<hr style="margin: 5px 0;"/>

							<div class="row margin-top-10 margin-both-vertical-20">
								<div class="col-md-12 text-center text-bold " style="color: #fb002a;">
									<span>مشخصات مسافرین</span>
								</div>
							</div>
						<?php } ?>

						<div class="row modal-padding-bottom-15 margin-both-vertical-20">
							<div class="col-md-3 ">
								<span>نام و نام خانوادگی:</span>
								<span><?php echo $view['passenger_name_en'] . ' ' . $view['passenger_family_en']; ?> </span>
							</div>
							<div class="col-md-2 ">
								<span>پاسپورت:</span>
								<span class="yn"><?php echo $view['passport_number'] ?></span>
							</div>

								<div class="col-md-2 ">
									<span>ملیت :</span>
									<span class="yn"><?php
									if($view['passenger_country']){
                                        echo functions::country_code($view['passenger_country'],'fa');

									}else{
                                        echo 'ایران';
									} ?>
									</span>
								</div>


							<div class="col-md-2 ">
								<span>مبلغ:</span>
								<span class="yn"><?php echo number_format($discountedPrice = $view['visa_main_cost'] - ($view['visa_main_cost'] * ($view['percent_discount'] / 100))) ?></span>
							</div>
							<div class="col-md-2 ">
								<span class=" pull-left">پیش پرداخت:</span>
								<span class="yn"><?php echo number_format($view['visa_prepayment_cost']) ?></span>
							</div>
							<?php if ($view['status'] == 'book') { ?>
								<div class="col-md-2 ">
									<span>مانده:</span>
									<span class="yn"><?php echo number_format($discountedPrice - $view['visa_prepayment_cost']) ?></span>
								</div>
								<div class="col-md-1 ">
									<span>پرینت:</span>
									<span class="yn"><a
												href="<?php echo ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=bookingVisa&id=' . $view['unique_code']; ?>"
												target="_blank"><i class="fa fa-print"></i></a>
                                    </span>
								</div>
							<?php } ?>

							<div class="col-md-1 ">
									<span>پرینت فایل ها:</span>
									<span class="yn"><a
												href="<?php echo ROOT_ADDRESS . '/visaDetailReview&factor_number=' . $view['factor_number']; ?>"
												target="_blank"><i class="fa fa-table"></i></a>
                                    </span>
								</div>


						</div>


						<div class="col-md-12 p-0 mt-5">
                            <?php


                            $custom_file_fields=json_decode($view['custom_file_fields'],true);
                                if (!empty($custom_file_fields)){
                                    foreach ($custom_file_fields as $item){

                                        ?>
                                        <div class="col-md-3">
                                        <?php if(!empty(array_values($item)[0])) {

                                         ?>
                                            <a id="downloadLink" target="_blank"
                                               class="d-flex flex-wrap justify-content-center"
                                               href="<?php echo ROOT_ADDRESS_WITHOUT_LANG .'/pic/visaPassengersFiles/' . array_values($item)[0]; ?>"
                                               type="application/octet-stream">
                                                <img src="<?php echo ROOT_ADDRESS_WITHOUT_LANG .'/pic/visaPassengersFiles/' . array_values($item)[0]; ?>"
                                                     class="w-100 p-3 mb-3 border rounded"
                                                     alt="<?php echo key($item);?>">
                                                <?php echo key($item);?><i class="fa mr-2 fa-download"></i>
                                            </a>

                                            <?php } ?>

                                        <div class="d-none">
                                            <label for="awdawd"><?php echo key($item).$key;?></label>
                                            <input id="<?php echo key($item).$key; ?>" type="file">
                                            <button onclick="updateVisaCustomFileFields('<?php echo key($item).$key;?>','<?php echo $view['factor_number'];?>','<?php echo key($item);?>','<?php echo $key;?>')"
                                             class="btn btn-info">
                                                 Upload
                                             </button>
                                        </div>

                                        </div>
                                        <?php
                                    }
                                }
                            ?>

                        </div>
                        <div class="col-md-12 p-0 mt-5 d-flex flex-wrap justify-content-center">

  <?php if(!empty($view['visa_files'])) {

                                         ?>
                                           <div class="col-md-3 p-0 mt-5 ">
                                            <a id="downloadLink" target="_blank"
                                               class="d-flex flex-wrap justify-content-center"
                                               href="<?php echo ROOT_ADDRESS_WITHOUT_LANG .'/pic/visaPassengersFiles/' . $view['visa_files']; ?>"
                                               type="application/octet-stream">
                                                <img src="<?php echo ROOT_ADDRESS_WITHOUT_LANG .'/pic/visaPassengersFiles/' . $view['visa_files']; ?>"
                                                     class="w-100 p-3 mb-3 border rounded"
                                                     alt="visa_files">
                                                فایل ویزا
                                                <i class="fa mr-2 fa-download"></i>
                                            </a>
                                            </div>

                                            <?php } ?>

                            <div class="col-md-12 p-0 mt-5 mb-5 ">
                                    <label for="visa_files<?php echo $key;?>">آپلود فایل ویزا</label>
                                    <input id="visa_files<?php echo $key;?>" type="file">
                                    <button onclick="updateVisaFiles('visa_files<?php echo $key;?>','<?php echo $view['factor_number'];?>','<?php echo $key;?>')"
                                         class="btn btn-info">
                                         Upload
                                     </button>

                            </div>
                        </div>



						<?php
/*						 if(!empty($view['passengers_file'])){
						 $passengers_files=json_decode($view['passengers_file'], true); */?><!--
                        <div class="row modal-padding-bottom-15 margin-both-vertical-20">
                        <?php /*foreach($passengers_files as $file){ */?>

							<div class="col-md-2 d-flex flex-wrap justify-content-center align-items-center">
                                <div class="w-100 p-4">
                                    <img class="w-100 p-2 rounded border border-secondary" src="<?php /*echo ROOT_ADDRESS_WITHOUT_LANG.'/pic/visaPassengersFiles/'.$file; */?>" alt="<?php /*echo $file; */?>">
                                </div>
								<a target="_blank" href="<?php /*echo ROOT_ADDRESS_WITHOUT_LANG.'/pic/visaPassengersFiles/'.$file; */?>">
								<span class="w-100 text-center">
								<?php /*echo $file; */?>
								</span>
								</a>
							</div>

							<?php /*}} */?>

                        </div>
                        <hr>-->
					<?php } ?>
					<div class="modal-footer site-bg-main-color">


					</div>
				</div>
			</div>

		</div>

		<?php
	}
	#endregion

	#region modalRequestOffline

	public function RequestOffline($Param) {

		$InfoRequestOffline = json_decode($Param, true);

		?>

		<div class="modal-header site-bg-main-color" style="display: block !important;">
			<span class="close" onclick="modalClose()">&times;</span>
			<h2><?php echo functions::Xmlinformation("RequestSMSFlightBooking"); ?></h2>
		</div>
		<div class="modal-body">
			<div class="row modal-padding-bottom-15 " style="display: block !important;">
				<div class="row" style="display: block !important;">
					<div class="col-md-12 modal-text-center modal-h " style="display: block !important;">
						<?php echo functions::Xmlinformation("FlightSentCoordinateSupportViaSMS"); ?>
					</div>
					<?php $InfoAirline = functions::InfoAirline($InfoRequestOffline['Airline']); ?>
					<label for="ReasonUser"
					       style="margin: 25px"><?php echo functions::Xmlinformation("Flight"); ?><?php echo functions::NameCity($InfoRequestOffline['Origin']) ?>
						<?php echo functions::Xmlinformation("On"); ?>
						<?php echo functions::NameCity($InfoRequestOffline['Destination']) ?>
						<?php echo functions::Xmlinformation("Airline"); ?>
						<?php echo $InfoAirline['name_fa'] ?>
						<?php echo functions::NameCity($InfoRequestOffline['ToFlightNumber']) ?>
						<?php echo $InfoRequestOffline['FlightNo'] ?>
						<?php echo functions::NameCity($InfoRequestOffline['WithRateID']) ?>
						<?php echo $InfoRequestOffline['CabinType'] ?>
						<?php echo functions::NameCity($InfoRequestOffline['Indate']) ?>
						<?php echo $InfoRequestOffline['DepartureDate'] ?>
						<?php echo functions::NameCity($InfoRequestOffline['Hour']) ?>
						<?php echo $InfoRequestOffline['DepartureTime'] ?>
					</label>
				</div>

				<div class="row" style="display: block !important;">
					<input type="hidden" name="InfoFlightRequest" id="InfoFlightRequest" value='<?php echo $Param ?>'>
					<input type="hidden" name="IsLogin" id="IsLogin"
					       value='<?php echo Session::IsLogin() ? '1' : '0' ?>'>
					<div class="col-md-12 modal-text-center modal-h " style="display: block !important;">
						<label for="ReasonUser"><?php echo functions::NameCity($InfoRequestOffline['EnterYourProfile']) ?></label>
					</div>
					<div class="col-md-5 col-lg-5 col-sm-12 col-xs-12 nopad  " style="direction: rtl; margin-left: 5px">
						<label style="float:right;"><?php echo functions::NameCity($InfoRequestOffline['Namefamily']) ?></label>
						<input class="form-control " type="text" id="fullName" name="fullName"
						       style="float: right;margin-right: 10px"
						       value="<?php echo Session::IsLogin() ? Session::getNameUser() : '' ?>">
					</div>

					<div class="col-md-5 col-lg-5 col-sm-12 col-xs-12 nopad  " style="direction: rtl;">
						<label style="float:right;"><?php echo functions::NameCity($InfoRequestOffline['MobilePhoneNumber']) ?></label>
						<input class="form-control " type="text" id="mobile" name="mobile"
						       style="float: right;margin-right: 10px">
					</div>

				</div>

			</div>

		</div>
		</div>
		<div class="modal-footer site-bg-main-color">
			<div class="col-md-12" style="text-align:left;">
				<input class="close btn btn-primary btn-send-information" onclick="SendSmsRequestOffline()"
				       type="button"
				       value="Sendinformation">

			</div>
		</div>

		<?php
	}

	#endregion


	#region ModalShowInfoPid

	public function ModalShowInfoPid($Param) {


		$InfoPid = Load::controller($this->Controller);

		$Result = $InfoPid->InfoPid($Param);

		?>
		<div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">مشاهده وضعیت پید های اختصاصی </h4>
				</div>
				<div class="modal-body">
					<div class="row padding-left-10 padding-right-10">
						<table class="table full-color-table full-success-table hover-table">
							<thead>
							<tr>
								<th>ردیف</th>
								<th>کد</th>
								<th>نام ایرلاین</th>
								<th>وضعیت</th>
								<th>اعتبار</th>
								<th>نام نرم افزار</th>
							</tr>
							</thead>
							<tbody>
							<?php
							if (empty($Result['error'])):
								foreach ($Result['data'][0]['sources'] as $key => $item) :
									$Airline = functions::InfoAirline($item['label']);
									?>
									<tr>
										<td><?php echo $key + 1; ?></td>
										<td><?php echo $item['source_agency_id']; ?></td>
										<td><?php echo $Airline['name_fa'] ?></td>
										<td><?php echo $item['text'] ?></td>
										<td><?php echo strlen($item['credit']) > 3 ? $item['credit'] . ' ' . 'ریال' : $item['credit'] . ' ' . 'تیکت' ?></td>
										<td><?php echo $item['source_software_name'] ?></td>
									</tr>
									<?php
								endforeach;
							else:
								?>
								<tr>
									<td colspan="3" class="text-center">اطلاعاتی وجود ندارد</td>
								</tr>
							<?php endif; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>


		<?php

	}

	public function ModalShowindexActiveRobot($Param) {


		$InfoPid = Load::controller($this->Controller);

		$Result = $InfoPid->indexActiveRobot($Param);

		?>
		<div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">مشاهده ربات های فعال </h4>
				</div>

				<div class="modal-body">
					<div class="row padding-left-10 padding-right-10">
						<table class="table full-color-table full-success-table hover-table">
							<thead>
							<tr>
								<th>ردیف</th>
								<th>نام ربات</th>
								<th> توکن ربات</th>

								<th> عملیات</th>
							</tr>
							</thead>


							<?php

							if ($Result["error"] != "NoData") {

								foreach ($Result as $key => $item) :


									?>

									<tbody>
									<tr>

										<td><?php echo $key + 1 ?></td>
										<td><?php echo $item['username']; ?></td>
										<td><?php echo $item['api_token'] ?></td>

										<td>
											<a class="btn btn-primary" onclick="SendRobot(<?php echo $item['id'] ?>)">
												ارسال اطلاعات</a>
											<input type="hidden" value="<?php echo $item['id'] ?>">

										</td>
									</tr>
									</tbody>
									<?php


								endforeach;
							} else {


								?>
								<tbody>
								<tr>
									<td style="text-align: center;" colspan="4">
										هیچ اطلاعات رباتی ثبت نشده است

									</td>
								</tr>
								</tbody>
								<?php
							}

							?>


						</table>
					</div>
				</div>
			</div>
		</div>


		<?php

	}
	#endregion
	#region ModalShowGasht
	public function ModalShowGasht($Param) {
		$user = Load::controller($this->Controller);
		$records = $user->info_gasht_client($Param);
		?>

		<div class="modal-header site-bg-main-color">
			<span class="close" onclick="modalClose('')">&times;</span>
			<h2><?php echo functions::Xmlinformation("ViewPurchaseInvoiceNumber"); ?>
				:<?php echo $Param; ?> </h2>
		</div>
		<div class="modal-body">
			<?php
			foreach ($records as $key => $view) {
				if ($key < 1) {
					?>
					<div class="row margin-both-vertical-20">
						<div class="col-md-12 modal-text-center modal-h">
                            <span><?php echo functions::Xmlinformation("Specifications"); ?>
	                            <?php echo $view['passenger_serviceRequestType'] == '0' ? functions::Xmlinformation("Gasht") : functions::Xmlinformation("transfer"); ?>
	                            <?php echo $view['passenger_serviceName']; ?></span>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4 ">
							<span><?php echo functions::Xmlinformation("Date"); ?> <?php echo $view['payment_type'] == 'cash' ? functions::Xmlinformation("Payment") : functions::Xmlinformation("Buy"); ?>
								: </span>
							<span dir="ltr"><?php echo $view['payment_date'] != '0000-00-00 00:00:00' ? functions::set_date_payment($view['payment_date']) : functions::Xmlinformation("Unpaid"); ?></span>
						</div>
						<div class="col-md-4 ">
							<span dir="rtl"><?php echo functions::Xmlinformation("Reservationdate"); ?> <?php echo $view['passenger_serviceRequestType'] == '0' ? functions::Xmlinformation("Gasht") : functions::Xmlinformation("transfer"); ?>
								: </span>
							<span style=''><?php echo $user->set_date_reserve(substr($view['creation_date'], 0, 10)) ?></span>
						</div>
						<div class="col-md-4 ">
							<span><?php echo functions::Xmlinformation("Destination"); ?>: </span>
							<span><?php echo $view['passenger_serviceCityName'] ?></span>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 ">
							<span><?php echo functions::Xmlinformation("Count"); ?> :</span>
							<span style=''><?php echo $view['passenger_number'] ?></span>
						</div>
						<div class="col-md-4 ">
							<span><?php echo functions::Xmlinformation("Amount"); ?> :</span>
							<span> <?php echo number_format($view['passenger_servicePriceAfterOff'] * $view['passenger_number']) ?>
								<?php echo functions::Xmlinformation("Rial"); ?></span>
						</div>
					</div>
					<div class="row margin-top-10">
						<div class="col-md-12 modal-text-center modal-h">
							<span><?php echo functions::Xmlinformation("PassengerProfile"); ?></span></div>
					</div>
				<?php } ?>

				<div class="row modal-padding-bottom-15">
					<div class="col-md-3 ">
						<span><?php echo functions::Xmlinformation("Namefamily"); ?> :</span>
						<span><?php echo $view['passenger_name'] . ' ' . $view['passenger_family'] ?></span>
					</div>
					<div class="col-md-3 ">
						<span><?php echo functions::Xmlinformation("DateOfBirth"); ?>: </span>
						<span dir="rtl"><?php echo (!empty($view['passenger_birthday'])) ? $view['passenger_birthday'] : $view['passenger_birthday'] ?></span>
					</div>
					<div class="col-md-3 ">
                        <span><?php echo functions::Xmlinformation("Receive"); ?>
	                        <?php echo $view['passenger_serviceRequestType'] == '0' ? functions::Xmlinformation("Gasht") : functions::Xmlinformation("transfer"); ?>
	                        :</span>
						<span>
            <?php if ($view['status'] == 'book') { ?>
	            <a href="<?php echo ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=bookingGasht&id=' . $view['passenger_factor_num'] ?>"
	               target="_blank"><i class="fa fa-print"></i></a>
	            <?php
            } else {
	            echo 'ـــــ';
            }
            ?>
                        </span>
					</div>
				</div>

			<?php } ?>
		</div>
		<div class="modal-footer site-bg-main-color">

		</div>

		<?php
	}
	#endregion
	#region ModalShowGashtBook
	public function ModalShowGashtBook($Param) {
		$objbook = Load::controller($this->Controller);
		$objDiscountCode = Load::controller('discountCodes');

		$books = $objbook->bookRecordsByFactorNumber($Param);
		?>

		<div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">مشاهده مشخصات سرویس

						&nbsp; <?php echo !empty($books[0]['member_name']) ? 'کاربر اصلی ' : 'کاربرمهمان' ?></h4>
				</div>
				<div class="modal-body">
					<?php
					foreach ($books as $key => $view) {

						if ($key < 1) {
							?>

							<div class="row margin-both-vertical-20">
								<div class="col-md-12 text-center text-bold" style="color: #fb002a;">
									<span>مشخصات کاربر</span></div>
							</div>

							<div class="row margin-both-vertical-20">
								<div class="col-md-4 ">
									<span>نام : </span>
									<span><?php echo $view['member_name'] ?></span>
								</div>
								<div class="col-md-4 ">
									<span class=""> شماره تلفن موبایل: </span>
									<span class="yn"><?php echo $view['member_mobile'] ?></span>
								</div>
								<div class="col-md-4 ">
									<span>ایمیل :</span>
									<span><?php echo $view['member_email'] ?></span>
								</div>
							</div>

							<hr style="margin: 5px 0;"/>

							<div class="row margin-both-vertical-20">
								<div class="col-md-12 text-center text-bold" style="color: #fb002a;">
									<span>اطلاعات مسافر </span>
								</div>
							</div>

							<div class="row margin-both-vertical-20">
								<div class="col-md-3 ">
									<span>نام و نام خانوادگی  : </span>
									<span><?php echo $view['passenger_name'] . ' ' . $view['passenger_family']; ?></span>
								</div>

								<div class="col-md-3 ">
									<span>شماره موبایل  : </span>
									<span><?php echo $view['passenger_mobile'] ?></span>
								</div>
								<div class="col-md-3 ">
									<span class=""> ایمیل: </span>
									<span class="yn"><?php echo $view['passenger_email'] ?></span>
								</div>
								<div class="col-md-3 ">
									<span>تعداد  : </span>
									<span><?php echo $view['passenger_number'] ?></span>
								</div>

							</div>
							<hr style="margin: 5px 0;"/>

							<div class="row margin-both-vertical-20">
								<div class="col-md-12 text-center text-bold " style="color: #fb002a;">
									<span>مشخصات پرداخت</span>
								</div>
							</div>

							<div class="row margin-both-vertical-20">
								<div class="col-md-4">
									<span class=" pull-left">تاریخ پرداخت : </span>
									<span class="yn"
									      dir="ltr"><?php echo($view['payment_date'] != '0000-00-00 00:00:00' ? functions::set_date_payment($view['payment_date']) : 'پرداخت نشده'); ?></span>
								</div>
								<div class="col-md-4"><span>نوع پرداخت: </span>
									<span><?php
										if ($view['payment_type'] == 'cash') {
											echo 'نقدی';
										} else if ($view['payment_type'] == 'credit' || $view['payment_type'] == 'member_credit') {
											echo 'اعتباری';
										}
										?>  </span>
								</div>

								<div class="col-md-4">
									<span>کد پیگیری بانک: </span>
									<span class="yn"><?php echo !empty($view['tracking_code_bank']) ? $view['tracking_code_bank'] : 'ندارد' ?></span>
								</div>
								<?php if (TYPE_ADMIN == '1' && $view['payment_type'] == 'cash') {
									?>
									<div class="col-md-4">
										<span>نام بانک: </span>
										<span><?php echo $objbook->namebank($view['name_bank_port'], $view['client_id']) ?></span>
									</div>
									<div class="col-md-4">
										<span class="">شماره درگاه: </span>
										<span class="yn"><?php echo $objbook->numberPortBnak($view['name_bank_port'], $view['client_id']) ?></span>
									</div>
									<div class="col-md-4">
										<span>صاحب امتیاز درگاه: </span>
										<span><?php echo $objbook->numberPortBnak($view['name_bank_port'], $view['client_id']) == '379918' ? 'ایران تکنولوژی' : $objbook->nameAgency($view['client_id']) ?></span>
									</div>
								<?php } ?>
							</div>
							<hr style="margin: 5px 0;"/>
							<div class="row margin-both-vertical-20">
								<div class="col-md-12 text-center text-bold " style="color: #fb002a;">
									<span>مشخصات محل اقامت</span></div>
							</div>
							<div class="row margin-both-vertical-20">

								<div class="col-md-3">
									<span class=" pull-left">نام هتل : </span>
									<span class="yn"><?php echo $view['passenger_HotelName'] ?></span>
								</div>
								<div class="col-md-3"><span>آدرس هتل :</span><span
											class="yn"><?php echo $view['passenger_HotelAddress'] ?></span></div>
								<div class="col-md-3">
									<span>تاریخ ورود :</span><span><?php echo $view['passenger_entryDate']; ?></span>
								</div>
								<div class="col-md-3">
									<span>تاریخ خروج :</span><span><?php echo $view['passenger_departureDate']; ?></span>
								</div>
							</div>
							<div class="row margin-both-vertical-20">
								<div class="col-md-12 text-center text-bold " style="color: #fb002a;">
                                    <span>مشخصات
	                                    <?php echo $view['passenger_serviceRequestType'] == '0' ? 'گشت' : 'ترانسفر'; ?>
                                    </span></div>
							</div>

							<div class="row margin-both-vertical-20">
								<div class="col-md-4 ">
									<span>نوع سرویس: </span><span>  <?php echo $view['passenger_serviceRequestType'] == '0' ? 'گشت' : 'ترانسفر'; ?></span>
								</div>
								<div class="col-md-4 "><span
											class=" pull-left">نام سرویس:</span><span><?php echo $view['passenger_serviceName'] ?></span>
								</div>
								<div class="col-md-4 ">
									<span class=" pull-left">شهر:</span>
									<span class="yn"><?php echo $view['passenger_serviceCityName'] ?></span>
								</div>
							</div>
							<div class="row margin-both-vertical-20">
								<div class="col-md-4"><span>شماره فاکتور :</span><span
											class="yn"><?php echo $view['passenger_factor_num'] ?></span></div>
								<div class="col-md-4">
									<span class=" pull-left">تاریخ رزرو : </span>
									<span class="yn"><?php echo dateTimeSetting::jdate('Y-m-d', $view['creation_date_int']) ?></span>
								</div>

								<div class="col-md-4 ">
									<span>مبلغ سرویس :</span><span><?php echo $view['passenger_servicePriceAfterOff']; ?>
										ریال </span></div>
							</div>


							<hr style="margin: 5px 0;"/>

							<!--                            <div class="row margin-top-10 margin-both-vertical-20">-->
							<!--                                <div class="col-md-12 text-center text-bold " style="color: #fb002a;">-->
							<!--                                    <span>مشخصات مسافرین</span>-->
							<!--                                </div>-->
							<!--                            </div>-->
						<?php } ?>

						<div class="row modal-padding-bottom-15 margin-both-vertical-20">

							<div class="col-md-4 ">
								<span>هزینه کل:</span>
								<span class="yn"><?php echo number_format($view['passenger_servicePriceAfterOff'] * $view['passenger_number']) ?></span>
								ریال
							</div>
							<div class="col-md-4 ">
								<span class=" pull-left">سهم آژانس:</span>
								<span class="yn"><?php echo number_format($view['agency_commission'] * $view['passenger_number']) ?></span>
							</div>
							<?php if ($view['status'] == 'book') { ?>

								<div class="col-md-4 "><span>پرینت:</span>
									<span class="yn"> <a
												href="<?php echo ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=bookingGasht&id=' . $view['passenger_factor_num'] ?>"
												target="_blank"><i class="fa fa-print"></i></a></span>
								</div>
							<?php } ?>
						</div>

					<?php } ?>
					<div class="modal-footer site-bg-main-color">


					</div>
				</div>
			</div>

		</div>

		<?php
	}
	#endregion

	#region showModalTicketClose
	public function showModalTicketClose($Param, $clientId) {
		?>
		<div class="modal-dialog modal-lg">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">بسته شدن بلیط</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label for="descriptionClose"> توضیحات</label>
								<textarea class="form-control" id="descriptionClose" name="descriptionClose"
								          placeholder="توضیحات"></textarea>
							</div>
						</div>
					</div>
				</div><!--setTicketClose-->
				<div class="modal-footer site-bg-main-color">
					<button type="button" class="btn btn-primary  pull-left"
					        onclick="setTicketClose('<?php echo $Param; ?>', '<?php echo $clientId; ?>')">
						ارسال اطلاعات
					</button>
				</div>
			</div>
		</div>
		<?php
	}

	#endregion

	#region showModalNote
    public function showModalNote($Param, $clientId = null, $note = null)
    {
        $data = array();

        if (!empty($Param)) {
            $decoded = json_decode($Param, true);
            if (is_array($decoded)) {
                $data = $decoded;
            }
        }

        $id = isset($data['id']) ? $data['id'] : null;
        $clientId = isset($data['client_id']) ? $data['client_id'] : $clientId;
        $note = isset($data['note']) ? $data['note'] : $note;

        $safeNote = '';
        if ($note !== null) {
            $safeNote = htmlspecialchars($note, ENT_QUOTES, 'UTF-8');
        }
        ?>
       <div class="modal-dialog modal-lg">
          <div class="modal-content">

             <div class="modal-header site-bg-main-color">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">یادداشت</h4>
             </div>

             <div class="modal-body">
                <div class="row">
                   <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                      <div class="form-group">
                         <label for="note_admin">یادداشت</label>
                         <textarea
                            class="form-control"
                            id="note_admin"
                            name="note_admin"
                            rows="5"
                            placeholder="یادداشت"><?php echo $safeNote; ?></textarea>
                      </div>
                   </div>
                </div>
             </div>

             <div class="modal-footer site-bg-main-color">
                <button type="button"
                        class="btn btn-primary pull-left"
                        onclick="setCancelNote('<?php echo $id; ?>', '<?php echo $clientId; ?>')">
                   ارسال اطلاعات
                </button>
             </div>

          </div>
       </div>
        <?php
    }



    #endregion
	#region configAllAirlines

	public function configAllAirlines($Param, $clientId) {
		$objAirline = Load::controller($this->Controller);
		$infoAirLine = $objAirline->getAllByIds($Param);
		$objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal', '8', 'replace');
		?>
		<div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">تنظیمات کلی ایرلاین ها</h4>
				</div>
				<div class="modal-body">
					<div class="row padding-left-10 padding-right-10">
						<?php if (!empty($infoAirLine[0])) { ?>
							<table class=" table accordian-body">
								<thead>
								<tr>
									<td scope="col"></td>
									<td scope="col">چارتری</td>
									<td scope="col">سیستمی</td>
								</tr>
								</thead>
								<tbody>
								<tr>
									<th scope="row">داخلی</th>
									<td>
										<table class="table table-striped">
											<thead>
											<tr>
												<td>اشتراکی</td>
												<td>اختصاصی</td>
												<td>انتخاب سرور اول</td>
													<td>اشتراکی</td>
												<td>اختصاصی</td>
												<td> انتخاب سرور دوم</td>
											</tr>
											</thead>
											<tbody>
											<tr>
												<td>
													<a href="#"
                                                       onclick="configPidAllAirlines('<?php echo $clientId ?>', '<?php echo $Param ?>','charter', 'isInternal','public','main'); return false">
														<?php if ($objAirline->GetConfigAirlineInfo($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal','main') == 'public') { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"
															       checked/>
														<?php } else { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"/>
														<?php } ?>
													</a>
												</td>
												<td>
													<a href="#"
                                                       onclick="configPidAllAirlines('<?php echo $clientId ?>', '<?php echo $Param ?>','charter', 'isInternal','private','main'); return false">
														<?php if ($objAirline->GetConfigAirlineInfo($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal','main') == 'private') { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"
															       checked/>
														<?php } else { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"/>
														<?php } ?>
													</a>
												</td>
												<td>
													<select name="server" id="server"
													        clientId="<?php echo $clientId ?>"
													        typeFlight="<?php echo 'charter' ?>"
													        isInternal="<?php echo 'isInternal' ?>"
                                                            airlineIds=<?php echo $Param ?>
													        onchange="selectAllServers(this)">
														<option value="">انتخاب کنید</option>
														<option value="1" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal', '1') == true) ? 'selected' : '' ?>>
															سرور 5
														</option>
														<option value="8" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal', '8') == true) ? 'selected' : '' ?>>
															سرور 7
														</option>
														<option value="10" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal', '10') == true) ? 'selected' : '' ?>>
															سرور 9
														</option>
														<option value="11" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal', '11') == true) ? 'selected' : '' ?>>
															سرور 10
														</option>
	                                                    <option value="12" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal', '12') == true) ? 'selected' : '' ?>>
															سرور 12
														</option>
														<option value="14" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal', '14') == true) ? 'selected' : '' ?>>
															سرور 14
														</option>

														<option value="15" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal', '15') == true) ? 'selected' : '' ?>>
															سرور 15
														</option>

														<option value="16" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal', '16') == true) ? 'selected' : '' ?>>
															سرور 16
														</option>
                                                        <option value="17" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal', '17') == true) ? 'selected' : '' ?>>
                                                            سرور 17
                                                        </option>
                                                        <option value="18" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal', '18') == true) ? 'selected' : '' ?>>
															سرور 18
														</option>

                                                        <option value="19" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal', '19') == true) ? 'selected' : '' ?>>
                                                            سرور 19
                                                        </option>
                                                        <option value="21" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal', '21') == true) ? 'selected' : '' ?>>
                                                            سرور 21
                                                        </option>
                                          <option value="22" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal', '22') == true) ? 'selected' : '' ?>>
                                             سرور 22
                                          </option>
                                          <option value="43" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal', '43') == true) ? 'selected' : '' ?>>
                                             سرور 43
                                          </option>
                                          <option value="20" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal', '20') == true) ? 'selected' : '' ?>>
                                             سرور 20
                                          </option>
													</select>
												</td>
												<td>
													<a href="#"
													  onclick="configPidAllAirlines('<?php echo $clientId ?>', '<?php echo $Param ?>','charter', 'isInternal','public','replace'); return false">
														<?php if ($objAirline->GetConfigAirlineInfo($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal','replace') == 'public') { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"
															       checked/>
														<?php } else { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"/>
														<?php } ?>
													</a>
												</td>
												<td>
													<a href="#"
                                                       onclick="configPidAllAirlines('<?php echo $clientId ?>', '<?php echo $Param ?>','charter', 'isInternal','private','replace'); return false">
														<?php if ($objAirline->GetConfigAirlineInfo($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal','replace') == 'private') { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"
															       checked/>
														<?php } else { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"/>
														<?php } ?>
													</a>
												</td>
												<td>
													<select name="serverReplace" id="serverReplace"
													        clientId="<?php echo $clientId ?>"
													        typeFlight="<?php echo 'charter' ?>"
													        isInternal="<?php echo 'isInternal' ?>"
													        airlineIds=<?php echo $Param ?>
													        onchange="selectAllServers(this,'replace')">
														<option value="">انتخاب کنید</option>
														<option value="1" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal', '1', 'replace') == true) ? 'selected' : '' ?>>
															سرور 5
														</option>
														<option value="8" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal', '8', 'replace') == true) ? 'selected' : '' ?>>
															سرور 7
														</option>
														<option value="10" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal', '10', 'replace') == true) ? 'selected' : '' ?>>
															سرور 9
														</option>
														<option value="11" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal', '11', 'replace') == true) ? 'selected' : '' ?>>
															سرور 10
														</option>
														<option value="12" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal', '12', 'replace') == true) ? 'selected' : '' ?>>
															سرور 12
														</option>
														<option value="14" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal', '14','replace') == true) ? 'selected' : '' ?>>
															سرور 14
														</option>
															<option value="15" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal', '15','replace') == true) ? 'selected' : '' ?>>
															سرور 15
														</option>
														<option value="16" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal', '16','replace') == true) ? 'selected' : '' ?>>
															سرور 16
														</option>
                                                        <option value="17" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal', '17','replace') == true) ? 'selected' : '' ?>>
                                                            سرور 17
                                                        </option>
														<option value="18" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal', '18','replace') == true) ? 'selected' : '' ?>>
															سرور 18
														</option>
														<option value="19" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal', '19','replace') == true) ? 'selected' : '' ?>>
															سرور 19
														</option>
                                                        <option value="21" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal', '21','replace') == true) ? 'selected' : '' ?>>
                                                            سرور 21
                                                        </option>
                                          <option value="22" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal', '22','replace') == true) ? 'selected' : '' ?>>
                                             سرور 22
                                          </option>
                                          <option value="43" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal', '43','replace') == true) ? 'selected' : '' ?>>
                                             سرور 43
                                          </option>
                                          <option value="20" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isInternal', '20','replace') == true) ? 'selected' : '' ?>>
                                             سرور 20
                                          </option>
													</select>
												</td>
											</tr>
											</tbody>
										</table>
									</td>
									<td>
										<table class="table table-striped">
											<thead>
											<tr>
												<td>اشتراکی</td>
												<td>اختصاصی</td>
												<td>انتخاب سرور اول</td>
													<td>اشتراکی</td>
												<td>اختصاصی</td>
												<td> انتخاب سرور دوم</td>
											</tr>
											</thead>
											<tbody>
											<tr>
												<td>
													<a href="#"
													   onclick="configPidAllAirlines('<?php echo $clientId ?>', '<?php echo $Param ?>','system', 'isInternal','public','main'); return false">
														<?php if ($objAirline->GetConfigAirlineInfo($clientId, $infoAirLine[0]['id'], 'system', 'isInternal','main') == 'public') { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"
															       checked/>
														<?php } else { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"/>
														<?php } ?>
													</a>
												</td>
												<td>
													<a href="#"
													   onclick="configPidAllAirlines('<?php echo $clientId ?>', '<?php echo $Param ?>','system', 'isInternal','private','main'); return false">
														<?php if ($objAirline->GetConfigAirlineInfo($clientId, $infoAirLine[0]['id'], 'system', 'isInternal','main') == 'private') { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"
															       checked/>
														<?php } else { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"/>
														<?php } ?>
													</a>
												</td>
												<td>
													<select name="server" id="server"
													        clientId="<?php echo $clientId ?>"
													        typeFlight="<?php echo 'system' ?>"
													        isInternal="<?php echo 'isInternal' ?>"
													        airlineIds=<?php echo $Param ?>
													        onchange="selectAllServers(this)">
														<option value="">انتخاب کنید</option>
														<option value="1" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isInternal', '1') == true) ? 'selected' : '' ?>>
															سرور 5
														</option>
														<option value="8" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isInternal', '8') == true) ? 'selected' : '' ?>>
															سرور 7
														</option>
														<option value="10" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isInternal', '10') == true) ? 'selected' : '' ?>>
															سرور 9
														</option>
														<option value="11" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isInternal', '11') == true) ? 'selected' : '' ?>>
															سرور 10
														</option>
														<option value="12" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isInternal', '12') == true) ? 'selected' : '' ?>>
															سرور 12
														</option>
														<option value="14" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isInternal', '14') == true) ? 'selected' : '' ?>>
															سرور 14
														</option>
														<option value="15" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isInternal', '15') == true) ? 'selected' : '' ?>>
															سرور 15
														</option>
														<option value="16" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isInternal', '16') == true) ? 'selected' : '' ?>>
															سرور 16
														</option>
                                                        <option value="17" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isInternal', '17') == true) ? 'selected' : '' ?>>
                                                            سرور 17
                                                        </option>
														<option value="18" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isInternal', '18') == true) ? 'selected' : '' ?>>
															سرور 18
														</option>
														<option value="19" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isInternal', '19') == true) ? 'selected' : '' ?>>
															سرور 19
														</option>
                                                        <option value="21" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isInternal', '21') == true) ? 'selected' : '' ?>>
                                                            سرور 21
                                                        </option>
                                          <option value="22" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isInternal', '22') == true) ? 'selected' : '' ?>>
                                             سرور 22
                                          </option>
                                          <option value="43" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isInternal', '43') == true) ? 'selected' : '' ?>>
                                             سرور 43
                                          </option>
                                          <option value="20" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isInternal', '20') == true) ? 'selected' : '' ?>>
                                             سرور 20
                                          </option>
													</select>
												</td>
												<td>
													<a href="#"
													   onclick="configPidAllAirlines('<?php echo $clientId ?>', '<?php echo $Param ?>','system', 'isInternal','public','replace'); return false">
														<?php if ($objAirline->GetConfigAirlineInfo($clientId, $infoAirLine[0]['id'], 'system', 'isInternal','replace') == 'public') { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"
															       checked/>
														<?php } else { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"/>
														<?php } ?>
													</a>
												</td>
												<td>
													<a href="#"
													   onclick="configPidAllAirlines('<?php echo $clientId ?>', '<?php echo $Param ?>','system', 'isInternal','private','replace'); return false">
														<?php if ($objAirline->GetConfigAirlineInfo($clientId, $infoAirLine[0]['id'], 'system', 'isInternal','replace') == 'private') { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"
															       checked/>
														<?php } else { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"/>
														<?php } ?>
													</a>
												</td>
												<td>
													<select name="serverReplace" id="serverReplace"
													        clientId="<?php echo $clientId ?>"
													        typeFlight="<?php echo 'system' ?>"
													        isInternal="<?php echo 'isInternal' ?>"
													        airlineIds=<?php echo $Param ?>
													        onchange="selectAllServers(this,'replace')">
														<option value="">انتخاب کنید</option>
														<option value="1" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isInternal', '1', 'replace') == true) ? 'selected' : '' ?>>
															سرور 5
														</option>
														<option value="8" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isInternal', '8', 'replace') == true) ? 'selected' : '' ?>>
															سرور 7
														</option>
														<option value="10" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isInternal', '10', 'replace') == true) ? 'selected' : '' ?>>
															سرور 9
														</option>
														<option value="11" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isInternal', '11', 'replace') == true) ? 'selected' : '' ?>>
															سرور 10
														</option>
														<option value="12" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isInternal', '12', 'replace') == true) ? 'selected' : '' ?>>
															سرور 12
														</option>
														<option value="14" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isInternal', '14','replace') == true) ? 'selected' : '' ?>>
															سرور 14
														</option>
															<option value="15" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isInternal', '15','replace') == true) ? 'selected' : '' ?>>
															سرور 15
														</option>
													<option value="16" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isInternal', '16','replace') == true) ? 'selected' : '' ?>>
															سرور 16
														</option>
                                                        <option value="17" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isInternal', '17','replace') == true) ? 'selected' : '' ?>>
                                                            سرور 17
                                                        </option>
														<option value="18" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isInternal', '18','replace') == true) ? 'selected' : '' ?>>
															سرور 18
														</option>
														<option value="19" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isInternal', '19','replace') == true) ? 'selected' : '' ?>>
															سرور 19
														</option>
                                                        <option value="21" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isInternal', '21','replace') == true) ? 'selected' : '' ?>>
                                                            سرور 21
                                                        </option>
                                          <option value="22" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isInternal', '22','replace') == true) ? 'selected' : '' ?>>
                                             سرور 22
                                          </option>
                                          <option value="43" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isInternal', '43','replace') == true) ? 'selected' : '' ?>>
                                             سرور 43
                                          </option>
                                          <option value="20" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isInternal', '20','replace') == true) ? 'selected' : '' ?>>
                                             سرور 20
                                          </option>
													</select>
												</td>
											</tr>
											</tbody>
										</table>
									</td>
								</tr>
								<tr>
									<th scope="row">خارجی</th>
									<td>
										<table class="table table-striped">
											<thead>
											<tr>
											<td>اشتراکی</td>
												<td>اختصاصی</td>
												<td>انتخاب سرور اول</td>
													<td>اشتراکی</td>
												<td>اختصاصی</td>
												<td> انتخاب سرور دوم</td>
											</tr>
											</thead>
											<tbody>
											<tr>
												<td>
													<a href="#"
													   onclick="configPidAllAirlines('<?php echo $clientId ?>', '<?php echo $Param ?>','charter', 'isExternal','public','main'); return false">
														<?php if ($objAirline->GetConfigAirlineInfo($clientId, $infoAirLine[0]['id'], 'charter', 'isExternal','main') == 'public') { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"
															       checked/>
														<?php } else { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"/>
														<?php } ?>
													</a>
												</td>
												<td>
													<a href="#"
													   onclick="configPidAllAirlines('<?php echo $clientId ?>', '<?php echo $Param ?>','charter', 'isExternal','private','main'); return false">
														<?php if ($objAirline->GetConfigAirlineInfo($clientId, $infoAirLine[0]['id'], 'charter', 'isExternal','main') == 'private') { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"
															       checked/>
														<?php } else { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"/>
														<?php } ?>
													</a>
												</td>
												<td>
													<select name="server" id="server"
													        clientId="<?php echo $clientId ?>"
													        typeFlight="<?php echo 'charter' ?>"
													        isInternal="<?php echo 'isExternal' ?>"
													        airlineIds=<?php echo $Param ?>
													        onchange="selectAllServers(this)">
														<option value="">انتخاب کنید</option>
														<option value="1" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isExternal', '1') == true) ? 'selected' : '' ?>>
															سرور 5
														</option>
														<option value="8" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isExternal', '8') == true) ? 'selected' : '' ?>>
															سرور 7
														</option>
														<option value="10" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isExternal', '10') == true) ? 'selected' : '' ?>>
															سرور 9
														</option>
														<option value="11" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isExternal', '11') == true) ? 'selected' : '' ?>>
															سرور 10
														</option>
														<option value="12" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isExternal', '12') == true) ? 'selected' : '' ?>>
															سرور 12
														</option>
														<option value="14" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isExternal', '14') == true) ? 'selected' : '' ?>>
															سرور 14
														</option>
														<option value="15" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isExternal', '15') == true) ? 'selected' : '' ?>>
															سرور 15
														</option>
														<option value="16" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isExternal', '16') == true) ? 'selected' : '' ?>>
															سرور 16
														</option>
                                          <option value="17" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isExternal', '17') == true) ? 'selected' : '' ?>>
                                                            سرور 17
                                                        </option>
														<option value="18" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isExternal', '18') == true) ? 'selected' : '' ?>>
															سرور 18
														</option>
														<option value="19" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isExternal', '19') == true) ? 'selected' : '' ?>>
															سرور 19
														</option>
                                          <option value="21" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isExternal', '21') == true) ? 'selected' : '' ?>>
                                                            سرور 21
                                                        </option>
                                          <option value="22" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isExternal', '22') == true) ? 'selected' : '' ?>>
                                             سرور 22
                                          </option>
                                          <option value="43" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isExternal', '43') == true) ? 'selected' : '' ?>>
                                             سرور 43
                                          </option>
                                          <option value="20" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isExternal', '20') == true) ? 'selected' : '' ?>>
                                             سرور 20
                                          </option>
													</select>
												</td>
												<td>
													<a href="#"
													   onclick="configPidAllAirlines('<?php echo $clientId ?>', '<?php echo $Param ?>','charter', 'isExternal','public','replace'); return false">
														<?php if ($objAirline->GetConfigAirlineInfo($clientId, $infoAirLine[0]['id'], 'charter', 'isExternal','replace') == 'public') { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"
															       checked/>
														<?php } else { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"/>
														<?php } ?>
													</a>
												</td>
												<td>
													<a href="#"
													   onclick="configPidAllAirlines('<?php echo $clientId ?>', '<?php echo $Param ?>','charter', 'isExternal','private','replace'); return false">
														<?php if ($objAirline->GetConfigAirlineInfo($clientId, $infoAirLine[0]['id'], 'charter', 'isExternal','replace') == 'private') { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"
															       checked/>
														<?php } else { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"/>
														<?php } ?>
													</a>
												</td>
												<td>
													<select name="serverReplace" id="serverReplace"
													        clientId="<?php echo $clientId ?>"
													        typeFlight="<?php echo 'charter' ?>"
													        isInternal="<?php echo 'isExternal' ?>"
													        airlineIds=<?php echo $Param ?>
													        onchange="selectAllServers(this,'replace')">
														<option value="">انتخاب کنید</option>
														<option value="1" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isExternal', '1', 'replace') == true) ? 'selected' : '' ?>>
															سرور 5
														</option>
														<option value="8" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isExternal', '8', 'replace') == true) ? 'selected' : '' ?>>
															سرور 7
														</option>
														<option value="10" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isExternal', '10', 'replace') == true) ? 'selected' : '' ?>>
															سرور 9
														</option>
														<option value="11" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isExternal', '11', 'replace') == true) ? 'selected' : '' ?>>
															سرور 10
														</option>
														<option value="12" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isExternal', '12', 'replace') == true) ? 'selected' : '' ?>>
															سرور 12
														</option>
														<option value="14" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isExternal', '14','replace') == true) ? 'selected' : '' ?>>
															سرور 14
														</option>

														<option value="15" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isExternal', '15','replace') == true) ? 'selected' : '' ?>>
															سرور 15
														</option>

														<option value="16" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isExternal', '16','replace') == true) ? 'selected' : '' ?>>
															سرور 16
														</option>
                                                        <option value="17" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isExternal', '17','replace') == true) ? 'selected' : '' ?>>
                                                            سرور 17
                                                        </option>
														<option value="18" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isExternal', '18','replace') == true) ? 'selected' : '' ?>>
															سرور 18
														</option>
														<option value="19" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isExternal', '19','replace') == true) ? 'selected' : '' ?>>
															سرور 19
														</option>
                                                        <option value="21" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isExternal', '21','replace') == true) ? 'selected' : '' ?>>
                                                            سرور 21
                                                        </option>
                                          <option value="22" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isExternal', '22','replace') == true) ? 'selected' : '' ?>>
                                             سرور 22
                                          </option>
                                          <option value="43" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isExternal', '43','replace') == true) ? 'selected' : '' ?>>
                                             سرور 43
                                          </option>
                                          <option value="20" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'charter', 'isExternal', '20','replace') == true) ? 'selected' : '' ?>>
                                             سرور 20
                                          </option>
													</select>
												</td>
												</td>
											</tr>
											</tbody>
										</table>
									</td>
									<td>
										<table class="table table-striped">
											<thead>
											<tr>
										<td>اشتراکی</td>
												<td>اختصاصی</td>
												<td>انتخاب سرور اول</td>
													<td>اشتراکی</td>
												<td>اختصاصی</td>
												<td> انتخاب سرور دوم</td>
											</tr>
											</thead>
											<tbody>
											<tr>
												<td>
													<a href="#"
													   onclick="configPidAllAirlines('<?php echo $clientId ?>', '<?php echo $Param ?>','system', 'isExternal','public','main'); return false">
														<?php if ($objAirline->GetConfigAirlineInfo($clientId, $infoAirLine[0]['id'], 'system', 'isExternal','main') == 'public') { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"
															       checked/>
														<?php } else { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"/>
														<?php } ?>
													</a>
												</td>
												<td>
													<a href="#"
													   onclick="configPidAllAirlines('<?php echo $clientId ?>', '<?php echo $Param ?>','system', 'isExternal','private','main'); return false">
														<?php if ($objAirline->GetConfigAirlineInfo($clientId, $infoAirLine[0]['id'], 'system', 'isExternal','main') == 'private') { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"
															       checked/>
														<?php } else { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"/>
														<?php } ?>
													</a>
												</td>
												<td>
													<select name="server" id="server"
													        clientId="<?php echo $clientId ?>"
													        typeFlight="<?php echo 'system' ?>"
													        isInternal="<?php echo 'isExternal' ?>"
													        airlineIds=<?php echo $Param ?>
													        onchange="selectAllServers(this)">
														<option value="">انتخاب کنید</option>
														<option value="1" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isExternal', '1') == true) ? 'selected' : '' ?>>
															سرور 5
														</option>
														<option value="8" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isExternal', '8') == true) ? 'selected' : '' ?>>
															سرور 7
														</option>
														<option value="10" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isExternal', '10') == true) ? 'selected' : '' ?>>
															سرور 9
														</option>
														<option value="11" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isExternal', '11') == true) ? 'selected' : '' ?>>
															سرور 10
														</option>
														<option value="12" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isExternal', '12') == true) ? 'selected' : '' ?>>
															سرور 12
														</option>
														<option value="14" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isExternal', '14') == true) ? 'selected' : '' ?>>
															سرور 14
														</option>
														<option value="15" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isExternal', '15') == true) ? 'selected' : '' ?>>
															سرور 15
														</option>
														<option value="16" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isExternal', '16') == true) ? 'selected' : '' ?>>
															سرور 16
														</option>
                                                        <option value="17" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isExternal', '17') == true) ? 'selected' : '' ?>>
                                                            سرور 17
                                                        </option>
														<option value="18" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isExternal', '18') == true) ? 'selected' : '' ?>>
															سرور 18
														</option>
														<option value="19" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isExternal', '19') == true) ? 'selected' : '' ?>>
															سرور 19
														</option>
                                                        <option value="21" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isExternal', '21') == true) ? 'selected' : '' ?>>
                                                            سرور 21
                                                        </option>
                                          <option value="22" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isExternal', '22') == true) ? 'selected' : '' ?>>
                                             سرور 22
                                          </option>
                                          <option value="43" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isExternal', '43') == true) ? 'selected' : '' ?>>
                                             سرور 43
                                          </option>
                                          <option value="20" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isExternal', '20') == true) ? 'selected' : '' ?>>
                                             سرور 20
                                          </option>
													</select>
												</td>
												<td>
													<a href="#"
													   onclick="configPidAllAirlines('<?php echo $clientId ?>', '<?php echo $Param ?>','system', 'isExternal','public','replace'); return false">
														<?php if ($objAirline->GetConfigAirlineInfo($clientId, $infoAirLine[0]['id'], 'system', 'isExternal','replace') == 'public') { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"
															       checked/>
														<?php } else { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"/>
														<?php } ?>
													</a>
												</td>
												<td>
													<a href="#"
													   onclick="configPidAllAirlines('<?php echo $clientId ?>', '<?php echo $Param ?>','system', 'isExternal','private','replace'); return false">
														<?php if ($objAirline->GetConfigAirlineInfo($clientId, $infoAirLine[0]['id'], 'system', 'isExternal','replace') == 'private') { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"
															       checked/>
														<?php } else { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"/>
														<?php } ?>
													</a>
												</td>
												<td>
													<select name="serverReplace" id="serverReplace"
													        clientId="<?php echo $clientId ?>"
													        typeFlight="<?php echo 'system' ?>"
													        isInternal="<?php echo 'isExternal' ?>"
													        airlineIds=<?php echo $Param ?>
													        onchange="selectAllServers(this,'replace')">
														<option value="">انتخاب کنید</option>
														<option value="1" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isExternal', '1', 'replace') == true) ? 'selected' : '' ?>>
															سرور 5
														</option>
														<option value="8" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isExternal', '8', 'replace') == true) ? 'selected' : '' ?>>
															سرور 7
														</option>
														<option value="10" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isExternal', '10', 'replace') == true) ? 'selected' : '' ?>>
															سرور 9
														</option>
														<option value="11" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isExternal', '11', 'replace') == true) ? 'selected' : '' ?>>
															سرور 10
														</option>
														<option value="12" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isExternal', '12', 'replace') == true) ? 'selected' : '' ?>>
															سرور 12
														</option>
														<option value="14" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isExternal', '14','replace') == true) ? 'selected' : '' ?>>
															سرور 14
														</option>
														<option value="15" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isExternal', '15','replace') == true) ? 'selected' : '' ?>>
															سرور 15
														</option>
														<option value="16" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isExternal', '16','replace') == true) ? 'selected' : '' ?>>
															سرور 16
														</option>
                                                        <option value="17" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isExternal', '17','replace') == true) ? 'selected' : '' ?>>
                                                            سرور 17
                                                        </option>
														<option value="18" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isExternal', '18','replace') == true) ? 'selected' : '' ?>>
															سرور 18
														</option>
														<option value="19" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isExternal', '19','replace') == true) ? 'selected' : '' ?>>
															سرور 19
														</option>
                                                        <option value="21" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isExternal', '21','replace') == true) ? 'selected' : '' ?>>
                                                            سرور 21
                                                        </option>
                                          <option value="22" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isExternal', '22','replace') == true) ? 'selected' : '' ?>>
                                             سرور 22
                                          </option>
                                          <option value="43" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isExternal', '43','replace') == true) ? 'selected' : '' ?>>
                                             سرور 43
                                          </option>
                                          <option value="20" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine[0]['id'], 'system', 'isExternal', '20','replace') == true) ? 'selected' : '' ?>>
                                             سرور 20
                                          </option>
													</select>
												</td>
											</tr>
											</tbody>
										</table>
									</td>
								</tr>
								</tbody>

							</table>

						<?php } ?>
					</div>

				</div>

			</div>
		</div>

		</div>
		<script type="text/javascript">
            $('document').ready(function () {

                $('.switch').each(function () {
                    new Switchery($(this)[0], $(this).data());
                });
            });

		</script>

		<?php
	}
	public function configAirline($Param, $clientId) {

		$objAirline = Load::controller($this->Controller);

		$infoAirLine = $objAirline->getByAbb($Param);
		$objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isInternal', '8', 'replace');
		?>
		<div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">تنظیمات ایرلاین <strong><?php echo $infoAirLine['name_fa'] ?></strong></h4>
				</div>
				<div class="modal-body">
					<div class="row padding-left-10 padding-right-10">
						<?php if (!empty($infoAirLine)) { ?>
							<table class=" table accordian-body">
								<thead>
								<tr>
									<td scope="col"></td>
									<td scope="col">چارتری</td>
									<td scope="col">سیستمی</td>

								</tr>
								</thead>
								<tbody>
								<tr>
									<th scope="row">داخلی</th>
									<td>
										<table class="table table-striped">
											<thead>
											<tr>
												<td>اشتراکی</td>
												<td>اختصاصی</td>
												<td>انتخاب سرور اول</td>
													<td>اشتراکی</td>
												<td>اختصاصی</td>
												<td> انتخاب سرور دوم</td>
											</tr>
											</thead>
											<tbody>
											<tr>
												<td>
													<a href="#"
													   onclick="configPidAirline('<?php echo $clientId ?>', '<?php echo $infoAirLine['id'] ?>','charter', 'isInternal','public','main'); return false">
														<?php if ($objAirline->GetConfigAirlineInfo($clientId, $infoAirLine['id'], 'charter', 'isInternal','main') == 'public') { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"
															       checked/>
														<?php } else { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"/>
														<?php } ?>
													</a>
												</td>
												<td>
													<a href="#"
													   onclick="configPidAirline('<?php echo $clientId ?>', '<?php echo $infoAirLine['id'] ?>','charter', 'isInternal','private','main'); return false">
														<?php if ($objAirline->GetConfigAirlineInfo($clientId, $infoAirLine['id'], 'charter', 'isInternal','main') == 'private') { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"
															       checked/>
														<?php } else { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"/>
														<?php } ?>
													</a>
												</td>
												<td>
													<select name="server" id="server"
													        clientId="<?php echo $clientId ?>"
													        typeFlight="<?php echo 'charter' ?>"
													        isInternal="<?php echo 'isInternal' ?>"
													        airlineId="<?php echo $infoAirLine['id'] ?>"
													        onchange="selectServer(this)">
														<option value="">انتخاب کنید</option>
														<option value="1" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isInternal', '1') == true) ? 'selected' : '' ?>>
															سرور 5
														</option>
														<option value="8" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isInternal', '8') == true) ? 'selected' : '' ?>>
															سرور 7
														</option>
														<option value="10" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isInternal', '10') == true) ? 'selected' : '' ?>>
															سرور 9
														</option>
														<option value="11" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isInternal', '11') == true) ? 'selected' : '' ?>>
															سرور 10
														</option>
	                                                    <option value="12" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isInternal', '12') == true) ? 'selected' : '' ?>>
															سرور 12
														</option>
														<option value="14" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isInternal', '14') == true) ? 'selected' : '' ?>>
															سرور 14
														</option>

														<option value="15" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isInternal', '15') == true) ? 'selected' : '' ?>>
															سرور 15
														</option>

														<option value="16" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isInternal', '16') == true) ? 'selected' : '' ?>>
															سرور 16
														</option>
                                                        <option value="17" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isInternal', '17') == true) ? 'selected' : '' ?>>
                                                            سرور 17
                                                        </option>
                                                        <option value="18" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isInternal', '18') == true) ? 'selected' : '' ?>>
															سرور 18
														</option>

                                                        <option value="19" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isInternal', '19') == true) ? 'selected' : '' ?>>
                                                            سرور 19
                                                        </option>
                                                        <option value="21" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isInternal', '21') == true) ? 'selected' : '' ?>>
                                                            سرور 21
                                                        </option>
                                          <option value="22" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isInternal', '22') == true) ? 'selected' : '' ?>>
                                             سرور 22
                                          </option>
                                          <option value="43" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isInternal', '43') == true) ? 'selected' : '' ?>>
                                             سرور 43
                                          </option>
                                          <option value="20" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isInternal', '20') == true) ? 'selected' : '' ?>>
                                             سرور 20
                                          </option>
													</select>
												</td>
												<td>
													<a href="#"
													   onclick="configPidAirline('<?php echo $clientId ?>', '<?php echo $infoAirLine['id'] ?>','charter', 'isInternal','public','replace'); return false">
														<?php if ($objAirline->GetConfigAirlineInfo($clientId, $infoAirLine['id'], 'charter', 'isInternal','replace') == 'public') { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"
															       checked/>
														<?php } else { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"/>
														<?php } ?>
													</a>
												</td>
												<td>
													<a href="#"
													   onclick="configPidAirline('<?php echo $clientId ?>', '<?php echo $infoAirLine['id'] ?>','charter', 'isInternal','private','replace'); return false">
														<?php if ($objAirline->GetConfigAirlineInfo($clientId, $infoAirLine['id'], 'charter', 'isInternal','replace') == 'private') { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"
															       checked/>
														<?php } else { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"/>
														<?php } ?>
													</a>
												</td>
												<td>
													<select name="serverReplace" id="serverReplace"
													        clientId="<?php echo $clientId ?>"
													        typeFlight="<?php echo 'charter' ?>"
													        isInternal="<?php echo 'isInternal' ?>"
													        airlineId="<?php echo $infoAirLine['id'] ?>"
													        onchange="selectServer(this,'replace')">
														<option value="">انتخاب کنید</option>
														<option value="1" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isInternal', '1', 'replace') == true) ? 'selected' : '' ?>>
															سرور 5
														</option>
														<option value="8" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isInternal', '8', 'replace') == true) ? 'selected' : '' ?>>
															سرور 7
														</option>
														<option value="10" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isInternal', '10', 'replace') == true) ? 'selected' : '' ?>>
															سرور 9
														</option>
														<option value="11" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isInternal', '11', 'replace') == true) ? 'selected' : '' ?>>
															سرور 10
														</option>
														<option value="12" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isInternal', '12', 'replace') == true) ? 'selected' : '' ?>>
															سرور 12
														</option>
														<option value="14" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isInternal', '14','replace') == true) ? 'selected' : '' ?>>
															سرور 14
														</option>
															<option value="15" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isInternal', '15','replace') == true) ? 'selected' : '' ?>>
															سرور 15
														</option>
														<option value="16" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isInternal', '16','replace') == true) ? 'selected' : '' ?>>
															سرور 16
														</option>
                                                        <option value="17" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isInternal', '17','replace') == true) ? 'selected' : '' ?>>
                                                            سرور 17
                                                        </option>
														<option value="18" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isInternal', '18','replace') == true) ? 'selected' : '' ?>>
															سرور 18
														</option>
														<option value="19" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isInternal', '19','replace') == true) ? 'selected' : '' ?>>
															سرور 19
														</option>
                                                        <option value="21" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isInternal', '21','replace') == true) ? 'selected' : '' ?>>
                                                            سرور 21
                                                        </option>
                                          <option value="22" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isInternal', '22','replace') == true) ? 'selected' : '' ?>>
                                             سرور 22
                                          </option>
                                          <option value="43" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isInternal', '43','replace') == true) ? 'selected' : '' ?>>
                                             سرور 43
                                          </option>
                                          <option value="20" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isInternal', '20','replace') == true) ? 'selected' : '' ?>>
                                             سرور 20
                                          </option>
													</select>
												</td>
											</tr>
											</tbody>
										</table>
									</td>
									<td>
										<table class="table table-striped">
											<thead>
											<tr>
												<td>اشتراکی</td>
												<td>اختصاصی</td>
												<td>انتخاب سرور اول</td>
													<td>اشتراکی</td>
												<td>اختصاصی</td>
												<td> انتخاب سرور دوم</td>
											</tr>
											</thead>
											<tbody>
											<tr>
												<td>
													<a href="#"
													   onclick="configPidAirline('<?php echo $clientId ?>', '<?php echo $infoAirLine['id'] ?>','system', 'isInternal','public','main'); return false">
														<?php if ($objAirline->GetConfigAirlineInfo($clientId, $infoAirLine['id'], 'system', 'isInternal','main') == 'public') { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"
															       checked/>
														<?php } else { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"/>
														<?php } ?>
													</a>
												</td>
												<td>
													<a href="#"
													   onclick="configPidAirline('<?php echo $clientId ?>', '<?php echo $infoAirLine['id'] ?>','system', 'isInternal','private','main'); return false">
														<?php if ($objAirline->GetConfigAirlineInfo($clientId, $infoAirLine['id'], 'system', 'isInternal','main') == 'private') { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"
															       checked/>
														<?php } else { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"/>
														<?php } ?>
													</a>
												</td>
												<td>
													<select name="server" id="server"
													        clientId="<?php echo $clientId ?>"
													        typeFlight="<?php echo 'system' ?>"
													        isInternal="<?php echo 'isInternal' ?>"
													        airlineId="<?php echo $infoAirLine['id'] ?>"
													        onchange="selectServer(this)">
														<option value="">انتخاب کنید</option>
														<option value="1" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isInternal', '1') == true) ? 'selected' : '' ?>>
															سرور 5
														</option>
														<option value="8" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isInternal', '8') == true) ? 'selected' : '' ?>>
															سرور 7
														</option>
														<option value="10" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isInternal', '10') == true) ? 'selected' : '' ?>>
															سرور 9
														</option>
														<option value="11" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isInternal', '11') == true) ? 'selected' : '' ?>>
															سرور 10
														</option>
														<option value="12" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isInternal', '12') == true) ? 'selected' : '' ?>>
															سرور 12
														</option>
														<option value="14" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isInternal', '14') == true) ? 'selected' : '' ?>>
															سرور 14
														</option>
														<option value="15" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isInternal', '15') == true) ? 'selected' : '' ?>>
															سرور 15
														</option>
														<option value="16" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isInternal', '16') == true) ? 'selected' : '' ?>>
															سرور 16
														</option>
                                                        <option value="17" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isInternal', '17') == true) ? 'selected' : '' ?>>
                                                            سرور 17
                                                        </option>
														<option value="18" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isInternal', '18') == true) ? 'selected' : '' ?>>
															سرور 18
														</option>
														<option value="19" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isInternal', '19') == true) ? 'selected' : '' ?>>
															سرور 19
														</option>
                                                        <option value="21" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isInternal', '21') == true) ? 'selected' : '' ?>>
                                                            سرور 21
                                                        </option>
                                          <option value="22" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isInternal', '22') == true) ? 'selected' : '' ?>>
                                             سرور 22
                                          </option>
                                          <option value="43" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isInternal', '43') == true) ? 'selected' : '' ?>>
                                             سرور 43
                                          </option>
                                          <option value="20" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isInternal', '20') == true) ? 'selected' : '' ?>>
                                             سرور 20
                                          </option>
													</select>
												</td>
												<td>
													<a href="#"
													   onclick="configPidAirline('<?php echo $clientId ?>', '<?php echo $infoAirLine['id'] ?>','system', 'isInternal','public','replace'); return false">
														<?php if ($objAirline->GetConfigAirlineInfo($clientId, $infoAirLine['id'], 'system', 'isInternal','replace') == 'public') { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"
															       checked/>
														<?php } else { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"/>
														<?php } ?>
													</a>
												</td>
												<td>
													<a href="#"
													   onclick="configPidAirline('<?php echo $clientId ?>', '<?php echo $infoAirLine['id'] ?>','system', 'isInternal','private','replace'); return false">
														<?php if ($objAirline->GetConfigAirlineInfo($clientId, $infoAirLine['id'], 'system', 'isInternal','replace') == 'private') { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"
															       checked/>
														<?php } else { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"/>
														<?php } ?>
													</a>
												</td>
												<td>
													<select name="serverReplace" id="serverReplace"
													        clientId="<?php echo $clientId ?>"
													        typeFlight="<?php echo 'system' ?>"
													        isInternal="<?php echo 'isInternal' ?>"
													        airlineId="<?php echo $infoAirLine['id'] ?>"
													        onchange="selectServer(this,'replace')">
														<option value="">انتخاب کنید</option>
														<option value="1" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isInternal', '1', 'replace') == true) ? 'selected' : '' ?>>
															سرور 5
														</option>
														<option value="8" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isInternal', '8', 'replace') == true) ? 'selected' : '' ?>>
															سرور 7
														</option>
														<option value="10" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isInternal', '10', 'replace') == true) ? 'selected' : '' ?>>
															سرور 9
														</option>
														<option value="11" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isInternal', '11', 'replace') == true) ? 'selected' : '' ?>>
															سرور 10
														</option>
														<option value="12" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isInternal', '12', 'replace') == true) ? 'selected' : '' ?>>
															سرور 12
														</option>
														<option value="14" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isInternal', '14','replace') == true) ? 'selected' : '' ?>>
															سرور 14
														</option>
															<option value="15" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isInternal', '15','replace') == true) ? 'selected' : '' ?>>
															سرور 15
														</option>
													<option value="16" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isInternal', '16','replace') == true) ? 'selected' : '' ?>>
															سرور 16
														</option>
                                                        <option value="17" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isInternal', '17','replace') == true) ? 'selected' : '' ?>>
                                                            سرور 17
                                                        </option>
														<option value="18" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isInternal', '18','replace') == true) ? 'selected' : '' ?>>
															سرور 18
														</option>
														<option value="19" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isInternal', '19','replace') == true) ? 'selected' : '' ?>>
															سرور 19
														</option>
                                                        <option value="21" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isInternal', '21','replace') == true) ? 'selected' : '' ?>>
                                                            سرور 21
                                                        </option>
                                          <option value="22" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isInternal', '22','replace') == true) ? 'selected' : '' ?>>
                                             سرور 22
                                          </option>
                                          <option value="43" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isInternal', '43','replace') == true) ? 'selected' : '' ?>>
                                             سرور 43
                                          </option>
                                          <option value="20" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isInternal', '20','replace') == true) ? 'selected' : '' ?>>
                                             سرور 20
                                          </option>
													</select>
												</td>
											</tr>
											</tbody>
										</table>
									</td>
								</tr>
								<tr>
									<th scope="row">خارجی</th>
									<td>
										<table class="table table-striped">
											<thead>
											<tr>
											<td>اشتراکی</td>
												<td>اختصاصی</td>
												<td>انتخاب سرور اول</td>
													<td>اشتراکی</td>
												<td>اختصاصی</td>
												<td> انتخاب سرور دوم</td>
											</tr>
											</thead>
											<tbody>
											<tr>
												<td>
													<a href="#"
													   onclick="configPidAirline('<?php echo $clientId ?>', '<?php echo $infoAirLine['id'] ?>','charter', 'isExternal','public','main'); return false">
														<?php if ($objAirline->GetConfigAirlineInfo($clientId, $infoAirLine['id'], 'charter', 'isExternal','main') == 'public') { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"
															       checked/>
														<?php } else { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"/>
														<?php } ?>
													</a>
												</td>
												<td>
													<a href="#"
													   onclick="configPidAirline('<?php echo $clientId ?>', '<?php echo $infoAirLine['id'] ?>','charter', 'isExternal','private','main'); return false">
														<?php if ($objAirline->GetConfigAirlineInfo($clientId, $infoAirLine['id'], 'charter', 'isExternal','main') == 'private') { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"
															       checked/>
														<?php } else { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"/>
														<?php } ?>
													</a>
												</td>
												<td>
													<select name="server" id="server"
													        clientId="<?php echo $clientId ?>"
													        typeFlight="<?php echo 'charter' ?>"
													        isInternal="<?php echo 'isExternal' ?>"
													        airlineId="<?php echo $infoAirLine['id'] ?>"
													        onchange="selectServer(this)">
														<option value="">انتخاب کنید</option>
														<option value="1" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isExternal', '1') == true) ? 'selected' : '' ?>>
															سرور 5
														</option>
														<option value="8" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isExternal', '8') == true) ? 'selected' : '' ?>>
															سرور 7
														</option>
														<option value="10" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isExternal', '10') == true) ? 'selected' : '' ?>>
															سرور 9
														</option>
														<option value="11" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isExternal', '11') == true) ? 'selected' : '' ?>>
															سرور 10
														</option>
														<option value="12" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isExternal', '12') == true) ? 'selected' : '' ?>>
															سرور 12
														</option>
														<option value="14" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isExternal', '14') == true) ? 'selected' : '' ?>>
															سرور 14
														</option>
														<option value="15" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isExternal', '15') == true) ? 'selected' : '' ?>>
															سرور 15
														</option>
														<option value="16" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isExternal', '16') == true) ? 'selected' : '' ?>>
															سرور 16
														</option>
                                                        <option value="17" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isExternal', '17') == true) ? 'selected' : '' ?>>
                                                            سرور 17
                                                        </option>
														<option value="18" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isExternal', '18') == true) ? 'selected' : '' ?>>
															سرور 18
														</option>
														<option value="19" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isExternal', '19') == true) ? 'selected' : '' ?>>
															سرور 19
														</option>
                                                        <option value="21" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isExternal', '21') == true) ? 'selected' : '' ?>>
                                                            سرور 21
                                                        </option>
                                          <option value="22" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isExternal', '22') == true) ? 'selected' : '' ?>>
                                             سرور 22
                                          </option>
                                          <option value="43" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isExternal', '43') == true) ? 'selected' : '' ?>>
                                             سرور 43
                                          </option>
                                          <option value="20" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isExternal', '20') == true) ? 'selected' : '' ?>>
                                             سرور 20
                                          </option>
													</select>
												</td>
												<td>
													<a href="#"
													   onclick="configPidAirline('<?php echo $clientId ?>', '<?php echo $infoAirLine['id'] ?>','charter', 'isExternal','public','replace'); return false">
														<?php if ($objAirline->GetConfigAirlineInfo($clientId, $infoAirLine['id'], 'charter', 'isExternal','replace') == 'public') { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"
															       checked/>
														<?php } else { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"/>
														<?php } ?>
													</a>
												</td>
												<td>
													<a href="#"
													   onclick="configPidAirline('<?php echo $clientId ?>', '<?php echo $infoAirLine['id'] ?>','charter', 'isExternal','private','replace'); return false">
														<?php if ($objAirline->GetConfigAirlineInfo($clientId, $infoAirLine['id'], 'charter', 'isExternal','replace') == 'private') { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"
															       checked/>
														<?php } else { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"/>
														<?php } ?>
													</a>
												</td>
												<td>
													<select name="serverReplace" id="serverReplace"
													        clientId="<?php echo $clientId ?>"
													        typeFlight="<?php echo 'charter' ?>"
													        isInternal="<?php echo 'isExternal' ?>"
													        airlineId="<?php echo $infoAirLine['id'] ?>"
													        onchange="selectServer(this,'replace')">
														<option value="">انتخاب کنید</option>
														<option value="1" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isExternal', '1', 'replace') == true) ? 'selected' : '' ?>>
															سرور 5
														</option>
														<option value="8" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isExternal', '8', 'replace') == true) ? 'selected' : '' ?>>
															سرور 7
														</option>
														<option value="10" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isExternal', '10', 'replace') == true) ? 'selected' : '' ?>>
															سرور 9
														</option>
														<option value="11" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isExternal', '11', 'replace') == true) ? 'selected' : '' ?>>
															سرور 10
														</option>
														<option value="12" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isExternal', '12', 'replace') == true) ? 'selected' : '' ?>>
															سرور 12
														</option>
														<option value="14" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isExternal', '14','replace') == true) ? 'selected' : '' ?>>
															سرور 14
														</option>

														<option value="15" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isExternal', '15','replace') == true) ? 'selected' : '' ?>>
															سرور 15
														</option>

														<option value="16" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isExternal', '16','replace') == true) ? 'selected' : '' ?>>
															سرور 16
														</option>
                                                        <option value="17" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isExternal', '17','replace') == true) ? 'selected' : '' ?>>
                                                            سرور 17
                                                        </option>
														<option value="18" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isExternal', '18','replace') == true) ? 'selected' : '' ?>>
															سرور 18
														</option>
														<option value="19" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isExternal', '19','replace') == true) ? 'selected' : '' ?>>
															سرور 19
														</option>
                                                        <option value="21" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isExternal', '21','replace') == true) ? 'selected' : '' ?>>
                                                            سرور 21
                                                        </option>
                                          <option value="22" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isExternal', '22','replace') == true) ? 'selected' : '' ?>>
                                             سرور 22
                                          </option>
                                          <option value="43" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isExternal', '43','replace') == true) ? 'selected' : '' ?>>
                                             سرور 43
                                          </option>
                                          <option value="20" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'charter', 'isExternal', '20','replace') == true) ? 'selected' : '' ?>>
                                             سرور 20
                                          </option>

													</select>
												</td>
												</td>
											</tr>
											</tbody>
										</table>
									</td>
									<td>
										<table class="table table-striped">
											<thead>
											<tr>
										<td>اشتراکی</td>
												<td>اختصاصی</td>
												<td>انتخاب سرور اول</td>
													<td>اشتراکی</td>
												<td>اختصاصی</td>
												<td> انتخاب سرور دوم</td>
											</tr>
											</thead>
											<tbody>
											<tr>
												<td>
													<a href="#"
													   onclick="configPidAirline('<?php echo $clientId ?>', '<?php echo $infoAirLine['id'] ?>','system', 'isExternal','public','main'); return false">
														<?php if ($objAirline->GetConfigAirlineInfo($clientId, $infoAirLine['id'], 'system', 'isExternal','main') == 'public') { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"
															       checked/>
														<?php } else { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"/>
														<?php } ?>
													</a>
												</td>
												<td>
													<a href="#"
													   onclick="configPidAirline('<?php echo $clientId ?>', '<?php echo $infoAirLine['id'] ?>','system', 'isExternal','private','main'); return false">
														<?php if ($objAirline->GetConfigAirlineInfo($clientId, $infoAirLine['id'], 'system', 'isExternal','main') == 'private') { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"
															       checked/>
														<?php } else { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"/>
														<?php } ?>
													</a>
												</td>
												<td>
													<select name="server" id="server"
													        clientId="<?php echo $clientId ?>"
													        typeFlight="<?php echo 'system' ?>"
													        isInternal="<?php echo 'isExternal' ?>"
													        airlineId="<?php echo $infoAirLine['id'] ?>"
													        onchange="selectServer(this)">
														<option value="">انتخاب کنید</option>
														<option value="1" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isExternal', '1') == true) ? 'selected' : '' ?>>
															سرور 5
														</option>
														<option value="8" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isExternal', '8') == true) ? 'selected' : '' ?>>
															سرور 7
														</option>
														<option value="10" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isExternal', '10') == true) ? 'selected' : '' ?>>
															سرور 9
														</option>
														<option value="11" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isExternal', '11') == true) ? 'selected' : '' ?>>
															سرور 10
														</option>
														<option value="12" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isExternal', '12') == true) ? 'selected' : '' ?>>
															سرور 12
														</option>
														<option value="14" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isExternal', '14') == true) ? 'selected' : '' ?>>
															سرور 14
														</option>
														<option value="15" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isExternal', '15') == true) ? 'selected' : '' ?>>
															سرور 15
														</option>
														<option value="16" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isExternal', '16') == true) ? 'selected' : '' ?>>
															سرور 16
														</option>
                                                        <option value="17" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isExternal', '17') == true) ? 'selected' : '' ?>>
                                                            سرور 17
                                                        </option>
														<option value="18" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isExternal', '18') == true) ? 'selected' : '' ?>>
															سرور 18
														</option>
														<option value="19" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isExternal', '19') == true) ? 'selected' : '' ?>>
															سرور 19
														</option>
                                                        <option value="21" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isExternal', '21') == true) ? 'selected' : '' ?>>
                                                            سرور 21
                                                        </option>
                                          <option value="22" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isExternal', '22') == true) ? 'selected' : '' ?>>
                                             سرور 22
                                          </option>
                                          <option value="43" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isExternal', '43') == true) ? 'selected' : '' ?>>
                                             سرور 43
                                          </option>
                                          <option value="20" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isExternal', '20') == true) ? 'selected' : '' ?>>
                                             سرور 20
                                          </option>
													</select>
												</td>
												<td>
													<a href="#"
													   onclick="configPidAirline('<?php echo $clientId ?>', '<?php echo $infoAirLine['id'] ?>','system', 'isExternal','public','replace'); return false">
														<?php if ($objAirline->GetConfigAirlineInfo($clientId, $infoAirLine['id'], 'system', 'isExternal','replace') == 'public') { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"
															       checked/>
														<?php } else { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"/>
														<?php } ?>
													</a>
												</td>
												<td>
													<a href="#"
													   onclick="configPidAirline('<?php echo $clientId ?>', '<?php echo $infoAirLine['id'] ?>','system', 'isExternal','private','replace'); return false">
														<?php if ($objAirline->GetConfigAirlineInfo($clientId, $infoAirLine['id'], 'system', 'isExternal','replace') == 'private') { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"
															       checked/>
														<?php } else { ?>
															<input type="checkbox" class="switch"
															       data-color="#99d683"
															       data-secondary-color="#f96262"
															       data-size="small"/>
														<?php } ?>
													</a>
												</td>
												<td>
													<select name="serverReplace" id="serverReplace"
													        clientId="<?php echo $clientId ?>"
													        typeFlight="<?php echo 'system' ?>"
													        isInternal="<?php echo 'isExternal' ?>"
													        airlineId="<?php echo $infoAirLine['id'] ?>"
													        onchange="selectServer(this,'replace')">
														<option value="">انتخاب کنید</option>
														<option value="1" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isExternal', '1', 'replace') == true) ? 'selected' : '' ?>>
															سرور 5
														</option>
														<option value="8" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isExternal', '8', 'replace') == true) ? 'selected' : '' ?>>
															سرور 7
														</option>
														<option value="10" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isExternal', '10', 'replace') == true) ? 'selected' : '' ?>>
															سرور 9
														</option>
														<option value="11" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isExternal', '11', 'replace') == true) ? 'selected' : '' ?>>
															سرور 10
														</option>
														<option value="12" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isExternal', '12', 'replace') == true) ? 'selected' : '' ?>>
															سرور 12
														</option>
														<option value="14" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isExternal', '14','replace') == true) ? 'selected' : '' ?>>
															سرور 14
														</option>
														<option value="15" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isExternal', '15','replace') == true) ? 'selected' : '' ?>>
															سرور 15
														</option>
														<option value="16" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isExternal', '16','replace') == true) ? 'selected' : '' ?>>
															سرور 16
														</option>
                                                        <option value="17" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isExternal', '17','replace') == true) ? 'selected' : '' ?>>
                                                            سرور 17
                                                        </option>
														<option value="18" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isExternal', '18','replace') == true) ? 'selected' : '' ?>>
															سرور 18
														</option>
														<option value="19" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isExternal', '19','replace') == true) ? 'selected' : '' ?>>
															سرور 19
														</option>
                                                        <option value="21" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isExternal', '21','replace') == true) ? 'selected' : '' ?>>
                                                            سرور 21
                                                        </option>
                                          <option value="22" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isExternal', '22','replace') == true) ? 'selected' : '' ?>>
                                             سرور 22
                                          </option>
                                          <option value="43" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isExternal', '43','replace') == true) ? 'selected' : '' ?>>
                                             سرور 43
                                          </option>
                                          <option value="20" <?php echo ($objAirline->getServerConfigFlight($clientId, $infoAirLine['id'], 'system', 'isExternal', '20','replace') == true) ? 'selected' : '' ?>>
                                             سرور 20
                                          </option>
													</select>
												</td>
											</tr>
											</tbody>
										</table>
									</td>
								</tr>
								</tbody>

							</table>

						<?php } ?>
					</div>

				</div>

			</div>
		</div>

		</div>
		<script type="text/javascript">
            $('document').ready(function () {

                $('.switch').each(function () {
                    new Switchery($(this)[0], $(this).data());
                });
            });

		</script>

		<?php
	}

	#endregion

	#region logConfigAirline

	public function logConfigAirline($Param, $clientId) {
		$objAirline = Load::controller($this->Controller);
		$infoAirLine = $objAirline->getByAbb($Param);
		$dataLog['airlineId'] = $infoAirLine['id'];
		$dataLog['ClientId'] = $clientId;
		$viewLog = $objAirline->logConfigAirline($dataLog);

		?>
		<div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"> مشاهده تغییرات ایرلاین <?php echo $infoAirLine['name_fa'] ?> </h4>
				</div>
				<div class="modal-body">
					<div class="row padding-left-10 padding-right-10">
						<table class="table full-color-table full-success-table hover-table">
							<thead>
							<tr>
								<th>#</th>
								<th>نام ایرلاین</th>
								<th>شرح فعالیت</th>
								<th>تاریخ</th>
							</tr>
							</thead>
							<tbody>

							<?php
							if (!empty($viewLog)):
								foreach ($viewLog as $key => $item) :

									$typeFlight = ($item['typeFlight'] == 'charter') ? 'چارتری' : 'سیستمی';
									$isInternal = ($item['isInternal'] == '0') ? 'خارجی' : 'داخلی';
									?>
									<tr>
										<td><?php echo $key + 1; ?></td>
										<td><?php echo $infoAirLine['name_fa']; ?></td>
										<td><?php if ($item['action'] == 'chooseServer') {

												switch ($item['valueAction']) {
												case '1':
													$nameServer = '5';
													break;
												case '8':
													$nameServer = '7';
													break;
												case '10':
													$nameServer = '9';
													break;
												case '11':
													$nameServer = '10';
													break;

												}
												echo 'انتخاب سرور' . ' ' . $nameServer . ' ' . ' برای پرواز ' . ' ' . $typeFlight . ' ' . $isInternal;
											} else if ($item['action'] == 'alternativeServer') {
												switch ($item['valueAction']) {
												case '1':
													$nameServer = '5';
													break;
												case '8':
													$nameServer = '7';
													break;
												case '10':
													$nameServer = '9';
													break;
												case '11':
													$nameServer = '10';
													break;

												}
												echo 'انتخاب سرور ' . ' ' . $nameServer . ' ' . 'به عنوان سرور جایگزین برای پرواز ' . ' ' . $typeFlight . ' ' . $isInternal;
											} else {
												$pid = ($item['valueAction'] == 'private') ? 'اختصاصی' : 'اشتراکی';
												echo 'انتخاب پید' . ' ' . $pid . ' ' . ' برای پرواز ' . ' ' . $typeFlight . ' ' . $isInternal;
											} ?></td>
										<td><?php echo dateTimeSetting::jdate("(H:i:s) Y-m-d ", $item['creationDateInt']); ?></td>
									</tr>
									<?php
								endforeach;
							else:
								?>
								<tr>
									<td colspan="3" class="text-center">اطلاعاتی وجود ندارد</td>
								</tr>
							<?php endif; ?>
							</tbody>
						</table>
					</div>

				</div>

			</div>
		</div>


		<?php
	}

	#endregion

	#region ModalShow

	public function ModalCancelAdmin($Param, $param2) {
		$user = Load::controller($this->Controller);
		$InfoCancelTicket = $user->InfoModalTicketCancel($Param, $param2);
		if (isset($param2) && $param2 == 'flight') {
			$Fee = functions::FeeCancelFlight($InfoCancelTicket[0]['airline_iata'], $InfoCancelTicket[0]['cabin_type']);
		}
		?>

		<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"> کنسل کردن بلیط به شماره رزرو <?php echo $Param ?> </h4>
			</div>
			<div class="modal-body">
				<div class="modal-padding-bottom-15">
					<div class="row">
						<div class="col-md-12 modal-text-center modal-h "> لطفا مسافر مورد نظر خود را انتخاب نمائید
						</div>
					</div>
					<div class="row">
						<?php
						foreach ($InfoCancelTicket as $i => $info) {
							$NationalCodeUser = $info['NationalCode'];//(!empty($info['passenger_national_code']) && $info['passenger_national_code'] != '0000000000') ? $info['passenger_national_code'] : $info['passportNumber'];
							if ($i < 1) {
								?>
								<input type="hidden" value="<?php echo $info['factor_number'] ?>" name="FactorNumber"
								       id="FactorNumber"/>
								<input type="hidden" value="<?php echo $info['member_id'] ?>" name="MemberId"
								       id="MemberId"/>
								<?php
							}
							?>
							<div class="col-md-12">

								<div class="col-md-1 ">
									<input class="form-control SelectUser" type="checkbox"
									       name="SelectUser[]" id="SelectUser"
									       value="<?php echo ($info['passenger_national_code'] != '0000000000') ? $info['passenger_national_code'] . '-' . $info['passenger_age'] : $info['passportNumber'] . '-' . $info['passenger_age'] ?>"
										<?php
										echo (!empty($info['Status']) && !empty($NationalCodeUser) && $info['Status'] != 'Nothing' ) ? 'disabled ="disabled"' : '';
										?>

									></div>

								<div class="col-md-2">
									<span><?php echo $info['passenger_name'] . ' ' . $info['passenger_family']; ?></span>
								</div>

								<div class="col-md-3 ">
									<span><?php echo functions::Xmlinformation("Nationalnumber") ?>
										/<?php echo functions::Xmlinformation("Passport") ?>
										:</span><span><?php echo ($info['passenger_national_code'] != '0000000000') ? $info['passenger_national_code'] : $info['passportNumber'] ?></span>
								</div>
								<div class="col-md-2 "><span
									><?php echo functions::Xmlinformation("DateOfBirth") ?>
										: </span><span><?php echo (!empty($info['passenger_birthday'])) ? $info['passenger_birthday'] : $info['passenger_birthday_en'] ?></span>
								</div>

								<div class="col-md-1 "> <span><?php
										switch ($info['passenger_age']) {

										case 'Adt':
											echo functions::Xmlinformation("Adult");
											break;

										case 'Chd':
											echo functions::Xmlinformation("Child");
											break;

										case 'Inf':
											echo functions::Xmlinformation("Baby");
											break;
										}
										?></span></div>

								<div class="col-md-3 col-lg-3 col-xs-12 col-sm-12 txtCenter"><?php
									if (!empty($info['Status']) && !empty($NationalCodeUser) && $info['Status'] != 'Nothing') {
										if ($info['Status'] == 'SetCancelClient') {
											?>
											<div class="btn btn-danger"><?php echo functions::Xmlinformation("Deniedrequest") ?></div>
											<?php
										} elseif($info['Status'] !='close') {
											?>
											<div class="btn btn-warning"><?php echo functions::Xmlinformation("Actionhasalreadybeentaken") ?></div>

											<?php
										}
									}
									?></div>
							</div>
							<?php
						}
						?>

					</div>

					<?php

					if (isset($param2) && $param2 == 'flight') {
						if (!empty($Fee) && strtolower($InfoCancelTicket[0]['flight_type']) == 'system') {
							?>
							<div class="cancel-policy cancel_modal">
								<div class="cancel-policy-head">
									<div class="cancel-policy-head-text"><?php echo functions::Xmlinformation("DetailMoneyCancel") ?></div>
									<div class="cancel-policy-class">


										<span><?php echo functions::Xmlinformation("Classflight") ?>
											:</span><span> <?php echo $Fee['TypeClass'] ?> </span></div>
								</div>
								<div class="cancel-policy-inner">
									<div class="cancel-policy-item cancel_modal">
										<span class="cancel-policy-item-text"><?php echo functions::Xmlinformation("Fromthetimeticketissueuntilnoondaysbeforeflight") ?></span>
										<span class="cancel-policy-item-pnalty site-bg-main-color-admin"><?php echo is_numeric($Fee['ThreeDaysBefore']) ? $Fee['ThreeDaysBefore'] . functions::Xmlinformation("PenaltyPercent") : $Fee['ThreeDaysBefore']; ?> </span>
									</div>

									<div class="cancel-policy-item cancel_modal">
										<span class="cancel-policy-item-text"><?php echo functions::Xmlinformation("Fromnoondaysbeforeflightnoondaybeforeflight") ?></span>
										<span class="cancel-policy-item-pnalty site-bg-main-color-admin"><?php echo is_numeric($Fee['OneDaysBefore']) ? $Fee['OneDaysBefore'] . functions::Xmlinformation("PenaltyPercent") : $Fee['OneDaysBefore']; ?> </span>
									</div>
									<div class="cancel-policy-item cancel_modal">

										<span class="cancel-policy-item-text"><?php echo functions::Xmlinformation("Fromnoondaybeforeflighthoursbeforeflight") ?></span>
										<span class="cancel-policy-item-pnalty site-bg-main-color-admin"><?php echo is_numeric($Fee['ThreeHoursBefore']) ? $Fee['ThreeHoursBefore'] . functions::Xmlinformation("PenaltyPercent") : $Fee['ThreeHoursBefore']; ?> </span>
									</div>
									<div class="cancel-policy-item cancel_modal">
										<?php echo functions::Xmlinformation("Fromnoondaybeforeflighthoursbeforeflight") ?>
										<span class="cancel-policy-item-text"><?php echo functions::Xmlinformation("Fromhoursbeforeflighttominutesbeforeflight") ?></span>
										<span class="cancel-policy-item-pnalty site-bg-main-color-admin"><?php echo is_numeric($Fee['ThirtyMinutesAgo']) ? $Fee['ThirtyMinutesAgo'] . functions::Xmlinformation("PenaltyPercent") : $Fee['ThirtyMinutesAgo']; ?> </span>
									</div>

									<div class="cancel-policy-item cancel_modal">
										<span class="cancel-policy-item-text">   <?php echo functions::Xmlinformation("Minutesbeforetheflight") ?></span>
										<span class="cancel-policy-item-pnalty site-bg-main-color-admin"><?php echo is_numeric($Fee['OfThirtyMinutesAgoToNext']) ? $Fee['OfThirtyMinutesAgoToNext'] . functions::Xmlinformation("PenaltyPercent") : $Fee['OfThirtyMinutesAgoToNext']; ?> </span>
									</div>
								</div>
							</div>
						<?php } else if (empty($Fee) && strtolower($InfoCancelTicket[0]['flight_type']) == 'system') { ?>
							<div class="cancel-policy cancel_modal cancel-policy-charter1">
								<div class="cancel-policy-head">

									<div class="cancel-policy-head-text"><?php echo functions::Xmlinformation("DetailMoneyCancel") ?></div>
								</div>
								<span class="site-bg-main-color-admin"><?php echo functions::Xmlinformation("Contactbackupunitinformationaboutamountconsignmentfines") ?></span>
							</div>

						<?php } else { ?>
							<div class="cancel-policy cancel_modal cancel-policy-charter1">
								<div class="cancel-policy-head">
									<div class="cancel-policy-head-text"><?php echo functions::Xmlinformation("DetailMoneyCancel") ?></div>
								</div>
								<span class="site-bg-main-color-admin"><?php echo functions::Xmlinformation("ThecharterflightscharterunderstandingCivilAviationOrganization") ?></span>
							</div>
							<?php
						}
					}
					?>
					<div class="row">
						<div class="col-md-12 modal-text-center modal-h ">
							<label for="ReasonUser"><?php echo functions::Xmlinformation("Pleaseselectyourdesiredoptions") ?></label>
						</div>
						<div class="col-md-3 col-lg-3 col-sm-12  nopad ">
							<select class="form-control mart5" name="ReasonUser"
							        id="ReasonUser">
								<option value=""> <?php echo functions::Xmlinformation("Choosereasonfortheconsole") ?></option>
								<option value="PersonalReason"><?php echo functions::Xmlinformation("Canselforpersonalreasons") ?></option>
								<?php if (isset($param2) && $param2 == 'flight') { ?>
									<option value="DelayTwoHours"><?php echo functions::Xmlinformation("Delaymorethantwohours") ?></option>
									<option value="CancelByAirline"><?php echo functions::Xmlinformation("AbandonedbyAirline") ?></option>
								<?php } else { ?>
									<option value="DelayTwoHours"><?php echo functions::Xmlinformation("delayTrain") ?></option>
								<?php } ?>
							</select>
						</div>

						<?php
						if (isset($param2) && $param2 == 'flight') {
							if (empty($Fee) && strtolower($InfoCancelTicket[0]['flight_type']) != 'system') { ?>
								<div class="col-md-5 col-lg-5 col-sm-12  nopad ">
									<div class="col-md-1 col-lg-1 col-sm-12 col-xs-12 nopad">
										<input class="form-control " type="checkbox" id="PercentNoMatter"
										       name="PercentNoMatter"
										       style="height: 40px">
									</div>
									<div class="col-md-11 col-lg-11 col-sm-12 col-xs-12 lh45 nopad">
										<?php echo functions::Xmlinformation("Idonotcareaboutthepercentagepenaltypleasebesurecancel") ?>
									</div>
								</div>
							<?php }
						} ?>


					</div>


				</div>
			</div>
			<div class="modal-footer">
				<div class="col-md-12" style="text-align:left;">
					<input type="hidden" name="typeService" id="typeService" value="<?php echo $param2 ?>">
					<input type="hidden" name="flightType" id="flightType"
					       value="<?php echo $InfoCancelTicket[0]['flight_type'] ?>">

          <button class="fcbtn btn btn-outline btn-info " id='btn-information' onclick="SelectUser('<?php echo $Param ?>')">
              <?php echo functions::Xmlinformation("Sendinformation") ?>
            <div class="spinner-border" id='btn-send-information-load' role="status">
              <span class="sr-only">Loading...</span>
            </div>
          </button>
				</div>
			</div>
		</div>

		<?php
	}

	#endregion

    public function ModalShowMainUserListBtn($param){

	    $id=$param['id'];
	    $type=$param['counter_type'];
         ?>
       <a href="mainUserEdit&id=<?php echo $id; ?>"><i class="fcbtn btn btn-outline btn-primary btn-1f  tooltip-primary ti-pencil-alt " data-toggle="tooltip" data-placement="top" title="" data-original-title=" ویرایش کاربر "></i></a>
       <a href="passengerListUser&id=<?php echo $id; ?>"><i class="fcbtn btn btn-outline btn-info btn-1f  tooltip-info ti-view-list-alt" data-toggle="tooltip" data-placement="top" title="" data-original-title="لیست مسافران کاربر "></i></a>
       <?php if($type == '5') : ?>
       <a href="#" onclick="ModalAddCounterOfUser('<?php echo $id; ?>');return false" data-toggle="modal" data-target="#ModalPublic"><i class="fcbtn btn btn-outline btn-success btn-1f  tooltip-success icon-user-follow " data-toggle="tooltip" data-placement="top" data-original-title="افزودن به عنوان کانتر "></i></a>
       <?php endif; ?>
       <a href="presentedList&id=<?php echo $id; ?>"><i class="fcbtn btn btn-outline btn-warning btn-1f tooltip-warning icon-user-following" data-toggle="tooltip" data-placement="top" title="" data-original-title="لیست استفاده کنندگان از کد معرف"></i></a>
       <a href="mainUserBankEdit&id=<?php echo $id; ?>"><i class="fcbtn btn btn-outline btn-danger btn-1f  tooltip-danger ti-money " data-toggle="tooltip" data-placement="top" title="" data-original-title=" مشخصات حساب بانکی "></i></a>
       <a href="mainUserBuy&id=<?php echo $id; ?>"><i class="fcbtn btn btn-outline btn-info btn-1f  tooltip-info  ti-shopping-cart " data-toggle="tooltip" data-placement="top" title="" data-original-title=" سوابق خرید "></i></a>
         <?php
    }

    #region ModalShowInfoComment

	public function ModalShowInfoComment($Param) {


		$InfoComment = Load::controller($this->Controller);

		$Param=array("commentId"=>$Param);
		$Result = $InfoComment->getOneComment($Param);

		?>
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">مشاهده نظر </h4>
				</div>
				<div class="modal-body">
					<div class="row padding-left-10 padding-right-10">
						<?php echo $Result['text']; ?>
					</div>
				</div>
			</div>
		</div>


		<?php

	}

      public function ModalEditComment($Param)
      {
          $InfoComment = Load::controller($this->Controller);

          $Param = array("commentId" => $Param);
          $Result = $InfoComment->getOneComment($Param);

          ?>
         <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header site-bg-main-color">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">ویرایش نظر</h4>
               </div>

               <div class="modal-body">
                  <div class="row padding-left-10 padding-right-10">
                     <form id="editCommentForm" onsubmit="event.preventDefault(); submitEditComment(<?php echo (int)$Result['id']; ?>);">
                        <textarea id="commentText" name="commentText" class="form-control" rows="6" style="resize: vertical;"><?php echo htmlspecialchars(trim($Result['text']), ENT_QUOTES, 'UTF-8'); ?></textarea>
                        <br>
                        <div class="d-flex justify-content-end">
                           <button type="button" class="btn btn-default ml-2" data-dismiss="modal">بستن</button>
                           <button type="submit" class="btn btn-success">ذخیره</button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
          <?php
      }




      public function ModalShowSlugs($Param) {

        /** @var tourSlugController $slug_controller */
        $slug_controller=$this->getController(tourSlugController::class);
        $slug=$slug_controller->findById($Param['slug_id'],$Param['self']);


//        $InfoComment = Load::controller($this->Controller);
//
//        $Param=array("commentId"=>$Param);
//        $Result = $InfoComment->getOneComment($Param);

        ?>
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header site-bg-main-color">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">نامک ها</h4>
          </div>
          <div class="modal-body">
            <div class="row padding-left-10 padding-right-10">

              <div class="alert alert-warning d-flex align-items-center text-dark" role="alert">
                <span class='fa font20 fa-chain-broken ml-4'></span>
                <div>
                  با تغییر نامک‌ها، نامک‌های قبلی شما ممکن است به خطای 404 منجر شوند که برای سئو مناسب نیست. بنابراین، این تغییر را با دقت انجام دهید.
                </div>
              </div>

              <div class='flex fle-wrap  '>
                  <?php
                  foreach ($slug_controller->getLang() as $lang) {
                      ?>
                    <div class='mt-3'>
                      <label for='slug_value_<?php echo $lang;  ?>'
                             class="control-label">
                        نامک مخصوص زبان: <?php echo $lang?>
                      </label>
                      <input onchange='updateSlug($(this))'
                             dir='ltr'
                             id='slug_value_<?php echo $lang;  ?>'
                             data-lang='<?php echo $lang; ?>'
                             data-self='<?php echo $slug['self'];  ?>'
                             data-id='<?php echo $slug['id'];  ?>'
                             class='form-control rounded' type='text'
                             value='<?php echo $slug['slug_'.$lang];  ?>'>
                    </div>
                      <?php
                  }
                  ?>
              </div>
             </div>
          </div>
        </div>
      </div>


        <?php

    }


	#region ModalShowContact

	/**
	 * @param $Param
	 * @param $type
	 */
	public function ModalShowContact($Param) {
	    /** @var contactUsModel $contactObj */
	    $contactObj = Load::controller('contactUs');
	    $contact = $contactObj->GetContact($Param);
		?>

		<div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"> مشاهده جزییات تماس <?php echo $contact['name'] ?></h4>
				</div>
				<div class="modal-body">
							<div class="row margin-both-vertical-20">
								<div class="col-md-12 text-center text-bold" style="color: #fb002a;">
									<span>مشخصات کاربر</span></div>
							</div>

							<div class="row margin-both-vertical-20">
								<div class="col-md-4 ">
									<span>نام و نام خانوادگی  : </span><span><?php echo $contact['name'] ?></span>
								</div>
								<div class="col-md-4 ">
									<span class=""> شماره  موبایل: </span><span
											class="yn"><?php echo $contact['mobile'] ?></span>
								</div>
								<div class="col-md-4 ">
									<span>ایمیل :</span><span><?php echo $contact['email'] ?></span>
								</div>
							</div>


							<hr style="margin: 5px 0;"/>

							<div class="row margin-both-vertical-20">
								<div class="col-md-12 text-center text-bold" style="color: #fb002a;"><span>متن پیام </span>
								</div>
							</div>

							<div class="row margin-both-vertical-20">
								<div class="col-md-12 ">
									<span><?php echo $contact['comment'] ?></span>
								</div>
								<div class="col-md-6 mt-2">
									<span>در تاریخ :</span><span class="pull-right"><?php echo functions::ConvertToJalaliOfDateGregorian($contact['created_at']); ?></span>
								</div>
<!--								<div class="col-md-6 mt-2">-->
<!--									<span>آژانس :</span>-->
<!--									<span>--><?php //echo $contact['agency_id'] == 0 ? 'آژانس اصلی' : $contact['name_fa']; ?><!--</span>-->
<!---->
<!---->
<!--								</div>-->
							</div>
				</div>
			</div>

		</div>

		<?php
	}

	#endregion


		#region modalAddRules

	/**
	 * @param $Param
	 * @param $type
	 */
	public function modalAddRules($Param) {
		?>
		<div class="modal-dialog modal-lg">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"> افزودن قانون جدید</h4>
				</div>
				<div class="modal-body">

							<div class="row margin-both-vertical-20">
								<div class="col-md-12 ">
									<span>عنوان قانون </span>
									<input type="text" class="form-control" name="rule" id="rule">
								</div>
								<div class="col-md-12 ">
									<span class=""> متن قانون: </span>
									<textarea class="form-control ckeditor" name="contentRules" id="contentRules"></textarea>
								</div>

								<div class="col-md-12 ">

									<button type='button' onclick="sendDataForInsertRules('<?php echo $Param ?>')" id='btn_create_new_rule_category' class="fcbtn btn btn-outline btn-info "><?php echo functions::Xmlinformation("Sendinformation") ?></button>
								</div>
							</div>

				</div>
			</div>

		</div>
    <script>
    if ($('#contentRules').length) {
    CKEDITOR.replace('contentRules')
    }
    </script>

		<?php
	}

	#endregion



	public function modalEditCategoryRule($Param) {


    $ruleController = Load::controller('rules');
            $category = $ruleController->getCategory($Param);

		?>
		<div class="modal-dialog modal-lg">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">ویرایش دسته بندی</h4>
				</div>
				<div class="modal-body">

							<div class="row margin-both-vertical-20">
								<div class="col-md-6 mb-3">
									<span>عنوان دسته بندی </span>
									<input type="text" value='<?php echo $category['title']?>' class="form-control" name="edited_rule_category" id="edited_rule_category">
								</div>
                <div class="col-md-6 mb-3">
									<span>عنوان انگلیسی </span>
									<input type="text" value='<?php echo $category['slug']?>' class="form-control"  name="edited_slug_category" id="edited_slug_category">
								</div>

								<div class="col-md-12 mb-3">
                  <label for="title" class="control-label" style='margin: 10px 0'>آیکون ها</label>

									<div class="col-md-12 mb-3 IconBox ">
									  <?php
                                        $icons=[
                                            'fa fa-plane',
                                            'fa fa-hand-o-left',
                                            'fa fa-hospital-o',
                                            'fa fa-home',
                                            'fa fa-building',
                                            'fa fa-building-o',
                                            'fa fa-bullhorn',
                                            'fa fa-bus',
                                            'fa fa-tachometer',
                                            'fa fa-train',
                                            'fa fa-truck',
                                            'fa fa-sliders',
                                            'fa fa-bicycle',
                                            'fa fa-automobile',
                                            'fa fa-wheelchair',
                                            'fa fa-user',
                                            'fa fa-product-hunt',
                                            'fa fa-globe',
                                            'fa fa-heartbeat',
                                            'fa fa-heart',
                                            'fa fa-tags',
                                            'fa fa-cc-visa',
                                            'fa fa-asterisk',
                                            'fa fa-check',
                                            'fa fa-calculator',
                                            'fa fa-dollar',];
                                        foreach($icons as $icon){
                                            ?>
                                            <div data-target="IconBoxSelector" data-value="<?php echo $icon; ?>"
                                                 class="col-md-1 text-center item mb-3">
                                                <div class="border text-center <?php if($icon == $category['icon']) echo 'active'; ?>" onclick="selectCategoryIcon($(this),'<?php echo $icon; ?>')">
                                                    <span class="<?php echo $icon; ?>"></span>
                                                </div>
                                            </div>
                                        <?php } ?>

										</div>
									<input type="hidden" value='<?php echo $category['icon']?>' class="form-control" name="edited_icon_category" id="edited_icon_category">
								</div>


								<div class="col-md-12 ">

									<button type='button' onclick="sendDataForEditRuleCategory('<?php echo $Param ?>')" id='btn_edit_rule_category' class="fcbtn btn btn-outline btn-info "><?php echo functions::Xmlinformation("Sendinformation") ?></button>
								</div>
							</div>

				</div>
			</div>

		</div>

		<?php
	}



		#region ModalShowContact

	/**
	 * @param $Param
	 * @param $type
	 */
	public function modalEditRules($Param) {

	    /** @var rules $ruleController */
            $ruleController = Load::controller('rules');
            $resultFetchRule = $ruleController->getRule($Param);

            /** @var rulesCategory $rulesCategoryController */
                $rulesCategoryController = Load::controller('rulesCategory');
                $resultFetchRulesCategory = $rulesCategoryController->getAllCategories();

		?>
		<div class="modal-dialog modal-lg">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"> ویرایش قانون</h4>
				</div>
				<div class="modal-body">

							<div class="row margin-both-vertical-20">
								<div class="col-md-6 ">
									<span>دسته بندی قانون </span>
									<select class="form-control" id="rulesCategory" name="rulesCategory">
									<?php
									    foreach ($resultFetchRulesCategory as $key=>$item) {?>
									        <option value="<?php echo $item['id']?>" <?php echo ($item['id']==$resultFetchRule['category_id']) ? 'selected' : ''?>>
									        <?php echo $item['title']?>
									        </option>
									    <?php }
									?>
</select>
								</div>
								<div class="col-md-6 ">
									<span>عنوان قانون </span>
									<input type="text" class="form-control" name="rule" id="rule" value="<?php echo $resultFetchRule['title']?>">
								</div>
								<div class="col-md-12 ">
									<span class=""> متن قانون: </span>
									<textarea class="form-control ckeditor" name="contentRules" id="contentRules"><?php echo $resultFetchRule['content']?></textarea>
								</div>

								<div class="col-md-12 ">
									<input class="fcbtn btn btn-outline btn-info "  type="button"  value="<?php echo functions::Xmlinformation("Sendinformation") ?> "
									onclick="sendDataForEditRules('<?php echo $Param ?>')">
								</div>
							</div>

				</div>
			</div>

		</div>
    <script>
      if ($('#contentRules').length) {
        CKEDITOR.replace('contentRules')
      }
    </script>
		<?php
	}

	#endregion


#region ModalShowVisaBookSms
public function ModalVisaShowSms($params){
	    $sms_content = $params['sms_content'];
	    $mobile = $params['mobile'];
    ?>
    <div class="modal-dialog modal-lg">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header site-bg-main-color">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">ارسال پیامک به مشتری ؟</h4>
				</div>
				<div class="modal-body">
                    <div class="form-group">
                        <label for="mobile" class="control-label">شماره موبایل مشتری</label>
                        <input class="form-control" id="mobile" readonly value="<?php echo $mobile;?>" />
                    </div>
                    <div class="form-group">
                        <label for="notification_content" class="control-label">متن پیامک</label>
                        <textarea name="notification_content" id="notification_content" class="form-control"><?php echo $sms_content; ?></textarea>
                    </div>
				</div>
				<div class="modal-footer">
				    <button class="btn btn-primary sendVisaStatusSms" type="button">ارسال پیامک</button>
				    <button class="btn btn-default" type="button" data-dismiss="modal">انصراف</button>
				</div>
			</div>
		</div>
<?php }
#endregion

  public function modalUpdatePriceChangeHotel($param){
      ?>
        <div class="modal-dialog modal-lg">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header site-bg-main-color">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">ویرایش تغییرات قیمت</h4>
              </div>
            <div class="modal-body">
              <div class="form-group col-sm-6">
                  <label for="price_type" class="control-label">نوع تغییر</label>
                    <select name='price_type' id='price_type' class='form-control'>
                    <option value=''>انتخاب کنید</option>
                    <option value='percent'>درصدی</option>
                    <option value='cost'>ریالی</option>
                    </select>
              </div>
              <div class="form-group col-sm-6">
                  <label for="price" class="control-label">میزان تغییر</label>
                  <input type='text' id='price' class='form-control' name='price' value='' >
              </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" onclick="updatePriceChange('<?php echo $param?>')">ارسال اطلاعات</button>
            </div>
          </div>
        </div>
      <?php
  }
    #region ShowPopUp
    	public function ModalShowPopUp($param) {

        $popController = Load::controller($this->Controller);

        $creat_pop_up = $popController->ModalShowPopUp();

        if($creat_pop_up != false) {
      ?>
      <div class="modal fade in" id="" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: block">
        <div class="modal-dialog modal-lg">
          <div class="modal-content modal-content-custom">
              <div class="modal-body">
                 <div class="d-flex justify-content-between align-items-center">
      <button type="button" class="close" onclick="close_modal_pop_up()" data-dismiss="modal">×</button>
        <?php
        foreach ($creat_pop_up as $key=>$item) {?>
           <h2 class="modal-title-popup"><?php echo $item['title']?></h2>
                 </div>
<div>
          <picture>
            <source srcset="<?php echo $item['pic']?>" media="(min-width:992px)">
            <source media="(min-width:650px)" srcset="<?php echo $item['pic_sample']?>">
            <source media="(min-width:100px)" srcset="<?php echo $item['pic_mobile']?>">
            <img src="<?php echo $item['pic']?>" alt="<?php echo $item['title']?>"  width="100%">

          </picture>
            <p class="modal-desc-popup"><?php echo $item['description']?></p>
</div>
        <?php
        }
        ?>
              </div>
          </div>
        </div>
        </div>
    <?php
    }
  }
    #endregion



    #region requestServiceOffline

    public function requestServiceOffline($Param) {
        $member_id = Session::getUserId();
        if(isset($member_id) && !empty($member_id)) {
            $member = $this->getController('members')->getMember();
        }

        $InfoRequestOffline = json_decode($Param, true);

    ?>

      <div class="modal-header site-bg-main-color" style="display: block !important;">
        <div class="d-flex justify-content-between align-content-center w-100 h-100 site-bg-main-color">
          <div class='col-12 d-flex justify-content-between'>
            <h5 class="modal-h m-0"><?php echo functions::Xmlinformation("RequestOffline"); ?></h5>
            <span class="close cursor-pointer ml-0 mr-auto text-white px-0 py-3" data-dismiss="modal">&times;</span>
          </div>

        </div>
      </div>
      <div class="modal-body">
        <div class="row modal-padding-bottom-15 " style="display: block !important;">
          <div class="row" style="display: block !important;">
            <div class="col-md-12 modal-text-center modal-h" style="display: block !important;">
                <?php echo functions::Xmlinformation("RequestOfflineInfo"); ?>
            </div>
          </div>
          <div class="row ReservationRequest">
            <input type="hidden" name="infoRequestOffline" id="infoRequestOffline" value='<?php echo $Param ?>'>
            <div class="col-12 pt-3 ">
              <label style="float:right;"> <?php echo functions::Xmlinformation("Namefamily"); ?></label>
              <input class="form-control " type="text" id="fullName" name="fullName" value='<?php echo isset($member) ? $member['name'].' '.$member['family'] : '' ?>'>
            </div>
            <div class="col-12 pt-3 ">
              <label style="float:right;"> <?php echo functions::Xmlinformation("Phonenumber"); ?></label>
              <input class="form-control " type="text" id="mobile" name="mobile" value='<?php echo isset($member) ? $member['mobile']  : '' ?>'>
            </div>
            <div class="col-12 pt-3 ">
              <label style="float:right;"> <?php echo functions::Xmlinformation("Description"); ?></label>
              <input class="form-control " type="text" id="description" name="description">
            </div>
            <div class="col-12 d-flex justify-content-center align-content-center pt-3 mt-1">
              <input class="button_SMSReservationRequest" onclick="RequestServiceOffline()" type="button" value=" <?php echo functions::Xmlinformation("Submitapplication"); ?>">
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
}

    #endregion


    public function ModalPassengerDetails($Param)
    {

        $user = Load::controller($this->Controller);
        $Tickets = functions::info_flight_client($Param);

        ?>

      <div class="modal_custom" onclick="closeModalParent(event)">
        <div class="container">
          <div class="main_modal_custom">
            <div class="scrollIng_model">
              <div class="header_modal_custom">
               <h2><?php echo functions::Xmlinformation("Viewpurchasetobookingnumber") ?>
                  :<?php echo $Param; ?> </h2>
                <button onclick="closeModal()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256L7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256L312.1 375z"/></svg></button>
              </div>
            <div class="center_modal_custom">
                <div class="box-style">
                  <div class="box-style-padding">
                    <div>
                      <div class="header_modal_custom p-0 w-100 modal-header">
                        <h2><?php echo functions::Xmlinformation("PassengerListProfile  ") ?></h2>
                      </div>
                      <div class="table-responsive-lg my-1">
                            <table class="min-w-900px table table-bordered">
                              <thead>
                              <tr>
                                  <th scope="col"><?php echo functions::Xmlinformation("Namefamily") ?></th>
                                  <th scope="col"><?php echo functions::Xmlinformation("Nationalnumber"); ?> / <?php echo functions::Xmlinformation("Passport"); ?></th>
                                  <th scope="col"><?php echo functions::Xmlinformation("DateOfBirth") ?></th>
                                  <th scope="col"><?php echo functions::Xmlinformation("Ticketnumber") ?></th>
                                  <th scope="col"><?php echo functions::Xmlinformation("TotalPrice") ?></th>
                              </tr>
                              </thead>
                              <tbody>
                              <?php foreach ($Tickets as $key => $view) { ?>
                                  <tr>
                                    <th><?php echo $view['passenger_name_en'] . ' ' . $view['passenger_family_en'] ?></th>
                                    <td><?php echo ($view['passenger_national_code'] != '0000000000') ? $view['passenger_national_code'] : $view['passportNumber'] ?></td>
                                    <td><?php echo (!empty($view['passenger_birthday'])) ? $view['passenger_birthday'] : $view['passenger_birthday_en'] ?></td>
                                    <td><?php echo $view['eticket_number']; ?></td>
                                    <td><?php echo $view['adt_price']; ?>


                                      <br>
                                        <?php

                                        $priceFlight = functions::getMemberCreditPayment($view['tracking_code_bank'], $view['adt_price'] ) ;
                                        $credit_price_flight = $priceFlight[0];
                                        $bank_price_flight = $priceFlight[1];
                                        if ($credit_price_flight > 0 ){
                                            ?>
                                          <br>
                                            <span>
                                           پرداخت اعتباری : <?php echo  $credit_price_flight ?>
                                            </span>
                                                            <br>
                                                            <span>
                                                 پرداخت بانکی :  <?php echo $bank_price_flight ?>
                                            </span>
                                            <?php
                                        }
                                        ?>

                                    </td>
                                  </tr>
                              <?php } ?>
                              </tbody>
                            </table>
                          </div>


                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <script>
        function closeModal(){
          $(".modal_custom").remove()
          $("body,html").removeClass("overflow-hidden");
        }
      </script>

        <?php

    }


    public function ModalPassengerExclusiveTourDetails($Param)
    {

        $user = Load::controller($this->Controller);
        $Tickets = functions::info_exclusive_tour_client($Param);

        ?>

       <div class="modal_custom" onclick="closeModalParent(event)">
          <div class="container">
             <div class="main_modal_custom">
                <div class="scrollIng_model">
                   <div class="header_modal_custom">
                      <h2><?php echo functions::Xmlinformation("Viewpurchasetobookingnumber") ?>
                         :<?php echo $Param; ?> </h2>
                      <button onclick="closeModal()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256L7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256L312.1 375z"/></svg></button>
                   </div>
                   <div class="center_modal_custom">
                      <div class="box-style">
                         <div class="box-style-padding">
                            <div>
                               <div class="header_modal_custom p-0 w-100 modal-header">
                                  <h2><?php echo functions::Xmlinformation("PassengerListProfile  ") ?></h2>
                               </div>
                               <div class="table-responsive-lg my-1">
                                  <table class="min-w-900px table table-bordered">
                                     <thead>
                                     <tr>
                                        <th scope="col"><?php echo functions::Xmlinformation("Namefamily") ?></th>
                                        <th scope="col"><?php echo functions::Xmlinformation("Nationalnumber"); ?> / <?php echo functions::Xmlinformation("Passport"); ?></th>
                                        <th scope="col"><?php echo functions::Xmlinformation("DateOfBirth") ?></th>
                                        <th scope="col"><?php echo functions::Xmlinformation("Nation") ?></th>
                                     </tr>
                                     </thead>
                                     <tbody>
                                     <?php foreach ($Tickets as $key => $view) { ?>
                                        <tr>
                                           <th><?php echo $view['passenger_name'] . ' ' . $view['passenger_family'] ?></th>
                                           <td><?php echo ($view['passenger_national_code'] != '0000000000') ? $view['passenger_national_code'] : $view['passportNumber'] ?></td>
                                           <td><?php echo (!empty($view['passenger_birthday'])) ? $view['passenger_birthday'] : $view['passenger_birthday'] ?></td>
                                           <td><?php echo $view['passportCountry']; ?></td>
                                           </td>
                                        </tr>
                                     <?php } ?>
                                     </tbody>
                                  </table>
                               </div>


                            </div>
                         </div>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>

      <script>
        function closeModal(){
          $(".modal_custom").remove()
          $("body,html").removeClass("overflow-hidden");
        }
      </script>

        <?php

    }


  public function ModalCancelItem($Param, $param2)
    {
        $user = Load::controller($this->Controller);
        $InfoCancelTicket = $user->InfoModalTicketCancel($Param, $param2);


        if (isset($param2) && $param2 == 'flight') {
            $Fee = functions::FeeCancelFlight($InfoCancelTicket[0]['airline_iata'], $InfoCancelTicket[0]['cabin_type']);
        }
        ?>

      <div class="modal_custom" onclick="closeModalParent(event)">
        <div class="container">
          <div class="main_modal_custom">
            <div class="scrollIng_model">
              <div class="header_modal_custom">
                <h2><?php echo functions::Xmlinformation("CancelPurchase") ?></h2>
                <input type="hidden" name="typeService" id="typeService" value="<?php echo $param2 ?>">
                <button onclick="closeModal()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256L7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256L312.1 375z"/></svg></button>
              </div>
              <div class="center_modal_custom">
                <div class="modal-padding-bottom-15">
                  <div>
                    <div class="w-100 modal-text-center modal-h ">   <?php echo functions::Xmlinformation("Pleaseselectthedesiredpassenger") ?></div>
                  </div>
                  <div>
                  <div class="w-100 table-responsive-lg">
                    <table class="min-w-800px table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th scope="col"><?php echo functions::Xmlinformation("Select") ?></th>
                          <th scope="col"><?php echo functions::Xmlinformation("Name") ?></th>
                          <th scope="col"><?php echo functions::Xmlinformation("Nationalnumber") ?></th>
                          <th scope="col"><?php echo functions::Xmlinformation("Passport") ?></th>
                          <th scope="col"><?php echo functions::Xmlinformation("DateOfBirth") ?></th>
                          <th scope="col"><?php echo functions::Xmlinformation("Age") ?></th>
                          <th scope="col"><?php echo functions::Xmlinformation("Status") ?></th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php
                          foreach ($InfoCancelTicket as $i => $info) {
                          if($param2 == 'bus'){
                              $info['passenger_age'] = 'Adt';
                              $info['factor_number'] = $info['passenger_factor_num'];
                              $NationalCodeUser = $info['passenger_national_code'];
                          }else{
                              $NationalCodeUser = $info['NationalCode'];
                          }
                          if ($i < 1) {
                              ?>
                            <input type="hidden" value="<?php echo $info['factor_number'] ?>" name="FactorNumber"
                                   id="FactorNumber"/>
                            <input type="hidden" value="<?php echo $info['member_id'] ?>" name="MemberId"
                                   id="MemberId"/>
                              <?php
                          }
                          ?>
                          <tr>
                            <th><input class="form-control SelectUser" type="checkbox" name="SelectUser[]" id="SelectUser" value="<?php echo ($info['passenger_national_code'] != '0000000000') ? $info['passenger_national_code'] . '-' . $info['passenger_age'] : $info['passportNumber'] . '-' . $info['passenger_age'] ?>" <?php echo (!empty($info['Status']) && !empty($NationalCodeUser) && ($info['Status'] != 'Nothing' && $info['Status'] != 'close')) ? 'disabled ="disabled"' : '';?>></th>
                            <th><?php echo $info['passenger_name'] . ' ' . $info['passenger_family']; ?></th>
                            <th><?php echo $info['passenger_national_code']; ?></th>
                            <th><?php echo $info['passportNumber']; ?></th>
                            <th><?php echo (!empty($info['passenger_birthday'])) ? $info['passenger_birthday'] : $info['passenger_birthday_en'] ?></th>
                            <th><?php
                                  switch ($info['passenger_age']) {

                                      case 'Adt':
                                          echo functions::Xmlinformation("Adult");
                                          break;

                                      case 'Chd':
                                          echo functions::Xmlinformation("Child");
                                          break;

                                      case 'Inf':
                                          echo functions::Xmlinformation("Baby");
                                          break;
                                  }
                                  ?></th>
                            <th>
                              <?php
                              if (!empty($info['Status']) && !empty($NationalCodeUser) && $info['Status'] != 'Nothing') {
                                  if ($info['Status'] == 'SetCancelClient') {
                                      ?>
                                    <div class="badge badge-danger p-2"><?php echo functions::Xmlinformation("Deniedrequest") ?></div>
                                      <?php
                                  } elseif($info['Status'] !='close')  {
                                      ?>
                                    <div class="badge badge-info p-2"><?php echo functions::Xmlinformation("Actionhasalreadybeentaken") ?></div>

                                      <?php
                                  }
                              }
                              ?>
                            </th>
                          </tr>
                          <?php } ?>
                      </tbody>
                    </table>
                  </div>
                  </div>


                  <div class="mr-auto d-flex nopad align-items-center">
                    <div class="input_s d-flex justify-content-center align-items-center">
                      <input onchange='inputDisabled(event)' class="form-control" type="checkbox" id="backCredit" name="backCredit">
                    </div>
                    <label for='backCredit' class="mr-2 lh45 mb-0">
                      به کیف پول من برگردانده شود
                    </label>
                  </div>

                    <?php
//                    if (functions::TypeUser(Session::getUserId()) == 'Ponline') {
                        ?>

                      <div class="row">

                        <div class="col-md-12 modal-text-center modal-h ">
                          <label for="ReasonUser"><?php echo functions::Xmlinformation("Pleaseenteryourinformationreturningmoneyyouraccount") ?></label>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 nopad  " style="direction: rtl;margin: 10px">
                          <label style="float:right;"><?php echo functions::Xmlinformation("CardOrShebanumber") ?></label>

                          <input class="form-control input-disabled-js" type="text" id="CardNumber" name="CardNumber"
                                 style="float: right;margin-right: 10px">
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 nopad  " style="direction: rtl;margin: 10px">
                          <label style="float:right;"><?php echo functions::Xmlinformation("Namebankowner") ?></label>
                          <input class="form-control input-disabled-js" type="text" id="AccountOwner" name="AccountOwner"
                                 style="float: right;margin-right: 10px">
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12 nopad  " style="direction: rtl;margin: 10px">
                          <label style="float:right;"><?php echo functions::Xmlinformation("Cardname") ?></label>
                          <input class="form-control input-disabled-js" type="text" id="NameBank" name="NameBank"
                                 style="float: right;margin-right: 10px">
                        </div>
                      </div>
                    <?php
//    }

                    if (isset($param2) && $param2 == 'flight') {
                        if (!empty($Fee) && strtolower($InfoCancelTicket[0]['flight_type']) == 'system') {
                            ?>
                          <div class="cancel-policy cancel_modal">
                            <div class="cancel-policy-head">
                              <div class="cancel-policy-head-text"><?php echo functions::Xmlinformation("DetailMoneyCancel") ?></div>
                              <div class="cancel-policy-class">
                            <span><?php echo functions::Xmlinformation("Classflight") ?>
                            :</span>
                                <span> <?php echo $Fee['TypeClass'] ?> </span></div>
                            </div>
                            <div class="cancel-policy-inner">
                              <div class="cancel-policy-item cancel_modal">
                                <span class="cancel-policy-item-text"><?php echo functions::Xmlinformation("Fromthetimeticketissueuntilnoondaysbeforeflight") ?></span>
                                <span class="cancel-policy-item-pnalty site-bg-main-color"><?php echo is_numeric($Fee['ThreeDaysBefore']) ? $Fee['ThreeDaysBefore'] . functions::Xmlinformation("PenaltyPercent") : $Fee['ThreeDaysBefore']; ?> </span>
                              </div>

                              <div class="cancel-policy-item cancel_modal">
                                <span class="cancel-policy-item-text"><?php echo functions::Xmlinformation("Fromnoondaysbeforeflightnoondaybeforeflight") ?></span>
                                <span class="cancel-policy-item-pnalty site-bg-main-color"><?php echo is_numeric($Fee['OneDaysBefore']) ? $Fee['OneDaysBefore'] . functions::Xmlinformation("PenaltyPercent") : $Fee['OneDaysBefore']; ?> </span>
                              </div>
                              <div class="cancel-policy-item cancel_modal">

                                <span class="cancel-policy-item-text"><?php echo functions::Xmlinformation("Fromnoondaybeforeflighthoursbeforeflight") ?></span>
                                <span class="cancel-policy-item-pnalty site-bg-main-color"><?php echo is_numeric($Fee['ThreeHoursBefore']) ? $Fee['ThreeHoursBefore'] . functions::Xmlinformation("PenaltyPercent") : $Fee['ThreeHoursBefore']; ?> </span>
                              </div>
                              <div class="cancel-policy-item cancel_modal">
                                  <?php echo functions::Xmlinformation("Fromnoondaybeforeflighthoursbeforeflight") ?>
                                <span class="cancel-policy-item-text"><?php echo functions::Xmlinformation("Fromhoursbeforeflighttominutesbeforeflight") ?></span>
                                <span class="cancel-policy-item-pnalty site-bg-main-color"><?php echo is_numeric($Fee['ThirtyMinutesAgo']) ? $Fee['ThirtyMinutesAgo'] . functions::Xmlinformation("PenaltyPercent") : $Fee['ThirtyMinutesAgo']; ?> </span>
                              </div>

                              <div class="cancel-policy-item cancel_modal">
                                <span class="cancel-policy-item-text">   <?php echo functions::Xmlinformation("Minutesbeforetheflight") ?></span>
                                <span class="cancel-policy-item-pnalty site-bg-main-color"><?php echo is_numeric($Fee['OfThirtyMinutesAgoToNext']) ? $Fee['OfThirtyMinutesAgoToNext'] . functions::Xmlinformation("PenaltyPercent") : $Fee['OfThirtyMinutesAgoToNext']; ?> </span>
                              </div>
                            </div>
                          </div>
                        <?php } else if (empty($Fee) && strtolower($InfoCancelTicket[0]['flight_type']) == 'system') { ?>
                          <div class="cancel-policy cancel_modal cancel-policy-charter1">
                            <div class="cancel-policy-head">

                              <div class="cancel-policy-head-text"><?php echo functions::Xmlinformation("DetailMoneyCancel") ?></div>
                            </div>
                            <span><?php echo functions::Xmlinformation("Contactbackupunitinformationaboutamountconsignmentfines") ?></span>
                          </div>

                        <?php } else { ?>
                          <div class="cancel-policy cancel_modal cancel-policy-charter1">
                            <div class="cancel-policy-head">
                              <div class="cancel-policy-head-text"><?php echo functions::Xmlinformation("DetailMoneyCancel") ?></div>
                            </div>
                            <span><?php echo functions::Xmlinformation("ThecharterflightscharterunderstandingCivilAviationOrganization") ?></span>
                          </div>
                            <?php
                        }
                    }
                    ?>
                  <div class='mt-4'>
                    <div class="w-100 modal-text-center modal-h mb-0">
                      <label class="mb-0" for="ReasonUser"><?php echo functions::Xmlinformation("Pleaseselectyourdesiredoptions") ?></label>
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-12  nopad ">
                      <select class="form-control mart5" name="ReasonUser"
                              id="ReasonUser">
                        <option value=""> <?php echo functions::Xmlinformation("Choosereasonfortheconsole") ?></option>
                        <option value="PersonalReason"><?php echo functions::Xmlinformation("Canselforpersonalreasons") ?></option>
                          <?php if (isset($param2) && $param2 == 'flight') { ?>
                            <option value="DelayTwoHours"><?php echo functions::Xmlinformation("Delaymorethantwohours") ?></option>
                            <option value="CancelByAirline"><?php echo functions::Xmlinformation("AbandonedbyAirline") ?></option>
                          <?php } elseif($param2 == 'train') { ?>
                            <option value="DelayTwoHours"><?php echo functions::Xmlinformation("delayTrain") ?></option>
                          <?php }else{
                              //else
                          } ?>
                      </select>
                    </div>

                      <?php
                      if (isset($param2) && $param2 == 'flight') {
                          if (empty($Fee) && strtolower($InfoCancelTicket[0]['flight_type']) != 'system') { ?>
                            <div class='d-flex align-items-center mt-4'>
                              <div class='d-flex justify-content-center align-items-center'>
                                <input type="checkbox" id="PercentNoMatter" name="PercentNoMatter">
                              </div>
                              <div class='mr-2'>
                                  <?php echo functions::Xmlinformation("Idonotcareaboutthepercentagepenaltypleasebesurecancel") ?>
                              </div>
                            </div>
                          <?php }
                      } ?>
                    <div class="mr-auto d-flex nopad align-items-center">
                      <div class="input_s d-flex justify-content-center align-items-center">
                        <input class="form-control" type="checkbox" id="Ruls" name="Ruls">
                      </div>
                      <div class="mr-2 lh45">
                          <?php echo functions::Xmlinformation("Iam") ?> <a
                          href="<?php echo URL_RULS ?>"
                          style="margin-top: 5px"><?php echo functions::Xmlinformation("Seerules") ?></a> <?php echo functions::Xmlinformation("IhavestudiedIhavenoobjection") ?>
                      </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                      <div class="DescriptionReason showContentTextModal" style="display : none"></div>
                    </div>
                  </div>
                  <div class="row">
                      <?php
                      if (isset($param2) && $param2 == 'train') {
                          ?>
                        <ol class="list-group">
                          <li class="list-group-item"><?php echo functions::Xmlinformation("liOneTrainCancel") ?></li>
                          <li class="list-group-item"><?php echo functions::Xmlinformation("liTwoTrainCancel") ?></li>
                          <li class="list-group-item"><?php echo functions::Xmlinformation("liTreeTrainCancel") ?></li>
                          <li class="list-group-item"><?php echo functions::Xmlinformation("liFourTrainCancel") ?></li>
                        </ol>
                      <?php }
                      ?>
                  </div>
                <div class="box_btn my-4 pb-4 w-100" style='margin-bottom: 10px; float: left'>
                  <button class="btn-send-information pull-left btn-cancel site-bg-main-color site-bg-main-color-hover d-flex justify-content-center align-items-center" id='btn-information' onclick="SelectUser('<?php echo $Param ?>')">
                      <?php echo functions::Xmlinformation("Sendinformation") ?>
                    <div class="spinner-border" id='btn-send-information-load' role="status">
                      <span class="sr-only">Loading...</span>
                    </div>
                  </button>
                </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>

      <script>
        function closeModal(){
          $(".modal_custom").remove()
          $("body,html").removeClass("overflow-hidden");
        }
      </script>

        <?php

    }

    public function ModalCancelFlightAdmin($Param, $param2)
    {
        $user = Load::controller($this->Controller);
        $InfoCancelTicket = $user->InfoModalTicketCancel($Param, $param2);

        $cancelTicketDetailsModel = $this->getModel('cancelTicketDetailsModel');
        $InfoCancel = $cancelTicketDetailsModel
            ->get('*')
            ->where('RequestNumber', $Param)
            ->find(false);

        $infoMember = functions::infoMember($InfoCancel['MemberId']);
        $InfoFlight = functions::InfoFlight($Param);


        if (isset($param2) && $param2 == 'flight') {
            $Fee = functions::FeeCancelFlight($InfoCancelTicket[0]['airline_iata'], $InfoCancelTicket[0]['cabin_type']);
        }
        ?>

             <div class="modal-dialog modal-lg modal-cancel-flight-admin">
                <div class="modal-content">
                   <div class="modal-header site-bg-main-color p-4">
                      <button type="button" class="close" data-dismiss="modal">×</button>
                      <h4 class="modal-title">کنسل کردن بلیط</h4>
                      <input type="hidden" name="typeService" id="typeService" value="<?php echo $param2 ?>">
                   </div>
                   <div class="center_modal_custom p-4">
                      <div class="modal-padding-bottom-15">
                         <div>
                            <div class="w-100 modal-text-center modal-h ">   <?php echo functions::Xmlinformation("Pleaseselectthedesiredpassenger") ?></div>
                         </div>
                         <div>
                            <div class="w-100 table-responsive-lg">
                               <table class="min-w-800px table table-striped table-bordered">
                                  <thead>
                                  <tr>
                                     <th scope="col"><?php echo functions::Xmlinformation("Select") ?></th>
                                     <th scope="col"><?php echo functions::Xmlinformation("Name") ?></th>
                                     <th scope="col"><?php echo functions::Xmlinformation("Nationalnumber") ?></th>
                                     <th scope="col"><?php echo functions::Xmlinformation("Passport") ?></th>
                                     <th scope="col"><?php echo functions::Xmlinformation("DateOfBirth") ?></th>
                                     <th scope="col"><?php echo functions::Xmlinformation("Age") ?></th>
                                     <th scope="col"><?php echo functions::Xmlinformation("Status") ?></th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  <?php
                                  foreach ($InfoCancelTicket as $i => $info) {
                                      if($param2 == 'bus'){
                                          $info['passenger_age'] = 'Adt';
                                          $info['factor_number'] = $info['passenger_factor_num'];
                                          $NationalCodeUser = $info['passenger_national_code'];
                                      }else{
                                          $NationalCodeUser = $info['NationalCode'];
                                      }
                                      if ($i < 1) {
                                          ?>
                                         <input type="hidden" value="<?php echo $info['factor_number'] ?>" name="FactorNumber"
                                                id="FactorNumber"/>
                                         <input type="hidden" value="<?php echo $info['member_id'] ?>" name="MemberId"
                                                id="MemberId"/>
                                          <?php
                                      }
                                      ?>
                                     <tr>
                                        <th><input class="form-control SelectUser" type="checkbox" name="SelectUser[]" id="SelectUser" value="<?php echo ($info['passenger_national_code'] != '0000000000') ? $info['passenger_national_code'] . '-' . $info['passenger_age'] : $info['passportNumber'] . '-' . $info['passenger_age'] ?>" <?php echo (!empty($info['Status']) && !empty($NationalCodeUser) && ($info['Status'] != 'Nothing' && $info['Status'] != 'close')) ? 'disabled ="disabled"' : '';?>></th>
                                     <?php
                                     if ($param2 == 'bus') {
                                        ?>
                                        <th><?php echo $info['passenger_name'] . ' ' . $info['passenger_family']; ?></th>
                                       <?php } else { ?>
                                        <th><?php echo $info['passenger_name_en'] . ' ' . $info['passenger_family_en']; ?></th>
                                         <?php } ?>
                                        <th><?php echo $info['passenger_national_code']; ?></th>
                                        <th><?php echo $info['passportNumber']; ?></th>
                                        <th><?php echo (!empty($info['passenger_birthday'])) ? $info['passenger_birthday'] : $info['passenger_birthday_en'] ?></th>
                                        <th><?php
                                            switch ($info['passenger_age']) {

                                                case 'Adt':
                                                    echo functions::Xmlinformation("Adult");
                                                    break;

                                                case 'Chd':
                                                    echo functions::Xmlinformation("Child");
                                                    break;

                                                case 'Inf':
                                                    echo functions::Xmlinformation("Baby");
                                                    break;
                                            }
                                            ?></th>
                                        <th>
                                            <?php
                                            if (!empty($info['Status']) && !empty($NationalCodeUser) && $info['Status'] != 'Nothing') {
                                                if ($info['Status'] == 'SetCancelClient') {
                                                    ?>
                                                   <div class="badge badge-danger p-2"><?php echo functions::Xmlinformation("Deniedrequest") ?></div>
                                                    <?php
                                                } elseif($info['Status'] !='close')  {
                                                    ?>
                                                   <div class="badge badge-info p-2"><?php echo functions::Xmlinformation("Actionhasalreadybeentaken") ?></div>

                                                    <?php
                                                }
                                            }
                                            ?>
                                        </th>
                                     </tr>
                                  <?php } ?>
                                  </tbody>
                               </table>
                            </div>
                         </div>
                         <div class="col-md-3 col-lg-3 col-sm-12  nopad ">
                            <label class="mb-0" for="ReasonUser"><?php echo functions::Xmlinformation("Pleaseselectyourdesiredoptions") ?></label>
                            <select class="form-control mart5" name="ReasonUser"
                                    id="ReasonUser">
                               <option value=""> <?php echo functions::Xmlinformation("Choosereasonfortheconsole") ?></option>
                               <option value="PersonalReason"><?php echo functions::Xmlinformation("Canselforpersonalreasons") ?></option>
                                <?php if (isset($param2) && $param2 == 'flight') { ?>
                                   <option value="DelayTwoHours"><?php echo functions::Xmlinformation("Delaymorethantwohours") ?></option>
                                   <option value="CancelByAirline"><?php echo functions::Xmlinformation("AbandonedbyAirline") ?></option>
                                <?php } elseif($param2 == 'train') { ?>
                                   <option value="DelayTwoHours"><?php echo functions::Xmlinformation("delayTrain") ?></option>
                                <?php }else{
                                    //else
                                } ?>
                            </select>
                         </div>
                          <?php
                          if (isset($param2) && $param2 == 'flight') {
                              if (empty($Fee) && strtolower($InfoCancelTicket[0]['flight_type']) != 'system') { ?>
                                 <div class='d-flex align-items-center mt-4'>
                                    <div class='d-flex justify-content-center align-items-center'>
                                       <input type="checkbox" id="PercentNoMatter" name="PercentNoMatter">
                                    </div>
                                    <div class='mr-2'>
                                        <?php echo functions::Xmlinformation("Idonotcareaboutthepercentagepenaltypleasebesurecancel") ?>
                                    </div>
                                 </div>
                              <?php }
                          } ?>
                          <?php if ($infoMember['fk_counter_type_id'] != '5' && $InfoFlight['payment_type']=='credit'){?>
                             <div class='mt-4'>
                                <div class="form-group">
                                   <div class="col-sm-12">
                                      <div class="checkbox checkbox-info">
                                         <input id="isCreditPayment" name="isCreditPayment" type="checkbox">
                                         <label for="isCreditPayment"> برگشت وجه به اعتبار همکار 	<small>(در صورت تمایل به واریز وجه استرداد شده به اعتبار مربوطه این گزینه را انتخاب کنید)</small></label>
                                      </div>
                                   </div>
                                </div>
                             </div>
                          <?php }?>
                         <div class="mr-auto d-flex nopad align-items-center d-none">
                            <div class="input_s d-flex justify-content-center align-items-center">
                               <input onchange='inputDisabled(event)' class="form-control" type="checkbox" id="backCredit" name="backCredit">
                            </div>
                            <label for='backCredit' class="mr-2 lh45 mb-0">
                               به کیف پول من برگردانده شود
                            </label>
                         </div>
                          <?php
                          //                    if (functions::TypeUser(Session::getUserId()) == 'Ponline') {
                          ?>
                         <div class="row d-none">

                            <div class="col-md-12 modal-text-center modal-h ">
                               <label for="ReasonUser"><?php echo functions::Xmlinformation("Pleaseenteryourinformationreturningmoneyyouraccount") ?></label>
                            </div>
                            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 nopad  " style="direction: rtl;margin: 10px">
                               <label style="float:right;"><?php echo functions::Xmlinformation("CardOrShebanumber") ?></label>

                               <input class="form-control input-disabled-js" type="text" id="CardNumber" name="CardNumber"
                                      style="float: right;margin-right: 10px">
                            </div>
                            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 nopad  " style="direction: rtl;margin: 10px">
                               <label style="float:right;"><?php echo functions::Xmlinformation("Namebankowner") ?></label>
                               <input class="form-control input-disabled-js" type="text" id="AccountOwner" name="AccountOwner"
                                      style="float: right;margin-right: 10px">
                            </div>
                            <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12 nopad  " style="direction: rtl;margin: 10px">
                               <label style="float:right;"><?php echo functions::Xmlinformation("Cardname") ?></label>
                               <input class="form-control input-disabled-js" type="text" id="NameBank" name="NameBank"
                                      style="float: right;margin-right: 10px">
                            </div>
                         </div>
                          <?php
                          //    }

                          if (isset($param2) && $param2 == 'flight') {
                              if (!empty($Fee) && strtolower($InfoCancelTicket[0]['flight_type']) == 'system') {
                                  ?>
                                 <div class="cancel-policy cancel_modal">
                                    <div class="cancel-policy-head">
                                       <div class="cancel-policy-head-text"><?php echo functions::Xmlinformation("DetailMoneyCancel") ?></div>
                                       <div class="cancel-policy-class">
                            <span><?php echo functions::Xmlinformation("Classflight") ?>
                            :</span>
                                          <span> <?php echo $Fee['TypeClass'] ?> </span></div>
                                    </div>
                                    <div class="cancel-policy-inner">
                                       <div class="cancel-policy-item cancel_modal">
                                          <span class="cancel-policy-item-text"><?php echo functions::Xmlinformation("Fromthetimeticketissueuntilnoondaysbeforeflight") ?></span>
                                          <span class="cancel-policy-item-pnalty site-bg-main-color"><?php echo is_numeric($Fee['ThreeDaysBefore']) ? $Fee['ThreeDaysBefore'] . functions::Xmlinformation("PenaltyPercent") : $Fee['ThreeDaysBefore']; ?> </span>
                                       </div>

                                       <div class="cancel-policy-item cancel_modal">
                                          <span class="cancel-policy-item-text"><?php echo functions::Xmlinformation("Fromnoondaysbeforeflightnoondaybeforeflight") ?></span>
                                          <span class="cancel-policy-item-pnalty site-bg-main-color"><?php echo is_numeric($Fee['OneDaysBefore']) ? $Fee['OneDaysBefore'] . functions::Xmlinformation("PenaltyPercent") : $Fee['OneDaysBefore']; ?> </span>
                                       </div>
                                       <div class="cancel-policy-item cancel_modal">

                                          <span class="cancel-policy-item-text"><?php echo functions::Xmlinformation("Fromnoondaybeforeflighthoursbeforeflight") ?></span>
                                          <span class="cancel-policy-item-pnalty site-bg-main-color"><?php echo is_numeric($Fee['ThreeHoursBefore']) ? $Fee['ThreeHoursBefore'] . functions::Xmlinformation("PenaltyPercent") : $Fee['ThreeHoursBefore']; ?> </span>
                                       </div>
                                       <div class="cancel-policy-item cancel_modal">
                                           <?php echo functions::Xmlinformation("Fromnoondaybeforeflighthoursbeforeflight") ?>
                                          <span class="cancel-policy-item-text"><?php echo functions::Xmlinformation("Fromhoursbeforeflighttominutesbeforeflight") ?></span>
                                          <span class="cancel-policy-item-pnalty site-bg-main-color"><?php echo is_numeric($Fee['ThirtyMinutesAgo']) ? $Fee['ThirtyMinutesAgo'] . functions::Xmlinformation("PenaltyPercent") : $Fee['ThirtyMinutesAgo']; ?> </span>
                                       </div>

                                       <div class="cancel-policy-item cancel_modal">
                                          <span class="cancel-policy-item-text">   <?php echo functions::Xmlinformation("Minutesbeforetheflight") ?></span>
                                          <span class="cancel-policy-item-pnalty site-bg-main-color"><?php echo is_numeric($Fee['OfThirtyMinutesAgoToNext']) ? $Fee['OfThirtyMinutesAgoToNext'] . functions::Xmlinformation("PenaltyPercent") : $Fee['OfThirtyMinutesAgoToNext']; ?> </span>
                                       </div>
                                    </div>
                                 </div>
                              <?php } else if (empty($Fee) && strtolower($InfoCancelTicket[0]['flight_type']) == 'system') { ?>
                                 <div class="cancel-policy cancel_modal cancel-policy-charter1 cancel-policy-charter1-admin">
                                    <div class="cancel-policy-head">

                                       <div class="cancel-policy-head-text"><?php echo functions::Xmlinformation("DetailMoneyCancel") ?></div>
                                    </div>
                                    <span><?php echo functions::Xmlinformation("Contactbackupunitinformationaboutamountconsignmentfines") ?></span>
                                 </div>
                              <?php } else { ?>
                                 <div class="cancel-policy cancel_modal cancel-policy-charter1 cancel-policy-charter1-admin">
                                    <div class="cancel-policy-head">
                                       <div class="cancel-policy-head-text"><?php echo functions::Xmlinformation("DetailMoneyCancel") ?></div>
                                    </div>
                                    <span><?php echo functions::Xmlinformation("ThecharterflightscharterunderstandingCivilAviationOrganization") ?></span>
                                 </div>
                                  <?php
                              }
                          }
                          ?>
                         <div class='mt-4'>
                            <div class="form-group">
                               <label for="DescriptionClient" class="mb-4">توضیحات
                                  <small>(شما میتوانید توضیحات مربوط به در خواست خود را در اینجا وارد نمائید)</small>
                               </label>
                               <textarea class="form-control" id="DescriptionClient"
                                         placeholder="متن توضیحات خود را وارد نمائید"></textarea>
                            </div>
                         </div>
                         <div class='mt-4'>
                            <div class="mr-auto d-flex nopad align-items-center">
                               <div class="input_s d-flex justify-content-center align-items-center">
                                  <input class="form-control" type="checkbox" id="Ruls" name="Ruls">
                               </div>
                               <div class="mr-2 lh45">
                                   <?php echo functions::Xmlinformation("Iam") ?> <a
                                     href="<?php echo URL_RULS ?>"
                                     style="margin-top: 5px"><?php echo functions::Xmlinformation("Seerules") ?></a> <?php echo functions::Xmlinformation("IhavestudiedIhavenoobjection") ?>
                               </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                               <div class="DescriptionReason showContentTextModal" style="display : none"></div>
                            </div>
                         </div>
                         <div class="row">
                             <?php
                             if (isset($param2) && $param2 == 'train') {
                                 ?>
                                <ol class="list-group">
                                   <li class="list-group-item"><?php echo functions::Xmlinformation("liOneTrainCancel") ?></li>
                                   <li class="list-group-item"><?php echo functions::Xmlinformation("liTwoTrainCancel") ?></li>
                                   <li class="list-group-item"><?php echo functions::Xmlinformation("liTreeTrainCancel") ?></li>
                                   <li class="list-group-item"><?php echo functions::Xmlinformation("liFourTrainCancel") ?></li>
                                </ol>
                             <?php }
                             ?>
                         </div>
                      </div>
                   </div>
                   <div class="modal-footer site-bg-main-color">
                      <button type="button" class="btn btn-primary  pull-right" data-dismiss="modal">بستن</button>
                      <button class="btn-send-information btn btn-success pull-right d-flex justify-content-center align-items-center" id='btn-information' onclick="DirectCancellationFlightAdmin('<?php echo $Param ?>')">
                          <?php echo functions::Xmlinformation("Sendinformation") ?>
                         <div class="spinner-border" id='btn-send-information-load' role="status">
                            <span class="sr-only">Loading...</span>
                         </div>
                      </button>
                   </div>
                </div>
             </div>

       <script>
          function closeModal(){
             $(".modal_custom").remove()
             $("body,html").removeClass("overflow-hidden");
          }
       </script>

        <?php

    }

    public function ModalCancelHotelAdmin($item1, $item2)
    {

        $typeApplication = $_POST['typeApplication'];
        $factorNumber = $_POST['factorNumber'];

        ?>
       <div class="modal-dialog modal-lg">
          <div class="modal-content">
                   <div class="modal-header site-bg-main-color p-4">
                      <button type="button" class="close" data-dismiss="modal">×</button>
                      <h4 class="modal-title">
                          کنسل کردن رزرو
                      </h4>
                   </div>
                   <div class="center_modal_custom">
                      <div class="center_modal_custom p-4">
                         <div class="modal-padding-bottom-15">
                            <form method="post" name="cancelBuyForm" id="cancelBuyForm" enctype="multipart/form-data">

                               <!--                      <input type="hidden" name="flag" id="flag" value="flagRequestCancelUser">-->
                               <input type="hidden" name="typeService" id="typeService" value="<?php echo $typeApplication; ?>">
                               <input type="hidden" name="FactorNumber" id="FactorNumber" value="<?php echo $factorNumber; ?>">

                               <div>
                                  <div class="modal-padding-bottom-15">
                                      <?php if (functions::TypeUser(CLIENT_ID) == 'Ponline') { ?>
                                         <div>
                                            <div class="w-100 modal-text-center modal-h mb-4">
                                               <label class='mb-0'><?php echo functions::Xmlinformation("Pleaseenteryourinformationreturningmoneyyouraccount") ?></label>
                                                <?php if($typeApplication=='train'){?>
                                                   <br/>
                                                   <label class='mb-0' style="color: red"><?php echo functions::Xmlinformation('descriptionCancelTrain');?></label>
                                                <?php } ?>
                                            </div>

                                            <div class="w-100 d-flex align-items-center parent-label-input-js">
                                               <div class='ml-2'>
                                                  <input onchange='inputDisabled(event)' type="checkbox" id="backCredit" name="backCredit" style="height: 40px">
                                               </div>
                                               <label for='backCredit' style="float:right;"><?php echo functions::Xmlinformation("BackToCredit") ?></label>
                                            </div>
                                            <div class="w-100 d-none">
                                               <label style="float:right;"><?php echo functions::Xmlinformation("Cardnumber") ?></label>
                                               <input class="form-control input-disabled-js" type="text" id="cardNumber" name="cardNumber">
                                            </div>
                                            <div class="w-100 d-none">
                                               <label class='mt-3' style="float:right;"><?php echo functions::Xmlinformation("Namebankowner") ?></label>
                                               <input class="form-control input-disabled-js" type="text" id="accountOwner" name="accountOwner">
                                            </div>
                                            <div class="w-100 d-none">
                                               <label class='mt-3' style="float:right;"><?php echo functions::Xmlinformation("Cardname") ?></label>
                                               <input class="form-control input-disabled-js" type="text" id="NameBank" name="NameBank">
                                            </div>
                                         </div>
                                      <?php } ?>
                                     <div>
                                        <div class="w-100 lh45">
                                           <label class="mt-3" style="float:right;">دلیل درخواست کنسلی</label>
                                           <textarea name="comment"
                                                     id="comment"
                                                     rows="2"
                                                     placeholder="دلیل درخواست کنسلی خود را وارد کنید..."
                                                     class="form-control w-100">
                              </textarea>
                                        </div>
                                        <div class="w-100 lh45 mt-5">
                                        <div class="form-group">
                                           <label for="DescriptionClient">توضیحات
                                              <small>(شما میتوانید توضیحات مربوط به در خواست خود را در اینجا وارد نمائید)</small>
                                           </label>
                                           <textarea class="form-control" id="DescriptionClient" placeholder="متن توضیحات خود را وارد نمائید"></textarea>
                                        </div>
                                        </div>
                                        <div class="w-100 d-flex align-items-center">
                                           <div class='ml-2'>
                                              <input type="checkbox" id="Ruls" name="Ruls" style="height: 40px">
                                           </div>
                                           <div>
                                               <?php echo functions::Xmlinformation("Iam") ?>
                                              <a
                                                 href="<?php echo URL_RULS ?>"
                                                 style="margin-top: 5px" target="_blank"><?php echo functions::Xmlinformation("Seerules") ?></a>
                                               <?php echo functions::Xmlinformation("IhavestudiedIhavenoobjection") ?>
                                           </div>
                                        </div>
                                     </div>
                                  </div>
                               </div>
                            </form>
                         </div>
                      </div>
                   </div>
             <div class="modal-footer site-bg-main-color">
                <button type="button" class="btn btn-primary  pull-right" data-dismiss="modal">بستن</button>
                <button class="btn-send-information btn btn-success pull-right d-flex justify-content-center align-items-center"
                        onclick="DirectCancellationHotelAdmin('<?php echo $typeApplication; ?>', '<?php echo $factorNumber; ?>')">
                    <?php echo functions::Xmlinformation("Sendinformation") ?>
                   <div class="spinner-border" id='btn-send-information-load' role="status">
                      <span class="sr-only">Loading...</span>
                   </div>
                </button>
             </div>
                </div>
             </div>
       <script>
          function closeModal(){
             $(".modal_custom").remove()
             $("body,html").removeClass("overflow-hidden");
          }
       </script>
        <?php
    }

    public function modalTicketBusInfo($Param)
    {
        $factorNumber = $Param;
        $Model = Load::library('Model');

        if (TYPE_ADMIN == '1') {

            $ModelBase = Load::library('ModelBase');
            $sql = "select * , GROUP_CONCAT(passenger_chairs SEPARATOR ', ') AS chairs from report_bus_tb where passenger_factor_num = '{$factorNumber}' ";
            $resultBook = $ModelBase->load($sql);

        } else {

            $sql = "select * , GROUP_CONCAT(passenger_chairs SEPARATOR ', ') AS chairs from book_bus_tb where passenger_factor_num = '{$factorNumber}' ";
            $resultBook = $Model->load($sql);
        }

//        $credit_query_bus = " SELECT * FROM  members_credit_tb  WHERE bankTrackingCode='{$resultBook['tracking_code_bank']}' LIMIT 1";
//        $res_credit_bus = $Model->load($credit_query_bus);
//        var_dump($resultBook['tracking_code_bank']);
//         var_dump($res_credit_bus['amount']);
        ?>

      <div class="modal_custom" onclick="closeModalParent(event)">
        <div class="container">
          <div class="main_modal_custom">
            <div class="scrollIng_model">
              <div class="header_modal_custom">
                <h2>
                    <?php echo functions::Xmlinformation("Viewpurchasetobookingnumber") ?>
                    :
                    <?php echo $Param; ?>


                    <?php echo functions::Xmlinformation("Reservationdate") ?> :
                   <?php echo $resultBook['creation_date'] ?>
                </h2>
                <button onclick="closeModal()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256L7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256L312.1 375z"/></svg></button>
              </div>
            <div class="center_modal_custom">
                <div class="box-style">
                  <div class="box-style-padding">
                    <div>
                      <div class="header_modal_custom p-0 w-100 modal-header">
                        <h2><?php echo functions::Xmlinformation("ViewTicketInformation") ?></h2>
                      </div>

<!--                      my-1 mb-1 mt-5-->
                      <div class='box_detail my-1'>
                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                        <span><?php echo functions::Xmlinformation("Origin") ?></span> :
                        <span><?php echo $resultBook['OriginCity'] ?></span>
                        </div>
                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                        <span><?php echo functions::Xmlinformation("Destination") ?></span> :
                        <span><?php echo $resultBook['DestinationCity'] ?></span>
                        </div>
                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                        <span><?php echo functions::Xmlinformation("Passengercompany") ?></span> :
                        <span><?php echo $resultBook['CompanyName'] ?></span>
                        </div>
                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                        <span><?php echo functions::Xmlinformation("Bustype") ?></span> :
                        <span><?php echo $resultBook['CarType'] ?></span>
                        </div>
                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                        <span><?php echo functions::Xmlinformation("Ticketnumber") ?></span> :
                        <span><?php echo $resultBook['order_code'] ?></span>
                        </div>
                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                        <span><?php echo functions::Xmlinformation("SeatNumber") ?></span> :
                        <span><?php echo $resultBook['chairs'] ?></span>
                        </div>
                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                        <span><?php echo functions::Xmlinformation("dateMove") ?></span> :
                        <span><?php echo $resultBook['DateMove'] ?></span>
                        </div>
                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                        <span><?php echo functions::Xmlinformation("timeMove") ?></span> :
                        <span><?php echo $resultBook['TimeMove'] ?></span>
                        </div>
                         <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                        <span><?php echo functions::Xmlinformation("Totalamount") ?></span> :
                        <span><?php echo number_format($resultBook['total_price']) ?> <?php echo functions::Xmlinformation("Rial") ?>
                            <br>
                          <?php

                           $priceFara = functions::getMemberCreditPayment($resultBook['tracking_code_bank'], $resultBook['total_price'] ) ;
                           $credit_price = $priceFara[0];
                           $bank_price = $priceFara[1];
                          if ($credit_price > 0 ){
                            ?>
                            <br>
                          <span>
                               پرداخت اعتباری : <?php echo  $credit_price ?>
                          </span>
                            <br>
                          <span>
                               پرداخت بانکی :  <?php echo $bank_price ?>
                          </span>
                          <?php
                           }
                          ?>

                        </span>
                        </div>
                      </div>

                      <div class="header_modal_custom p-0 w-100 modal-header my-3">
                        <h2> <?php echo functions::Xmlinformation("Informationpassenger") ?></h2>
                      </div>
                      <div class="table-responsive-lg ">
                        <table class="min-w-500px table table-bordered">
                          <thead>
                          <tr>
                       <th><?php echo functions::Xmlinformation("Namefamily") ?></th>
                            <th><?php echo functions::Xmlinformation("Nationalnumber") ?></th>
                            <th><?php echo functions::Xmlinformation("Phonenumber") ?></th>
                            <th><?php echo functions::Xmlinformation("Email") ?></th>
                          </tr>
                          </thead>
                          <tbody>
                            <tr>
                               <td>
                               <div>
                                    <?php
                                    if ($resultBook['passenger_gender'] =='Male' ) {
                                        echo functions::Xmlinformation("Sir") ;
                                    }else {
                                        echo functions::Xmlinformation("Lady") ;
                                    }
                                    ?>
                                    <?php echo $resultBook['passenger_name'] ?>  <?php echo $resultBook['passenger_family'] ?>
                                </div>
                              </td>
                              <td>
                                  <?php echo $resultBook['passenger_national_code'] ?>
                              </td>
                              <td><?php echo $resultBook['passenger_mobile'] ?></td>
                              <td><?php echo $resultBook['passenger_email'] ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <script>
        function closeModal(){
          $(".modal_custom").remove()
          $("body,html").removeClass("overflow-hidden");
        }
      </script>

        <?php

    }


    public function ModalListGashtTransferDetails($Param) {
        $user = Load::controller($this->Controller);
        $records = $user->info_gasht_client($Param);
        ?>

      <div class="modal_custom" onclick="closeModalParent(event)">
        <div class="container">
          <div class="main_modal_custom">
            <div class="scrollIng_model">
              <div class="header_modal_custom">
                <h2>
                    <?php echo functions::Xmlinformation("ViewPurchaseInvoiceNumber") ?>
                  :<?php echo $Param; ?>
                </h2>
                <button onclick="closeModal()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256L7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256L312.1 375z"/></svg></button>
              </div>
              <div class="center_modal_custom">
                <div class="box-style">
                  <div class="box-style-padding">
                    <div>
                        <?php
                        foreach ($records as $key => $view) {
                        if ($key < 1) { ?>

                      <!--  my-1 mb-1 mt-5-->
                      <div class='box_detail'>
                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span>
                            <?php echo functions::Xmlinformation("Specifications"); ?>
                            <?php echo $view['passenger_serviceRequestType'] == '0' ? functions::Xmlinformation("Gasht") : functions::Xmlinformation("Transfer"); ?>
                          </span> :
                          <span><?php echo $view['passenger_serviceName']; ?></span>
                        </div>
                            <?php if ($view['payment_date']){ ?>
                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span><?php echo functions::Xmlinformation("Date"); ?> <?php echo $view['payment_type'] == 'cash' ? functions::Xmlinformation("Payment") : functions::Xmlinformation("Buy"); ?></span> :
                          <span dir="ltr"> <?php echo $view['payment_date'] != '0000-00-00 00:00:00' ? functions::set_date_payment($view['payment_date']) : functions::Xmlinformation("Unpaid"); ?></span>
                        </div>
                            <?php } ?>
                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span dir="rtl"><?php echo functions::Xmlinformation("Reservationdate"); ?> <?php echo $view['passenger_serviceRequestType'] == '0' ? functions::Xmlinformation("Gasht") : functions::Xmlinformation("Transfer"); ?></span> :
                          <span><?php echo $user->set_date_reserve(substr($view['creation_date'], 0, 10)) ?></span>
                        </div>
                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span><?php echo functions::Xmlinformation("Destination"); ?></span> :
                          <span><?php echo $view['passenger_serviceCityName'] ?></span>
                        </div>
                      </div>
                        <?php } ?>
                      <div class="header_modal_custom p-0 w-100 modal-header">
                        <h2>
                            <?php echo functions::Xmlinformation("PassengerProfile") ?>
                        </h2>
                      </div>
                      <div class="table-responsive-lg">
                        <table class="min-w-500px table table-bordered">
                          <thead>
                          <tr>
                            <th><?php echo functions::Xmlinformation("Namefamily") ?></th>
                            <th><?php echo functions::Xmlinformation("DateOfBirth") ?></th>
                            <th><?php echo functions::Xmlinformation("Receive") ?> <?php echo $view['passenger_serviceRequestType'] == '0' ? functions::Xmlinformation("Gasht") : functions::Xmlinformation("transfer"); ?></th>
                          </tr>
                          </thead>
                          <tbody>
                          <tr>
                            <td><?php echo $view['passenger_name'] . ' ' . $view['passenger_family'] ?></td>
                            <td><?php echo (!empty($view['passenger_birthday'])) ? $view['passenger_birthday'] : $view['passenger_birthday'] ?></td>
                            <td>
                                <?php if ($view['status'] == 'book') { ?>
                                  <a href="<?php echo ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=bookingGasht&id=' . $view['passenger_factor_num'] ?>"
                                     target="_blank">
                                    <i class="fa fa-print"></i>
                                  </a>
                                <?php } else { echo 'ـــــ'; } ?>
                            </td>
                          </tr>
                          </tbody>
                        </table>
                      </div>
                        <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <script>
        function closeModal(){
          $(".modal_custom").remove()
          $("body,html").removeClass("overflow-hidden");
        }
      </script>

        <?php
    }

    public function showModalCancelItem($item0,$item1, $item2)
    {

        $typeApplication = $_POST['typeApplication'];
        $factorNumber = $_POST['factorNumber'];

        ?>
      <div class="modal_custom" onclick="closeModalParent(event)">
        <div class="container col-lg-4">
          <div class="main_modal_custom">
            <div class="scrollIng_model w-100">
              <div class="header_modal_custom">
                <h2>

                    <?php echo functions::Xmlinformation("CancelPurchase")?>
<!--                    --><?php //echo functions::Xmlinformation("Cancelpurchasebookingnumber")?>
<!--                    --><?php //echo $factorNumber; ?>
                </h2>
                <button onclick="closeModal()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256L7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256L312.1 375z"/></svg></button>
              </div>
              <div class="center_modal_custom">
                <div class="box-style">
                  <div class="box-style-padding">
                    <form method="post" name="cancelBuyForm" id="cancelBuyForm" enctype="multipart/form-data">

<!--                      <input type="hidden" name="flag" id="flag" value="flagRequestCancelUser">-->
                      <input type="hidden" name="typeService" id="typeService" value="<?php echo $typeApplication; ?>">
                      <input type="hidden" name="FactorNumber" id="FactorNumber" value="<?php echo $factorNumber; ?>">

                      <div>
                        <div class="modal-padding-bottom-15">
                          <?php if (functions::TypeUser(CLIENT_ID) == 'Ponline') { ?>
                            <div>
                              <div class="w-100 modal-text-center modal-h mb-4">
                                <label class='mb-0'><?php echo functions::Xmlinformation("Pleaseenteryourinformationreturningmoneyyouraccount") ?></label>
                                  <?php if($typeApplication=='train'){?>
                                    <br/>
                                    <label class='mb-0' style="color: red"><?php echo functions::Xmlinformation('descriptionCancelTrain');?></label>
                                  <?php } ?>
                              </div>

                              <div class="w-100 d-flex align-items-center parent-label-input-js">
                                <div class='ml-2'>
                                  <input onchange='inputDisabled(event)' type="checkbox" id="backCredit" name="backCredit" style="height: 40px">
                                </div>
                                <label for='backCredit' style="float:right;"><?php echo functions::Xmlinformation("BackToCredit") ?></label>
                              </div>
                              <div class="w-100">
                                <label style="float:right;"><?php echo functions::Xmlinformation("Cardnumber") ?></label>
                                <input class="form-control input-disabled-js" type="text" id="cardNumber" name="cardNumber">
                              </div>
                              <div class="w-100">
                                <label class='mt-3' style="float:right;"><?php echo functions::Xmlinformation("Namebankowner") ?></label>
                                <input class="form-control input-disabled-js" type="text" id="accountOwner" name="accountOwner">
                              </div>
                              <div class="w-100">
                                <label class='mt-3' style="float:right;"><?php echo functions::Xmlinformation("Cardname") ?></label>
                                <input class="form-control input-disabled-js" type="text" id="NameBank" name="NameBank">
                              </div>
                            </div>
                          <?php } ?>
                          <div>
                            <div class="w-100 lh45">
                              <label class="mt-3" style="float:right;">دلیل درخواست کنسلی</label>
                              <textarea name="comment"
                                        id="comment"
                                        rows="2"
                                        placeholder="دلیل درخواست کنسلی خود را وارد کنید..."
                                        class="form-control w-100">
                              </textarea>
                            </div>
                            <div class="w-100 d-flex align-items-center">
                              <div class='ml-2'>
                                <input type="checkbox" id="Ruls" name="Ruls" style="height: 40px">
                              </div>
                              <div>
                                  <?php echo functions::Xmlinformation("Iam") ?>
                                  <a
                                  href="<?php echo URL_RULS ?>"
                                  style="margin-top: 5px" target="_blank"><?php echo functions::Xmlinformation("Seerules") ?></a>
                                  <?php echo functions::Xmlinformation("IhavestudiedIhavenoobjection") ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                    <div class="col-md-12 box_btn mt-4">
                      <button class="close btn btn-primary btn-send-information site-bg-main-color"  style='font-size: 18px;  padding: 10px;  color: #fff;  background-color: #38ae61;border:#38ae61;'
                      onclick="requestCancelFinalBuy('<?php echo $typeApplication; ?>', '<?php echo $factorNumber; ?>')">
                          <?php echo functions::Xmlinformation("Sendinformation") ?>
                        <div class="spinner-border" id='btn-send-information-load' role="status">
                          <span class="sr-only">Loading...</span>
                        </div>
                      </button>
                    </div>


                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script>
        function closeModal(){
          $(".modal_custom").remove()
          $("body,html").removeClass("overflow-hidden");
        }
      </script>
<?php
    }


    public function ModalShowHotel($Param)
    {
        $Model = Load::library('Model');
        $objbook = Load::controller($this->Controller);
        $Hotel = $objbook->info_hotel_client($Param);
//        if ($Hotel[0]['tracking_code_bank'] != '') {
//        $credit_query_hotel = " SELECT * FROM  members_credit_tb  WHERE bankTrackingCode='{$Hotel[0]['tracking_code_bank']}' LIMIT 1";
//        $res_credit_hotel = $Model->load($credit_query_hotel);
//         var_dump($Hotel[0]['tracking_code_bank']);
//
//         }
        ?>
      <div class="modal_custom" onclick="closeModalParent(event)">
        <div class="container">
          <div class="main_modal_custom">
            <div class="scrollIng_model">
              <div class="header_modal_custom">
                <h2><?php echo functions::Xmlinformation("Viewhotelpurchasetobookingnumber") ?>
                  :<?php echo $Param; ?> </h2>
                <button onclick="closeModal()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256L7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256L312.1 375z"/></svg></button>
              </div>
              <div class="center_modal_custom">
                <div class="box-style">
                  <div class="box-style-padding">
                    <div>
                      <div class="header_modal_custom p-0 w-100 modal-header">
                        <h2><?php echo functions::Xmlinformation("Specifications"); ?> <?php echo $Hotel[0]['hotel_name']?> <?php echo $Hotel[0]['city_name']?></h2>
                      </div>

                      <!--  my-1 mb-1 mt-5-->
                      <div class='box_detail'>

                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span><?php echo functions::Xmlinformation("City"); ?></span> :
                          <span><?php echo $Hotel[0]['city_name']?></span>
                        </div>

                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span><?php echo functions::Xmlinformation("Hotel"); ?></span> :
                          <span><?php echo $Hotel[0]['hotel_name']?></span>
                        </div>

                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span><?php echo functions::Xmlinformation("Stayigtime"); ?></span> :
                          <span><?php echo $Hotel[0]['number_night']?> شب</span>
                        </div>

                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span><?php echo functions::Xmlinformation("Amount"); ?></span> :
                          <span><?php echo number_format(functions::calcDiscountCodeByFactor($Hotel[0]['total_price'], $Param)) ?> <?php echo functions::Xmlinformation("Rial"); ?></span>



                          <br>
                            <?php

                            $priceFara = functions::getMemberCreditPayment($Hotel[0]['tracking_code_bank'], $Hotel[0]['total_price'] ) ;
                            $credit_price = $priceFara[0];
                            $bank_price = $priceFara[1];
                            if ($credit_price > 0 ){
                                ?>
                              <br>
                              <span>
                               پرداخت اعتباری : <?php echo  $credit_price ?>
                          </span>
                              <br>
                              <span>
                               پرداخت بانکی :  <?php echo $bank_price ?>
                          </span>
                                <?php
                            }
                            ?>

                        </div>


                      </div>

                      <div class="header_modal_custom p-0 w-100 modal-header  my-2">
                          <?php if (!empty($Hotel[0]['passenger_name']) || !empty($Hotel[0]['passenger_name_en'])){ ?>
                            <h2><?php echo functions::Xmlinformation("Travelerprofile"); ?></h2>
                          <?php }else { ?>
                            <h2><?php echo functions::Xmlinformation("HeadOfRoom"); ?>: <?php echo $Hotel[0]['passenger_leader_room_fullName'] ?></h2>
                          <?php } ?>
                      </div>
                      <div class="table-responsive-lg">
                        <table class="min-w-500px table table-bordered">
                          <thead>
                          <?php if (!empty($Hotel[0]['passenger_name']) || !empty($Hotel[0]['passenger_name_en'])){ ?>
                            <tr>
                              <th><?php echo functions::Xmlinformation("Room"); ?></th>
                              <th><?php echo functions::Xmlinformation("Namefamily"); ?></th>
                              <th><?php echo functions::Xmlinformation("Nationalnumber"); ?>/<?php echo functions::Xmlinformation("Passport"); ?></th>
                              <th><?php echo functions::Xmlinformation("DateOfBirth"); ?></th>
                            </tr>
                          <?php }else { ?>
                            <tr>
                              <th><?php echo functions::Xmlinformation("Room"); ?></th>
                            </tr>
                          <?php } ?>
                          </thead>
                          <tbody>
                          <?php
                          foreach ($Hotel as $key => $view) {
                              ?>
                              <?php if (!empty($Hotel[0]['passenger_name']) || !empty($Hotel[0]['passenger_name_en'])){ ?>

                              <tr>
                                <td><?php echo $view['room_name'] ?></td>
                                <td> <span><?php echo functions::Xmlinformation("Namefamily"); ?> :</span><span>
                                  <?php
                                  if (!empty($view['passenger_name'])){
                                      echo $view['passenger_name'] . ' ' . $view['passenger_family'];
                                  } elseif (!empty($view['passenger_name_en'])){
                                      echo $view['passenger_name_en'] . ' ' . $view['passenger_family_en'];
                                  }
                                  ?>
                              </span></td>
                                <td><span><?php echo (!empty($view['passenger_national_code'])) ? $view['passenger_national_code'] : $view['passportNumber'] ?></span></td>
                                <td><span dir="rtl"><?php echo (!empty($view['passenger_birthday'])) ? $view['passenger_birthday'] : $view['passenger_birthday_en'] ?></span></td>
                              </tr>
                              <?php }else { ?>
                              <tr>
                                <td><?php echo $view['room_name'] ?></td>
                              </tr>
                              <?php } ?>
                          <?php } ?>
                          </tbody>
                        </table>
                      </div>
                        <?php if ($Hotel[0]['type_application'] == 'reservation' && $Hotel[0]['origin'] != '') { ?>
                      <div class="header_modal_custom p-0 w-100 modal-header">
                        <h2><?php echo functions::Xmlinformation("Informationtravel"); ?></h2>
                        <p><?php echo functions::Xmlinformation("Origin"); ?></p>
                        <p><?php echo functions::Xmlinformation("Destination"); ?> :</span><span><?php echo $Hotel[0]['origin'] ?></p>
                      </div>
                      <div class="table-responsive-lg">
                        <table class="min-w-500px table table-bordered">
                          <thead>
                          <tr>
                            <th><span> <?php echo functions::Xmlinformation('NameTransport')?></span></th>
                            <th><span> <?php echo functions::Xmlinformation('Numflight')?> </span></th>
                            <th><span> <?php echo functions::Xmlinformation('Starttime')?> </span></th>
                            <th><span> <?php echo functions::Xmlinformation('Wentdate')?> </span></th>
                          </tr>
                          </thead>
                          <tbody>
                          <tr>
                            <td><span><?php echo $Hotel[0]['airline_went'] ?></span></td>
                            <td><span><?php echo $Hotel[0]['flight_number_went'] ?></span></td>
                            <td><span><?php echo $Hotel[0]['hour_went'] ?></span></td>
                            <td><span><?php echo $Hotel[0]['flight_date_went'] ?></span></td>
                          </tr>
                          </tbody>
                        </table>
                      </div>



                      <div class="table-responsive-lg">
                        <table class="min-w-500px table table-bordered">
                          <thead>
                          <tr>
                            <th><span> <?php echo functions::Xmlinformation('NameTransport')?></span></th>
                            <th><span> <?php echo functions::Xmlinformation('Numflight')?> </span></th>
                            <th><span> <?php echo functions::Xmlinformation('Returntime')?> </span></th>
                            <th><span> <?php echo functions::Xmlinformation('Datewentback')?></span></th>
                          </tr>
                          </thead>
                          <tbody>
                          <tr>
                            <td><span><?php echo $Hotel[0]['airline_back'] ?></span></td>
                            <td><span><?php echo $Hotel[0]['flight_number_back'] ?></span></td>
                            <td><span><?php echo $Hotel[0]['hour_back'] ?></span></td>
                            <td><span><?php echo $Hotel[0]['flight_date_back'] ?></span></td>
                          </tr>
                          </tbody>
                        </table>
                      </div>
                        <?php } ?>


                        <?php if ($Hotel[0]['type_application'] == 'reservation' && $objbook->showOneDayTour == 'True'){
                        ?>
                      <div class="header_modal_custom p-0 w-100 modal-header  my-2">
                        <h2><?php echo functions::Xmlinformation('AuthToureOneDay')?></h2>
                      </div>
                      <div class="table-responsive-lg">
                        <table class="min-w-900px table table-bordered">
                          <tbody>
                          <?php
                          foreach ($objbook->listOneDayTour as $val){
                              ?>
                            <tr>
                              <th><span> <?php echo functions::Xmlinformation('Title')?>: </span></th>
                              <td><span><?php echo $val['title'] ?></span></td>
                            </tr>
                            <tr>
                              <th> <span> <?php echo functions::Xmlinformation('Price')?>:</span></th>
                              <td><span><?php echo $val['price'] ?></span></td>
                            </tr>
                          <?php } ?>
                          </tbody>
                        </table>
                      </div>
                        <?php } ?>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script>
        function closeModal(){
          $(".modal_custom").remove()
          $("body,html").removeClass("overflow-hidden");
        }
      </script>

        <?php

    }
    public function ModalShowInsuranceProfile($Param) {
        $user = Load::controller($this->Controller);
        $records = $user->info_insurance_client($Param);
        ?>

      <div class="modal_custom" onclick="closeModalParent(event)">
        <div class="container">
          <div class="main_modal_custom">
            <div class="scrollIng_model">
              <div class="header_modal_custom">
                <h2>
                    <?php echo functions::Xmlinformation("ViewPurchaseInvoiceNumber")?> <?php echo $Param; ?>
                </h2>
                <button onclick="closeModal()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256L7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256L312.1 375z"/></svg></button>
              </div>
              <div class="center_modal_custom">
                <div class="box-style">
                  <div class="box-style-padding">
                    <div>
                      <div class="header_modal_custom p-0 w-100 modal-header">
                        <h2><?php echo functions::Xmlinformation("InsurancePolicyProfile"); ?> <?php echo $records[0]['source_name_fa']; ?></h2>
                      </div>


                      <!-- my-1 mb-1 mt-5-->
                      <div class='box_detail'>

                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span><?php echo functions::Xmlinformation("Date"); ?> <?php echo $records[0]['payment_type'] == 'cash' ? functions::Xmlinformation("Payment") : functions::Xmlinformation("Buy"); ?></span> :
                          <span dir="ltr"><?php echo $records[0]['payment_date'] != '0000-00-00 00:00:00' ? functions::set_date_payment($records[0]['payment_date']) : functions::Xmlinformation("Unpaid"); ?></span>
                        </div>

                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span dir="rtl"><?php echo functions::Xmlinformation("DateBookingInsurancePolicy"); ?></span> :
                          <span><?php echo $user->set_date_reserve(substr($records[0]['creation_date'], 0, 10)) ?></span>
                        </div>

                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span><?php echo functions::Xmlinformation("Destination"); ?></span> :
                          <span><?php echo $records[0]['destination'] ?></span>
                        </div>

                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span><?php echo functions::Xmlinformation("Count"); ?></span> :
                          <span><?php echo $user->count; ?></span>
                        </div>


                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span><?php echo functions::Xmlinformation("Durationtrip"); ?></span> :
                          <span><?php echo $records[0]['duration'] ?><?php echo functions::Xmlinformation("Day"); ?></span>
                        </div>

                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span><?php echo functions::Xmlinformation("Amount"); ?></span> :
                          <span><?php echo number_format(functions::calcDiscountCodeByFactor($user->total_price_insurance($records[0]['factor_number']), $records[0]['factor_number'])) ?>
                              <?php echo functions::Xmlinformation("Rial"); ?></span>
                        </div>

                      </div>

                      <div class="header_modal_custom p-0 w-100 modal-header">
                        <h2><?php echo functions::Xmlinformation("Travelerprofile"); ?></h2>
                      </div>
                      <div class="table-responsive-lg">
                        <table class="min-w-500px table table-bordered">
                          <thead>
                          <tr>
                            <th><span><?php echo functions::Xmlinformation("Namefamily"); ?> :</span></th>
                            <th><span><?php echo functions::Xmlinformation("Passport"); ?>:</span></th>
                            <th><span><?php echo functions::Xmlinformation("DateOfBirth"); ?>: </span></th>
                            <th><span><?php echo functions::Xmlinformation("GetInsurancePolicy"); ?>:</span></th>
                          </tr>
                          </thead>
                          <tbody>
                          <?php
                          foreach ($records as $key => $view) {
                              ?>
                            <tr>
                              <td><span><?php echo $view['passenger_name'] . ' ' . $view['passenger_family'] ?></span></td>
                              <td><span><?php echo $view['passport_number'] ?></span></td>
                              <td><span dir="rtl"><?php echo (!empty($view['passenger_birth_date'])) ? $view['passenger_birth_date'] : $view['passenger_birth_date_en'] ?></span></td>
                              <td><span><?php echo functions::Xmlinformation("GetInsurancePolicy"); ?>:</span>
                                <span>
                              <?php if ($view['status'] == 'book') { ?>
                                <a href="<?php echo $user->get_insurance_pdf($view['source_name'], $view['pnr']) ?>"
                                   target="_blank"><i class="fa fa-print"></i></a>
                                  <?php
                              } else {
                                  echo 'ـــــ';
                              }
                              ?>
                        </span></td>
                            </tr>
                          <?php } ?>

                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <script>
        function closeModal(){
          $(".modal_custom").remove()
          $("body,html").removeClass("overflow-hidden");
        }
      </script>

        <?php
    }

    public function ModalShowVisaProfile($Param) {
        $user = Load::controller($this->Controller);
        $records = $user->info_visa_client($Param);
        ?>

      <div class="modal_custom" onclick="closeModalParent(event)">
        <div class="container">
          <div class="main_modal_custom">
            <div class="scrollIng_model">
              <div class="header_modal_custom">
                <h2>
                    <?php echo functions::Xmlinformation("ViewPurchaseInvoiceNumber")?> <?php echo $Param; ?>
                </h2>
                <button onclick="closeModal()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256L7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256L312.1 375z"/></svg></button>
              </div>
              <div class="center_modal_custom">
                <div class="box-style">
                  <div class="box-style-padding">
                    <div>
                      <div class="header_modal_custom p-0 w-100 modal-header">
                        <h2><?php echo functions::Xmlinformation("Specifications"); ?> <?php echo $records[0]['visa_title']; ?></h2>
                      </div>


                      <!--                      my-1 mb-1 mt-5-->
                      <div class='box_detail'>

                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span><?php echo functions::Xmlinformation("Date"); ?> <?php echo $records[0]['payment_type'] == 'cash' ? functions::Xmlinformation("Payment") : functions::Xmlinformation("Buy"); ?></span> :
                          <span dir="ltr"><?php echo $records[0]['payment_date'] != '0000-00-00 00:00:00' ? functions::set_date_payment($records[0]['payment_date']) : functions::Xmlinformation("Unpaid"); ?></span>
                        </div>

                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span dir="rtl"><?php echo functions::Xmlinformation("DateVisaReservation"); ?>  </span> :
                          <span><?php echo $user->set_date_reserve(substr($records[0]['creation_date'], 0, 10)) ?></span>
                        </div>

                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span><?php echo functions::Xmlinformation("NumberPurchases"); ?></span> :
                          <span><?php echo $user->count; ?></span>
                        </div>

                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span><?php echo functions::Xmlinformation("Destination"); ?></span> :
                          <span><?php echo $records[0]['visa_destination'] ?></span>
                        </div>

                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span><?php echo functions::Xmlinformation("Type"); ?></span> :
                          <span><?php echo $records[0]['visa_type'] ?></span>
                        </div>

                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span><?php echo functions::Xmlinformation("DeliveryTime"); ?> </span> :
                          <span><?php echo $records[0]['visa_deadline'] ?></span>
                        </div>

                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span><?php echo functions::Xmlinformation("ValidityDuration"); ?></span> :
                          <span><?php echo $records[0]['visa_validity_duration'] ?></span>
                        </div>

                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span><?php echo functions::Xmlinformation("Countenter"); ?></span> :
                          <span><?php echo $records[0]['visa_allowed_use_no'] ?> بار</span>
                        </div>

                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span><?php echo functions::Xmlinformation("Amount"); ?> </span> :
                          <span> <?php echo number_format(functions::calcDiscountCodeByFactor($records[0]['total_price'], $records[0]['factor_number'])) ?>
                              <?php echo functions::Xmlinformation("Rial"); ?>
                          </span>
                        </div>




                      </div>

                      <div class="header_modal_custom p-0 w-100 modal-header">
                        <h2><?php echo functions::Xmlinformation("Travelerprofile"); ?></h2>
                      </div>
                      <div class="table-responsive-lg">
                        <table class="min-w-500px table table-bordered">
                          <thead>
                          <tr>
                            <th><span><?php echo functions::Xmlinformation("Namefamily"); ?> :</span></th>
                            <th><span><?php echo functions::Xmlinformation("Passport"); ?>:</span></th>
                            <th><span><?php echo functions::Xmlinformation("DateOfBirth"); ?>: </span></th>
                            <th><span><?php echo functions::Xmlinformation("GetWatcher"); ?>:</span></th>
                          </tr>
                          </thead>
                          <tbody>
                          <?php
                          foreach ($records as $key => $view) {
                              ?>
                            <tr>
                              <td><span><?php echo $view['passenger_name'] . ' ' . $view['passenger_family'] ?></span></td>
                              <td><span><?php echo $view['passport_number'] ?></span></td>
                              <td><span dir="rtl"><?php echo (!empty($view['passenger_birthday'])) ? $view['passenger_birthday'] : $view['passenger_birthday_en'] ?></span></td>
                              <td>
                      <span>
                            <?php if ($view['status'] == 'book') { ?>
                              <a href="<?php echo ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=bookingVisa&id=' . $view['unique_code'] ?>"
                                 target="_blank"><i class="fa fa-print"></i></a>
                                <?php
                            } else {
                                echo 'ـــــ';
                            }
                            ?>
                            <a href="<?php echo ROOT_ADDRESS . '/visaDetailReview&factor_number=' . $view['factor_number'] ?>"
                               target="_blank"><i class="fa fa-list"></i></a>
                        </span>
                              </td>
                            </tr>
                          <?php } ?>

                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script>
        function closeModal(){
          $(".modal_custom").remove()
          $("body,html").removeClass("overflow-hidden");
        }
      </script>

        <?php
    }

    public function ModalShowEuropcar($Param) {
        $user = Load::controller($this->Controller);
        $records = $user->info_europcar_client($Param);
        ?>

      <div class="modal_custom" onclick="closeModalParent(event)">
        <div class="container">
          <div class="main_modal_custom">
            <div class="scrollIng_model">
              <div class="header_modal_custom">
                <h2>
                    <?php echo functions::Xmlinformation("ViewPurchaseInvoiceNumber")?> <?php echo $Param; ?>
                </h2>
                <button onclick="closeModal()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256L7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256L312.1 375z"/></svg></button>
              </div>
              <div class="center_modal_custom">
                <div class="box-style">
                  <div class="box-style-padding">
                    <div>
                      <div class="header_modal_custom p-0 w-100 modal-header">
                        <h2><?php echo functions::Xmlinformation("Specifications"); ?> <?php echo $records[0]['car_name']; ?></h2>
                      </div>


                      <!--my-1 mb-1 mt-5-->
                      <div class='box_detail'>


                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span><?php echo functions::Xmlinformation("Namecar"); ?></span> :
                          <span><?php echo $records[0]['car_name'] ?></span>
                        </div>
                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span><?php echo functions::Xmlinformation("EnglishNameOfCar"); ?></span> :
                          <span><?php echo $records[0]['car_name_en'] ?></span>
                        </div>
                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span><?php echo functions::Xmlinformation("ImageOfCar"); ?></span> :
                          <span><a href='<?php echo $records[0]['car_image'] ?>' target='_blank'><img src='<?php echo $records[0]['car_image'] ?>'></a></span>
                        </div>
                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span><?php echo functions::Xmlinformation("Origin"); ?></span> :
                          <span><?php echo $records[0]['source_station_name'] ?></span>
                        </div>
                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span><?php echo functions::Xmlinformation("Destination"); ?></span> :
                          <span><?php echo $records[0]['dest_station_name'] ?></span>
                        </div>
                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span><?php echo functions::Xmlinformation("Amount"); ?></span> :
                          <span> <?php echo number_format(functions::calcDiscountCodeByFactor($records[0]['total_price'], $records[0]['factor_number'])) ?>
                              <?php echo functions::Xmlinformation("Rial"); ?></span>


                          <br>
                            <?php

                            $priceRentCar = functions::getMemberCreditPayment($records[0]['tracking_code_bank'], $records[0]['total_price'] ) ;
                            $credit_price_car = $priceRentCar[0];
                            $bank_price_car = $priceRentCar[1];
                            if ($credit_price_car > 0 ){
                                ?>
                              <br>
                              <span>
                               پرداخت اعتباری : <?php echo  $credit_price_car ?>
                          </span>
                              <br>
                              <span>
                               پرداخت بانکی :  <?php echo $bank_price_car ?>
                          </span>
                                <?php
                            }
                            ?>
                        </div>





                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script>
        function closeModal(){
          $(".modal_custom").remove()
          $("body,html").removeClass("overflow-hidden");
        }
      </script>

        <?php
    }

  public function ModalTourDetails($factorNumber)
    {
             $infoBook = functions::GetInfoTour($factorNumber);
        /** @var resultTourLocal $resultTourLocalController */

        $resultTourLocalController=Load::controller('resultTourLocal');


        $resultTourLocalController->getInfoTourByIdTour((int)$infoBook['tour_id']);

        $tourDetail=$resultTourLocalController->arrayTour['infoTour'];

        $cities=[];
        if(SOFTWARE_LANG === 'fa'){
            $index_name='name';
            $index_name_tag='name_fa';
            $index_city='city_name';
        }else{
            $index_name=$index_name_tag='name_en';
            $index_city='city_name_en';


        }


        foreach($resultTourLocalController->arrayTour['infoTourRout'] as $route)
        {
            $cities[] = $route[$index_name];
        }


//        $Model = Load::library('Model');
//        $credit_query_tour = " SELECT * FROM  members_credit_tb  WHERE bankTrackingCode='{$infoBook['tracking_code_bank']}' LIMIT 1";
//        $res_credit_tour = $Model->load($credit_query_tour);
//         var_dump($res_credit_tour['amount']);

        ?>


      <div class="modal_custom" onclick="closeModalParent(event)">
        <div class="container">
          <div class="main_modal_custom">
            <div class="scrollIng_model">
              <div class="header_modal_custom">
                <h2><?php echo functions::Xmlinformation("Viewpurchasetobookingnumber") ?>
                  :<?php echo $factorNumber; ?> </h2>
                <button onclick="closeModal()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256L7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256L312.1 375z"/></svg></button>
              </div>
              <div class="center_modal_custom">
                <div class="box-style">
                  <div class="box-style-padding">
                    <div>
                      <div class="header_modal_custom p-0 w-100 modal-header">
                        <h2>
                          <span> <?php echo functions::Xmlinformation("TourReservationSpecifications"); ?> <?php echo $infoBook['tour_name'] . " " . $infoBook['tour_code']; ?> </span>
                          (<span> <?php echo functions::Xmlinformation("Paymentamount"); ?>: <?php echo number_format($infoBook['tour_payments_price']); ?> <?php echo functions::Xmlinformation("Rial"); ?> </span>)
                        </h2>
                      </div>


                      <!--  my-1 mb-1 mt-5-->
                      <div class='box_detail'>

                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span><?php echo functions::Xmlinformation("Origin"); ?></span> :
                          <span>
                               <?php
                               if(SOFTWARE_LANG === 'fa'){
                                   echo $resultTourLocalController->arrayTour['infoTour']['country_name'] . ' - ' . $resultTourLocalController->arrayTour['infoTour']['name'] . ' - ' . $infoBook['tour_origin_region_name'];
                               }else{
                                   echo $resultTourLocalController->arrayTour['infoTour']['country_name_en'] . ' - ' . $resultTourLocalController->arrayTour['infoTour']['name_en'] . ' - ' . $infoBook['tour_origin_region_name'];
                               }
                               ?>
                          </span>
                        </div>

                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span><?php echo functions::Xmlinformation("ToursOfCity"); ?></span> :
                          <span><?php echo join(', ',$cities); ?></span>
                        </div>

                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span><?php echo functions::Xmlinformation("Datetravelwent"); ?></span> :
                          <span><?php echo $infoBook['tour_start_date']; ?></span>
                        </div>

                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span><?php echo functions::Xmlinformation("Datewentback"); ?></span> :
                          <span><?php echo $infoBook['tour_end_date']; ?></span>
                        </div>

                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span><?php echo functions::Xmlinformation("Tourduration"); ?></span> :
                          <span>
                              <?php if ($infoBook['tour_night'] > 0){ ?>
                              <span><?php echo $infoBook['tour_night']; ?></span>
                              <span> <?php echo functions::Xmlinformation("Night"); ?> </span>
                              <?php } ?>
                        <span><?php echo $infoBook['tour_day']; ?></span>
                        <span> <?php echo functions::Xmlinformation("Day"); ?> </span>
                          </span>
                        </div>

                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span><?php echo functions::Xmlinformation("Permissibleamount"); ?></span> :
                          <span>
                        <span><?php echo $infoBook['tour_free']; ?></span>
                         <span> <?php echo functions::Xmlinformation("Kilograms"); ?> </span>
                          </span>
                        </div>

                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span><?php echo functions::Xmlinformation("Visa"); ?></span> :
                          <span>
                          <span><?php if ($infoBook['tour_visa'] == 'yes'){ echo functions::Xmlinformation("Have");} else { echo functions::Xmlinformation("Donthave");}; ?></span>
                          </span>
                        </div>
                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>

                          <span><?php echo functions::Xmlinformation("Insurance"); ?>: </span>
                          <span><?php if ($infoBook['tour_insurance'] == 'yes'){ echo functions::Xmlinformation("Have");} else { echo functions::Xmlinformation("Donthave");}; ?></span>

                        </div>

                        <div><i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"/></svg></i>
                          <span><?php echo functions::Xmlinformation("TotalPrice"); ?></span> :
                          <span><?php echo number_format($infoBook['tour_total_price']); ?> <?php echo functions::Xmlinformation("Rial"); ?> </span>


                          <br>
                            <?php

                            $priceFara = functions::getMemberCreditPayment($infoBook['tracking_code_bank'], $infoBook['total_price'] ) ;
                            $credit_price = $priceFara[0];
                            $bank_price = $priceFara[1];
                            if ($credit_price > 0 ){
                                ?>
                              <br>
                              <span>
                               پرداخت اعتباری : <?php echo  $credit_price ?>
                          </span>
                              <br>
                              <span>
                               پرداخت بانکی :  <?php echo $bank_price ?>
                          </span>
                                <?php
                            }
                            ?>

                        </div>



                      </div>

                      <div class="header_modal_custom p-0 w-100 modal-header">
                        <h2><?php echo functions::Xmlinformation("Travelerprofile"); ?></h2>
                      </div>
                      <div class="table-responsive-lg">
                        <table class="min-w-500px table table-bordered">
                          <thead>
                          <tr>
                            <th><?php echo functions::Xmlinformation("Namefamily"); ?></th>
                            <th><?php echo functions::Xmlinformation("nationalCodeOrPassPort"); ?></th>
                            <th><?php echo functions::Xmlinformation("DateOfBirth"); ?></th>
                          </tr>
                          </thead>
                          <tbody>
                          <tr>
                            <td><?php echo $infoBook['passenger_name'] . ' ' . $infoBook['passenger_family'] ?></td>
                            <td><?php echo functions::Xmlinformation("nationalCodeOrPassPort"); ?> :</span><span><?php echo (!empty($infoBook['passenger_national_code'])) ? $infoBook['passenger_national_code'] : $infoBook['passportNumber'] ?>  </td>
                            <td><?php echo functions::Xmlinformation("DateOfBirth"); ?> : </span><span dir="rtl"><?php echo (!empty($infoBook['passenger_birthday'])) ? $infoBook['passenger_birthday'] : $infoBook['passenger_birthday_en'] ?></td>
                          </tr>

                          </tbody>
                        </table>
                      </div>

                      <div class="col-md-6">
                          <?php
                          if (!empty($infoBook['passenger_national_image'])){
                              ?>
                            <a id="downloadLink" target="_blank"
                               href="<?php echo ROOT_ADDRESS_WITHOUT_LANG .'/pic/reservationTour/passengersImages/' . $infoBook['passenger_national_image']; ?>"
                               type="application/octet-stream"><?php echo functions::Xmlinformation("Downloadimg"); ?><i class="fa fa-download"></i>
                            </a>
                              <?php
                          } elseif (!empty($infoBook['passenger_passport_image'])){
                              ?>
                            <a id="downloadLink" target="_blank"
                               href="<?php echo ROOT_ADDRESS_WITHOUT_LANG .'/pic/reservationTour/passengersImages/' . $infoBook['passenger_passport_image']; ?>"
                               type="application/octet-stream"><?php echo functions::Xmlinformation("Downloadimg"); ?><i class="fa fa-download"></i>
                            </a>
                              <?php
                          }
                          ?>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script>


        function closeModal(){
          $(".modal_custom").remove()
          $("body,html").removeClass("overflow-hidden");
        }

      </script>

        <?php

    }

  public function ModalShowProofProfile($Param)
    {
        $reservationProof = Load::controller($this->Controller);

        $Tickets = functions::info_flight_client($Param['requestNumber']);
        $file = $reservationProof->getProofFile($Param['requestNumber'] , $Param['type']);

        $ext = pathinfo($file['file_path'], PATHINFO_EXTENSION) ;
        if(in_array($ext,['jpg','gif','png','tif', 'jpeg'])) {
            $file_url = ROOT_ADDRESS_WITHOUT_LANG . '/pic/proof/' . $file['file_path'];
            $image_url =ROOT_ADDRESS_WITHOUT_LANG . '/pic/proof/' . $file['file_path'];
        }else {
            $file_url = ROOT_ADDRESS_WITHOUT_LANG . '/pic/proof/' . $file['file_path'];
            $image_url = ROOT_ADDRESS_WITHOUT_LANG . '/pic/ext-icons/'.$ext.'.png';
        }

        ?>

      <div class="modal_custom" onclick="closeModalParent(event)">
        <div class="container">
          <div class="main_modal_custom">
            <div class="scrollIng_model">
            <div class="header_modal_custom">
              <h2><?php echo functions::Xmlinformation("Viewpurchasetobookingnumber") ?>
                :<?php echo $Param['requestNumber']; ?> </h2>
              <button onclick="closeModal()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256L7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256L312.1 375z"/></svg></button>
            </div>
            <div class="center_modal_custom">
                <?php
                foreach ($Tickets as $key => $view) {
                    if ($key < 1) {
                        ?>
                      <div class="row margin-both-vertical-20">
                        <div class="col-md-12 modal-text-center modal-h">
                          <span> <?php echo functions::Xmlinformation("Flightprofile") ?></span></div>
                      </div>
                      <div class="row">
                        <div class="col-md-4 ">
					    	   	<span><?php echo functions::Xmlinformation("Date"); ?> <?php echo $view['payment_type'] == 'cash' ? functions::Xmlinformation("Payment") : functions::Xmlinformation("Buy"); ?>
							    	: </span>
                          <span dir="rtl"><?php echo !empty($view['payment_date']) ? functions::set_date_payment($view['payment_date']) : functions::Xmlinformation("Unpaid") ?></span>
                        </div>
                        <div class="col-md-4 ">
                          <span><?php echo functions::Xmlinformation("WachterNumber") ?> :</span>

                          <span><?php echo $view['request_number'] ?></span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4 ">

							<span><?php echo functions::Xmlinformation("Origin") ?>
								/ <?php echo functions::Xmlinformation("Destination") ?>
								: </span><span><?php echo $view['origin_city'] ?>
								/ <?php echo $view['desti_city'] ?></span>
                        </div>
                        <div class="col-md-4 ">
							<span><?php echo functions::Xmlinformation("Count") ?>
								:</span><span><?php echo $view['CountId']; ?></span>
                        </div>

                      </div>
                      <div class="row">
                        <div class="col-md-4 ">

                          <span> <?php echo functions::Xmlinformation("Nameairline") ?> :</span>
                          <span><?php echo $view['airline_name'] ?></span>
                        </div>
                        <div class="col-md-4 ">

                          <span><?php echo functions::Xmlinformation("Classflight") ?>: </span>
                          <span><?php echo ($view['seat_class'] == 'C' || $view['seat_class'] == 'B') ? functions::Xmlinformation("BusinessType") : functions::Xmlinformation("EconomicsType") ?> </span>
                        </div>

                        <div class="col-md-4 "><span> <?php echo functions::Xmlinformation("Typeflight") ?>: </span>
                          <span><?php echo $view['flight_type'] == 'system' ? functions::Xmlinformation("SystemType") : functions::Xmlinformation("CharterType") ?> </span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4 ">

						      	<span><?php echo functions::Xmlinformation("Numflight") ?>
							    	:</span><span><?php echo $view['flight_number'] ?> </span>
                        </div>
                        <div class="col-md-4 ">
						    	<span dir="rtl"><?php echo functions::Xmlinformation("PnrCode") ?>
							  	:</span><span><?php echo $view['pnr']; ?></span>
                        </div>
                      </div>
                      <div class="row margin-top-10">
                        <div class="col-md-12 modal-text-center modal-h">
                          <span><?php echo functions::Xmlinformation("Travelerprofile") ?></span></div>
                      </div>
                    <?php } ?>

                  <div class="row modal-padding-bottom-15">
                    <div class="col-md-3 ">

                      <span><?php echo functions::Xmlinformation("Namefamily") ?> :</span>
                      <span><?php echo $view['passenger_name'] . ' ' . $view['passenger_family'] ?></span>
                    </div>
                    <div class="col-md-3 ">
					   	<span><?php echo functions::Xmlinformation("Nationalnumber"); ?>
							/<?php echo functions::Xmlinformation("Passport"); ?>:</span>
                      <span><?php echo ($view['passenger_national_code'] != '0000000000') ? $view['passenger_national_code'] : $view['passportNumber'] ?></span>
                    </div>
                    <div class="col-md-3 ">
                      <span dir="rtl"><?php echo functions::Xmlinformation("DateOfBirth") ?>: </span>
                      <span><?php echo (!empty($view['passenger_birthday'])) ? $view['passenger_birthday'] : $view['passenger_birthday_en'] ?></span>
                    </div>
                    <div class="col-md-3 ">
                      <span dir="rtl"><?php echo functions::Xmlinformation("Ticketnumber") ?>: </span>
                      <span><?php echo $view['eticket_number']; ?></span>
                    </div>
                  </div>

                <?php } ?>

              <div class="row margin-both-vertical-20">
                <div class="col-md-12 modal-text-center modal-h">
                  <span> <?php echo functions::Xmlinformation("proofFile") ?> </span>
                </div>
                <div class="row">
                    <?php
                    if($file && isset($file) && !empty($file)){
                        ?>
                      <div class="col-md-12 ">
                <span dir="rtl">
                <a href='<?php echo $file_url ?>' target='_blank' class='d-flex py-2' style = "width: 200px; height: 200px;">
                  <img src="<?php echo $image_url?>" class='w-100 h-100' alt="<?php echo $file['file_title']?>">
                </a>

                </span>
                      </div>
                        <?php
                    }else {
                        ?>
                      <div class="col-md-12 ">
                        <p><?php echo functions::Xmlinformation("notUploadedProof") ?></p>
                      </div>
                        <?php
                    }
                    ?>

                </div>
              </div>

            </div>
          </div>
          </div>
        </div>
      </div>

      <script>


        function closeModal(){
          $(".modal_custom").remove()
          $("body,html").removeClass("overflow-hidden");
        }

      </script>

        <?php

    }


    #region ModalSendSms

    public function ModalShowRequestCredit($Param , $Param2) {

        $creditController = Load::controller($this->Controller);

        $info_credit = $creditController->getRequestUserInfo($Param , $Param2);

        $user = Load::controller('user');
        $info_user = $user->getProfile($Param2);

        ?>
      <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header site-bg-main-color">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">جزییات درخواست وجه نقد کاربر از اعتبار خودش   </h4>


          </div>
          <div class="modal-body">


            <div class="row margin-both-vertical-20">
              <div class="col-md-12 text-center text-bold" style="color: #fb002a;">
                <span>مشخصات کاربر</span></div>
            </div>

            <div class="row margin-both-vertical-20">
              <div class="col-md-4 ">
                <span>نام و نام خانوادگی  : </span><span>
                           <?php
                      echo $info_user['name'];
                      ?>

                           <?php
                      echo $info_user['family'];
                      ?>
                </span>
              </div>
              <div class="col-md-4 ">
                <span class=""> شماره تلفن موبایل: </span><span class="yn">

                   <?php
                   echo $info_user['mobile']
                   ?>
                </span>
              </div>
              <div class="col-md-4 ">
                <span>ایمیل :</span><span>
                   <?php
                   echo $info_user['email']
                   ?>
                </span>
              </div>
            </div>


            <hr style="margin: 5px 0;">

            <div class="row margin-both-vertical-20">
              <div class="col-md-12 text-center text-bold " style="color: #fb002a;"><span>مشخصات درخواست</span>
              </div>
            </div>

            <div class="row margin-both-vertical-20">
              <div class="col-md-4">
                <span class=" pull-left">تاریخ درخواست : </span>
                <span class="yn"> <?php
                    echo $creditController->timeToDateJalali( $info_credit['creationDateInt']);
                    ?></span>
              </div>
              <div class="col-md-4">
                <span>شماره فاکتور: </span>
                <span class="yn">
                  <?php
                  echo $info_credit['factorNumber']
                  ?>
                </span>
              </div>
              <div class="col-md-4">
                <span>مبلغ: </span>
                <span>
                  <?php
                  echo number_format($info_credit['amount']);
                  ?>
                </span>
              </div>
              <div class="col-md-4">
                <span>توضیحات تراکنش: </span>
                <span class="yn">
                  <?php
                  echo $info_credit['comment']
                  ?>
                </span>
              </div>

              <div class="col-md-4">
                <span>شماره کارت: </span>
                <span class="yn">
                  <?php
                  echo $info_credit['factorNumber']
                  ?>
                </span>
              </div>

            </div>
<!--            <hr style="margin: 5px 0;">-->




            <div class="modal-footer site-bg-main-color"></div>
          </div>
          <div class="modal-footer site-bg-main-color">

            <button type="button" class="btn btn-primary  pull-left"
                    onclick="ConfirmAdminRequestedUser('<?php echo $Param; ?>')">
              تایید پرداخت
            </button>
            <button type="button" class="btn btn-danger  pull-left"
                    onclick="RejectAdminRequestedUser('<?php echo $Param; ?>')">
              عدم تایید
            </button>

          </div>
        </div>
      </div>

      </div>

        <?php
    }

    #endregion

  public function ModalUserList($request_number , $type ) {
      $user = Load::controller($this->Controller);
      $infoUserList = $user->infoModalUserList($request_number, $type);
      ?>
    <div class="modal-header site-bg-main-color">
      <span class="close" onclick="modalClose()">&times;</span>
      <h4 dir='rtl'>  <?php echo functions::Xmlinformation("Numberreservation") ?> : <?php echo $request_number ?></h4>
    </div>

    <div class="modal-body">
      <div class="modal-padding-bottom-15">
        <div class="row">
          <div class="col-md-12 modal-text-center modal-h ">   <?php echo functions::Xmlinformation("ProfileListPassengers") ?></div>
        </div>
        <table class="table">
          <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col"><?php echo functions::Xmlinformation("FirstName") ?></th>
            <th scope="col"><?php echo functions::Xmlinformation("LastName") ?></th>
            <th scope="col"><?php echo functions::Xmlinformation("NationalCode") ?>/<?php echo functions::Xmlinformation("Numpassport") ?></th>
            <th scope="col"><?php echo functions::Xmlinformation("DateOfBirth") ?></th>
            <th scope="col"><?php echo functions::Xmlinformation("Ages") ?></th>
          </tr>
          </thead>
          <tbody>
      <?php
      foreach ($infoUserList as $i => $info) { ?>
          <tr>
            <th scope="row"><?php echo ++$i?></th>
            <td><?php echo $info['passenger_name'] ? $info['passenger_name'] : $info['passenger_name_en']; ?></td>
            <td><?php echo $info['passenger_family'] ? $info['passenger_family'] : $info['passenger_family_en']; ?></td>
            <td><?php echo ($info['passenger_national_code'] != '0000000000') ? $info['passenger_national_code'] : $info['passportNumber'] ?></td>
            <td><?php echo (!empty($info['passenger_birthday'])) ? $info['passenger_birthday'] : $info['passenger_birthday_en'] ?></td>
            <td><?php
                switch ($info['passenger_age']) {

                    case 'Adt':
                        echo functions::Xmlinformation("Adult");
                        break;

                    case 'Chd':
                        echo functions::Xmlinformation("Child");
                        break;

                    case 'Inf':
                        echo functions::Xmlinformation("Baby");
                        break;
                }
                ?></td>
          </tr>
        <?php } ?>
          </tbody>
        </table>

      </div>
    </div>


<?php
  }



    #region credit wallet

    public function returnCreditWallet($Param , $Param2 , $Param3) {


        ?>
      <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header site-bg-main-color">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">انتقال اعتبار به کیف پول کاربر</h4>
          </div>
          <form id="BackWallet" name="BackWallet" method="post">
            <input type="hidden" value="BackWallet" name="flag" id="flag">
            <input type="hidden" value="<?php echo $Param ?>" name="RequestNumber" id="RequestNumber">
            <input type="hidden" value="<?php echo $Param2 ?>" name="ParamId" id="ParamId">
            <input type="hidden" value="<?php echo $Param3 ?>" name="ClientID" id="ClientID">
            <div class="modal-body">
              <div class="row">
                <div class="form-group col-md-12 col-lg-12 col-sm-12 col-xs-12 ">
                  <label>چه مبلغی به اعتبار کاربر برگردانده شود</label>
                  <input type="text" class="form-control" value="" name="priceBack" id="priceBack"/>
                </div>


              </div>


            </div>

            <div class="modal-footer site-bg-main-color">

              <button type="button" class="btn btn-primary  pull-right" data-dismiss="modal">بستن</button>
              <button type="submit" class="btn btn-success pull-right">ارسال اطلاعات</button>


            </div>
          </form>

          <script type="text/javascript">
            $(document).ready(function () {
              $("#AddPnr").validate({
                rules: {
                  pnr: "required"
                },
                messages: {},
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
                    url: amadeusPath + 'user_ajax.php',
                    type: "post",
                    success: function (response) {
                      var res = response.split(':');

                      if (response.indexOf('Success') > -1) {
                        $.toast({
                          heading: 'افزودن pnr ',
                          text: res[1],
                          position: 'top-right',
                          loaderBg: '#fff',
                          icon: 'success',
                          hideAfter: 3500,
                          textAlign: 'right',
                          stack: 6
                        });

                        setTimeout(function () {
                          $('#ModalPublic').modal('hide');
                        }, 1000);


                      } else {

                        $.toast({
                          heading: 'افزودن  pnr',
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
            })

          </script>

          <script type="text/javascript">
            $(document).ready(function () {
              $("#BackWallet").validate({
                rules: {
                  priceBack: "required"
                },
                messages: {},
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
                    url: amadeusPath + 'user_ajax.php',
                    type: "post",
                    success: function (response) {
                      let data_response = JSON.parse(JSON.stringify(response))
                      console.log(data_response);
                      let displayIcon
                      var res = response.split(':');
                      if (res[0] = 'Success ') {
                        displayIcon = 'success'
                      } else {
                        displayIcon = 'error'
                      }

                      // console.log(res[0]);
                      // alert(res[0]);

                      $.toast({
                        heading: 'بازگشت به کیف پول',
                        text: res[1],
                        position: 'top-right',
                        icon: displayIcon,
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6,
                      })

                      if (res[0] === 'Success ') {
                        setTimeout(function() {
                          location.reload()
                          // window.location = `${amadeusPath}itadmin/ticket/userTicketCancellationHistory`;
                        }, 1000)
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
            })

          </script>
        </div>
      </div>


        <?php
    }

    public function ModalChangeCloseTime()
    {
       $airlineId = $_POST['airlineId'];

        $airline_close_time_model = $this->getModel('airlineCloseTimeModel');
        $airline = $airline_close_time_model
            ->get()
            ->where('type' , 'airline')
            ->where('type_id' , $airlineId)
            ->find();
        $globalTime = $airline_close_time_model
            ->get()
            ->where('type' , 'airline')
            ->where('type_id' , '0')
            ->find();

        $internalTime='';
        $externalTime='';

        if ($airline) {
           if ($airline['internal']) {
               $internalTime = explode(':', $airline['internal']);
           } else {
               $internalTime = explode(':', $globalTime['internal']);
           }
            if ($airline['external']) {
                $externalTime = explode(':', $airline['external']);
            } else {
                $externalTime = explode(':', $globalTime['external']);
            }
        } else {
            $internalTime = explode(':', $globalTime['internal']);
            $externalTime = explode(':', $globalTime['external']);
        }

        $internalTimeHour = $internalTime[0];
        $internalTimeMinute = $internalTime[1];

        $externalTimeHour = $externalTime[0];
        $externalTimeMinute = $externalTime[1];

        ?>

       <div class="modal-dialog modal-lg">
          <div class="modal-content">
             <div class="modal-header site-bg-main-color p-4">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">تنظیم ساعت ارسال مانیفست</h4>
             </div>
             <div class="center_modal_custom p-4">

                   <div class="row">
                      <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 nopad internalTime" style="direction: rtl;">
                         <div class="col-12 mb-4">
                            ساعت داخلی
                         </div>
                         <div class="form-group col-sm-6">
                            <label for="minutes" class="control-label">دقیقه</label>
                            <select name="minutes" class="form-control minutes">
                                <?php for ($n = 0; $n <= 9; $n++): ?>
                                    <?php $value = "0" . $n; ?>
                                   <option value="<?php echo $value; ?>"
                                       <?php if ($internalTimeMinute == $value) echo 'selected'; ?>>
                                       <?php echo $value; ?>
                                   </option>
                                <?php endfor; ?>

                                <?php for ($n = 10; $n <= 60; $n++): ?>
                                   <option value="<?php echo $n; ?>"
                                       <?php if ($internalTimeMinute == $n) echo 'selected'; ?>>
                                       <?php echo $n; ?>
                                   </option>
                                <?php endfor; ?>
                            </select>
                         </div>
                         <div class="form-group col-sm-6">
                            <label for="hours" class="control-label">ساعت</label>
                            <select name="hours" class="form-control hours">
                                <?php for ($n = 0; $n <= 9; $n++): ?>
                                    <?php $value = "0" . $n; ?>
                                   <option value="<?php echo $value; ?>"
                                       <?php if ($internalTimeHour == $value) echo 'selected'; ?>>
                                       <?php echo $value; ?>
                                   </option>
                                <?php endfor; ?>

                                <?php for ($n = 10; $n <= 24; $n++): ?>
                                   <option value="<?php echo $n; ?>"
                                       <?php if ($internalTimeHour == $n) echo 'selected'; ?>>
                                       <?php echo $n; ?>
                                   </option>
                                <?php endfor; ?>
                            </select>
                         </div>
                      </div>
                      <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 nopad  externalTime" style="direction: rtl;">
                         <div class="col-12 mb-4">
                            ساعت خارجی
                         </div>
                         <div class="form-group col-sm-6">
                            <label for="minutes" class="control-label">دقیقه</label>
                            <select name="minutes" class="form-control minutes">
                                <?php for ($n = 0; $n <= 9; $n++): ?>
                                    <?php $value = "0" . $n; ?>
                                   <option value="<?php echo $value; ?>"
                                       <?php if ($externalTimeMinute == $value) echo 'selected'; ?>>
                                       <?php echo $value; ?>
                                   </option>
                                <?php endfor; ?>

                                <?php for ($n = 10; $n <= 60; $n++): ?>
                                   <option value="<?php echo $n; ?>"
                                       <?php if ($externalTimeMinute == $n) echo 'selected'; ?>>
                                       <?php echo $n; ?>
                                   </option>
                                <?php endfor; ?>
                            </select>
                         </div>
                         <div class="form-group col-sm-6">
                            <label for="hours" class="control-label">ساعت</label>
                            <select name="hours" class="form-control hours">
                                <?php for ($n = 0; $n <= 9; $n++): ?>
                                    <?php $value = "0" . $n; ?>
                                   <option value="<?php echo $value; ?>"
                                       <?php if ($externalTimeHour == $value) echo 'selected'; ?>>
                                       <?php echo $value; ?>
                                   </option>
                                <?php endfor; ?>

                                <?php for ($n = 10; $n <= 24; $n++): ?>
                                   <option value="<?php echo $n; ?>"
                                       <?php if ($externalTimeHour == $n) echo 'selected'; ?>>
                                       <?php echo $n; ?>
                                   </option>
                                <?php endfor; ?>
                            </select>
                         </div>
                      </div>
                   </div>

             </div>
             <div class="modal-footer site-bg-main-color">
                <button type="button" class="btn btn-primary  pull-right" data-dismiss="modal">بستن</button>
                <button class="btn-send-information btn btn-success pull-right d-flex justify-content-center align-items-center" id='btn-information' onclick="ChangeCloseTime('<?php echo $airlineId ?>')">
                    <?php echo functions::Xmlinformation("Sendinformation") ?>
                   <div class="spinner-border" id='btn-send-information-load' role="status">
                      <span class="sr-only">Loading...</span>
                   </div>
                </button>
             </div>
          </div>
       </div>

        <?php
    }

    #endregion

}

/**
 * این کلاس چون از طریق جاوا اسکریپت فراخوانی میشود
 * همین جا صدا زده شده
 * لطفا پاک نشود
 */
new ModalCreator();
?>

<style>

    .donut {
        width: 2rem;
        height: 2rem;
        margin: 2rem;
        border-radius: 50%;
        border: 0.3rem solid rgba(151, 159, 208, 0.3);
        border-top-color: rgba(151, 159, 208, 0.3);
        border-top-color: #979fd0;
        -webkit-animation: 1.5s spin infinite linear;
        animation: 1.5s spin infinite linear;
        display:none;
    }
    @-webkit-keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }





</style>
