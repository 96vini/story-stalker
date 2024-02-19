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
                            @isset($story['type'])
                                @if ($story['type'] == 'IMAGE')
                                    <img src="{{ $story['url'] }}" class="img-fluid" alt="Imagem">
                                @endif
                                @if ($story['type'] == 'VIDEO')
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <video class="embed-responsive-item" style="max-width: 100%;" controls>
                                            <source src="{{ $story['url'] }}" type="video/mp4">
                                            Seu navegador não suporta o elemento de vídeo.
                                        </video>
                                        <a class="btn btn-download" href="{{ route('story.download', ['filename' => $story['url'] ]) }}">Download</a>
                                    </div>
                                @endif
                            @endisset
                        </div>
                    @endforeach
                @endisset
            </div>

        </div>
    </div>
</div>
@endsection
