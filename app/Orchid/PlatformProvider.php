<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * Register the application menu.
     *
     * @return Menu[]
     */
    public function menu(): array
    {
        return [
            Menu::make('Get Started')
                ->icon('bs.book')
                ->title('Navigation')
                ->route(config('platform.index')),

            Menu::make('Sample Screen')
                ->icon('bs.collection')
                ->route('platform.example')
                ->badge(fn () => 6)
                ->permission('platform.examples'),

            Menu::make('Form Elements')
                ->icon('bs.card-list')
                ->route('platform.example.fields')
                ->permission('platform.examples')
                ->active('*/examples/form/*'),

            Menu::make('Layouts Overview')
                ->icon('bs.window-sidebar')
                ->permission('platform.examples')
                ->route('platform.example.layouts'),

            Menu::make('Grid System')
                ->icon('bs.columns-gap')
                ->permission('platform.examples')
                ->route('platform.example.grid'),

            Menu::make('Charts')
                ->icon('bs.bar-chart')
                ->permission('platform.examples')
                ->route('platform.example.charts'),

            Menu::make('Cards')
                ->icon('bs.card-text')
                ->route('platform.example.cards')
                ->permission('platform.examples')
                ->divider(),

            Menu::make(__('Users'))
                ->icon('bs.people')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Access Controls')),

            Menu::make(__('Roles'))
                ->icon('bs.shield')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles')
                ->divider(),

            Menu::make('Documentation')
                ->title('Docs')
                ->icon('bs.box-arrow-up-right')
                ->url('https://orchid.software/en/docs')
                ->permission('platform.examples')
                ->target('_blank'),

            Menu::make('Changelog')
                ->icon('bs.box-arrow-up-right')
                ->url('https://github.com/orchidsoftware/platform/blob/master/CHANGELOG.md')
                ->target('_blank')
                ->permission('platform.examples')
                ->badge(fn () => Dashboard::version(), Color::DARK),

            Menu::make('Tasks')
                ->icon('bag')
                ->route('platform.task')
                ->title('Tools')
                ->permission('platform.task'),

            Menu::make('Anggota')
                ->icon('bs.people')
                ->route('platform.members')
                ->permission('platform.members')
                ->title('Komunitas'),

            Menu::make('Skill')->icon('bs.stars')
                ->route('platform.skills')
                ->permission('platform.skills')
                ->addPermission('platform.skills'),

            Menu::make('Profil Saya')
                ->icon('bs.person-circle')
                ->route('platform.my.profile')
                ->permission('platform.my.profile')
                ->title('Member Area'),

            Menu::make('Skill Saya')
                ->icon('bs.stars')
                ->route('platform.my.skills')
                ->permission('platform.my.skills'),

        ];
    }

    /**
     * Register permissions for the application.
     *
     * @return ItemPermission[]
     */
    // public function permissions(): array
    // {
    //     return [
    //         ItemPermission::group(__('System'))
    //             ->addPermission('platform.systems.roles', __('Roles'))
    //             ->addPermission('platform.systems.users', __('Users')),
    //     ];
    // }

    public function permissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),

            ItemPermission::group(__('Tools'))
                ->addPermission('platform.task', __('Tasks')),

            ItemPermission::group(__('Examples'))
                ->addPermission('platform.examples', __('Example Screens')),

            ItemPermission::group('Master Data')
                ->addPermission('platform.members', 'Kelola Anggota')
                ->addPermission('platform.skills', 'Kelola Skill')
                ->addPermission('platform.professional-roles', 'Profesi')
                ->addPermission('platform.businesses', 'Usaha')
                ->addPermission('platform.opportunities', 'Peluang')
                ->addPermission('platform.referrals', 'Referral')
                ->addPermission('platform.events', 'Event'),

            ItemPermission::group('Member Area')
                ->addPermission('platform.my.profile', 'Profil Saya')
                ->addPermission('platform.my.skills', 'Skill Saya')
                ->addPermission('platform.my.businesses', 'Usaha Saya')
                ->addPermission('platform.my.opportunities', 'Peluang Saya')
                ->addPermission('platform.my.events', 'Event Saya'),
        ];
    }
}
