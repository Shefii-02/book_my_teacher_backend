<html>
<head>
    <style>
        #root {
            width: 100vw;
            height: 100vh;
            overflow: hidden;
        }
    </style>
</head>
<body>
<div id="root"></div>
<div id="whiteboard"></div>
</body>

<!-- Whiteboard + UIKit SDKs -->
<script src="https://unpkg.com/zego-superboard-web@2.15.3/index.js"></script>
<script src="https://unpkg.com/@zegocloud/zego-uikit-prebuilt/zego-uikit-prebuilt.js"></script>

<script>
    function getUrlParams(url = window.location.href) {
        let urlStr = url.split("?")[1];
        return new URLSearchParams(urlStr);
    }

    const roomID = getUrlParams().get("roomID") || "room_" + Math.floor(Math.random() * 1000);
    const userID = Math.floor(Math.random() * 10000) + "";
    const userName = "user_" + userID;
    const appID = `{{ $app_id }}`;
    const serverSecret = `{{ $secret_id }}`;

    // role=host OR role=audience
    const role = getUrlParams().get("role") || "audience";

    const kitToken = ZegoUIKitPrebuilt.generateKitTokenForTest(
        appID,
        serverSecret,
        roomID,
        userID,
        userName
    );

    const zp = ZegoUIKitPrebuilt.create(kitToken);
    zp.addPlugins({ ZegoSuperBoardManager });

    // ✅ Common settings
    const roomConfig = {
        container: document.querySelector("#root"),
        sharedLinks: [{
            name: "Copy Link",
            url: window.location.origin + window.location.pathname + "?roomID=" + roomID + "&role=audience",
        }],
        scenario: {
            mode: ZegoUIKitPrebuilt.LiveStreaming,
            config: {
                role: role === "host" ? ZegoUIKitPrebuilt.Host : ZegoUIKitPrebuilt.Audience
            }
        },
        showWhiteboardButton: role === "host",
        whiteboardConfig: {
            showCreateButton: true,
            showAddImageButton: true,
            showUploadDocsButton: true,
        }
    };

    // ✅ Role-specific permissions
    if (role === "host") {
        roomConfig.micEnabled = true;
        roomConfig.cameraEnabled = true;
        roomConfig.showScreenSharingButton = true;
    } else {
        roomConfig.micEnabled = false;            // no mic
        roomConfig.cameraEnabled = false;         // no camera
        roomConfig.turnOnMicrophoneWhenJoining = false;
        roomConfig.turnOnCameraWhenJoining = false;
        roomConfig.showScreenSharingButton = false;
    }

    zp.joinRoom(roomConfig);
</script>
</html>
