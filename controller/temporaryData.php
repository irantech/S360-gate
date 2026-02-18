<?php

/**
 * Class temporaryData
 * Controller for managing temporary data storage
 */
class temporaryData extends clientAuth
{
    
    public function __construct(){
        parent::__construct();
    }

    /**
     * Save temporary data for a reference
     */
    public function saveTemporaryData($referenceId, $referenceType, $data)
    {
        $temporaryData = array(
            'reference_id' => $referenceId,
            'reference_type' => $referenceType,
            'data' => json_encode($data),
            'created_at' => date('Y-m-d H:i:s')
        );
        
        return $this->getModel('temporaryDataModel')->insertWithBind($temporaryData);
    }

    /**
     * Get temporary data by reference
     */
    public function getByReference($referenceId, $referenceType)
    {
        return $this->getModel('temporaryDataModel')
            ->get()
            ->where('reference_id', $referenceId)
            ->where('reference_type', $referenceType)
            ->find();
    }
    /**
     * Get all temporary data by reference type
     */
    public function getAllByReference($referenceId, $referenceType)
    {
         $Result=$this->getModel('temporaryDataModel')
            ->get()
            ->where('reference_id', $referenceId)
            ->where('reference_type', $referenceType)
            ->all();
        return $Result[0];
    }
    
    /**
     * Update existing temporary data
     */
    public function updateTemporaryData($referenceId, $referenceType, $data)
    {
        $updateData = array(
            'data' => json_encode($data),
            'updated_at' => date('Y-m-d H:i:s')
        );
        
        return $this->getModel('temporaryDataModel')
            ->get()
            ->where('reference_id', $referenceId)
            ->where('reference_type', $referenceType)
            ->update($updateData);
    }
    
    /**
     * Delete temporary data by reference
     */
    public function deleteByReference($referenceId, $referenceType)
    {
        return $this->getModel('temporaryDataModel')
            ->get()
            ->where('reference_id', $referenceId)
            ->where('reference_type', $referenceType)
            ->delete();
    }

    /**
     * Save or update temporary data (upsert operation)
     */
    public function saveOrUpdateTemporaryData($referenceId, $referenceType, $data)
    {
        // Check if data already exists
        $existingData = $this->getByReference($referenceId, $referenceType);
        
        if ($existingData) {
            // Update existing record
            return $this->updateTemporaryData($referenceId, $referenceType, $data);
        } else {
            // Create new record
            return $this->saveTemporaryData($referenceId, $referenceType, $data);
        }
    }
} 