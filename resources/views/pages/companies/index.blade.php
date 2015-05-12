@extends($theme . 'pages.singlepage')

@section('title', trans( $lang . 'companies.index.heading'))

@section('content')
    <div class="row">
        <div class="col-xs-6 col-xs-offset-6 text-right">
            <div class="btn-group">
                <button class="btn btn-primary" data-toggle="modal"
                        data-target="#create-company-modal">{{ trans( $lang . 'companies.index.createButton') }}</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans( $lang . 'companies.index.panels.companies.heading') }}</div>

                <table class="table">
                    @foreach ($companies as $company)
                        <tr>
                            <td valign="middle"></td>
                            <td valign="middle">{{ $company->name }}</td>
                            <td valign="middle">
                                <div class="btn-group" role="group">
                                    <a href="/company/view/{{ $company->slug }}" class="btn btn-default"
                                       aria-label="Left Align">
                                        <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
                                    </a>
                                    <a href="/company/edit/{{ $company->slug }}" class="btn btn-default"
                                       aria-label="Left Align">
                                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                    </a>
                                    <a href="/company/delete/{{ $company->slug }}" class="btn btn-default"
                                       aria-label="Left Align">
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

    <div id="create-company-modal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ trans('portal::companies.index.modals.create.title') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control"
                               placeholder="{{ trans('portal::companies.index.modals.create.fields.name') }}">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control"
                               placeholder="{{ trans('portal::companies.index.modals.create.fields.name') }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal">{{ trans('portal::companies.index.modals.create.actions.dismiss') }}</button>
                    <button type="button"
                            class="btn btn-primary">{{ trans('portal::companies.index.modals.create.actions.submit') }}</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div><!-- /.modal -->

@stop
