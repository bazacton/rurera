@foreach (['success', 'error', 'warning', 'info'] as $msg)
	@if(session()->has($msg))
		<div class="rurera-flash-msg alert alert-{{ $msg }} alert-dismissible fade show mb-20" role="alert">
			{{ session()->get($msg) }}
			<button type="button" class="alert-btn-close" data-bs-dismiss="alert" aria-label="Close">&#x2715;</button>
		</div>
	@endif
@endforeach