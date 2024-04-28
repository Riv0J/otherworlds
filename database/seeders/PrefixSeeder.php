<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrefixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $prefixes_data = [
            [
                'keyword' => 'wikimedia_commons',
                'url' => 'https://commons.wikimedia.org/',
                'description' => 'general wikimedia link'
            ],
            [
                'keyword' => 'wikimedia_gallery',
                'url' => 'https://commons.wikimedia.org/wiki/',
                'description' => 'wikimedia gallery prefix, followed by place name, eg. Antelope_Canyon'
            ],
            [
                'keyword' => 'wikimedia_gallery_alt',
                'url' => 'https://commons.wikimedia.org/wiki/Category:',
                'description' => 'alternate wikimedia gallery prefix, followed by place name, eg. Antelope_Canyon'
            ],
            [
                'keyword' => 'wikimedia_upload',
                'url' => 'https://upload.wikimedia.org/wikipedia/commons/',
                'description' => 'wikimedia gallery images prefix'
            ],
        ];

        foreach ($prefixes_data as $prefix_data) {
            \App\Models\Prefix::create($prefix_data);
        }
    }
}
