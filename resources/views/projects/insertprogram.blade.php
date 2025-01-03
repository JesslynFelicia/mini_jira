@include('header')
<div class = "container">
<h1>INSERT PROJECT</h1>
<form action=insertproject method="POST">
    @csrf <!-- This is necessary for CSRF protection in Laravel -->
    
    <!-- dd{{$curruser}} -->
    <label for="project_title">Project Title:</label>
    <input type="text" id="project_title" name="project_title" required> <br>

    <!-- <label for="project_title">PIC : </label>
    <input type="text" id="pic" name="pic" value ="{{$curruser->name}}"> <br> -->

    <label for="project_title">Owner : </label>
    <input type="text" id="owner" name="owner" value ="{{$curruser->name}}" disabled>

    <div class="form-group">
            <label for="pic">PIC:</label>
            <select id="pic" name="pic" class="form-control">
                @foreach ($users as $user)
                <option value="{{ $user->name }}">{{ $user->name }}</option>
                @endforeach
            </select>
         
        </div>

        <label for="due_date">Due date:</label>
        <input type="date" id="date" name="due_date"> <br>

    <!-- hidden -->
    <input type="hidden" id="owner" name="owner" value ="{{$curruser->name}}">
    <input type="hidden" id="curruser" name="curruser" value ="{{$curruser->id}}">
    <button type="submit">Submit</button>
</form>

</div>
