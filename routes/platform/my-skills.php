<?php

use App\Orchid\Screens\Profile\MySkillScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

Route::screen('my/skills', MySkillScreen::class)
    ->name('platform.my.skills')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Skill Saya', route('platform.my.skills')));
