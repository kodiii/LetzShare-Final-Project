@extends('layouts.app')

@section('title')
{{$userPhotos[0]->name}} Profile
@endsection

@section('content')
@guest
@php
$ownUser=false;
@endphp
@else
@php
// check if the profile belongs to the user
if((Auth::user()->user_id)==($userPhotos[0]->user_id)){
$ownUser=true;
$userId=Auth::user()->user_id;
}else{
$ownUser=false;
}
@endphp
@endguest

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
    </div>
</div>
@if($ownUser)

<!-- Modal to edit user photo -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Select a new photo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/userprofile/photo/{{Auth::user()->user_id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="foto">Select a photo</label>
                        <div class="custom-file">
                            <input type="file" name="image" class="custom-file-input" id="foto" required>
                            <label class="custom-file-label" for="foto"></label>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save photo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end of the model to edit photo -->
@endif

<!-- Edit Name -->
<form method="post" class="form-flex-profile edit-name">
    @csrf
    <h2>
        <!--User name-->
        @if($ownUser)Hello, @endif <span class="old-name older-name text-capitalize">{{$userPhotos[0]->name}}</span>

        @if($ownUser)<span class="old-name"> | </span><a href="#" id="editName">Edit Name</a>
        @endif
    </h2>
    @if($ownUser)
    <!--Form to edit name-->
    <div class="form-group flex-div div-edit-name hide">
        <input class="form-control profile-field" type="text" name="name" id="name" value="{{$userPhotos[0]->name}}"
            placeholder="Edit your name">
        <input type="number" class="hide user_id" name="user_id" value="{{Auth::user()->user_id}}">
        <input class="btn btn-primary mb-2 profile-field" type="submit" value="Save" name="save">
        <input class="btn btn-danger mb-2 profile-field cancel-edit" type="button" value="Cancel" name="cancel">
    </div>

    @endif
</form>
<!--End edit name-->

<hr>
<!-- User details -->
<section id="user_details" class="card promoting-card card-user">
    <!-- Avatar -->
    <div class="profile-flex">
        <div class="edit-photo ">
            <img src="{{URL::asset($userPhotos[0]->user_photo)}}" class="rounded-circle user-profile img-thumbnail"
                height="150" width="150" alt="{{$userPhotos[0]->name}} photo">
            @if($ownUser)
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"
                data-whatever="{{$userPhotos[0]->name}}">Edit photo</button>@endif
        </div>


        <div class="user-details-flex">
            <form method="post" class="form-flex-profile edit-description">
                @csrf
                <div>
                    <p><i class="fas fa-comment"></i>
                        <span class="old-description older-description text-capitalize">
                            <i>"@if($userPhotos[0]->user_description)
                                {{$userPhotos[0]->user_description}}@endif"</i>
                        </span>@if(!$ownUser)
                </div> @endif
                @if($ownUser)
                <span class="old-description">|</span>
                <a href="#" class="linkEditDescription">Edit Description</a>
                </p>
        </div>

        <!-- EDIT User description -->
        @if($ownUser)
        <div class="form-group flex-div div-edit-description hide">
            <textarea class="form-control" name="description" id="description" cols="50" rows="1"
                placeholder="Edit your description">{{$userPhotos[0]->user_description}}</textarea>
            <input type="number" class="hide user_id" name="user_id" value="{{Auth::user()->user_id}}">
            <input class="btn btn-primary mb-2 profile-field" type="submit" value="Save" name="save">
            <input class="btn btn-danger mb-2 profile-field cancel-edit-description" type="button" value="Cancel"
                name="cancel">
        </div>
        @endif
        @endif
        <!--End if user is in your own profile-->
        </form>
        <!-- end edit description -->

        <!-- user location -->
        <form method="POST" class="form-flex-profile edit-location">
            @csrf
            <p>
                <i class="fas fa-map-marker-alt"></i>

                <span class="old-location older-location">
                    @if($userPhotos[0]->user_location)
                    {{$userPhotos[0]->user_location}}
                    @endif
                </span>

                @if($ownUser)
                <span class="old-location"> | </span>
                <a href="#" class="linkEditLocation">Edit Location</a>
                @endif
            </p>
            @if($ownUser)
            <!--Form to edit location-->
            <div class="form-group flex-div div-edit-location hide">
                <input class="form-control profile-field" type="text" name="location" id="location"
                    value="{{$userPhotos[0]->user_location}}" placeholder="Edit your location">
                <input type="number" class="hide user_id" name="user_id" value="{{Auth::user()->user_id}}">
                <input class="btn btn-primary mb-2 profile-field" type="submit" value="Save" name="save">
                <input class="btn btn-danger mb-2 profile-field cancel-edit-location" type="button" value="Cancel"
                    name="cancel">
            </div>
            @endif
        </form>
        <!-- end of the user location -->

        <!-- send message to user -->
        @if(!$ownUser)
        <p>
            <a href="#" class="send-msg-link">
                <i class="far fa-envelope"></i>
                Send a message</a>
        </p>

        <!-- user email -->
        @else <p>
            <i class="fas fa-at"></i>
            {{$userPhotos[0]->email}}</p>
        @endif
    </div>

    <!-- form to send message to the user -->
    <div class="row justify-content-center send-msg-card hide">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="close close-card">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3>Get in touch with {{$userPhotos[0]->name}}</h3>
                </div>
                <div class="card-body">
                    <form class="formbox send-message-to" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="fullname">Full name</label>
                            <input type="text" class="form-control" id="fullname" name="fullname" @guest
                                placeholder="Enter your name" @else value="{{Auth::user()->name}}" @endguest>
                        </div>
                        <div class="form-group">
                            <label for="email">E-Mail address</label>
                            <input type="email" class="form-control" id="email" name="email" @guest
                                placeholder="Enter your e-mail" @else value="{{Auth::user()->email}}" @endguest>
                        </div>
                        <div class="form-group">
                            <label for="message">Your message</label>
                            <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                        </div>
                        <input type="number" value="{{$userPhotos[0]->user_id}}" name="user_id" id="idToSend"
                            class="hide">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Send message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <!-- end of the form to send message -->

    @if($ownUser)
    <!--delete user account by own user-->
    <button type="submit" class="text-danger btn delete-user-account" data-toggle="modal"
        data-target="#deleteAccountModal">Delete account</button>

    <!-- Modal to confirm delete account -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog"
        aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="deleteAccountModalLabel">Attention, this action is
                        irreversible!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Thank you for the time you were with us,<br>
                    We hope you come back soon...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Go back</button>
                    <form action="/delete/user-account/{{Auth::user()->user_id}}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-danger">Confirm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
    </div>
</section>
<!-- End of the User details -->

<!-- User Portfolio -->
<section id="portfolio">
    <h2>Portfolio
        @if($ownUser)|
        <a href="/uploadphoto" class="add">
            Upload new photo <i class="fas fa-plus-circle"></i>
        </a>
        @endif
    </h2>
    <hr>

    <!-- check if the user as photos -->
    @if($userPhotos[0]->photo_id)

    <!--create a card for each photo if the user has photo -->
    <div class="row gallery">
        <div class="card-columns">

            @foreach ($userPhotos as $userPhoto)
            <article class="card promoting-card">

                @if($ownUser || (Auth::check() && Auth::user()->user_type == 'admin'))
                <!-- Modal to confirm delete photo -->
                <div class="modal fade" id="deletePhoto{{ $userPhoto->photo_id }}" tabindex="-1" role="dialog"
                    aria-labelledby="deletePhotoLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-danger" id="deletePhotoLabel{{ $userPhoto->photo_id }}">
                                    Attention, this action is
                                    irreversible!</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">Are you sure you want to delete this photo?
                                <img class="card-img-top img-thumbnail" src="{{ URL::asset($userPhoto->image_URL) }}"
                                    alt="{{ $userPhoto->image_title }}">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                                <form action="/delete/user-photo/{{ $userPhoto->photo_id }}" class="delete-user-photo"
                                    method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Delete photo</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>@endif
                @if($ownUser)
                <!--end model to confirm delete photo-->
                <form action="/edit-photo-details/{{ $userPhoto->photo_id }}" method="POST"
                    class="edit-photo-details-{{ $userPhoto->photo_id }}">
                    @csrf

                    @endif
                    <!-- Card content -->
                    <div class="card-body d-flex flex-row container-button">

                        <!-- Content -->
                        <div class="">

                            <!-- Title -->
                            <h6 class="card-title font-weight-bold mb-2 {{ $userPhoto->photo_id }}">
                                {{ $userPhoto->image_title }}
                            </h6>@if($ownUser)
                            <!-- Button trigger modal -->
                            <div class="buttons-absolutes">
                                <!--edit photo button-->
                                <a href="#" class="edit-photo-button " id="edit-{{ $userPhoto->photo_id }}"><i
                                        class="far fa-edit text-primary"></i></a>@endif
                                <!--delete photo button-->@if($ownUser || (Auth::check() && Auth::user()->user_type ==
                                'admin'))
                                <a href="#" data-toggle="modal" data-target="#deletePhoto{{ $userPhoto->photo_id }}"><i
                                        class="far fa-trash-alt delete-photo-button text-danger text-right"></i></a>@endif
                                @if($ownUser)
                            </div>

                            <input type="text" class="edit-photo-{{ $userPhoto->photo_id }} hide form-control"
                                name="title" placeholder="Enter a new title" value="{{ $userPhoto->image_title }}">

                            @endif

                            <!-- Subtitle -->
                            <p class="card-text"><small><i class="far fa-calendar-alt"></i>
                                    {{ date('d-m-Y', strtotime($userPhoto->photodate)) }}

                                </small></p>

                        </div>

                    </div>

                    <!-- Card image -->
                    <div class="view overlay">
                        <a href="{{ URL::asset($userPhoto->image_URL) }}" data-toggle="modal"
                            data-target="#modal-{{ $userPhoto->photo_id }}">
                            <img class="card-img-top rounded-0" src="{{ URL::asset($userPhoto->image_URL) }}"
                                alt="{{ $userPhoto->image_title }}">
                        </a>
                        <!-- Modal -->
                        <div class="modal fade bd-example-modal-lg" id="modal-{{ $userPhoto->photo_id }}" tabindex="-1"
                            role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <a href="{{ URL::asset($userPhoto->image_URL) }}">
                                            <img src="{{ URL::asset($userPhoto->user_photo) }}"
                                                class="rounded-circle mr-3" height="50" width="50" alt="avatar">
                                        </a>
                                        <h5 class="modal-title">{{ $userPhoto->image_title }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body modalBodyGallery">
                                        <img class="card-img-top rounded-0" src="{{ URL::asset($userPhoto->image_URL) }}"
                                            alt="{{ $userPhoto->image_title }}">
                                    </div>

                                    <div class="modal-footer modalFooterGallery">
                                        <div class="col modal-description">
                                            {{ $userPhoto->image_description }}
                                        </div>
                                        <div class="col modal-icons">
                                            <ul>
                                                <li>
                                                    {{-- code to implement like /unlike functionality in page --}}
                                                    @if (Auth::check())
                                                    @php
                                                    $like = App\Like::where('photo_id',
                                                    $userPhoto->photo_id)->where('user_id',
                                                    Auth::user()->user_id)->first();
                                                    @endphp
                                                    @if ($like)
                                                    {{-- Does a "like" exist in the table for this user, photo? --}}
                                                    @if ($like->islike)
                                                    {{-- If so is it a like? --}}
                                                    <div class="liked" id="{{$userPhoto->photo_id}}">
                                                        @csrf
                                                        <i class="fas fa-heart"></i>
                                                        <span class="likes-number">{{ $userPhoto->likes_sum }}</span>
                                                    </div>
                                                    @else
                                                    <!-- Else is it currently a report? -->
                                                    <div class="not-liked" id="{{$userPhoto->photo_id}}">
                                                        @csrf
                                                        <i class="far fa-heart"></i>
                                                        <span class="likes-number">{{ $userPhoto->likes_sum }}</span>
                                                    </div>
                                                    @endif
                                                    @else
                                                    <!-- Or else there isn't a like in the table i.e. not liked or reported -->
                                                    <div class="not-liked" id="{{$userPhoto->photo_id}}">
                                                        @csrf
                                                        <i class="far fa-heart"></i>
                                                        <span class="likes-number">{{ $userPhoto->likes_sum }}</span>
                                                    </div>
                                                    @endif
                                                    @else
                                                    <!-- finally, if the user is not logged on the like/report functionality is not enabled -->
                                                    <div class="not-logged">
                                                        <i class="far fa-heart"></i>
                                                        <span>{{ $userPhoto->likes_sum }}</span>
                                                    </div>
                                                    @endif
                                                </li>
                                                <li>
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <span>{{ $userPhoto->locality_name }}</span>
                                                </li>
                                                <li>
                                                    <i class="{{$userPhoto->category_icon}}">
                                                    </i>
                                                    <span class="text-capitalize">{{ $userPhoto->category_name }}</span>
                                                </li>
                                                <li>
                                                    <!-- code to implement report functionality in page -->
                                                    @if (Auth::check())
                                                    @php
                                                    $like = App\Like::where('photo_id' ,
                                                    $userPhoto->photo_id)->where('user_id' ,
                                                    Auth::user()->user_id)->first();
                                                    @endphp
                                                    @if ($like)
                                                    <!-- Does a "like" exist in the table for this user, photo? -->
                                                    @if (!($like->islike))
                                                    <!-- If so is it a report? -->
                                                    <div class="reported" id="0{{$userPhoto->photo_id}}">
                                                        @csrf
                                                        <i class="fas fa-flag"></i>
                                                        <!-- the show/hide of the spans are toggled by JS -->
                                                        <span class="rep-text">Reported</span><span
                                                            class="rep-text hide">Report</span>
                                                    </div>
                                                    @else
                                                    <!-- Else is it currently a like? -->
                                                    <div class="not-reported" id="0{{$userPhoto->photo_id}}">
                                                        @csrf
                                                        <i class="far fa-flag"></i>
                                                        <span class="rep-text">Report</span>
                                                        <span class="rep-text hide">Reported</span>
                                                    </div>
                                                    @endif
                                                    @else
                                                    <!-- Or else there isn't a like in the table i.e. not liked or reported -->
                                                    <div class="not-reported" id="0{{$userPhoto->photo_id}}">
                                                        @csrf
                                                        <i class="far fa-flag"></i>
                                                        <span class="rep-text">Report</span><span
                                                            class="rep-text hide">Reported</span>
                                                    </div>
                                                    @endif
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Card content -->
                    <div class="card-body">

                        <div class="collapse-content">

                            <!-- Text -->
                            <div class="formHide">
                                <a class="readMore" data-toggle="collapse" href="#collapse-{{ $userPhoto->photo_id }}"
                                    role="button" aria-expanded="false" aria-controls="collapseExample">
                                    <i class="fas fa-angle-down"></i>
                                </a>
                            </div>
                            <p class="card-text collapse text-capitalize" id="collapse-{{ $userPhoto->photo_id }}">
                                {{ $userPhoto->image_description }}</p>
                            @if($ownUser)
                            <textarea name="image_description"
                                class="form-control edit-photo-{{ $userPhoto->photo_id }} hide">{{ $userPhoto->image_description }}</textarea>
                            @endif
                            <!-- Button -->
                            <ul>
                                <li>
                                    <!-- code to implement like /unlike functionality in page -->
                                    @if (Auth::check())
                                    @php
                                    $like = App\Like::where('photo_id', $userPhoto->photo_id)->where('user_id',
                                    Auth::user()->user_id)->first();
                                    @endphp
                                    @if ($like)
                                    <!-- Does a "like" exist in the table for this user, photo? -->
                                    @if ($like->islike)
                                    <!-- If so is it a like? -->
                                    <div class="liked" id="{{$userPhoto->photo_id}}">
                                        @csrf
                                        <i class="fas fa-heart"></i>
                                        <span class="likes-number">{{ $userPhoto->likes_sum }}</span>
                                    </div>
                                    @else
                                    <!-- Else is it currently a report? -->
                                    <div class="not-liked" id="{{$userPhoto->photo_id}}">
                                        @csrf
                                        <i class="far fa-heart"></i>
                                        <span class="likes-number">{{ $userPhoto->likes_sum }}</span>
                                    </div>
                                    @endif
                                    @else
                                    <!-- Or else there isn't a like in the table i.e. not liked or reported -->
                                    <div class="not-liked" id="{{$userPhoto->photo_id}}">
                                        @csrf
                                        <i class="far fa-heart"></i>
                                        <span class="likes-number">{{ $userPhoto->likes_sum }}</span>
                                    </div>
                                    @endif
                                    @else
                                    <!-- finally, if the user is not logged on the like/report functionality is not enabled -->
                                    <div class="not-logged">
                                        <i class="far fa-heart"></i>
                                        <span>{{ $userPhoto->likes_sum }}</span>
                                    </div>
                                    @endif
                                </li>
                                <li>
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span class="old-fields-{{ $userPhoto->photo_id }}">
                                        {{ $userPhoto->locality_name }}</span>
                                    @if($ownUser)
                                    <select class="custom-select hide edit-photo-{{ $userPhoto->photo_id }}"
                                        name="locality" required>
                                        <option value="" disabled>Locality</option>
                                        @foreach ($locations as $locality)
                                        <option value="{{$locality->locality_id}}" @if(($userPhoto->locality_id) ==
                                            ($locality->locality_id))
                                            selected
                                            @endif
                                            >{{$locality->locality_name}}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                </li>
                                <li>
                                    <i class="{{$userPhoto->category_icon}}">
                                    </i>
                                    <span class="text-capitalize old-fields-{{ $userPhoto->photo_id }}">
                                        {{ $userPhoto->category_name }}</span>
                                    @if($ownUser)
                                    <select class="custom-select hide edit-photo-{{ $userPhoto->photo_id }}"
                                        name="category" required>
                                        <option value="" disabled>Category</option>
                                        @foreach ($categories as $category)
                                        <option value="{{$category->category_id}}" @if(($userPhoto->category_id) ==
                                            ($category->category_id))
                                            selected
                                            @endif>{{ ucfirst($category->category_name) }}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                </li>

                                <li>
                                    <!-- code to implement report functionality in page -->
                                    @if (Auth::check())
                                    @php
                                    $like = App\Like::where('photo_id' , $userPhoto->photo_id)->where('user_id' ,
                                    Auth::user()->user_id)->first();
                                    @endphp
                                    @if ($like)
                                    <!-- Does a "like" exist in the table for this user, photo? -->
                                    @if (!($like->islike))
                                    <!-- If so is it a report? -->
                                    <div class="reported" id="0{{$userPhoto->photo_id}}">
                                        @csrf
                                        <i class="fas fa-flag"></i>
                                        <!-- the show/hide of the spans are toggled by JS -->
                                        <span class="rep-text">Reported</span><span class="rep-text hide">Report</span>
                                    </div>
                                    @else
                                    <!-- Else is it currently a like? -->
                                    <div class="not-reported" id="0{{$userPhoto->photo_id}}">
                                        @csrf
                                        <i class="far fa-flag"></i>
                                        <span class="rep-text">Report</span><span class="rep-text hide">Reported</span>
                                    </div>
                                    @endif
                                    @else
                                    <!-- Or else there isn't a like in the table i.e. not liked or reported -->
                                    <div class="not-reported" id="0{{$userPhoto->photo_id}}">
                                        @csrf
                                        <i class="far fa-flag"></i>
                                        <span class="rep-text">Report</span><span class="rep-text hide">Reported</span>
                                    </div>
                                    @endif
                                    @endif
                                </li>
                            </ul>
                            @if($ownUser)
                            <div class="buttons-photo-{{ $userPhoto->photo_id }} hide">
                                <input class="btn btn-primary mb-2 profile-field" type="submit" value="Save"
                                    name="save">
                                <input class="btn btn-danger mb-2 profile-field cancel-edit-photo"
                                    id="cancel_{{ $userPhoto->photo_id}}" type="button" value="Cancel"
                                    name="cancel">@endif</div>
                        </div>


                        @if($ownUser)
                    </div>
                </form>@endif
            </article>
            @endforeach
            <!-- END Card -->

        </div>
    </div>


    @else
    <!--if the portfolio is empty-->
    <div class="card promoting-card card-user">
        <div class="card-body d-flex flex-row">
            <p>This portfolio is empty for now. We're excited to see new photos from {{$userPhotos[0]->name}}!</p>
        </div>
    </div>
    @endif
    <!--End of the User Portfolio -->
    <div class="pagination">
        {{ $userPhotos->links() }}
    </div>
</section>

@endsection
