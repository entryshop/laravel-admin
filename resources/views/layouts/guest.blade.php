@extends('admin::layouts.html')

@section('body')
    <div {!! $_this->getAttributes() !!}>
        @include('admin::layouts.partials.children', ['children' => $_this->children ?? []])
    </div>
@endsection
