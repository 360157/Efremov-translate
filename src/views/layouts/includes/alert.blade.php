<section class="page-content">
    @foreach(['success', 'error'] as $type)
        @if (Session::has($type))
            <div class="alert alert-{{ $type !== 'error' ? $type : 'danger' }}" role="alert">
                {!! Session::get($type) !!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
        @endif
    @endforeach
</section>