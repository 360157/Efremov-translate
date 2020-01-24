<div id="langCountryModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Select counties</h4>
                <button class="close" type="button" data-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <select name="country" class="form-control" multiple="multiple">
                    <option value="*">Other</option>
                    @foreach($countries as $code => $name)
                        <option value="{{ $code }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button type="submit" class="btn btn-primary" name="add"><i class="icon-plus-circle2"></i> @lang('main.add')</button>
                    <button type="button" class="btn btn-danger" name="cancel"><i class="icon-cancel-circle2"></i> @lang('main.cancel')</button>
                </div>
            </div>
        </div>
    </div>
</div>