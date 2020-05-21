@extends('layouts.app')

@push('styles')
@endpush

@section('content')
<div class="container">
	
    <div class="row justify-content-center">

    	<!-- Page Title -->
    	<div class="col-md-12 border-bottom d-flex justify-content-between mb-5">
			<h4 class="pt-2">User<small class="ml-2">&nbsp;<i class="fas fa-angle-double-right"></i>&nbsp;Edit</small></h4>
		</div>

		<!-- Page Content -->
        <!-- <div class="col-md-12">

        </div> -->

        <div class="col-md-8">
            <div class="card">
                <form id="form-user" method="POST" action="{{ route('admin.user.update', $user->id) }}">
                    @method('PATCH')
                	@csrf
	                <h5 class="card-header text-center">User Information</h5>
	                        
	                <div class="card-body">
	                    <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }} </label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }} </label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Username') }} </label>
                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $user->username }}" autocomplete="username">
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
                                <input id="contact-number" type="text" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ $user->contact_number }}">

                                @error('contact_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Role') }} </label>
                            <div class="col-md-6">
                                <input type="text" readonly class="form-control-plaintext" value="{{ $user->role->name }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Is active?') }} </label>
                            <div class="col-md-6">
                                <label class="switch float-left mt-1">
                                  <input type="checkbox" class="form-control primary" name="active" value="1" @if($user->active) checked @endif>
                                  <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Blocked User?') }} </label>
                            <div class="col-md-6">
                                <label class="switch float-left mt-1">
                                  <input type="checkbox" class="form-control danger" name="block" value="1" @if($user->block) checked @endif>
                                  <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <hr class="mt-3 mb-3">

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <small class="form-text text-muted">
                                  If you don't want to change your password, just leave the password fields empty/blank.
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('New Password') }} </label>
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
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }} </label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>

	                </div>

					<div class="card-footer text-center">
						<div class="row">
							<div id="btn-cancel" class="offset-3 col-md-3 pr-1">
								<button class="btn btn-block btn-danger" type="button" onclick="window.history.back()"><i class="fas fa-window-close"></i>&nbsp;{{ __('Cancel') }}</button>
							</div>
							<div class="col-md-3 pl-1">
						    	<button id="btn-submit" class="btn btn-success btn-block" type="button" onclick="return confirmUpdate()"><i class="fas fa-save"></i>&nbsp;{{ __('Save') }}</button>
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

function confirmUpdate(e) {
    swal.fire({
        title: "Update User Information?",
        text: "Are you sure you want to save changes?",
        icon: "warning",
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
            $("#form-user").submit();
        }
    })
}


$(function() {
    // toastr.success('message', 'title')
    // alert( "ready!" );
});   

</script>
@endpush
