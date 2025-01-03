@include('header')
<div class="container">
    <h1>Edit Notes</h1>

    <!-- Display validation errors -->
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    <form action="/editnotes/{{$notes->id_notes}}" method="POST">
        @csrf


        <input type="hidden" name="id_notes" value="{{ $notes->id_notes }}">

        <!-- notes Title Input -->
        <div class="form-group">
            <label for="notes">notes</label>
            <input type="text" name="notes" id="notes" class="form-control" value="{{ old('notes', $notes->notes) }}" required>
        </div>


        


        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update Notes</button>
        </div>
    </form>
</div>