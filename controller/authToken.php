<?php

class authToken extends clientAuth {
    
    private $authTokenModel;
    private $tokenValidityMinutes = 10; // Token validity period in minutes (increased from 2 to 10)
    
    public function __construct() {
        parent::__construct();
        $this->authTokenModel = $this->getModel('authTokenModel');
    }
    
    /**
     * Generate a new authentication token after captcha verification
     * @param array $params
     * @return array
     */
    public function generateToken($params) {
        $entry = $params['entry'];
        $sessionId = session_id();
        $ipAddress = isset($params['ip_address']) ? $params['ip_address'] : ($_SERVER['REMOTE_ADDR'] ?: '');
        $userAgent = isset($params['user_agent']) ? $params['user_agent'] : ($_SERVER['HTTP_USER_AGENT'] ?: '');

        // Generate a secure token
        $token = $this->createSecureToken();

        // Calculate expiry time
        $expiresAt = date('Y-m-d H:i:s', strtotime('+' . $this->tokenValidityMinutes . ' minutes'));


        // Deactivate any existing tokens for this entry
        $this->deactivateExistingTokens($entry);
        
        // Store the new token
        $tokenData = [
            'token' => $token,
            'session_id' => $sessionId,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'entry' => $entry,
            'is_verified' => 1,
            'expires_at' => $expiresAt,
            'is_active' => 1
        ];


        $result = $this->authTokenModel->insertWithBind($tokenData);

        if ($result) {
            return [
                'success' => true,
                'token' => $token,
                'expires_at' => $expiresAt
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Failed to generate token'
        ];
    }
    
    /**
     * Verify if a token is valid
     * @param string $token
     * @param string $entry
     * @param bool $checkIP Whether to validate IP address (default: true)
     * @return bool
     */
    public function verifyToken($token, $entry, $checkIP = true) {
        if (empty($token) || empty($entry)) {
            return false;
        }
        
        $tokenRecord = $this->authTokenModel->get()
            ->where('token', $token)
            ->where('entry', $entry)
            ->where('is_active', 1)
            ->where('expires_at', date('Y-m-d H:i:s'), '>')
            ->find();
        
        if ($tokenRecord) {
            // Optional IP validation for additional security
            if ($checkIP) {
                $currentIP = $_SERVER['HTTP_CF_CONNECTING_IP'] ? $_SERVER['HTTP_CF_CONNECTING_IP'] : '';
                if (!empty($tokenRecord['ip_address']) && $tokenRecord['ip_address'] !== $currentIP) {
                    // Log potential security issue
                    error_log("Token IP mismatch for entry: {$entry}. Expected: {$tokenRecord['ip_address']}, Got: {$currentIP}");
                    return false;
                }
            }
            
            // Update used_at timestamp
            $this->authTokenModel->updateWithBind(
                ['used_at' => date('Y-m-d H:i:s')],
                ['id' => $tokenRecord['id']]
            );
            return true;
        }
        
        return false;
    }
    
    /**
     * Deactivate a token after use (for single-use tokens)
     * @param string $token
     * @return bool
     */
    public function deactivateToken($token) {
        // Check if token exists first
        $tokenExists = $this->authTokenModel->get()
            ->where('token', $token)
            ->find();
            
        if (!$tokenExists) {
            return false;
        }
        
        return $this->authTokenModel->updateWithBind(
            ['is_active' => 0],
            ['token' => $token]
        );
    }
    
    /**
     * Clean up expired tokens
     * @return bool
     */
    public function cleanupExpiredTokens() {
        return $this->authTokenModel->updateWithBind(
            ['is_active' => 0],
            ['expires_at' => date('Y-m-d H:i:s'), 'is_active' => 1],
            'expires_at < ? AND is_active = ?'
        );
    }
    
    /**
     * Deactivate existing tokens for an entry
     * @param string $entry
     * @return bool
     */
    private function deactivateExistingTokens($entry) {

        // Check if token exists first
        $tokenExists = $this->authTokenModel->get()
            ->where('entry', $entry)
            ->find();


        if (!$tokenExists) {
            return false;
        }
        return $this->authTokenModel->updateWithBind(
            ['is_active' => 0],
            ['entry' => $entry, 'is_active' => 1]
        );
    }
    
    /**
     * Create a secure random token
     * @return string
     */
    private function createSecureToken() {
        return bin2hex(rand(1111,9999)) . '_' . time() . '_' . uniqid();
    }
    
    /**
     * Get token information for debugging/logging
     * @param string $token
     * @return array|null
     */
    public function getTokenInfo($token) {
        return $this->authTokenModel->get()
            ->where('token', $token)
            ->find();
    }
} 