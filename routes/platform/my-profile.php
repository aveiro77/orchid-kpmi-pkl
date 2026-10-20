<?php
// routes/platform/my-profile.php
use App\Orchid\Screens\Profile\MyProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

Route::screen('my/profile', MyProfileScreen::class)
    ->name('platform.my.profile')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Profil Saya', route('platform.my.profile')));