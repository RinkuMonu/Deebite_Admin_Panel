<!DOCTYPE html>
<html>
<head>
    <title>FCM Test</title>
</head>
<body>

<h2>FCM Token Test</h2>

<script type="module">
    // Import Firebase
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
    import { getMessaging, getToken } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-messaging.js";

    // 🔥 Replace with YOUR Firebase config
    const firebaseConfig = {
        apiKey: "YOUR_API_KEY",
        authDomain: "YOUR_PROJECT.firebaseapp.com",
        projectId: "YOUR_PROJECT_ID",
        storageBucket: "YOUR_PROJECT.appspot.com",
        messagingSenderId: "YOUR_SENDER_ID",
        appId: "YOUR_APP_ID"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const messaging = getMessaging(app);

    // Request permission
    Notification.requestPermission().then(async (permission) => {
        if (permission === "granted") {

            const token = await getToken(messaging, {
                vapidKey: "YOUR_VAPID_KEY"
            });

            console.log("FCM Token:", token);
            alert(token);

        } else {
            alert("Permission denied");
        }
    });
</script>

</body>
</html>