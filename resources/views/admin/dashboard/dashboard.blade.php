@extends('admin.layout.main')
@section('title', 'Dashboard | ')
@section('content')
    <section class="section dashboard">

        <div class="row">

            <div class="col-xxl-4 col-md-4">
                <div class="card info-card sales-card">

                    <div class="card-body">
                        <h5 class="card-title">Total Members</h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="ri-group-fill"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $membersCount }}</h6>


                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xxl-4 col-md-4">
                <div class="card info-card revenue-card">


                    <div class="card-body">
                        <h5 class="card-title">Total Paitents </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="ri-hotel-bed-fill"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{$patientCount}}</h6>


                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xxl-4 col-xl-4">

                <div class="card info-card customers-card">



                    <div class="card-body">
                        <h5 class="card-title">Total Bookings</h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="ri-map-pin-add-fill"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{$bookingCount}}</h6>

                            </div>
                        </div>

                    </div>
                </div>

            </div>




            <div class="col-12">
                <div class="card recent-sales overflow-auto">


                    <div class="card-body">
                        <h5 class="card-title">Recent Booking List</h5>

                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col">Booking ID</th>
                                    <th scope="col">Booking Type</th>
                                    <th scope="col">Patient Name</th>
                                    <th scope="col">Phone Number</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($latestBookings as $latestBooking)
                                    <tr>
                                        <th scope="row">{{ '#' . $latestBooking->booking_id }}</th>
                                        <td>{!! $latestBooking->booking_type_or_operation !!}</td>
                                        <td>{{ $latestBooking->patient->name }}</td>
                                        <td>{{ $latestBooking->patient->phone_number }}</td>
                                        <td>{{ $latestBooking->amount }}</td>
                                        <td>{{ \Carbon\Carbon::parse($latestBooking->created_at)->format('dM, Y h:i A') }}
                                        </td>
                                        <td>
                                            <a href="{{ route('register-bookings.show', $latestBooking->slug) }}"><i
                                                    class="ri-eye-fill"></i></a>
                                    </tr>
                                @empty
                                @endforelse

                            </tbody>
                        </table>

                    </div>

                </div>
            </div>

        </div>

    </section>
@endsection
