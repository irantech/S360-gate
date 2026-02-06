<?php

class requestReservation extends clientAuth
{
    /** @var  $targetBookModel bool|mixed|Model|ModelBase*/
    protected $targetBookModel;
    /** @var  $targetReservationController reservationTour */
    protected $targetReservationController;
    protected $requestReservationModel;
    protected $tour='tour';
    protected $hotel='hotel';
    protected $entertainment='entertainment';
    protected $visa='visa';

    protected $serviceName;
    protected $params=[];
    public function __construct() {
        parent::__construct();
        $this->requestReservationModel=$this->getModel('requestReservationModel');
    }

    private function getTargetClasses($serviceName) {
        try {
            switch ($serviceName) {
                case $this->tour:
                    $targetBookModel='bookTourLocalModel';
                    $targetReservationController='reservationTour';
                    break;
                case $this->hotel:
                    $targetBookModel='book_hotel_local_tb';
                    $targetReservationController='resultHotelLocal';
                    break;
               case $this->entertainment:
                    $targetBookModel='bookEntertainmentModel';
                    $targetReservationController='entertainment';
                    break;
                /*case $this->visa:
                    $targetBookModel='bookTourLocalModel';
                    $targetReservationController='bookTourLocalModel';
                    break;*/
            }
        }catch (Exception $e){

        }
        $this->targetBookModel=$this->getModel($targetBookModel);
        $this->targetReservationController=$this->getController($targetReservationController);

    }
    public function initialize($serviceName) {
        $this->serviceName=$serviceName;

        $this->getTargetClasses($serviceName);
    }
    public function getTargetDetail($params) {

        if($params['is_api']){
            return $this->targetReservationController->detailOnDayTour($params);
        }
        return $this->targetReservationController->getFullDetail($params);
    }

    public function create($params) {

        $factorNumber=$this->targetReservationController->registerBookRecord($params);

        if(!$this->getRequest($this->serviceName,$factorNumber)) {
            $result_insert_request = $this->requestReservationModel->insertWithBind([
                'service_name' =>$this->serviceName,
                'factor_number'=>$factorNumber,
                'price_change' =>0,
            ]);

            if($result_insert_request){

                $this->getController('manageMenuAdmin')->getMembersAccessHistory($params['serviceTitle']);
                return [
                    'service_name'=>$this->serviceName,
                    'factor_number'=>$factorNumber,
                ];
            }

        }
        return [
            'service_name'=>$this->serviceName,
            'factor_number'=>$factorNumber,
        ];

    }

    public function callChangeStatus($params) {
        return $this->changeStatus($params['serviceName'],$params['factor_number'],$params['status']);
    }
    public function callChangePrice($params) {
        return $this->changePrice($params['serviceName'],$params['factor_number'],$params['price']);
    }

    public function changeStatus($serviceName,$factorNumber,$status) {
        $this->initialize($serviceName);

        return $this->targetReservationController->changeStatus($factorNumber,$status);
    }

    public function changePrice($serviceName, $factorNumber, $price) {
        $this->initialize($serviceName);

        return $this->requestReservationModel->updateWithBind([
            'price_change'=>$price
        ],[
            'factor_number'=>$factorNumber,
            'service_name'=>$this->serviceName,
        ]);
    }
    public function getRequest($serviceName,$factorNumber) {
        $this->initialize($serviceName);
        return $this->requestReservationModel->get()
            ->where('factor_number',$factorNumber)
            ->where('service_name',$this->serviceName)
            ->find();
    }
}