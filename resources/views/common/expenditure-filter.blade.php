<div class="row mb-3">
    <div class="col-sm-4">
        <label for="inputEmail" class="col-form-label">From Date</label>

        <input type="date" name="from_date" class="form-control" value="{{ request('from_date', $fromDate) }}">
    </div>
    <div class="col-sm-4">
        <label for="inputEmail" class="col-form-label">To Date</label>
        <input type="date" name="to_date" class="form-control" value="{{ request('to_date', $toDate) }}">
    </div>

    <div class="col-sm-4">
        <label for="inputEmail" class="col-form-label">Select Category</label>
        <select name="donation_type" class="form-control">
            <option value="">-select-</option>
            @foreach (\App\enum\ExpenditureCategoryEnum::values() as $value)
                <option value="{{ $value }}" {{ request('donation_type') == $value ? 'selected' : '' }}>
                    {{ $value }}</option>
            @endforeach
        </select>
    </div>



</div>
