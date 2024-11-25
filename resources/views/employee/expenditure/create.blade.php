@extends('employee.layout.main')
@section('title', 'Create Expenditure | ')
@section('content')
    <section class="section dashboard">

        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add New Receive/Payment</h5>
                        <form action="{{ route('recep-expenditure-manages.store') }}" method="POST" enctype="multipart/form-data" id="expenditureForm">
                            @csrf

                            @include('common.expenditure-create')
                            
                            
                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-sm btn-primary float-end m-2"  id="submitBtn">Submit Form</button>
                                    <a href="{{ route('recep-expenditure-manages.index') }}" class="btn btn-sm btn-danger float-end m-2">Cancel</a>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
