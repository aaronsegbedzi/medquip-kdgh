<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Equipment;
use QrCode;

class GenerateQR extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qr:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate QR Codes for all Equipments';

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
        $equipments = Equipment::select('id')->get();
        if ($equipments->count()) {
            foreach ($equipments as $equipment) {
                $url = env('APP_URL') . "/equipments/history/" . $equipment->id;
                $image = QrCode::format('png')->size(300)->generate($url, public_path('qrcodes/'.$equipment->id.'.png'));
            }
            $this->info('Finished generating QR codes for all equipments.');
        }
    }
}
