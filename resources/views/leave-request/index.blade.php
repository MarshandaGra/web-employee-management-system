@extends('dashboard.layouts.main')

@section('content')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="container py-2">
                <h1 class="h3">Permintaan Cuti</h1>

                <div class="d-flex justify-content-between mb-3 mt-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                        Tambah Data
                    </button>

                    <form id="searchForm" action="{{ route('leave.index') }}" method="GET"
                        class="d-flex align-items-center gap-2">
                        @csrf
                        <div class="form-group mb-0 position-relative">
                            <label class="sr-only">Filter Status:</label>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="statusDropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Filter Status
                                </button>
                                <ul class="dropdown-menu p-3" aria-labelledby="statusDropdown">
                                    <li>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="status[]" value="pending"
                                                id="statusPending"
                                                {{ in_array('pending', request('status', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="statusPending">Pending</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="status[]" value="approved"
                                                id="statusApproved"
                                                {{ in_array('approved', request('status', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="statusApproved">Approved</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="status[]" value="rejected"
                                                id="statusRejected"
                                                {{ in_array('rejected', request('status', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="statusRejected">Rejected</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="form-group mb-0 position-relative">
                            <label for="search" class="sr-only">Search:</label>
                            <input type="text" id="search" placeholder="Cari data..." name="search"
                                value="{{ request('search') }}" class="form-control rounded shadow search-input">
                            <a href="{{ route('leave.index') }}"
                                class="clear-search btn btn-sm position-absolute top-50 translate-middle-y end-0 me-2"
                                style="z-index: 10; padding: 0.2rem 0.4rem; line-height: 1; display: none;">
                                X
                            </a>
                        </div>
                    </form>
                </div>

                <div class="mt-3">
                    <table class="table border text-nowrap customize-table mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>
                                    <a
                                        href="{{ route('leave.index', array_merge(request()->query(), ['sortBy' => 'employee_id', 'sortDirection' => request('sortDirection') === 'asc' ? 'desc' : 'asc'])) }}">
                                        Employee ID
                                        @if (request('sortBy') === 'employee_id')
                                            @if (request('sortDirection') === 'asc')
                                                &#9650; <!-- Unicode character for upward arrow -->
                                            @else
                                                &#9660; <!-- Unicode character for downward arrow -->
                                            @endif
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a
                                        href="{{ route('leave.index', array_merge(request()->query(), ['sortBy' => 'start_date', 'sortDirection' => request('sortDirection') === 'asc' ? 'desc' : 'asc'])) }}">
                                        Mulai Ijin
                                        @if (request('sortBy') === 'start_date')
                                            @if (request('sortDirection') === 'asc')
                                                &#9650; <!-- Unicode character for upward arrow -->
                                            @else
                                                &#9660; <!-- Unicode character for downward arrow -->
                                            @endif
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a
                                        href="{{ route('leave.index', array_merge(request()->query(), ['sortBy' => 'end_date', 'sortDirection' => request('sortDirection') === 'asc' ? 'desc' : 'asc'])) }}">
                                        Sampai Tanggal
                                        @if (request('sortBy') === 'end_date')
                                            @if (request('sortDirection') === 'asc')
                                                &#9650; <!-- Unicode character for upward arrow -->
                                            @else
                                                &#9660; <!-- Unicode character for downward arrow -->
                                            @endif
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a
                                        href="{{ route('leave.index', array_merge(request()->query(), ['sortBy' => 'type', 'sortDirection' => request('sortDirection') === 'asc' ? 'desc' : 'asc'])) }}">
                                        Type
                                        @if (request('sortBy') === 'type')
                                            @if (request('sortDirection') === 'asc')
                                                &#9650; <!-- Unicode character for upward arrow -->
                                            @else
                                                &#9660; <!-- Unicode character for downward arrow -->
                                            @endif
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a
                                        href="{{ route('leave.index', array_merge(request()->query(), ['sortBy' => 'status', 'sortDirection' => request('sortDirection') === 'asc' ? 'desc' : 'asc'])) }}">
                                        Status
                                        @if (request('sortBy') === 'status')
                                            @if (request('sortDirection') === 'asc')
                                                &#9650; <!-- Unicode character for upward arrow -->
                                            @else
                                                &#9660; <!-- Unicode character for downward arrow -->
                                            @endif
                                        @endif
                                    </a>
                                </th>
                                <th class="text-center">Action</th>
                            </tr>

                        </thead>

                        <tbody>
                            @forelse($leaveRequest as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->employee_id }}</td>
                                    <td>{{ $data->start_date }}</td>
                                    <td>{{ $data->end_date }}</td>
                                    <td>{{ $data->type }}</td>
                                    <td>{{ ucfirst($data->status) }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $data->id }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('leave.destroy', $data->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this item?');">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal Delete -->
                                <div class="modal fade" id="deleteSalariesModal{{ $data->id }}" tabindex="-1"
                                    aria-labelledby="deleteSalariesModalLabel{{ $data->id }}" aria-hidden="true"
                                    data-bs-backdrop="static">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteSalariesModalLabel{{ $data->id }}">
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
                                                <form action="{{ route('salaries.destroy', $data->id) }}" method="POST">
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
                                    <td colspan="7" class="text-center">
                                        <img src="{{ asset('assets/images/no-data.png') }}" alt="No Data"
                                            class="img-fluid" style="width: clamp(150px, 50vw, 300px);">
                                        <p class="mt-3">No data available.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-3 justify-content-end">
                        {{ $leaveRequest->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Data -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('leave.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Tambah Permintaan Cuti
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="employee_id" class="form-label">Employee ID</label>
                            <input type="text" class="form-control @error('employee_id') is-invalid @enderror"
                                id="employee_id" name="employee_id" value="{{ old('employee_id') }}">
                            @error('employee_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Mulai Ijin</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                id="start_date" name="start_date" value="{{ old('start_date') }}">
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="end_date" class="form-label">Sampai
                                Tanggal</label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                id="end_date" name="end_date" value="{{ old('end_date') }}">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Type</label>
                            <input type="text" class="form-control @error('type') is-invalid @enderror" id="type"
                                name="type" value="{{ old('type') }}">
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status"
                                name="status">
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
