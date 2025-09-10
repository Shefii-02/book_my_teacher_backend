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

<!--add whiteboard plugins before UIKits SDK -->
<script src="https://unpkg.com/zego-superboard-web@2.15.3/index.js"></script>
<script src="https://unpkg.com/@zegocloud/zego-uikit-prebuilt/zego-uikit-prebuilt.js"></script>
<script src="https://cdn.bootcdn.net/ajax/libs/vConsole/3.9.0/vconsole.min.js"></script>
<script>
    // VConsole will be exported to `window.VConsole` by default.
    var vConsole = new window.VConsole();
</script>
<script>
    function getUrlParams(url = window.location.href) {
        let urlStr = url.split("?")[1];
        return new URLSearchParams(urlStr);
    }

    const roomID = getUrlParams().get("roomID") || "room_" + Math.floor(Math.random() * 1000);
    const userID = Math.floor(Math.random() * 10000) + "";
    const userName = "userName" + userID;
    const appID = {{ $app_id }};
    const serverSecret = `{{ $secret_id }}`;

    const kitToken = ZegoUIKitPrebuilt.generateKitTokenForTest(
        appID,
        serverSecret,
        roomID,
        userID,
        userName
    );

    // const zp = ZegoUIKitPrebuilt.create(kitToken);

    // zp.joinRoom({
    //     container: document.querySelector("#root"),
    //     joinScreen: {
    //         visible: true,
    //         title: "Join Room",
    //         inviteURL: window.location.origin + window.location.pathname + "?roomID=" + roomID
    //     },
    //     micEnabled: true,
    //     cameraEnabled: true,
    //     userCanToggleSelfCamera: true,
    //     userCanToggleSelfMic: true,
    //     deviceSettings: true,
    //     chatEnabled: true,
    //     userListEnabled: true,
    //     notification: {
    //         userOnlineOfflineTips: true,
    //         unreadMessageTips: true
    //     },
    //     leaveRoomCallback: () => {
    //         console.log("Left the room");
    //     },
    //     branding: {
    //         logoURL: "https://bookmyteacher.shefii.com/assets/images/logo/BookMyTeacher-white.png",
    //     },
    //     onJoinRoom: async () => {
    //         // ✅ Initialize Whiteboard after joining room
    //         const superBoard = new ZegoSuperBoardManager();

    //         // Bind to the same ZegoEngine instance
    //         superBoard.init(zp.getZegoExpressEngine());

    //         // Create whiteboard view
    //         const wbContainer = document.getElementById("whiteboard");
    //         superBoard.createWhiteboardView({ container: wbContainer })
    //             .then(boardView => {
    //                 console.log("Whiteboard ready:", boardView);
    //             })
    //             .catch(err => {
    //                 console.error("Whiteboard error:", err);
    //             });
    //     }
    // });
    const zp = ZegoUIKitPrebuilt.create(kitToken);
    zp.addPlugins({
        ZegoSuperBoardManager
    });

    zp.joinRoom({
        container: document.querySelector("#root"),
        sharedLinks: [{
            name: "Copy Link",
            url: window.location.origin + window.location.pathname + "?roomID=" + roomID,
        }],
        scenario: {
            mode: ZegoUIKitPrebuilt.GroupCall,
        },
        showWhiteboardButton: true, // ✅ enables the whiteboard icon
        whiteboardConfig: {
            showCreateButton: true,
            showAddImageButton: true,
            showUploadDocsButton: true,
        },

    });
</script>

</html>
