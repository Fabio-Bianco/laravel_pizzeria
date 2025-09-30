# Pizzeria Backend (Laravel)

Backend Laravel per gestione pizzeria con:
- Backoffice amministrativo (Blade + Breeze) su URL non prefissati (`/categories`, `/pizzas`, …) ma con nomi di rotta namespaced `admin.*`
- API JSON versionate per frontend React sotto `/api/v1/*` con nomi di rotta prefissati `guest.*`

## Requisiti
- PHP 8.2+
- Composer
- Database MySQL (o SQLite, con adattamenti `.env`)

## Setup rapido
1. Clona il repo e installa le dipendenze
	 - `composer install`
2. Configura l’ambiente in `.env`
	 - `APP_URL=http://localhost:8000`
	 - `DB_CONNECTION=mysql` (o sqlite)
	 - `SESSION_DRIVER=database`
	 - `FRONTEND_URL=http://localhost:5173` (dominio React in dev)
3. Genera chiave app (se necessario)
	 - `php artisan key:generate`
4. Migrazioni + seed demo
	 - `php artisan migrate --seed`
5. Avvio server
	 - `php artisan serve` (se porta occupata: `php artisan serve --port=8001`)

## Utente di test
- Email: `test@example.com`
- Password: `password`

Se non accedi, reimposta via Tinker:
```
php artisan tinker
use App\Models\User;
use Illuminate\Support\Facades\Hash;
User::where('email','test@example.com')->update(['password'=>Hash::make('password')]);
```

## Struttura
- Backoffice (Blade, sessioni) → Rotte `web` agli URL: `/categories`, `/pizzas`, `/ingredients`, `/allergens` (nomi: `admin.categories.*`, `admin.pizzas.*`, …)
- API (JSON, stateless) → Rotte `api` agli URL: `/api/v1/*` (nomi: `guest.categories.*`, `guest.pizzas.*`, …)
- Autenticazione backoffice: Breeze (login/logout, profilo)
- Relazioni:
	- Category hasMany Pizza
	- Pizza belongsTo Category, belongsToMany Ingredient
	- Ingredient belongsToMany Pizza, belongsToMany Allergen
	- Allergen belongsToMany Ingredient

## Backoffice (Blade) – Rotte principali
- `/categories` (CRUD) – nome base: `admin.categories.*`
- `/pizzas` (CRUD) – nome base: `admin.pizzas.*`
- `/ingredients` (CRUD) – nome base: `admin.ingredients.*`
- `/allergens` (CRUD) – nome base: `admin.allergens.*`

Tutte protette da login. Dashboard su `/dashboard`.

## API (JSON) – Rotte principali (v1)
Base URL: `/api/v1` – nomi delle rotte: `guest.*`

Rispondono JSON e supportano i metodi REST standard.

### Categories
- GET `/categories` → lista paginata
- POST `/categories` → crea
- GET `/categories/{id}` → dettaglio
- PUT/PATCH `/categories/{id}` → aggiorna
- DELETE `/categories/{id}` → elimina

Esempio richiesta creazione:
```json
POST /api/v1/categories
{
	"name": "Classiche",
	"description": "Le pizze più amate"
}
```
Risposta 201:
```json
{
	"id": 1,
	"name": "Classiche",
	"slug": "classiche",
	"description": "Le pizze più amate",
	"created_at": "2025-09-29T09:00:00.000000Z",
	"updated_at": "2025-09-29T09:00:00.000000Z"
}
```

Nomi di rotta utili (esempi):
- `route('guest.categories.index')` → GET /api/v1/categories
- `route('guest.categories.store')` → POST /api/v1/categories
- `route('guest.categories.show', id)` → GET /api/v1/categories/{id}

### Pizzas
- GET `/pizzas` → lista con `category`, `ingredients`
- POST `/pizzas` → crea (campi: `name`, `price`, `description?`, `category_id?`, `ingredients?` array di id)
- GET `/pizzas/{id}` → dettaglio
- PUT/PATCH `/pizzas/{id}` → aggiorna (stessi campi di POST)
- DELETE `/pizzas/{id}` → elimina

Esempio richiesta creazione:
```json
POST /api/v1/pizzas
{
	"name": "Margherita",
	"price": 6.5,
	"category_id": 1,
	"ingredients": [1, 2, 3]
}
```
Risposta 201 (estratto):
```json
{
	"id": 1,
	"name": "Margherita",
	"slug": "margherita",
	"price": 6.5,
	"category": { "id": 1, "name": "Classiche" },
	"ingredients": [ {"id":1,"name":"Pomodoro"}, ... ]
}
```

### Ingredients
- GET `/ingredients` → lista con `allergens`
- POST `/ingredients` → crea (campi: `name`, `allergens?` array di id)
- GET `/ingredients/{id}` → dettaglio
- PUT/PATCH `/ingredients/{id}` → aggiorna
- DELETE `/ingredients/{id}` → elimina

### Allergens
- GET `/allergens`
- POST `/allergens`
- GET `/allergens/{id}`
- PUT/PATCH `/allergens/{id}`
- DELETE `/allergens/{id}`

## CORS
Configurato in `config/cors.php` per permettere l’origine del frontend React. Impostare l’URL nel `.env`:
```
FRONTEND_URL=http://localhost:5173
```

## Dev tips
- Se `php artisan serve` fallisce per porta occupata: `php artisan serve --port=8001`
- Per vedere le rotte: `php artisan route:list`
- Esempi di nomi rotta
	- Web: `admin.categories.index`, `admin.pizzas.edit`, …
	- API: `guest.categories.index`, `guest.pizzas.store`, …
- Slug: generato automaticamente da `name`; attualmente unico: evitare duplicati di nome o gestire suffissi.

## Roadmap / ToDo
- [ ] Policy / Ruoli (es. admin) per il backoffice
- [ ] FormRequest dedicati per validazione
- [ ] Test di feature API
- [ ] Autenticazione API per SPA (Sanctum) se richiesto
- [ ] Paginazione e filtri avanzati per liste API

---

MIT License
