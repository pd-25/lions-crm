<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item {{ Route::is('employee.patients.index') ? 'active' : ''}}">
            <a class="nav-link " href="{{route('employee.patients.index')}}">
                <i class="bi bi-grid"></i>
                <span>Patients</span>
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse"
                href="#">
                <i class="bi bi-menu-button-wide"></i><span>Bookings</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse {{(Route::is('employee.register-bookings.index') || Route::is('booking-types.index')) ? 'show' : ''}}" data-bs-parent="#sidebar-nav">
                <li>
                    <a class="{{ Route::is('employee.register-bookings.index') ? 'active' : ''}}" href="{{route('employee.register-bookings.index')}}">
                        <i class="ri-group-fill"></i>
                        <span>Booking List</span>
                    </a>
                </li>

                <li class="">
                    <a class="{{ Route::is('employee-booking-types.index') ? 'active' : ''}}" href="{{route('employee-booking-types.index')}}">
                        <i class="ri-group-fill"></i>
                        <span>Booking Type</span>
                    </a>
                </li>
                
            </ul>
        </li>
        {{-- <li class="nav-item {{ Route::is('members.index') ? 'active' : ''}}">
            <a class="nav-link " href="{{route('members.index')}}">
                <i class="ri-group-fill"></i>
                <span>Members</span>
            </a>
        </li> --}}
        {{-- <li class="nav-item {{ Route::is('operation-schemes.index') ? 'active' : ''}}">
            <a class="nav-link " href="{{route('operation-schemes.index')}}">
                <i class="ri-book-3-fill"></i>
                <span>Operation Schemes</span>
            </a>
        </li> --}}

        

        

        {{-- <li class="nav-item {{ Route::is('expenditure-manages.index') ? 'active' : ''}}">
            <a class="nav-link " href="{{route('expenditure-manages.index')}}">
                <i class="ri-group-fill"></i>
                <span>Expenditure Mgmt</span>
            </a>
        </li> --}}
        

    </ul>

</aside>