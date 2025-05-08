// Language Switcher
document.addEventListener('DOMContentLoaded', function() {
    // Get the language selector element
    const languageSelector = document.getElementById('language-switcher');
    
    // Initialize language manager if it exists
    if (typeof languageManager !== 'undefined') {
        // Set initial language
        languageSelector.value = languageManager.currentLanguage;
        
        // Add event listener for language changes
        languageSelector.addEventListener('change', (e) => {
            const selectedLanguage = e.target.value;
            languageManager.setLanguage(selectedLanguage);
        });
    } else {
        console.error('Language manager not found. Make sure language-manager.js is loaded before language-switcher.js');
    }
}); 