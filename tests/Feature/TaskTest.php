<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Response;

class TaskTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $password = $this->faker->password();
        // $manager_data = [
        //     'name' => $this->faker->name(),
        //     'email' => $this->faker->unique()->safeEmail(),
        //     'password' => $password,
        //     'c_password' => $password,
        //     'role_id' => 2,
        // ];

        // $data = [
        //     'name' => $this->faker->name(),
        //     'email' => $this->faker->unique()->safeEmail(),
        //     'password' => $password,
        //     'c_password' => $password,
        //     'role_id' => 3,
        // ];

        $data = [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => $password,
            'c_password' => $password,
        ];
        

        $project_manager = User::create(
            [
                'name' => $this->faker->name(),
                'email' => $this->faker->unique()->safeEmail(),
                'password' => $password,
                'c_password' => $password,
                'role_id' => 2

            ]);
        $team_member = User::create([
                'name' => $this->faker->name(),
                'email' => $this->faker->unique()->safeEmail(),
                'password' => $password,
                'c_password' => $password,
                'role_id' => 3
                
            ]);
        $project = Project::create([
            'name' => $this->faker->name(),
            'created_by' => $project_manager->id
        ]);

        $task = Task::create([
            'title' => $this->faker->title(),
            'description' => $this->faker->paragraph(),
            'project_id' => $project->id,
            'user_id' => $team_member->id,
            'created_by' => $project_manager->id
        ]);

        // Log in as the user
        $this->actingAs($team_member);
        // Send PUT request to update the task status
        $response = $this->postJson("/api/tasks/update_status/$task->id", ['status_id' => 2]);

        // Assert response status code is 200 OK
        $response->assertStatus(200);

        // Assert response JSON contains updated task data
        $response->assertJson([
            'message' => 'Task Updated',
        ]);

       
    }
}
