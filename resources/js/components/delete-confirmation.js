/**
 * Sistema unobtrusivo per conferma eliminazione
 * Gestisce tutti i form DELETE con event delegation
 * WCAG 2.1 AAA compliant
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Event delegation per tutti i form DELETE
    document.addEventListener('submit', function(e) {
        const form = e.target;
        
        // Verifica se è un form DELETE
        if (form.tagName === 'FORM' && form.querySelector('input[name="_method"][value="DELETE"]')) {
            e.preventDefault();
            
            // Estrai il nome dell'item dal form action o data attribute
            const itemName = form.dataset.itemName || 'questo elemento';
            const message = `Eliminare definitivamente "${itemName}"?`;
            
            // Mostra conferma accessibile
            showAccessibleConfirm(message)
                .then(confirmed => {
                    if (confirmed) {
                        // Rimuovi il listener per evitare loop
                        form.removeEventListener('submit', arguments.callee);
                        form.submit();
                    }
                });
        }
    });
    
    // Conferma accessibile con focus management
    function showAccessibleConfirm(message) {
        return new Promise((resolve) => {
            const previousFocus = document.activeElement;
            
            // Crea modal di conferma accessibile
            const modal = createConfirmModal(message, resolve, previousFocus);
            document.body.appendChild(modal);
            
            // Trigger bootstrap modal
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
        });
    }
    
    function createConfirmModal(message, resolve, previousFocus) {
        const modalId = 'confirm-delete-modal';
        
        const modal = document.createElement('div');
        modal.className = 'modal fade';
        modal.id = modalId;
        modal.setAttribute('tabindex', '-1');
        modal.setAttribute('aria-labelledby', modalId + '-title');
        modal.setAttribute('aria-hidden', 'true');
        modal.setAttribute('role', 'dialog');
        modal.setAttribute('aria-modal', 'true');
        
        modal.innerHTML = `
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger bg-opacity-10">
                        <h5 class="modal-title fw-bold text-danger" id="${modalId}-title">
                            <i class="fas fa-exclamation-triangle me-2" aria-hidden="true"></i>
                            Conferma Eliminazione
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Annulla"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-3">${message}</p>
                        <div class="alert alert-warning d-flex align-items-center">
                            <i class="fas fa-info-circle me-2" aria-hidden="true"></i>
                            <small>Questa azione non può essere annullata.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1" aria-hidden="true"></i>
                            Annulla
                        </button>
                        <button type="button" class="btn btn-danger delete-confirm-btn">
                            <i class="fas fa-trash me-1" aria-hidden="true"></i>
                            Elimina Definitivamente
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        // Event listeners per i bottoni
        const cancelBtn = modal.querySelector('[data-bs-dismiss="modal"]');
        const confirmBtn = modal.querySelector('.delete-confirm-btn');
        
        cancelBtn.addEventListener('click', () => {
            resolve(false);
            cleanupModal();
        });
        
        confirmBtn.addEventListener('click', () => {
            resolve(true);
            cleanupModal();
        });
        
        // Gestione ESC e cleanup
        modal.addEventListener('hidden.bs.modal', () => {
            cleanupModal();
        });
        
        function cleanupModal() {
            modal.remove();
            if (previousFocus) {
                previousFocus.focus();
            }
        }
        
        // Focus al primo elemento
        modal.addEventListener('shown.bs.modal', () => {
            confirmBtn.focus();
        });
        
        return modal;
    }
    
    console.log('✅ Sistema conferma eliminazione caricato');
});

export default {};