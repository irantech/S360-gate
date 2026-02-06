<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 2024/01/01
 * Time: 12:00 PM
 */

class reservationContinentConfigModel extends Model{

    protected $table = 'reservation_continent_config_tb' ;

    public function __construct() {
        parent::__construct();
        $this->table = 'reservation_continent_config_tb';
        $this->pk = 'id';
    }
    
    /**
     * Get sort order for a continent
     * @param int $continent_id
     * @return array|bool
     */
    public function getSortOrder($continent_id) {
        return $this->get()->where('continent_id', $continent_id)->where('is_del', 'no')->find();
    }
    
    /**
     * Set sort order for a continent
     * @param int $continent_id
     * @param int $sort_order
     * @return bool
     */
    public function setSortOrder($continent_id, $sort_order) {
        $existing = $this->getSortOrder($continent_id);
        
        if ($existing) {
            // Update existing record
            return $this->update(['sort_order' => $sort_order], 'continent_id = ' . $continent_id . ' AND is_del = "no"');
        } else {
            // Insert new record
            $data = [
                'continent_id' => $continent_id,
                'sort_order' => $sort_order,
                'is_del' => 'no'
            ];
            return $this->insertLocal($data);
        }
    }
    
    /**
     * Toggle sort order for a continent
     * @param int $continent_id
     * @param int $sort_order (optional)
     * @return bool
     */
    public function toggleSortOrder($continent_id, $sort_order = null) {
        $current = $this->getSortOrder($continent_id);
        
        if ($sort_order !== null) {
            $newSortOrder = $sort_order;
        } else {
            if ($current) {
                $newSortOrder = ($current['sort_order'] > 0) ? 0 : 1;
            } else {
                $newSortOrder = 1;
            }
        }
        
        return $this->setSortOrder($continent_id, $newSortOrder);
    }
} 