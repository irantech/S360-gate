<?php

class configurations extends baseController
{
    private $config_tbl, $services_group_tbl, $config_rel_tbl, $client_content_tbl, $clients_tbl, $client_id, $client_name;
    public $listAllConfigurations, $listClientConfigurations;

    public function __construct()
    {
        $this->config_tbl = 'client_configuration_tb';
        $this->config_rel_tbl = 'client_config_relation_tb';
        $this->client_content_tbl = 'configuration_content_tb';
        $this->services_group_tbl = 'services_group_tb';
        $this->clients_tbl = 'clients_tb';
        $this->client_id = CLIENT_ID;
        $this->client_name = CLIENT_NAME;
    }

    public function getAllConfigurations()
    {

        $services_group = $this->getModel('servicesGroupModel')->getTable();
        $query = $this->getModel('clientConfigurationModel');
        $query = $query->get('*,' . $services_group . '.title AS service_group_title');
        $query = $query->join($services_group, 'id', 'service_group_id', 'LEFT');
        return $query->all();
    }

    public function getConfigurationById($id)
    {


        $services_group = $this->getModel('servicesGroupModel')->getTable();
        $client_configuration = $this->getModel('clientConfigurationModel')->getTable();
        $query = $this->getModel('clientConfigurationModel');
        $query = $query->get('*,' . $services_group . '.title AS service_group_title');
        $query = $query->join($services_group, 'id', 'service_group_id', 'LEFT');
        $query = $query->where($client_configuration . '.id', $id);
        return $query->find();


    }

    public function getConfigurationByTitle($title)
    {

        $services_group = $this->getModel('servicesGroupModel')->getTable();
        $client_configuration = $this->getModel('clientConfigurationModel')->getTable();
        $query = $this->getModel('clientConfigurationModel');
        $query = $query->get('*,' . $services_group . '.title AS service_group_title');
        $query = $query->join($services_group, 'id', 'service_group_id', 'LEFT');
        $query = $query->where($client_configuration . '.title', $title);
        $query = $query->orWhere($client_configuration . '.title_en', $title);
        return $query->find();
    }

    public function getClientConfigurations($client_id, $conditions = [], $client_side = false)
    {
        /** @var ModelBase $ModelBase */
        $where = "{$this->config_rel_tbl}.client_id = '{$client_id}'";
        if ($client_side) {
            $where .= " AND {$this->config_tbl}.client_can_edit = '1'";
        }
        if (!empty($conditions)) {
            foreach ($conditions as $key => $value) {
                $cond[] = "{$key}={$value}";
            }
            $where .= implode(" AND ", $cond);
        }
        $ModelBase = Load::library('ModelBase');
        $sql = "SELECT {$this->clients_tbl}.id AS clientId, {$this->clients_tbl}.AgencyName AS ClientName, {$this->config_tbl}.* FROM {$this->clients_tbl}
	INNER JOIN {$this->config_rel_tbl} ON {$this->clients_tbl}.id = {$this->config_rel_tbl}.client_id
	INNER JOIN {$this->config_tbl} ON {$this->config_rel_tbl}.configuration_id = {$this->config_tbl}.id
	WHERE {$where}";

        $configurations = $ModelBase->select($sql);

        return $configurations;

    }

    public function getConfigurationClients($configuration_id)
    {
        $ModelBase = Load::library('ModelBase');
        $sql = "SELECT {$this->clients_tbl}.*,{$this->config_tbl}.title AS ConfigurationTitle,{$this->config_tbl}.title_en,{$this->config_tbl}.type,{$this->config_tbl}.is_active FROM {$this->clients_tbl}
	INNER JOIN {$this->config_rel_tbl} ON {$this->clients_tbl}.id = {$this->config_rel_tbl}.client_id
	INNER JOIN {$this->config_tbl} ON {$this->config_rel_tbl}.configuration_id = {$this->config_tbl}.id
	WHERE {$this->config_rel_tbl}.configuration_id = '{$configuration_id}'";

        $client = $ModelBase->select($sql);

        return $client;
    }

    public function getAllClientsConfiguration($client_id = null)
    {
        $where = "{$this->clients_tbl}.`id` > 1";
        if ($client_id) {
            $where .= " AND {$this->clients_tbl}.`id` = '{$client_id}'";
        }
        $sql = "SELECT * FROM {$this->clients_tbl} WHERE {$where}";

        /** @var ModelBase $ModelBase */
        $ModelBase = Load::library('ModelBase');
        $clients = $ModelBase->select($sql);

        $result = [];
        foreach ($clients as $key => $client) {
            $configurations = self::getClientConfigurations($client['id']);
            $result[$key] = [
                'client_id' => $client['id'],
                'name' => $client['AgencyName'],
                'configurations' => $configurations
            ];
        }

        return $result;
    }

    public function getAllServiceGroups()
    {
        $sql = "SELECT * FROM {$this->services_group_tbl} ";
        /** @var ModelBase $ModelBase */
        $ModelBase = Load::library('ModelBase');
        $serviceGroups = $ModelBase->select($sql);

        return $serviceGroups;
    }

    public function changeConfigurationStatus($configuration_id)
    {
        /** @var ModelBase $ModelBase */
        $ModelBase = Load::library('ModelBase');
        $config = $ModelBase->load("SELECT * FROM {$this->config_tbl} WHERE id='{$configuration_id}'");
        if ($config) {
            $ModelBase->setTable($this->config_tbl);
            $status = (bool)!$config['is_active'];

            $ModelBase->update(['is_active' => (int)$status], "id='{$configuration_id}'");

            return true;
        }

        return false;
    }

    public function changeConfigurationEdit($configuration_id)
    {
        /** @var ModelBase $ModelBase */
        $ModelBase = Load::library('ModelBase');
        $config = $ModelBase->load("SELECT * FROM {$this->config_tbl} WHERE id='{$configuration_id}'");
        if ($config) {
            $ModelBase->setTable($this->config_tbl);
            $status = (bool)!$config['client_can_edit'];

            $ModelBase->update(['client_can_edit' => (int)$status], "id='{$configuration_id}'");

            return true;
        }

        return false;
    }

    public function setClientConfigStatus($configuration_id, $client_id, $action = 'insert')
    {
        if (!in_array($action, ['insert', 'delete'])) {
            return false;
        }
        /** @var ModelBase $ModelBase */
        $ModelBase = Load::library('ModelBase');
        $sql = "SELECT {$this->clients_tbl}.id AS clientId, {$this->clients_tbl}.AgencyName AS ClientName, {$this->config_tbl}.title, {$this->config_tbl}.id AS configurationId FROM {$this->clients_tbl}
	INNER JOIN {$this->config_rel_tbl} ON {$this->clients_tbl}.id = {$this->config_rel_tbl}.client_id
	INNER JOIN {$this->config_tbl} ON {$this->config_rel_tbl}.configuration_id = {$this->config_tbl}.id
	WHERE {$this->config_rel_tbl}.configuration_id = '{$configuration_id}' AND {$this->config_rel_tbl}.client_id = '{$client_id}'
GROUP BY {$this->config_tbl}.id, {$this->clients_tbl}.AgencyName";
        $clientConfigurations = $ModelBase->load($sql);
        if ($action == 'insert') {
            if (!$clientConfigurations) {
                $ModelBase->setTable($this->config_rel_tbl);
                $insert = $ModelBase->insertLocal(['configuration_id' => $configuration_id, 'client_id' => $client_id]);
                if ($insert) {
                    return true;
                }

                return false;
            }

            return false;
        }
        $ModelBase->setTable($this->config_rel_tbl);
        $delete = $ModelBase->delete("client_id='{$client_id}' AND configuration_id='{$configuration_id}'");
        if ($delete) {
            return true;
        }

        return false;

    }

    public function addNewConfiguration($postData = [])
    {

        if (!$postData['title'] || !$postData['title_en'] || !$postData['service_group']) {
            return false;
        }

        $title_en = preg_replace("/[^a-z0-9]+/i", "_", trim($postData['title_en']));

        /** @var ModelBase $ModelBase */
        $ModelBase = Load::library('ModelBase');
        $insertData = [
            'service_group_id' => trim($postData['service_group']),
            'title' => trim($postData['title']),
            'title_en' => trim($title_en),
            'type' => $postData['type'] ? $postData['type'] : 'banner',
            'is_active' => (isset($postData['is_active']) ? $postData['is_active'] : 0)
        ];

        $ModelBase->setTable($this->config_tbl);
        $insert = $ModelBase->insertLocal($insertData);

        return $insert;
    }

    public function editConfiguration($postData = [])
    {

        if (!$postData['id'] || !$postData['title'] || !$postData['title_en'] || !$postData['service_group'] || !$postData['type']) {
            return false;
        }
        /** @var ModelBase $ModelBase */
        $ModelBase = Load::library('ModelBase');
        $config = self::getConfigurationById($postData['id']);
        if (!$config) {
            return false;
        }
        $updateData = [
            'service_group_id' => $postData['service_group'],
            'title' => $postData['title'],
            'title_en' => $postData['title_en'],
            'type' => $postData['type'],
            'is_active' => (isset($postData['is_active']) ? $postData['is_active'] : $config['is_active'])
        ];

        $ModelBase->setTable($this->config_tbl);
        $update = $ModelBase->update($updateData, "id='{$config['id']}'");

        return $update;
    }

    public function checkClientConfigurationAccess($configuration_id, $client_id)
    {
        $result = $this->getModel('clientConfigRelationModel')
       ->get()
       ->where('configuration_id', $configuration_id)
       ->where('client_id', $client_id)
        ->find();

        if ($result) {
            return true;
        }

        return false;
    }

    public function checkClientConfigurationByTitle($configuration_title, $client_id)
    {
        $config = self::getConfigurationByTitle($configuration_title);


        if (!$config) {
            return false;
        }

        return self::checkClientConfigurationAccess($config['id'], $client_id);
    }

    /*Client side*/
    public function getAllClientContents($client_id = null, $conditions = [], $fields = [])
    {
        $client_id = ($client_id) ? $client_id : CLIENT_ID;
        /** @var admin $admin */
        $admin = Load::controller('admin');
        $where = "";
        $cond = [];
        $keys = [];
        $selected = "*";
        if (!empty($fields) && is_array($fields)) {
            foreach ($fields as $field) {
                $keys[] = $field;
            }
            $selected = implode(",", $keys);
        }
        if (!empty($conditions)) {
            foreach ($conditions as $key => $value) {
                $cond[] = "{$key}={$value}";
            }

            $where = "WHERE ";
            $where .= implode(" AND ", $cond);
        }
        $sql = "SELECT {$selected} FROM configuration_content_tb {$where}";

        $contents = $admin->ConectDbClient($sql, $client_id, 'SelectAll');
        $result = [];
        foreach ($contents as $content) {
            $content['content'] = base64_decode($content['content']);
            $result[] = $content;
        }

        return $contents;
    }

    public function getClientContent($content_id, $client_id = null)
    {
        $client_id = isset($client_id) ? $client_id : CLIENT_ID;
        $sql = "SELECT * FROM configuration_content_tb WHERE id='{$content_id}'";

        /** @var admin $admin */
        $admin = Load::controller('admin');
        $content = $admin->ConectDbClient($sql, $client_id, 'Select');
        $content['content'] = base64_decode($content['content']);

        return $content;
    }

    public function addNewClientContent($data = [], $client_id = null)
    {

        $client_id = ($client_id) ? $client_id : CLIENT_ID;

        if (!$data['configuration_id']) {
            return false;
        }
        $is_active = (int)$data['is_active'];
        $content = base64_encode($data['content']);

        $configuration = self::getConfigurationById($data['configuration_id']);
        /** @var application $config */
        $config = Load::Config('application');
        $path = "advertise/{$client_id}/{$configuration['title_en']}/";
        $config->pathFile($path);
        $success = $config->UploadFile("pic", "feature_image", "");
        $explode_name_pic = explode(':', $success);
        if ($explode_name_pic[0] == 'done') {
            $feature_image = $path . $explode_name_pic[1];
        } else {
            $feature_image = '';
        }

        /** @var admin $admin */
        $admin = Load::controller('admin');

        $dataInsert = [
            'content' => $content,
            'image' => $feature_image,
            'content_type' => $data['content_type'],
            'title' => $data['title'],
            'is_active' => $is_active,
            'configuration_id' => $data['configuration_id'],
            'created_at' => date('Y-m-d H:i:s'),
        ];


        $insert = $admin->ConectDbClient('', $client_id, 'Insert', $dataInsert, 'configuration_content_tb');
        if ($insert) {
            return true;
        }

        return false;
    }

    public function editClientContent($content_id, $data = [], $client_id = null)
    {
        $client_id = ($client_id) ? $client_id : CLIENT_ID;
        /** @var admin $admin */
        $admin = Load::controller('admin');

        if (!$data['configuration_id']) {
            return false;
        }
        $is_active = (int)$data['is_active'];
        $content = base64_encode($data['content']);

        $configuration = self::getConfigurationById($data['configuration_id']);

        $dataUpdate = [
            'title' => $data['title'],
            'content' => $content,
            //			'image'            => $feature_image,
            'content_type' => $data['content_type'],
            'is_active' => $is_active,
            'configuration_id' => $data['configuration_id'],
            'created_at' => date('Y-m-d H:i:s'),
        ];
        /** @var application $config */
        $config = Load::Config('application');
        $path = "advertise/{$client_id}/{$configuration['title_en']}/";
        $config->pathFile($path);
        $success = $config->UploadFile("pic", "feature_image", "");
        $explode_name_pic = explode(':', $success);
        if ($explode_name_pic[0] == 'done') {
            $feature_image = $path . $explode_name_pic[1];
            $dataUpdate['image'] = $feature_image;
        }


        $update = $admin->ConectDbClient('', $client_id, 'Update', $dataUpdate, 'configuration_content_tb', "id='{$content_id}'");
        if ($update) {
            return true;
        }

        return false;
    }

    public function deleteClientContent($id, $client_id = null)
    {
        $client_id = ($client_id) ? $client_id : CLIENT_ID;
        /** @var admin $admin */
        $admin = Load::controller('admin');
        $delete = $admin->ConectDbClient('', $client_id, 'Delete', null, 'configuration_content_tb', "id='{$id}'");

        return $delete;
    }

    public function getAdvertisesIds()
    {
        $sql = "SELECT id FROM `{$this->config_tbl}` WHERE `title_en` LIKE '%_advertise' ORDER BY id ASC";
        /** @var ModelBase $ModelBase */
        $ModelBase = Load::library('ModelBase');
        $result = $ModelBase->select($sql);
        $ids = functions::array_column($result, 'id');
        return $ids;
    }

    public function insertAdvertiseAccess($client_id)
    {

        //			switch ( $service ) {
        //				case 'Flight':
        //					array_push( $inputs, 2, 3 );
        //					break;
        //				case 'Hotel':
        //					array_push( $inputs, 4, 5 );
        //					break;
        //				case 'Insurance':
        //					array_push( $inputs, 10 );
        //					break;
        //				case 'Europcar' :
        //					array_push( $inputs, 11 );
        //					break;
        //				case 'GashtTransfer':
        //					array_push( $inputs, 12 );
        //					break;
        //				case 'Tour':
        //					array_push( $inputs, 6, 9 );
        //					break;
        //				case 'Visa':
        //					array_push( $inputs, 8 );
        //					break;
        //				case 'Bus':
        //					array_push( $inputs, 7 );
        //					break;
        //				case 'Train':
        //					array_push( $inputs, 1 );
        //					break;
        //				case 'Entertainment':
        //					array_push( $inputs, 13 );
        //					break;
        //				default:
        //					break;
        //			}

        //$all_services = functions::listServiceClient();
        /*$inputs = self::getAdvertisesIds();// we can get ids by this query but for now its in a range and we don't need to fetch these from db*/
        /*
         * todo: Note : from 1 to 13 are the ids of advertisement configuration
         * */
        $inputs = range(1, 13);
        /** @var ModelBase $ModelBase */
        $ModelBase = Load::library('ModelBase');
        $inserted = $ModelBase->select("SELECT configuration_id FROM {$this->config_rel_tbl} WHERE client_id='{$client_id}'");
        $inserted_rows = functions::array_column($inserted, 'configuration_id');
        $_data = array_values(array_diff($inputs, $inserted_rows));
        $result = false;
        foreach ($_data as $input) {
            $ModelBase->setTable('client_config_relation_tb');
            $insert_data = ['client_id' => $client_id, 'configuration_id' => $input];

            $result = $ModelBase->insertLocal($insert_data);
        }

        return $result;

    }

    public function updateStatusConfigurations($data_update) {
          $check_exist_configurations = $this->getModel('contentConfigurationModel')->get()->where('id', $data_update['id'])->find();
        if ($check_exist_configurations) {
            $data_update_status['is_active'] = ($check_exist_configurations['is_active'] == 1) ? 0 : 1;
            $condition_update_status ="id='{$check_exist_configurations['id']}'";
            $result_update = $this->getModel('contentConfigurationModel')->updateWithBind($data_update_status,$condition_update_status);

            if ($result_update) {
                return functions::withSuccess('', 200, 'ویرایش وضعیت با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در ویرایش وضعیت');
        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');

    }
}