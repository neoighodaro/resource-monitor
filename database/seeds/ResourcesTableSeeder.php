<?php

use Illuminate\Database\Seeder;

class ResourcesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resources = [
            [
                'name' => 'HNG Main',
                'type' => 'power'
            ],
            [
                'name' => 'HNG Annex',
                'type' => 'power'
            ],
            [
                'name' => 'Smile - Main',
                'type' => 'internet'
            ],
            [
                'name' => 'Smile - Annex',
                'type' => 'internet'
            ]
        ];

        foreach ($resources as $resource) {
            App\Resource::create($resource);
        }
    }
}
