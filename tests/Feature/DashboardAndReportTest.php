<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class DashboardAndReportTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_guest_is_redirected_to_login_from_dashboard_and_report(): void
    {
        $this->get(route('dashboard'))->assertRedirect(route('login'));
        $this->get(route('loans.report'))->assertRedirect(route('login'));
    }

    public function test_login_redirects_to_dashboard(): void
    {
        $user = User::factory()->create([
            'email' => 'petugas@pens.ac.id',
            'password' => 'password',
            'role' => 'petugas',
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_dashboard_displays_stats_from_internal_api(): void
    {
        Http::preventStrayRequests();

        $baseUrl = rtrim((string) config('services.internal_api.base_url'), '/');

        Http::fake([
            $baseUrl.'/api/stats' => Http::response([
                'total_buku' => 20,
                'total_anggota' => 15,
                'peminjaman_aktif' => 4,
            ], 200),
        ]);

        $user = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk()
            ->assertViewIs('dashboard')
            ->assertSee('Total Buku')
            ->assertSee('20')
            ->assertSee('Total Anggota')
            ->assertSee('15')
            ->assertSee('Peminjaman Aktif')
            ->assertSee('4')
            ->assertSee('Lihat Laporan Peminjaman')
            ->assertSee('Profil');

        Http::assertSent(fn (Request $request): bool => $request->url() === $baseUrl.'/api/stats');
    }

    public function test_dashboard_falls_back_to_zero_when_internal_api_fails_or_is_unreachable(): void
    {
        Http::preventStrayRequests();

        $baseUrl = rtrim((string) config('services.internal_api.base_url'), '/');
        $user = User::factory()->create(['role' => 'petugas']);

        Http::fake([
            $baseUrl.'/api/stats' => Http::response(['message' => 'Server Error'], 500),
        ]);

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertViewHas('stats', [
                'total_buku' => 0,
                'total_anggota' => 0,
                'peminjaman_aktif' => 0,
            ]);

        Http::fake([
            $baseUrl.'/api/stats' => Http::failedConnection(),
        ]);

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertViewHas('stats', [
                'total_buku' => 0,
                'total_anggota' => 0,
                'peminjaman_aktif' => 0,
            ]);
    }

    public function test_loan_report_displays_api_loans_and_pagination(): void
    {
        Http::preventStrayRequests();

        $baseUrl = rtrim((string) config('services.internal_api.base_url'), '/');

        Http::fake([
            $baseUrl.'/api/loans*' => Http::response([
                'data' => [
                    [
                        'id' => 7,
                        'member' => ['id' => 1, 'nama' => 'Siti Aminah'],
                        'petugas' => ['id' => 1, 'name' => 'Bambang Sutrisno'],
                        'tanggal_pinjam' => '2026-10-10',
                        'tanggal_kembali' => '2026-10-17',
                        'tanggal_dikembalikan' => null,
                        'status' => 'dipinjam',
                        'books' => [
                            ['id' => 1, 'judul' => 'Laskar Pelangi'],
                            ['id' => 2, 'judul' => 'Bumi Manusia'],
                        ],
                    ],
                ],
                'meta' => [
                    'current_page' => 2,
                    'last_page' => 3,
                ],
            ], 200),
        ]);

        $user = User::factory()->create(['role' => 'petugas']);

        $response = $this->actingAs($user)->get(route('loans.report', ['page' => 2]));

        $response->assertOk()
            ->assertViewIs('loans.report')
            ->assertSee('Laporan Peminjaman')
            ->assertSee('Siti Aminah')
            ->assertSee('Bambang Sutrisno')
            ->assertSee('Laskar Pelangi')
            ->assertSee('Bumi Manusia')
            ->assertSee('Dipinjam')
            ->assertSee('Halaman 2 dari 3');

        Http::assertSent(fn (Request $request): bool => $request->url() === $baseUrl.'/api/loans?page=2');
    }

    public function test_loan_report_falls_back_to_empty_when_internal_api_is_unreachable(): void
    {
        Http::preventStrayRequests();

        $baseUrl = rtrim((string) config('services.internal_api.base_url'), '/');

        Http::fake([
            $baseUrl.'/api/loans*' => Http::failedConnection(),
        ]);

        $user = User::factory()->create(['role' => 'petugas']);

        $response = $this->actingAs($user)->get(route('loans.report'));

        $response->assertOk()
            ->assertViewIs('loans.report')
            ->assertSee('Belum ada data peminjaman.');
    }
}
