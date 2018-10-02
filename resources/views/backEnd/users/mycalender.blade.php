@extends('backLayout.app')
@section('title')
    View User Calendar
@stop

@section('content')
    <div class="col-md-3">
        <form >
            {{ csrf_field() }}
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

    <script>
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
    {{--<script src="https://js.pusher.com/4.3/pusher.min.js"></script>--}}
    {{--<script type="text/javascript">--}}
        {{--// Enable pusher logging - don't include this in production--}}
        {{--Pusher.logToConsole = true;--}}

        {{--var pusher = new Pusher('8ad3fa296f9b5f85c3ff', {--}}
            {{--cluster: 'ap1',--}}
            {{--encrypted: true--}}
        {{--});--}}

        {{--// Subscribe to the channel we specified in our Laravel Event--}}
        {{--var channel = pusher.subscribe('Calendar');--}}

        {{--// Bind a function to a Event (the full Laravel class)--}}
        {{--channel.bind('calendar-update', function(data) {--}}
            {{--$('#calendar').fullCalendar({--}}
                {{--events: [--}}
                    {{--{--}}
                        {{--title: data.title,--}}
                        {{--start: '2018-10-10T13:13:55.008',--}}
                        {{--end: '2018-10-13T13:13:55.008'--}}
                    {{--},--}}
                {{--],--}}
                {{--eventSources: [--}}

                    {{--// your event source--}}
                    {{--{--}}
                        {{--url: '', // use the `url` property--}}
                        {{--color: 'yellow',    // an option!--}}
                        {{--textColor: 'red'  // an option!--}}
                    {{--}--}}
                {{--]--}}
            {{--});--}}
        {{--});--}}

    {{--</script>--}}

@endsection