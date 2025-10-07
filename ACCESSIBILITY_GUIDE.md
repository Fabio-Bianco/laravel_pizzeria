# 🎯 SISTEMA DI ACCESSIBILITÀ PER RISTORATORI ANALFABETI DIGITALI
## WCAG 2.1 AAA COMPLIANT

---

## 📋 **GUIDA RAPIDA AI COLORI**

### 🟢 **VERDE = CREO/SALVO QUALCOSA**
- **Quando usare**: Aggiungere pizza al menu, salvare modifiche, confermare ordine
- **Classi CSS**: `.btn-create`, `.btn-save`, `.btn-success`
- **Esempio**: "Aggiungi Pizza", "Salva Menu", "Conferma Ordine"

### 🔴 **ROSSO = ELIMINO QUALCOSA**  
- **Quando usare**: Rimuovere pizza dal menu, cancellare ordine, eliminare utente
- **Classi CSS**: `.btn-delete`, `.btn-remove`, `.btn-danger`
- **Esempio**: "Elimina Pizza", "Cancella Ordine", "Rimuovi dal Menu"

### 🔵 **BLU = GUARDO/LEGGO QUALCOSA**
- **Quando usare**: Vedere dettagli ordine, visualizzare menu, leggere recensioni
- **Classi CSS**: `.btn-view`, `.btn-details`, `.btn-info`, `.btn-primary`
- **Esempio**: "Vedi Dettagli", "Mostra Menu", "Leggi Recensione"

### 🟡 **GIALLO = MODIFICO QUALCOSA**
- **Quando usare**: Cambiare prezzo pizza, modificare orari, aggiornare info
- **Classi CSS**: `.btn-edit`, `.btn-modify`, `.btn-warning`
- **Esempio**: "Modifica Prezzo", "Cambia Orari", "Aggiorna Info"

### ⚫ **GRIGIO = NEUTRO/ANNULLO**
- **Quando usare**: Tornare indietro, annullare operazione, reset form
- **Classi CSS**: `.btn-cancel`, `.btn-back`, `.btn-secondary`, `.btn-neutral`
- **Esempio**: "Annulla", "Torna Indietro", "Reset"

---

## 🎨 **STANDARD ACCESSIBILITÀ IMPLEMENTATI**

### ✅ **WCAG 2.1 AAA Compliance**
- **Contrasto colori**: Minimo 7:1 (superato standard 4.5:1)
- **Touch targets**: Minimo 44px per dispositivi touch
- **Focus visibile**: Outline ben visibile per navigazione da tastiera
- **Text scalabile**: Funziona fino a 200% zoom
- **Color independence**: Non solo colore per trasmettere informazioni

### ✅ **Keyboard Navigation**
- **Tab order**: Sequenza logica di navigazione
- **Skip links**: Salta al contenuto principale
- **Focus trap**: Focus rimane nella sidebar mobile quando aperta
- **Escape key**: Chiude modali e sidebar

### ✅ **Screen Reader Support**
- **ARIA labels**: Descrizioni per elementi interattivi
- **Semantic HTML**: Header, nav, main, section corretti
- **Live regions**: Annunci per messaggi dinamici
- **Hidden decorative**: Icone decorative nascoste ai screen reader

### ✅ **Mobile Optimized**
- **Touch targets**: Bottoni grandi per pollici
- **Readable fonts**: Dimensioni leggibili su piccoli schermi
- **Responsive design**: Adattamento a tutte le dimensioni
- **One-handed use**: Navigazione con una mano

---

## 🛠 **COME USARE IL SISTEMA**

### **Per Sviluppatori:**

```html
<!-- ✅ GIUSTO: Bottone semantico -->
<button class="btn btn-create" type="submit">
    <i class="fas fa-plus" aria-hidden="true"></i>
    Aggiungi Pizza
</button>

<!-- ❌ SBAGLIATO: Colori generici -->
<button class="btn btn-primary">Bottone</button>
```

### **Classi Principali:**

```css
/* Azioni semantiche */
.btn-create    /* Verde - Creare */
.btn-delete    /* Rosso - Eliminare */
.btn-view      /* Blu - Visualizzare */
.btn-edit      /* Giallo - Modificare */
.btn-cancel    /* Grigio - Annullare */

/* Dimensioni */
.btn-sm        /* Piccolo: 40px */
.btn           /* Normale: 44px */
.btn-lg        /* Grande: 56px */
.btn-xl        /* Extra: 64px */

/* Varianti */
.btn-outline-success  /* Contorno verde */
.badge-success        /* Badge verde */
```

### **ARIA e Accessibility:**

```html
<!-- Skip link (sempre primo elemento) -->
<a href="#main-content" class="skip-link">Salta al contenuto</a>

<!-- Bottoni con ARIA -->
<button 
    class="btn btn-edit"
    aria-label="Modifica pizza Margherita"
    aria-describedby="help-text">
    Modifica
</button>

<!-- Form accessibili -->
<label for="pizza-name" class="form-label required">
    Nome Pizza
</label>
<input 
    type="text" 
    id="pizza-name" 
    class="form-control"
    aria-required="true"
    aria-describedby="name-help">
<div id="name-help" class="form-text">
    Inserisci il nome della pizza (es. Margherita)
</div>
```

---

## 🔍 **TESTING ACCESSIBILITÀ**

### **Keyboard Navigation:**
1. Usa solo **TAB** per navigare
2. **INVIO** e **SPAZIO** per attivare
3. **ESC** per chiudere modali
4. **Frecce** per menu dropdown

### **Screen Reader:**
1. Testa con **NVDA** (gratuito) o **JAWS**
2. Controlla che tutto sia annunciato correttamente
3. Verifica skip links funzionanti

### **Color Contrast:**
1. Usa **WebAIM Color Contrast Checker**
2. Verifica minimo 7:1 per testo normale
3. Verifica minimo 4.5:1 per testo grande

### **Mobile Testing:**
1. Touch targets minimo 44px
2. Testa con pollice su veri dispositivi
3. Zoom fino a 200% deve funzionare

---

## 📱 **ESEMPI PRATICI PER RISTORATORE**

### **Scenario: Aggiungere una nuova pizza**
```html
<a href="/admin/pizzas/create" class="btn btn-create btn-lg">
    <i class="fas fa-plus" aria-hidden="true"></i>
    Aggiungi Nuova Pizza
</a>
```
**Perché Verde**: Stai CREANDO qualcosa di nuovo

### **Scenario: Modificare prezzo pizza**
```html
<button class="btn btn-edit" onclick="editPrice({{ $pizza->id }})">
    <i class="fas fa-edit" aria-hidden="true"></i>
    Modifica Prezzo
</button>
```
**Perché Giallo**: Stai MODIFICANDO qualcosa di esistente

### **Scenario: Eliminare pizza dal menu**
```html
<form method="POST" action="/admin/pizzas/{{ $pizza->id }}">
    @csrf @method('DELETE')
    <button class="btn btn-delete" type="submit" 
            onclick="return confirm('Sei sicuro?')">
        <i class="fas fa-trash" aria-hidden="true"></i>
        Elimina Pizza
    </button>
</form>
```
**Perché Rosso**: Stai ELIMINANDO qualcosa per sempre

### **Scenario: Vedere dettagli ordine**
```html
<a href="/admin/orders/{{ $order->id }}" class="btn btn-view">
    <i class="fas fa-eye" aria-hidden="true"></i>
    Vedi Dettagli Ordine
</a>
```
**Perché Blu**: Stai GUARDANDO/LEGGENDO informazioni

---

## 🚀 **PERFORMANCE E OTTIMIZZAZIONE**

### **CSS Ottimizzato:**
- ✅ Variabili CSS per consistenza
- ✅ NO `!important` (tranne casi specifici)
- ✅ Mobile-first responsive
- ✅ Prefers-reduced-motion support
- ✅ Print styles inclusi

### **JavaScript Leggero:**
- ✅ Focus management automatico
- ✅ Keyboard traps per modali
- ✅ Event delegation efficiente
- ✅ Polyfill per browser legacy

### **Vite Build Ottimizzato:**
- ✅ CSS separato per cache migliore
- ✅ Tree-shaking automatico
- ✅ Minificazione avanzata
- ✅ Code splitting intelligente

---

## ⚡ **QUICK REFERENCE**

| Azione | Colore | Classe CSS | Esempio |
|--------|--------|------------|---------|
| Creare | 🟢 Verde | `.btn-create` | Aggiungi Pizza |
| Eliminare | 🔴 Rosso | `.btn-delete` | Elimina Pizza |
| Visualizzare | 🔵 Blu | `.btn-view` | Vedi Dettagli |
| Modificare | 🟡 Giallo | `.btn-edit` | Modifica Prezzo |
| Annullare | ⚫ Grigio | `.btn-cancel` | Annulla |

**🎯 Ricorda**: Se un ristoratore può capire subito cosa fa un bottone dal colore, hai fatto il tuo lavoro!

---

*Questo sistema è stato progettato specificatamente per ristoratori che potrebbero non essere esperti di tecnologia, garantendo al tempo stesso la massima accessibilità per tutti gli utenti.*