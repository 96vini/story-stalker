@extends('layouts.app')

@section('title', 'Results')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-12 text-center">

            <div class="col-md-12 logo-box">
                <img src="{{ asset('images/logo.png') }}" class="logo"/>
            </div>
            
            <form class="form-stories" method="POST" action="{{ route('stories.read') }}" autocomplete="off">
                @csrf
                <div>
                    <input class="form-control input-search" name="username" type="text" placeholder="Username" autocomplete="false">
                    <button type="submit" class="btn btn-search">Search</button>
                </div>
            </form>

            <div class="row justify-content-center align-items-center text-center">
                @isset($stories)
                    @isset($stories['code'])
                        <div>
                            @if($stories['code'] === 'NOT_FOUND_USER')
                                <h2>Nenhum usuário encontrado para esse username</h2>
                            @endif
                            @if($stories['code'] === 'NOT_FOUND_STORY')
                                <h2>Nenhum stories encontrado para esse usuário</h2>
                            @endif
                        </div>
                    @endif
                    @foreach($stories as $story)
                        <div class="col-lg-4 col-md-6 mb-2">
                                @if(isset($story['video_versions']))
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <video class="embed-responsive-item" style="max-width: 100%;" controls>
                                            <source src="data:image/png;base64,{{ base64_encode(file_get_contents($story['video_versions'][0]['url'])) }}" type="video/mp4">
                                            Seu navegador não suporta o elemento de vídeo.
                                        </video>
                                    </div>
                                @endif
                                @if(isset($story['image_versions2']) && !isset($story['video_versions']))
                                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents($story['image_versions2']['candidates'][1]['url'])) }}" class="img-fluid">
                                @endif
                        </div>
                    @endforeach
                @endisset
            </div>

        </div>
    </div>
</div>
@endsection
