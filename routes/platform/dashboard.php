<?php

use App\Orchid\Screens\Dashboard\DashboardScreen;
use App\Orchid\Screens\Dashboard\MyDashboardScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

Route::screen('dashboard', DashboardScreen::class)
    ->name('platform.dashboard')
    ->breadcrumbs(fn (Trail $trail) => $trail->parent('platform.index')->push('Dashboard', route('platform.dashboard')));

Route::screen('my-dashboard', MyDashboardScreen::class)
    ->name('platform.my.dashboard')
    ->breadcrumbs(fn (Trail $trail) => $trail->parent('platform.index')->push('Dashboard Saya', route('platform.my.dashboard')));
