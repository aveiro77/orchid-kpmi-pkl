<?php

use App\Orchid\Screens\Business\BusinessEditScreen;
use App\Orchid\Screens\Business\BusinessListScreen;
use App\Orchid\Screens\Business\MyBusinessEditScreen;
use App\Orchid\Screens\Business\MyBusinessListScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

Route::screen('businesses', BusinessListScreen::class)
    ->name('platform.businesses')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Direktori Usaha', route('platform.businesses')));

Route::screen('businesses/create', BusinessEditScreen::class)
    ->name('platform.businesses.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.businesses')
        ->push('Tambah'));

Route::screen('businesses/{business}/edit', BusinessEditScreen::class)
    ->name('platform.businesses.edit')
    ->breadcrumbs(fn (Trail $trail, $business) => $trail
        ->parent('platform.businesses')
        ->push('Edit'));

Route::screen('my/businesses', MyBusinessListScreen::class)
    ->name('platform.my.businesses')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Usaha Saya', route('platform.my.businesses')));

Route::screen('my/businesses/create', MyBusinessEditScreen::class)
    ->name('platform.my.businesses.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.my.businesses')
        ->push('Tambah'));

Route::screen('my/businesses/{business}/edit', MyBusinessEditScreen::class)
    ->name('platform.my.businesses.edit')
    ->breadcrumbs(fn (Trail $trail, $business) => $trail
        ->parent('platform.my.businesses')
        ->push('Edit'));
