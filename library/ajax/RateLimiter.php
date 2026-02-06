<?php

class RateLimiter {
    private $defaultWindow = 60; // Time window in seconds
    private $defaultMaxAttempts = 5; // Max attempts per window
    
    // Rate limiting configuration per method
    private $methodLimits = [
        'members::callCheckExistence' => ['max' => 3, 'window' => 60],
        'members::callMemberLogin' => ['max' => 5, 'window' => 60],
        'members::callMemberRegister' => ['max' => 5, 'window' => 60],
        'members::callAuthenticateDigitCodeCreate' => ['max' => 1, 'window' => 60], //there is another check time in verificationCode::149 (expired method)
    ];
    
    /**
     * Check rate limiting for a method
     * @param string $className
     * @param string $method
     * @param string $identifier IP address or user identifier
     * @return array ['allowed' => bool, 'message' => string, 'retry_after' => int]
     */
    public function checkRateLimit($className, $method, $identifier) {
        $methodSignature = $className . '::' . $method;
        
        // Get rate limit config for this method
        $config = isset($this->methodLimits[$methodSignature]) 
            ? $this->methodLimits[$methodSignature] 
            : ['max' => $this->defaultMaxAttempts, 'window' => $this->defaultWindow];


        
        $maxAttempts = $config['max'];
        $timeWindow = $config['window'];
        
        // Create cache key
        $cacheKey = 'rate_limit_' . md5($methodSignature . '_' . $identifier);


        // Get current attempts from session/cache
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $attempts = isset($_SESSION[$cacheKey]) ? $_SESSION[$cacheKey] : [];
        $currentTime = time();

        
        // Clean old attempts outside the window
        $attempts = array_filter($attempts, function($timestamp) use ($currentTime, $timeWindow) {
            return ($currentTime - $timestamp) < $timeWindow;
        });
       
        // Check if limit exceeded
        if (count($attempts) >= $maxAttempts) {
            $oldestAttempt = min($attempts);
            $retryAfter = $timeWindow - ($currentTime - $oldestAttempt);
            
            return [
                'allowed' => false,
                'message' => "تعداد درخواست‌های شما بیش از حد مجاز است. لطفا {$retryAfter} ثانیه صبر کنید",
                'retry_after' => $retryAfter
            ];
        }
        
        // Add current attempt
        $attempts[] = $currentTime;
        $_SESSION[$cacheKey] = $attempts;
        
        return [
            'allowed' => true,
            'message' => '',
            'retry_after' => 0
        ];
    }
    
    /**
     * Get rate limiting info for monitoring/debugging
     * @param string $className
     * @param string $method
     * @param string $identifier
     * @return array
     */
    public function getRateLimitInfo($className, $method, $identifier) {
        $methodSignature = $className . '::' . $method;
        $config = isset($this->methodLimits[$methodSignature]) 
            ? $this->methodLimits[$methodSignature] 
            : ['max' => $this->defaultMaxAttempts, 'window' => $this->defaultWindow];
        
        $cacheKey = 'rate_limit_' . md5($methodSignature . '_' . $identifier);
        
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $attempts = isset($_SESSION[$cacheKey]) ? $_SESSION[$cacheKey] : [];
        $currentTime = time();
        
        // Clean old attempts
        $attempts = array_filter($attempts, function($timestamp) use ($currentTime, $config) {
            return ($currentTime - $timestamp) < $config['window'];
        });
        
        return [
            'method' => $methodSignature,
            'max_attempts' => $config['max'],
            'window_seconds' => $config['window'],
            'current_attempts' => count($attempts),
            'remaining_attempts' => max(0, $config['max'] - count($attempts)),
            'reset_time' => count($attempts) > 0 ? min($attempts) + $config['window'] : null
        ];
    }
    
    /**
     * Set rate limiting headers when limit is reached
     * @param int $retryAfter
     */
    public function setRateLimitHeaders($retryAfter) {
        header("X-RateLimit-Limit: " . $this->defaultMaxAttempts);
        header("X-RateLimit-Remaining: 0");
        header("Retry-After: " . $retryAfter);
    }
} 