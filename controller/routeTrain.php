<?php
/**
 * Class routeTrain
 * @property routeTrain $routeTrain
 */
class routeTrain extends clientAuth
{

    public function __construct()
    {
        parent::__construct();
    }

    #region ListRoute


    public function ListRoute()
    {
        return $this->getModel('trainRouteCustomerModel')->get()->orderBy('priority=0, priority' , 'ASC')->all();
    }
    #endregion



    #region SetPriorityParentDeparture

    public function SetPriorityParentDeparture($Param)
    {

        $Model = Load::library('Model');
        $Model->setTable('train_route_tb');
        $p1 = $Param['PriorityOld'];
        $p2 = $Param['PriorityNew'];
        $Code = $Param['CodeDeparture'];
        $priority = (isset($Param['Destination']) && $Param['Destination']) ? 'priorityDestination' : 'priority' ;
        $RoutesSql = "SELECT * FROM train_route_tb WHERE Code <> '{$Code}'";
        $ResultRoutesSql = $Model->select($RoutesSql);


        $RoutesSql = "SELECT max({$priority}) AS MAXPriority FROM train_route_tb
                      WHERE EXISTS (SELECT * FROM train_route_tb WHERE {$priority} ='{$p2}')";
        $PriorityMax = $Model->load($RoutesSql);

        $flag = false;

        if ($p1 == 0) {
            //مقدار کد مور نظر آپدیت میشود

            $Condition = "Code='{$Code}'";
            $dataCodeUp[$priority] = !empty($PriorityMax['MAXPriority']) ? ($PriorityMax['MAXPriority'] + 1) : $p2;
            $updatePriorityCode = $Model->update($dataCodeUp, $Condition);
            if ($updatePriorityCode) {
                $flag = true;
            }
        } elseif ($p1 < $p2) {// الویت را بیشتر میکنیم
            for ($j = 0; $j < count($ResultRoutesSql); $j++) {
                if ($ResultRoutesSql[$j][$priority] != 0) {
                    $dataUp[$priority] = $ResultRoutesSql[$j][$priority] - 1;
                } else {
                    $dataUp[$priority] = 0;
                }
                $Condition = "{$priority}>='{$p1}' AND {$priority}<='{$p2}' AND Code = '{$ResultRoutesSql[$j]['Code']}' AND {$priority} <> '0'";
                $updatePriorityOtherCode = $Model->update($dataUp, $Condition);
            }
            //مقدار کد مور نظر آپدیت میشود
            $Condition = "Code='{$Code}'";
            $dataCodeUp[$priority] = $p2;
            $updatePriorityCode = $Model->update($dataCodeUp, $Condition);

            if ($updatePriorityCode && $updatePriorityOtherCode) {
                $flag = true;
            }
        } elseif ($p1 > $p2) {// الویت را کمتر میکنیم
            for ($j = 0; $j < count($ResultRoutesSql); $j++) { // upd maghadir beyne p1 & p2
                if ($ResultRoutesSql[$j][$priority] != 0) {
                    $dataDown[$priority] = $ResultRoutesSql[$j][$priority] + 1;
                } else {
                    $dataDown[$priority] = 0;
                }
                $Condition = "{$priority}<='{$p1}' AND {$priority}>='{$p2}' AND Code = '{$ResultRoutesSql[$j]['Code']}' AND $priority <> '0'";
                $updatePriorityOtherCode = $Model->update($dataDown, $Condition);
            }
            //مقدار کد مور نظر آپدیت میشود
            $dataDownCode[$priority] = $p2;
            $Condition = "Code='{$Code}'";
            $updatePriorityCode = $Model->update($dataDownCode, $Condition);


            if ($updatePriorityCode && $updatePriorityOtherCode) {
                $flag = true;
            }
        }

        if ($flag) {
            return 'SuccessChangePriority:تغییر الویت با موفیقت انجام شد';
        } else {
            return 'ErrorChangePriority:خطا در تغییر الویت';
        }

    }

    #endregion


    /**
     * @throws Exception
     */
    public function getTrainRoutes($params,$is_customer=true)
    {

        if($is_customer)
            $train_routes=$this->getModel('trainRouteCustomerModel')
                 ->get('DISTINCTROW *',true);
        else
            $train_routes=$this->getModel('trainRouteModel')
                ->get('DISTINCTROW *',true);

        if ((isset($params['type']) && $params['type'] == 'destination')) {
            $typePriority = 'priorityDestination';
        } else {
            $typePriority = 'priority';
        }


        if ($params['value']) {

            $train_routes=$train_routes->like('Name',"%{$params['value']}%");
            $train_routes=$train_routes->like('EnglishName',"%{$params['value']}%");
        }

        $train_routes=$train_routes->groupBy('Code');


        $limit = '20';
        if ($params['limit']) {
            $limit = $params['limit'];
        }
        $train_routes=$train_routes->limit(0, $limit);

        $train_routes=$train_routes->all();



        return $train_routes;
    }



}

