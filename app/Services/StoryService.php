<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

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
        $endpoint = env('API_INSTAG_URL')."/$route/$username";
        
        $response = $this->api($endpoint);

        if($response->serverError()) return ['code' => 'NOT_FOUND_USER'];

        $response = $response->json();

        if($response['status'] === 'fail')  return ['code' => 'NOT_FOUND_USER'];

        return $this->getStoriesByUserId($response['data']);
    }

    public function getStoriesByUserId($user_id, $route = 'userstories') {
        $endpoint = env('API_INSTAG_URL')."/$route/$user_id";

        $response = $this->api($endpoint);
        
        if($response->serverError()) return ['code' => 'NOT_FOUND_STORY'];

        $response = $response->json();

        if($response['data'] === null)  return ['code' => 'NOT_FOUND_STORY'];


        foreach($response['data'] as $story) {

            $story_id = $story['id'];

            if(isset($story['video_versions'])) {
                $type = 1;
            } else {
                $type = 2;
            }
   
            switch ($type) {
                
                case 1:
                    Storage::disk('public')->put("app/public/$user_id/videos/$story_id.mp4", file_get_contents(trim($story['video_versions'][0]['url'])), 'public');
                    $stories[] = ['type' => 'VIDEO', 'url' => env('APP_URL')."/storage/app/public/$user_id/videos/$story_id.mp4"];
                    break;
                case 2:
                    Storage::disk('public')->put("app/public/$user_id/images/$story_id.png", file_get_contents(trim($story['image_versions2']['candidates'][0]['url'])), 'public');
                    $stories[] = ['type' => 'IMAGE', 'url' => env('APP_URL')."/storage/app/public/$user_id/images/$story_id.png"];
                    break;
            }

        }

        return $stories;
    }
}