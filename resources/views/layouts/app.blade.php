@extends('admin::layouts.html')

@section('body')
    <header>
        @if($back = $_this->back())
            <a href="{{$back}}">Back</a>
        @endif
        {{$_this->title()}}
    </header>
    <main class="container">
        @include('admin::layouts.partials.children', ['children' => $_this->children ?? []])
    </main>
@endsection
