@extends('layouts.app')

@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            @if (Session::has('message_update'))
            <div id="card-alert" class="alert alert-success flashmessage">
                <div class="card-content white-text">
                    <p style="text-align: center;"><b>{{ Session::get('message_update') }}</b></p>
                </div>
            </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Blogs List</h4>
                </div>
                <div class="card-body">
                    <div id="toolbar" style="padding-bottom:25px;">
                        <a class="btn btn-sm btn-success" id="users" href="{{route('blogs-add')}}" style="float:right;">Add Blog</a>
                    </div>
                </div>
                <div class="card-body">

                    <table id="blogs-list-datatable" class="table">
                        <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Description</th>
                                <th>Tags</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                    <!-- Delete confirmation modal -->
                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Delete Blog</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h3>Are you sure you want to delete this blogs???</h3>
                                </div>
                                <div class="modal-footer">
                                <a href='#' class="modal-close btn btn-success yeDelete">Delete</a>
                                <a class="modal-close waves-effect btn btn-danger NoCancel" data-dismiss="modal">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('pageScript')
<script src="{{ asset('public/js/blogs.js?').time() }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script>
    var getBlogsList = '{{ route('blogs')}}';
    var deleteBlog = '{{ route('delete-blog')}}';
</script>
@endsection