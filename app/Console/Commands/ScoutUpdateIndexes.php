<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

class ScoutUpdateIndexes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scout:update-indexes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update scout model indexes.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (config('scout.meilisearch.index-settings') as $model => $settings) {
            /** @var $model Model */
            $model::query()
                ->where($model::CREATED_AT, '>', Carbon::now()->subDay()->startOfDay())
                ->searchable();
            $this->output->info($model . ' indexes were successfully updated.');
        }
    }
}
