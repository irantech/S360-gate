<?php


class busRoute extends clientAuth{

    public function __construct() {
        parent::__construct();
    }


    public function routeBus($data = null) {

        $bus_routes=$this->getModel('busRouteModel')->get();

        $bus_routes=$bus_routes->where('iataCode','','!=');

        if ($data['value']) {
            $bus_routes=$bus_routes->where('name_fa','%'.$data['value'].'%','like');
            $bus_routes=$bus_routes->orwhere('name_en','%'.$data['value'].'%','like');
            $bus_routes=$bus_routes->orwhere('iataCode','%'.$data['value'].'%','like');
            $bus_routes=$bus_routes->orwhere('code','%'.$data['value'].'%','like');
        }
        $bus_routes=$bus_routes->orderBy('priority=0,priority', 'ASC')->all();
        $result = ['results'=>[]];
        foreach ($bus_routes as $bus_route) {
            $result['results'][] = [
                "id" => $bus_route['iataCode'],
                "text" => $bus_route['name_fa'],
            ];
        }
        return functions::toJson($result);
    }

    public function getPopularBusCities() {
        // لیست کدهای IATA به ترتیب اولویت
        $popularIataCodes = ['THR', 'MHD', 'SYZ', 'TBZ', 'RAS', 'HDM', 'IFN', 'KSH', 'BND', 'AZD'];

        $bus_routes = $this->getModel('busRouteModel')->get();
        $bus_routes = $bus_routes->where('iataCode', '', '!=');
        $bus_routes = $bus_routes->whereIn('iataCode', $popularIataCodes)->all();

        // مرتب‌سازی بر اساس ترتیب آرایه $popularIataCodes
        $sortedRoutes = [];
        foreach ($popularIataCodes as $code) {
            foreach ($bus_routes as $route) {
                if ($route['iataCode'] === $code) {
                    $sortedRoutes[] = $route;
                    break;
                }
            }
        }

        $result = ['results' => []];
        foreach ($sortedRoutes as $bus_route) {
            $result['results'][] = [
                "id" => $bus_route['iataCode'],
                "text" => $bus_route['name_fa'],
            ];
        }

        return functions::toJson($result);
    }

}