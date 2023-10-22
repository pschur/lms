<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClientCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'client:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a client for API authentication';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('What is the name of the client?');

        $client = \App\Models\Client::create([
            'name' => $name,
        ]);

        $this->info('Client created successfully.');
        $this->info('Client ID: ' . $client->id);
    }
}
