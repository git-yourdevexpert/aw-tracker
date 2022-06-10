<?php
use App\Models\Site;
function siteName(){
    $user = auth()->user()->id;
    $site = Site::select('domain')->where('user_id',$user)->get();
    return $site;     
}
?>