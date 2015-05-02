@extends($theme . 'pages.singlepage')

@section('title', 'View Companies')

@section('content')

    <div class="row">

        <div class="col-md-9">

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
