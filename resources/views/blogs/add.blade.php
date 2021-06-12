@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Add Blogs</h2>
    <form action="{{route('blog-save')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="text" placeholder="Enter title" name="title">
            <span class="text-danger" id="">@error('title'){{ $message }}@enderror</span>
        </div>
        <div class="form-group">
            <label for="">Description</label>
            <textarea class="form-control" value="" placeholder="Enter description" name="description"></textarea>
            <span class="text-danger" id="">@error('description'){{ $message }}@enderror</span>
        </div>
        <div class="form-group">
            <label for="">Image</label>
            <input type="file" value="" class="form-control" name="image">
            <span class="text-danger" id="">@error('image'){{ $message }}@enderror</span>
        </div>
        <div class="form-group">
            <label>Tags</label>
            <input type="text" name="tags" class="form-control">
            <span class="text-danger" id="">@error('tags'){{ $message }}@enderror</span>
        </div>
        <input type="submit" class="btn btn-info" value="save">
    </form>
</div>
@endsection