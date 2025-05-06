<?php 

function show($stuff)
{
	echo "<pre>";
	print_r($stuff);
	echo "</pre>";
}

function esc($str)
{
	return htmlspecialchars($str);
}

function redirect($path)
{
	header("Location: " . 	URLROOT."/".$path);
	die;
}

function translate($text) {
    static $translator = null;
    
    if ($translator === null) {
        $translator = new Translation();
    }
    
    return $translator->translate($text);
}

function getCurrentLanguage() {
    return $_SESSION['lang'] ?? 'en';
}

function setLanguage($language) {
    $_SESSION['language'] = $language;
}
