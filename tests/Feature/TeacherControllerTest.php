<?php

namespace Tests\Feature;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeacherControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_page_loads()
    {
        $response = $this->get('/admin/teachers');
        $response->assertStatus(200);
    }

    public function test_store_teacher()
    {
        $response = $this->post('/admin/teachers', [
            'name' => 'Test Teacher',
            'price_per_hour' => 500,
            'year_exp' => 5,
        ]);

        $response->assertRedirect('/admin/teachers');
        $this->assertDatabaseHas('teachers', ['name' => 'Test Teacher']);
    }

    public function test_update_teacher()
    {
        $teacher = Teacher::factory()->create();

        $response = $this->put("/admin/teachers/{$teacher->id}", [
            'name' => 'Updated',
            'price_per_hour' => 400,
            'year_exp' => 4,
        ]);

        $response->assertRedirect('/admin/teachers');

        $this->assertDatabaseHas('teachers', [
            'id' => $teacher->id,
            'name' => 'Updated'
        ]);
    }

    public function test_delete_teacher()
    {
        $teacher = Teacher::factory()->create();

        $response = $this->delete("/admin/teachers/{$teacher->id}");

        $response->assertRedirect('/admin/teachers');
        $this->assertDatabaseMissing('teachers', ['id' => $teacher->id]);
    }
}
