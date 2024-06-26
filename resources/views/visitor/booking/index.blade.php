@extends('visitor.layouts.main')

@section('content')
    <div class="MyContainer flex-wrap d-flex justify-content-center">
        <div class="d-flex justify-content-center  col-12 col-xl-4 text-center mt-4 mb-4" id="canvas-container">
            <div style="position: relative">
                <canvas id="drawingCanvas" style="background-image: url('{{asset('images/table.png')}}');"></canvas>
                @foreach($tables as $table)
                    <div style="position: absolute; display: contents;">
                        <p class="text-light image"  data-id="{{$table->id}}" style="position: absolute;left: {{$table['x']+7}}px; top: {{$table['y']}}px; z-index: 1;">{{$table->id}}</p>
                        <img src="
                    {{$table['is_available_for_now'] == 1?asset('images/greenTable.png'): asset('images/redTable.png')}}
                " width="42" height="42" data-id="{{$table->id}}" class="image"
                             style="left: {{$table['x']}}px; top: {{$table['y']}}px;">
                    </div>
                @endforeach
            </div>
        </div>
        <div id="hereCalendar" class="d-none col-12 col-xl-3" style="display: flex; justify-content: center">
            <div data-bs-toggle="calendar" style="padding: 0;"
                 data-bs-target="{{ route('slots', ['id' => 1]) }}" class=" exampleCalendar mt-md-4"></div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        let start;
        let end;
        $('.exampleCalendar').bsCalendar({
            width: '100%',
            showTodayHeader: false,
            showPopover: false,

            formatEvent: function (event) {
                console.log(event);
                const startTimeUtc = moment.utc(event.start);
                const startTime = startTimeUtc.format('HH:mm');

                const endTimeUtc = moment.utc(event.end);
                const endTime = endTimeUtc.format('HH:mm');

                console.log(startTime);
                console.log(event.is_available);
                return '<button class="event-time w-100 meeting event-item btn btn-warning myColor mt-2"' + (event.is_available === 0 ? 'disabled' : '') + '  data-start="' + event.start + '" data-end="' + event.end + '">' +
                    startTime + '-' + endTime
                '</button>';
            }
        });

        $(document).ready(function () {
            $('.image').click(function () {
                let x = $(this).css('left');
                let id = $(this).data('id');

                $('#hereCalendar').html(generateCalendarHTML(id));
                $('#hereCalendar').removeClass('d-none');

                $('.exampleCalendar').bsCalendar({
                    width: '100%',
                    showTodayHeader: false,
                    showPopover: false,
                });


            });
        });

        function generateCalendarHTML(id) {
            let route = '{{ route('slots', ['id' => ':id']) }}'; // Ось місце для заміни ':id' на фактичне значення

            route = route.replace(':id', id);

            let html = '<div data-bs-toggle="calendar" data-id="' + id + '" style="background-color: white; border-radius: 15px; padding: 0; max-width: 400px" data-bs-target="' + route + '"id="exCalendar" class="exampleCalendar mt-md-4"></div>';

            return html;
        }

        $(document).ready(function () {
            $(document).on('click', '.js-event', function () {
                id = $("#exCalendar").data('id');
                start = $(this).find('.event-time').data('start');
                end = $(this).find('.event-time').data('end');

                if (start !== undefined && end !== undefined) {
                    let url = '/makeBook?start=' + encodeURIComponent(start) + '&end=' + encodeURIComponent(end) + '&id=' + encodeURIComponent(id);
                    window.location.href = url;
                }

            });
        })
    </script>
@endpush
