<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

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

            $type = $story['video_versions'] ? 1 : 2;

            switch ($type) {
                case 1:
                    $stories[] = ['type' => 'VIDEO', 'url' => $story['video_versions'][0]['url']];
                    break;
                case 2:
                    $stories[] = ['type' => 'IMAGE', 'url' => $story['image_versions2'][0]['candidates'][0]['url']];
                    break;
            }

        }

        return $stories;
    }
}