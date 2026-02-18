<?php
ini_set('memory_limit', '-1');
/*
 *
 * @property ruleModel $ruleModel
 * @property ruleCategoryModel $ruleCategoryModel
 *
 * */

/**
 * Class Model
 *
 * @property string $table
 * @property integer $pk
 * @property string $logName
 */

class Model {
	
	private $_pdo;
	private $_query = '';
	private $query = '';
	protected $table = '';
	protected $pk = 'id';
	protected $logName = 'log_update_';
    private $userIdSession = "";
    private $currentPageSession = "";
	/**
	 * Model constructor.
	 */
	function __construct()
    {
        //id page in panel counter for pages_permissions_tb
        if (defined('currentPagePanelCounter')) {
            $this->currentPageSession = (int) currentPagePanelCounter;
            //functions::insertLog("address=> {$this->currentPageSession}==> ".date("Y-m-d H:i:s")."\n",'log_address_now');
        } else {
            $this->currentPageSession = 'NoPageCounter';
        }

        if (isset($_SESSION['memberIdCounterInAdmin'])) {
            $this->userIdSession = (int)$_SESSION['memberIdCounterInAdmin'];
        }
        else {
            $this->userIdSession = 'NoCounter';
       }


        if ( $this->table == '' ) {
			$this->table = get_class( $this );
		}
		// Create a database connection only if one doesn?t already exist
		if ( ! isset( $this->_pdo ) ) {
			// Execute code catching potential exceptions
			try {
				// Create a new PDO class instance
				$this->_pdo = new PDO( PDO_DSN, DB_USERNAME, DB_PASSWORD, array(
					PDO::ATTR_PERSISTENT         => DB_PERSISTENCY,
					PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
				) );
                $this->_pdo->exec("set session sql_mode = ''");
				// Configure PDO to throw exceptions
				$this->_pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				$this->_pdo->setAttribute( PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false );
			} catch ( PDOException $e ) {
				// Close the database handler and trigger an error
				$this->Close();
				trigger_error( $e->getMessage(), E_USER_ERROR );
			}
		}
		//   $this->_pdo= new PDO(DB_TYPE . ':host='.DB_HOST.';dbname=' . DB_NAME, DB_USER, DB_PASS);
		$this->_pdo->exec( 'set names utf8' );
		$this->logName = $this->logName . $this->table;
	}
	
	/**
	 *
	 */
	public function conect() {
		if ( ! isset( $this->_pdo ) ) {
			// Execute code catching potential exceptions
			try {
				// Create a new PDO class instance
				$this->_pdo = new PDO( PDO_DSN, DB_USERNAME, DB_PASSWORD, array(
					PDO::ATTR_PERSISTENT         => DB_PERSISTENCY,
					PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
				) );
				
				// Configure PDO to throw exceptions
				$this->_pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			} catch ( PDOException $e ) {
				// Close the database handler and trigger an error
				$this->Close();
				trigger_error( $e->getMessage(), E_USER_ERROR );
			}
		}
	}



    /**
     * @return string
     */
    public function getTable() {
        return $this->table;
    }


	// Clear the PDO class instance
	
	/**
	 *
	 */
	public function Close() {
		$this->_pdo = null;
	}
	
	/**
	 * @param string $sql
	 * @param string $fetchType
	 *
	 * @return array
	 */
	public function     select( $sql = '', $fetchType = '' ) {
		
		if ( $fetchType != '' && $fetchType == 'num' ) {
			$fetchType = PDO::FETCH_NUM;
		} elseif ( $fetchType != '' && $fetchType == 'col' ) {
			$fetchType = PDO::FETCH_COLUMN;
		} else {
			$fetchType = PDO::FETCH_ASSOC;
		}
		
		$this->_query = $sql;
		//        	echo ($this->_query."<br>");
		$prepared = $this->_pdo->prepare( $this->_query );
		$prepared->execute();
		$data = $prepared->fetchAll( $fetchType );
		
		//        print_r($data);
		return $data;
	}
	
	/**
	 * @param string $sql
	 * @param string $fetchType
	 *
	 * @return mixed
	 */
	public function load( $sql = '', $fetchType = '' ) {
        $this->_query = $sql;
        $prepared = $this->_pdo->prepare($this->_query);
        $prepared->execute();
        return $prepared->fetch(PDO::FETCH_ASSOC);
	}
    public function loadAll($sql)
    {
        $this->_query = $sql;

        $prepared = $this->_pdo->prepare($this->_query);
        $prepared->execute();

        return $prepared->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
	 * @param array $data
	 *
	 * @return bool
	 */
	public function insert( $data = [] ) {
        // --- کنترل پرمیشن قبل از ساخت کوئری ---
        if (!$this->checkPermissionModel('insert')) {
            functions::insertLog("Permission denied for insert by user {$this->userIdSession}==> ".date("Y-m-d H:i:s")."\n",'log_permission');
            return false;
        }

		$cols = array_keys( $data );
		$vals = array_values( $data );
		$imp1 = implode( ",", $cols );
		$imp2 = implode( ",", $vals );
		
		if ( $this->existField( 'register_date' ) ) {
			$imp1 .= ",register_date";
			
			$imp2 .= ",'" . Date( 'Y-m-d H:i:s' ) . "'";
		}

		$this->_query = "INSERT INTO " . $this->table . " ( " . $imp1 . " ) VALUES ( " . $imp2 . " ) ";
		try {

			$return = $this->_pdo->exec( $this->_query );
			error_log( 'try in insert ' . DB_DATABASE . ' model: ' . date( 'Y/m/d H:i:s' ) . ' query: ' . $this->_query . " \n", 3, LOGS_DIR . $this->logName . '.txt' );
			
			return (boolean) $return;
		} catch ( PDOException $e ) {

			// Close the database handler and trigger an error
			$this->Close();
			trigger_error( $e->getMessage(), E_USER_ERROR );
		}
		return false;
	}
	
	/**
	 * @param string $sql
	 * @param array $params
	 *
	 * @return mixed
	 */
	public function runSP( $sql = '', $params = [] ) {

		$this->_query = $sql;
		$prepared     = $this->_pdo->prepare( $this->_query );
		foreach ( $params as $key => $val ) {
			$prepared->bindValue( $key, $val, PDO::PARAM_STR );
		}
		$prepared->execute();
		$data = $prepared->fetch( PDO::FETCH_ASSOC );

		return $data;
	}
	
	/**
	 * @param $data
	 *
	 * @return bool
	 */
	public function insertLocal( $data ) {
        // --- کنترل پرمیشن قبل از ساخت کوئری ---
        if (!$this->checkPermissionModel('insert')) {
            functions::insertLog("Permission denied for insertLocal by user {$this->userIdSession}==> ".date("Y-m-d H:i:s")."\n",'log_permission');
            return false;
        }

		if ( $this->existField( 'register_date' ) ) {
			$data['register_date'] = Date( 'Y-m-d H:i:s' );
		}

		$this->_query = "INSERT INTO $this->table (" . implode( ',', array_keys( $data ) ) . ") VALUES ('" . implode( "', '", array_values( $data ) ) . "' )";
		error_log( 'try in insertLocal ' . DB_DATABASE . ' model: ' . date( 'Y/m/d H:i:s' ) . ' query: ' . $this->_query . " \n", 3, LOGS_DIR . $this->logName . '.txt' );
		try {
			$return = $this->_pdo->exec( $this->_query );


			if ( $return == 1 ) {
				return true;
			} else {
				return false;
			}
		} catch ( PDOException $e ) {

			// Close the database handler and trigger an error
			$this->Close();
         
			trigger_error( $e->getMessage(), E_USER_ERROR );
		}
	}
	
	/**
	 * @param      $table
	 * @param bool $return
	 *
	 * @return $this|null
	 */
	public function setTable( $table, $return = false ) {
		$this->table   = $table;
		$this->logName = 'log_update_' . $table;
		if ( $return ) {
			return $this;
		}
		
		return null;
	}
	
	/**
	 * @param $data
	 * @param $condition
	 *
	 * @return bool
	 */
	public function update( $data, $condition ) {
        // --- کنترل پرمیشن قبل از ساخت کوئری ---
        if (!$this->checkPermissionModel('update')) {
            functions::insertLog("Permission denied for update by user {$this->userIdSession}==> ".date("Y-m-d H:i:s")."\n",'log_permission');
            return false;
        }

        $this->conect(); // if cinection has gone away connect again
		$s = "";
		foreach ( $data as $col => $val ) {
			if ( $s != "" ) {
				$s .= ",";
			}
			$s .= ( "`" . $col . "`" . " = '" . $val . "'" );
		}
		$this->_query = 'UPDATE ' . $this->table . ' SET ' . $s . ( $condition != '' ? ' WHERE ' . $condition : '' );
		error_log( 'try in update ' . DB_DATABASE . ' model: ' . date( 'Y/m/d H:i:s' ) . ' query: ' . $this->_query . " \n", 3, LOGS_DIR . $this->logName . '.txt' );
		$sql = $this->_pdo->prepare( $this->_query );
		try {
			$return = false;
			if ( $sql ) {
				$return = $sql->execute();
			}
			return $return;
			
		} catch ( PDOException $e ) { //echo $e.'<br>++';
			// Close the database handler and trigger an error

			$this->Close();
			trigger_error( $e->getMessage(), E_USER_ERROR );
		}
	}
	
	/**
	 * @param string $query
	 *
	 * @return bool
	 */
	public function updateByQuery( $query = '' ) {
        // --- کنترل پرمیشن قبل از ساخت کوئری ---
        if (!$this->checkPermissionModel('update')) {
            functions::insertLog("Permission denied for updateByQuery by user {$this->userIdSession}==> ".date("Y-m-d H:i:s")."\n",'log_permission');
            return false;
        }

        $this->conect(); // if cinection has gone away connect again
		$this->_query = $query;
		error_log( 'try in update ' . DB_DATABASE . ' model: ' . date( 'Y/m/d H:i:s' ) . ' query: ' . $this->_query . " \n", 3, LOGS_DIR . 'updateByQuery.txt' );
		
		$sql = $this->_pdo->prepare( $this->_query );
		try {
			if ( $sql ) {
				$return = $sql->execute();
			}
			if ( $return ) {
				return true;
			} else {
				return false;
			}
			
		} catch ( PDOException $e ) {
			// Close the database handler and trigger an error
			$this->Close();
			trigger_error( $e->getMessage(), E_USER_ERROR );
		}
	}
	
	/**
	 * @param string $condition
	 *
	 * @return bool
	 */
	public function delete( $condition = '' ) {
        // --- کنترل پرمیشن قبل از ساخت کوئری ---
        if (!$this->checkPermissionModel('delete')) {
            functions::insertLog("Permission denied for delete by user {$this->userIdSession}==> ".date("Y-m-d H:i:s")."\n",'log_permission');
            return false;
        }

        $conditions = $condition;
        $cond       = array();
        if ( is_array( $condition ) ) {
            foreach ( $condition as $field => $val ) {
                $cond[] = " {$field}='{$val}' ";
            }
            $conditions = implode( ' AND ', $cond );
        }
		$this->_query = "DELETE FROM " . $this->table . " WHERE " . $conditions;
		error_log( 'try in delete ' . DB_DATABASE . ' model: ' . date( 'Y/m/d H:i:s' ) . ' query: ' . $this->_query . " \n", 3, LOGS_DIR . $this->logName . '.txt' );
		
		$delete = $this->_pdo->exec( $this->_query );
		if ( $delete ) {
			
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * @return string
	 */
	public function last_query() {
		return $this->_query;
	}
	
	/**
	 * @return string
	 */
	public function getLastId() {
		return $this->_pdo->lastInsertId();
	}
	
	/**
	 * @param $field
	 *
	 * @return bool
	 */
	public function existField( $field ) {
		//$this->_query="SELECT ".$field." FROM ". $this->table;
		$this->_query = "SHOW COLUMNS FROM `{$this->table}` WHERE FIELD='{$field}'";
		$prepared     = $this->_pdo->prepare( $this->_query );
		$prepared->execute();
		$data = $prepared->fetch( PDO::FETCH_ASSOC );
		
		
		//   print_r($data);
		if ( $data ) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * @param $item
	 *
	 * @return mixed
	 */
	private static function convertPersianWord( $item ) {
		return str_replace( array( 'ي', 'ك' ), array( 'ی', 'ک' ), $item );
	}
	
	/**
	 * @param $arrayParams
	 *
	 * @return mixed
	 */
	private static function convertPersianWords( $arrayParams ) {
		foreach ( $arrayParams as $key => $value ) {
			$arrayParams[ $key ] = self::convertPersianWord( $value );
		}
		
		return $arrayParams;
	}
	
	/**
	 * @param $query
	 *
	 * @return bool
	 */
	public function execQuery( $query ) {
        // تشخیص نوع دستور
        $action = null;
        if (stripos($query, 'insert') === 0) {
            $action = 'insert';
        } elseif (stripos($query, 'update') === 0) {
            $action = 'update';
        } elseif (stripos($query, 'delete') === 0) {
            $action = 'delete';
        } elseif (stripos($query, 'select') === 0) {
            $action = 'select';
        } else {
            $action = 'other';
        }

        // چک پرمیشن فقط روی insert/update/delete
        if (!$this->checkPermissionModel($action)) {
            functions::insertLog("Permission denied for (function execQuery({$action}))  by user {$this->userIdSession}==> ".date("Y-m-d H:i:s")."\n",'log_permission');
            return false;
        }

		try {
			error_log( 'try in insertLocal ' . DB_DATABASE . ' model: ' . date( 'Y/m/d H:i:s' ) . ' query: ' . $query . " \n", 3, LOGS_DIR . 'log_update_execQuery.txt' );
			$return = $this->_pdo->exec( $query );
			
			if ( $return ) {
				return true;
			} else {
				return false;
			}
		} catch ( PDOException $e ) {
			// Close the database handler and trigger an error
			$this->Close();
			trigger_error( $e->getMessage(), E_USER_ERROR );
		}
		
	}
	
	/**
	 * @param null $where
	 * @param null $table
	 *
	 * @return bool|int
	 */
	public function softDelete( $where = null, $table = null ) {
		if ( ! $where ) {
			return false;
		}
		
		if ( ! self::existField( 'deleted_at' ) ) {
			return false;
		}
		
		return self::updateWithBind( array( 'deleted_at' => date( 'Y-m-d H:i:s' ) ), $where, $table );
	}
	
	/**
	 * @param array $data
	 * @param string $table
	 *
	 * @return bool|string
	 */
	public function insertWithBind( $data = array(), $table = '' ) {
       // --- کنترل پرمیشن قبل از ساخت کوئری ---
        if (!$this->checkPermissionModel('insert')) {
            functions::insertLog("Permission denied for insertWithBind by user {$this->userIdSession} ==> ".date("Y-m-d H:i:s")."\n",'log_permission');
            return false;
        }

		if ( $table ) {
			$this->setTable( $table );
		}
		if ( $this->existField( 'created_at' ) ) {
			$data['created_at'] = date( 'Y-m-d H:i:s' );
		}
		if ( $this->existField( 'updated_at' ) ) {
			$data['updated_at'] = date( 'Y-m-d H:i:s' );
		}

		$sqlFields = implode( ', ', array_map( function ( $v, $k ) { return sprintf( "%s = :%s", $k, $k ); }, $data, array_keys( $data ) ) );
		$sql = "INSERT INTO {$this->table} SET $sqlFields";
		try {
			$fields = array();
			$prepare = $this->_pdo->prepare( $sql );
			foreach ( $data as $field => $value ) {
				$prepare->bindValue( ":$field", $value );
				$fields[ $field ] = $value;
			}

            functions::insertLog(json_encode($sql,256),$this->logName);
            functions::insertLog(json_encode($fields,256),$this->logName);
            functions::insertLog('----------------------------------------',$this->logName);
			$res = $prepare->execute();
			return ( $res == 1 ) ? $this->_pdo->lastInsertId() : false;
			
		} catch ( PDOException $e ) {
			return trigger_error( $e->getMessage(), E_USER_ERROR );
		}
		//		return false;
	}
	
	/**
	 * @param array $data
	 * @param null $condition
	 * @param null $table
	 *
	 * @return bool|int
	 */
	public function updateWithBind( $data = array(), $condition = null, $table = null ) {
        // --- کنترل پرمیشن قبل از ساخت کوئری ---
        if (!$this->checkPermissionModel('update')) {
            functions::insertLog("Permission denied for updateWithBind by user {$this->userIdSession}==> ".date("Y-m-d H:i:s")."\n",'log_permission');
            return false;
        }

		if ( $table ) {
			$this->setTable( $table );
		}
		$sqlFields  = implode( ', ', array_map( function ( $v, $k ) { return sprintf( "%s = :%s", $k, $k ); }, $data, array_keys( $data ) ) );
		$conditions = $condition;
		$cond       = array();
		if ( is_array( $condition ) ) {
			foreach ( $condition as $field => $val ) {
				$cond[] = " {$field}='{$val}' ";
			}
			$conditions = implode( ' AND ', $cond );
		}
		
		$where = ( $conditions ? ' WHERE ' . $conditions : '' );
		
		$sql = "UPDATE {$this->table} SET {$sqlFields} {$where}";

				error_log( 'try in update ' . DB_DATABASE . ' model: ' . date( 'Y/m/d H:i:s' ) . ' query: ' . $sql . " \n", 3, LOGS_DIR .'update_bind' );
		try {
			$fields = array();
			$prepare = $this->_pdo->prepare( $sql );

			foreach ( $data as $field => $value ) {
				$prepare->bindValue( ":$field", $value );
				$fields[ $field ] = $value;
			}
            functions::insertLog(json_encode($sql,256),$this->logName);
            functions::insertLog(json_encode($fields,256),$this->logName);
            functions::insertLog('----------------------------------------',$this->logName);
			$res = $prepare->execute();

			return ( $res  ) ? $prepare->rowCount() : false;
		} catch ( PDOException $e ) {
//            var_dump( $e->getMessage());
			return trigger_error( $e->getMessage(), E_USER_ERROR );
		}
		//		return false;
	}
	
	/*new methods to create chain functions */
	/**
	 * @param array|string $fields
	 *
	 * @return $this
	 */
    public function  get( $fields = array(),$raw = false ) {

        $fields      = is_array( $fields ) ? implode( ', ', $fields ) : $fields;
        $fields      = empty( $fields ) ? '*' : $fields;
        if($raw){
            $this->query = "SELECT {$fields} FROM {$this->table} ";
            return $this;
        }
        $this->query = "SELECT {$this->table}.{$fields} FROM {$this->table} ";
        return $this;
    }
	
	/**
	 * @return $this
	 */
	public function withoutTrashed() {
		if ( self::existField( 'deleted_at' ) ) {
			$this->where( 'deleted_at', null, ' IS ' );
		}
		
		return $this;
	}
	
	/**
	 * @param bool $without_trashed
	 *
	 * @return array
	 */
	public function all( $without_trashed = true ) {

		if ( $without_trashed ) {
			$query = $this->withoutTrashed();

			$prepared = $query->_pdo->prepare( $this->query );
			$prepared->execute();
			
			return $prepared->fetchAll( PDO::FETCH_ASSOC );
		}


		$prepared = $this->_pdo->prepare( $this->query );
		$prepared->execute();
		
		return $prepared->fetchAll( PDO::FETCH_ASSOC );
	}
	
	/**
	 * @param bool $without_trashed
	 *
	 * @return mixed
	 */
	public function find( $without_trashed = true ) {
		if ( $without_trashed ) {
			$query = $this->withoutTrashed();

			return $query->load( $this->query );
		}

		return $this->load( $this->query );
	}

    /**
     * @param bool $without_trashed
     *
     * @return int
     */
    public function count( $without_trashed = true ) {
        // Store the original query
        $originalQuery = $this->query;

        // Extract everything after FROM (including JOINs, WHERE, GROUP BY, etc.)
        // but exclude ORDER BY and LIMIT as they're not needed for counting
        if (preg_match('/FROM\s+(.+?)(?:\s+ORDER\s+BY\s+.+)?(?:\s+LIMIT\s+.+)?$/is', $this->query, $matches)) {
            $fromClause = $matches[1];
            $this->query = "SELECT COUNT(*) as total FROM " . $fromClause;
        } else {
            // Fallback: try to replace just the SELECT part more aggressively
            $this->query = preg_replace('/^SELECT\s+.+?\s+FROM/is', 'SELECT COUNT(*) as total FROM', $this->query);
        }

        // Remove ORDER BY clause if it exists (not needed for counting)
        $this->query = preg_replace('/\s+ORDER\s+BY\s+.+?(?=\s+LIMIT|\s+$)/is', '', $this->query);

        // Remove LIMIT clause if it exists (not needed for counting)
        $this->query = preg_replace('/\s+LIMIT\s+\d+(?:\s*,\s*\d+)?/is', '', $this->query);

        if ( $without_trashed ) {
            $query = $this->withoutTrashed();
            $result = $query->load( $this->query );
        } else {
            $result = $this->load( $this->query );
        }


        // Restore original query
        $this->query = $originalQuery;

        return isset($result['total']) ? (int)$result['total'] : 0;
    }
	
	/**
	 * @param string $field
	 * @param string $value
	 * @param string $operation
	 *
	 * @return $this
	 */
	public function where( $field = '', $value = '', $operation = '=' ) {
		if ( is_array( $field ) ) {
            foreach ( $field as $condition) {
                $operator=$operation;
                if(!empty($condition['operator'])){
                    $operator=$condition['operator'];
                }
                $this->where( $condition['index'], $condition['value'], $operator );
            }
        }
        else{
            $value = is_string( $value ) ? "'{$value}'" : $value;
            $value = is_null( $value ) ? " NULL " : $value;

            $condition = "{$field} {$operation} {$value}";
			if(in_array($operation,array('IN','NOT IN'))){
				$condition = "{$field} {$operation} ({$value})";
			}
            if(strpos($this->query,'( AND') !== false){
                $this->query = str_replace('( AND','(',$this->query) ;
            }
            if ( strpos( $this->query, 'WHERE' ) !== false ) {
                $this->query .= " AND {$condition} ";

                return $this;
            }
            $this->query .= " WHERE {$condition} ";
        }

		return $this;
	}
    public function whereRaw($rawSql)
    {
        if (!empty($this->query) && strpos($this->query, 'WHERE') !== false) {
            $this->query .= " AND ($rawSql)";
        } else {
            $this->query .= " WHERE ($rawSql)";
        }
        return $this;
    }
    public function whereIn($field = '', $value = [])
    {
        if(is_array($value) || is_object($value)){
            $value = implode("','",$value);
            return $this->where($field,$value,'IN');
        }
        return $this->where($field,$value,'IN');
    }

    public function whereNotIn($field = '', $value = [])
    {
        if(is_array($value) || is_object($value)){
            $value = implode("','",$value);
            return $this->where($field,$value,'NOT IN');
        }
        return $this->where($field,$value,'NOT IN');
    }
    /**
	 * @param string $field
	 * @param string $value
	 * @param string $operation
	 *
	 * @return $this
	 */
	public function orWhere( $field = '', $value = '', $operation = '=' ) {
		if ( is_array( $field ) ) {
			foreach ( $field as $key => $val ) {
				$this->orWhere( $key, $val, $operation );
			}
		}
		$value = is_string( $value ) ? "'{$value}'" : $value;
		$value = is_null( $value ) ? " NULL " : $value;
		
		$condition = "{$field} {$operation} {$value}";
        if(strpos($this->query,'( AND') !== false){
            $this->query = str_replace('( AND','(',$this->query) ;
        }
		if ( strpos( $this->query, 'WHERE' ) !== false ) {
			$this->query .= " OR {$condition} ";
			
			return $this;
		}
		$this->query .= " OR WHERE {$condition} ";
		
		return $this;
	}


    /**
     * @param string $field

     *
     * @return $this
     */
    public function orWhereNull( $field = '') {
        if ( is_array( $field ) ) {
            foreach ( $field as $key => $val ) {
                $this->orWhereNull( $key );
            }
        }
        $condition = "{$field} is null";
        if(strpos($this->query,'( AND') !== false){
            $this->query = str_replace('( AND','(',$this->query) ;
        }
        if ( strpos( $this->query, 'WHERE' ) !== false ) {
            $this->query .= " OR {$condition} ";

            return $this;
        }
        $this->query .= " OR WHERE {$condition} ";

        return $this;
    }
    public function WhereNotNull( $field = '') {


        $condition = "{$field} is not null";
        if(strpos($this->query,'( AND') !== false){
            $this->query = str_replace('( AND','(',$this->query) ;
        }
        if ( strpos( $this->query, 'WHERE' ) !== false ) {
            $this->query .= "AND {$condition} ";

            return $this;
        }
        $this->query .= " WHERE {$condition} ";

        return $this;
    }

    /**
     * @param string $field
     * @param string $order
     * @param null $table_name
     * @param string $other_order
     * @return $this
     */
    public function orderBy($field = 'id', $order = 'DESC' , $table_name = null, $other_order=',') {

        $is_other_order = $other_order !=null ? ',' : '';
        $field = !empty($table_name) ? "{$table_name}.{$field}" : $field;

        if ( strpos( $this->query, 'ORDER BY' ) !== false ) {
            $field = !empty($table_name) ? "{$table_name}.{$field}" : $field;
            $this->query .= " $is_other_order {$field} {$order} " ;
            return $this;
        }
        $this->query .= " ORDER BY {$field} {$order} ";

        return $this;
    }

    /**
     * @param string $fields
     * @return $this
     * @throws Exception
     */
    public function groupBy($fields = 'id') {
        // Fix: proper strpos usage
        if (strpos($this->query, 'GROUP BY') !== false) {
            throw new Exception('GROUP BY already used in this query');
        }

        // Support array of fields or string
        if (is_array($fields)) {
            $fields = implode(', ', $fields);
        }

        $this->query .= " GROUP BY {$fields}";

        return $this;
    }
	
	/**
	 * @param int $start
	 * @param int $limit
	 *
	 * @return $this
	 * @throws \Exception
	 */
	public function limit( $start = 0, $limit = 20 ) {
		/*if ( strpos( $this->query, 'ORDER BY' !== false ) ) {
			throw new Exception( 'Wrong usage of function' );
		}*/
		$this->query .= " LIMIT {$start},{$limit}";

		return $this;
	}
	
	/**
	 * @param string $field
	 * @param string $string
	 * @param string $position
	 *
	 * @return $this
	 */
	public function like( $field = '', $string = '', $position = 'both' ) {
		$position    = strtolower( $position );
		$like_string = $string;
		if ( $position == 'left' ) {
			$like_string = "{$string}%";
		} elseif ( $position == 'right' ) {
			$like_string = "%{$string}";
		} elseif ( $position == 'both' ) {
			$like_string = "%{$string}%";
		}
		
		$query = " {$field} LIKE '{$like_string}'";
		
		if ( strpos( $this->query, 'LIKE' ) !== false ) {
			$this->query .= " OR {$query}";
			
		} else {
			$this->query .= $query;
		}
		
		return $this;
	}
	
	/**
	 * @param string $with
	 *
	 * @return $this
	 */
	public function openParentheses( $with = 'AND' ) {
		
		$this->query .= strtoupper( $with ) . ' (';
		
		return $this;
	}
	
	/**
	 * @return $this
	 */
	public function closeParentheses() {
		$this->query .= ')';
		
		return $this;
	}

    public function removeAsString($string)
    {
        return preg_replace('/(?=.*[as]) [^.\s]*/','',$string);
    }

    /**
     * @param $join_table
     * @param string $foreign_key
     * @param string $local_key
     * @param string $type
     * @param null $second_table
     * @return $this
     */
    public function joinSimple($join_table, $foreign_key = '', $local_key = 'id', $type = 'LEFT' , $second_table=[] ) {
        if(!empty($second_table))
        {
            $this->query .= "{$type} JOIN $second_table[0] AS $second_table[1] ON {$foreign_key} ={$local_key} ";
        }else{
            $this->query .= "{$type} JOIN $join_table[0] AS $join_table[1] ON {$foreign_key} ={$local_key} ";
        }

        return $this;
    }

    /**
     * @param $join_table
     * @param string $foreign_key
     * @param string $local_key
     * @param string $type
     * @param null $second_table
     * @return $this
     */
    public function joinAlias($join_table, $foreign_key = '', $local_key = 'id', $type = 'LEFT' , $second_table=[] ) {
        if(!empty($second_table))
        {
            $this->query .= "{$type} JOIN $second_table[0] AS $second_table[1] ON {$second_table[1]}.{$foreign_key} ={$join_table[1]}.{$local_key} ";
        }else{
            $this->query .= "{$type} JOIN $join_table[0] AS $join_table[1] ON {$join_table[1]}.{$foreign_key} ={$this->table}.{$local_key} ";
        }

        return $this;
    }
    /**
     * @param $join_table
     * @param string $foreign_key
     * @param string $local_key
     * @param string $type
     * @param null $second_table
     * @return $this
     */
    public function join($join_table, $foreign_key = '', $local_key = 'id', $type = 'LEFT' , $second_table=null ) {
        if(!empty($second_table))
        {
            $this->query .= "{$type} JOIN $second_table ON {$second_table}.{$foreign_key} ={$join_table}.{$local_key} ";
        }else{
            $this->query .= "{$type} JOIN $join_table ON {$join_table}.{$foreign_key} ={$this->table}.{$local_key} ";
        }

        return $this;
    }


    /**
     * @param string $query
     */
    public function setSql($query)
    {
        $this->query .= $query;

        return $this;
    }


    /**
	 * @return string
	 */
	public function toSql() {
		return (string) $this->sqlFormat($this->query);
	}

    /**
     * @param $query
     * @return array|mixed|string|string[]
     */
    public function sqlFormat($query) {
        $keywords = array("select", "from", "LIMIT", "INNER JOIN", "LEFT JOIN", "RIGHT JOIN", "AND", "where", "order by", "group by", "insert into", "update");
        foreach ($keywords as $keyword) {
            if (preg_match("/($keyword *)/i", $query, $matches)) {
                $query = str_replace($matches[1], "\n" . strtoupper($matches[1]) . "\n  ", $query);
            }
        }
        return $query;
    }

    /**
     * @return void
     */
    public function toSqlDie() {
        echo ($this->sqlFormat($this->query));
        die();
    }
    private function checkPermissionModel_old($action) {
        if ($this->userIdSession=='NoCounter') {
            return true;
        }
        try {
            $userId = (int)$this->userIdSession;
            // اتصال PDO
            $pdo = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD, [
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);

            // Query دستی
            $stmt = $pdo->prepare("SELECT can_insert, can_update, can_delete 
                               FROM user_permissions_tb 
                               WHERE 
                                   user_id = :uid AND 
                                   (role = 'counter' or role = 'manager')
                                LIMIT 1");
            $stmt->bindValue(':uid', $userId, PDO::PARAM_INT);
            $stmt->execute();

            $perms = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$perms) {
                // اگر رکوردی نبود، همه اجازه داده شود
                $perms = [
                    'can_insert' => 1,
                    'can_update' => 1,
                    'can_delete' => 1
                ];
                functions::insertLog("No record in DB → all allowed for user {$userId}==> ".date("Y-m-d H:i:s")."\n",'log_permission');
            }

        } catch (PDOException $e) {
            trigger_error($e->getMessage(), E_USER_ERROR);
            return false;
        }

        switch ($action) {
            case 'insert': return !empty($perms['can_insert']);
            case 'update': return !empty($perms['can_update']);
            case 'delete': return !empty($perms['can_delete']);
            default: return true;
        }
    }
    private function checkPermissionModel($action) {
        if ($this->userIdSession=='NoCounter') {
            return true;
        }
        try {
            $userId = (int)$this->userIdSession;
            $PageId = (int)$this->currentPageSession;
            // اتصال PDO
            $pdo = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD, [
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            // Query دستی
            $stmt = $pdo->prepare("SELECT can_insert,can_update,can_delete 
                               FROM pages_permissions_tb 
                               WHERE 
                                   id_member = :uid AND 
                                   id_page= :pid AND
                                   dell='0'
                                LIMIT 1");
            $stmt->bindValue(':uid', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':pid', $PageId, PDO::PARAM_INT);
            $stmt->execute();
            $perms = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$perms) {
                // اگر رکوردی نبود، همه اجازه داده شود
                $perms = [
                    'can_insert' => 1,
                    'can_update' => 1,
                    'can_delete' => 1
                ];
                functions::insertLog("No record in DB → all allowed for user:{$userId} id_page : {$PageId}==> ".date("Y-m-d H:i:s")."\n",'log_address_now');
            }

        } catch (PDOException $e) {
            trigger_error($e->getMessage(), E_USER_ERROR);
            return false;
        }

        switch ($action) {
            case 'insert': return !empty($perms['can_insert']);
            case 'update': return !empty($perms['can_update']);
            case 'delete': return !empty($perms['can_delete']);
            default: return true;
        }
    }
}