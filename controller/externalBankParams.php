<?php
/**
 * Created by PhpStorm.
 * User: Developer10
 * Date: 9/8/2021
 * Time: 1:55 PM
 */


class externalBankParams {
	protected $externalBankParamsTb, $banksTb, $transactionTb;
	
	public function __construct() {
		$this->externalBankParamsTb = 'external_bank_report_tb';
		$this->banksTb              = 'bank_tb';
		$this->transactionTb        = 'transaction_tb';
	}
	
	/**
	 * @param array $fields
	 * @param array $conditions
	 * @param string $table
	 * @param bool $single
	 *
	 * @return array|bool|mixed
	 */
	public function _selectFromTb( $fields = [], $conditions = [], $table = '', $single = false ) {
		if ( ! $table ) {
			return false;
		}
		$cond = '';
		$keys = ( $fields && is_array( $fields ) ) ? '`' . implode( '`,`', $fields ) . '`' : '*';
		if ( $conditions && is_array( $conditions ) ) {
			$where = [];
			foreach ( $conditions as $column => $value ) {
				$where[] = "{$column}='{$value}'";
			}
			if ( $where ) {
				$cond = implode( ' AND ', $where );
				$cond = " WHERE {$cond}";
			}
		}
		$sql = "SELECT {$keys} FROM {$table}{$cond}";
		/** @var Model $model */
		$model = Load::library( 'Model' );
		if ( TYPE_ADMIN ) {
			/** @var ModelBase $model */
			$model = Load::library( 'ModelBase' );
			
		}
		
		return ( $single ) ? $model->load( $sql, 'assoc' ) : $model->select( $sql, 'assoc' );
	}
	
	public function insertParams( $data = [] ) {
		/** @var Model $model */
		$model = Load::library( 'Model' );
		$model->setTable( $this->externalBankParamsTb );
		
		return $model->insertWithBind( $data );
	}
	
	/**
	 * @param array $data
	 * @param array $conditions
	 *
	 * @return bool
	 */
	public function updateParams( $data = [], $conditions = [] ) {
		if ( ! $conditions || ! is_array( $conditions ) ) {
			return false;
		}
		/** @var Model $model */
		$model = Load::library( 'Model' );
		$model->setTable( $this->externalBankParamsTb );
		$where = [];
		foreach ( $conditions as $key => $value ) {
			$where[] = "{$key}='{$value}'";
		}
		$where = implode( ' AND ', $where );
		
		return $model->update( $data, $where );
	}
	
	/**
	 * @param array $conditions
	 * @param array $fields
	 * @param bool $single
	 *
	 * @return array|mixed
	 */
	public function getParams( $conditions = [], $fields = [], $single = false ) {
		return $this->_selectFromTb( $fields, $conditions, $this->externalBankParamsTb, $single );
	}
	
	/**
	 * @param array $conditions
	 * @param array $fields
	 *
	 * @return array
	 */
	public function getBanks( $conditions = [], $fields = [], $single = false ) {
		return $this->_selectFromTb( $fields, $conditions, $this->banksTb, $single );
	}
	
	/**
	 * @param array $conditions
	 * @param array $fields
	 *
	 * @return array|bool|mixed
	 */
	public function getTransaction( $conditions = [], $fields = [] ) {
		return $this->_selectFromTb( $fields, $conditions, $this->transactionTb, true );
	}
	
	/**
	 * @param null $factor_number
	 * @param array $fields
	 *
	 * @return array|bool|mixed
	 */
	public function getTransactionByFactorNumber( $factor_number = null, $fields = [] ) {
		return ( $factor_number ) ? $this->getTransaction( [ 'FactorNumber' => $factor_number ], $fields ) : false;
	}
	
	/**
	 * @param null $factor_number
	 * @param array $fields
	 *
	 * @return array|bool
	 */
	public function getParamsByFactorNumber( $factor_number = null, $fields = [] ) {
		return ( $factor_number ) ? $this->getParams( [ 'factor_number' => $factor_number ], $fields, true ) : false;
	}
	
	/**
	 * @param null $id
	 *
	 * @return bool|mixed|null
	 */
	public function getBank( $id = null, $fields = [] ) {
		return ( $id ) ? $this->getBanks( [ 'id' => $id ], $fields, true ) : false;
	}
	
	public function currencyCodeForYekpay( $currency = null ) {
		$SessionCurrency = ( $currency && $currency >= 0 ) ? $currency : Session::getCurrency();
		$Currency        = Load::controller( 'currencyEquivalent' );
		$InfoCurrency    = $Currency->InfoCurrency( $SessionCurrency );
		$code            = 0;
		switch ( $InfoCurrency['CurrencyShortName'] ) {
			case 'EUR' :
				$code = 978;
				break;
			case 'IRR' :
				$code = 364;
				break;
			case 'AED' :
				$code = 784;
				break;
			case 'GBP' :
				$code = 826;
				break;
			case 'TRY' :
				$code = 949;
				break;
			case 'CNY' :
				$code = 156;
				break;
			case 'JPY' :
				$code = 392;
				break;
			case 'RUB' :
				$code = 643;
				break;
			default :
				$code = 0;
				break;
		}
		
		return $code;
		
	}
	
	public function CurlExecute( $data = [], $url = '', $type = 'post' ) {
		if ( $type == 'post' ) {
			$curl = functions::curlExecution( $url, $data, 'yes' );
		} else {
			$curl = functions::curlExecution_Get( $url, $data );
		}
		
	}
	
	
	public function preInsert( $data = [] ) {
		Session::init();
		$currencyEquivalent = Load::controller( 'currencyEquivalent' );
		$defaultCurrency    = $currencyEquivalent->CurrencyDefault();
		header( 'Content-Type: application/json' );
		$order_id     = $data['order_id'];
		$currency     = Session::getCurrency() ? Session::getCurrency() : $defaultCurrency['CurrencyCode'];
		$amount       = functions::CurrencyCalculate( $data['amount'], $currency );
		$bank         = self::getBanks( [ 'bank_dir' => 'yekpay' ], [ 'id', 'title', 'title_en', 'param2', 'bank_dir' ], true );
		$transaction  = self::getTransactionByFactorNumber( $order_id );
		$currencyCode = self::currencyCodeForYekpay( $currency );
		$insertData   = [
			'factor_number' => $order_id,
			'amount'        => $amount['AmountCurrency'],
			'bank_id'       => $bank['id'],
			'currency_code' => $currencyCode,
			'description'   => $transaction['Comment'],
			'status'        => 'pending',
			'callback_url'  => $data['callback']
		];
		
		$insert = self::insertParams( $insertData );
		if ( $insert ) {
			return [
				'success' => true,
				'data'    => [ 'id' => $insert['id'], 'fid' => $data['order_id'] ],
				'message' => 'Insert success',
			];
		}
		
		return [
			'order'    => $transaction['Comment'],
			'amount'   => $amount,
			'bank'     => $bank,
			'currency' => $currencyCode
		];
	}
	
	public function makeRequestForBank( $data = [] ) {
		$bank        = self::getBank( $data['bank_id'] );
		$transaction = self::getTransaction( $data['fid'] );
		
	}
	
}