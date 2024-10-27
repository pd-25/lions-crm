<script>
    function checkIfOperation(getvalue) {
    if (getvalue.value.trim() == '{{ $operationId }}') {
        console.log(typeof (getvalue.value.trim()), typeof ('{{ $operationId }}'));
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
                    document.querySelector('#operation-scheme-select').addEventListener('change', function () {
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
                // if (data.status) {
                //     console.log('data[0] ', data[0]);
                //     document.getElementById('patient-name').value = data[0].patient_name;
                //     document.getElementById('phone-number').value = data[0].phone_number;
                //     document.getElementById('address').value = data[0].address;
                //     document.getElementById('span-text').innerHTML =
                //         '<p class="span-text-p-color">(The patient is already exist)</p>';
                // } else {
                //     document.getElementById('patient-name').value = '';
                //     document.getElementById('phone-number').value = ''
                //     document.getElementById('address').value = '';
                //     document.getElementById('span-text').innerHTML =
                //         '<p class="span-text-p-color">(This is a new patient)</p>';
                // }
                if (data.status && data.patientList.patients.length > 0) {
                    document.getElementById('top-span-text').innerHTML = '';
                    const patientListContainer = document.getElementById('existing-patient-list');
                    patientListContainer.classList.remove('d-none'); // Show the container
                    patientListContainer.querySelector('.row').innerHTML = ''; // Clear existing content

                    // Loop through each patient and append it to the list
                    data.patientList.patients.forEach(patient => {
                        const patientCard = `
                                            <div class="col-md-3 mt-2">
                                                <div class="card h-100">
                                                    <div class="card-body">
                                                        <h5 class="card-title">${patient.patient_name}</h5>
                                                        <p class="card-text">${patient.address}</p>
                                                        <button class="btn btn-primary btn-md w-100" onclick='useData("${patient.patient_name}", "${patient.address}", ${patient.user_id})'>Use</button>
                                                    </div>
                                                </div>
                                            </div>
                                        `;

                        patientListContainer.querySelector('.row').insertAdjacentHTML('beforeend',
                            patientCard);
                    });
                    document.getElementById('patient-registration-form').classList.remove('d-none');
                    document.getElementById('patient-name').value = '';
                    document.getElementById('phone-number').value = ''
                    document.getElementById('address').value = '';




                } else {
                    const row = document.querySelector('#existing-patient-list .row');

                    // Remove all elements with class col-md-3 if they exist
                    const existingPatients = row.querySelectorAll('.col-md-3');
                    existingPatients.forEach(patient => patient.remove());
                    document.getElementById('top-span-text').innerHTML = 'This is a new number..';
                    document.getElementById('patient-registration-form').classList.remove('d-none');
                    document.getElementById('patient-name').value = '';
                    document.getElementById('phone-number').value = ''
                    document.getElementById('address').value = '';
                }
                document.getElementById('spinner-div').classList.add('d-none');
                // document.getElementById('patient-registration-form').classList.remove('d-none');
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

function useData(patientName, patientAddress, patientId) {
    console.log(patientName, patientAddress, patientId);
    const givenInput = document.getElementById('number-or-id').value.trim();

    document.getElementById('patient-name').value = patientName;
    document.getElementById('phone-number').value = givenInput;
    document.getElementById('address').value = patientAddress;
    document.getElementById('existing_patient_id').value = patientId;
    document.getElementById('patient-name').readOnly = true;
    document.getElementById('phone-number').readOnly = true;
    document.getElementById('address').readOnly = true;


    document.getElementById('span-text').innerHTML =
        '<p class="span-text-p-color">(System auto fillup the personal details)</p>';

}

function resetForm() {
    const form = document.getElementById('booking-form');
    form.reset();
    document.getElementById('span-text').innerHTML = ''
    document.getElementById('patient-name').readOnly = false;
    document.getElementById('phone-number').readOnly = false;
    document.getElementById('address').readOnly = false;
    const errorMessages = form.querySelectorAll('.text-danger');
    errorMessages.forEach(message => {
        message.innerHTML = '';
    });
    document.getElementById('existing_patient_id').value = '0';

}
</script>