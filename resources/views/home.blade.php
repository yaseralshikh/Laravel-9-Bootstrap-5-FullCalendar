@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div class="">{{ __('Dashboard') }}</div>
                            <div class="">
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

                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="appointmentModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var initialLocaleCode = 'ar-sa';
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

                    events: @json($events),
                    selectable: true,
                    selectHelper: true,
                    select: function(start, end, allDays){
                        $('#appointmentModal').modal('toggle');
                    }
                });
                calendar.render();

                // build the locale selector's options
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
