<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LogRandomUserData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $endpoint = 'https://randomuser.me/api/';
        
        try {
            // Make the HTTP request
            $response = Http::get($endpoint);

            if ($response->successful()) {
                // Extract and log the "results" object
                $results = $response->json('results');
                Log::info('Random User Data:', ['results' => $results]);
            } else {
                Log::error('Failed to fetch data from Random User API', ['status' => $response->status()]);
            }
        } catch (\Exception $e) {
            Log::error('Error occurred while fetching data', ['message' => $e->getMessage()]);
        }
    }
}
