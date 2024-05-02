@extends('admin.layout.main')
@section('title', 'Booking List | ')
@section('content')
    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">

                        <h5 class="card-title">All Bookings</h5>
                        @if (Session::has('msg'))
                            <p class="alert alert-info">{{ Session::get('msg') }}</p>
                        @endif
                        <a class="btn btn-sm btn-outline-success float-end" href="{{ route('register-bookings.create') }}">New
                            Booking</a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Booking ID</th>
                                    <th scope="col">Patient Name</th>
                                    <th scope="col">Phone Number</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($allbookings as $allbooking)
                                    <tr>
                                        <th scope="row">{{ '#'.$allbooking->booking_id }}</th>
                                        <td>{{ $allbooking->patient->name }}</td>
                                        <td>{{ $allbooking->patient->phone_number }}</td>
                                        <td>{{ $allbooking->amount }}</td>
                                        <td>
                                            <a href="{{ route('register-bookings.edit', $allbooking->slug) }}"><i
                                                    class="ri-pencil-fill"></i></a>
                                            <form method="POST"
                                                action="{{ route('register-bookings.destroy', $allbooking->slug) }}"
                                                class="d-inline-block pl-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="delete-icon show_confirm"
                                                    data-toggle="tooltip" title='Delete'>

                                                    <i class="ri-delete-bin-2-fill"></i>

                                                </button>
                                            </form>
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
