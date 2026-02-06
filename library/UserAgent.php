<?php

class UserAgent {
	
	public $platforms = [
			'windows nt 10.0' => 'Windows 10',
			'windows nt 6.3'  => 'Windows 8.1',
			'windows nt 6.2'  => 'Windows 8',
			'windows nt 6.1'  => 'Windows 7',
			'windows nt 6.0'  => 'Windows Vista',
			'windows nt 5.2'  => 'Windows 2003',
			'windows nt 5.1'  => 'Windows XP',
			'windows nt 5.0'  => 'Windows 2000',
			'windows nt 4.0'  => 'Windows NT 4.0',
			'winnt4.0'        => 'Windows NT 4.0',
			'winnt 4.0'       => 'Windows NT',
			'winnt'           => 'Windows NT',
			'windows 98'      => 'Windows 98',
			'win98'           => 'Windows 98',
			'windows 95'      => 'Windows 95',
			'win95'           => 'Windows 95',
			'windows phone'   => 'Windows Phone',
			'windows'         => 'Unknown Windows OS',
			'android'         => 'Android',
			'blackberry'      => 'BlackBerry',
			'iphone'          => 'iOS',
			'ipad'            => 'iOS',
			'ipod'            => 'iOS',
			'os x'            => 'Mac OS X',
			'ppc mac'         => 'Power PC Mac',
			'freebsd'         => 'FreeBSD',
			'ppc'             => 'Macintosh',
			'linux'           => 'Linux',
			'debian'          => 'Debian',
			'sunos'           => 'Sun Solaris',
			'beos'            => 'BeOS',
			'apachebench'     => 'ApacheBench',
			'aix'             => 'AIX',
			'irix'            => 'Irix',
			'osf'             => 'DEC OSF',
			'hp-ux'           => 'HP-UX',
			'netbsd'          => 'NetBSD',
			'bsdi'            => 'BSDi',
			'openbsd'         => 'OpenBSD',
			'gnu'             => 'GNU/Linux',
			'unix'            => 'Unknown Unix OS',
			'symbian'         => 'Symbian OS',
		];
	
	public $browsers = [
			'OPR'               => 'Opera',
			'Flock'             => 'Flock',
			'Edge'              => 'Spartan',
			'Edg'               => 'Edge',
			'Chrome'            => 'Chrome',
			// Opera 10+ always reports Opera/9.80 and appends Version/<real version> to the user agent string
			'Opera.*?Version'   => 'Opera',
			'Opera'             => 'Opera',
			'MSIE'              => 'Internet Explorer',
			'Internet Explorer' => 'Internet Explorer',
			'Trident.* rv'      => 'Internet Explorer',
			'Shiira'            => 'Shiira',
			'Firefox'           => 'Firefox',
			'Chimera'           => 'Chimera',
			'Phoenix'           => 'Phoenix',
			'Firebird'          => 'Firebird',
			'Camino'            => 'Camino',
			'Netscape'          => 'Netscape',
			'OmniWeb'           => 'OmniWeb',
			'Safari'            => 'Safari',
			'Mozilla'           => 'Mozilla',
			'Konqueror'         => 'Konqueror',
			'icab'              => 'iCab',
			'Lynx'              => 'Lynx',
			'Links'             => 'Links',
			'hotjava'           => 'HotJava',
			'amaya'             => 'Amaya',
			'IBrowse'           => 'IBrowse',
			'Maxthon'           => 'Maxthon',
			'Ubuntu'            => 'Ubuntu Web Browser',
			'Vivaldi'           => 'Vivaldi',
		];
	
	public $mobiles = [
			// legacy array, old values commented out
			'mobileexplorer'       => 'Mobile Explorer',
			// 'openwave'             => 'Open Wave',
			// 'opera mini'           => 'Opera Mini',
			// 'operamini'            => 'Opera Mini',
			// 'elaine'               => 'Palm',
			'palmsource'           => 'Palm',
			// 'digital paths'        => 'Palm',
			// 'avantgo'              => 'Avantgo',
			// 'xiino'                => 'Xiino',
			'palmscape'            => 'Palmscape',
			// 'nokia'                => 'Nokia',
			// 'ericsson'             => 'Ericsson',
			// 'blackberry'           => 'BlackBerry',
			// 'motorola'             => 'Motorola'
			
			// Phones and Manufacturers
			'motorola'             => 'Motorola',
			'nokia'                => 'Nokia',
			'palm'                 => 'Palm',
			'iphone'               => 'Apple iPhone',
			'ipad'                 => 'iPad',
			'ipod'                 => 'Apple iPod Touch',
			'sony'                 => 'Sony Ericsson',
			'ericsson'             => 'Sony Ericsson',
			'blackberry'           => 'BlackBerry',
			'cocoon'               => 'O2 Cocoon',
			'blazer'               => 'Treo',
			'lg'                   => 'LG',
			'amoi'                 => 'Amoi',
			'xda'                  => 'XDA',
			'mda'                  => 'MDA',
			'vario'                => 'Vario',
			'htc'                  => 'HTC',
			'samsung'              => 'Samsung',
			'sharp'                => 'Sharp',
			'sie-'                 => 'Siemens',
			'alcatel'              => 'Alcatel',
			'benq'                 => 'BenQ',
			'ipaq'                 => 'HP iPaq',
			'mot-'                 => 'Motorola',
			'playstation portable' => 'PlayStation Portable',
			'playstation 3'        => 'PlayStation 3',
			'playstation vita'     => 'PlayStation Vita',
			'hiptop'               => 'Danger Hiptop',
			'nec-'                 => 'NEC',
			'panasonic'            => 'Panasonic',
			'philips'              => 'Philips',
			'sagem'                => 'Sagem',
			'sanyo'                => 'Sanyo',
			'spv'                  => 'SPV',
			'zte'                  => 'ZTE',
			'sendo'                => 'Sendo',
			'nintendo dsi'         => 'Nintendo DSi',
			'nintendo ds'          => 'Nintendo DS',
			'nintendo 3ds'         => 'Nintendo 3DS',
			'wii'                  => 'Nintendo Wii',
			'open web'             => 'Open Web',
			'openweb'              => 'OpenWeb',
			
			// Operating Systems
			'android'              => 'Android',
			'symbian'              => 'Symbian',
			'SymbianOS'            => 'SymbianOS',
			'elaine'               => 'Palm',
			'series60'             => 'Symbian S60',
			'windows ce'           => 'Windows CE',
			
			// Browsers
			'obigo'                => 'Obigo',
			'netfront'             => 'Netfront Browser',
			'openwave'             => 'Openwave Browser',
			'mobilexplorer'        => 'Mobile Explorer',
			'operamini'            => 'Opera Mini',
			'opera mini'           => 'Opera Mini',
			'opera mobi'           => 'Opera Mobile',
			'fennec'               => 'Firefox Mobile',
			
			// Other
			'digital paths'        => 'Digital Paths',
			'avantgo'              => 'AvantGo',
			'xiino'                => 'Xiino',
			'novarra'              => 'Novarra Transcoder',
			'vodafone'             => 'Vodafone',
			'docomo'               => 'NTT DoCoMo',
			'o2'                   => 'O2',
			
			// Fallback
			'mobile'               => 'Generic Mobile',
			'wireless'             => 'Generic Mobile',
			'j2me'                 => 'Generic Mobile',
			'midp'                 => 'Generic Mobile',
			'cldc'                 => 'Generic Mobile',
			'up.link'              => 'Generic Mobile',
			'up.browser'           => 'Generic Mobile',
			'smartphone'           => 'Generic Mobile',
			'cellphone'            => 'Generic Mobile',
		];
	
	public $robots = [
			'googlebot'            => 'Googlebot',
			'msnbot'               => 'MSNBot',
			'baiduspider'          => 'Baiduspider',
			'bingbot'              => 'Bing',
			'slurp'                => 'Inktomi Slurp',
			'yahoo'                => 'Yahoo',
			'ask jeeves'           => 'Ask Jeeves',
			'fastcrawler'          => 'FastCrawler',
			'infoseek'             => 'InfoSeek Robot 1.0',
			'lycos'                => 'Lycos',
			'yandex'               => 'YandexBot',
			'mediapartners-google' => 'MediaPartners Google',
			'CRAZYWEBCRAWLER'      => 'Crazy Webcrawler',
			'adsbot-google'        => 'AdsBot Google',
			'feedfetcher-google'   => 'Feedfetcher Google',
			'curious george'       => 'Curious George',
			'ia_archiver'          => 'Alexa Crawler',
			'MJ12bot'              => 'Majestic-12',
			'Uptimebot'            => 'Uptimebot',
		];
	
	/**
	 * Current user-agent
	 *
	 * @var string
	 */
	protected $agent = '';
	
	/**
	 * Flag for if the user-agent belongs to a browser
	 *
	 * @var bool
	 */
	protected $isBrowser = false;
	
	/**
	 * Flag for if the user-agent is a robot
	 *
	 * @var bool
	 */
	protected $isRobot = false;
	
	/**
	 * Flag for if the user-agent is a mobile browser
	 *
	 * @var bool
	 */
	protected $isMobile = false;
	
	/**
	 * Current user-agent platform
	 *
	 * @var string
	 */
	protected $platform = '';
	
	/**
	 * Current user-agent browser
	 *
	 * @var string
	 */
	protected $browser = '';
	
	/**
	 * Current user-agent version
	 *
	 * @var string
	 */
	protected $version = '';
	
	/**
	 * Current user-agent mobile name
	 *
	 * @var string
	 */
	protected $mobile = '';
	
	/**
	 * Current user-agent robot name
	 *
	 * @var string
	 */
	protected $robot = '';
	
	/**
	 * HTTP Referer
	 *
	 * @var mixed
	 */
	protected $referrer;
	
	/**
	 * Constructor
	 *
	 * Sets the User Agent and runs the compilation routine
	 */
	public function __construct() {
		if ( isset( $_SERVER['HTTP_USER_AGENT'] ) ) {
			$this->agent = trim( $_SERVER['HTTP_USER_AGENT'] );
			$this->compileData();
		}
	}
	
	/**
	 * Is Browser
	 *
	 * @param string $key
	 *
	 * @return bool
	 */
	public function isBrowser( $key = null ) {
		if ( ! $this->isBrowser ) {
			return false;
		}
		
		// No need to be specific, it's a browser
		if ( $key === null ) {
			return true;
		}
		
		// Check for a specific browser
		return isset( $this->browsers[ $key ] ) && $this->browser === $this->browsers[ $key ];
	}
	
	/**
	 * Is Robot
	 *
	 * @param string $key
	 *
	 * @return bool
	 */
	public function isRobot( $key = null ) {
		if ( ! $this->isRobot ) {
			return false;
		}
		
		// No need to be specific, it's a robot
		if ( $key === null ) {
			return true;
		}
		
		// Check for a specific robot
		return isset( $this->robots[ $key ] ) && $this->robot === $this->robots[ $key ];
	}
	
	/**
	 * Is Mobile
	 *
	 * @param string $key
	 *
	 * @return bool
	 */
	public function isMobile( ?string $key = null ) {
		if ( ! $this->isMobile ) {
			return false;
		}
		
		// No need to be specific, it's a mobile
		if ( $key === null ) {
			return true;
		}
		
		// Check for a specific robot
		return isset( $this->mobiles[ $key ] ) && $this->mobile === $this->mobiles[ $key ];
	}
	
	/**
	 * Is this a referral from another site?
	 */
	public function isReferral() {
		if ( ! isset( $this->referrer ) ) {
			if ( empty( $_SERVER['HTTP_REFERER'] ) ) {
				$this->referrer = false;
			} else {
				$refererHost = @parse_url( $_SERVER['HTTP_REFERER'], PHP_URL_HOST );
				$ownHost     = parse_url( "", PHP_URL_HOST );
				
				$this->referrer = ( $refererHost && $refererHost !== $ownHost );
			}
		}
		
		return $this->referrer;
	}
	
	/**
	 * Agent String
	 */
	public function getAgentString() {
		return $this->agent;
	}
	
	/**
	 * Get Platform
	 */
	public function getPlatform() {
		return $this->platform;
	}
	
	/**
	 * Get Browser Name
	 */
	public function getBrowser() {
		return $this->browser;
	}
	
	/**
	 * Get the Browser Version
	 */
	public function getVersion() {
		return $this->version;
	}
	
	/**
	 * Get The Robot Name
	 */
	public function getRobot() {
		return $this->robot;
	}
	
	/**
	 * Get the Mobile Device
	 */
	public function getMobile() {
		return $this->mobile;
	}
	
	/**
	 * Get the referrer
	 */
	public function getReferrer() {
		return empty( $_SERVER['HTTP_REFERER'] ) ? '' : trim( $_SERVER['HTTP_REFERER'] );
	}
	
	/**
	 * Parse a custom user-agent string
	 *
	 * @param $string
	 */
	public function parse( $string ) {
		// Reset values
		$this->isBrowser = false;
		$this->isRobot   = false;
		$this->isMobile  = false;
		$this->browser   = '';
		$this->version   = '';
		$this->mobile    = '';
		$this->robot     = '';
		
		// Set the new user-agent string and parse it, unless empty
		$this->agent = $string;
		
		if ( ! empty( $string ) ) {
			$this->compileData();
		}
	}
	
	/**
	 * Compile the User Agent Data
	 */
	protected function compileData() {
		$this->setPlatform();
		
		foreach ( [ 'setRobot', 'setBrowser', 'setMobile' ] as $function ) {
			if ( $this->{$function}() === true ) {
				break;
			}
		}
	}
	
	/**
	 * Set the Platform
	 */
	protected function setPlatform() {
		if ( is_array( $this->platforms ) && $this->platforms ) {
			foreach ( $this->platforms as $key => $val ) {
				if ( preg_match( '|' . preg_quote( $key, '|' ) . '|i', $this->agent ) ) {
					$this->platform = $val;
					
					return true;
				}
			}
		}
		
		$this->platform = 'Unknown Platform';
		
		return false;
	}
	
	/**
	 * Set the Browser
	 */
	protected function setBrowser() {
		if ( is_array( $this->browsers ) && $this->browsers ) {
			foreach ( $this->browsers as $key => $val ) {
				if ( preg_match( '|' . $key . '.*?([0-9\.]+)|i', $this->agent, $match ) ) {
					$this->isBrowser = true;
					$this->version   = $match[1];
					$this->browser   = $val;
					$this->setMobile();
					
					return true;
				}
			}
		}
		
		return false;
	}
	
	/**
	 * Set the Robot
	 */
	protected function setRobot() {
		if ( is_array( $this->robots ) && $this->robots ) {
			foreach ( $this->robots as $key => $val ) {
				if ( preg_match( '|' . preg_quote( $key, '|' ) . '|i', $this->agent ) ) {
					$this->isRobot = true;
					$this->robot   = $val;
					$this->setMobile();
					
					return true;
				}
			}
		}
		
		return false;
	}
	
	/**
	 * Set the Mobile Device
	 */
	protected function setMobile() {
		if ( is_array( $this->mobiles ) && $this->mobiles ) {
			foreach ( $this->mobiles as $key => $val ) {
				if ( false !== ( stripos( $this->agent, $key ) ) ) {
					$this->isMobile = true;
					$this->mobile   = $val;
					
					return true;
				}
			}
		}
		
		return false;
	}
	
	/**
	 * Outputs the original Agent String when cast as a string.
	 */
	public function __toString() {
		return $this->getAgentString();
	}
}
