@extends('layouts.app')

@push('styles')
<!-- <link href="{{ asset('css/datepicker.css') }}" rel="stylesheet"> -->
<!-- <link href="{{ asset('css/datetimepicker.css') }}" rel="stylesheet"> -->
@endpush

@section('content')
<div class="container">
	
    <div class="row justify-content-center">

    	<!-- Page Title -->
    	<div class="col-md-12 border-bottom d-flex justify-content-between mb-5">
			<h4 class="pt-2">Profile<small class="ml-2">&nbsp;<i class="fas fa-angle-double-right"></i>&nbsp;Information</small></h4>
		</div>

		<!-- Page Content -->
        <!-- <div class="col-md-12">

        </div> -->

        <div class="col-md-8">
            <div class="card">
                <form id="update-profile" method="POST" action="{{ route('updateProfile') }}" autocomplete="off">
                	@csrf
	                <h5 class="card-header">Profile</h5>
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
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $user->username }}">
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

                        @if(Auth::user()->role_id === 3)
                        <div id="form-group-position" class="form-group row">
                            <label for="position" class="col-md-4 col-form-label text-md-right">{{ __('Position') }}</label>

                            <div class="col-md-6">
                                <input id="position" type="text" class="form-control @error('position') is-invalid @enderror" name="position" value="{{ $user->position }}" maxlength="100">

                                @error('position')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div id="form-group-official-station" class="form-group row">
                            <label for="official-station" class="col-md-4 col-form-label text-md-right">{{ __('Official Station') }}</label>

                            <div class="col-md-6">
                                <input id="official-station" type="text" class="form-control @error('official_station') is-invalid @enderror" name="official_station" value="{{ $user->official_station }}" maxlength="100">

                                @error('official_station')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div id="form-group-monthly-salary" class="form-group row">
                            <label for="monthly-salary" class="col-md-4 col-form-label text-md-right">{{ __('Monthly Salary') }}</label>

                            <div class="col-md-6">
                                <input id="monthly-salary" type="text" class="form-control amount @error('monthly_salary') is-invalid @enderror" name="monthly_salary" value="{{ $user->monthly_salary !== NULL ? number_format($user->monthly_salary, 2) : '' }}" maxlength="12">

                                @error('monthly_salary')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @endif

                        <hr class="mt-3 mb-3">

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <small class="form-text text-muted">
                                  If you don't want to change your password, just leave the password fields empty/blank.
                                </small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="current-password" class="col-md-4 col-form-label text-md-right">{{ __('Current Password') }} </label>
                            <div class="col-md-6">
                                <input id="current-password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" autocomplete="new-password">

                                @error('current_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('New Password') }} </label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">

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
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>

	                </div>

					<div class="card-footer text-center">
						<button id="update-profile-btn" class="btn btn-success" type="button" onclick="return confirmUpdate()"><i class="fas fa-save"></i>&nbsp;{{ __('Update Profile') }}</button>
					</div>
				</form>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<!-- <script src="{{ asset('js/datepicker.js') }}"></script>
<script src="{{ asset('js/datetimepicker.js') }}"></script> -->

<script>
    $(document).ready(function() {
        // $('.datepicker').datepicker();
//         $('#datetimepicker1').datetimepicker({
//   allowInputToggle: true
// });
    });
</script>
<script type="text/javascript">

function confirmUpdate(e) {

    swal.fire({
        title: "Update Your Profile?",
        text: "Are you sure you want to save changes?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'Save Changes',
        cancelButtonText: 'Cancel',
        reverseButtons: true
        // dangerMode: true,
    }).then((e) => {
        if (e.value) {
            $("#update-profile").submit();
        }
    })
}

$(function() {
    // toastr.success('message', 'title')
    // alert( "ready!" );
});   

</script>
@endpush
