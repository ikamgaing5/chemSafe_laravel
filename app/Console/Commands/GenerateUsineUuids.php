<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Usine;
use Illuminate\Support\Str;

class GenerateUsineUuids extends Command
{
    protected $signature = 'usine:generate-uuids';
    protected $description = 'Génère des UUIDs pour toutes les usines existantes';

    public function handle()
    {
        $usines = Usine::whereNull('uuid')->orWhere('uuid', '')->get();

        if ($usines->isEmpty()) {
            $this->info('Toutes les usines ont déjà un UUID.');
            return;
        }

        $bar = $this->output->createProgressBar(count($usines));
        $bar->start();

        foreach ($usines as $usine) {
            $usine->uuid = (string) Str::uuid();
            $usine->save();
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('UUIDs générés avec succès pour ' . count($usines) . ' usines.');
    }
}