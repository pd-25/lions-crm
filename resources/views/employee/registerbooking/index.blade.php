@extends('employee.layout.main')
@section('title', 'Booking List | ')
@section('content')
    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">

                        <h5 class="card-title">All Bookings</h5>
                        @if (Session::has('msg'))
                            <p id="flash-message" class="alert alert-info">{{ Session::get('msg') }}</p>
                        @endif
                        <a class="btn btn-sm btn-outline-success float-end" href="{{ route('employee.register-bookings.create') }}">New
                            Booking</a>
                        <table class="table">
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

                                @foreach ($allbookings as $allbooking)
                                    <tr>
                                        <th scope="row">{{ '#' . $allbooking->booking_id }}</th>
                                        <td>{!! $allbooking->booking_type_or_operation !!}</td>
                                        <td>{{ $allbooking->patient->name }}</td>
                                        <td>{{ $allbooking->patient->phone_number }}</td>
                                        <td>{{ $allbooking->amount }}</td>
                                        <td>{{ \Carbon\Carbon::parse($allbooking->created_at)->format('dM, Y h:i A') }}</td>
                                        <td>
                                            <a href="{{ route('employee.register-bookings.show', $allbooking->slug) }}"><i
                                                    class="ri-eye-fill"></i></a>

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                        {{ $allbookings->links() }}
                        <!-- End Default Table Example -->
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
