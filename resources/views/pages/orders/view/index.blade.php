@extends($theme . 'pages.singlepage')

@section('title', trans($lang . 'orders.view.index.heading'))

@section('content')

    <div class="col-md-12">
        @include($pages . 'orders.partials.ordertable')
    </div>

@stop
