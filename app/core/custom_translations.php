<?php
// Custom translations mapping
$customTranslations = [
    'en' => [
        // English translations (source)
    ],
    'si' => [
        // Sinhala translations
        'Dashboard' => 'පාලක පුවරුව',
        'Work Records' => 'වැඩ වාර්තා',
        'File a Complaint' => 'පැමිණිල්ලක් ඉදිරිපත් කරන්න',
        'Logout' => 'පිටවීම',
        'Worker Dashboard' => 'කම්කරු පාලක පුවරුව',
        'Worker Portal' => 'කම්කරු ද්වාරය'
    ],
    'ta' => [
        // Tamil translations
        'Dashboard' => 'டாஷ்போர்டு',
        'Work Records' => 'வேலை பதிவுகள்',
        'File a Complaint' => 'புகார் தாக்கல் செய்யவும்',
        'Logout' => 'வெளியேறு',
        'Worker Dashboard' => 'தொழிலாளர் டாஷ்போர்டு',
        'Worker Portal' => 'தொழிலாளர் போர்டல்'
    ]
];

// Function to get custom translation
function getCustomTranslation($text, $language) {
    global $customTranslations;
    
    if (isset($customTranslations[$language][$text])) {
        return $customTranslations[$language][$text];
    }
    
    return null; // Return null if no custom translation exists
} 