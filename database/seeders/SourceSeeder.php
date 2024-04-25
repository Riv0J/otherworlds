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
                $content_data = OHelper::getWikiContent($source->url);
                $this->command->info($source->place->name.": ".strlen($content_data['content']));

                $source->content = $content_data['content'];
                $source->title = $content_data['title'];
                $source->save();

                //apply the coords
                if($content_data['latitude'] != null && $content_data['longitude'] != null){
                    $source->place->latitude = $content_data['latitude'];
                    $source->place->longitude = $content_data['longitude'];
                    $source->place->save();

                    // $this->command->info("Saved Coordinates: ".$content_data['latitude'].",".$content_data['longitude']);
                }else{

                }
            } catch (\Throwable $th) {
                $this->command->error('No resource for Place: '.$source->place->name.'.');
                $this->command->error('------ Message: '. $th->getMessage());
            }
        }
    }
}
