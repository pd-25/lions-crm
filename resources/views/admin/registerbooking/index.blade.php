@extends('admin.layout.main')
@section('title', 'Booking List | ')
@section('content')
    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">

                        <h5 class="card-title">All Bookings</h5>
                        @if (Session::has('msg'))
                            <p id="flash-message" class="alert alert-info">{{ Session::get('msg') }}</p>
                        @endif
                        <form action="{{ route('register-bookings.index') }}" method="get">
                            <div class="d-flex">
                                <input type="text" class="form-control" placeholder="Search by booking Id, Phone, name " name="search_text"
                                    value="{{ @request()->search_text }}">
                                <button class="btn btn-md btn-success m-2">Search</button>
                            </div>
                        </form>
                        <a class="btn btn-sm btn-outline-success float-end"
                            href="{{ route('register-bookings.create') }}">New
                            Booking</a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Booking ID</th>
                                    <th scope="col">Booking Type</th>
                                    <th scope="col">Phone Number</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Done By</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($allbookings as $allbooking)
                                    <tr>
                                        <th scope="row">{{ '#' . $allbooking->booking_id }} <br><a href="{{ route('patients.show', $allbooking->patient->slug) }}">{{ $allbooking->patient->name }}</a>  </th>
                                        <td>{!! $allbooking->booking_type_or_operation !!}</td>
                                        <td>{{ $allbooking->patient->phone_number }}</td>
                                        <td><b>{{ $allbooking->amount }}</b>
                                            <br>Paid: <span class="text-success">{{$allbooking->bookingPaymrnts->sum("amount")}}</span><br>
                                            Due: <span class="text-danger">{{($allbooking->amount -$allbooking->bookingPaymrnts->sum("amount"))}}</span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($allbooking->created_at)->format('dM, Y h:i A') }}</td>
                                        <td>{{ $allbooking?->checkAction?->name  ?? 'N/A' }}</td>
                                        <td>
                                            <a title="View Details" href="{{ route('register-bookings.show', $allbooking->slug) }}"><i
                                                    class="ri-eye-fill"></i></a>
                                                    <a target="_blank" title="Print" href="{{route('get-print', $allbooking->slug)}}" ><i class="ri-download-fill"></i></a>
                                            {{-- @dump($allbooking->amount, $allbooking->bookingPaymrnts->sum('amount')) --}}
                                            @if (
                                                $allbooking->bookingPaymrnts->sum('amount') != $allbooking->amount &&
                                                    $allbooking->bookingPaymrnts->sum('amount') < $allbooking->amount)
                                                <span class="more-btn" data-bs-toggle="modal"
                                                    data-bs-target="#verticalycentered" data-slug={{ $allbooking->slug }}
                                                    data-total-amount="{{ $allbooking->amount }}"
                                                    data-due-amount="{{ $allbooking->bookingPaymrnts->sum('amount') }}">
                                                    {{-- $allbooking->amount, sum of -$allbooking->bookingPaymrnts amount field   --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        fill="currentColor" width="16" height="16">
                                                        <path
                                                            d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22ZM13.5003 8C13.8278 8.43606 14.0625 8.94584 14.175 9.5H16V11H14.175C13.8275 12.7117 12.3142 14 10.5 14H10.3107L14.0303 17.7197L12.9697 18.7803L8 13.8107V12.5H10.5C11.4797 12.5 12.3131 11.8739 12.622 11H8V9.5H12.622C12.3131 8.62611 11.4797 8 10.5 8H8V6.5H16V8H13.5003Z">
                                                        </path>
                                                    </svg>
                                                </span>
                                            @endif



                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                        {{ $allbookings->links() }}
                        <!-- End Default Table Example -->
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="verticalycentered" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Amount</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="error-Msg">

                        </div>
                        <div>
                            <label for="inputText" class="col-form-label">Total Amount</label>
                            <input type="number" name="total_amount" class="form-control" readonly>
                        </div>
                        <div>
                            <label for="inputText" class="col-form-label">Paid Amount</label>
                            <input type="number" name="paid_amount" class="form-control" readonly>
                        </div>
                        <div>
                            <label for="inputText" class="col-form-label">Due Amount</label>
                            <input type="number" name="due_amount" class="form-control">
                        </div>
                        <input type="hidden" name="booking_slug">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="update-btn" onclick="saveDueAmount()">Save
                            changes</button>
                    </div>
                </div>
            </div>
        </div>


    </section>
@endsection
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('verticalycentered');
            modal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const totalAmount = button.getAttribute('data-total-amount');
                const paidAmount = button.getAttribute('data-due-amount');
                const bookingSlug = button.getAttribute('data-slug');
                modal.querySelector('input[readonly][name="total_amount"]').value = totalAmount;
                modal.querySelector('input[readonly][name="paid_amount"]').value = paidAmount;
                modal.querySelector('input[name="due_amount"]').value = parseInt(totalAmount) - parseInt(
                    paidAmount);
                modal.querySelector('input[name="booking_slug"]').value = bookingSlug

            });
        });

        function saveDueAmount() {
            const updateBtn = document.getElementById('update-btn');
            updateBtn.innerHTML =
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
            updateBtn.disabled = true;
            const bookingSlug = document.querySelector('input[name="booking_slug"]').value;
            const dueAmount = document.querySelector('input[name="due_amount"]').value;
            console.log("bookingSlug- ", bookingSlug);
            const url = `{{ route('admin.updatePayment', ['register_booking_slug' => ':register_booking_slug']) }}`
                .replace(':register_booking_slug', bookingSlug);
            fetch(url, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        due_amount: dueAmount
                    })

                })
                .then(response => response.json())
                .then(data => {
                    updateBtn.innerHTML = 'Submit';
                    updateBtn.disabled = false;
                    if (data.status) {
                        swal(data.msg, "", "success")

                    } else {
                        swal(data.msg, "", "error")
                    }
                })
                .catch(error => {
                    updateBtn.innerHTML = 'Submit';
                    updateBtn.disabled = false;
                    document.getElementById('error-Msg').innerHTML =
                        `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Some Error Occur, Try again or Reload the Page..
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>`;
                });
        }
    </script>
@endsection
