<?php


class baseCompanyBus extends clientAuth
{
    public function getData()
    {
        return $this->getModel('baseCompanyBusModel')->get()
            ->where('is_del', 'no')
            ->where('type_vehicle', 'bus')
            ->openParentheses()
            ->where('client_id',0)
            ->orWhere('client_id',CLIENT_ID)
            ->closeParentheses()
            ->all();
    }


    public  function getCompanyTrainPhoto( $code, $capacity = null ) {
        $result =  $this->getModel('baseCompanyBusModel')->get()->where('type_vehicle','train')
            ->openParentheses()
            ->where('code_company_raja',$code)
            ->orWhere('name_fa',$code)
            ->closeParentheses()
            ->where('is_del','no')->find();
        if ( ! empty( $result ) && $result['logo'] != '' ) {
            if ( $code == '31' && $capacity == '4' ) {
                $result['logo'] = 'arg.png';
            }
            return ROOT_ADDRESS_WITHOUT_LANG . "/pic/companyBusImages/" . $result['logo'];
        }
            return ROOT_ADDRESS_WITHOUT_LANG . "/pic/companyBusImages/no-photo-train.png";
    }




    public  function getCompanyTrainById( $code ) {
        $result =  $this->getModel('baseCompanyBusModel')->get()->where('type_vehicle','train')->where('code_company_raja',$code)->find();
        return $result['name_fa'];
    }

}