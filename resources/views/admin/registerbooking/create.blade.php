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
                                    placeholder="Enter phone number or privious booking ID" class="form-control" required>
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
                        <h5 class="card-title">Patient Details</h5>
                        <span id="span-text"></span>
                        <form action="{{ route('register-bookings.store') }}" method="POST">
                            @method('POST')
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="inputText" class="col-form-label">Patient Name</label>
                                    <div>
                                        <input type="text" name="patient_name" class="form-control" id="patient-name"
                                            required>
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
                                        <input type="number" name="phone_number" class="form-control" id="phone-number"
                                            required>
                                        @error('phone_number')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <label for="inputText" class="col-form-label">Adderss</label>
                                    <div>
                                        <input type="text" name="address" class="form-control" id="address" required>
                                        @error('address')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label for="inputText" class="col-form-label">Amount</label>
                                    <div>
                                        <input type="number" value="100" name="amount" class="form-control" required>
                                        @error('amount')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <label for="inputText" class="col-form-label">About Patient Problem</label>
                                    <div>
                                        <textarea name="about_patient_problem" class="form-control patient-problem" required cols="20" rows="10"></textarea>
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
                                    <button type="submit" class="btn btn-sm btn-primary float-end m-2">Submit</button>
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
                            document.getElementById('span-text').innerHTML = 'The patient is already exist';
                        } else {
                            document.getElementById('patient-name').value = '';
                            document.getElementById('phone-number').value = ''
                            document.getElementById('address').value = '';
                            document.getElementById('span-text').innerHTML = 'This is a new patient';
                        }
                        document.getElementById('spinner-div').classList.add('d-none');
                        document.getElementById('patient-registration-form').classList.remove('d-none');
                    })
                    .catch(error => {
                        document.getElementById('spinner-div').classList.add('d-none');
                        document.getElementById('top-span-text').innerHTML = 'Some Error Occur, Try again or Reload the Page..';
                    });
            } else {
                swal("Please put the correct input first.");
            }
        }
    </script>
@endsection
