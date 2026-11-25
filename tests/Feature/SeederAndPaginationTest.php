<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use App\Models\Loan;
use App\Models\LoanItem;
use App\Models\Member;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class SeederAndPaginationTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_database_seeder_populates_consistent_indonesian_data(): void
    {
        $this->seed();

        $this->assertDatabaseCount('users', 3);
        $this->assertDatabaseHas('users', ['email' => 'admin@pens.ac.id', 'name' => 'Bambang Sutrisno', 'role' => 'admin']);
        $this->assertDatabaseHas('users', ['email' => 'petugas1@pens.ac.id', 'name' => 'Siti Rahmawati', 'role' => 'petugas']);
        $this->assertDatabaseHas('users', ['email' => 'petugas2@pens.ac.id', 'name' => 'Ahmad Fauzi', 'role' => 'petugas']);

        $this->assertDatabaseCount('categories', 5);
        $this->assertDatabaseCount('books', 20);
        $this->assertDatabaseCount('members', 15);
        $this->assertDatabaseCount('loans', 10);

        $this->assertTrue(LoanItem::count() >= 10);

        $members = Member::all();
        foreach ($members as $member) {
            $this->assertStringEndsWith('@pens.ac.id', $member->email);
        }

        $loans = Loan::all();
        foreach ($loans as $loan) {
            if ($loan->status === 'dikembalikan') {
                $this->assertNotNull($loan->tanggal_dikembalikan);
            } else {
                $this->assertNull($loan->tanggal_dikembalikan);
            }
        }
    }

    public function test_user_and_category_seeders_are_idempotent(): void
    {
        $this->seed(UserSeeder::class);
        $this->seed(UserSeeder::class);
        $this->seed(CategorySeeder::class);
        $this->seed(CategorySeeder::class);

        $this->assertSame(3, User::count());
        $this->assertSame(5, Category::count());
    }

    public function test_books_and_members_pages_render_custom_pagination(): void
    {
        $this->seed();

        $user = User::where('email', 'admin@pens.ac.id')->firstOrFail();

        $booksResponse = $this->actingAs($user)->get(route('books.index'));
        $booksResponse->assertOk()
            ->assertSee('pagination-current', false)
            ->assertSee('Berikutnya', false)
            ->assertDontSee('svg', false);

        $membersResponse = $this->actingAs($user)->get(route('members.index'));
        $membersResponse->assertOk()
            ->assertSee('pagination-current', false)
            ->assertSee('Berikutnya', false)
            ->assertDontSee('svg', false);

        $this->assertGreaterThan(10, Book::count());
        $this->assertGreaterThan(10, Member::count());
    }
}
