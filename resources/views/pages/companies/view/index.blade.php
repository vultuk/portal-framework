@extends($theme . 'pages.singlepage')

@section('title', $company->name)

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <div class="col-sm-4">
                    <span class="thumbnail">
                        <img src="{{ $company->logo }}" alt="{{ $company->name }}">
                    </span>
                </div>
                <div class="col-sm-8">Other Content</div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-sm-offset-6 text-right">
                    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#update-address-modal">
                        {{ trans($lang . 'companies.view.addaddress') }} <i class="glyphicon glyphicon-plus-sign"></i>
                    </a>
                </div>
            </div>
            @forelse($company->addresses as $index => $address)
                @if($index==0 || $index%4 == 0)
                    <div class="row">
                        @endif
                        <div class="col-sm-3 address-entire">
                            <h3>
                                {{ $address->description }} {{ $address->is_primary?'*':'' }}
                                <span class="pull-right fade">
                                <a href="#" class="edit-address" data-toggle="modal"
                                   data-target="#update-address-modal"><i class="glyphicon glyphicon-edit"></i></a>
                            </span>
                            </h3>
                            <address class="well" style="height:160px">
                                {!! implode("<br>", array_filter([sprintf('<strong>%s</strong>', $company->name),
                                $address->address1,
                                $address->address2,
                                $address->town_city,
                                $address->county,
                                $address->postal_code])) !!}
                            </address>
                        </div>
                        @if($index%4 == 4|| end($company->addresses))
                    </div>
                @endif
            @empty
                <div class="row">
                    <div class="text-center">
                        <p>
                            {{ trans($lang . 'companies.view.noaddress') }}
                            <a href="#" data-toggle="modal" data-target="#update-address-modal">{{ trans($lang . 'companies.view.addaddress')}}</a>
                        </p>
                    </div>
                </div>
            @endforelse
            <div class="row">
                @include($pages . 'orders.partials.ordertable', ['orders' => $company->orders])
            </div>
        </div>
        <div class="col-md-3">
            @forelse($company->activity as $activity)
                @include($pages . 'activity.partials.' . $activity->activity_name)
            @empty
                <p>No Activity</p>
            @endforelse
        </div>

    </div>

    <div id="update-address-modal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Address</h4>
                </div>
                <form action="" method="post" id="address-form">
                    <input type="hidden" name="_method" value="put" id="method-input">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="" id="id-input"/>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-8 form-group">
                                <input type="text" name="description" class="form-control" placeholder="{{ trans($lang . 'companies.modals.address.fields.description') }}">
                            </div>
                            <div class="col-sm-4 form-group checkbox">
                                <div class="form-group">
                                <label>
                                    <input type="checkbox" name="primary">
                                    {{ trans($lang . 'companies.modals.address.fields.primary') }}
                                </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <input type="text" name="address1" placeholder="{{ trans($lang . 'companies.modals.address.fields.address1') }}" class="form-control">
                            </div>
                            <div class="col-sm-6 form-group">
                                <input type="text" name="address2" placeholder="{{ trans($lang . 'companies.modals.address.fields.address2') }}" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 form-group">
                                <input type="text" name="town" placeholder="{{ trans($lang . 'companies.modals.address.fields.town') }}" class="form-control">
                            </div>
                            <div class="col-sm-4 form-group">
                                <input type="text" name="county" placeholder="{{ trans($lang . 'companies.modals.address.fields.county') }}" class="form-control">
                            </div>
                            <div class="col-sm-4 form-group">
                                <input type="text" name="postal_code" placeholder="{{ trans($lang . 'companies.modals.address.fields.postalcode') }}" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <select name="country" class="form-control">
                                    @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans($lang . 'companies.modals.address.actions.dismiss')  }}</button>
                        <button type="submit" class="btn btn-primary">{{ trans($lang . 'companies.modals.address.actions.submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(function () {
            $(document).on('mouseenter', '.address-entire', function (e) {
                $(this).find('span.pull-right').addClass('in');
            }).on('mouseleave', '.address-entire', function (e) {
                $(this).find('span.pull-right').removeClass('in');
            }).on('click', '.edit-address', function (e) {
                e.preventDefault();
                $('#update-address-modal').modal('show')
            });

            $('#address-form').on('submit', function(e){
                e.preventDefault();
                $('#method-input').val('post');
                $.post('/company/address/{{ $company->slug }}', $(this).serialize(), function(data){
                    console.log(data);
                });
            });
        });
    </script>
@stop
