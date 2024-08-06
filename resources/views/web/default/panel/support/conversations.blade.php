@extends(getTemplate() .'.panel.layouts.panel_layout')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
@endpush

@section('content')
    <section>
        <h2 class="section-title font-24">{{ trans('panel.support_summary') }}</h2>

        <div class="activities-container mt-30 p-20 p-lg-35">
            <div class="row">
                <div class="col-4 d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column align-items-center text-center bg-white py-20 panel-shadow rounded-sm w-100">
                        <img src="/assets/default/img/activity/41.svg" width="64" height="64" alt="">
                        <strong class="font-24 mt-5">{{ $openSupportsCount }}</strong>
                        <span class="font-16 text-gray font-weight-500">{{ trans('panel.open_conversations') }}</span>
                    </div>
                </div>

                <div class="col-4 d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column align-items-center text-center bg-white py-20 panel-shadow rounded-sm w-100">
                        <img src="/assets/default/img/activity/40.svg" width="64" height="64" alt="">
                        <strong class="font-24 mt-5">{{ $closeSupportsCount }}</strong>
                        <span class="font-16 text-gray font-weight-500">{{ trans('panel.closed_conversations') }}</span>
                    </div>
                </div>

                <div class="col-4 d-flex align-items-center justify-content-center">
                    <div class="d-flex flex-column align-items-center text-center bg-white py-20 panel-shadow rounded-sm w-100">
                        <img src="/assets/default/img/activity/39.svg" width="64" height="64" alt="">
                        <strong class="font-24 mt-5">{{ $supportsCount }}</strong>
                        <span class="font-16 text-gray font-weight-500">{{ trans('panel.total_conversations') }}</span>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <section class="mt-40">
        <h2 class="section-title font-24">{{ trans('panel.messages_history') }}</h2>

        @if(!empty($supports) and !$supports->isEmpty())

            <div class="bg-white shadow rounded-sm py-10 py-lg-25 px-15 px-lg-15 mt-25">
                <div class="row">
                    <div id="conversationsList" class="col-12 col-lg-5 conversations-list">
                        <div class="table-responsive">
                            <table class="table table-md">
                                <tr>
                                    <th class="text-left text-gray font-16 font-weight-500">{{ trans('navbar.contact') }}</th>
                                    <th class="text-left text-gray font-16 font-weight-500">{{ trans('public.title') }}</th>
                                    <th class="text-center text-gray font-16 font-weight-500">{{ trans('public.status') }}</th>
                                </tr>
                                <tbody>

                                @foreach($supports as $support)
                                    <tr class="@if(!empty($selectSupport) and $selectSupport->id == $support->id) selected-row @endif">
                                        <td class="text-left">
                                            <a href="/panel/support/{{ $support->id }}/conversations" class="">
                                                <div class="user-inline-avatar d-flex align-items-center">
                                                    <div class="avatar bg-gray200">
                                                        <img src="{{ (!empty($support->webinar) and $support->webinar->teacher_id != $authUser->id) ? $support->webinar->teacher->getAvatar() : $support->user->getAvatar() }}" class="img-cover" alt="">
                                                    </div>
                                                    <div class="ml-10">
                                                        <span class="d-block font-16 text-dark-blue font-weight-500">{{ (!empty($support->webinar) and $support->webinar->teacher_id != $authUser->id) ? $support->webinar->teacher->get_full_name() : $support->user->get_full_name() }}</span>
                                                        <span class="mt-1 font-12 text-gray d-block">
                                                            {{ (!empty($support->webinar) and $support->webinar->teacher_id != $authUser->id) ? trans('panel.teacher') : ( ($support->user->isUser()) ? trans('quiz.student') : trans('panel.staff')) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </a>
                                        </td>

                                        <td class="text-left">
                                            @if($authUser->isUser())
                                                <a href="/panel/support/{{ $support->id }}/conversations" class="">
                                                    <span class="font-weight-500 font-16 text-dark-blue d-block">{{ $support->title }}</span>
                                                    <span class="mt-1 font-12 text-gray d-block">{{ truncate((!empty($support->webinar)) ? $support->webinar->title : '', 20) }} | {{ (!empty($support->conversations) and count($support->conversations)) ? dateTimeFormat($support->conversations->first()->created_at,'j M Y | H:i') : dateTimeFormat($support->created_at,'j M Y | H:i') }}</span>
                                                </a>
                                            @else
                                                <a href="/panel/support/{{ $support->id }}/conversations" class="">
                                                    <span class="font-weight-500 font-16 text-dark-blue d-block">{{ $support->title }}</span>
                                                    <span class="mt-1 font-12 text-gray d-block">{{ (!empty($support->conversations) and count($support->conversations)) ? dateTimeFormat($support->conversations->first()->created_at,'j M Y | H:i') : dateTimeFormat($support->created_at,'j M Y | H:i') }}</span>
                                                </a>
                                            @endif
                                        </td>

                                        <td class="text-center align-middle">
                                            @if($support->status == 'close')
                                                <span class="text-danger font-weight-500 font-16">{{  trans('panel.closed') }}</span>
                                            @elseif($support->status == 'supporter_replied')
                                                <span class="text-primary font-weight-500 font-16">{{  trans('panel.replied') }}</span>
                                            @else
                                                <span class="text-warning font-weight-500 font-16">{{  trans('public.waiting') }}</span>
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if(!empty($selectSupport))
                        <div class="col-12 col-lg-7 border-left border-gray300">
                            <div class="conversation-box p-15 d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="font-weight-500 font-16 text-dark-blue d-block">{{ $selectSupport->title }}</span>
                                    <span class="font-12 mt-1 text-gray d-block">{{ trans('public.created') }}: {{ dateTimeFormat($support->created_at,'j M Y | H:i') }}</span>

                                    @if(!empty($selectSupport->webinar))
                                        <span class="font-12 text-gray d-block mt-5">{{ trans('webinars.webinar') }}: {{ $selectSupport->webinar->title }}</span>
                                    @endif
                                </div>

                                @if($selectSupport->status != 'close')
                                    <a href="/panel/support/{{ $selectSupport->id }}/close" class="btn btn-primary btn-sm">{{ trans('panel.close_request') }}</a>
                                @endif
                            </div>

                            <div id="conversationsCard" class="pt-15 conversations-card">

                                @if(!empty($selectSupport->conversations) and !$selectSupport->conversations->isEmpty())

                                    @foreach($selectSupport->conversations as $conversations)
                                        <div class="rounded-sm mt-15 panel-shadow border p-15">
                                            <div class="d-flex align-items-center justify-content-between pb-20 border-bottom border-gray300">
                                                <div class="user-inline-avatar d-flex align-items-center">
                                                    <div class="avatar bg-gray200">
                                                        <img src="{{ (!empty($conversations->supporter)) ? $conversations->supporter->getAvatar() : $conversations->sender->getAvatar() }}" class="img-cover" alt="">
                                                    </div>
                                                    <div class="ml-10">
                                                        <span class="d-block text-dark-blue font-16 font-weight-500">{{ (!empty($conversations->supporter)) ? $conversations->supporter->get_full_name() : $conversations->sender->get_full_name() }}</span>
                                                        <span class="mt-1 font-12 text-gray d-block">{{ (!empty($conversations->supporter)) ? trans('panel.staff') : $conversations->sender->role_name }}</span>
                                                    </div>
                                                </div>

                                                <div class="d-flex flex-column align-items-end">
                                                    <span class="font-12 text-gray">{{ dateTimeFormat($conversations->created_at,'j M Y | H:i') }}</span>

                                                    @if(!empty($conversations->attach))
                                                        <a href="{{ url($conversations->attach) }}" target="_blank" class="font-12 mt-10 text-danger"><i data-feather="paperclip" height="14"></i> {{ trans('panel.attach') }}</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <p class="text-gray font-16 mt-15 font-weight-500">{!! nl2br($conversations->message) !!}</p>
                                        </div>
                                    @endforeach

                                @endif
                            </div>

                            <div class="conversation-box mt-30 py-10 px-15">
                                <h3 class="font-16 text-dark-blue font-weight-bold">{{ trans('panel.reply_to_the_conversation') }}</h3>
                                <form action="/panel/support/{{ $selectSupport->id }}/conversations" method="post" class="mt-5">
                                    {{ csrf_field() }}

                                    <div class="form-group mt-10">
                                        <label class="input-label d-block">{{ trans('site.message') }}</label>
                                        <textarea name="message" class="form-control @error('message')  is-invalid @enderror" rows="5">{{ old('message') }}</textarea>
                                        @error('message')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="d-flex d-flex align-items-center">
                                        <div class="form-group">
                                            <label class="input-label">{{ trans('panel.attach_file') }}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <button type="button" class="input-group-text panel-file-manager" data-input="attach" data-preview="holder">
                                                        <i data-feather="arrow-up" width="18" height="18" class="text-white"></i>
                                                    </button>
                                                </div>
                                                <input type="text" name="attach" id="attach" value="{{ old('attach') }}" class="form-control"/>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-sm ml-40 mt-10">{{ trans('site.send_message') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="col-12 col-lg-6 border-left border-gray300">
                            @include(getTemplate() . '.includes.no-result',[
                                'file_name' => 'support.png',
                                'title' => trans('panel.select_support'),
                                'hint' => nl2br(trans('panel.select_support_hint')),
                            ])
                        </div>
                    @endif
                </div>
            </div>

        @else

            @include(getTemplate() . '.includes.no-result',[
                'file_name' => 'support.png',
                'title' => trans('panel.support_no_result'),
                'hint' => nl2br(trans('panel.support_no_result_hint')),
            ])

        @endif
    </section>


@endsection


@push('scripts_bottom')
    <script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>
    <script src="/assets/default/vendors/select2/select2.min.js"></script>

    <script src="/assets/default/js/panel/conversations.min.js"></script>
@endpush
