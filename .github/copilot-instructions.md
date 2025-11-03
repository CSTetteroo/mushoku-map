# Copilot instructions for mushoku-map

This is a Laravel 10 app that renders a static world map with Leaflet and serves a small JSON API to manage places, travels, and visits.

## Big picture
- Frontend: a single Blade view `resources/views/map.blade.php` using Leaflet (CDN) with an image overlay `public/images/highresmapclearonteal.png` and Simple CRS. All coordinates are in image pixels: `[y, x]` pairs.
- Backend: Eloquent models + thin API controllers under `App\Http\Controllers\Api` returning raw JSON (Eloquent models/collections). No custom transformers.
- Data flow: View fetches from `/api/*` endpoints, renders markers and polylines, and posts new place visits.

## Domain model (files and shapes)
- `Place { id, name, description?, x: float, y: float }` → model `app/Models/Place.php`, table `places` (migration `2025_10_31_092917_create_places_table.php`).
  - Relationship: `Place::visits()` hasMany `PlaceVisit`.
- `PlaceVisit { id, place_id, travel_number?, story_time?, reason? }` → model `app/Models/PlaceVisit.php`, table `place_visits` (`2025_10_31_153751_place_visits.php`).
  - Relationship: `PlaceVisit::place()` belongsTo `Place`.
- `Travels { id, name?, type?, color='red', reason?, path: [[y,x], ...] }` → model `app/Models/Travels.php`, table `travels` (`2025_10_31_092918_create_travel_table.php`). `path` is cast to array.

## API surface (canonical)
- Declared in `routes/api.php` using `Route::apiResource`:
  - `GET /api/places` (list), `POST /api/places`, `GET /api/places/{id}` (includes `visits`), `PUT/PATCH /api/places/{id}`, `DELETE /api/places/{id}`.
  - `GET /api/travels`, `POST /api/travels`, `PUT/PATCH /api/travels/{id}`, `DELETE /api/travels/{id}`.
  - `GET /api/place-visits`, `POST /api/place-visits`, `DELETE /api/place-visits/{id}`.
  - Extra: `GET /api/places/{place}/visits` returns visits for a place ordered by `travel_number`.
- Note: `routes/web.php` defines `/map` view and duplicate `GET /places` and `/travels` routes; use the `/api/*` endpoints from the frontend.

## Controller patterns
- Thin controllers with built-in validation and direct Eloquent returns. Examples:
  - Create place: validate `name, x, y` and `Place::create($data)`.
  - Create travel: validate `path` as array of `[y,x]` pairs; other fields are optional strings.
  - `PlaceController@show` returns `$place->load('visits')`.

## Frontend conventions
- Leaflet Simple CRS; map size is fixed (`width=2882`, `height=2048`). Markers created as `[y,x]` to match Leaflet `[lat, lng]` ordering under Simple CRS.
- `travels.path` rendered with `L.polyline(t.path, { color: t.color })`.
- `Add Visit` posts to `/api/place-visits` with `{ place_id, travel_number?, reason?, story_time? }` then reloads.

## Local dev workflows (Windows PowerShell)
- Install deps: `composer install`; `npm install`.
- Configure env: Copy `.env.example` to `.env`; set DB; then `php artisan key:generate`.
- Database: `php artisan migrate`; (optional) seeders are present but `DatabaseSeeder` is empty. `MapSeeder.php` is outdated (uses `lat/lng` and `from_place_id` not present in current schema).
- Run: `php artisan serve` (map at `http://localhost:8000/map`); Vite isn’t required for `map.blade.php`, but for asset changes run `npm run dev`.
- Tests: `php artisan test` (PHPUnit 10 configured via `phpunit.xml`).

## Examples
- POST `/api/places`
  ```json
  { "name":"Roa", "description":"Eris mansion", "x": 123.4, "y": 567.8 }
  ```
- POST `/api/travels`
  ```json
  { "type":"Ship", "color":"blue", "reason":"To Millis", "path": [[100,200],[150,300],[210,280]] }
  ```
- POST `/api/place-visits`
  ```json
  { "place_id": 1, "travel_number": 16, "story_time": "After Demon Continent", "reason": "Reunion" }
  ```

## Gotchas & conventions
- Coordinates are image pixels; keep the `[y,x]` order across DB and frontend.
- Prefer `/api/*` endpoints from the client; avoid duplicating logic in web routes.
- Keep `$fillable` in models in sync with migrations when adding fields.
- Public API is unauthenticated except the default `/api/user` Sanctum route.

## Key files
`resources/views/map.blade.php`, `routes/api.php`, `routes/web.php`, `app/Http/Controllers/Api/*`, `app/Models/*`, `database/migrations/*`, `public/images/*`.
