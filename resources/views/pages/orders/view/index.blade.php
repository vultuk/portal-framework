@extends($theme . 'pages.singlepage')

@section('title', trans($lang . 'orders.view.index.heading'))

@section('content')

    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">{{ trans($lang . 'orders.view.index.panels.orders.title') }}</h3>
            </div>

            <table class="table table-striped">
                <tr>
                    <th>{{ trans($lang . 'orders.view.index.tables.orders.product') }}</th>
                    <th>{{ trans($lang . 'orders.view.index.tables.orders.value') }}</th>
                    <th>{{ trans($lang . 'orders.view.index.tables.orders.status') }}</th>
                    <th>{{ trans($lang . 'orders.view.index.tables.orders.created') }}</th>
                    <th>{{ trans($lang . 'orders.view.index.tables.orders.completion') }}</th>
                    <th></th>
                </tr>
                @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->product->name }}<br /><i>{{ !is_null($order->description) ? $order->description : 'No description Given!' }}</i></td>
                    <td>£{{ number_format($order->price, 2) }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->created_at->diffForHumans() }}</td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar @if (!is_null($order->completed_at))progress-bar-success @else  progress-bar-striped active {{ $order->estimated_completion_time <= 2 ? 'progress-bar-warning' : 'progress-bar-info' }} @endif" role="progressbar" aria-valuenow="{{ ceil($order->completion_percentage) }}" aria-valuemin="90" aria-valuemax="100" style="width: {{ ceil($order->completion_percentage) }}%;">
                                @if (!is_null($order->completed_at))
                                    Order Completed {{ $order->completed_at->diffForHumans() }}
                                @else
                                    Estimated Completion in {{ is_null($order->estimated_completion_time) ? 'Unknown' : $order->estimated_completion_time }} days
                                @endif
                            </div>
                        </div>
                    </td>
                    <td></td>
                </tr>
                @endforeach
            </table>

        </div>
    </div>

@stop
