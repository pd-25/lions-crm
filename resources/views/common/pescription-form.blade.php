<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Pescription</h5>
            @if (Session::has('msg'))
                <p id="flash-message" class="alert alert-info">{{ Session::get('msg') }}</p>
            @endif
            <form action="{{ route('admin.savePescription', $registerBooking->slug) }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label for=""><b>Booking Number</b></label>
                        <input type="text" class="form-control" value="{{ $registerBooking->booking_id }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label for=""><b>Venue</b></label><span class="text-danger">*</span>
                        <input type="text" placeholder="Enter venue"
                            value="{{ $registerBooking->pescription?->venue ?? '' }}" name="venue"
                            class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label for=""><b>Booking Date</b></label>
                        <input type="text"
                            value="{{ \Carbon\Carbon::parse($registerBooking->created_at)->format('d M, Y h:i A') }}"
                            class="form-control" readonly>
                    </div>

                    <div class="col-md-6">
                        <label for=""><b>Patient Name</b></label>
                        <input type="text" placeholder="Enter venue" class="form-control"
                            value="{{ $registerBooking->patient->name }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label for=""><b>Age</b></label><span class="text-danger">*</span>
                        <input type="text" placeholder="Enter Patient Age"
                            value="{{ $registerBooking->pescription?->age ?? '' }}" name="age" class="form-control"
                            required>
                    </div>

                    <div class="col-md-4">
                        <label for=""><b>Sex</b></label><span class="text-danger">*</span>
                        <input type="text" placeholder="Enter Patient Sex"
                            value="{{ $registerBooking->pescription?->sex ?? '' }}" name="sex" class="form-control"
                            required>
                    </div>

                    <div class="col-md-4">
                        <label for=""><b>Mobile</b></label>
                        <input type="text" placeholder="Enter Patient Sex" class="form-control"
                            value="{{ $registerBooking->patient->phone_number }}" @readonly(true)>
                    </div>
                    <div class="col-md-6">
                        <label for=""><b>Father's/Husband Name</b></label><span class="text-danger">*</span>
                        <input type="text" placeholder="Enter Father's/Husband Name"
                            value="{{ $registerBooking->pescription?->guardians_name ?? '' }}" name="guardians_name"
                            class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label for=""><b>Doctor/Optometrist</b></label><span class="text-danger">*</span>
                        <input type="text" placeholder="Enter Doctor/Optometrist"
                            value="{{ $registerBooking->pescription?->doctor ?? '' }}" name="doctor"
                            class="form-control" required>
                    </div>

                    {{-- <div class="col-md-6">
                        <label for=""><b>Clinical Findings</b></label><span class="text-danger">*</span>
                        <div id="clinical-findings-wrapper">
                            <div class="clinical-finding-input d-flex align-items-center">
                                <input type="text" placeholder="write here" name="clinical_findings[]"
                                    class="form-control" required>
                            </div>
                        </div>
                        <button type="button" id="add-more-button" class="btn btn-primary mt-2">Add
                            More</button>
                    </div>

                    <div class="col-md-6">
                        <label for=""><b>Advice</b></label><span class="text-danger">*</span>
                        <div id="advices-wrapper">
                            <div class="advice-input d-flex align-items-center">
                                <input type="text" placeholder="write here" name="advice[]" class="form-control"
                                    required>
                            </div>
                        </div>
                        <button type="button" id="add-more-button-advice" class="btn btn-primary mt-2">Add
                            More</button>
                    </div> --}}
                    <div class="col-md-6">
                        <label for=""><b>Clinical Findings</b></label><span class="text-danger">*</span>
                        <div id="clinical-findings-wrapper">
                            @if (!empty($registerBooking->pescription?->clinical_findings))
                                @foreach (json_decode($registerBooking->pescription->clinical_findings) as $finding)
                                    <div class="clinical-finding-input d-flex align-items-center mt-2">
                                        <input type="text" placeholder="write here" name="clinical_findings[]"
                                            class="form-control" value="{{ $finding }}" required>
                                        <button type="button"
                                            class="btn btn-danger btn-sm ms-2 remove-button">Remove</button>
                                    </div>
                                @endforeach
                            @else
                                <div class="clinical-finding-input d-flex align-items-center">
                                    <input type="text" placeholder="write here" name="clinical_findings[]"
                                        class="form-control" required>
                                </div>
                            @endif
                        </div>
                        <button type="button" id="add-more-button" class="btn btn-primary mt-2">Add More</button>
                    </div>

                    <div class="col-md-6">
                        <label for=""><b>Advice</b></label><span class="text-danger">*</span>
                        <div id="advices-wrapper">
                            @if (!empty($registerBooking->pescription?->advice))
                                @foreach (json_decode($registerBooking->pescription->advice) as $advice)
                                    <div class="advice-input d-flex align-items-center mt-2">
                                        <input type="text" placeholder="write here" name="advice[]"
                                            class="form-control" value="{{ $advice }}" required>
                                        <button type="button"
                                            class="btn btn-danger btn-sm ms-2 remove-button-advice">Remove</button>
                                    </div>
                                @endforeach
                            @else
                                <div class="advice-input d-flex align-items-center">
                                    <input type="text" placeholder="write here" name="advice[]"
                                        class="form-control" required>
                                </div>
                            @endif
                        </div>
                        <button type="button" id="add-more-button-advice" class="btn btn-primary mt-2">Add
                            More</button>
                    </div>



                </div>
                <div class="float-end m4">
                    <a target="_blank" class="m-3" title="Print" href="{{route('get-pescription-print', $registerBooking->slug)}}" ><i class="ri-download-fill">Print</i></a>
                    <button type="submit" class="btn btn-md btn-success">Save</button>
                </div>
            </form>


        </div>
    </div>
</div>

<script>
    document.getElementById('add-more-button').addEventListener('click', function() {
        const wrapper = document.getElementById('clinical-findings-wrapper');

        // Create a new input div with remove button
        const newInputDiv = document.createElement('div');
        newInputDiv.classList.add('clinical-finding-input', 'd-flex', 'align-items-center', 'mt-2');

        const newInput = document.createElement('input');
        newInput.type = 'text';
        newInput.placeholder = 'write here';
        newInput.name = 'clinical_findings[]';
        newInput.classList.add('form-control');

        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.classList.add('btn', 'btn-danger', 'btn-sm', 'ms-2', 'remove-button');
        removeButton.innerText = 'Remove';

        // Append the input and remove button to the div
        newInputDiv.appendChild(newInput);
        newInputDiv.appendChild(removeButton);

        // Add the new input div to the wrapper
        wrapper.appendChild(newInputDiv);
    });

    document.getElementById('clinical-findings-wrapper').addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('remove-button')) {
            event.target.parentElement.remove();
        }
    });


    document.getElementById('add-more-button-advice').addEventListener('click', function() {
        const wrapper = document.getElementById('advices-wrapper');

        const newInputDiv = document.createElement('div');
        newInputDiv.classList.add('advice-input', 'd-flex', 'align-items-center', 'mt-2');

        const newInput = document.createElement('input');
        newInput.type = 'text';
        newInput.placeholder = 'write here';
        newInput.name = 'advice[]';
        newInput.classList.add('form-control');

        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.classList.add('btn', 'btn-danger', 'btn-sm', 'ms-2', 'remove-button-advice');
        removeButton.innerText = 'Remove';

        newInputDiv.appendChild(newInput);
        newInputDiv.appendChild(removeButton);

        wrapper.appendChild(newInputDiv);
    });

    document.getElementById('advices-wrapper').addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('remove-button-advice')) {
            event.target.parentElement.remove();
        }
    });
</script>
