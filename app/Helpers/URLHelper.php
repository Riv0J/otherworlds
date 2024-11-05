<?php

//used only in views and redirects to get a places index URL given a locale
function get_url($locale,$slug_key){
    return url("/".$locale."/".trans('otherworlds.'.$slug_key,[],$locale));
}
function places_url($locale){
    return get_url($locale, 'places_slug');
}

use App\Models\Message;

function success_message($message) {
    Session::flash('message', new Message(Message::TYPE_SUCCESS, $message));
}

function error_message($message) {
    Session::flash('message', new Message(Message::TYPE_ERROR, $message));
}