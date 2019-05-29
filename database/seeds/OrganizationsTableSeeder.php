<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrganizationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $organizations = [
            [
                'name' => 'JPV',
                'description' => '',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ];

        DB::table('organizations')->insert($organizations);
    }
}
