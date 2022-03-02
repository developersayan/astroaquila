// Import and configure the Firebase SDK
// These scripts are made available when the app is served or deployed on Firebase Hosting
// If you do not serve/host your project using Firebase Hosting see https://firebase.google.com/docs/web/setup
/*importScripts('/__/firebase/5.0.0/firebase-app.js');
importScripts('/__/firebase/5.0.0/firebase-messaging.js');
importScripts('/__/firebase/init.js');

var messaging = firebase.messaging();*/

/**
 * Here is is the code snippet to initialize Firebase Messaging in the Service
 * Worker when your app is not hosted on Firebase Hosting. **/

 // [START initialize_firebase_in_sw]
 // Give the service worker access to Firebase Messaging.
 // Note that you can only use Firebase Messaging here, other Firebase libraries
 // are not available in the service worker.
 importScripts('https://www.gstatic.com/firebasejs/7.14.5/firebase-app.js');
 importScripts('https://www.gstatic.com/firebasejs/7.14.5/firebase-messaging.js');

 // Initialize the Firebase app in the service worker by passing in the
 // messagingSenderId.
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

 // Retrieve an instance of Firebase Messaging so that it can handle background
 // messages.
 const messaging = firebase.messaging();
 // [END initialize_firebase_in_sw]



// If you would like to customize notifications that are received in the
// background (Web app is closed or not in browser focus) then you should
// implement this optional method.
// [START background_handler]
messaging.setBackgroundMessageHandler(function(payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
  // Customize notification here
  var notificationTitle = payload.data.title;
  var notificationOptions = {
    body: payload.data.message,
    icon: '/firebase-logo.png'
  };

  return self.registration.showNotification(notificationTitle,notificationOptions);
});
// [END background_handler]
