<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="//fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
            
            .pusher {
              font-size: 86px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Laravel 5</div>
                <div class="pusher">Real-Time by Pusher</div>
            </div>
        </div>

        <script src="//js.pusher.com/3.0/pusher.min.js"></script>
        <script>
            Pusher.log = function(msg) {
                console.log(msg);
            };

            var pusher = new Pusher("{{env('PUSHER_KEY')}}")
            var channel = pusher.subscribe('test-channel');
            channel.bind('test-event', function(data) {
                alert(data.text);
            });
        </script>
    </body>
</html>
