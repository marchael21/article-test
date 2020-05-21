@extends('layouts.app')

@push('styles')
@endpush

@section('content')
<div class="container">
	
    <div class="row">

    	<!-- Page Title -->
    	<div class="col-md-12 border-bottom d-flex justify-content-between mb-5">
			<h4 class="pt-2">Article<small class="ml-2">&nbsp;<i class="fas fa-angle-double-right"></i>&nbsp;List</small></h4>
			<a href="{{ route('article.create') }}" class="btn btn-sm btn-success mb-3 float-right"><i class="fas fa-plus"></i> Add Article</a>
		</div>

		<!-- Page Content -->
        <div class="col-md-12">
        	<form id="search-form" method="GET" action="{{ url('article/list') }}">
        	<div class="float-left mb-3">
        		<select class="form-control form-control-sm rounded-0" id="page-limit" name="page_limit">
					<option value="10" @if('10' == $searchFilter['page_limit'])) selected @endif>10</option>
					<option value="25" @if('25' == $searchFilter['page_limit'])) selected @endif>25</option>
					<option value="50" @if('50' == $searchFilter['page_limit'])) selected @endif>50</option>
					<option value="100" @if('100' == $searchFilter['page_limit'])) selected @endif>100</option>
			    </select>
        	</div>
        	<div class="float-right mb-3">
				<a href="{{ url('article/list') }}" class="btn btn-warning btn-sm" id="clear-search-btn" type="button"><i class="fas fa-sync-alt"></i>&nbsp;Clear Search</a>
        		<button class="btn btn-primary btn-sm" id="search-btn" type="button" onclick="return searchFilter()"><i class="fas fa-search"></i>&nbsp;Search</button>
        	</div>
        	<div class="table-responsive">
	            <table class="table table-striped table-condensed">
	                <thead>
	                    <tr>
	                        <!-- <th class="w-10">ID</th> -->
	                        <th>Cover Image</th>
	                        <th>Title</th>
	                        <th>Category</th>
	                        <th class="w-10 text-center">Status</th>
	                        <th class="w-10 text-center">Action</th>
	                    </tr>
	                    <tr>
	                    	<!-- <th>
	                    		<input type="text" class="form-control form-control-sm rounded-0" id="id" name="id" placeholder="" value="{{ $searchFilter['id'] }}"></th>
	                    	</th> -->
	                    	<th class="w-20"></th>
	                    	<th>
	                    		<input type="text" class="form-control form-control-sm rounded-0" id="cor-number" name="title" placeholder="" value="{{ $searchFilter['title'] }}">
	                    	</th>
	                    	<th>
	                    		<select class="form-control form-control-sm" id="category" name="category">
                                    <option value="">- Select Category -</option>
                                    @foreach($categoryOpt as $category)
                                    <option value="{{ $category->id }}" @if($searchFilter['category'] == $category->id) selected @endif>{{ $category->name }}</option>
                                    @endforeach
                                </select>
	                    	</th>
	                    	<th></th>
	                    </tr>	                    
	                </thead>
	            	</form>
	                <tbody>
	                	@if(count($articles) > 0)
	                    @foreach($articles as $i => $article)
	                    <tr>
	                        <!-- <td>{{ $article->id }}</td> -->
	                        <td>
	                        	<img class="img img-thumbnail" src="{{ $article->image_path }}">
	                        </td>
	                        <td>{{ $article->title }}</td>
	                        <td>{{ $article->category->name }}</td>
	                        <td class="text-center">
	                        	@if($article->visible == 1) <span class="badge badge-success p-1 w-100">Visible</span> @endif
	                        	@if($article->visible == 0) <span class="badge badge-danger p-1 w-100">Hidden</span> @endif
	                        </td>
	                        <td class="text-center">
	                        	<form id="delete{!! $article->id !!}" action="{{ route('article.delete', $article->id)}}" method="post" type="hidden">
				                  	@csrf
				                  	@method('DELETE')
				                </form>
				                <a href="{{ url('/article/view/' . $article->id) }}" class="text-dark" title="view article"><i class="fas fa-search"></i></a>
	                        	<a href="{{ url('/article/edit/' . $article->id) }}" class="text-dark" title="edit article"><i class="fas fa-edit"></i></a>
	                        	<a href="javascript:void(0)" class="text-dark" title="delete article" onclick="return confirmDelete('{{ $article->id }}', 'Title:{{ $article->title }}')"><i class="fas fa-trash"></i></a>
	                        </td>
	                    </tr>
	                    @endforeach
	                    @else 
	                    <tr>
	                    	<td class="text-center" colspan="8">No article found</td>
	                    </tr>
	                    @endif
	                </tbody>
	            </table>
	        </div>
            {{ $articles->links() }}
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
        title: "Delete Article " + name + "?",
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
