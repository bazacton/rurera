@extends('admin.layouts.app')

@push('styles_top')
    <link href="/assets/default/vendors/sortable/jquery-ui.min.css"/>
    <link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
@endpush


@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Add Sections</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="/admin/questions_bank/store_sections_auto"
                                  method="Post">
                                {{ csrf_field() }}

								<div class="form-group">
                                    <label>Subject</label>
                                    <select class="form-control @error('webinar_id') is-invalid @enderror" name="webinar_id">
                                        <option {{ !empty($trend) ? '' : 'selected' }} disabled>Select a Subject</option>

                                        @foreach($webinars as $webinar)
                                            <option value="{{ $webinar->id }}" class="font-weight-bold" >{{ $webinar->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('webinar_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label class="input-label">List Each per line</label>
									<div class="col-12 col-md-12 col-lg-12">
                                    <textarea class="note-codable" style="width:100%;" rows="20" id="chapters_list" name="chapters_list" aria-multiline="true"></textarea>
									</div>
                                </div>
								@if($success == 'yes')
								<div class="text-left mt-4">
                                    Created Successfully
                                </div>
								@endif
                                <div class="text-right mt-4">
								
                                    <button class="btn btn-primary">{{ trans('admin/main.submit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/sortable/jquery-ui.min.js"></script>
    <script src="/assets/default/js/admin/filters.min.js"></script>
    <script src="/assets/vendors/summernote/summernote-bs4.min.js"></script>
@endpush
