@extends('backLayout.app')
@section('title')
    View User Calendar
    @stop
@section('content')
    <div class="col-md-3">
        <form >
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            Title name:
            <br />
            <input type="text" name="title" id = "name"/>
            <br /><br />
            Start time:
            <br />
            <input type="date" name="start_date" class="date" id = "start_date"/>
            <br /><br />
            End time:
            <br />
            <input type="date" name="end_date" class="date" id = "end_date" />
            <br /><br />
            <input type="button" value="Save" id="createEvent"/>
        </form>
    </div>
    <div class="col-md-9">
        <div id='calendar'></div>
    </div>

@stop

@section('scripts')
    <script src="{{ URL::asset('/js/moment.min.js') }}"></script>
    <script src="{{ URL::asset('/js/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('/js/fullcalendar.min.js') }}"></script>
    <script>

        $(document).ready(function() {
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,basicWeek,basicDay'
                },
                defaultDate: '2018-03-12',
                navLinks: true, // can click day/week names to navigate views
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                events: [],
                eventClick: function(event, element) {
                    console.log(event);
                    event.title = "Click!";

                    $('#calendar').fullCalendar('updateEvent', event);

                },
                eventDrop: function(event, delta, revertFunc) {

                    alert(event.title + " was dropped on " + event.start.format());

                    if (!confirm("Are you sure about this change?")) {
                        revertFunc();
                    }
                }
            });


        });

    </script>
<script src="https://js.pusher.com/4.3/pusher.min.js"></script>

<script type="text/javascript">
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('8ad3fa296f9b5f85c3ff', {
        cluster: 'ap1',
        encrypted: true
    });

    // Subscribe to the channel we specified in our Laravel Event
    var channel = pusher.subscribe('Calendar');

    // Bind a function to a Event (the full Laravel class)
    channel.bind('calendar-update', function(data) {
        console.log(data);
        $('#calendar').fullCalendar('renderEvent', {
            title: data.title,
            start: '2018-03-10',
            end: '2018-03-13',
            allDay: true
        });
    });

</script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {
            $('#createEvent').on('click', function () {
                var title = $('#name').val(),
                    start_date = $('#start_date').val(),
                    end_date = $('#end_date').val();
                var data ={
                    title : title,
                    start_date : start_date,
                    end_date : end_date
                };
                $.ajax({
                    type: "POST",
                    cache: false,
                    url : "{{action('EventController@store')}}",
                    data: data,
                    success: function(data) {
                    }
                })
            });

        });
    </script>

@endsection
