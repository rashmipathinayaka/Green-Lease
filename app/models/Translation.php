<?php
class Translation {
    private $apiKey;
    private $currentLang = 'en';

    public function __construct() {
        $this->currentLang = $_SESSION['lang'] ?? 'en';
        // You'll need to set your Google Cloud API key here
        $this->apiKey = 'AIzaSyCHawurTPTu__8FiWXnRtReyGYcTBg3EjA';
    }

    public function translate($text, $targetLang = null) {
        if ($targetLang === null) {
            $targetLang = $this->currentLang;
        }

        // If target language is English, return original text
        if ($targetLang === 'en') {
            return $text;
        }

        // Convert language code to Google Translate format
        $targetLang = $this->getGoogleLangCode($targetLang);

        $url = 'https://translation.googleapis.com/language/translate/v2';
        $data = [
            'q' => $text,
            'target' => $targetLang,
            'key' => $this->apiKey
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        if (isset($result['data']['translations'][0]['translatedText'])) {
            return $result['data']['translations'][0]['translatedText'];
        }

        return $text; // Return original text if translation fails
    }

    private function getGoogleLangCode($lang) {
        $langMap = [
            'si' => 'si', // Sinhala
            'en' => 'en'  // English
        ];
        return $langMap[$lang] ?? 'en';
    }

    public function setLanguage($lang) {
        if (in_array($lang, ['en', 'si'])) {
            $this->currentLang = $lang;
            $_SESSION['lang'] = $lang;
        }
    }
} 