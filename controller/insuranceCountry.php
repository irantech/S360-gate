<?php


class insuranceCountry extends clientAuth {


    public function __construct() {
        parent::__construct();
    }

    public function AllCountryInsurance() {
        return $this->getModel('insuranceCountryModel')->getAllCountries();
    }

    public function routeInsurance($data = null) {

        $insurance_routes=$this->getModel('insuranceCountryModel')->get();


        if ($data['value']) {
            $insurance_routes=$insurance_routes->where('persian_name','%'.$data['value'].'%','like');
            $insurance_routes=$insurance_routes->orwhere('abbr','%'.$data['value'].'%','like');
        }
        $insurance_routes=$insurance_routes->orderBy('priority=0,priority', 'ASC')->all();
        $result = ['results'=>[]];
        foreach ($insurance_routes as $insurance_route) {
            $result['results'][] = [
                "id" => $insurance_route['abbr'],
                "text" => $insurance_route['persian_name'] . '(' . $insurance_route['abbr'] . ')' ,
            ];
        }
        return functions::toJson($result);
    }



    public function ExternalCountryInsurance() {


        $result = $this->getModel('insuranceCountryModel')
            ->get()
            ->where('abbr', 'IRN', '!=')
            ->groupBy('abbr')
            ->orderBy('priority=0,priority', 'ASC')
            ->all(false);

        return $result;
    }




}