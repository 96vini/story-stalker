<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\StoryService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class StoryController extends Controller
{
    public $service;

    public function __construct() {
        $this->service = new StoryService();
    }

    public function index()
    {
        return view('home');
    }

    public function read(Request $request)
    {
        $stories = $this->service->getStories($request->get('username'));

        return view('home', ['stories' => $stories] );
    }

    public function download(Request $request)
    {
        $url = $request->query('filename');

        $response = Http::get($url);

        $filename = Str::afterLast($url, '/');

        $headers = [
            'Content-Type' => $response->header('Content-Type'),
        ];

        return response()->streamDownload(function () use ($response) {
            echo $response->body();
        }, $filename, $headers);
    }
}
