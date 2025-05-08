class LanguageManager {
    constructor() {
        console.log('LanguageManager: Starting initialization...');
        
        // Check if required files are loaded
        if (!window.languages) {
            console.error('LanguageManager: languages.js not loaded');
            throw new Error('languages.js not loaded');
        }
        if (!window.translations) {
            console.error('LanguageManager: translations.js not loaded');
            throw new Error('translations.js not loaded');
        }
        
        console.log('LanguageManager: Required files loaded successfully');
        console.log('Available languages:', Object.keys(window.languages));
        
        this.currentLang = localStorage.getItem('preferredLanguage') || 'en';
        console.log('LanguageManager: Current language set to', this.currentLang);
        
        // Initialize immediately if DOM is ready
        if (document.readyState === 'complete' || document.readyState === 'interactive') {
            console.log('LanguageManager: DOM already loaded, initializing...');
            this.init();
        } else {
            console.log('LanguageManager: Waiting for DOM to load...');
            document.addEventListener('DOMContentLoaded', () => {
                console.log('LanguageManager: DOM loaded, initializing...');
                this.init();
            });
        }
    }

    init() {
        console.log('LanguageManager: Starting initialization...');
        
        try {
            // Set initial language
            this.updateLanguage(this.currentLang);

            // Add click event listeners to language switcher buttons
            const languageButtons = document.querySelectorAll('[data-lang]');
            console.log('LanguageManager: Found', languageButtons.length, 'language buttons');
            
            if (languageButtons.length === 0) {
                console.error('LanguageManager: No language buttons found!');
                return;
            }
            
            languageButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    const lang = e.target.getAttribute('data-lang');
                    console.log('LanguageManager: Language button clicked:', lang);
                    
                    if (window.languages[lang]) {
                        this.updateLanguage(lang);
                    } else {
                        console.error('LanguageManager: Invalid language code:', lang);
                    }
                });
            });
            
            console.log('LanguageManager: Initialization complete');
        } catch (error) {
            console.error('LanguageManager: Error during initialization:', error);
        }
    }

    updateLanguage(lang) {
        console.log('LanguageManager: Updating language to', lang);
        
        if (!window.languages[lang]) {
            console.error('LanguageManager: Invalid language:', lang);
            return;
        }

        try {
            this.currentLang = lang;
            localStorage.setItem('preferredLanguage', lang);
            console.log('LanguageManager: Language saved to localStorage');

            // Update current language display
            const currentLangElement = document.getElementById('current-language');
            if (currentLangElement) {
                currentLangElement.textContent = window.languages[lang].name;
                console.log('LanguageManager: Updated current language display to:', window.languages[lang].name);
            } else {
                console.error('LanguageManager: Current language element not found');
            }

            // Update all translatable elements
            const translatableElements = document.querySelectorAll('[data-translate]');
            console.log('LanguageManager: Found', translatableElements.length, 'translatable elements');
            
            let updatedCount = 0;
            let missingTranslations = 0;
            
            translatableElements.forEach(element => {
                const key = element.getAttribute('data-translate');
                if (window.translations[lang] && window.translations[lang][key]) {
                    element.textContent = window.translations[lang][key];
                    updatedCount++;
                } else {
                    console.warn('LanguageManager: Translation not found for key:', key, 'in language:', lang);
                    missingTranslations++;
                }
            });
            
            console.log('LanguageManager: Updated', updatedCount, 'elements');
            if (missingTranslations > 0) {
                console.warn('LanguageManager: Missing', missingTranslations, 'translations');
            }

            // Update debug info
            this.showDebugInfo();
        } catch (error) {
            console.error('LanguageManager: Error updating language:', error);
        }
    }

    showDebugInfo() {
        try {
            const debugInfo = document.getElementById('debug-info');
            const debugLanguage = document.getElementById('debug-language');
            const debugElements = document.getElementById('debug-elements');
            
            if (debugInfo && debugLanguage && debugElements) {
                debugInfo.classList.remove('hidden');
                debugLanguage.textContent = this.currentLang;
                debugElements.textContent = document.querySelectorAll('[data-translate]').length;
                console.log('LanguageManager: Debug info updated');
            } else {
                console.warn('LanguageManager: Debug elements not found');
            }
        } catch (error) {
            console.error('LanguageManager: Error showing debug info:', error);
        }
    }
}

// Initialize the language manager
console.log('Starting language manager initialization...');
try {
    window.languageManager = new LanguageManager();
    console.log('Language manager initialized successfully');
} catch (error) {
    console.error('Failed to initialize LanguageManager:', error);
} 