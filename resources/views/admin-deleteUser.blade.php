@extends('layouts.app')

@section('title', 'Admin Dashboard | LetzShare')

@section('content')

<h1>Admin Dashborad</h1>
<hr>
<form action="/admin/{{ $user->user_id }}" method="POST">
  @csrf
  @method('DELETE')
<h3>Photos from user <a href="/userprofile/{{ $user->user_id }}" class="badge badge-secondary">{{ $user->name }}, ID: {{ $user->user_id }}</a></h3>
<div class="table-responsive">
    <table class="table table-sm table-striped table-bordered table-hover">
        <thead class="thead-dark">
          <tr>
            <th scope="col">photo_id <i class="fa fa-fw fa-sort"></i></th>
            <th scope="col">image_URL <i class="fa fa-fw fa-sort"></i></th>
            <th scope="col">image_title <i class="fa fa-fw fa-sort"></i></th>
            <th scope="col">image_description</i></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($photos as $photo)
            <tr>
            <td>{{ $photo->photo_id }}</td>
              <td>{{ $photo->image_URL }}</td>
              <td>{{ $photo->image_title }}</td>
              <td>{{ str_limit($photo->image_description, 90, '...') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <button type="submit" class="btn btn-danger">Delete user & all related photos</button>
      <a class="btn btn-secondary" href="{{ url()->previous() }}" role="button">Cancel</a>
</div>

</form>

@endsection
