@extends('layouts.app')

@push('styles')
<!-- <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet"> -->
<link href="{{ asset('css/summernote.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container">
    
    <div class="row justify-content-center">

        <!-- Page Title -->
        <div class="col-md-12 border-bottom d-flex justify-content-between mb-5">
            <h4 class="pt-2">Article<small class="ml-2">&nbsp;<i class="fas fa-angle-double-right"></i>&nbsp;Create</small></h4>
        </div>

        <!-- Page Content -->
        <div class="col-md-12">
            <div class="card">
                <form  id="form-article" method="POST" action="{{ route('article.update', $article->id) }}" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf
                    <h5 class="card-header text-center">Fill up article information</h5>
                            
                    <div class="card-body">

                        <div class="form-group row">
                            <label for="category" class="col-md-2 col-form-label text-md-right">{{ __('Category') }}<span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <select class="form-control @error('category') is-invalid @enderror" id="category" name="category">
                                    <option value="">- Select Category -</option>
                                    @foreach($categoryOpt as $category)
                                    @if($article->category_id == $category->id)
                                    <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                    @else
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endif
                                    @endforeach
                                </select>
                                @error('category')
                                    <span class="invalid-feedback" category="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="title" class="col-md-2 col-form-label text-md-right">{{ __('Title') }}<span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $article->title }}">
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="image" class="col-md-2 col-form-label text-md-right">{{ __('Cover Image') }}<span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="image" name="image">
                                    <label class="custom-file-label" for="customFile">Browse Image</label>
                                </div>
                                <!-- <input id="image" type="text" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}"> -->
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small class="form-text text-muted">Leave the cover image blank if you don't want to change cover image</small>
                            </div>
                            <div class="col-md-9 offset-2 d-none">
                                <p class="font-weight-bold">
                                    (Current Cover Image)<br>
                                    <img src="{{ $article->image_path }}">
                                </p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="article-content" class="col-md-2 col-form-label text-md-right">{{ __('Content') }}<span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <textarea name="content" id="article-content" hidden>{{ html_entity_decode($article->content) }}</textarea>
                                <div  id="summernote">{!! html_entity_decode($article->content) !!}</div>
                                <!-- <div id="content"></div> -->
                                <!-- <input id="content" type="text" class="form-control @error('content') is-invalid @enderror" name="content" value="{{ old('content') }}"> -->
                                @error('content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="visible" class="col-md-2 col-form-label text-md-right">{{ __('Visible') }}<span class="text-danger">*</span></label>
                            <div class="col-md-2">
                                <select class="form-control form-control-select @error('visible') is-invalid @enderror" id="visible" name="visible" data-placeholder="- Select -">
                                    <option value=""></option>
                                    <option value="1" @if($article->visible == 1) selected @endif>Yes</option>
                                    <option value="0" @if($article->visible == 0) selected @endif>No</option>
                                </select>
                                @error('visible')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="card-footer text-center">
                        <div class="row">
                            <div class="offset-2 col-md-4 pr-1">
                                <button id="btn-cancel" class="btn btn-block btn-danger" type="button" onclick="return window.history.back()"><i class="fas fa-window-close"></i>&nbsp;{{ __('Cancel') }}</button>
                            </div>
                            <div class="col-md-4 pl-1">
                                <button id="btn-submit" class="btn btn-block btn-success" type="button" onclick="return confirmUpdate()"><i class="fas fa-save"></i>&nbsp;{{ __('Save') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<!-- <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script> -->
<script src="{{ asset('js/summernote.js') }}"></script>
<script type="text/javascript">

function confirmUpdate(e) {
    swal.fire({
        title: "Update Article Information?",
        text: "Are you sure you want to save changes?",
        icon: "info",
        showCancelButton: true,
        confirmButtonText: 'Save Changes',
        cancelButtonText: 'Cancel',
        reverseButtons: true
        // dangerMode: true,
    }).then((e) => {
        if (e.value) {
            //disable buttons upon submit
            $("#btn-submit").attr("disabled", true);
            $("#btn-cancel").attr("disabled", true);
            $("#form-article").submit();
        }
    })
}

$(function() {

    $("#form-article").submit(function (e) {

        //disable buttons upon submit
        $("#btn-submit").attr("disabled", true);
        $("#btn-cancel").attr("disabled", true);

        return true;
    });

    $('#summernote').summernote({
        height:300,
        dialogsInBody: true,
        callbacks:{
            onInit:function(){
            $('body > .note-popover').hide();
            },
            onChange: function(e) {
               setTimeout(function(){
                    $("#article-content").val('');
                    $("#article-content").val($('#summernote').summernote('code'));
               },200);
            }
         },
    });

    $(".custom-file-input").on("change", function() {
      var fileName = $(this).val().split("\\").pop();
      $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

    // toastr.success('message', 'title')
    // alert( "ready!" );
});   

</script>
@endpush
