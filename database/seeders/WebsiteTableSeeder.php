<?php

namespace Database\Seeders;

use App\Models\Website;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WebsiteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('websites')->truncate();
        $websites = array(
            array(
                'name' => 'Test Name',
                'domain' => 'test@somedomain.com'
            ),
            array(
                'name' => 'Crypto Zombies',
                'domain' => 'test@crypto.com'
            )
        ) ;
        Website::insert($websites);
    }
}
