<?php

class AuthenticationValidator {
    private $tokenMaxAge = 30; // Token max age in minutes
    
    // Configuration for methods that require captcha verification OR token verification
    private $authRequiredMethods = [
        'members::callCheckExistence',
        'members::callMemberLogin',
        'members::callMemberRegister',
        'members::callAuthenticateDigitCodeCreate',
    ];
    
    // Methods that ONLY require captcha (no token alternative)
    private $captchaOnlyMethods = [
        'members::callCheckExistence',  // First step always needs captcha
    ];
    
    /**
     * Check if a method requires authentication (captcha or token)
     * @param string $className
     * @param string $method
     * @return bool
     */
    public function isAuthRequired($className, $method) {
        $methodSignature = $className . '::' . $method;
        
        // Check exact match
        if (in_array($methodSignature, $this->authRequiredMethods)) {
            return true;
        }
        
        // Check wildcard match (className::*)
        $wildcardSignature = $className . '::*';
        if (in_array($wildcardSignature, $this->authRequiredMethods)) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Check if a method requires ONLY captcha (no token alternative)
     * @param string $className
     * @param string $method
     * @return bool
     */
    public function isCaptchaOnly($className, $method) {
        $methodSignature = $className . '::' . $method;
        return in_array($methodSignature, $this->captchaOnlyMethods);
    }
    
    /**
     * Verify captcha using Securimage
     * @param string $captcha_code
     * @return bool
     */
    public function verifyCaptcha($captcha_code) {
        try {
            // Start session if not already started
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            
            // Include Securimage class
            require_once dirname(__FILE__) . '/../../captcha/securimage.php';
            $securimage = new Securimage();
            
            // Check the captcha code
            $result = $securimage->check($captcha_code);
            
            // Create new code for next verification
            if ($result) {
                $securimage->createCode();
            }
            
            return $result;
        } catch (Exception $e) {
            // Log error if needed
            error_log('Captcha verification error: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Validate token age and activity
     * @param string $token
     * @param string $entry
     * @return array ['valid' => bool, 'message' => string]
     */
    public function validateTokenTime($token, $entry) {
        try {
            $authTokenController = Load::controller('authToken');
            $tokenInfo = $authTokenController->getTokenInfo($token);
            
            if (!$tokenInfo) {
                return ['valid' => false, 'message' => 'توکن یافت نشد'];
            }
            
            $createdAt = strtotime($tokenInfo['created_at']);
            $expiresAt = strtotime($tokenInfo['expires_at']);
            $currentTime = time();
            
            // Check if token is expired
            if ($currentTime > $expiresAt) {
                return ['valid' => false, 'message' => 'توکن منقضی شده است ، لطفا صفحه را رفرش کنید'];
            }
            
            // Check if token is too old (beyond max age)
            $tokenAge = ($currentTime - $createdAt) / 60; // Age in minutes
            if ($tokenAge > $this->tokenMaxAge) {
                return ['valid' => false, 'message' => 'توکن قدیمی است و نیاز به تجدید دارد'];
            }
            
            // Check if token is active
            if (!$tokenInfo['is_active']) {
                return ['valid' => false, 'message' => 'توکن غیرفعال است'];
            }
            
            // Check if entry matches
            if ($tokenInfo['entry'] !== $entry) {
                return ['valid' => false, 'message' => 'توکن برای این کاربر معتبر نیست'];
            }
            
            return ['valid' => true, 'message' => ''];
            
        } catch (Exception $e) {
            error_log('Token validation error: ' . $e->getMessage());
            return ['valid' => false, 'message' => 'خطا در اعتبارسنجی توکن'];
        }
    }
    
    /**
     * Generate token after successful captcha verification
     * @param string $entry
     * @param string $clientIP
     * @param string $userAgent
     * @return array|null
     */
    public function generateAuthToken($entry, $clientIP, $userAgent) {
        $authTokenController = Load::controller('authToken');
        
        // Add additional security info for token generation
        $tokenParams = [
            'entry' => $entry,
            'ip_address' => $clientIP,
            'user_agent' => $userAgent
        ];
        
        $tokenResult = $authTokenController->generateToken($tokenParams);

        if ($tokenResult['success']) {
            // Log successful token generation for security monitoring
            error_log("Token generated for entry: {$entry}, IP: {$clientIP}");
            return $tokenResult['token'];
        } else {
            error_log("Token generation failed for entry: {$entry}, IP: {$clientIP}");
            return null;
        }
    }
    
    /**
     * Verify token for authentication
     * @param string $token
     * @param string $entry
     * @return array ['valid' => bool, 'message' => string]
     */
    public function verifyAuthToken($token, $entry) {
        // Validate token time and activity first
        $tokenTimeCheck = $this->validateTokenTime($token, $entry);
        if (!$tokenTimeCheck['valid']) {
            return $tokenTimeCheck;
        }

        $authTokenController = Load::controller('authToken');
        $isValid = $authTokenController->verifyToken($token, $entry);
        return [
            'valid' => $isValid,
            'message' => $isValid ? '' : 'توکن معتبر نیست'
        ];
    }
} 