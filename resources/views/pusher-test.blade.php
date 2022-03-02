<!DOCTYPE html>
<head>
  <title>Pusher Test</title>
</head>
<body>
  <h1>Pusher Test</h1>
  <p>
    Try publishing an event to channel <code>astroaquila</code>
    with event name <code>eventnew</code>.
  </p>
  <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('{{env('PUSHER_APP_KEY')}}', {
      cluster: '{{env('PUSHER_APP_CLUSTER')}}'
    });

    var channel = pusher.subscribe('astroaquila');
    channel.bind('eventnew', function(data) {
      alert(JSON.stringify(data));
    });
  </script>
</body>

