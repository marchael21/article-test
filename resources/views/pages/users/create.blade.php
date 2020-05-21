@extends('layouts.app')

@push('styles')
@endpush

@section('content')
<div class="container">
	
    <div class="row justify-content-center">

    	<!-- Page Title -->
    	<div class="col-md-12 border-bottom d-flex justify-content-between mb-5">
			<h4 class="pt-2">User<small class="ml-2">&nbsp;<i class="fas fa-angle-double-right"></i>&nbsp;Create</small></h4>
		</div>

		<!-- Page Content -->
        <!-- <div class="col-md-12">

        </div> -->

        <div class="col-md-8">
            <div class="card">
                <form id="form-user" method="POST" action="{{ route('admin.user.store') }}">
                	@csrf
	                <h5 class="card-header text-center">Fill up user information</h5>
	                        
	                <div class="card-body">

                        <div class="form-group row">
                            <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Role') }}<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <select class="form-control @error('role') is-invalid @enderror" id="role" name="role">
                                    <option value=""></option>
                                    @foreach($roleOpt as $role)
                                    <option value="{{ $role->id }}" @if($role->id == old('role')) selected @endif>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

	                    <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}<span class="text-danger">*</span></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" autocomplete="username">
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="contact-number" class="col-md-4 col-form-label text-md-right">{{ __('Contact Number') }} </label>

                            <div class="col-md-6">
                                <input id="contact-number" type="text" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ old('contact_number') }}">

                                @error('contact_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>

	                </div>

					<div class="card-footer text-center">
						<div class="row">
							<div class="offset-3 col-md-4 pr-1">
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
<script type="text/javascript">

$(function() {

    
    $("#form-user").submit(function (e) {
        //stop submitting the form to see the disabled button effect
        e.preventDefault();

        //disable buttons upon submit
        $("#btn-submit").attr("disabled", true);
        $("#btn-cancel").attr("disabled", true);

        return true;
    });

    // toastr.success('message', 'title')
    // alert( "ready!" );
});   

</script>
@endpush
