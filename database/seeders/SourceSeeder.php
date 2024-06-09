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
                $content_data = $source->scrape_fill();
                $this->command->info($source->place->name.": ".strlen($content_data['content']));
                if($content_data['latitude'] != null && $content_data['longitude'] != null){
                    $this->command->info("Saved Coordinates: ".$content_data['latitude'].",".$content_data['longitude']);
                }
            } catch (\Throwable $th) {
                $this->command->error('No resource for Place: '.$source->place->name.'.');
                $this->command->error('------ Message: '. $th->getMessage());
            }
        }
    }
}
