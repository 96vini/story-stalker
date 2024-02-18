@extends('layouts.app')

@section('title', 'Results')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-12 text-center">

            <div class="col-md-12 logo-box">
                <img src="{{ asset('images/logo.png') }}" class="logo"/>
            </div>
            
            <form class="form-stories" method="POST" action="{{ route('stories.read') }}">
                @csrf
                <div>
                    <input class="form-control input-search" name="username" type="text" placeholder="Username" aria-label=".form-control-lg example">
                    <button type="submit" class="btn btn-search">Search</button>
                </div>
            </form>

            <div class="row justify-content-center align-items-center text-center">
                @isset($stories)
                    @foreach($stories as $story)
                        <div class="col-lg-4 col-md-6 mb-2">
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
                        </div>
                    @endforeach
                @endisset
            </div>

        </div>
    </div>
</div>
@endsection
