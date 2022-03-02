var cT;
const firebaseConfig = {
  apiKey: "AIzaSyDItFNi5m73PUS7hTVxx6P0wgpfz2koE6Y",
  authDomain: "astroaquila-73b74.firebaseapp.com",
  projectId: "astroaquila-73b74",
  storageBucket: "astroaquila-73b74.appspot.com",
  messagingSenderId: "828606586057",
  appId: "1:828606586057:web:1739ddeebe4e86f0c88118",
  measurementId: "G-PWCX6SQ2V9"
};
firebase.initializeApp(firebaseConfig);
firebase.analytics();
const messaging = firebase.messaging();

//server key - AAAAwOzNHMk:APA91bGv882ICbL_fO2qLwkyOaAlWlbWx1P3C_02TVgxxCgo9dDdrUbB7bSgu0tLye4jf_DwdrfgMDI-LHAeax0U6aAJWZT54NP7Rn1F4fkNdkFXTsNUWmjpABwLEO-UPsTX8Gi6LwRn
//sender Id - 828606586057

messaging.usePublicVapidKey("BHnQ-Hfz7B19Yfi2yOkejDAOI_EUZduCgRnHwytGe1nVfm18AW_JZVo_2dVGbvNouh2AQO2t0SuNZxBRCDmoQfQ");
// [END set_public_vapid_key]
// [START refresh_token]
// Callback fired if Instance ID token is updated.
messaging.onTokenRefresh(function() {
    messaging.getToken().then(function(refreshedToken) {
        console.log('Token refreshed.');
        // Indicate that the new Instance ID token has not yet been sent to the
        // app server.
        setTokenSentToServer(false);
        // Send Instance ID token to app server.
        sendTokenToServer(refreshedToken);
        // [START_EXCLUDE]
        // Display new Instance ID token and clear UI of all previous messages.
        resetUI();
        // [END_EXCLUDE]
    }).catch(function(err) {
        console.log('Unable to retrieve refreshed token ', err);
    });
});
// [END refresh_token]

// [START receive_message]
// Handle incoming messages. Called when:
// - a message is received while the app has focus
// - the user clicks on an app notification created by a service worker
//   `messaging.setBackgroundMessageHandler` handler.
/*messaging.onMessage(function(payload) {
    console.log('Message received. ', payload);
    // [START_EXCLUDE]
    // Update the UI to include the received message.
    appendMessage(payload);
    // [END_EXCLUDE]
});*/
// [END receive_message]


function resetUI() {
  console.log("RestUi");
    // [START get_token]
    // Get Instance ID token. Initially this makes a network call, once retrieved
    // subsequent calls to getToken will return from cache.
    messaging.getToken().then(function(currentToken) {
        if (currentToken) {
            cT = currentToken;
            console.log(currentToken);

            sendTokenToServer(currentToken);
            updateUIForPushEnabled(currentToken);
            console.log("restUI");
        } else {
            // Show permission request.
            console.log('No Instance ID token available. Request permission to generate one.');
            // Show permission UI
            setTokenSentToServer(false);
        }
    }).catch(function(err) {
        console.log('An error occurred while retrieving token. ', err);
        setTokenSentToServer(false);
    });
    // [END get_token]
}

function showToken(currentToken) {
  console.log("showToken");
    // alert(currentToken);
    // Show token in console and UI.
    //call ajax to insert/update token in server
}

// Send the Instance ID token your application server, so that it can:
// - send messages back to this app
// - subscribe/unsubscribe the token from topics
function sendTokenToServer(currentToken) {
  console.log("sendTokenToServer")
   // if (!isTokenSentToServer()) {
		console.log('Hello');
        // console.log('Sending token to server...');
        var urlRefresh = "https://astroaquila.com/preview/refresh-dashboard";
        $.ajax({
            url:urlRefresh,
            dataType: 'json',
            data: {
                token: currentToken
            },
            type: 'get',
            success: function(resp){
				console.log(resp);
            }
        });
        // TODO(developer): Send the current token to your server.
		//console.log('Hello');
        setTokenSentToServer(true);
    /*} else {
        console.log('Token already sent to server so won\'t send it again ' +
        'unless it changes');
    }*/
}

function isTokenSentToServer() {
  console.log("isTokenSentToServer");
    return window.localStorage.getItem('sentToServer') === '1';
}

function setTokenSentToServer(sent) {
  console.log("setTokenSentToServer");
    window.localStorage.setItem('sentToServer', sent ? '1' : '0');
}

function requestPermission() {
  console.log("requestPermission");
    console.log('Requesting permission...');
    // [START request_permission]
    messaging.requestPermission().then(function() {
        console.log('Notification permission granted.');
        // TODO(developer): Retrieve an Instance ID token for use with FCM.
        // [START_EXCLUDE]
        // In many cases once an app has been granted notification permission, it
        // should update its UI reflecting this.
        resetUI();
        // [END_EXCLUDE]
    }).catch(function(err) {
        console.log('Unable to get permission to notify.', err);
    });
    // [END request_permission]
}
// Add a message to the messages element.
function appendMessage(payload) {
  console.log("appendMessage");
    //show the custom notification
    console.log(payload);
    /*var from_id = payload.data.from_id;
    var message_id = payload.data.message_id;
    var to_id = payload.data.to_id;
    var from_user_name = payload.data.from_user_name;*/
    // receiveMessage(from_id, from_user_name, to_id, message_id);

    
}



function updateUIForPushEnabled(currentToken) {
  console.log("updateUIForPushEnabled");
    showToken(currentToken);
    cT=currentToken;
}

self.addEventListener('notificationclick', function(event) {
    let url = 'https://google.com';
    event.notification.close(); // Android needs explicit close.
    event.waitUntil(
        clients.matchAll({type: 'window'}).then( windowClients => {
            // Check if there is already a window/tab open with the target URL
            for (var i = 0; i < windowClients.length; i++) {
                var client = windowClients[i];
                // If so, just focus it.
                if (client.url === url && 'focus' in client) {
                    return client.focus();
                }
            }
            // If not, then open the target URL in a new window/tab.
            if (clients.openWindow) {
                return clients.openWindow(url);
            }
        })
    );
});

//resetUI();
requestPermission();