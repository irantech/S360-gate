<?php

class priority
{
    public $tableName;
    public $priorityField;
    public $clientID;
    public $controller;

    #region construct
    public function __construct()
    {

    }
    #endregion

    #region init
    public function init($table, $field, $clientID = null)
    {
        $this->tableName = $table;
        $this->priorityField = $field;
        $this->clientID = $clientID;

        if($this->clientID != null) {

            $this->controller = Load::controller('admin');

        } else{

            $this->controller = Load::library('Model');
            $this->controller->setTable($this->tableName);
        }
    }
    #endregion

    #region getPriority
    public function getPriority($colIndex, $colValue){

        $query = "SELECT {$this->priorityField} AS Priority FROM {$this->tableName} WHERE {$colIndex} = '{$colValue}'";

        if($this->clientID != null) {

            $result = $this->controller->ConectDbClient($query, $this->clientID, 'Select', '', '', '');

        } else{

            $result = $this->controller->load($query);
        }

        return $result['Priority'];
    }
    #endregion

    #region getMaxPriority
    public function getMaxPriority($conditions = ''){

        if($conditions != ''){
            $conditions = ' WHERE ' . $conditions;
        }

        $query = "SELECT MAX({$this->priorityField}) AS MaxPr FROM {$this->tableName} {$conditions}";

        if($this->clientID != null) {

            $result = $this->controller->ConectDbClient($query, $this->clientID, 'Select', '', '', '');

        } else{

            $result = $this->controller->load($query);
        }

        if($result['MaxPr'] > 0)
            return $result['MaxPr'];
        else
            return 0;
    }
    #endregion

    #region deletePriorityRecord
    public function deletePriorityRecord($thisP, $conditions = ''){

        $maxP = $this->getMaxPriority($conditions);

        if($conditions!=''){
            $conditions = ' AND ' . $conditions;
        }

        // update values from this priority to end
        for ($j = $thisP + 1; $j <= $maxP; $j++) {

            $changeVal = $j - 1;

            $data[$this->priorityField] = $changeVal;
            $updateCondition = " {$this->priorityField} = '{$j}' {$conditions} ";

            if($this->clientID != null) {

                $this->controller->ConectDbClient('', $this->clientID, 'Update', $data, $this->tableName, $updateCondition);

            } else{

                $this->controller->update($data, $updateCondition);
            }
        }
    }
    #endregion

    #region updatePriority
    public function updatePriority($colIndex, $colValue, $newP, $conditions = ''){

        $presentP = $this->getPriority($colIndex, $colValue);

        if($conditions!=''){
            $conditions = ' AND ' . $conditions;
        }

        //when present priority is 0 => just change it to new priority
        if ($presentP == 0) {

            $data[$this->priorityField] = $newP;
            $updateCondition = " {$colIndex} = '{$colValue}' ";

            if($this->clientID != null) {

                $this->controller->ConectDbClient('', $this->clientID, 'Update', $data, $this->tableName, $updateCondition);

            } else{

                $this->controller->update($data, $updateCondition);
            }
        }

        //when present priority is less than new priority
        elseif ($presentP < $newP) {
            for ($j = $presentP + 1; $j <= $newP; $j++)
            {
                $changeVal = $j - 1;

                $data[$this->priorityField] = $changeVal;
                $updateCondition = " {$this->priorityField} = '{$j}' {$conditions} ";

                if($this->clientID != null) {

                    $this->controller->ConectDbClient('', $this->clientID, 'Update', $data, $this->tableName, $updateCondition);

                } else{

                    $this->controller->update($data, $updateCondition);
                }
            }

            $data[$this->priorityField] = $newP;
            $updateCondition = " {$colIndex} = '{$colValue}' {$conditions} ";

            if($this->clientID != null) {

                $this->controller->ConectDbClient('', $this->clientID, 'Update', $data, $this->tableName, $updateCondition);

            } else{

                $this->controller->update($data, $updateCondition);
            }
        }

        //when present priority is more than new priority
        elseif ($presentP > $newP) {
            for ($j = $presentP - 1; $j >= $newP; $j--)
            {
                $changeVal = $j + 1;

                $data[$this->priorityField] = $changeVal;
                $updateCondition = " {$this->priorityField} = '{$j}' {$conditions} ";

                if($this->clientID != null) {

                    $this->controller->ConectDbClient('', $this->clientID, 'Update', $data, $this->tableName, $updateCondition);

                } else{

                    $this->controller->update($data, $updateCondition);
                }
            }

            $data[$this->priorityField] = $newP;
            $updateCondition = " {$colIndex} = '{$colValue}' {$conditions} ";

            if($this->clientID != null) {

                $this->controller->ConectDbClient('', $this->clientID, 'Update', $data, $this->tableName, $updateCondition);

            } else{

                $this->controller->update($data, $updateCondition);
            }
        }

    }
    #endregion
}

?>
