@extends('admin.layout.main')
@section('title', 'Patients | ')
@section('content')
    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">

                        <h5 class="card-title">All Patients</h5>
                        @if (Session::has('msg'))
                            <p id="flash-message" class="alert alert-info">{{ Session::get('msg') }}</p>
                        @endif
                       
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Total Previous Bookings </th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $startIndex = ($patients->currentPage() - 1) * $patients->perPage() + 1;
                                @endphp
                                @foreach ($patients as $patient)
                                    <tr>
                                        <th scope="row">{{ $startIndex++ }}</th>
                                        <td>{{ $patient->name }}</td>

                                        <td>{{ $patient->phone_number }}</td>
                                        <td> {{ $patient->registerBooking->count() }}</td>
                                        <td>
                                            <a href="{{ route('patients.show', $patient->slug) }}"><i
                                                    class="ri-eye-fill"></i></a>
                                            <form method="POST" action="{{ route('patients.destroy', $patient->slug) }}"
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
                        {{ $patients->links() }}
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
