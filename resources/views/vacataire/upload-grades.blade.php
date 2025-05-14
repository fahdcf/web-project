<x-coordonnateur_layout>
    <div class="container py-4">
        <h2>Upload Grades for {{ $module->name }}</h2>

        <form action="{{ route('vacataire.grades.store', $module->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="session" class="form-label">Select Session</label>
                <select name="session" id="session" class="form-select" required>
                    <option value="normale">Session Normale</option>
                    <option value="rattrapage">Session Rattrapage</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="gradeFile" class="form-label">Upload Grade File (CSV)</label>
                <input type="file" name="gradeFile" id="gradeFile" class="form-control" accept=".csv" required>
                <small class="text-muted">Please upload a CSV file with the grades.</small>
            </div>

            <button type="submit" class="btn btn-primary">Upload</button>
        </form>

        @if (session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</x-coordonnateur_layout>
