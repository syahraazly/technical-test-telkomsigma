<?php

namespace App\Providers;

use App\Models\Employment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // fetch data dari API public
        $response = Http::get('https://678112d285151f714b0945c6.mockapi.io/api/v1/employment/list-public-api');
        if ($response->successful()) {
            $data = $response->json();

            foreach ($data as $item) {
                try {
                    // apakah data sudah ada
                    $existingData = Employment::where('employment_no', $item['employment_no'])->first();

                    if (!$existingData || $existingData->is_deleted) {
                        // tambahkan data baru jika belum ada atau sudah dihapus
                        Employment::create([
                            'employment_no' => $item['employment_no'],
                            'name' => $item['name'],
                            'gender' => $item['gender'],
                            'role' => $item['role'],
                            'job_grade' => $item['job_grade'],
                            'employment_status' => $item['employment_status'],
                            'manager' => $item['manager'],
                            'join_date' => $item['join_date'],
                            'end_date' => $item['end_date'],
                            'is_custom' => false, // default data dari API public
                            'is_deleted' => false // default data tidak dihapus
                        ]);
                    }
                } catch (\Exception $e) {
                    // abaikan error duplikasi
                    continue;
                }
            }
        }
    }
}
