<?php

namespace App\Http\Controllers\PDI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLteController extends Controller
{
    public function adminlte_image (){
        $url = Auth::user()->profile_photo_url;
        if(!isset($url)){
            $url = 'https://picsum.photos/300/300';
        }
        return $url;
    }

    public function adminlte_desc()
    {
        return 'Selamat Datang';
    }

    public function adminlte_profile_url()
    {
        return 'profile.show';
    }

    public function adminlte_api_token_url()
    {
        return 'api-tokens.index';
    }
}
