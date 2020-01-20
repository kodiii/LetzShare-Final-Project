<div class="filters form-group">
    <form action="/gallery" method="GET">
        @csrf
        <div class="form-group form-inline">
            <input class="form-control mr-sm-2 form-control-sm" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </div>
        <div class="form-row">
            <div class="form-group col-md-2">
                <label for="photo-user">Photographers</label>
                <select class="form-control form-control-sm" name="users" id="users" required>
                    <option value="" disabled>Select</option>
                    @foreach ($photos as $photo)
                    <option value="{{$photo->user_id}}">{{$photo->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-2">
                <label for="photo-user">Location</label>
                <select class="form-control form-control-sm" name="locality" id="locality" required>
                    <option value="" disabled>Select</option>
                    @foreach ($photos as $photo)
                    <option value="{{$photo->locality_id}}">{{$photo->locality_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-2">
                <label for="photo-user">Category</label>
                <select class="form-control form-control-sm" name="category" id="category" required>
                    <option value="" disabled>Select</option>
                    @foreach ($photos as $photo)
                    <option value="{{$photo->category_id}}">{{$photo->category_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-2">
                <label for="photo-user">Likes</label>
                <select class="form-control form-control-sm" name="likes" id="likes_sum" required>
                    <option value="" disabled>Select</option>
                    @foreach ($photos as $photo)
                    <option value="{{$photo->likes_sum}}">{{$photo->likes_sum}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label for="photo-user">Date</label>
                <select class="form-control form-control-sm">
                    <option>select</option>
                    <option>A-Z</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>