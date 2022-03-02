var myInterval;
$(function () {
  var speakerDevices = document.getElementById('speaker-devices');
  var ringtoneDevices = document.getElementById('ringtone-devices');
  var outputVolumeBar = document.getElementById('output-volume');
  var inputVolumeBar = document.getElementById('input-volume');
  var volumeIndicators = document.getElementById('volume-indicators');

  log('Requesting Capability Token...');

  $.getJSON('https://cherry-moose-4861.twil.io/capability-token')

    .done(function (data) {
      // Setup Twilio.Device
      Twilio.Device.setup(data.token);

      Twilio.Device.ready(function (device) {
        console.log('device ready...');
        //$('.clickon').css('display','block');
      });

      Twilio.Device.error(function (error) {
        log('Twilio.Device Error: ' + error.message);
      });

      Twilio.Device.connect(function (conn) {
        var fiveMinutes = 60 * 0,
        display = $('#timer');
        startTimer(fiveMinutes, display);
        insertToOrderMaster(conn.parameters.CallSid);
        document.getElementById('button-call').style.display = 'none';
        document.getElementById('button-hangup').style.display = 'inline';
      });

      // Twilio.Device

      Twilio.Device.disconnect(function (conn) {
        clearInterval(myInterval);
        disconnectCall();
        $('#call-duration').modal('hide');
        document.getElementById('button-call').style.display = 'inline';
        document.getElementById('button-hangup').style.display = 'none';
        location.reload();
      });

      /*Twilio.Device.accept(function (conn) {
        console.log('accept', conn)
      });*/

      // Show audio selection UI if it is supported by the browser.
      if (Twilio.Device.audio.isSelectionSupported) {
        document.getElementById('output-selection').style.display = 'block';
      }
    })
    .fail(function () {
      log('Could not get a token from server!');
    });

  // Bind button to make call
  document.getElementById('button-call').onclick = function () {
    // get the phone number to connect the call to
    var params = {
      To: document.getElementById('phone-number').value
    };
    Twilio.Device.connect(params);
  };

  // Bind button to hangup call
  document.getElementById('button-hangup').onclick = function () {
    log('Hanging up...');
    Twilio.Device.disconnectAll();
    console.log(Twilio.Device.status());
    location.reload();
  };

  document.getElementById('get-devices').onclick = function() {
    navigator.mediaDevices.getUserMedia({ audio: true })
      .then(updateAllDevices);
  };
  function updateAllDevices() {
    updateDevices(speakerDevices, Twilio.Device.audio.speakerDevices.get());
    updateDevices(ringtoneDevices, Twilio.Device.audio.ringtoneDevices.get());
  }
});

// Update the available ringtone and speaker devices
function updateDevices(selectEl, selectedDevices) {
  selectEl.innerHTML = '';
  Twilio.Device.audio.availableOutputDevices.forEach(function(device, id) {
    var isActive = (selectedDevices.size === 0 && id === 'default');
    selectedDevices.forEach(function(device) {
      if (device.deviceId === id) { isActive = true; }
    });

    var option = document.createElement('option');
    option.label = device.label;
    option.setAttribute('data-id', id);
    if (isActive) {
      option.setAttribute('selected', 'selected');
    }
    selectEl.appendChild(option);
  });
}

// Activity log
function log(message) {
  /*var logDiv = document.getElementById('log');
  logDiv.innerHTML += '<p>&gt;&nbsp;' + message + '</p>';
  logDiv.scrollTop = logDiv.scrollHeight;*/
}

// Set the client name in the UI
function setClientNameUI(clientName) {
 /* var div = document.getElementById('client-name');
  div.innerHTML = 'Your client name: <strong>' + clientName +
    '</strong>';*/
}

