@extends('employee.layout.main')
@section('title', 'Edit Expenditure | ')
@section('content')
    <section class="section dashboard">

        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Expenditure</h5>
                        @if (Session::has('msg'))
                            <p id="flash-message" class="alert alert-info">{{ Session::get('msg') }}</p>
                        @endif
                        <form action="{{ route('recep-expenditure-manages.update', $expenditure->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf

                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Ammount</label>
                                <div class="col-sm-10">
                                    <input type="text" name="ammount" class="form-control"
                                        value="{{ $expenditure->ammount }}">
                                    @error('ammount')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail" class="col-sm-2 col-form-label">Type</label>
                                <div class="col-sm-10">
                                    <select name="debit_or_credit" class="form-control">
                                        @foreach (\App\enum\ExpenditureTypeEnum::values() as $value)
                                            <option value="{{ $value }}"
                                                {{ $expenditure->debit_or_credit == $value ? 'selected' : '' }}>
                                                {{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('debit_or_credit')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputNumber" class="col-sm-2 col-form-label">Note</label>
                                <div class="col-sm-10">
                                    <input type="text" name="note" class="form-control"
                                        value="{{ $expenditure->note }}">
                                    @error('note')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Date</label>
                                <div class="col-sm-10">
                                    <input type="date" name="date" class="form-control" value="{{ $expenditure->date ?? ' ' }}" required>
                                    @error('date')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-sm btn-primary float-end m-2">Submit Form</button>
                                    <a href="{{ route('recep-expenditure-manages.index') }}" type="submit"
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
