<?php

// error_reporting(1);
// error_reporting(E_ALL | E_STRICT);
// @ini_set('display_errors', 1);
// @ini_set('display_errors', 'on');

// Include required classes
require_once __DIR__ . '/RateLimiter.php';
require_once __DIR__ . '/AuthenticationValidator.php';
require_once __DIR__ . '/RequestProcessor.php';

class ajax {
	private $content;
	private $requestProcessor;
	
	public function __construct() {
//        if($_SERVER['HTTP_HOST'] == 'admin.chartertech.ir'){
//            var_dump('awd');
//            die();
//        }
		header( "Content-type: application/json" );
		
		// Add security headers
		header("X-Content-Type-Options: nosniff");
		header("X-Frame-Options: DENY");
		header("X-XSS-Protection: 1; mode=block");
		
		// Initialize request processor
		$this->requestProcessor = new RequestProcessor();
	}

	/**
	 * Get rate limiting info for monitoring/debugging
	 * @param string $className
	 * @param string $method
	 * @param string $identifier
	 * @return array
	 */
	public function getRateLimitInfo($className, $method, $identifier) {
		return $this->requestProcessor->getRateLimitInfo($className, $method, $identifier);
	}

	/**
	 * @return bool|mixed|string
	 */
	public function showResponse() {
		$language = isset( $_SERVER['HTTP_X_LANGUAGE'] ) && ! empty( $_SERVER['HTTP_X_LANGUAGE'] ) && in_array( array(
			'en',
			'ar',
			'fa'
		), $_SERVER['HTTP_X_LANGUAGE'] ) ? strtolower( $_SERVER['HTTP_X_LANGUAGE'] ) : SOFTWARE_LANG;

		if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
			$input = functions::clearJsonHiddenCharacters( file_get_contents( 'php://input' ) );

            if(!empty($input)){
                if ( is_string( $input ) && !functions::isJson($input)) {
                    return functions::withError( file_get_contents( 'php://input' ), 400, 'Request data must be as json format');
                }
            }

			$this->content = json_decode( $input, true );
			if ( empty( $this->content ) ) {
				$this->content = $_POST;
			}
		}

		if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
			$this->content = $_GET;
			unset( $this->content['ajax'], $this->content['ajax/'] );
		}

		/**
		 * @var publicAjax ./controller/publicAjax
		 */
		$public_ajax      = 'publicAjax';
		$class_name       = isset( $this->content['className'] ) ? $this->content['className'] : $public_ajax;
		$method           = $this->content['method'];
		$param_controller = isset( $this->content['param'] ) ? $this->content['param'] : null;

		// Set content for request processor and process authentication
		$this->requestProcessor->setContent($this->content);
		$authResult = $this->requestProcessor->processAuthentication($class_name, $method);
		
		// Check authentication result
		if (!$authResult['success']) {
			$statusCode = isset($authResult['status_code']) ? $authResult['status_code'] : 400;
			return functions::withError(null, $statusCode, $authResult['error']);
		}
		
		// Get processed content (with captcha/token removed)
		$this->content = $this->requestProcessor->getProcessedContent();

		$controller_name  = Load::controller( $class_name, $param_controller );

		unset( $this->content['method'] );
		unset( $this->content['className'] );
		unset( $this->content['param'] );
		$params = $this->content;

		if ( ! $controller_name ) {
			return functions::withError( null, 400, 'class parameter is wrong' );
		}

		if ( ! $method ) {
			return functions::withError( [$method,$controller_name,$this->content], 400, 'method parameter not sent' );
		}
		if ( ! method_exists( $controller_name, $method ) ) {
			return functions::withError( [ $controller_name, $method ], 400, 'method not found' );
		}
        if(isset($params['to_json']) && $params['to_json']){
            $result = $controller_name->$method( $params );
            
            // If a token was generated, include it in the response
            if ($authResult['token']) {
                if (is_array($result) && isset($result['data'])) {
                    $result['auth_token'] = $authResult['token'];
                } else {
                    $result = [
                        'data' => $result,
                        'auth_token' => $authResult['token']
                    ];
                }
            }
            
            return functions::withSuccess($result);
        }

		return $controller_name->$method( $params );
	}
}

$result = new ajax();
echo $result->showResponse(); 