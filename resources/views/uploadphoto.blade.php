@extends('layouts.app')
@section('title', 'Upload a photo | LetzShare')
@section('content')

<!-- Div to show errors messages -->
<div class="errors hide errors-profile">
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <span class="errorMsg"></span>
    </div>
</div>
<!-- Div to show success messages -->
<div class="errors hide success-profile">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <span class="successMsg"></span>
        <div id="showNewPhoto"> </div>
    </div>

</div>

<form id="uploadform" class="formbox" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-10 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3>Upload photo</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="foto">Select a photo</label>
                        <div class="custom-file">
                            <input type="file" name="image" class="custom-file-input" id="foto" required>
                            <label class="custom-file-label" for="foto"></label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter the photo title" autocomplete="off" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="This is an amazin photo taked by {{ Auth::user()->name }}" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="locality">Locality</label>
                        <select class="custom-select" name="locality" id="locality" required>
                            <option value="" disabled>Select</option>
                            @foreach ($locations as $locality)
                                <option value="{{$locality->locality_id}}">{{$locality->locality_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="category">Category</label>
                        <select class="custom-select" name="category" id="category" required>
                            <option value="" disabled>Select</option>
                            @foreach ($categories as $category)
                                <option value="{{$category->category_id}}">{{ ucfirst($category->category_name) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Upload</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</form>

@endsection
