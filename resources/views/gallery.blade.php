@extends('layouts.app')

@section('title', 'Gallery')

@section('content')

{{-- Filters section --}}
<div id="accordion">
    <div class="filters">
        <div class="card-header formfilters" id="headingOne">
            <h5 class="mb-0">
                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                    aria-controls="collapseOne">
                    FILTERS
                </button>
            </h5>
        </div>

        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
            <form method="POST" class="form-filters">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="users">Photographers</label>
                        <select class="form-control users form-control-sm" name="users" id="users">
                            <option value="default">Select</option>
                            @foreach ($users as $user)
                            <option value="{{$user->user_id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="locations">Location</label>
                        <select class="form-control locations form-control-sm" name="locations" id="locations">
                            <option value="">Select</option>
                            @foreach ($locations as $location)
                            <option value="{{$location->locality_id}}">{{$location->locality_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="categories">Category</label>
                        <select class="form-control categories form-control-sm" name="categories" id="categories">
                            <option value="">Select</option>
                            @foreach ($categories as $category)
                            <option value="{{$category->category_id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="firstdate">Date From</label>
                        <input type="date" class="form-control form-control-sm" name="firstdate" id="firstdate">
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="lastdate">Date To</label>
                        <input type="date" class="form-control form-control-sm" id="lastdate" name="lastdate">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

{{-- Gallery section --}}
<div class="row gallery">
    <div class="card-columns">

        <!-- Card -->
        @foreach ($photos as $photo)
        <div class="card promoting-card">

            <!-- Card content -->
            <div class="card-body d-flex flex-row">

                <!-- Avatar -->
                <a href="/userprofile/{{$photo->user_id}}">
                    <img src="{{URL::asset($photo->user_photo)}}" class="rounded-circle mr-3" height="50" width="50"
                        alt="avatar">
                </a>
                <!-- Content -->
                <div>

                    <!-- Title -->
                    <h6 class="card-title font-weight-bold mb-2 text-capitalize">{{ $photo->image_title }}</h6>
                    <!-- Subtitle -->
                    <p class="card-text"><small><i class="far fa-calendar-alt"></i>
                            {{date('d-m-Y', strtotime($photo->created_at)) }}
                        </small></p>
                </div>
            </div>

            <!-- Card image -->
            <div class="view overlay">
                <a href="{{ $photo->image_URL }}" data-toggle="modal" data-target="#modal-{{ $photo->photo_id }}">
                    <img class="card-img-top rounded-0" src="{{ $photo->image_URL }}" alt="{{ $photo->image_title }}">
                </a>
                <!-- Modal -->
                <div class="modal fade bd-example-modal-lg" id="modal-{{ $photo->photo_id }}" tabindex="-1"
                    role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <a href="/userprofile/{{$photo->user_id}}">
                                    <img src="{{URL::asset($photo->user_photo)}}" class="rounded-circle mr-3"
                                        height="50" width="50" alt="avatar">
                                </a>
                                <h5 class="modal-title">{{ $photo->image_title }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body modalBodyGallery">
                                <img class="card-img-top rounded-0" src="{{ $photo->image_URL }}"
                                    alt="{{ $photo->image_title }}">
                            </div>

                            <div class="modal-footer modalFooterGallery">
                                <div class="col modal-description">
                                    {{ $photo->image_description }}
                                </div>
                                <div class="col modal-icons">
                                    <ul>
                                        <li>
                                            {{-- code to implement like /unlike functionality in page --}}
                                            @if (Auth::check())
                                            @php
                                            $like = App\Like::where('photo_id', $photo->photo_id)->where('user_id',
                                            Auth::user()->user_id)->first();
                                            @endphp
                                            @if ($like)
                                            {{-- Does a "like" exist in the table for this user, photo? --}}
                                            @if ($like->islike)
                                            {{-- If so is it a like? --}}
                                            <div class="liked" id="{{$photo->photo_id}}">
                                                @csrf
                                                <i class="fas fa-heart"></i>
                                                <span class="likes-number">{{ $photo->likes_sum }}</span>
                                            </div>
                                            @else
                                            <!-- Else is it currently a report? -->
                                            <div class="not-liked" id="{{$photo->photo_id}}">
                                                @csrf
                                                <i class="far fa-heart"></i>
                                                <span class="likes-number">{{ $photo->likes_sum }}</span>
                                            </div>
                                            @endif
                                            @else
                                            <!-- Or else there isn't a like in the table i.e. not liked or reported -->
                                            <div class="not-liked" id="{{$photo->photo_id}}">
                                                @csrf
                                                <i class="far fa-heart"></i>
                                                <span class="likes-number">{{ $photo->likes_sum }}</span>
                                            </div>
                                            @endif
                                            @else
                                            <!-- finally, if the user is not logged on the like/report functionality is not enabled -->
                                            <div class="not-logged">
                                                <i class="far fa-heart"></i>
                                                <span>{{ $photo->likes_sum }}</span>
                                            </div>
                                            @endif
                                        </li>
                                        <li>
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span>{{ $photo->locality_name }}</span>
                                        </li>
                                        <li>
                                            <i class="{{$photo->category_icon}}">
                                            </i>
                                            <span class="text-capitalize">{{ $photo->category_name }}</span>
                                        </li>
                                        <li>
                                            <!-- code to implement report functionality in page -->
                                            @if (Auth::check())
                                            @php
                                            $like = App\Like::where('photo_id' , $photo->photo_id)->where('user_id' ,
                                            Auth::user()->user_id)->first();
                                            @endphp
                                            @if ($like)
                                            <!-- Does a "like" exist in the table for this user, photo? -->
                                            @if (!($like->islike))
                                            <!-- If so is it a report? -->
                                            <div class="reported" id="0{{$photo->photo_id}}">
                                                @csrf
                                                <i class="fas fa-flag"></i>
                                                <!-- the show/hide of the spans are toggled by JS -->
                                                <span class="rep-text">Reported</span><span
                                                    class="rep-text hide">Report</span>
                                            </div>
                                            @else
                                            <!-- Else is it currently a like? -->
                                            <div class="not-reported" id="0{{$photo->photo_id}}">
                                                @csrf
                                                <i class="far fa-flag"></i>
                                                <span class="rep-text">Report</span>
                                                <span class="rep-text hide">Reported</span>
                                            </div>
                                            @endif
                                            @else
                                            <!-- Or else there isn't a like in the table i.e. not liked or reported -->
                                            <div class="not-reported" id="0{{$photo->photo_id}}">
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
                        <a class="readMore" data-toggle="collapse" href="#collapse-{{ $photo->photo_id }}" role="button"
                            aria-expanded="false">
                            <i class="fas fa-angle-down"></i>
                        </a>
                    </div>
                    <p class="card-text collapse text-capitalize" id="collapse-{{ $photo->photo_id }}">
                        {{ $photo->image_description }}</p>
                    <!-- Like, Location, Categories, Reports icons -->
                    <ul>
                        <li>
                            {{-- code to implement like /unlike functionality in page --}}
                            @if (Auth::check())
                            @php
                            $like = App\Like::where('photo_id', $photo->photo_id)->where('user_id',
                            Auth::user()->user_id)->first();
                            @endphp
                            @if ($like)
                            {{-- Does a "like" exist in the table for this user, photo? --}}
                            @if ($like->islike)
                            {{-- If so is it a like? --}}
                            <div class="liked" id="00{{$photo->photo_id}}">
                                @csrf
                                <i class="fas fa-heart"></i>
                                <span class="likes-number">{{ $photo->likes_sum }}</span>
                            </div>
                            @else
                            <!-- Else is it currently a report? -->
                            <div class="not-liked" id="00{{$photo->photo_id}}">
                                @csrf
                                <i class="far fa-heart"></i>
                                <span class="likes-number">{{ $photo->likes_sum }}</span>
                            </div>
                            @endif
                            @else
                            <!-- Or else there isn't a like in the table i.e. not liked or reported -->
                            <div class="not-liked" id="00{{$photo->photo_id}}">
                                @csrf
                                <i class="far fa-heart"></i>
                                <span class="likes-number">{{ $photo->likes_sum }}</span>
                            </div>
                            @endif
                            @else
                            <!-- finally, if the user is not logged on the like/report functionality is not enabled -->
                            <div class="not-logged">
                                <i class="far fa-heart"></i>
                                <span>{{ $photo->likes_sum }}</span>
                            </div>
                            @endif
                        </li>
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $photo->locality_name }}</span>
                        </li>
                        <li>
                            <i class="{{$photo->category_icon}}">
                            </i>
                            <span class="text-capitalize">{{ $photo->category_name }}</span>
                        </li>
                        <li>
                            <!-- code to implement report functionality in page -->
                            @if (Auth::check())
                            @php
                            $like = App\Like::where('photo_id' , $photo->photo_id)->where('user_id' ,
                            Auth::user()->user_id)->first();
                            @endphp
                            @if ($like)
                            <!-- Does a "like" exist in the table for this user, photo? -->
                            @if (!($like->islike))
                            <!-- If so is it a report? -->
                            <div class="reported" id="000{{$photo->photo_id}}">
                                @csrf
                                <i class="fas fa-flag"></i>
                                <!-- the show/hide of the spans are toggled by JS -->
                                <span class="rep-text">Reported</span><span class="rep-text hide">Report</span>
                            </div>
                            @else
                            <!-- Else is it currently a like? -->
                            <div class="not-reported" id="000{{$photo->photo_id}}">
                                @csrf
                                <i class="far fa-flag"></i>
                                <span class="rep-text">Report</span>
                                <span class="rep-text hide">Reported</span>
                            </div>
                            @endif
                            @else
                            <!-- Or else there isn't a like in the table i.e. not liked or reported -->
                            <div class="not-reported" id="000{{$photo->photo_id}}">
                                @csrf
                                <i class="far fa-flag"></i>
                                <span class="rep-text">Report</span><span class="rep-text hide">Reported</span>
                            </div>
                            @endif
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
        <!-- END Card -->
    </div>

</div>

@endsection
