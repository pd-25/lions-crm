@extends('employee.layout.main')
@section('title', 'Expenditures | ')
@section('content')
    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">

                        <h5 class="card-title">All Receive/Payment</h5>
                        
                        <form method="GET" action="{{ route('recep-expenditure-manages.index') }}">
                            @include('common.expenditure-filter')
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                                <a href="{{ route('recep-expenditure-manages.index') }}" type="submit" class="btn btn-sm btn-danger">Clear</a>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-sm-6">
                                <h4><strong>Total Credit</strong>: <span class="text-success">{{ number_format($totalCredit, 2) }}</span></h4>
                            </div>
                            <div class="col-sm-6">
                                <h4><strong>Total Debit</strong>: <span class="text-danger">{{ number_format($totalDebit, 2) }}</span></h4>
                            </div>
                        </div>
                        @if (Session::has('msg'))
                            <p id="flash-message" class="alert alert-info">{{ Session::get('msg') }}</p>
                        @endif
                        <a class="btn btn-sm btn-outline-success float-end"
                            href="{{ route('recep-expenditure-manages.create') }}">Add
                            Expenditure</a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Sub Category</th>
                                    <th scope="col">Ammount</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Note</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Added By</th>
                                    {{-- <th scope="col">Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $startIndex = ($expenditures->currentPage() - 1) * $expenditures->perPage() + 1;
                                @endphp
                                @foreach ($expenditures as $expenditure)
                                    <tr>
                                        <th scope="row">{{ $startIndex++ }}</th>
                                        <td class="{{getExpenditureCategory($expenditure->donation_type)}} mt-1">{{ $expenditure->donation_type ?? 'N/A' }}</td>
                                        <td class="mt-1"> {{ $expenditure->donation_sub_type ?? 'N/A' }}</td>
                                        <td>{{ $expenditure->ammount }}</td>

                                        <td><span
                                                class="{{ getExpenditureType($expenditure->debit_or_credit) }}">{{ $expenditure->debit_or_credit }}</span>
                                        </td>
                                        <td>{{ $expenditure->note }}</td>
                                        <td> {{ \Carbon\Carbon::parse($expenditure->date)->format('dM, Y') }}
                                        </td>
                                        <td>{{ $expenditure?->checkAction?->name }}</td>
                                        {{-- <td>
                                            <a href="{{ route('recep-expenditure-manages.edit', encrypt($expenditure->id)) }}"><i
                                                    class="ri-pencil-fill"></i></a>
                                            <form method="POST"
                                                action="{{ route('recep-expenditure-manages.destroy', $expenditure->id) }}"
                                                class="d-inline-block pl-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="delete-icon show_confirm"
                                                    data-toggle="tooltip" title='Delete'>

                                                    <i class="ri-delete-bin-2-fill"></i>

                                                </button>
                                            </form>
                                        </td> --}}
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                        {{ $expenditures->links() }}
                        <!-- End Default Table Example -->
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
