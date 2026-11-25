<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    /**
     * Display the library dashboard with statistics from the internal API.
     */
    public function index(): View
    {
        $stats = [
            'total_buku' => 0,
            'total_anggota' => 0,
            'peminjaman_aktif' => 0,
        ];

        try {
            $baseUrl = rtrim((string) config('services.internal_api.base_url'), '/');
            $response = Http::connectTimeout(3)
                ->timeout(5)
                ->get($baseUrl.'/api/stats');

            if ($response->successful() && is_array($data = $response->json())) {
                $stats = array_merge($stats, $data);
            }
        } catch (ConnectionException $e) {
            // Server internal API (port 8011) tidak bisa dihubungi - statistik tetap tampil nol.
        }

        return view('dashboard', compact('stats'));
    }
}
