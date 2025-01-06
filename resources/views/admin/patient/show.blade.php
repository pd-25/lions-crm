@extends('admin.layout.main')

@section('title', 'Patient Details | ')
@section('content')
    <section class="section dashboard">

        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{$patient->name. "'s "}} Details</h5>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="inputText" class=" col-form-label">Full Name</label>
                                <div class="col-sm-10">
                                    <input type="text" value="{{ $patient->name }}" class="form-control"
                                        readonly>
                                </div>

                            </div>
                            <div class="col-6">
                                <label for="inputNumber" class="col-form-label">Contact Number</label>
                                <div class="col-sm-10">
                                    <input type="number" value="{{ $patient->phone_number ?? '' }}" 
                                        class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="inputNumber" class="col-form-label">Address</label>
                                <div class="col-sm-12">
                                    <input value="{{ $patient->address }}" 
                                        class="form-control" readonly>
                                </div>
                            </div>
                        </div>



                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <a href="{{ route('patients.index') }}" type="submit"
                                    class="btn btn-sm btn-danger float-end m-2">Back</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{$patient->name. "'s "}}All Bookings</h5>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Booking ID</th>
                                <th scope="col">Booking Type</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach ($patient->registerBooking()->orderBy('id', 'DESC')->get() as $allbooking)
                                <tr>
                                    <th scope="row">{{ '#'.$allbooking->booking_id }}</th>
                                    <td>{!! $allbooking->booking_type_or_operation !!}</td>
                                    <td>{{ $allbooking->amount }}</td>
                                    <td>{{ \Carbon\Carbon::parse($allbooking->created_at)->format('dM, Y h:i A') }}</td>
                                    <td>
                                        <a href="{{ route('register-bookings.show', $allbooking->slug) }}"><i
                                                class="ri-eye-fill"></i></a>
                                        
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>

                    </table>
                    {{-- {{ $allbookings->links() }} --}}
                </div>
            </div>
        </div>
    </section>
@endsection
