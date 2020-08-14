<html>
<title>Firebase Messaging Demo</title>
<style>
    div {
        margin-bottom: 15px;
    }
</style>
<body>
    <div id="token"></div>
    <div id="msg"></div>
    <div id="notis"></div>
    <div id="err"></div>
    <script>
       MsgElem = document.getElementById("msg")
       TokenElem = document.getElementById("token")
       NotisElem = document.getElementById("notis")
       ErrElem = document.getElementById("err")
    </script>

    <script>
    var config = {
        messagingSenderId: "1000022360340",
        apiKey: "AIzaSyDsVywia-S2mcyKDp6ZxZQAGtkvovh-yvA",
        projectId: "my-tutorials-3754a",
        appId: "1:1000022360340:web:1b6378fd418412a52c4201"
    };
    firebase.initializeApp(config);
</script>
<script>
importScripts("https://www.gstatic.com/firebasejs/7.16.1/firebase-app.js");
importScripts(
    "https://www.gstatic.com/firebasejs/7.16.1/firebase-messaging.js",
);
// For an optimal experience using Cloud Messaging, also add the Firebase SDK for Analytics.
importScripts(
    "https://www.gstatic.com/firebasejs/7.16.1/firebase-analytics.js",
);

// Initialize the Firebase app in the service worker by passing in the
// messagingSenderId.
firebase.initializeApp({
    messagingSenderId: "YOUR-SENDER-ID",
    apiKey: "YOUR_API_KEY",
    projectId: "YOUR_PROJECT_ID",
    appId: "YOUR_APP_ID",
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();

messaging.setBackgroundMessageHandler(function(payload) {
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload,
    );
    // Customize notification here
    const notificationTitle = "Background Message Title";
    const notificationOptions = {
        body: "Background Message body.",
        icon: "/itwonders-web-logo.png",
    };

    return self.registration.showNotification(
        notificationTitle,
        notificationOptions,
    );
});


const messaging = firebase.messaging();
 messaging
   .requestPermission()
   .then(function () {
     MsgElem.innerHTML = "Notification permission granted." 
     console.log("Notification permission granted.");
   })
   .catch(function (err) {
   ErrElem.innerHTML = ErrElem.innerHTML + "; " + err
   console.log("Unable to get permission to notify.", err);
 });
</script>
</body>
</html>