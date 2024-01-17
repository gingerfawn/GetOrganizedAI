<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;


class MediaController extends Controller
{
    public function view(Request $request){

        return view('media-gallery')->with('url', $url);
    }
}
