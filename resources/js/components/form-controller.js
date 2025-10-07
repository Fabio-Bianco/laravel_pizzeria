/**
 * F * - Integrazione con API REST
 * - Accessibilità e UX ottimizzata
 * 
 * @author b_bot
 * @version 2.0
 * @requires Bootstrap 5.x
 */TROLLER
 

class FormController {
    /**
     * Inizializza il controller del form
     * @param {string|Element} formSelector - Selettore o elemento del form
     * @param {Object} config - Configurazione del controller
     */
    constructor(formSelector, config = {}) {
        this.form = typeof formSelector === 'string' 
            ? document.querySelector(formSelector) 
            : formSelector;
            
        if (!this.form) {
            console.error('FormController: Form non trovato');
            return;
        }
        
        this.config = {
            autoSave: true,
            autoSaveInterval: 30000, // 30 secondi
            validateOnChange: true,
            validateOnBlur: true,
            showProgressBar: true,
            enableFileUpload: true,
            apiEndpoint: null,
            customValidators: {},
            ...config
        };
        
        this.isInitialized = false;
        this.isDirty = false;
        this.isSubmitting = false;
        this.autoSaveTimer = null;
        this.uploadQueues = new Map();
        this.validationRules = new Map();
        
        // Binding dei metodi
        this.handleSubmit = this.handleSubmit.bind(this);
        this.handleInput = this.handleInput.bind(this);
        this.handleBlur = this.handleBlur.bind(this);
        this.handleFileUpload = this.handleFileUpload.bind(this);
        this.handleBeforeUnload = this.handleBeforeUnload.bind(this);
        
        this.init();
    }

    /**
     * Inizializza il controller del form
     */
    init() {
        if (this.isInitialized) {
            console.warn('FormController: Già inizializzato');
            return;
        }

        try {
            // Setup eventi base
            this.setupFormEvents();
            
            // Setup validazione
            this.setupValidation();
            
            // Setup file upload
            if (this.config.enableFileUpload) {
                this.setupFileUpload();
            }
            
            // Setup auto-save
            if (this.config.autoSave) {
                this.setupAutoSave();
            }
            
            // Setup campi dinamici
            this.setupDynamicFields();
            
            // Setup progress tracking
            if (this.config.showProgressBar) {
                this.setupProgressTracking();
            }
            
            // Setup accessibilità
            this.setupAccessibility();
            
            // Carica dati salvati
            this.loadSavedData();
            
            this.isInitialized = true;
            console.log('FormController: Inizializzato per form', this.form.id || this.form.className);
            
        } catch (error) {
            console.error('FormController: Errore durante inizializzazione', error);
        }
    }

    /**
     * Setup eventi base del form
     */
    setupFormEvents() {
        // Submit handler
        this.form.addEventListener('submit', this.handleSubmit);
        
        // Input change handlers
        const inputs = this.form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            if (this.config.validateOnChange) {
                input.addEventListener('input', this.handleInput);
            }
            
            if (this.config.validateOnBlur) {
                input.addEventListener('blur', this.handleBlur);
            }
            
            // Mark form as dirty quando l'utente modifica qualcosa
            input.addEventListener('change', () => {
                this.markAsDirty();
            });
        });
        
        // Previeni uscita accidentale con dati non salvati
        window.addEventListener('beforeunload', this.handleBeforeUnload);
    }

    /**
     * Setup sistema di validazione
     */
    setupValidation() {
        // Definisci regole di validazione base
        this.defineValidationRules();
        
        // Setup validazione HTML5 personalizzata
        const inputs = this.form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('invalid', (event) => {
                event.preventDefault();
                this.showFieldError(input, input.validationMessage);
            });
        });
    }

    /**
     * Definisce le regole di validazione
     */
    defineValidationRules() {
        // Email validation
        this.validationRules.set('email', {
            test: (value) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value),
            message: 'Inserire un indirizzo email valido'
        });
        
        // Telefono italiano
        this.validationRules.set('phone', {
            test: (value) => /^[\+]?[0-9\s\-\(\)]{8,20}$/.test(value),
            message: 'Inserire un numero di telefono valido'
        });
        
        // Codice fiscale italiano
        this.validationRules.set('codice-fiscale', {
            test: (value) => /^[A-Z]{6}[0-9]{2}[A-Z][0-9]{2}[A-Z][0-9]{3}[A-Z]$/.test(value.toUpperCase()),
            message: 'Inserire un codice fiscale valido'
        });
        
        // Partita IVA italiana
        this.validationRules.set('partita-iva', {
            test: (value) => /^[0-9]{11}$/.test(value),
            message: 'Inserire una partita IVA valida (11 cifre)'
        });
        
        // Password forte
        this.validationRules.set('strong-password', {
            test: (value) => /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(value),
            message: 'La password deve contenere almeno 8 caratteri, una maiuscola, una minuscola, un numero e un carattere speciale'
        });
        
        // Merge con validatori custom
        Object.entries(this.config.customValidators).forEach(([name, validator]) => {
            this.validationRules.set(name, validator);
        });
    }

    /**
     * Gestisce l'evento submit del form
     * @param {Event} event - Evento submit
     */
    async handleSubmit(event) {
        event.preventDefault();
        
        if (this.isSubmitting) {
            console.log('Form già in submit, ignorato');
            return;
        }
        
        // Disabilita il submit button
        const submitBtn = this.form.querySelector('button[type="submit"], input[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            this.showSubmitProgress(submitBtn, true);
        }
        
        this.isSubmitting = true;
        
        try {
            // Validazione completa del form
            const isValid = await this.validateForm();
            
            if (!isValid) {
                this.showNotification('Correggere gli errori nel form', 'error');
                return;
            }
            
            // Raccoglie i dati del form
            const formData = this.collectFormData();
            
            // Submit dei dati
            const result = await this.submitFormData(formData);
            
            if (result.success) {
                this.showNotification('Dati salvati con successo', 'success');
                this.markAsClean();
                
                // Redirect se specificato
                if (result.redirect) {
                    setTimeout(() => {
                        window.location.href = result.redirect;
                    }, 1000);
                }
            } else {
                throw new Error(result.message || 'Errore durante il salvataggio');
            }
            
        } catch (error) {
            console.error('Errore submit form:', error);
            this.showNotification(error.message || 'Errore durante il salvataggio', 'error');
            
            // Mostra errori specifici dei campi se disponibili
            if (error.fieldErrors) {
                this.showFieldErrors(error.fieldErrors);
            }
            
        } finally {
            this.isSubmitting = false;
            
            // Riabilita submit button
            if (submitBtn) {
                submitBtn.disabled = false;
                this.showSubmitProgress(submitBtn, false);
            }
        }
    }

    /**
     * Gestisce input in tempo reale
     * @param {Event} event - Evento input
     */
    handleInput(event) {
        const field = event.target;
        
        // Debounce per evitare validazioni eccessive
        clearTimeout(field.validationTimeout);
        field.validationTimeout = setTimeout(() => {
            this.validateField(field);
        }, 300);
    }

    /**
     * Gestisce blur dei campi
     * @param {Event} event - Evento blur
     */
    handleBlur(event) {
        const field = event.target;
        this.validateField(field);
    }

    /**
     * Valida un singolo campo
     * @param {Element} field - Campo da validare
     * @returns {boolean} True se valido
     */
    validateField(field) {
        const value = field.value.trim();
        const fieldName = field.name || field.id;
        
        // Rimuovi errori precedenti
        this.clearFieldError(field);
        
        // Validazione required
        if (field.hasAttribute('required') && !value) {
            this.showFieldError(field, 'Questo campo è obbligatorio');
            return false;
        }
        
        // Skip ulteriori validazioni se campo vuoto e non required
        if (!value) {
            return true;
        }
        
        // Validazione lunghezza minima
        const minLength = field.getAttribute('minlength');
        if (minLength && value.length < parseInt(minLength)) {
            this.showFieldError(field, `Minimo ${minLength} caratteri`);
            return false;
        }
        
        // Validazione lunghezza massima
        const maxLength = field.getAttribute('maxlength');
        if (maxLength && value.length > parseInt(maxLength)) {
            this.showFieldError(field, `Massimo ${maxLength} caratteri`);
            return false;
        }
        
        // Validazione pattern HTML5
        const pattern = field.getAttribute('pattern');
        if (pattern && !new RegExp(pattern).test(value)) {
            this.showFieldError(field, field.getAttribute('title') || 'Formato non valido');
            return false;
        }
        
        // Validazioni custom per tipo di campo
        const validationType = field.getAttribute('data-validation');
        if (validationType && this.validationRules.has(validationType)) {
            const rule = this.validationRules.get(validationType);
            if (!rule.test(value)) {
                this.showFieldError(field, rule.message);
                return false;
            }
        }
        
        // Validazione conferma password
        if (field.type === 'password' && field.name.includes('confirm')) {
            const passwordField = this.form.querySelector('input[type="password"]:not([name*="confirm"])');
            if (passwordField && value !== passwordField.value) {
                this.showFieldError(field, 'Le password non coincidono');
                return false;
            }
        }
        
        // Validazione HTML5 nativa
        if (!field.checkValidity()) {
            this.showFieldError(field, field.validationMessage);
            return false;
        }
        
        // Campo valido
        this.showFieldSuccess(field);
        return true;
    }

    /**
     * Valida l'intero form
     * @returns {Promise<boolean>} True se tutto il form è valido
     */
    async validateForm() {
        const fields = this.form.querySelectorAll('input, select, textarea');
        let isValid = true;
        
        for (const field of fields) {
            if (!this.validateField(field)) {
                isValid = false;
            }
        }
        
        // Focus sul primo campo con errore
        if (!isValid) {
            const firstError = this.form.querySelector('.is-invalid');
            if (firstError) {
                firstError.focus();
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
        
        return isValid;
    }

    /**
     * Mostra errore su un campo
     * @param {Element} field - Campo con errore
     * @param {string} message - Messaggio di errore
     */
    showFieldError(field, message) {
        field.classList.remove('is-valid');
        field.classList.add('is-invalid');
        
        // Trova o crea elemento feedback
        let feedback = field.parentNode.querySelector('.invalid-feedback');
        if (!feedback) {
            feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            field.parentNode.appendChild(feedback);
        }
        
        feedback.textContent = message;
        feedback.style.display = 'block';
        
        // Update aria attributes per accessibilità
        field.setAttribute('aria-invalid', 'true');
        field.setAttribute('aria-describedby', feedback.id || 'error-' + (field.name || field.id));
    }

    /**
     * Mostra successo su un campo
     * @param {Element} field - Campo valido
     */
    showFieldSuccess(field) {
        field.classList.remove('is-invalid');
        field.classList.add('is-valid');
        
        // Nascondi errori
        const feedback = field.parentNode.querySelector('.invalid-feedback');
        if (feedback) {
            feedback.style.display = 'none';
        }
        
        // Update aria attributes
        field.removeAttribute('aria-invalid');
    }

    /**
     * Rimuove indicatori di errore da un campo
     * @param {Element} field - Campo da pulire
     */
    clearFieldError(field) {
        field.classList.remove('is-invalid', 'is-valid');
        
        const feedback = field.parentNode.querySelector('.invalid-feedback');
        if (feedback) {
            feedback.style.display = 'none';
        }
        
        field.removeAttribute('aria-invalid');
    }

    /**
     * Setup file upload con progress
     */
    setupFileUpload() {
        const fileInputs = this.form.querySelectorAll('input[type="file"]');
        
        fileInputs.forEach(input => {
            input.addEventListener('change', this.handleFileUpload);
            
            // Drag & drop se supportato
            this.setupDragDrop(input);
            
            // Preview per immagini
            if (input.accept && input.accept.includes('image/')) {
                this.setupImagePreview(input);
            }
        });
    }

    /**
     * Gestisce upload file
     * @param {Event} event - Evento change del file input
     */
    async handleFileUpload(event) {
        const input = event.target;
        const files = Array.from(input.files);
        
        if (files.length === 0) return;
        
        // Validazione file
        const validFiles = files.filter(file => this.validateFile(file, input));
        
        if (validFiles.length === 0) {
            input.value = ''; // Reset input
            return;
        }
        
        // Upload file uno per volta
        for (const file of validFiles) {
            await this.uploadFile(file, input);
        }
    }

    /**
     * Valida un file
     * @param {File} file - File da validare
     * @param {Element} input - Input element
     * @returns {boolean} True se valido
     */
    validateFile(file, input) {
        // Validazione tipo MIME
        const acceptedTypes = input.accept ? input.accept.split(',').map(type => type.trim()) : [];
        if (acceptedTypes.length > 0) {
            const isValidType = acceptedTypes.some(type => {
                if (type.startsWith('.')) {
                    return file.name.toLowerCase().endsWith(type.toLowerCase());
                } else {
                    return file.type.match(type.replace('*', '.*'));
                }
            });
            
            if (!isValidType) {
                this.showNotification(`Tipo file non supportato: ${file.name}`, 'error');
                return false;
            }
        }
        
        // Validazione dimensione
        const maxSize = input.getAttribute('data-max-size');
        if (maxSize) {
            const maxSizeBytes = parseInt(maxSize) * 1024 * 1024; // MB to bytes
            if (file.size > maxSizeBytes) {
                this.showNotification(`File troppo grande: ${file.name} (max ${maxSize}MB)`, 'error');
                return false;
            }
        }
        
        return true;
    }

    /**
     * Upload di un singolo file
     * @param {File} file - File da uploadare
     * @param {Element} input - Input element
     */
    async uploadFile(file, input) {
        const formData = new FormData();
        formData.append('file', file);
        formData.append('field', input.name);
        
        // Crea progress bar
        const progressContainer = this.createProgressBar(input, file.name);
        
        try {
            const response = await fetch('/api/upload', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            const result = await response.json();
            
            if (result.success) {
                this.showUploadSuccess(progressContainer, result.url);
                
                // Salva URL del file in un campo hidden
                this.saveFileUrl(input, result.url);
                
            } else {
                throw new Error(result.message || 'Errore upload');
            }
            
        } catch (error) {
            console.error('Errore upload file:', error);
            this.showUploadError(progressContainer, error.message);
        }
    }

    /**
     * Crea una progress bar per upload
     * @param {Element} input - Input element
     * @param {string} fileName - Nome del file
     * @returns {Element} Container della progress bar
     */
    createProgressBar(input, fileName) {
        const container = document.createElement('div');
        container.className = 'upload-progress mt-2';
        container.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-1">
                <small class="text-muted">${fileName}</small>
                <small class="upload-status">Caricamento...</small>
            </div>
            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated" 
                     role="progressbar" style="width: 0%"></div>
            </div>
        `;
        
        input.parentNode.appendChild(container);
        return container;
    }

    /**
     * Setup auto-save automatico
     */
    setupAutoSave() {
        // Auto-save timer
        this.autoSaveTimer = setInterval(() => {
            if (this.isDirty && !this.isSubmitting) {
                this.performAutoSave();
            }
        }, this.config.autoSaveInterval);
        
        // Visual feedback per auto-save
        this.createAutoSaveIndicator();
    }

    /**
     * Esegue auto-save
     */
    async performAutoSave() {
        try {
            const formData = this.collectFormData();
            
            // Mostra indicatore auto-save
            this.showAutoSaveStatus('saving');
            
            const response = await fetch('/api/autosave', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    form_id: this.form.id || 'form_' + Date.now(),
                    data: formData
                })
            });
            
            const result = await response.json();
            
            if (result.success) {
                this.showAutoSaveStatus('saved');
                this.markAsClean();
            } else {
                this.showAutoSaveStatus('error');
            }
            
        } catch (error) {
            console.error('Errore auto-save:', error);
            this.showAutoSaveStatus('error');
        }
    }

    /**
     * Raccoglie tutti i dati del form
     * @returns {Object} Dati del form
     */
    collectFormData() {
        const formData = new FormData(this.form);
        const data = {};
        
        // Converti FormData in oggetto normale
        for (const [key, value] of formData.entries()) {
            if (data.hasOwnProperty(key)) {
                // Campo multiplo (checkbox, select multiple)
                if (Array.isArray(data[key])) {
                    data[key].push(value);
                } else {
                    data[key] = [data[key], value];
                }
            } else {
                data[key] = value;
            }
        }
        
        return data;
    }

    /**
     * Submit dati del form via API
     * @param {Object} formData - Dati da inviare
     * @returns {Promise<Object>} Risultato del submit
     */
    async submitFormData(formData) {
        const endpoint = this.config.apiEndpoint || this.form.action;
        const method = this.form.method || 'POST';
        
        const response = await fetch(endpoint, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(formData)
        });
        
        if (!response.ok) {
            const error = await response.json();
            throw new Error(error.message || 'Errore server');
        }
        
        return await response.json();
    }

    /**
     * Marca il form come modificato
     */
    markAsDirty() {
        this.isDirty = true;
        this.form.classList.add('form-dirty');
    }

    /**
     * Marca il form come salvato
     */
    markAsClean() {
        this.isDirty = false;
        this.form.classList.remove('form-dirty');
    }

    /**
     * Gestisce evento beforeunload
     * @param {Event} event - Evento beforeunload
     */
    handleBeforeUnload(event) {
        if (this.isDirty) {
            const message = 'Ci sono modifiche non salvate. Uscire comunque?';
            event.returnValue = message;
            return message;
        }
    }

    /**
     * Mostra notifica
     * @param {string} message - Messaggio
     * @param {string} type - Tipo (success, error, warning, info)
     */
    showNotification(message, type = 'info') {
        // Implementazione notifica (toast, alert, etc.)
        const toast = document.createElement('div');
        toast.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show position-fixed`;
        toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999;';
        toast.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(toast);
        
        // Auto remove dopo 5 secondi
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 5000);
    }

    /**
     * Distrugge il controller e pulisce le risorse
     */
    destroy() {
        if (!this.isInitialized) return;
        
        // Clear auto-save timer
        if (this.autoSaveTimer) {
            clearInterval(this.autoSaveTimer);
        }
        
        // Rimuovi event listeners
        this.form.removeEventListener('submit', this.handleSubmit);
        window.removeEventListener('beforeunload', this.handleBeforeUnload);
        
        // Clear upload queues
        this.uploadQueues.clear();
        
        // Remove dirty state
        this.markAsClean();
        
        this.isInitialized = false;
        console.log('FormController: Distrutto');
    }
}

// Export per utilizzo come modulo ES6
export default FormController;

// Auto-inizializzazione per form con data-form-controller
if (typeof module === 'undefined') {
    document.addEventListener('DOMContentLoaded', () => {
        const forms = document.querySelectorAll('[data-form-controller]');
        forms.forEach(form => {
            new FormController(form);
        });
    });
}