@extends('layouts.app')

@push('styles')
@endpush

@section('content')
<div class="container">
    
    <div class="row justify-content-center">

        <!-- Page Title -->
        <div class="col-md-12 border-bottom d-flex justify-content-between mb-5">
            <h4 class="pt-2">Article<small class="ml-2">&nbsp;<i class="fas fa-angle-double-right"></i>&nbsp;Preview</small></h4>
        </div>

        <!-- Page Content -->
        <h4 class="header-title">{{ $article->title }}</h4>
        <div class="col-md-12 text-center">
            <img src="{{ $article->image_path }}">
        </div>
        <div class="col-md-12">
            {!! html_entity_decode($article->content) !!}
        </div>

    </div>
</div>
@endsection

@push('scripts')
@endpush
