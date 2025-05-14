<!-- assign.blade.php -->
<form action="{{ route('coordinator.assign.store', $module) }}" method="POST">
    @csrf
    <select name="professor_id">
        @foreach($professeurs as $prof)
            <option value="{{ $prof->id }}">{{ $prof->name }}</option>
        @endforeach
    </select>
    <button>Valider</button>
</form>