<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Source;
use App\Models\OHelper;

class SourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Source::all() as $source) {
            try {
                $content = OHelper::getPageContent($source->url);
                $source->content = $content;
                $this->command->info(strlen($content));
                $source->save();
            } catch (\Throwable $th) {
                $this->command->error('WOOOOOOOOOOOOOOOOPS: ' . $th->getMessage());
            }
        }
    }
}
