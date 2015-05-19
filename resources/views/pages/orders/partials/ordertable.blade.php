<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">{{ trans($lang . 'orders.partials.ordertable.heading') }}</h3>
    </div>

    <table class="table table-striped">
        <tr>
            <th>{{ trans($lang . 'orders.partials.ordertable.table.product') }}</th>
            <th>{{ trans($lang . 'orders.partials.ordertable.table.value') }}</th>
            <th>{{ trans($lang . 'orders.partials.ordertable.table.status') }}</th>
            <th>{{ trans($lang . 'orders.partials.ordertable.table.created') }}</th>
            <th>{{ trans($lang . 'orders.partials.ordertable.table.completion') }}</th>
            <th></th>
        </tr>
        @foreach ($orders as $order)
        <tr>
            <td>{{ $order->product->name }}<br /><i>{{ !is_null($order->description) ? $order->description : "No Description Given" }}</i></td>
            <td>£{{ number_format($order->price, 2) }}</td>
            <td>{{ $order->status }}</td>
            <td><span data-toggle="tooltip" data-placement="top" title="{{ $order->created_at->format("d/m/Y") }}">{{ $order->created_at->diffForHumans() }}</span></td>
            <td align="center">

                @if (!is_null($order->estimated_completion_time))
                <div class="progress">
                    <div class="progress-bar @if (!is_null($order->completed_at))progress-bar-success @else  progress-bar-striped active {{ $order->estimated_completion_time <= 2 ? 'progress-bar-danger' : 'progress-bar-warning' }} @endif" role="progressbar" aria-valuenow="{{ ceil($order->completion_percentage) }}" aria-valuemin="90" aria-valuemax="100" style="min-width: 30%; width: {{ ceil($order->completion_percentage) }}%;">
                        @if (!is_null($order->completed_at))
                            Order Completed <span data-toggle="tooltip" data-placement="top" title="{{ $order->completed_at->format("d/m/Y") }}">{{ $order->completed_at->diffForHumans() }}</span>
                        @else
                            {{ is_null($order->estimated_completion_time) ? 'Unknown' : $order->estimated_completion_time }} days remaining
                        @endif
                    </div>
                </div>
                @else
                    <div class="progress">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                            We have sent <b>{{ number_format($order->details->supplied,0) }}</b> leads for this product.
                        </div>
                    </div>

                @endif
            </td>
            <td></td>
        </tr>
        @endforeach
    </table>
</div>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
