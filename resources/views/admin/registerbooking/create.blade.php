@extends('admin.layout.main')
@section('title', 'Register Booking | ')
@section('content')
    <section class="section dashboard">

        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Booking Registration</h5>
                        <span id="top-span-text" class="text-info"></span>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-10 col-form-label">Enter phone number or privious booking
                                ID</label>
                            <div class="col-sm-12">
                                <input type="text" id="number-or-id" name="phone"
                                    placeholder="Enter phone number or privious booking ID" class="form-control">
                                @error('phone')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <button type="button" onclick="checkIfExist()" id="check-if-exist"
                                    class="btn btn-sm btn-primary float-end m-2">Go</button>
                                <a href="{{ route('register-bookings.index') }}" type="submit"
                                    class="btn btn-sm btn-danger float-end m-2">Cancel</a>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="text-center d-none" id="spinner-div">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="container mt-4 d-none" id="existing-patient-list">
                    <h5>This patients are already using this number, you can use those</h5>
                    <div class="row">
                    </div>
                </div>



                <div class="card d-none mt-2" id="patient-registration-form">
                    <div class="card-body">
                        <div class="d-flex">
                            <h5 class="card-title">Enter Patient Details</h5>
                            <span id="span-text"></span>

                        </div>
                        <button type="button" onclick="resetForm()" class="btn btn-sm btn-success float-end m-2"
                            id="resetBtn">Reset</button>
                        <form id="booking-form" action="javascript:void(0)" method="POST">
                            <input type="hidden" name="existing_patient_id" id="existing_patient_id" value="0">

                            @include('common.bookingForm')



                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <button type="button" onclick="createNewBooking()"
                                        class="btn btn-sm btn-primary float-end m-2" id="submitBtn">Submit</button>
                                    <a href="{{ route('register-bookings.index') }}" type="submit"
                                        class="btn btn-sm btn-danger float-end m-2">Cancel</a>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    @include('common.commonJs')


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('select[name="booking_type_id"]').addEventListener('change', function() {
                var selectedOption = this.value;
                var bookingTypes = @json($bookingTypes);
                var selectedBookingType = bookingTypes.find(function(item) {
                    return item.id == selectedOption;
                });
                if (selectedBookingType) {
                    document.querySelector('input[name="amount"]').value = selectedBookingType.price;
                } else {
                    document.querySelector('input[name="amount"]').value = '';
                }
            });
        });

        function createNewBooking() {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.innerHTML =
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
            submitBtn.disabled = true;

            const formData = new FormData();
            formData.append('existing_patient_id', document.getElementById('existing_patient_id').value);
            formData.append('patient_name', document.getElementById('patient-name').value);
            formData.append('phone_number', document.getElementById('phone-number').value);
            formData.append('address', document.getElementById('address').value);
            formData.append('booking_type_id', document.querySelector('select[name="booking_type_id"]').value);
            formData.append('amount', document.querySelector('input[name="amount"]').value);
            formData.append('initial_paid_amount', document.querySelector('input[name="initial_paid_amount"]').value);

            formData.append('about_patient_problem', document.querySelector('textarea[name="about_patient_problem"]')
                .value);

            const operationSchemeSelect = document.querySelector('select[name="operation_scheme_id"]');
            if (operationSchemeSelect) {
                formData.append('operation_scheme_id', operationSchemeSelect.value);
            }

            // Clear previous error messages
            document.querySelectorAll('.text-danger').forEach(element => {
                element.textContent = '';
            });
            // console.log('formData', formData);
            // return;

            fetch("{{ route('register-bookings.store') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json"
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw data;
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data);
                    if (data.status === 'success') {
                        swal(data.msg, "", "success")
                            .then(() => {
                                window.location.href = "{{ route('register-bookings.index') }}";
                            });
                    } else {
                        swal("Error creating booking. Please try again.", "", "error");
                        submitBtn.innerHTML = 'Submit';
                        submitBtn.disabled = false;
                    }
                })
                .catch(error => {
                    if (error.errors) {
                        for (const [key, messages] of Object.entries(error.errors)) {
                            const inputElement = document.querySelector(`[name="${key}"]`);
                            if (inputElement) {
                                const errorElement = document.createElement('span');
                                errorElement.classList.add('text-danger');
                                errorElement.innerHTML = `<strong>${messages.join(' ')}</strong>`;
                                inputElement.parentElement.appendChild(errorElement);
                            }
                        }
                    } else {
                        swal("Some error occurred. Please try again.", "", "error");
                    }
                    submitBtn.innerHTML = 'Submit';
                    submitBtn.disabled = false;
                });
        }
    </script>
@endsection
