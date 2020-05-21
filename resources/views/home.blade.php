@extends('layouts.app')

@push('styles')
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong><i class="fas fa-info-circle fa-lg"></i>&nbsp;Welcome {{ Auth::user()->name }}!</strong> You are logged in.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">Welcome {{ Auth::user()->name }}!</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
// $(function() {
//     // toastr.success('message', 'title')
//     // alert( "ready!" );
// });   

</script>
@endpush
