<?php


class configFlight extends clientAuth
{
    #region [__construct]
    public function __construct(){
        parent::__construct();
    }
    #endregion

    #region [checkStatusConfigAirline]
    public function checkStatusConfigAirline($data_check_config){

        $data_config = $data_check_config['selected_config'];
//        if($data_check_config['source_id'] == '20'){
//            return 'private';
//        }
        if (
            ($data_config['isPublic'] == '0'
                && ($data_config['sourceId'] == $data_check_config['source_id'])) ||
            ($data_config['sourceReplaceId'] == $data_check_config['source_id'])
            && $data_config['isPublicreplaced'] == '0' && $data_check_config['source_id'] !== '16') {
            return 'private';
        }
        return 'public';
    }
    #endregion

    public function checkConfigStatusSpecificAirline($data_check_config)
    {
            $info_airline = $this->getController('airline')->getByAbb($data_check_config['airline_iata']) ;
            $result_specific_config = $this->getModel('configFlightModel')->get()->where('airlineId',$info_airline['id'])->where('typeFlight',$data_check_config['flight_type'])
                ->where('isInternal',$data_check_config['is_internal'])->find();
        if (($result_specific_config['isPublic'] == '0'
                && ($result_specific_config['sourceId'] == $data_check_config['source_id']))
            || ($result_specific_config['sourceReplaceId'] == $data_check_config['source_id'])
            && $result_specific_config['isPublicreplaced'] == '0' && $data_check_config['source_id'] !== '16') {
            return 'private';
        }
        return 'public';

    }

}