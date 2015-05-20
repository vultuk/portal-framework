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