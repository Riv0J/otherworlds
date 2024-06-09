<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Source;
use App\Models\OHelper;
class Admin_SourceController extends Controller{
    /**
     * Update an existing resource
     */
    public function ajax_update(Request $request){
        $data = $request->all();
        $source = Source::find($data['source_id']);

        if($source == null){
            return response()->json([
                'message' => new Message(Message::TYPE_ERROR, "Source not found"),
            ], 200);
        }
        $source->url = $data['source_url'];
        $messages = [];
        if($data['source_url'] && !$data['source_content']){
            try {
                $source->scrape_fill();
                $messages[] = new Message(Message::TYPE_SUCCESS, "Scraped content from Wiki URL");
            } catch (\Throwable $th) {
                $messages[] = new Message(Message::TYPE_ERROR, "Data scraping failed");
            }
        } else {
            $messages[] = new Message(Message::TYPE_SUCCESS, "Source updated");
            $source->title = $data['source_title'];
            $source->content = $data['source_content'];
            $source->save();
        }
        $variables = [
            'success' => true,
            'messages' => $messages,
            'source' => $source,
        ];
        return response()->json($variables);
    }

    /**
     * Create a new resource
     */
    public function ajax_create(Request $request){
        $data = $request->all();
        $source_url = $data['source_url'];
        $place_id = $data['place_id'];
        $locale = $data['locale'];

        if(!$source_url){
            return response()->json([
                'message' => new Message(Message::TYPE_ERROR, "Source URL required"),
            ], 200);
        }
        if(Source::where('locale', $locale)->where('place_id', $place_id)->exists()){
            return response()->json([
                'message' => new Message(Message::TYPE_ERROR, "A source for this place and language already exists"),
            ], 200);
        }
        $text = "No text";

        $source = Source::create([
            'locale' => $locale,
            'url' => $data['source_url'],
            'place_id' => $place_id,
        ]);

        if($source_url && !$data['source_content']){
            $text = "Scraped Wiki URL";
            try {
                $source->scrape_fill();
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => new Message(Message::TYPE_ERROR, "Data scraping failed"),
                ], 200);
            }
        } else {
            $text = "Source created";
            $source->title = $data['source_title'];
            $source->content = $data['source_content'];
            $source->save();
        }

        $variables = [
            'success' => true,
            'message' => new Message(Message::TYPE_SUCCESS, $text),
            'source' => $source
        ];
        return response()->json($variables);
    }
    /**
     * Delete a specific resource
     */
    public function ajax_delete(Request $request){
        $data = $request->all();
        $source = Source::find($data['source_id']);

        if($source == null){
            return response()->json([
                'message' => new Message(Message::TYPE_ERROR, "Source not found"),
            ], 200);
        }
        $variables = [
            'success' => true,
            'message' => new Message(Message::TYPE_SUCCESS, "Source deleted"),
            'source' => $source
        ];
        return response()->json($variables);
    }
}
