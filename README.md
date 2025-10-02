 🎯 ## Come funziona il sistema:

 👨‍🍳 PANNELLO ADMIN:
1. Staff seleziona ingredienti → Allergeni automatici calcolati
2. Staff aggiunge allergeni extra → Override manuali  
3. Sistema salva entrambi → Database aggiornato

📱 MENU QR:
1. Cliente vede pizza/antipasto → API chiama getAllAllergens()
2. Sistema merge automatici + manuali → Lista finale senza duplicati
3. Cliente visualizza allergeni completi → Scelta informata

🎯  Come funziona per lo staff:

👨‍🍳 STAFF PIZZERIA:
1. Seleziona ingredienti → Vede allergeni automatici (gialli)
2. Aggiunge allergeni extra → Checkboxes per casi speciali
3. Vede preview finale → Esattamente quello che vedrann

📱 Risultato per clienti:
Il menu QR mostrerà gli allergeni finali (automatici + manuali) tramite il metodo getAllAllergens() che abbiamo implementato nei modell