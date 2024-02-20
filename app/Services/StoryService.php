<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class StoryService {

    public function api($endpoint) {
        return Http::withHeaders([
            'X-InstagAPI-Key' => env('API_INSTAG_KEY')
        ])->get($endpoint);
    }

    public function getStories($username) {
        $user_id = $this->getUserIdByUsername($username);
        return $this->getStoriesByUserId($user_id);
    }

    public function getUserIdByUsername($username, $route = 'userid') {
        return Cache::remember("user_id_$username", 60 * 60, function () use ($username, $route) {
            $endpoint = env('API_INSTAG_URL') . "/$route/$username";
            $response = $this->api($endpoint);

            if ($response->successful()) {
                return $response->json('data');
            }

            return null;
        });
    }

    public function getStoriesByUserId($user_id, $route = 'userstories') {
        return Cache::remember("stories_$user_id", 60 * 60, function () use ($user_id, $route) {
            $endpoint = env('API_INSTAG_URL') . "/$route/$user_id";
            $response = $this->api($endpoint);
    
            if ($response->successful()) {
                $stories = [];
                $data = $response->json('data');
    
                foreach ($data as $index => $story) {
                    if (isset($story['video_versions'])) {
                        $type = 'VIDEO';
                        $url = $story['video_versions'][0]['url'];
                    } elseif (isset($story['image_versions2']['candidates'][0]['url'])) {
                        $type = 'IMAGE';
                        $url = $story['image_versions2']['candidates'][0]['url'];
    
                        $fileData = Http::get(trim($url))->body();
                        $extension = 'png';
                        $filePath = "app/public/$user_id/images/".($index + 1).".$extension";
    
                        Storage::disk('public')->put($filePath, $fileData, 'public');
    
                        $url = Storage::url($filePath);
                    } else {
                        continue;
                    }
    
                    $stories[] = ['type' => $type, 'url' => $url];
                }
    
                return $stories;
            }
    
            return [];
        });
    }
    
    
}
