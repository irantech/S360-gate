<?php
error_reporting(1);
error_reporting(E_ALL | E_STRICT);
@ini_set('display_errors', 1);
@ini_set('display_errors', 'on');
$a = new syncDataGds();
$a->init();

class syncDataGds extends baseController
{
    protected $content = [];
//Hotel
//'Tour','Flight','Visa',
    protected $services = [

        'Flight',

    ];
    protected $address;

    public function __construct() {

        header("Content-type: application/json");


    }

    public function init() {

        $this->content = $_GET;


        $method = $this->content['method'];

        unset($this->content['method']);
        unset($this->content['param']);
        $params = $this->content;


        $host_addr = gethostname();
        $ip_addr = gethostbyname($host_addr);


        if ($ip_addr == "159.69.52.220") {
            $this->address = "https://safar360.com/gds/infoGds";
        } else if ($ip_addr == "37.32.27.222") {
            $this->address = "https://safar360.com/gds/infoGds";
        }


        if (!$method) {
            return functions::withError([$method, 'syncDataGds', $this->content], 400, 'method parameter not sent');
        }
        if (!method_exists('syncDataGds', $method)) {
            return functions::withError(['syncDataGds', $method], 400, 'method not found');
        }

        echo $this->$method($params);


    }

    public function fetchData() {
        /** @var syncDatabase $sync_database_controller */
        $sync_database_controller = $this->getController('syncDatabase');
        $this->content['method'] = 'callSyncDatabase';
        $sync_result = [];
        $total_time = 0;

        foreach ($this->services as $key => $service) {
            $this->content['service'] = $service;
            $last_record = $sync_database_controller->getServiceClass($service)->getLastItem();
            $this->content['last_item'] = $last_record;

            $start_time = microtime(true);
            $result = functions::curlExecution($this->address, json_encode($this->content), 'json');
            $end_time = microtime(true);

            $time_taken_ms = ($end_time - $start_time);
            $time_taken_formatted = number_format($time_taken_ms, 3);
            $total_time += $time_taken_ms;
            $sync_result[$key] = $result ? $sync_database_controller->syncService($service, $result) : $service . ' is already synced.';
            $sync_result[$key] .= ' Time taken: ' . $time_taken_formatted . ' seconds';
            //show sum of time taken
        }
        $sync_result[] = 'Total time taken: ' . number_format($total_time, 3) . ' seconds';

        return json_encode($sync_result);
    }


}
