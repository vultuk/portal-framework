@extends($theme . 'pages.singlepage')

@section('title', 'Sales Report for ' . count($statistics) . ' Users')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <canvas id="combinedStatistics" width="100%" height="400"></canvas>
            <script>
                $(function() {
                    var combinedStatistics = document.getElementById("combinedStatistics").getContext("2d");
                    $('#combinedStatistics').attr({
                        "width": $('#combinedStatistics').parent().width()
                    });
                    var combinedStatisticsLine = new Chart(combinedStatistics).Line({
                        labels: {!! json_encode($possibleDates) !!},
                        datasets: [
                            @foreach($statistics as $userResult)
                            {
                                label: "{{ $userResult['user']['firstName'] }} {{ $userResult['user']['lastName'] }}",
                                data: [
                                    @foreach ($possibleDates as $date)
                                    {{ isset($userResult['scriptStatistics'][$date]) ? $userResult['scriptStatistics'][$date] : 0 }},
                                    @endforeach
                                ],
                                strokeColor: "rgba({{ $userResult['color']['r'] }}, {{ $userResult['color']['g'] }}, {{ $userResult['color']['b'] }}, 1)",
                                pointColor: "rgba({{ $userResult['color']['r'] }}, {{ $userResult['color']['g'] }}, {{ $userResult['color']['b'] }}, 1)",
                                fillColor: "rgba({{ $userResult['color']['r'] }}, {{ $userResult['color']['g'] }}, {{ $userResult['color']['b'] }}, 0.2)",
                            },
                            @endforeach
                        ]
                    }, {});
                });
            </script>
        </div>
    </div>

@stop