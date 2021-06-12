@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Edit Blogs</h2>
    <form action="{{route('blog-update')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{$blogs->id}}">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="text" value="{{$blogs->title}}" placeholder="Enter title" name="title">
            <span class="text-danger" id="">@error('title'){{ $message }}@enderror</span>
        </div>
        <div class="form-group">
            <label for="">Description</label>
            <textarea class="form-control" value="" placeholder="Enter description" name="description">{{$blogs->description}}</textarea>
            <span class="text-danger" id="">@error('description'){{ $message }}@enderror</span>
        </div>
        <div class="form-group">
            <label for="">Image</label>
            <a href="{{$imgurl}}" target="_blank">View Blog Image</a>
            <input type="file" value="" class="form-control" name="image">
            <input type="hidden" value="{{$blogs->image}}" name="old_iamge">
            <span class="text-danger" id="">@error('image'){{ $message }}@enderror</span>
        </div>
        <div class="form-group">
            <label>Tags</label>
            <input type="text" name="tags" class="form-control" value="{{$blogs->tags}}">
            <span class="text-danger" id="">@error('tags'){{ $message }}@enderror</span>
        </div>
        <input type="submit" class="btn btn-default" value="Update">
    </form>
</div>
@endsection