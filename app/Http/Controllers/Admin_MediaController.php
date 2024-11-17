<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Media;
use App\Models\Message;
use App\Models\Crawly;
class Admin_MediaController extends Controller{

    /**
     * Ajax, DELETE a specific Media
     */
    public function ajax_delete(Request $request){
        $data = $request->all();
        $media = Media::find($data['media_id']);
        $response = [];
        if($media == null){
            $response['message'] = new Message(Message::TYPE_ERROR, 'Media not found');
        } else {
            $media->delete();
            $response['success'] = true;
            $response['message'] = new Message(Message::TYPE_SUCCESS, 'Media deleted');
        }
        return response()->json($response);
    }

    /**
     * Ajax, CREATE a specific Media via upload
     */
    //protected $fillable = ['url', 'thumbnail_url', 'page_url', 'place_id'];
    public function ajax_create(Request $request){
        $validated = $request->validate([
            'place_id' => 'required|exists:places,id',
            'page_url' => 'required|string|max:255',
        ]);

        $data_result = Crawly::get_media_data($validated['page_url']);

        // obtener la url y thumbnail url a partir de 'page_url' para la media
        $new_media = Media::create([
            'place_id' => $validated['place_id'],
            'url' => $data_result['url'],
            'thumbnail_url' => $data_result['url'],
            'page_url' => $validated['page_url']
        ]);
        $response = [
            'new_media' => $new_media,
            'success' => true,
            'message' => new Message(Message::TYPE_SUCCESS, 'Media added'),
        ];
        return response()->json($response);
    }
}
