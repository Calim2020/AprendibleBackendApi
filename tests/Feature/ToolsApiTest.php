<?php

namespace Tests\Feature;

use App\Models\Tool;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ToolsApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function can_get_all_tools()
    {
        $tools = Tool::factory(4)->create();

        $this->getJson(route('tools.index'))
            ->assertJsonFragment([ 'name' => $tools[0]->name])
            ->assertJsonFragment([ 'name' => $tools[1]->name]);
    }

    /** @test */
    function can_get_one_tool()
    {
        $tool = Tool::factory()->create();

        $this->getJson(route('tools.show', $tool))
            ->assertJsonFragment([ 'name' => $tool->name]);
    }

    /** @test */
    function can_create_tools()
    {
        $this->postJson(route('tools.store'), [])
            ->assertJsonValidationErrorFor('name');

        $this->postJson(route('tools.store'), ['name' => 'New tool'])
            ->assertJsonFragment([ 'name' => 'New tool']);

        $this->assertDatabaseHas('tools', [ 'name' => 'New tool']);
    }

    /** @test */
    function can_update_tools()
    {
        $tool = Tool::factory()->create();

        $this->patchJson(route('tools.update', $tool), [])
            ->assertJsonValidationErrorFor('name');

        $this->patchJson(route('tools.update', $tool), ['name' => 'Edited tool'])
            ->assertJsonFragment([ 'name' => 'Edited tool']);

        $this->assertDatabaseHas('tools', [ 'name' => 'Edited tool']);
    }

    /** @test */
    function can_delete_tools()
    {
        $tool = Tool::factory()->create();

         $this->deleteJson(route('tools.destroy', $tool))
            ->assertNoContent();

        $this->assertDatabaseCount('tools', 0);
    }
}
