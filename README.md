# PrefinalProject-Cortez-KaonTaDavao

**Kaon Ta! Davao – Cortez's Food Guide**
By Jez Cortez · 4-334 Full-Stack Web Development · Ateneo de Davao University

A guide to carinderias and eateries in Davao City. Staff can list eateries by district with their business permit, dishes and features, and residents can leave reviews. Built with Laravel 12, SQLite, Blade and Tailwind v4 through Vite. There is no login, every page is public.

## Setup

``` bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate:fresh --seed
npm install
npm run build
php artisan serve
```

## My data

- **Districts:** Poblacion, Talomo, Agdao, Buhangin, Toril, Bunawan
- **Features:** Suki ni Cortez, Budget Meal, Halal, Open 24 Hours, Aircon, Free WiFi
- **Users** (password `kaonta2026` for both): Jez Cortez (`cortez@kaonta.test`) and Tita Cortez (`tita.cortez@kaonta.test`), plus 10 factory users
- **My eatery:** Carinderia ni Cortez (`carinderia-ni-cortez`), San Pedro St., Poblacion, Davao City, budget, specialty Tinolang Manok
- **Permit:** DVO-2026-0531, expires 2027-05-31
- **Dishes:** Tinolang Manok ₱85.00 (bestseller), Kinilaw na Tuna ₱120.00, Durian Shake ₱75.00

## Relationships

| Relationship | Type | Why |
| --- | --- | --- |
| District → Eatery | hasMany / belongsTo | One district has many eateries, but each eatery sits in only one district. |
| Eatery → Dish | hasMany / belongsTo | An eatery sells many dishes and each dish belongs to one eatery. |
| Eatery → Review | hasMany / belongsTo | An eatery collects many reviews and each review is about one eatery. |
| User → Review | hasMany / belongsTo | A reviewer can write many reviews, each written by one user. |
| Eatery → Permit | hasOne / belongsTo | Each eatery has exactly one permit (unique `eatery_id`). |
| Eatery ↔ Feature | belongsToMany | An eatery has several features and a feature (like Halal) is on many eateries, so they need the `eatery_feature` pivot. |
| District → Review (through Eatery) | hasManyThrough | Reviews belong to eateries, not districts, so I count a district's reviews by going through its eateries. |

## Routes

Output of `php artisan route:list --except-vendor`:

``` bash

 GET|HEAD / .. home › HomeController
 GET|HEAD districts .. districts.index › DistrictController@index
 GET|HEAD districts/{district} .. districts.show › DistrictController@show
 GET|HEAD eateries .. eateries.index › EateryController@index
 POST eateries .. eateries.store › EateryController@store
 GET|HEAD eateries/create .. eateries.create › EateryController@create
 GET|HEAD eateries/{eatery} .. eateries.show › EateryController@show
 PUT|PATCH eateries/{eatery} .. eateries.update › EateryController@update
 DELETE eateries/{eatery} .. eateries.destroy › EateryController@destroy
 GET|HEAD eateries/{eatery}/edit .. eateries.edit › EateryController@edit
 POST eateries/{eatery}/reviews .. eateries.reviews.store › ReviewController@store
 GET|HEAD reviewers/{user} .. reviewers.show › ReviewerController@show
 DELETE reviews/{review} .. reviews.destroy › ReviewController@destroy

 Showing [13] routes

```

## Screenshots

- `screenshots/eatery-list.png`: the eatery list
- `screenshots/eatery-page.png`: an eatery page with reviews
- `screenshots/create-form-errors.png`: the create form showing validation errors
