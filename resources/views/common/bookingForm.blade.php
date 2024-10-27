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