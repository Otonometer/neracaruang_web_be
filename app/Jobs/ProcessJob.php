<?php

namespace App\Jobs;

// use App\AudioProcessor;
// use App\Podcast;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Log;

class ProcessJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // protected $podcast;

    /**
     * Create a new job instance.
     *
     * @param  Podcast  $podcast
     * @return void
     */
    // public function __construct(Podcast $podcast)
    public function __construct()
    {
        // $this->podcast = $podcast;
    }

    /**
     * Execute the job.
     *
     * @param  AudioProcessor  $processor
     * @return void
     */
    // public function handle(AudioProcessor $processor)
    public function handle()
    {
        // Process uploaded podcast...
        Log::info('test job by dandisy');
    }
}