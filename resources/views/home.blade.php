@extends('layouts.app')

@section('content')

    @push('styles')
        <style>
            .fc .fc-toolbar-title {
                font-size: 1.5em;
                padding: 10px;
                text-align: center;
            }

            .fc-col-header {
                background-color:blue;
                background-color: aliceblue;
            }
        </style>
    @endpush

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{-- Content Card Header --}}
                        <div class="d-flex justify-content-between">
                            <div>{{ __('Dashboard') }}</div>
                            {{-- Localization  Aria --}}
                            <div>
                                <select class="form-select form-select-sm" id='locale-selector' aria-label=".form-select-sm Locales">
                                    <option selected value="ar-sa">ar</option>
                                    <option value="en">en</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        {{-- Full Calender --}}
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Appointment Modal -->
    <div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="appointmentModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <div class="form-group">
                                <!-- User ID -->
                                <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}">
                                <!-- Semester -->
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="semester">{{ __('Semester') }}</label>
                                    <select name="semester" class="form-select  @error('semester') is-invalid @enderror" id="semester">
                                        <option selected>Choose...</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                        <option value="4">fore</option>
                                    </select>

                                    @error('semester')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Task -->
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="task">{{ __('Task') }}</label>
                                    <select name="task" class="form-select  @error('task') is-invalid @enderror" id="task">
                                        <option selected>Choose...</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                        <option value="4">fore</option>
                                    </select>

                                    @error('task')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Start time --}}
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">{{ __('Start time') }}</span>
                                    <input id="start_time" type="date" class="form-control @error('start_time') is-invalid @enderror" name="start_time" value="{{ old('start_time') }}" required autocomplete="start_time" autofocus aria-describedby="basic-addon1">

                                    @error('start_time')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Finish time --}}
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">{{ __('Finish time') }}</span>
                                    <input id="finish_time" type="date" class="form-control @error('finish_time') is-invalid @enderror" name="finish_time" value="{{ old('finish_time') }}" required autocomplete="finish_time" autofocus aria-describedby="basic-addon1">

                                    @error('finish_time')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="saveBtn" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                // var initialLocaleCode = 'ar-sa';
                var initialLocaleCode = 'en';
                var localeSelectorEl = document.getElementById('locale-selector');
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    displayEventTime : false,
                    locale: initialLocaleCode,
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,listWeek'
                    },
                    // for show Tooltips
                    eventDidMount: function (info) {
                        $(info.el).popover({
                            title: info.event.title,
                            placement: 'top',
                            trigger: 'hover',
                            content: 'more info on the popover if you want',
                            container: 'body'
                        });
                    },
                    //for add data events
                    events: @json($events),
                    eventColor: '#378006',
                    // for selcet any event and controlle(add , edit)
                    selectable: true,
                    selectHelper: true,
                    select: function(start, end, allDays){
                        $('#appointmentModal').modal('toggle');

                        $('#saveBtn').click(function(){
                            var user_id = $('#user_id').val();
                            var semester = $('#semester').val();
                            var task = $('#task').val();

                            var start_time = $('#start_time').val();
                            var finish_time = $('#finish_time').val();
                            //var start_time = moment(start).format('YYYY-MM-DD HH:mm:ss');
                            //var finish_time = moment(end).format('YYYY-MM-DD HH:mm:ss');

                            //console.log(user_id, semester, task, start_time, finish_time);
                            $.ajax({
                                url:"{{ route('store') }}",
                                type:"POST",
                                dataType:'json',
                                data:{ user_id, semester, task, start_time, finish_time },
                                success:function(response)
                                {
                                    $('#appointmentModal').modal('hide');
                                    calendar.addEvent({
                                        title: response.title,
                                        start: response.start,
                                        end: response.end,
                                        color: response.color
                                    });
                                },
                                error:function(error)
                                {
                                    if(error.responseJSON.errors) {
                                        $('#titleError').html(error.responseJSON.errors.title);
                                    }
                                },
                            });
                        });
                    }
                });

                calendar.render();

                // build the locale selector's options (for all locales)
                // calendar.getAvailableLocaleCodes().forEach(function(localeCode) {
                //     var optionEl = document.createElement('option');
                //     optionEl.value = localeCode;
                //     optionEl.selected = localeCode == initialLocaleCode;
                //     optionEl.innerText = localeCode;
                //     localeSelectorEl.appendChild(optionEl);
                // });

                // when the selected option changes, dynamically change the calendar option
                localeSelectorEl.addEventListener('change', function() {
                    if (this.value) {
                    calendar.setOption('locale', this.value);
                    }
                });

            });
        </script>
    @endpush

@endsection
