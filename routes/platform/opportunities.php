<?php

use App\Orchid\Screens\Opportunity\MyOpportunityEditScreen;
use App\Orchid\Screens\Opportunity\MyOpportunityListScreen;
use App\Orchid\Screens\Opportunity\OpportunityEditScreen;
use App\Orchid\Screens\Opportunity\OpportunityListScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

Route::screen('opportunities', OpportunityListScreen::class)
    ->name('platform.opportunities')
    ->breadcrumbs(fn (Trail $trail) => $trail->parent('platform.index')->push('Peluang', route('platform.opportunities')));

Route::screen('opportunities/create', OpportunityEditScreen::class)
    ->name('platform.opportunities.create')
    ->breadcrumbs(fn (Trail $trail) => $trail->parent('platform.opportunities')->push('Buat'));

Route::screen('opportunities/{opportunity}/edit', OpportunityEditScreen::class)
    ->name('platform.opportunities.edit')
    ->breadcrumbs(fn (Trail $trail) => $trail->parent('platform.opportunities')->push('Edit'));

// Member Area: My Opportunities
Route::screen('my/opportunities', MyOpportunityListScreen::class)
    ->name('platform.my.opportunities')
    ->breadcrumbs(fn (Trail $trail) => $trail->parent('platform.index')->push('Peluang Saya', route('platform.my.opportunities')));

Route::screen('my/opportunities/create', MyOpportunityEditScreen::class)
    ->name('platform.my.opportunities.create')
    ->breadcrumbs(fn (Trail $trail) => $trail->parent('platform.my.opportunities')->push('Buat'));

Route::screen('my/opportunities/{opportunity}/edit', MyOpportunityEditScreen::class)
    ->name('platform.my.opportunities.edit')
    ->breadcrumbs(fn (Trail $trail) => $trail->parent('platform.my.opportunities')->push('Edit'));

use App\Orchid\Screens\Opportunity\OpportunityBoardScreen;
use App\Orchid\Screens\Opportunity\OpportunityDetailScreen;

// Board: Public Opportunity Board for logged in members
Route::screen('opportunity-board', OpportunityBoardScreen::class)
    ->name('platform.opportunity-board')
    ->breadcrumbs(fn (Trail $trail) => $trail->parent('platform.index')->push('Papan Peluang', route('platform.opportunity-board')));

Route::screen('opportunity-board/{opportunity}', OpportunityDetailScreen::class)
    ->name('platform.opportunity-board.show')
    ->breadcrumbs(fn (Trail $trail) => $trail->parent('platform.opportunity-board')->push('Detail'));
