<?php
class Translation {
    private $credentialsPath;
    private $baseUrl = 'https://translation.googleapis.com/language/translate/v2';

    public function __construct() {
        // Path to your service account credentials JSON file
        $this->credentialsPath = __DIR__ . '/config/google_cloud_credentials.json';
        
        if (!file_exists($this->credentialsPath)) {
            error_log('Translation Error: Credentials file not found at: ' . $this->credentialsPath);
            throw new Exception('Google Cloud credentials file not found. Please place your service account JSON file at: ' . $this->credentialsPath);
        }
    }

    private function getAccessToken() {
        try {
            $credentials = json_decode(file_get_contents($this->credentialsPath), true);
            if (!$credentials) {
                error_log('Translation Error: Invalid credentials JSON format');
                return null;
            }
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://oauth2.googleapis.com/token');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $this->createJWT($credentials)
            ]));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            error_log('Translation Debug: OAuth Response Code: ' . $httpCode);
            error_log('Translation Debug: OAuth Response: ' . $response);

            $result = json_decode($response, true);
            if (!isset($result['access_token'])) {
                error_log('Translation Error: No access token in response');
                return null;
            }

            return $result['access_token'];
        } catch (Exception $e) {
            error_log('Translation Error: ' . $e->getMessage());
            return null;
        }
    }

    private function createJWT($credentials) {
        $header = [
            'alg' => 'RS256',
            'typ' => 'JWT'
        ];

        $now = time();
        $payload = [
            'iss' => $credentials['client_email'],
            'scope' => 'https://www.googleapis.com/auth/cloud-translation',
            'aud' => 'https://oauth2.googleapis.com/token',
            'exp' => $now + 3600,
            'iat' => $now
        ];

        $encodedHeader = $this->base64UrlEncode(json_encode($header));
        $encodedPayload = $this->base64UrlEncode(json_encode($payload));
        $signature = $this->sign($encodedHeader . '.' . $encodedPayload, $credentials['private_key']);

        return $encodedHeader . '.' . $encodedPayload . '.' . $signature;
    }

    private function base64UrlEncode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function sign($data, $privateKey) {
        openssl_sign($data, $signature, $privateKey, OPENSSL_ALGO_SHA256);
        return $this->base64UrlEncode($signature);
    }

    public function translate($text, $targetLanguage = null) {
        if (empty($text)) {
            return $text;
        }

        // Get current language from session
        $currentLanguage = getCurrentLanguage();
        error_log('Translation Debug: Current Language: ' . $currentLanguage);
        
        // If current language is English, return text as is
        if ($currentLanguage === 'en') {
            return $text;
        }

        // Use current language as target if not specified
        if ($targetLanguage === null) {
            $targetLanguage = $currentLanguage;
        }

        if ($customTranslation !== null) {
            error_log('Translation Debug: Using custom translation: ' . $customTranslation);
            return $customTranslation;
        }

        // If no custom translation exists, use Google Translate
        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            error_log('Translation Error: Failed to get access token');
            return $text;
        }

        $url = $this->baseUrl . '?key=' . $accessToken;
        $data = [
            'q' => $text,
            'target' => $targetLanguage,
            'source' => 'en'
        ];

        error_log('Translation Debug: Request URL: ' . $url);
        error_log('Translation Debug: Request Data: ' . json_encode($data));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        error_log('Translation Debug: API Response Code: ' . $httpCode);
        error_log('Translation Debug: API Response: ' . $response);

        $result = json_decode($response, true);

        if (isset($result['data']['translations'][0]['translatedText'])) {
            return $result['data']['translations'][0]['translatedText'];
        }

        error_log('Translation Error: No translation in response');
        return $text;
    }

    public function translateArray($array) {
        $translated = [];
        foreach ($array as $key => $value) {
            if (is_string($value)) {
                $translated[$key] = $this->translate($value);
            } else {
                $translated[$key] = $value;
            }
        }
        return $translated;
    }
} 