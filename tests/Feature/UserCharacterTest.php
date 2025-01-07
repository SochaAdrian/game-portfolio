<?php

namespace Tests\Feature;

use App\Models\Classes;
use App\Models\Races;
use App\Models\Resources;
use App\Models\Statistics;
use App\Models\User;
use App\Models\UserCharacter;
use App\Policies\UserCharacterPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserCharacterTest extends TestCase
{
    use RefreshDatabase;

    private function createValidCharacter()
    {
        return $this->postJson('/api/characters', [
            'name' => 'Test Character',
            'races_id' => Races::inRandomOrder()->first()->id,
            'classes_id' => Classes::inRandomOrder()->first()->id,
            'bio' => fake()->sentence()
        ]);
    }

    public function test_if_not_authenticated_user_cant_create_character()
    {
        $response = $this->postJson('/api/characters', [
            'name' => 'Test Character'
        ]);

        $response->assertStatus(401);
    }

    public function test_if_authenticated_user_can_create_character()
    {
        $user = User::factory()->create();
        Sanctum::actingAs(
            $user
        );

        $response = $this->createValidCharacter();


        $this->assertDatabaseHas('user_characters', [
            'name' => 'Test Character',
            'user_id' => $user->id,
        ]);

        $response->assertStatus(302);
    }

    public function test_if_created_character_has_proper_statistics()
    {
        $user = User::factory()->create();
        Sanctum::actingAs(
            $user
        );

        $response = $this->createValidCharacter();

        $character = UserCharacter::latest()->first();

        // Check if character has proper statistics
        $race = $character->races;
        $class = $character->classes;

        $expectedStatistics = [
            'strength' => $race->strength + $class->strength,
            'dexterity' => $race->dexterity + $class->dexterity,
            'agility' => $race->agility + $class->agility,
            'inteligence' => $race->inteligence + $class->inteligence,
            'charisma' => $race->charisma + $class->charisma,
            'durability' => $race->durability + $class->durability,
        ];

        foreach ($expectedStatistics as $statName => $statValue) {
            $this->assertDatabaseHas('character_statistics', [
                'user_character_id' => $character->id,
                'statistics_id' => Statistics::where('name', $statName)->first()->id,
                'value' => $statValue
            ]);
        }
    }


    public function test_if_created_character_has_proper_resources()
    {
        $user = User::factory()->create();
        Sanctum::actingAs(
            $user
        );

        $response = $this->createValidCharacter();

        $character = UserCharacter::latest()->first();

        $resources = Resources::all();

        foreach ($resources as $resource) {
            $this->assertDatabaseHas('character_resources', [
                'user_character_id' => $character->id,
                'resources_id' => $resource->id,
                'value' => 0
            ]);
        }
    }

    public function test_if_validation_on_create_character_acctualy_works()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->postJson('/api/characters', [
            'name' => 'Test Character',
            'races_id' => Races::latest()->first()->id++,
            'classes_id' => 'test',
            'bio' => fake()->sentence()
        ]);

        $response->assertStatus(422);
    }

    public function test_if_user_can_see_his_own_characters()
    {
        $user = User::factory()->create();
        Sanctum::actingAs(
            $user
        );

        $userCharacter = UserCharacter::factory(3)->create([
            'user_id' => $user->id
        ]);

        $response = $this->getJson('/api/characters');

        $response->assertJson($userCharacter->toArray());
        $response->assertStatus(200);
    }

    public function test_if_user_can_choose_his_own_character()
    {
        $user = User::factory()->create();
        Sanctum::actingAs(
            $user
        );

        $userCharacter = UserCharacter::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->get('/game/choose-character/'.$userCharacter->id);
        $response->assertRedirect(route('games.game-screen'));
        $this->assertEquals(session('character'), $userCharacter->id);
    }

    public function test_if_user_cant_choose_someones_character()
    {
        $user = User::factory()->create();
        Sanctum::actingAs(
            $user
        );

        $userCharacter = UserCharacter::factory()->create();

        $response = $this->get('/game/choose-character/'.$userCharacter->id);
        $response->assertStatus(403);
    }

    public function test_if_validation_checking_if_character_exists_works()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->get('/game/choose-character/99999');
        $response->assertStatus(404);
    }

    public function test_user_character_policy()
    {
        $user = User::factory()->create();
        $userCharacter = UserCharacter::factory()->create([
            'user_id' => $user->id,
        ]);

        $anotherUser = User::factory()->create();

        $policy = new UserCharacterPolicy();
        $this->assertTrue($policy->view($user, $userCharacter));
        $this->assertFalse($policy->view($anotherUser, $userCharacter));
    }

}
