<?php

namespace App\Console\Commands;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteOldSoftDeletedPosts extends Command
{
    protected $signature = 'posts:purge-old';
    protected $description = 'Force-delete posts that were soft-deleted more than 30 days ago';
    public function handle()
    {
        $thirtyDaysAgo = Carbon::now()->subDays(30);

        $deletedPosts = Post::onlyTrashed()
            ->where('deleted_at', '<=', $thirtyDaysAgo)
            ->forceDelete();

        $this->info("Old soft-deleted posts have been purged.");
        return 0;
    }
}
