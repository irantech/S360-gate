<?php


class BookRoutes extends clientAuth{

    public function __construct(){
        parent::__construct();
    }

    public function getDetailFlightOfReportRoute($request_number){

        $result_detail_route = $this->getModel('reportRoutesModel')->get()->where('requestNumber',$request_number)->all();

        $detail_final = array();
        foreach ($result_detail_route as $res){
            if ($res['TypeRoute'] == 'Dept') {
                $detail_final['dept'][] = $res;
            }else if ($res['TypeRoute'] == 'Return') {
                $detail_final ['return'][] = $res;
            }
        }

        return $detail_final;
    }
}