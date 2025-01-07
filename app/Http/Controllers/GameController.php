<?php

namespace App\Http\Controllers;

use App\Http\Resources\Collections\UserCharacterCollection;
use App\Http\Resources\JsonResources\QuestResource;
use App\Http\Resources\JsonResources\QuestRewardResource;
use App\Http\Services\GameService;
use App\Models\CharacterQuests;
use App\Models\Classes;
use App\Models\LocalizationNpcs;
use App\Models\Localizations;
use App\Models\Quests;
use App\Models\QuestsCompleted;
use App\Models\Races;
use App\Models\UserCharacter;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GameController extends Controller
{
    use AuthorizesRequests;

    protected $user;

    public function __construct()
    {
        $this->user = auth()->user();
        $this->service = new GameService();
    }

    public function index()
    {
        return Inertia::render('game/choose-character', [
            'characters' => new UserCharacterCollection($this->user->characters) ?? [],
        ]);
    }


    public function camp()
    {
        return Inertia::render('game/camp');
    }

    public function map()
    {
        return Inertia::render('game/map');
    }

    public function quests()
    {
        return Inertia::render('game/quests');
    }

    public function createCharacter()
    {
        return Inertia::render('game/create-character', [
            'races' => Races::all(),
            'classes' => Classes::all(),
        ]);
    }

    public function chooseCharacter(Request $request, UserCharacter $character)
    {
        $this->authorize('view', $character);

        //Do sesji zapisujemy wybraną postać
        session(['character' => $character->id]);
        return redirect()->route('games.game-screen');
    }

    public function changeLocalization(Request $request, $id)
    {
        $this->service->changeLocalization($id, $request);
        return redirect()->route('games.game-screen');
    }


    public function startQuest(Request $request, $id)
    {
        return $this->service->startQuest($id, $request);
    }

    public function getNpcs(Request $request, Localizations $id)
    {
        return $this->service->getNpcs($id, $request);
    }

    public function talkToNpc(Request $request, $npc)
    {
        return $this->service->talkToNpc($npc, $request);
    }

    public function participateInQuest(Request $request)
    {
        $user = $request->user();
        $character = session('character');

        if ($character === null) {
            return redirect()->route('games.index');
        }

        $pendingQuests = CharacterQuests::where('character_id', $character)->pluck('quests_id')->toArray();

        // take 3 random quests from $pendingQuests that has type other than talk
        return Inertia::render('game/suggested-quests', [
            'quests' => QuestResource::collection(Quests::whereIn('id', $pendingQuests)->where('type', '!=',
                'talk')->inRandomOrder()->with('questRewards')->limit(3)->get()),
        ]);


    }

    public function participateInParticularQuest(Request $request, Quests $quest)
    {
        $user = $request->user();
        $characterId = session('character');

        if ($characterId === null) {
            return redirect()->route('games.index');
        }

        $characterQuests = CharacterQuests::where('character_id', $characterId)->pluck('quests_id')->toArray();

        if ($quest === null || !in_array($quest->id, $characterQuests) || $quest->type === 'talk') {
            return redirect()->route('games.participate');
        }

        $isCompleted = QuestsCompleted::where('quests_id', $quest->id)
            ->where('user_character_id', $characterId)
            ->exists();

        return Inertia::render('game/participate-in-quest', [
            'quest' => $quest,
            'questReward' => QuestRewardResource::collection($quest->questRewards ?? []),
            'isCompleted' => $isCompleted,
        ]);
    }


    public function finishQuest(Request $request, $id)
    {
        return $this->service->finishQuest($id, $request);
    }

    public function buildings()
    {
        return Inertia::render('game/buildings');
    }

    public function buildBuilding(Request $request, $building)
    {
        return $this->service->buildBuilding($building, $request);
    }
}
