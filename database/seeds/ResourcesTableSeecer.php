<?php

use Illuminate\Database\Seeder;

class ResourcesTableSeecer extends Seeder
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
                'name' => 'Swift - HNG Main',
                'type' => 'internet',
            ],
            [
                'name' => 'Smile - HNG Annex',
                'type' => 'internet',
            ]
        ];

        foreach ($$resources as $resource) {
            Resource::create($resources);
        }
    }
}
