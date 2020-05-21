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
                <form  id="form-article" method="POST" action="{{ route('article.store') }}" enctype="multipart/form-data">
                	@csrf
	                <h5 class="card-header text-center">Fill up article information</h5>
	                        
	                <div class="card-body">

                        <div class="form-group row">
                            <label for="category" class="col-md-2 col-form-label text-md-right">{{ __('Category') }}<span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <select class="form-control @error('category') is-invalid @enderror" id="category" name="category">
                                    <option value="">- Select Category -</option>
                                    @foreach($categoryOpt as $category)
                                    <option value="{{ $category->id }}" @if($category->id == old('category')) selected @endif>{{ $category->name }}</option>
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
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}">
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
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="article-content" class="col-md-2 col-form-label text-md-right">{{ __('Content') }}<span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <textarea name="content" id="article-content" hidden></textarea>
                                <div  id="summernote"></div>
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
                                    <option value="1" selected>Yes</option>
                                    <option value="0">No</option>
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
						    	<button id="btn-submit" class="btn btn-block btn-success" type="submit"><i class="fas fa-save"></i>&nbsp;{{ __('Save') }}</button>
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
