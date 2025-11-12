<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        [$message, $author] = str(Inspiring::quotes()->random())->explode('-');

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'quote' => ['message' => trim($message), 'author' => trim($author)],
            'auth' => [
                'user' => $request->user(),
                'notificationCount' => $request->user() ? $request->user()->unreadNotifications()->count() : null,
                'unreadNotifications' => $request->user() ? $request->user()->unreadNotifications : null
            ],
            'flash' => [
                'success' => $request->session()->get('success'),
                'error' => $request->session()->get('error'),
                'locationsall' => Cache::get('locationsall'),
            ],
            'site' => [
                'current_project' => $request->session()->get('current_project_id') ?? 0,
                'img_share' => img_share(),
                'logo_dark' => logo_dark(),
                'icon_dark' => icon_dark(),
                'logo_white' => logo_white(),
                'icon_white' => icon_white(),
                'favicon' => favicon(),
                'site_name' => get_site_name(),
                'seo' => seo(),
                'keywords' => keywords(),
                'ccc' => get_c(),
                'year' => Carbon::now()->year,
                'academic_session' => academic_session(),
                'entrance_fee' => entrance_fee(),
            ],
        ];
    }
}
