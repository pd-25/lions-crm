@extends('admin.layout.main')
@section('title', 'Booking Details | ')
@section('content')
<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Booking Details</h5>
                    <a class="btn btn-sm btn-outline-secondary float-end" href="javascript:void(0)" onclick="window.history.back();">Back to List</a>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label"><b> Booking ID</b></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control-plaintext" value="{{ '#'.$registerBooking->booking_id }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label"><b>Booking Type</b> </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control-plaintext" value="{{ $registerBooking->booking_type_or_operation }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label"><b>Patient Name</b> </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control-plaintext" value="{{ $registerBooking->patient->name }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label"><b>Phone Number</b> </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control-plaintext" value="{{ $registerBooking->patient->phone_number }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label"><b>Address</b> </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control-plaintext" value="{{ $registerBooking->patient->address }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label"><b>Amount</b> </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control-plaintext" value="{{ $registerBooking->amount }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label"><b>Date</b> </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control-plaintext" value="{{ \Carbon\Carbon::parse($registerBooking->created_at)->format('d M, Y h:i A') }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label"><b>About Patient Problem</b> </label>
                        <div class="col-sm-10">
                            <p>{{ $registerBooking->about_patient_problem ?? 'N/A' }}</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
