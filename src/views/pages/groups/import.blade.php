<div id="groupImportModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="groupImportForm" action="{{ route('translate.groups.parse') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="POST" />
                <input type="hidden" name="type" value="{{ $type }}" />
                <div class="modal-header">
                    <h4 class="modal-title">Import groups to @lang($type)</h4>
                    <button class="close" type="button" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="scroll">
                        <table class="table">
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" id="parseGroup" name="status"><i class="icon-floppy-disk"></i> @lang('main.parse')</button>
                        <button type="button" class="btn btn-danger" name="cancel"><i class="icon-cancel-circle2"></i> @lang('main.cancel')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>