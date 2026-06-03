# App Overview

Quick refresher for the mushoku-map Laravel 10 app.

## What the app does
- Renders a static world map with Leaflet using a Simple CRS and an image overlay.
- Stores places, travels, and visits, then exposes them via a small JSON API.
- The main UI is a single Blade view that fetches data and renders markers and paths.

## Core data model
- Place
  - Fields: id, name, description (optional), x, y
  - x/y are image pixel coordinates
  - Relationships: hasMany PlaceVisit
- PlaceVisit
  - Fields: id, place_id, travel_number (optional), story_time (optional), reason (optional)
  - Relationships: belongsTo Place
- Travels
  - Fields: id, name (optional), type (optional), color (default red), reason (optional), path
  - path is an array of [y, x] points

## How the frontend works
- View: resources/views/map.blade.php
- Leaflet uses Simple CRS, so coordinates are [y, x] pixels.
- The view loads places and travels from /api endpoints.
- Places are rendered as markers; travels are rendered as polylines.
- Adding a visit posts to /api/place-visits and reloads.

## API surface (JSON)
- /api/places
  - GET list
  - POST create
  - GET /api/places/{id} includes visits
  - PUT/PATCH update
  - DELETE delete
  - Extra: GET /api/places/{place}/visits ordered by travel_number
- /api/travels
  - GET list
  - POST create
  - PUT/PATCH update
  - DELETE delete
- /api/place-visits
  - GET list
  - POST create
  - DELETE delete

## Where the code lives
- Models: app/Models/Place.php, PlaceVisit.php, Travels.php
- Controllers: app/Http/Controllers/Api/
- Routes: routes/api.php (primary), routes/web.php (map view + duplicate GET routes)
- Map image: public/images/highresmapclearonteal.png

## Local dev notes
- Install: composer install, npm install
- Env: copy .env.example to .env, set DB, php artisan key:generate
- DB: php artisan migrate
- Run: php artisan serve (map at /map)

## Gotchas
- Coordinate order is always [y, x] across frontend and DB.
- Use /api endpoints from the client.
- Keep model $fillable in sync with migrations if you add fields.
