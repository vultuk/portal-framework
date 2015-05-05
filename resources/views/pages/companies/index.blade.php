@extends($theme . 'pages.singlepage')

@section('title', 'View Companies')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">List of all Companies</div>

                <table class="table">
                    @foreach ($companies as $company)
                    <tr>
                        <td valign="middle"></td>
                        <td valign="middle">{{ $company->name }}</td>
                        <td valign="middle">
                            <div class="btn-group" role="group">
                                <a href="/company/view/{{ $company->slug }}" class="btn btn-default" aria-label="Left Align">
                                    <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
                                </a>
                                <a href="/company/edit/{{ $company->slug }}" class="btn btn-default" aria-label="Left Align">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                </a>
                                <a href="/company/delete/{{ $company->slug }}" class="btn btn-default" aria-label="Left Align">
                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                </table>
            </div>
        </div>
    </div>

@stop
