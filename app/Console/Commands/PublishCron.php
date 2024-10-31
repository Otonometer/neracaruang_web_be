<?php

namespace App\Console\Commands;

use App\Models\Content;
use App\Models\Discussion;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PublishCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'publish:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Status to Publish';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Content::where('status', '!=', 'publish')->where('status','!=', 'archive')->where('publish_date', '<=',Carbon::now('Asia/Jakarta'))->update(['status' => 'publish']);
        Discussion::where('status', '!=', 'publish')->where('status','!=', 'archive')->where('publish_date_start', '<=', Carbon::now('Asia/Jakarta'))->update(['status' => 'publish']);
        Discussion::where(function($query) {
            $query->where('status','publish')->where('status','!=', 'archive');
        })->where('publish_date_end', '<=', Carbon::now('Asia/Jakarta'))->update(['status' => 'archive']);
    }
}
