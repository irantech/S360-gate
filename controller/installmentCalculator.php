<?php

class installmentCalculator extends clientAuth {
    public function getData() {
        $result = $this->getModel('installmentCalculatorModel')->get()->find();
        return $result;
    }


    public function update($params) {
//var_dump($params);
//die;
        $about_us=$this->getModel('installmentCalculatorModel');
        $update_data=[
            'title'=>$params['title'],
            'min_installments'=>$params['min_installments'],
            'max_installments'=>$params['max_installments'],
            'min_price'=>$params['min_price'],
            'max_price'=>$params['max_price'],
            'initial_payment'=>$params['initial_payment'],
            'profit_percentage'=>$params['profit_percentage'],

        ];
        $last_about_us=$this->getData();

        if(!$last_about_us){
            return $about_us->insertWithBind($update_data);
        }

         return $about_us->updateWithBind($update_data);

    }

}