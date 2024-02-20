<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class StoryService {

    public function api($endpoint) {
        return Http::withHeaders([
            'X-InstagAPI-Key' => env('API_INSTAG_KEY')
        ])->get($endpoint);
    }

    public function getStories($username) {
        return $this->getUserIdByUsername($username);
    }

    public function getUserIdByUsername($username, $route = 'userid') {

        $keyCache = "user_id:$username";

        if(Cache::has($keyCache)) return $this->getStoriesByUserId(Cache::get($keyCache));

        $endpoint = env('API_INSTAG_URL')."/$route/$username";
        
        $response = $this->api($endpoint);

        if($response->serverError()) return ['code' => 'NOT_FOUND_USER'];

        $response = $response->json();

        if($response['status'] === 'fail')  return ['code' => 'NOT_FOUND_USER'];
        
        Cache::put($keyCache, $response['data']);

        return $this->getStoriesByUserId($response['data']);
    }

    public function getStoriesByUserId($user_id, $route = 'userstories') {

        $cacheKey = "stories:$user_id";

        //if(Cache::has($cacheKey)) return Cache::get($cacheKey);
        
        $endpoint = env('API_INSTAG_URL')."/$route/$user_id";

        $response = $this->api($endpoint);
        
        if($response->serverError()) return ['code' => 'NOT_FOUND_STORY'];

        $response = $response->json();

        if($response['data'] === null)  return ['code' => 'NOT_FOUND_STORY'];
        
        Cache::put("stories:$user_id", $response['data']);

        return $response['data'];
    }

    public function saveFiles($stories, $user_id) {
        foreach ($stories as &$story) { // Use "&" para passar a referência do array
            $storyId = $story['id'];
        
            if (isset($story['video_versions'])) {
                $videoContent = file_get_contents($story['video_versions'][0]['url']);
                Storage::disk('public')->put("users/$user_id/videos/$storyId.mp4", $videoContent);
                $story['video_versions'][0]['url'] = Storage::disk('public')->url("users/$user_id/videos/$storyId.mp4");
            } elseif (isset($story['image_versions2'])) {
                $imageContent = file_get_contents($story['image_versions2']['candidates'][0]['url']);
                $imageName = "$storyId.png";
                Storage::disk('public')->put("users/$user_id/images/$imageName", $imageContent);
                $story['image_versions2']['candidates'][0]['url'] = Storage::disk('public')->url("users/$user_id/images/$imageName");
            }
        }
    
        return $stories;
    }

}