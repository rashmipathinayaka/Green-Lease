<?php
class Language extends Controller {
    private $translation;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->translation = new Translation();
    }

    public function switch() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lang = $_POST['lang'] ?? 'en';
            $redirect_url = $_POST['redirect_url'] ?? '/';
            
            // Validate language
            if (!in_array($lang, ['en', 'si'])) {
                $lang = 'en';
            }
            
            // Set language in session
            $_SESSION['lang'] = $lang;
            
            // If it's an AJAX request, return JSON response
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'lang' => $lang]);
                exit;
            }
            
            // For non-AJAX requests, redirect
            header('Location: ' . $redirect_url);
            exit;
        }
        
        // If not a POST request, redirect to home
        header('Location: ' . URLROOT);
        exit;
    }

    public function translate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $text = $_POST['text'] ?? '';
            $lang = $_POST['lang'] ?? 'en';
            
            if (!empty($text)) {
                $translation = $this->translation->translate($text, $lang);
                
                header('Content-Type: application/json');
                echo json_encode(['translation' => $translation]);
                exit;
            }
        }
        
        header('Content-Type: application/json');
        echo json_encode(['translation' => '']);
        exit;
    }
}