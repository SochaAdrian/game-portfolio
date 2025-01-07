<?php

namespace App\Http\Middleware;

use App\Http\Resources\JsonResources\BuildingResource;
use App\Http\Resources\JsonResources\LocalizationResource;
use App\Http\Resources\JsonResources\QuestResource;
use App\Http\Resources\JsonResources\StatisticsResource;
use App\Http\Resources\JsonResources\UserCharacterForGameResource;
use App\Models\Buildings;
use App\Models\Localizations;
use App\Models\Quests;
use App\Models\Statistics;
use App\Models\UserCharacter;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    private static function getGameData()
    {
        $localizations = LocalizationResource::collection(Localizations::all());
        $quests = QuestResource::collection(Quests::available()->get());
        $buildings = BuildingResource::collection(Buildings::all());
        $statistics = StatisticsResource::collection(Statistics::all());
        return [
            'localizations' => $localizations,
            'quests' => $quests,
            'buildings' => $buildings,
            'statistics' => $statistics,
        ];
    }

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        if (UserCharacter::where('id', session('character'))->doesntExist()) {
            session()->forget('character');
        }

        return [
            ...parent::share($request),
            'auth' => [
                'character' => session('character') ? new UserCharacterForGameResource(UserCharacter::find(session('character')) ?? []) : null,
                'user' => $request->user(),
            ],
            'gameData' => self::getGameData(),
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
        ];
    }
}
