<?php

class RequestProcessor {
    private $authValidator;
    private $rateLimiter;
    private $content;

    public function __construct() {
        $this->authValidator = new AuthenticationValidator();
        $this->rateLimiter = new RateLimiter();
    }

    /**
     * Set request content
     * @param array $content
     */
    public function setContent($content) {
        $this->content = $content;
    }

    /**
     * Process authentication for a method call
     * @param string $className
     * @param string $method
     * @return array ['success' => bool, 'error' => string|null, 'token' => string|null]
     */
    public function processAuthentication($className, $method) {
        // Check if this method requires authentication
        if (!$this->authValidator->isAuthRequired($className, $method)) {
            return $this->processOptionalCaptcha();
        }

        $captcha_code = isset($this->content['captcha_code']) ? $this->content['captcha_code'] : '';
        $auth_token = isset($this->content['auth_token']) ? $this->content['auth_token'] : '';
        $entry = isset($this->content['entry']) ? $this->content['entry'] : '';

        // Get client identifier for rate limiting
        $clientIP = $_SERVER['HTTP_CF_CONNECTING_IP'] ? $_SERVER['HTTP_CF_CONNECTING_IP'] : '';
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ? $_SERVER['HTTP_USER_AGENT'] : '';
        $identifier = $entry ?: $clientIP;

        // Check rate limiting
        $rateLimitCheck = $this->rateLimiter->checkRateLimit($className, $method, $identifier);

        if (!$rateLimitCheck['allowed']) {
            $this->rateLimiter->setRateLimitHeaders($rateLimitCheck['retry_after']);
            return [
                'success' => false,
                'error' => $rateLimitCheck['message'],
                'status_code' => 429,
                'token' => null
            ];
        }

        // Process captcha-only methods
        if ($this->authValidator->isCaptchaOnly($className, $method)) {
            return $this->processCaptchaOnlyAuth($method, $captcha_code, $entry, $clientIP, $userAgent);
        }

        // Process token or captcha methods
        return $this->processTokenOrCaptchaAuth($auth_token, $captcha_code, $entry);
    }

    /**
     * Process captcha-only authentication (like callCheckExistence)
     * @param string $method
     * @param string $captcha_code
     * @param string $entry
     * @param string $clientIP
     * @param string $userAgent
     * @return array
     */
    private function processCaptchaOnlyAuth($method, $captcha_code, $entry, $clientIP, $userAgent) {
        if (empty($captcha_code)) {
            return [
                'success' => false,
                'error' => 'لطفا کد امنیتی را وارد کنید',
                'status_code' => 400,
                'token' => null
            ];
        }

        if (!$this->authValidator->verifyCaptcha($captcha_code)) {
            return [
                'success' => false,
                'error' => 'کد امنیتی وارد شده صحیح نمی باشد',
                'status_code' => 400,
                'token' => null
            ];
        }

        // Remove captcha from content
        unset($this->content['captcha_code']);

        // Generate token for callCheckExistence
        $generatedToken = null;
        if ($method === 'callCheckExistence' && !empty($entry)) {
            $generatedToken = $this->authValidator->generateAuthToken($entry, $clientIP, $userAgent);
        }

        return [
            'success' => true,
            'error' => null,
            'token' => $generatedToken
        ];
    }

    /**
     * Process token or captcha authentication
     * @param string $auth_token
     * @param string $captcha_code
     * @param string $entry
     * @return array
     */
    private function processTokenOrCaptchaAuth($auth_token, $captcha_code, $entry) {
        $authVerified = false;

        // Try token first
        if (!empty($auth_token) && !empty($entry)) {
            $tokenResult = $this->authValidator->verifyAuthToken($auth_token, $entry);
            if ($tokenResult['valid']) {
                $authVerified = true;
                unset($this->content['auth_token']);
            } else {
                // Return specific token error message
                return [
                    'success' => false,
                    'error' => $tokenResult['message'],
                    'status_code' => 401,
                    'token' => null
                ];
            }
        }

        // If token verification failed and captcha is provided, try captcha
        if (!$authVerified && !empty($captcha_code)) {
            if ($this->authValidator->verifyCaptcha($captcha_code)) {
                $authVerified = true;
                unset($this->content['captcha_code']);
            }
        }

        if (!$authVerified) {
            return [
                'success' => false,
                'error' => 'احراز هویت نامعتبر است. لطفا مجددا تلاش کنید',
                'status_code' => 400,
                'token' => null
            ];
        }

        return [
            'success' => true,
            'error' => null,
            'token' => null
        ];
    }

    /**
     * Process optional captcha for non-protected methods
     * @return array
     */
    private function processOptionalCaptcha() {
        // For non-protected methods, still check captcha if provided (optional captcha)
        if (isset($this->content['captcha_code']) && !empty($this->content['captcha_code'])) {
            $captcha_code = $this->content['captcha_code'];

            if (!$this->authValidator->verifyCaptcha($captcha_code)) {
                return [
                    'success' => false,
                    'error' => 'کد امنیتی وارد شده صحیح نمی باشد',
                    'status_code' => 400,
                    'token' => null
                ];
            }

            unset($this->content['captcha_code']);
        }

        return [
            'success' => true,
            'error' => null,
            'token' => null
        ];
    }

    /**
     * Get processed content (after removing captcha/token fields)
     * @return array
     */
    public function getProcessedContent() {
        return $this->content;
    }

    /**
     * Get rate limiting info for monitoring
     * @param string $className
     * @param string $method
     * @param string $identifier
     * @return array
     */
    public function getRateLimitInfo($className, $method, $identifier) {
        return $this->rateLimiter->getRateLimitInfo($className, $method, $identifier);
    }
} 