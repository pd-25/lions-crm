@extends('admin.layout.main')
@section('title', 'Expenditures | ')
@section('content')
    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">

                        <h5 class="card-title">All Expenditures</h5>
                        @if (Session::has('msg'))
                            <p class="alert alert-info">{{ Session::get('msg') }}</p>
                        @endif
                        <a class="btn btn-sm btn-outline-success float-end"
                            href="{{ route('expenditure-manages.create') }}">Add
                            Expenditure</a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Ammount</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Note</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $startIndex = ($expenditures->currentPage() - 1) * $expenditures->perPage() + 1;
                                @endphp
                                @foreach ($expenditures as $expenditure)
                                    <tr>
                                        <th scope="row">{{ $startIndex++ }}</th>
                                        <td>{{ $expenditure->ammount }}</td>

                                        <td><span
                                                class="{{ getExpenditureType($expenditure->debit_or_credit) }}">{{ $expenditure->debit_or_credit }}</span>
                                        </td>
                                        <td>{{ $expenditure->note }}</td>
                                        <td> {{ \Carbon\Carbon::parse($expenditure->join_date)->format('dM, Y h:i A') }}
                                        </td>
                                        <td>
                                            <a href="{{ route('expenditure-manages.edit', encrypt($expenditure->id)) }}"><i
                                                    class="ri-pencil-fill"></i></a>
                                            <form method="POST"
                                                action="{{ route('expenditure-manages.destroy', $expenditure->id) }}"
                                                class="d-inline-block pl-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="delete-icon show_confirm"
                                                    data-toggle="tooltip" title='Delete'>

                                                    <i class="ri-delete-bin-2-fill"></i>

                                                </button>
                                            </form>
                                        </td>
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
