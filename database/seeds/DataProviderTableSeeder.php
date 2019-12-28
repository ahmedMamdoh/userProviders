<?php

use Illuminate\Database\Seeder;
use App\UserProvider;
use Carbon\Carbon;

class DataProviderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        $json = file_get_contents(storage_path('DataProviderY.json'));
        $data = json_decode($json, true);
       
        foreach ($data['users'] as $obj) {
            $obj = array_values($obj);
          $obj[4] = str_replace('/','-',$obj[4]);
            $mapped_data_entry = [
                "balance"    =>  $obj[0],
                "currency" =>  $obj[1],
                "email"  =>  $obj[2],
                "status"   => $obj[3],
                "registeration_date" => Carbon::parse($obj[4])->format('Y-m-d'),
                "identification"    => $obj[5],
                "provider" => 'DataProviderY'
            ];
            
           UserProvider::create($mapped_data_entry);
          
    }
        //
    }
}
