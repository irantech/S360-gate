<?php

abstract class syncServiceDatabase extends clientAuth
{
    protected $table;
    protected $model;
    protected $current_source;
    protected $target_source;
    protected $service;
    protected $time_field;
    protected $request_number_field;
    //Monday, 19 June 2023 00:00:00
    protected $default_init_time = '1687132800';
    protected $default_queue_limitation = 1000;

    public function __construct($service) {
        parent::__construct();
        $this->service=$service;
        $this->setTable();
        $this->setCurrentAndTargetSources();
    }

    abstract protected function setTable();
    protected function setCurrentAndTargetSources() {
        $host_addr = gethostname();
        $ip_addr = gethostbyname($host_addr);

        if ($ip_addr === "159.69.52.220") {
            $this->current_source = "german";
            $this->target_source = "iran";
        } elseif ($ip_addr === "37.32.27.222") {
            $this->current_source = "iran";
            $this->target_source = "german";
        }
    }

    public function fetch($params) {


        $last_item = $params['last_item'];

        $items = $this->model
            ->get()
            ->where($this->time_field, $last_item, '>');
        if ($this->target_source === 'german') {
            $items = $items
                ->where('database_source', $this->target_source);
        }
        $items = $items
            ->limit(0, $this->default_queue_limitation)
            ->all();


        $result = [];


        foreach ($items as $key => $item) {
            unset($item['id']);

            $result[$item[$this->request_number_field]][] = $item;
        }

        return $result;
    }

    public function getNonSynced($fetched_items) {
        $result = [];

        $check = $this->model
            ->get()
            ->where('client_id', '186')
            ->where('creation_date_int', '1687132800' , '>')
            ->where('database_source', $this->target_source )
            ->toSql();
        echo json_encode($check);
        die();
        foreach ($fetched_items as $request_number => $items) {

            $source = $this->target_source;
            $check = $this->getLastItemBySource($source);


            if($check){
                $check = $this->model
                    ->get("count('id') as exist", true)
                    ->where($this->request_number_field, $request_number)
                    ->where('client_id', '186')
                    ->where('creation_date_int', $this-default_init_time)
                    ->where('database_source', $this->target_source)
                    ->find();
            }else{
                $check = $this->model
                    ->get("count('id') as exist", true)
                    ->where($this->request_number_field, $request_number)
                    ->find();
            }



            if (!$check['exist']) {
                foreach ($items as $item) {
                    $result[] = $item;
                }
            }
        }

        return $result;
    }

    public function sync($non_synced_items) {
        // Check if there are items to sync
        if (!$non_synced_items) {
            return "No items to sync.";
        }

        // Prepare values for each item
        $insert_values = [];

        foreach ($non_synced_items as $key => $item) {
            $item_values = array_merge($this->prepareValues($item), $this->prepareValues([$this->target_source]));
            $insert_values[] = '(' . implode(', ', $item_values) . ')';
        }

        // Generate the column names and values for the SQL query
        $columns = implode(', ', array_merge(array_keys($non_synced_items[0]), ['database_source']));
        $values_query = implode(', ', $insert_values);
        $total_items = count($non_synced_items);

        // Build and execute the SQL query
        $query = "INSERT INTO {$this->table} ({$columns}) VALUES {$values_query}";

        Load::library('ModelBase')->execQuery($query); // Using the method directly, without $ModelBase variable.

        // Generate and return a success message
        $item_plural_suffix = ($total_items > 1) ? 's' : '';
        $message = number_format($total_items) . " item{$item_plural_suffix} has been added to {$this->service} on {$this->current_source} server.";
        return $message;
    }

    protected function prepareValues($item) {
        $prepared_values = [];
        foreach ($item as $key => $value) {
            if ($value === null) {
                $prepared_values[] = 'NULL';
            } else {
                $value = str_replace("'", "\'", $value);
                $prepared_values[] = "'" . $this->defaultValue($key, $value) . "'";
            }
        }
        return $prepared_values;
    }

    protected function defaultValue($field, $value) {
        return $value;
    }

    public function getLastItem() {
        $source = $this->target_source;
        $check = $this->getLastItemBySource($source);

        if ($check && $check[$this->time_field]) {
            return $check[$this->time_field];
        }

        return $this->default_init_time;

    }

    private function getLastItemBySource($source) {
        return $this->model
            ->get($this->time_field)
            ->where('database_source', $source)
            ->orderBy($this->time_field, 'desc')
            ->limit(0, 1)
            ->find();
    }


}