<!DOCTYPE html>
<html>
<head>
    <title>Real-Time Laravel with Pusher</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="//js.pusher.com/3.0/pusher.min.js"></script>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <script>
        // Ensure CSRF token is sent with AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Added Pusher logging
        Pusher.log = function(msg) {
            console.log(msg);
        };
    </script>
</head>
<body>

<form id="notify_form" action="/notifications/notify" method="post">
    <label for="notify_text">What's the notification?</label>
    <input type="text" id="notify_text" name="notify_text" minlength="3" maxlength="50" required />
</form>

<script>
    // set up form submission handling
    function notifyInit() {
        $('#notify_form').submit(notifySubmit);
    }

    // Handle the form submission
    function notifySubmit() {
        var notifyText = $('#notify_text').val();
        if(notifyText.length < 3) {
            return;
        }

        // Build POST data and make AJAX request
        var data = {notify_text: notifyText};
        $.post('/notifications/notify', data).success(notifySuccess);

        // Ensure the normal browser event doesn't take place
        return false;
    }

    // Handle the success callback
    function notifySuccess() {
        console.log('notification submitted');
    }

    // Use toastr to show the notification
    function showNotification(data) {
        var text = data.text;
        toastr.success(text);
    }

    $(notifyInit);

    var pusher = new Pusher('{{env("PUSHER_KEY")}}');

    // Subscribe to the channel
    var channel = pusher.subscribe('notifications');

    // Bind to the event and pass in the notification handler
    channel.bind('new-notification', showNotification);
</script>

</body>
</html>