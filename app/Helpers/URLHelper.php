<?php

//used only in views and redirects to get a places index URL given a locale
function get_url($locale,$slug_key){
    return url("/".$locale."/".trans('otherworlds.'.$slug_key,[],$locale));
}
function places_url($locale){
    return get_url($locale, 'places_slug');
}
