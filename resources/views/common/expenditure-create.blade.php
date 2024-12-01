<div class="row mb-3">

    <div class="col-sm-4">
        <label for="inputEmail" class="col-form-label">Select Category</label>
        <select name="donation_type" class="form-control">
            <option value="">-select-</option>
            @foreach (\App\enum\ExpenditureCategoryEnum::values() as $value)
                <option value="{{ $value }}" {{ old('donation_type') == $value ? 'selected' : '' }}>
                    {{ $value }}</option>
            @endforeach
        </select>
        @error('donation_type')
            <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="row mb-3" id="donation-form">


</div>

<div class="row mb-3" id="salary-form">


</div>

<div class="row mb-3" id="member-pay-form">


</div>

@section('script')
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const donationTypeSelect = document.querySelector('[name="donation_type"]');
            const donationForm = document.getElementById('donation-form');
            const salaryForm = document.getElementById('salary-form');
            const memberPayForm = document.getElementById('member-pay-form');

            // Common HTML structure for Date, Amount, and Note fields
            function generateCommonFields() {
                return `
            <div class="col-sm-4">
                <label for="inputText" class="col-form-label">Date</label>
                <input type="date" name="date" class="form-control" value="{{ old('date') }}" required>
                @error('date')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-sm-4">
                <label for="inputText" class="col-form-label">Amount</label>
                <input type="text" name="ammount" class="form-control" value="{{ old('ammount') }}">
                @error('ammount')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-sm-12">
                <label for="inputNumber" class="col-form-label">Note</label>
                <input type="text" name="note" class="form-control" value="{{ old('note') }}">
                @error('note')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        `;
            }

            // Function to clear all form sections
            function clearForms() {
                donationForm.innerHTML = '';
                salaryForm.innerHTML = '';
                memberPayForm.innerHTML = '';
            }

            // Function to generate HTML for Donation type
            function generateDonationForm() {
                return `
            <h2><u>Please enter the donation details.</u></h2>
            
            <div class="col-sm-4">
                <label for="inputEmail" class="col-form-label">Type</label>
                <select name="debit_or_credit" class="form-control">
                    <option value="">-select-</option>
                    @foreach (\App\enum\ExpenditureTypeEnum::values() as $value)
                        <option value="{{ $value }}" {{ old('debit_or_credit') == $value ? 'selected' : '' }}>
                            {{ $value }}</option>
                    @endforeach
                </select>
                @error('debit_or_credit')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-sm-4">
                <label for="inputEmail" class="col-form-label">Select Document</label>
                <select name="unique_personal_doc_name" class="form-control">
                    <option value="">-select-</option>
                    @foreach (\App\enum\ExpenditureDocEnum::values() as $value)
                        <option value="{{ $value }}" {{ old('unique_personal_doc_name') == $value ? 'selected' : '' }}>
                            {{ $value }}</option>
                    @endforeach
                </select>
                @error('unique_personal_doc_name')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-sm-4">
                <label for="inputNumber" class="col-form-label">Document Number</label>
                <input type="text" name="unique_personal_doc_id" class="form-control" value="{{ old('unique_personal_doc_id') }}">
                @error('unique_personal_doc_id')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-sm-4">
                <label for="inputNumber" class="col-form-label">ID Code</label>
                <input type="text" name="id_code" class="form-control" value="{{ old('id_code') }}">
                @error('id_code')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-sm-4">
                <label for="inputNumber" class="col-form-label">Section Code</label>
                <input type="text" name="section_code" class="form-control" value="{{ old('section_code') }}">
                @error('section_code')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-sm-4">
                <label for="inputEmail" class="col-form-label">Payment Mode</label>
                <select name="payment_mode" class="form-control">
                    <option value="">-select-</option>
                    @foreach (\App\enum\ExpenditurePaymentModeEnum::values() as $value)
                        <option value="{{ $value }}" {{ old('payment_mode') == $value ? 'selected' : '' }}>
                            {{ $value }}</option>
                    @endforeach
                </select>
                @error('payment_mode')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-sm-6">
                <label for="inputNumber" class="col-form-label">Name of Donor</label>
                <input type="text" name="name_of_donor" class="form-control" value="{{ old('name_of_donor') }}">
                @error('name_of_donor')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-sm-6">
                <label for="inputNumber" class="col-form-label">Address of Donor</label>
                <input type="text" name="address_of_donor" class="form-control" value="{{ old('address_of_donor') }}">
                @error('address_of_donor')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            ${generateCommonFields()}
        `;
            }

            // Function to generate HTML for Salary type
            function generateSalaryForm() {
                return `
            <h2><u>Please enter the salary details.</u></h2>
           
            <div class="col-sm-4">
                <label for="inputEmail" class="col-form-label">Select Stuff</label>
                <select name="member_id" class="form-control">
                    <option value="">-select-</option>
                    @forelse ($stuffs as $stuff)
                        <option value="{{ $stuff->id }}">{{ $stuff->name }}</option>
                    @empty
                    @endforelse
                </select>
                @error('member_id')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
             ${generateCommonFields()}
        `;
            }

            // Function to generate HTML for Member Payment type
            function generateMemberPayForm() {
                return `
            <h2><u>Please enter the member payment details.</u></h2>
           
            <div class="col-sm-4">
                <label for="inputEmail" class="col-form-label">Select member</label>
                <select name="member_id" class="form-control">
                    <option value="">-select-</option>
                    @forelse ($members as $member)
                        <option value="{{ $member->id }}">{{ $member->name }}</option>
                    @empty
                    @endforelse
                </select>
                @error('member_id')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
             ${generateCommonFields()}
        `;
            }

            // Event listener for donation_type change
            donationTypeSelect.addEventListener('change', function() {
                const selectedType = donationTypeSelect.value;

                clearForms(); // Clear all forms

                switch (selectedType) {
                    case 'Donation':
                        donationForm.innerHTML = generateDonationForm();
                        break;
                    case 'Salary':
                        salaryForm.innerHTML = generateSalaryForm();
                        break;
                    case 'Member Payment':
                        memberPayForm.innerHTML = generateMemberPayForm();
                        break;
                    default:
                        break;
                }
            });
        });
    </script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const donationTypeSelect = document.querySelector('[name="donation_type"]');
            const donationForm = document.getElementById('donation-form');
            const salaryForm = document.getElementById('salary-form');
            const memberPayForm = document.getElementById('member-pay-form');
            const submitBtn = document.getElementById('submitBtn'); // Your submit button

            // Common HTML structure for Date, Amount, and Note fields
            function generateCommonFields() {
                return `
            <div class="col-sm-4">
                <label for="inputText" class="col-form-label">Date</label>
                <input type="date" name="date" class="form-control" required>
            </div>
            <div class="col-sm-4">
                <label for="inputText" class="col-form-label">Amount</label>
                <input type="text" name="ammount" class="form-control">
            </div>
            <div class="col-sm-4">
                <label for="inputEmail" class="col-form-label">Type</label>
                <select name="debit_or_credit" class="form-control">
                    <option value="">-select-</option>
                    @foreach (\App\enum\ExpenditureTypeEnum::values() as $value)
                        <option value="{{ $value }}" {{ old('debit_or_credit') == $value ? 'selected' : '' }}>
                            {{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-12">
                <label for="inputNumber" class="col-form-label">Note</label>
                <input type="text" name="note" class="form-control">
            </div>

        `;
            }

            // Function to generate HTML for Donation type
            function generateDonationForm(category) {
                return `
            <h2><u>Please enter the ${category} details.</u></h2>
            
            

            <div class="col-sm-4">
                <label for="inputEmail" class="col-form-label">Select Document</label>
                <select name="unique_personal_doc_name" class="form-control">
                    <option value="">-select-</option>
                    @foreach (\App\enum\ExpenditureDocEnum::values() as $value)
                        <option value="{{ $value }}" {{ old('unique_personal_doc_name') == $value ? 'selected' : '' }}>
                            {{ $value }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-sm-4">
                <label for="inputNumber" class="col-form-label">Document Number</label>
                <input type="text" name="unique_personal_doc_id" class="form-control">
            </div>

            <div class="col-sm-4">
                <label for="inputNumber" class="col-form-label">ID Code</label>
                <input type="text" name="id_code" class="form-control">
            </div>

            <div class="col-sm-4">
                <label for="inputNumber" class="col-form-label">Section Code</label>
                <input type="text" name="section_code" class="form-control">
            </div>

            <div class="col-sm-4">
                <label for="inputEmail" class="col-form-label">Payment Mode</label>
                <select name="payment_mode" class="form-control">
                    <option value="">-select-</option>
                    @foreach (\App\enum\ExpenditurePaymentModeEnum::values() as $value)
                        <option value="{{ $value }}" {{ old('payment_mode') == $value ? 'selected' : '' }}>
                            {{ $value }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-sm-6">
                <label for="inputNumber" class="col-form-label">Name of Donor</label>
                <input type="text" name="name_of_donor" class="form-control">
            </div>

            <div class="col-sm-6">
                <label for="inputNumber" class="col-form-label">Address of Donor</label>
                <input type="text" name="address_of_donor" class="form-control">
            </div>

            ${generateCommonFields()}
        `;
            }

            function generateSalaryForm() {
                return `
                    <h2><u>Please enter the salary details.</u></h2>
                    <div class="col-sm-4">
                        <label for="inputEmail" class="col-form-label">Select Stuff</label>
                        <select name="member_id" class="form-control">
                            <option value="">-select-</option>
                            @forelse ($stuffs as $stuff)
                                <option value="{{ $stuff->id }}">{{ $stuff->name }}</option>
                            @empty
                            @endforelse
                        </select>
                        @error('member_id')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    ${generateCommonFields()}
                `;
            }

            function generateMemberPayForm() {
                return `
                    <h2><u>Please enter the member payment details.</u></h2>
                    <div class="col-sm-4">
                        <label for="inputEmail" class="col-form-label">Select member</label>
                        <select name="member_id" class="form-control">
                            <option value="">-select-</option>
                            @forelse ($members as $member)
                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                            @empty
                            @endforelse
                        </select>
                        @error('member_id')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    ${generateCommonFields()}
                `;
            }

            // Function to clear all form sections
            function clearForms() {
                donationForm.innerHTML = '';
                salaryForm.innerHTML = '';
                memberPayForm.innerHTML = '';
            }

            // Event listener for donation_type change
            donationTypeSelect.addEventListener('change', function() {
                const selectedType = donationTypeSelect.value;

                clearForms(); // Clear all forms

                switch (selectedType) {
                    case 'Donation':
                    case 'District Grand':
                    case 'Blood Donation Camp':
                    case 'Fixed Deposit Interest':
                    case 'Interest in Bank':
                    case 'Other Contribution':
                        donationForm.innerHTML = generateDonationForm(selectedType);
                        break;
                    case 'Salary':
                        salaryForm.innerHTML = generateSalaryForm();
                        break;
                    case 'Member Payment':
                        memberPayForm.innerHTML = generateMemberPayForm();
                        break;
                    default:
                        break;
                }
            });

            // Handle the form submission with fetch
            function handleFormSubmission() {
                const form = document.querySelector('#expenditureForm');
                const formData = new FormData(form);
                submitBtn.innerHTML =
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
                submitBtn.disabled = true;
                const formAction = form.action;

                fetch(formAction, {
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
                        return response.json(); // Handle success response
                    })
                    .then(data => {
                        if (data.status === 'success') {
                            swal(data.msg, "", "success")
                                .then(() => {
                                    window.location.href = data.toUrl;
                                });
                        } else {
                            swal("Error creating expenditure. Please try again.", "", "error");
                            submitBtn.innerHTML = 'Submit';
                            submitBtn.disabled = false;
                        }
                    })
                    .catch(error => {
                        if (error.errors) {
                            // Clear previous error messages before adding new ones
                            document.querySelectorAll('.text-danger').forEach(element => {
                                element.remove();
                            });

                            // Display validation errors next to the respective fields
                            for (const [key, messages] of Object.entries(error.errors)) {
                                const inputElement = document.querySelector(`[name="${key}"]`);
                                if (inputElement) {
                                    // Only create and append new error messages if they don't exist already
                                    let errorElement = inputElement.parentElement.querySelector('.text-danger');
                                    if (!errorElement) {
                                        errorElement = document.createElement('span');
                                        errorElement.classList.add('text-danger');
                                        inputElement.parentElement.appendChild(errorElement);
                                    }

                                    errorElement.innerHTML = `<strong>${messages.join(' ')}</strong>`;
                                }
                            }
                        } else {
                            swal("Some error occurred. Please try again.", "", "error");
                        }

                        // Re-enable the submit button
                        submitBtn.innerHTML = 'Submit';
                        submitBtn.disabled = false;
                    });
            }

            // Attach the submit handler to the form submit
            const form = document.querySelector('#expenditureForm');
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                handleFormSubmission();
            });
        });
    </script>
@endsection
