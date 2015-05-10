@extends($theme . 'pages.singlepage')

@section('title', 'View Companies')

@section('content')

    <div class="row">

        <div class="col-md-9">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Heading1</th>
                        <th>Heading1</th>
                        <th>Heading1</th>
                        <th>Heading1</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4">One</td>
                    </tr>
                    <tr>
                        <td colspan="4">Two</td>
                    </tr>
                    <tr>
                        <td colspan="4">Free</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-3">
            @if (count($company->activity) > 0)
                @foreach ($company->activity as $activity)
                    @include($pages . 'activity.partials.' . $activity->activity_name)
                @endforeach
            @else
                No Activity
            @endif
        </div>

    </div>

@stop
