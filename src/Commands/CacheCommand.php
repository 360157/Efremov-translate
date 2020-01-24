<?php

namespace Sashaef\TranslateProvider\Commands;

use Illuminate\Console\Command;
use Sashaef\TranslateProvider\Traits\TranslationsTrait;

class CacheCommand extends Command
{
    use TranslationsTrait;

    protected $signature = 'translate:cache';

    protected $description = 'Cache translations';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        self::restartTranslationByType();

        $this->info('Translate cache cleared!');
        $this->info('Translate cached successfully!');
    }
}
