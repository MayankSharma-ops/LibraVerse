<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Resource;
use App\Models\Borrowing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LibraryFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed basic category
        $this->category = Category::create([
            'name' => 'Physics',
            'slug' => 'physics',
            'color' => '#10b981',
            'icon' => '⚛️',
        ]);

        // Seed basic resource
        $this->resource = Resource::create([
            'title' => 'Quantum Physics',
            'author' => 'R. Shankar',
            'category_id' => $this->category->id,
            'type' => 'book',
            'total_copies' => 3,
            'available_copies' => 3,
            'rating' => 5.0,
            'views' => 0,
        ]);

        // Seed regular user
        $this->user = User::create([
            'name' => 'Standard User',
            'email' => 'user@library.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        // Seed admin user
        $this->admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@library.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
    }

    /**
     * Guest cannot access dashboard
     */
    public function test_guest_cannot_access_dashboard()
    {
        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('login'));
    }

    /**
     * Standard user login and dashboard access
     */
    public function test_user_can_login_and_access_dashboard()
    {
        $response = $this->post('/login', [
            'email' => 'user@library.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($this->user);
    }

    /**
     * Admin login and admin dashboard access
     */
    public function test_admin_can_login_and_access_admin_dashboard()
    {
        $response = $this->post('/login', [
            'email' => 'admin@library.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($this->admin);
    }

    /**
     * Non-admin cannot access admin console
     */
    public function test_user_cannot_access_admin_dashboard()
    {
        $response = $this->actingAs($this->user)->get(route('admin.dashboard'));
        $response->assertStatus(403);
    }

    /**
     * Borrowing and returning transactions flow
     */
    public function test_user_can_borrow_and_return_book()
    {
        // 1. Borrow resource
        $response = $this->actingAs($this->user)->post(route('resources.borrow', $this->resource->id));

        $response->assertRedirect(route('dashboard'));
        $this->resource->refresh();
        $this->assertEquals(2, $this->resource->available_copies);
        $this->assertDatabaseHas('borrowings', [
            'user_id' => $this->user->id,
            'resource_id' => $this->resource->id,
            'returned_at' => null,
        ]);

        // Get borrowing record
        $borrowing = Borrowing::where('user_id', $this->user->id)
            ->where('resource_id', $this->resource->id)
            ->first();

        // 2. Return resource
        $response = $this->actingAs($this->user)->post(route('borrowings.return', $borrowing->id));

        $response->assertRedirect(route('dashboard'));
        $this->resource->refresh();
        $this->assertEquals(3, $this->resource->available_copies);
        $this->assertNotNull($borrowing->refresh()->returned_at);
    }

    /**
     * Admin can catalog a new resource
     */
    public function test_admin_can_catalog_new_book()
    {
        $response = $this->actingAs($this->admin)->post(route('admin.resources.store'), [
            'title' => 'Principles of Electrodynamics',
            'author' => 'Melvin Schwartz',
            'category_id' => $this->category->id,
            'type' => 'book',
            'total_copies' => 2,
            'pages' => 360,
            'isbn' => '978-0486654934',
            'publisher' => 'Dover Publications',
            'published_year' => 1987,
            'description' => 'A classic book on electrodynamics.',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertDatabaseHas('resources', [
            'title' => 'Principles of Electrodynamics',
            'author' => 'Melvin Schwartz',
            'total_copies' => 2,
            'available_copies' => 2,
        ]);
    }
}
