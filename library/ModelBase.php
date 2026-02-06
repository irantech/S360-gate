<?php
ini_set('memory_limit', '-1');
class ModelBase {

    private $_pdo;
    private $_query = '';
    private $query = '';
    protected $table = '';
    protected $pk = 'id';
    protected $logName = 'log_update_';

    public function __construct() {

        //   if($this->table == ''){$this->table = get_class($this);}
        // Create a database connection only if one doesn?t already exist
        if (!isset($this->_pdo)) {
            // Execute code catching potential exceptions
            try {

                // Create a new PDO class instance
                $this->_pdo = new PDO(PDO_DSN_BASE, DB_USERNAME_BASE, DB_PASSWORD_BASE, array(PDO::ATTR_PERSISTENT => DB_PERSISTENCY_BASE, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

                $this->_pdo->exec("set session sql_mode = ''");
                // Configure PDO to throw exceptions
                $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->_pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, FALSE);
            } catch (PDOException $e) {
                // Close the database handler and trigger an error
                $this->Close();
                trigger_error($e->getMessage(), E_USER_ERROR);
            }
        }

        //   $this->_pdo= new PDO(DB_TYPE . ':host='.DB_HOST.';dbname=' . DB_NAME, DB_USER, DB_PASS);        
        $this->_pdo->exec('set names utf8');
        $this->logName = $this->logName . $this->table;

    }
	
	/**
	 * @return string
	 */
	public function getTable() {
		return $this->table;
	}
	
    // Clear the PDO class instance
    public function Close() {
        $this->_pdo = null;
    }

    public function select($sql, $fetchType = '') {

        if ($fetchType != '' && $fetchType == 'num'){
            $fetchType = PDO::FETCH_NUM;
        } elseif ($fetchType != '' && $fetchType == 'col'){
            $fetchType = PDO::FETCH_COLUMN;
        } else{
            $fetchType = PDO::FETCH_ASSOC;
        }

        $this->_query = $sql;
//       	echo ($this->_query."<br>");
        $prepared = $this->_pdo->prepare($this->_query);
        $prepared->execute();
        $data = $prepared->fetchAll($fetchType);
        //	print_r($data);
        return $data;
    }

    public function load($sql) {
        $this->_query = $sql;
        $prepared = $this->_pdo->prepare($this->_query);
        $prepared->execute();
        return $prepared->fetch(PDO::FETCH_ASSOC);
    }


    public function insert($data) {
        $cols = array_keys($data);
        $vals = array_values($data);
        $imp1 = implode(",", $cols);
        $imp2 = implode(",", $vals);

        if ($this->existField('register_date')) {
            $imp1 .= ",register_date";
            $imp2 .= ",'" . Date('Y-m-d H:i:s') . "'";
        }

        $this->_query = "INSERT INTO " . $this->table . " ( " . $imp1 . " ) VALUES ( " . $imp2 . " ) ";
       // echo  $this->_query;
        try {
            $return = $this->_pdo->exec($this->_query);
            
            error_log('try in insert ' . DB_DATABASE . ' modelBase: '.date('Y/m/d H:i:s').' query: '.$this->_query." \n", 3, LOGS_DIR.$this->logName.'.txt');
            
            if ($return == 1)
                return true;
            return false;
        } catch (PDOException $e) {
            // Close the database handler and trigger an error
            $this->Close();
            trigger_error($e->getMessage(), E_USER_ERROR);
        }
    }

    public function insertLocal($data) {


        if ($this->existField('register_date')) {
            $data['register_date'] = Date('Y-m-d H:i:s');
        }

        $this->_query = "INSERT INTO $this->table (" . implode(',', array_keys($data)) . ") VALUES ('" . implode("', '", array_values($data)) . "' )";


        if($this->table =='clients_tb')
        {
            error_log('try in insertLocal ' . DB_DATABASE . ' modelBase: '.date('Y/m/d H:i:s').' query: '.$this->_query." \n", 3, LOGS_DIR.'ClientTable.txt');
        }

        
        try {
            $return = $this->_pdo->exec($this->_query);

            error_log('try in insertLocal ' . DB_DATABASE . ' modelBase: '.date('Y/m/d H:i:s').' query: '.$this->_query." \n", 3, LOGS_DIR.$this->logName.'.txt');

            if ($return == 1) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            // Close the database handler and trigger an error
            $this->Close();
            trigger_error($e->getMessage(), E_USER_ERROR);
        }
    }

    public function setTable($table, $return = false ) {
        $this->table   = $table;
        if ($table=='report_tb'){
            $this->logName = 'log_update_book_local_tb';
        }else {
            $this->logName = 'log_update_' . $table;
        }
        if ( $return ) {
            return $this;
        }

        return null;
    }

    public function update($data, $condition) {

        $s = "";
        foreach ($data as $col => $val) {
            if ($s != "")
                $s .= ",";
            $s .= ("`" . $col . "`" . " = '" . $val . "'");
        }
         $this->_query = " UPDATE " . $this->table . " SET " . $s . " WHERE " . $condition;

        error_log('try in update ' . DB_DATABASE . ' modelBase: '.date('Y/m/d H:i:s').' query: '.$this->_query." \n", 3, LOGS_DIR.$this->logName.'.txt');


        $sql = $this->_pdo->prepare($this->_query);
//        echo '<br>' . $this->_query . '<br>';
//        die();
//        	print_r($this->_pdo->errorInfo());
        if ($sql) {
            $return = $sql->execute();
        }

        if ($return == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function updateByQuery($query) {
        $this->conect(); // if cinection has gone away connect again
        $this->_query = $query;
        error_log('try in update ' . DB_DATABASE . ' model: '.date('Y/m/d H:i:s').' query: '.$this->_query." \n", 3, LOGS_DIR.'updateByQuery.txt');

        $sql = $this->_pdo->prepare($this->_query);
        try {
            if ($sql) {
                $return = $sql->execute();
            }
            if ($return) {
                return true;
            } else {
                return false;
            }

        } catch (PDOException $e) {
            // Close the database handler and trigger an error
            $this->Close();
            trigger_error($e->getMessage(), E_USER_ERROR);
        }
    }
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
    public function delete($condition) {
        $conditions = $condition;
        $cond       = array();
        if ( is_array( $condition ) ) {
            foreach ( $condition as $field => $val ) {
                $cond[] = " {$field}='{$val}' ";
            }
            $conditions = implode( ' AND ', $cond );
        }

        $this->_query = "DELETE FROM " . $this->table . " WHERE " . $conditions;
        error_log('try in delete ' . DB_DATABASE . ' model: '.date('Y/m/d H:i:s').' query: '.$this->_query." \n", 3, LOGS_DIR.$this->logName.'.txt');
        //	echo $this->_query;
        return $this->_pdo->exec($this->_query);
    }

    public function last_query() {
        return $this->_query;
    }

    public function getLastId() {
        return $this->_pdo->lastInsertId();
    }

    public function existField($field) {
        //$this->_query="SELECT ".$field." FROM ". $this->table;
        $this->_query = "SHOW COLUMNS FROM " . $this->table . " WHERE FIELD='" . $field . "'";
        $prepared = $this->_pdo->prepare($this->_query);
        $prepared->execute();
        $data = $prepared->fetch();
        //   print_r($data);
        if ($data) {
            return true;
        } else {
            return false;
        }
    }

    public function execQuery($query) {

        try {
            error_log('try in execQuery ' . DB_DATABASE . ' modelBase: '.date('Y/m/d H:i:s').' query: '.$query." \n", 3, LOGS_DIR.'log_update_execQuery.txt');
            $return = $this->_pdo->exec($query);

            if ($return == 1) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            // Close the database handler and trigger an error
            $this->Close();
            trigger_error($e->getMessage(), E_USER_ERROR);
        }

    }

    public function insertWithBind( $data = array(), $table = '') {
        if ( $table ) {
            $this->setTable( $table );
        }
        if($this->existField('created_at')){
            $data['created_at'] = date('Y-m-d H:i:s');
        }
        if( $this->existField('updated_at')){
            $data['updated_at'] = date('Y-m-d H:i:s');
        }
        $sqlFields = implode( ', ', array_map( function ( $v, $k ) { return sprintf( "%s = :%s", $k, $k ); }, $data, array_keys( $data ) ) );

        $sql = "INSERT INTO {$this->table} SET $sqlFields";
        try {
            $fields  = array();
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

    public function updateWithBind( $data = [], $condition = null,$table = null ) {

        if($table){
            $this->setTable($table);
        }
        $sqlFields = implode( ', ', array_map( function ( $v, $k ) { return sprintf( "%s = :%s", $k, $k ); }, $data, array_keys( $data ) ) );
        $conditions = $condition;
        $cond       = array();
        if ( is_array( $condition ) ) {
            foreach ( $condition as $field => $val ) {
                $cond[] = " {$field}='{$val}' ";
            }
            $conditions = implode( ' AND ', $cond );
        }

        $where     = ( $conditions ? ' WHERE ' . $conditions : '' );
        $sql       = "UPDATE {$this->table} SET {$sqlFields} {$where}";
        error_log($sql.PHP_EOL.json_encode($sqlFields,256|64),3,LOGS_DIR.'UUUUU');
        try {
            $fields  = array();
            $prepare = $this->_pdo->prepare( $sql );
            foreach ( $data as $field => $value ) {
                $prepare->bindValue( ":$field", $value );
                $fields[ $field ] = $value;
            }
            functions::insertLog(json_encode($sql,256),$this->logName);
            functions::insertLog(json_encode($fields,256),$this->logName);
            functions::insertLog('----------------------------------------',$this->logName);

            $res = $prepare->execute();

            return ( $res == 1 ) ? $prepare->rowCount() : false;
        } catch ( PDOException $e ) {

            return trigger_error( $e->getMessage(), E_USER_ERROR );
        }
        //		return false;
    }
	
	
	/*new methods to create chain functions */
	/**
	 * @param array $fields
	 *
	 * @return $this
	 */
	public function get( $fields = array(),$raw = false ) {
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
		if(self::existField('deleted_at')){
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
//
//				error_log( 'try in insert ' . DB_DATABASE . ' model: ' . date( 'Y/m/d H:i:s' ) . ' query: ' . $this->query . " \n", 3, LOGS_DIR . 'all.txt' );
			return $query->select( $this->query );
		}
		
		//		error_log( 'try in insert ' . DB_DATABASE . ' model: ' . date( 'Y/m/d H:i:s' ) . ' query: ' . $this->query . " \n", 3, LOGS_DIR . 'updateBind.txt' );
		return $this->select( $this->query );
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
		}else{
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
     * @param string $order
     * @param null $table_name
     * @param string $other_order
     * @return $this
     */
    public function orderBy($field = 'id', $order = 'DESC' , $table_name = null, $other_order=',') {
        if ( strpos( $this->query, 'ORDER BY' ) !== false ) {
            $field = !empty($table_name) ? "{$table_name}.{$field}" : $field;
            $this->query .= " $other_order {$field} {$order} " ;
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
		if(strpos( $this->query, 'WHERE' ) !== false){
			$query = " {$this->table}.{$field} LIKE '{$like_string}'";
		}else{
			$query = " WHERE {$this->table}.{$field} LIKE '{$like_string}'";
		}
		
		
		if ( strpos( $this->query, 'LIKE' ) !== false ) {
			$this->query .= " OR {$query}";
			
		}else{
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
            $this->query .= "{$type} JOIN $join_table ON  {$join_table}.{$foreign_key}={$second_table}.{$local_key} ";
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
		return (string) $this->query;
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
}