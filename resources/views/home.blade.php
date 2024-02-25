@extends('layouts.app')

@section('title', 'Watch stories anonymously')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-12 text-center">

            <div class="col-md-12 logo-box">
                <a href="/"><img src="{{ asset('images/logo.png') }}" class="logo" alt="Logotipo for StoryStalker"/></a>
            </div>
            
            <form class="form-stories" method="POST" action="{{ route('stories.read') }}" autocomplete="off">
                @csrf
                <div>
                    <input class="form-control input-search" style="border-radius: 30px;border-radius: 30px;
                    padding: 10px 20px;" name="username" type="text" placeholder="Username" autocomplete="false">
                    <button type="submit" class="btn btn-search btn-secondary" style="border-radius: 30px;padding: 5px 25px;">Search</button>
                </div>
            </form>

            <div class="row justify-content-center align-items-center text-center">
                @isset($stories)
                    @isset($stories['code'])
                        <div>
                            @if($stories['code'] === 'NOT_FOUND_USER')
                                <img src="{{ asset('images/not-found.png') }}"/>
                                <h2>User not found for this username.</h2>
                            @endif
                            @if($stories['code'] === 'NOT_FOUND_STORY')
                                <img src="{{ asset('images/not-found.png') }}"/>
                                <h2>No stories found for this user.</h2>
                            @endif
                        </div>
                    @endif
                    <div style="display: flex; flex-wrap: wrap; justify-content: center;">
                        @foreach($stories as $story)
                            @if(isset($story['video_versions']))
                                <div class="item" style="padding: 5px;">
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <video class="embed-responsive-item" style="max-width: 100%;width: 40vh; height: auto;" controls>
                                            <source src="{{ $story['video_versions'][0]['url'] }}" type="video/mp4">
                                            Seu navegador não suporta o elemento de vídeo.
                                        </video>
                                    </div>
                                    <div style="text-align: center;padding-top: 5px;">
                                        <a class="btn btn-success" style="border-radius: 30px;" href="{{ route('story.downloadVideo', ['url' => $story['video_versions'][0]['url']]) }}" download><i class="bi bi-download"></i> Download</a>
                                    </div>
                                </div>
                            @endif
                            @if(isset($story['image_versions2']) && !isset($story['video_versions']))
                                <div class="item" style="padding: 5px;">
                                    <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($story['image_versions2']['candidates'][1]['url'])) }}" class="img-fluid" style="max-width: 100%;width: 40vh; height: auto;border-radius: 10px;">
                                    <div style="text-align: center;padding-top: 5px;">
                                        <a class="btn btn-success" style="border-radius: 30px;" href="{{ route('story.downloadImage', ['url' => $story['image_versions2']['candidates'][1]['url']] ) }}" download><i class="bi bi-download"></i> Download</a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>                    
                @endisset
            </div>                      
        </div>
    </div>
</div>