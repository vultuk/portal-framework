@extends($theme . 'pages.singlepage')

@section('title', 'Sales Report By User')

@section('content')

    <p class="bg-danger">
    @foreach ($errors->all() as $error)
        <p class="error">{{ $error }}</p>
    @endforeach
    </p>

    {!! Form::open(['url' => '/users/reports/sales/view']) !!}

        <div class="form-group">
            <label>Single or Multiple Users</label>
            <select name="user_id[]" class="form-control" size="5" multiple>
                @foreach($userList as $user)
                <option value="{{ $user['id'] }}">{{ $user['firstName'] }} {{ $user['lastName'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Start Date</label>
            <input name="start_date" class="form-control" placeholder="Report Start Date" type="date"><br>
        </div>
        <div class="form-group">
            <label>End Date</label>
            <input name="end_date" class="form-control" placeholder="Report End Date" type="date"><br>
        </div>

        <button type="submit" class="btn btn-default">Submit</button>

    {!! Form::close() !!}

@stop