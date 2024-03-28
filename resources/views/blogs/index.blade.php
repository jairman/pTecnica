@extends('layouts.app')
@section('content')
    <div class="container">
        <h1 class="mt-5 mb-4">Últimas Noticias</h1>
        @foreach ($data as $news)
            <div class="card mt-5 ml-5" style="width:90%">
                <div class="row center">
                    <div class="col-sm-2 text-center mt-1">
                        <img src="{{ $news['image'] }}" class="card-img-top" alt="{{ $news['author'] }}" style="width:128px;height:128px">
                    </div>
                    <div class="col-sm-10">
                        <div class="card-body">
                            <h5 class="card-title">{{ $news['title'] }}</h5>
                            <p class="card-text">{{ $news['description'] }}</p>

                            <p class="card-text"><small class="text-muted"> Author: {{ $news['author'] }}</small></p>

                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="pagination justify-content-center mt-2">

            {{ $paginator->links() }}
        </div>
    </div>
@endsection
