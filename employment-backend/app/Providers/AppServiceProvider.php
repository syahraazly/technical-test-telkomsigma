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
        // fetch data dari API Public
        $response = Http::get('https://678112d285151f714b0945c6.mockapi.io/api/v1/employment/list-public-api');

        if ($response->successful()) {
            $data = $response->json();

            foreach ($data as $item) {
                // simpan data ke database
                Employment::updateOrCreate(
                    ['employment_no' => $item['employment_no']], 
                    [
                        'name' => $item['name'],
                        'gender' => $item['gender'],
                        'role' => $item['role'],
                        'job_grade' => $item['job_grade'],
                        'employment_status' => $item['employment_status'],
                        'manager' => $item['manager'],
                        'join_date' => $item['join_date'],
                        'end_date' => $item['end_date'],
                    ]
                );
            }
        }
    }
}
