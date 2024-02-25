<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\StoryService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Carbon\Carbon;

class StoryController extends Controller
{
    public $service;

    public function __construct() {
        $this->service = new StoryService();
    }

    public function index()
    {
        $date = Carbon::now();

        return view('home', ['year' => $date->year]);
    }

    public function read(Request $request)
    {
        $date = Carbon::now();

        $stories = $this->service->getStories($request->get('username'));

        return view('home', ['stories' => $stories, 'year' => $date->year] );
    }


    public function downloadImage(Request $request)
    {
        $url = $request->query('url');
        $filename = Str::afterLast($url, '/');
    
        $image_data = file_get_contents($url);
    
        $headers = [
            'Content-Type' => 'image/jpeg',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
    
        return response($image_data, 200, $headers);
    }
    

    public function downloadVideo(Request $request)
    {
        $url = $request->query('url');
        $filename = Str::afterLast($url, '/');
    
        $video_data = file_get_contents($url);
    
        $headers = [
            'Content-Type' => 'video/mp4', // ajuste conforme necessário
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
    
        return response($video_data, 200, $headers);
    }    
    
}
