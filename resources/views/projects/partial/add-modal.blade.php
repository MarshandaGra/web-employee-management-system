<!-- Modal Create -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Buat Proyek</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('projects.store') }}" method="POST">
                    @method('POST')
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama proyek</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            id="name" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Harga</label>
                        <input type="numeric" name="price" class="form-control @error('price') is-invalid @enderror"
                            id="price" value="{{ old('price') }}">
                        @error('price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <input type="text" name="description"
                            class="form-control @error('description') is-invalid @enderror" id="description"
                            value="{{ old('description') }}">
                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    {{-- <div class="mb-3">
                        <label for="department_id" class="form-label">Departemen</label>
                        <select name="department_id" class="form-control @error('department_id') is-invalid @enderror" id="department_id">
                            <option value="">Pilih Departemen</option>
                            @forelse ($departments as $department)
                                <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @empty
                                <option disabled>Tidak ada departemen.</option>
                            @endforelse
                        </select>
                        @error('department_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div> --}}
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Ditugaskan kepada</label> <br>
                        <select class="js-example-basic-multiple form-control w-100" name="employee_id[]"
                            multiple="multiple">
                            {{-- @forelse ($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            @empty
                                <option disabled>Tidak ada karyawan.</option>
                            @endforelse --}}
                            @forelse ($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            @empty
                                <option disabled>Tidak ada karyawan.</option>
                            @endforelse
                        </select>
                        @error('employee_id[]')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" name="start_date"
                            class="form-control @error('start_date') is-invalid @enderror" id="start_date"
                            value="{{ old('start_date') }}">
                        @error('start_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Tanggal Selesai</label>
                        <input type="date" name="end_date"
                            class="form-control @error('end_date') is-invalid @enderror" id="end_date"
                            value="{{ old('end_date') }}">
                        @error('end_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2({
            placeholder: "Pilih Karyawan", // Placeholder text
            allowClear: true, // Enable the clear button
            width: '100%' // Use the full width of the select element
        });
    });
</script>

<style>
    /* Adjust Select2 container and dropdown styles */
    .select2-container--default .select2-selection--multiple {
        background-color: #fff !important;
        ;
        /* Ensure solid background */
        border: 1px solid #ccc !important;
        ;
        /* Match border style */
    }

    /* Ensure options are clearly visible */
    .select2-container--default .select2-results>.select2-results__options {
        background-color: #fff !important;
        ;
        /* Solid background for options */
    }

    /* Highlighted option styling */
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #bcb9b9 !important;
        ;
        /* Lighter background on hover */
    }

    .select2-container--default .select2-dropdown {
        z-index: 9999;
        /* Pastikan dropdown berada di atas elemen lain */
    }
</style>
