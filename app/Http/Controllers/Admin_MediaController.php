<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Media;
use App\Models\Message;

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
    public function ajax_create(Request $request){
        return response()->json($request);
    }
}
