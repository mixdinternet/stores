<?php

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Seeder;
use Mixdinternet\Stores\Store;

class StoresTableSeeder extends Seeder
{
    public function run()
    {
        EloquentModel::unguard();

        DB::table('stores')->truncate();

        $stores = json_decode(file_get_contents(__DIR__ . '/stores.json'));
        foreach ($stores as $store) {
            $data = [
                'id' => $store->id
                , 'status' => $store->status
                , 'type' => 'stores'
                , 'name' => $store->name
                , 'zipcode' => $store->zipcode
                , 'address' => $store->address
                , 'phone' => $store->phone
                , 'latitude' => $store->latitude
                , 'longitude' => $store->longitude
                , 'description' => $store->description
                , 'city' => $store->city
                , 'state' => $store->state
            ];

            if (Store::create($data)) {
                $this->command->info('OK - Lojas ' . $store->name);
            } else {
                $this->command->info('FAIL - Lojas ' . $store->name);
            }
        }
    }
}
