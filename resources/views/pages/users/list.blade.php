@extends('layouts.app')

@push('styles')
@endpush

@section('content')
<div class="container">
	
    <div class="row">

    	<!-- Page Title -->
    	<div class="col-md-12 border-bottom d-flex justify-content-between mb-5">
			<h4 class="pt-2">User<small class="ml-2">&nbsp;<i class="fas fa-angle-double-right"></i>&nbsp;List</small></h4>
			<a href="{{ route('admin.user.create') }}" class="btn btn-sm btn-success mb-3 float-right"><i class="fas fa-plus"></i> Add User</a>
		</div>

		<!-- Page Filters -->
	<!-- 	<div class="col-md-12 mb-3">
			<h5>Search Filters</h5>
			<form>
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
						    <label for="formGroupExampleInput">Example label</label>
						    <input type="text" class="form-control form-control-sm" id="formGroupExampleInput" placeholder="Example input">
						</div>
					</div>
					<div class="col-md-3">
						
					</div>
					<div class="col-md-3">
						
					</div>
					<div class="col-md-3">
						<button class="btn btn-info btn-block" type="submit">Search</button>
						<button class="btn btn-warning btn-block" type="button" onclick="return location.reload()">Clear Search</button>
					</div>
				</div>
			</form>
		</div> -->

		<!-- Page Content -->
		
        <div class="col-md-12">
        	<form id="search-form" method="GET" action="{{ url('user/list') }}">
        	<div class="float-left mb-3">
        		<select class="form-control form-control-sm rounded-0" id="page-limit" name="page_limit">
					<option value="10" @if('10' == $searchFilter['page_limit'])) selected @endif>10</option>
					<option value="25" @if('25' == $searchFilter['page_limit'])) selected @endif>25</option>
					<option value="50" @if('50' == $searchFilter['page_limit'])) selected @endif>50</option>
					<option value="100" @if('100' == $searchFilter['page_limit'])) selected @endif>100</option>
			    </select>
        	</div>
        	<div class="float-right mb-3">
				<a href="{{ url('user/list') }}" class="btn btn-warning btn-sm" id="clear-search-btn" type="button"><i class="fas fa-sync-alt"></i>&nbsp;Clear Search</a>
        		<button class="btn btn-primary btn-sm" id="search-btn" type="button" onclick="return searchFilter()"><i class="fas fa-search"></i>&nbsp;Search</button>
        	</div>
        	<div class="table-responsive">
	            <table class="table table-striped table-condensed">
	                <thead>
	                    <tr>
	                        <th>ID</th>
	                        <th>Name</th>
	                        <th class="w-15">Username</th>
	                        <th>Email</th>
	                        <th>Role</th>
	                        <th class="w-10">Status</th>
	                        <th class="w-10 text-center">Action</th>
	                    </tr>
	                    <tr>
	                    	<th></th>
	                    	<th>
	                    		<input type="text" class="form-control form-control-sm rounded-0" id="name" name="name" placeholder="" value="{{ $searchFilter['name'] }}"></th>
	                    	<th>
	                    		<input type="text" class="form-control form-control-sm rounded-0" id="username" name="username" placeholder="" value="{{ $searchFilter['username'] }}">
	                    	</th>
	                    	<th>
	                    		<input type="text" class="form-control form-control-sm rounded-0" id="email" name="email" placeholder="" value="{{ $searchFilter['email'] }}">
	                    	</th>
	                    	<th>
	                    		<select class="form-control form-control-sm rounded-0" id="role" name="role">
	                    			<option value=""></option>
                            		@foreach($roleOpt as $role)
									<option value="{{ $role->id }}" @if($role->id == $searchFilter['role'])) selected @endif>{{ $role->name }}</option>
									@endforeach
							    </select>
	                    	</th>
	                    	<th>
	                    		<select class="form-control form-control-sm rounded-0" id="status" name="status">
									<option value=""></option>
									<option value="active" @if('active' == $searchFilter['status'])) selected @endif>Active</option>
									<option value="unverified" @if('unverified' == $searchFilter['status'])) selected @endif>For Verification</option>
									<option value="inactive" @if('inactive' == $searchFilter['status'])) selected @endif>Inactive</option>
									<option value="blocked" @if('blocked' == $searchFilter['status'])) selected @endif>Blocked</option>
							    </select>
	                    	</th>
	                    	<th></th>
	                    </tr>
	                </thead>
	    			</form>
	                <tbody>
	                	@if(count($users) > 0)
	                    @foreach($users as $i => $user)
	                    <tr>
	                        <td>{{ $user->id }}</td>
	                        <td>{{ $user->name }}</td>
	                        <td>{{ $user->username }}</td>
	                        <td>{{ $user->email }}</td>
	                        <td>{{ $user->role->name }}</td>
	                        <td>
	                        	<h6>
		                        	@if($user->active === NULL && $user->block == '0')<span class="badge badge-warning p-1 w-100">For Verification</span>@endif
		                        	@if(($user->active !== NULL && $user->active == 0) && $user->block == '0')<span class="badge badge-secondary p-1 w-100">Inactive</span>@endif
		                        	@if($user->active == '1' && $user->block == '0')<span class="badge badge-success p-1 w-100">Active</span>@endif
		                        	@if($user->block == '1')<span class="badge badge-danger p-1 w-100">Blocked</span>@endif
		                        </h6>
	                        </td>
	                        <td class="text-center">
	                        	@if(Auth::id() !== $user->id)
	                        	<form id="delete{!! $user->id !!}" action="{{ route('admin.user.delete', $user->id)}}" method="post" type="hidden">
				                  	@csrf
				                  	@method('DELETE')
				                </form>
	                        	<a href="{{ url('/user/edit/' . $user->id) }}" class="text-dark" title="edit user"><i class="fas fa-edit"></i></a>
	                        	<a href="javascript:void(0)" class="text-dark" title="delete user" onclick="return confirmDelete('{{ $user->id }}', '{{ $user->name }}')"><i class="fas fa-trash"></i></a>
	                        	@endif
	                        </td>
	                    </tr>
	                    @endforeach
	                    @else 
	                    <tr>
	                    	<td class="text-center" colspan="7">No record found</td>
	                    </tr>
	                    @endif
	                </tbody>
	            </table>
	        </div>
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">

function searchFilter() {
	$("#search-form").submit();
	
	// Un-disable form fields when page loads, in case they click back after submission
	$( "#search-form" ).find( ":input" ).prop( "disabled", false );
}

function confirmDelete(id, name) {

    swal.fire({
        title: "Delete User " + name + "?",
        text: "Are you sure you want to proceed? This cannot be undone.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        dangerMode: true,
    }).then((e) => {
        if (e.value) {
            $("#delete"+id).submit();
        }
    })
}

$(function() {
    // toastr.success('message', 'title')
    // alert( "ready!" );
});   

</script>
@endpush
