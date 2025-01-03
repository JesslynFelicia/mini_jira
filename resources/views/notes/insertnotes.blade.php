@include('header')
@include('form')

    <div class="container">
       <h1>Insert Notes</h1>
        <!-- Show any error or success messages -->
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Issue form -->
        <form action="{{ url('/insertnotes') }}" method="POST" enctype="multipart/form-data">
            @csrf
       
            <!-- Notes -->
            <div class="form-group">
                <label for="notes">Notes:</label>
                <textarea id="notes" name="notes" class="form-control"></textarea>
            </div>

         
            
           
            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Add Notes</button>
        </form>
    </div>

