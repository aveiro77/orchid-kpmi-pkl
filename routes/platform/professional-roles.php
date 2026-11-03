<?php

use App\Orchid\Screens\ProfessionalRole\ProfessionalRoleListScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

Route::screen('professional-roles', ProfessionalRoleListScreen::class)
    ->name('platform.professional-roles')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Peran Profesi', route('platform.professional-roles')));
