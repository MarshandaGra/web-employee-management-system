@extends('dashboard.layouts.main')

@section('content')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="container py-2">
                <h1 class="h3">Salaries</h1>

                <div class="d-flex justify-content-between align-items-center mb-2 mt-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createSalariesModal">
                        Create
                    </button>
                    <form id="searchForm" action="{{ route('salaries.index') }}" method="GET"
                        class="d-flex align-items-center gap-2">
                        @csrf
                        <div class="form-group mb-0 position-relative">
                            <label for="search" class="sr-only">Search:</label>
                            <input type="text" placeholder="Search" id="search" name="search"
                                value="{{ request('search') }}" class="form-control shadow search-input">
                            <a href="{{ route('salaries.index') }}"
                                class="clear-search btn btn-sm position-absolute top-50 translate-middle-y end-0 me-2"
                                style="z-index: 10; padding: 0.2rem 0.4rem; line-height: 1; display: none;">
                                X
                            </a>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table border text-nowrap customize-table mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>
                                    <a
                                        href="{{ route('salaries.index', array_merge(request()->query(), ['sortBy' => 'employee', 'sortDirection' => request('sortDirection') === 'asc' ? 'desc' : 'asc'])) }}">
                                        Employee
                                        @if (request('sortBy') === 'employee')
                                            @if (request('sortDirection') === 'asc')
                                                &#9650;
                                            @else
                                                &#9660;
                                            @endif
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a
                                        href="{{ route('salaries.index', array_merge(request()->query(), ['sortBy' => 'amount', 'sortDirection' => request('sortDirection') === 'asc' ? 'desc' : 'asc'])) }}">
                                        Amount
                                        @if (request('sortBy') === 'amount')
                                            @if (request('sortDirection') === 'asc')
                                                &#9650;
                                            @else
                                                &#9660;
                                            @endif
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a
                                        href="{{ route('salaries.index', array_merge(request()->query(), ['sortBy' => 'payment_date', 'sortDirection' => request('sortDirection') === 'asc' ? 'desc' : 'asc'])) }}">
                                        Payment Date
                                        @if (request('sortBy') === 'payment_date')
                                            @if (request('sortDirection') === 'asc')
                                                &#9650;
                                            @else
                                                &#9660;
                                            @endif
                                        @endif
                                    </a>
                                </th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($salaries as $salary)
                                <tr>

                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $salary->employeeDetails->fullname }}</td>
                                    <td>Rp {{ number_format($salary->amount, 2, ',', '.') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($salary->payment_date)->format('d M Y') }}</td>
                                    <td class="text-center">
                                        <button data-bs-target="#editSalariesModal{{ $salary->id }}"
                                            data-bs-toggle="modal" class="btn btn-warning btn-sm">Edit</button>
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deleteSalariesModal{{ $salary->id }}"
                                            type="button">Delete</button>
                                    </td>
                                </tr>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="editSalariesModal{{ $salary->id }}" tabindex="-1"
                                    aria-labelledby="editSalariesModalLabel{{ $salary->id }}" aria-hidden="true"
                                    data-bs-backdrop="static">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editSalariesModalLabel{{ $salary->id }}">Edit
                                                    Salary</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('salaries.update', $salary->id) }}" method="POST">
                                                    @method('PUT')
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="employee_id" class="form-label">Employee</label>
                                                        <input type="hidden" value="{{ $salary->employee_id }}" name="employee_id">
                                                        <input readonly type="text" 
                                                            class="form-control  @error('employee') is-invalid @enderror"
                                                            id="employee"
                                                            value="{{ old('employee', $salary->employeeDetails->fullname) }}">
                                                        @error('employee')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="amount" class="form-label">Amount</label>
                                                        <input type="text" name="amount"
                                                            class="form-control @error('amount') is-invalid @enderror"
                                                            id="amount" value="{{ old('amount', $salary->amount) }}">
                                                        @error('amount')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="payment_date" class="form-label">Payment Date</label>
                                                        <input type="date" name="payment_date"
                                                            class="form-control @error('payment_date') is-invalid @enderror"
                                                            id="payment_date"
                                                            value="{{ old('payment_date', $salary->payment_date) }}">
                                                        @error('payment_date')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Delete -->
                                <div class="modal fade" id="deleteSalariesModal{{ $salary->id }}" tabindex="-1"
                                    aria-labelledby="deleteSalariesModalLabel{{ $salary->id }}" aria-hidden="true"
                                    data-bs-backdrop="static">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteSalariesModalLabel{{ $salary->id }}">
                                                    Confirm Delete</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete this record? This action cannot be
                                                    undone.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <form action="{{ route('salaries.destroy', $salary->id) }}"
                                                    method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <img src="{{ asset('assets/images/no-data.png') }}" alt="No Data"
                                            class="img-fluid" style="width: clamp(150px, 50vw, 300px);">
                                        <p class="mt-3">No data available.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Links -->
                <div class="mt-3 justify-content-end">
                    {{ $salaries->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="createSalariesModal" tabindex="-1" aria-labelledby="createSalariesModalLabel"
        aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createSalariesModalLabel">Create Salary</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('salaries.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="employee_id" class="form-label">Employee</label>
                            <select name="employee_id" id="employee_id" class="form-control">
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ $employee->id == old('employee_id', $employee->id) ? 'selected' : '' }}>
                                        {{ $employee->fullname }}
                                    </option>
                                @endforeach
                            </select>
                            @error('employee_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>        
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="text" name="amount"
                                class="form-control @error('amount') is-invalid @enderror" id="amount"
                                value="{{ old('amount') }}">
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="payment_date" class="form-label">Payment Date</label>
                            <input type="date" name="payment_date"
                                class="form-control @error('payment_date') is-invalid @enderror" id="payment_date"
                                value="{{ old('payment_date') }}">
                            @error('payment_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- 
@extends('dashboard.layouts.main')

@section('content')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="container py-2">
                <h1 class="h3">Salaries</h1>

                <div class="d-flex justify-content-between align-items-center mb-2 mt-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createSalariesModal">
                        Create
                    </button>
                    <form id="searchForm" action="{{ route('salaries.index') }}" method="GET"
                        class="d-flex align-items-center gap-2">
                        @csrf
                        <div class="form-group mb-0 position-relative">
                            <label for="search" class="sr-only">Search:</label>
                            <input type="text" placeholder="Search" id="search" name="search"
                                value="{{ request('search') }}" class="form-control shadow search-input">
                            <a href="{{ route('salaries.index') }}"
                                class="clear-search btn btn-sm position-absolute top-50 translate-middle-y end-0 me-2"
                                style="z-index: 10; padding: 0.2rem 0.4rem; line-height: 1; display: none;">
                                X
                            </a>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table border text-nowrap customize-table mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>
                                    <a href="{{ route('salaries.index', array_merge(request()->query(), ['sortBy' => 'employee', 'sortDirection' => request('sortDirection') === 'asc' ? 'desc' : 'asc'])) }}">
                                        Employee
                                        @if (request('sortBy') === 'employee')
                                            @if (request('sortDirection') === 'asc')
                                                &#9650;
                                            @else
                                                &#9660;
                                            @endif
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ route('salaries.index', array_merge(request()->query(), ['sortBy' => 'amount', 'sortDirection' => request('sortDirection') === 'asc' ? 'desc' : 'asc'])) }}">
                                        Amount
                                        @if (request('sortBy') === 'amount')
                                            @if (request('sortDirection') === 'asc')
                                                &#9650;
                                            @else
                                                &#9660;
                                            @endif
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ route('salaries.index', array_merge(request()->query(), ['sortBy' => 'payment_date', 'sortDirection' => request('sortDirection') === 'asc' ? 'desc' : 'asc'])) }}">
                                        Payment Date
                                        @if (request('sortBy') === 'payment_date')
                                            @if (request('sortDirection') === 'asc')
                                                &#9650;
                                            @else
                                                &#9660;
                                            @endif
                                        @endif
                                    </a>
                                </th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($salaries as $salary)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $salary->employeeDetail->fullname ?? 'No Employee' }}</td>
                                    <td>Rp {{ number_format($salary->amount, 2, ',', '.') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($salary->payment_date)->format('d M Y') }}</td>
                                    <td class="text-center">
                                        <button data-bs-target="#editSalariesModal{{ $salary->id }}"
                                            data-bs-toggle="modal" class="btn btn-warning btn-sm">Edit</button>
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deleteSalariesModal{{ $salary->id }}"
                                            type="button">Delete</button>
                                    </td>
                                </tr>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="editSalariesModal{{ $salary->id }}" tabindex="-1"
                                    aria-labelledby="editSalariesModalLabel{{ $salary->id }}" aria-hidden="true"
                                    data-bs-backdrop="static">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editSalariesModalLabel{{ $salary->id }}">Edit
                                                    Salary</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('salaries.update', $salary->id) }}" method="POST">
                                                    @method('PUT')
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="employee_id" class="form-label">Employee</label>
                                                        <select name="employee_id" id="employee_id" class="form-control disabled">
                                                            @foreach ($employees as $employee)
                                                               <option value="{{ $employee->id }}"
                                                                            {{ old('project_id', $data->project_id) == $employee->id ? 'selected' : '' }}>
                                                                            {{ $employee->fullname }}
                                                                        </option>
                                                            @endforeach
                                                        </select>
                                                        @error('employee_id')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="amount" class="form-label">Amount</label>
                                                        <input type="text" name="amount"
                                                            class="form-control @error('amount') is-invalid @enderror"
                                                            id="amount" value="{{ old('amount', $salary->amount) }}">
                                                        @error('amount')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="payment_date" class="form-label">Payment Date</label>
                                                        <input type="date" name="payment_date"
                                                            class="form-control @error('payment_date') is-invalid @enderror"
                                                            id="payment_date"
                                                            value="{{ old('payment_date', $salary->payment_date) }}">
                                                        @error('payment_date')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Delete -->
                                <div class="modal fade" id="deleteSalariesModal{{ $salary->id }}" tabindex="-1"
                                    aria-labelledby="deleteSalariesModalLabel{{ $salary->id }}" aria-hidden="true"
                                    data-bs-backdrop="static">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteSalariesModalLabel{{ $salary->id }}">
                                                    Confirm Delete</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete this record? This action cannot be
                                                    undone.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <form action="{{ route('salaries.destroy', $salary->id) }}"
                                                    method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <img src="{{ asset('assets/images/no-data.png') }}" alt="No Data"
                                            class="img-fluid" style="width: clamp(150px, 50vw, 300px);">
                                        <p class="mt-3">No data available.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Links -->
                <div class="mt-3 justify-content-end">
                    {{ $salaries->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="createSalariesModal" tabindex="-1" aria-labelledby="createSalariesModalLabel"
        aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createSalariesModalLabel">Create Salary</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('salaries.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="employee_id" class="form-label">Employee</label>
                            <select name="employee_id" id="employee_id" class="form-control">
                                @foreach ($employees $employee)
                                    <option value="{{ $employee->id }}">
                                        {{ $employee->fullname }}
                                    </option>
                                @endforeach
                            </select>
                            @error('employee_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="text" name="amount"
                                class="form-control @error('amount') is-invalid @enderror" id="amount"
                                value="{{ old('amount') }}">
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="payment_date" class="form-label">Payment Date</label>
                            <input type="date" name="payment_date"
                                class="form-control @error('payment_date') is-invalid @enderror" id="payment_date"
                                value="{{ old('payment_date') }}">
                            @error('payment_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection --}}
