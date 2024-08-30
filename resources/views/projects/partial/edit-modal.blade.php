<!-- Modal Edit -->
<div class="modal fade" id="editModal{{ $project->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $project->id }}"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{ $project->id }}">Edit
                    project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('projects.update', $project->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama projects</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            id="name" value="{{ old('name', $project->name) }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <input type="text" name="description"
                            class="form-control @error('description') is-invalid @enderror" id="description"
                            value="{{ old('description', $project->description) }}">
                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    @php
                        $selectedStates = old('states', $project->states ?? []); // Mengambil nilai dari database atau input lama
                    @endphp
                    <div class="mb-3">
                        <label for="assigned_to" class="form-label">Ditugaskan kepada</label> <br>
                        <select class="js-example-basic-multiple form-control w-100" name="states[]" multiple="multiple">
                            <option value="AL" {{ in_array('AL', $selectedStates) ? 'selected' : '' }}>Alabama</option>
                            <option value="AK" {{ in_array('AK', $selectedStates) ? 'selected' : '' }}>Alaska</option>
                            <option value="AZ" {{ in_array('AZ', $selectedStates) ? 'selected' : '' }}>Arizona</option>
                            <option value="AR" {{ in_array('AR', $selectedStates) ? 'selected' : '' }}>Arkansas</option>
                            <!-- Tambahkan opsi lainnya -->
                        </select>
                        
                        @error('end_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" name="start_date"
                            class="form-control @error('start_date') is-invalid @enderror" id="start_date"
                            value="{{ old('start_date', $project->start_date) }}">
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
                            value="{{ old('end_date', $project->end_date) }}">
                        @error('end_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // $(document).ready(function() {
    //     $('.js-example-basic-multiple').select2({
    //         placeholder: "Pilih State", // Placeholder text
    //         allowClear: true, // Enable the clear button
    //         width: '100%' // Use the full width of the select element
    //     });
    // });

    $(document).ready(function() {
        $('#editModal{{ $project->id }}').on('shown.bs.modal', function () {
            $('.js-example-basic-multiple').select2({
                placeholder: "Pilih State",
                allowClear: true,
                width: '100%'
            });
        });
    });
</script>

<style>
    /* Adjust Select2 container and dropdown styles */
    .select2-container--default .select2-selection--multiple {
        background-color: #fff !important;; /* Ensure solid background */
        border: 1px solid #ccc !important;; /* Match border style */
    }

    /* Ensure options are clearly visible */
    .select2-container--default .select2-results>.select2-results__options {
        background-color: #fff !important;; /* Solid background for options */
    }

    /* Highlighted option styling */
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #bcb9b9 !important;; /* Lighter background on hover */
    }
    .select2-container--default .select2-dropdown {
    z-index: 9999; /* Pastikan dropdown berada di atas elemen lain */
}
</style>