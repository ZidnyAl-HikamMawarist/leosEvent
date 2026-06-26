<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Setting::create(['id' => 1, 'nama_event' => 'Test Event']);
    }

    public function test_guest_cannot_access_admin(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_regular_user_cannot_access_admin(): void
    {
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        // User biasa yang coba akses /admin langsung di-redirect
        $response = $this->actingAs($user)->get('/admin/dashboard');
        $response->assertRedirect('/');
    }

    public function test_non_admin_cannot_login(): void
    {
        $user = User::create([
            'name' => 'Not Admin',
            'email' => 'notadmin@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        // Coba login tapi langsung ditolak + di-logout
        $response = $this->post('/login', [
            'email' => 'notadmin@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHas('error');
        $this->assertGuest(); // Harus tetap guest (tidak login)
    }

    public function test_admin_can_access_admin(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
    }

    public function test_superadmin_can_access_admin(): void
    {
        $superadmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('password'),
            'role' => 'superadmin',
        ]);

        $response = $this->actingAs($superadmin)->get('/admin/dashboard');
        $response->assertStatus(200);
    }

    public function test_admin_can_access_lomba_index(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/admin/lomba');
        $response->assertStatus(200);
    }

    public function test_admin_can_access_settings(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/admin/settings');
        $response->assertStatus(200);
    }

    public function test_regular_user_cannot_access_lomba(): void
    {
        $user = User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->get('/admin/lomba');
        $response->assertRedirect('/');
    }
}
