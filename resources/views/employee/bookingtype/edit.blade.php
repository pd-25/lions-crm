@extends('employee.layout.main')
@section('title', 'Create Booking Type | ')
@section('content')
    <section class="section dashboard">

        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add New Booking Type</h5>
                        <form action="{{ route('employee-booking-types.update', $bookingtype->slug) }}" method="POST">
                            @method('PUT')
                            @csrf
                           
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Type Name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="type_name" class="form-control" value="{{$bookingtype->type_name}}" required>
                                    @error('type_name')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail" class="col-sm-2 col-form-label">Price</label>
                                <div class="col-sm-10">
                                    <input type="number" name="price" class="form-control" value="{{$bookingtype->price}}" >
                                    @error('price')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputEmail" class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-10">
                                    <select name="status" class="form-control">
                                        <option {{$bookingtype->status == 1 ? "selected" : ''}} value="1">Active</option>
                                        <option {{$bookingtype->status == 0 ? "selected" : ''}} value="0">In-Active</option>
                                    </select>
                                    @error('status')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-sm btn-primary float-end m-2">Submit Form</button>
                                    <a href="{{route('employee-booking-types.index')}}" type="submit" class="btn btn-sm btn-danger float-end m-2">Cancel</a>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
