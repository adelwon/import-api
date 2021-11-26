<?php

namespace App\Console\Commands;

use App\Models\Settlement;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

class GetNovaPoshtaData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:nova-poshta-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import settlements from Nova Poshta';

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
     * @return int
     * @throws GuzzleException
     */
    public function handle()
    {
        $i = 1;
        do {
            $data = $this->getData($i);
            if (count($data) > 0) {
                foreach ($data as $item) {
                    $settlement = new Settlement();
                    $settlement->id = $item->Ref;
                    $settlement->type = $item->SettlementTypeDescription;
                    $settlement->description = $item->Description;
                    $settlement->region_description = $item->RegionsDescription;
                    $settlement->area_description = $item->AreaDescription;
                    $settlement->index = $item->Index1;
                    $settlement->save();
                }
            }

            $i++;

        } while (count($data) > 0);

        return 0;
    }

    /**
     * @throws GuzzleException
     */
    public function getData(int $page): array
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('POST', 'https://api.novaposhta.ua/v2.0/json/', [
            "json" => [
                "modelName" => "Address",
                "calledMethod" => "getSettlements",
                "methodProperties" => [
                    'Page' => $page,
                    'Limit' => 100
                ],
                "apiKey" => "1a7d2fa0ae0544e6db407384f0ebc3a0"
            ]
        ]);

        return json_decode($res->getBody()->getContents())->data;
    }
}
