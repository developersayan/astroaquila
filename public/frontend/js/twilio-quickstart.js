'use strict';

const Video = Twilio.Video;


var activeRoom;
var previewTracks;
var identity;
var roomName;
var tokenUrl = 'get-twilio-token';

// Attach the Track to the DOM.
function attachTrack(track, container) {
  container.appendChild(track.attach());
}

// Attach array of Tracks to the DOM.
function attachTracks(tracks, container) {
  tracks.forEach(function(track) {
    attachTrack(track, container);
  });
}

// Detach given track from the DOM
function detachTrack(track) {
  track.detach().forEach(function(element) {
    element.remove();
  });
}

// A new RemoteTrack was published to the Room.
function trackPublished(publication, container) {
  if (publication.isSubscribed) {
    attachTrack(publication.track, container);
  }
  publication.on('subscribed', function(track) {
    attachTrack(track, container);
  });
  publication.on('unsubscribed', detachTrack);
}

// A RemoteTrack was unpublished from the Room.
function trackUnpublished(publication) {
  log(publication.kind + ' track was unpublished.');
}

// A new RemoteParticipant joined the Room
function participantConnected(participant, container) {
  participant.tracks.forEach(function(publication) {
    trackPublished(publication, container);
  });
  participant.on('trackPublished', function(publication) {
    trackPublished(publication, container);
  });
  participant.on('trackUnpublished', trackUnpublished);
}

// Detach the Participant's Tracks from the DOM.
function detachParticipantTracks(participant) {
  var tracks = getTracks(participant);
  tracks.forEach(detachTrack);
}

// When we are about to transition away from this page, disconnect
// from the room, if joined.
window.addEventListener('beforeunload', leaveRoomIfJoined);

// Obtain a token from the server in order to connect to the Room.


// Get the Participant's Tracks.
function getTracks(participant) {
  return Array.from(participant.tracks.values()).filter(function(publication) {
    return publication.track;
  }).map(function(publication) {
    return publication.track;
  });
}

// Successfully connected!
function roomJoined(room) {
  start_timer();
  window.room = activeRoom = room;
  // Attach LocalParticipant's Tracks, if not already attached.
  var previewContainer = document.getElementById('local-media');
  if (!previewContainer.querySelector('video')) {
    attachTracks(getTracks(room.localParticipant), previewContainer);
  }

  // Attach the Tracks of the Room's Participants.
  var remoteMediaContainer = document.getElementById('remote-media');
  room.participants.forEach(function(participant) {
    $('#connecting').hide();
    $('#local-media').show();
    participantConnected(participant, remoteMediaContainer);
  });

  room.on('trackEnabled', function(track, participant) {
    if(track.kind =='video'){
      $('#remote-video-mute').hide();
      $('#remote-media').removeClass('muteblur');
    }
    if(track.kind =='audio'){
      $('#remote-audio-mute').hide();
    }
  });

  // mute audio and video for remote user
  room.on('trackDisabled', function(track, participant) {
    if(track.kind =='video'){
      $('#remote-video-mute').show();
      $('#remote-media').addClass('muteblur');
    }
    if(track.kind =='audio'){
      $('#remote-audio-mute').show();
    }
  });

  // When a Participant joins the Room, log the event.
  room.on('participantConnected', function(participant) {
    $('#connecting').hide();
    $('#local-media').show();
    participantConnected(participant, remoteMediaContainer);
  });

  // When a Participant leaves the Room, detach its Tracks.
  room.on('participantDisconnected', function(participant) {
    detachParticipantTracks(participant);
    // call videoCloseFunCustomer for stop timer and remove localstorage
    if(userType == 'C') {
      videoCloseFunCustomer();
    //   swal('Vip user disconnected.',{icon:"info"});
    swal('Disconnected.',{icon:"info"});
    }

    // call videoCloseFunProfessional for stop timer and remove localstorage
    if(userType == 'P') {
      videoCloseFunProfessional();
    //   swal('Customer disconnected.',{icon:"info"});
    swal('Disconnected.',{icon:"info"});
    }
  });

  // Once the LocalParticipant leaves the room, detach the Tracks
  // of all Participants, including that of the LocalParticipant.
  room.on('disconnected', function() {
    if (previewTracks) {
      previewTracks.forEach(function(track) {
        track.stop();
      });
      previewTracks = null;
    }
    detachParticipantTracks(room.localParticipant);
    room.participants.forEach(detachParticipantTracks);
    activeRoom = null;

    // call videoCloseFunCustomer for stop timer and remove localstorage
    if(userType == 'C') {
      videoCloseFunCustomer();
    //   swal('Disconnected.',{icon:"info"});
      swal('Vip user disconnected.',{icon:"info"});
    }

    // call videoCloseFunProfessional for stop timer and remove localstorage
    if(userType == 'P') {
      videoCloseFunProfessional();
      swal('Customer disconnected.',{icon:"info"});
    //   swal('Disconnected.',{icon:"info"});
    }
  });

  // video mute and audio mute

  var localParticipant = room.localParticipant;
  $('body').on('click', '#video-mute', function() {
    $('#local-video-mute').show();
    $(this).hide();
    $('#video-unmute').show();
    localParticipant.videoTracks.forEach(function (videoTrack) {
      videoTrack.track.disable();
    });
  })

  $('body').on('click', '#video-unmute', function() {
    $('#local-video-mute').hide();
    $(this).hide();
    $('#video-mute').show();
    localParticipant.videoTracks.forEach(function (videoTrack) {
      videoTrack.track.enable();
    });
  })

  $('body').on('click', '#audio-mute', function() {
    $('#local-audio-mute').show();
    $(this).hide();
    $('#audio-unmute').show();
    localParticipant.audioTracks.forEach(function (audioTrack) {
      audioTrack.track.disable();
    });
  })

  $('body').on('click', '#audio-unmute', function() {
    $('#local-audio-mute').hide();
    $(this).hide();
    $('#audio-mute').show();
    localParticipant.audioTracks.forEach(function (audioTrack) {
      audioTrack.track.enable();
    });
  })
}

// Preview LocalParticipant's Tracks.
document.getElementById('button-preview').onclick = function() {
  var localTracksPromise = previewTracks
    ? Promise.resolve(previewTracks)
    : Video.createLocalTracks();

  localTracksPromise.then(function(tracks) {
    window.previewTracks = previewTracks = tracks;
    var previewContainer = document.getElementById('local-media');
    if (!previewContainer.querySelector('video')) {
      attachTracks(tracks, previewContainer);
    }
  }, function(error) {
    console.error('Unable to access local media', error);
    log('Unable to access Camera and Microphone');
  });
};

// Activity log.
function log(message) {

}

// Leave Room.
function leaveRoomIfJoined() {
  if (activeRoom) {
    activeRoom.disconnect();
  }
}
