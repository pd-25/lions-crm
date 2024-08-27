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

                <div class="card d-none" id="patient-registration-form">
                    <div class="card-body">
                        <div class="d-flex">
                            <h5 class="card-title">Patient Details</h5>
                            <span id="span-text"></span>
                        </div>
                        <form id="booking-form" action="javascript:void(0)" method="POST">

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="inputText" class="col-form-label">Patient Name</label>
                                    <div>
                                        <input type="text" name="patient_name" class="form-control" id="patient-name">
                                        @error('patient_name')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="inputText" class="col-form-label">Patient Contact No.</label>
                                    <div>
                                        <input type="number" name="phone_number" class="form-control" id="phone-number">
                                        @error('phone_number')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="inputText" class="col-form-label">Adderss</label>
                                    <div>
                                        <input type="text" name="address" class="form-control" id="address">
                                        @error('address')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <label for="inputText" class="col-form-label">Booking Type</label>
                                    <div>
                                        <select name="booking_type_id" class="form-control"
                                            onchange="checkIfOperation(this)">
                                            <option value="">--select booking type--</option>
                                            @foreach ($bookingTypes as $item)
                                                <option value="{{ $item->id }}">{{ $item->type_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('booking_type_id')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="div col-md-4" id="operation-type">

                                </div>

                                <div class="col-md-6">
                                    <label for="inputText" class="col-form-label">Amount</label>
                                    <div>
                                        <input type="number" value="" name="amount" class="form-control" readonly>
                                        @error('amount')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="inputText" class="col-form-label">Paid Amount</label>
                                    <div>
                                        <input type="number" value="" name="initial_paid_amount" class="form-control">
                                        @error('initial_paid_amount')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <label for="inputText" class="col-form-label">About Patient Problem</label>
                                    <div>
                                        <textarea name="about_patient_problem" class="form-control patient-problem" cols="20" rows="10"></textarea>
                                        @error('about_patient_problem')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>


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
    <script>
        function checkIfExist() {
            const givenInput = document.getElementById('number-or-id').value.trim();
            if (givenInput) {
                document.getElementById('spinner-div').classList.remove('d-none');
                const url = "{{ route('admin.checkPatientPriviousBooking') }}?userinput=" + encodeURIComponent(givenInput);
                fetch(url, {
                        method: "GET",
                        headers: {
                            "Content-Type": "application/json"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status) {
                            console.log('data[0] ', data[0]);
                            document.getElementById('patient-name').value = data[0].patient_name;
                            document.getElementById('phone-number').value = data[0].phone_number;
                            document.getElementById('address').value = data[0].address;
                            document.getElementById('span-text').innerHTML =
                                '<p class="span-text-p-color">(The patient is already exist)</p>';
                        } else {
                            document.getElementById('patient-name').value = '';
                            document.getElementById('phone-number').value = ''
                            document.getElementById('address').value = '';
                            document.getElementById('span-text').innerHTML =
                                '<p class="span-text-p-color">(This is a new patient)</p>';
                        }
                        document.getElementById('spinner-div').classList.add('d-none');
                        document.getElementById('patient-registration-form').classList.remove('d-none');
                    })
                    .catch(error => {
                        document.getElementById('spinner-div').classList.add('d-none');
                        document.getElementById('top-span-text').innerHTML =
                            'Some Error Occur, Try again or Reload the Page..';
                    });
            } else {
                swal("Please put the correct input first.");
            }
        }

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

        function checkIfOperation(getvalue) {
            if (getvalue.value.trim() == '{{ $operationId }}') {
                console.log(typeof(getvalue.value.trim()), typeof('{{ $operationId }}'));
                const url = "{{ route('admin.checkIfBookingTypeOperation') }}";
                fetch(url, {
                        method: "GET",
                        headers: {
                            "Content-Type": "application/json"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status) {
                            console.log('data ', data.allBookingTypes);
                            let optionsHtml = data.allBookingTypes.map(type =>
                                `<option value="${type.id}" data-price="${type.price}">${type.name}</option>`
                            ).join('');

                            const schemeHtml = `
                        <label for="inputText" class="col-form-label">Operation Schemes</label>
                        <div>
                            <select name="operation_scheme_id" class="form-control" id="operation-scheme-select">
                                <option value="">--select operation schemes--</option>
                                ${optionsHtml}
                            </select>
                            @error('operation_scheme_id')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>`;
                            document.getElementById('operation-type').innerHTML = schemeHtml;
                            document.querySelector('#operation-scheme-select').addEventListener('change', function() {
                                var selectedOption = this.options[this.selectedIndex];
                                var selectedPrice = selectedOption.getAttribute('data-price');
                                document.querySelector('input[name="amount"]').value = selectedPrice;
                            });

                        } else {
                            document.getElementById('top-span-text').innerHTML = 'No operation schemes found.';
                        }
                    })
                    .catch(error => {
                        document.getElementById('top-span-text').innerHTML =
                            'Some Error Occur, Try again or Reload the Page..';
                    });
            } else {
                document.getElementById('operation-type').innerHTML = '';
            }
        }

        function createNewBooking() {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.innerHTML =
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
            submitBtn.disabled = true;

            const formData = new FormData();
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
