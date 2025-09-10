<html>
  <head>
    <style>
      #root {
        width: 100vw;
        height: 100vh;
      }
    </style>
  </head>

  <body>
    <div id="root"></div>
  </body>
  <script src="https://unpkg.com/@zegocloud/zego-uikit-prebuilt/zego-uikit-prebuilt.js"></script>
  <script>
    function getUrlParams(url = window.location.href) {
      let urlStr = url.split("?")[1];
      return new URLSearchParams(urlStr);
    }
    // Generate a Kit Token by calling a method.
    // @param 1: appID
    // @param 2: serverSecret
    // @param 3: Room ID
    // @param 4: User ID
    // @param 5: Username
    const roomID =
      getUrlParams().get("roomID") ||
      "room_" + Math.floor(Math.random() * 1000);
    const userID = Math.floor(Math.random() * 10000) + "";
    const userName = "userName" + userID;
    const appID = 1266818966;
    const serverSecret = "d2ca2d8fd78dc5cfe5f22f2bbad37739";
    const kitToken = ZegoUIKitPrebuilt.generateKitTokenForTest(
      appID,
      serverSecret,
      roomID,
      userID,
      userName
    );

    const zp = ZegoUIKitPrebuilt.create(kitToken);
    zp.joinRoom({
      container: document.querySelector("#root"),
      sharedLinks: [
        {
          url:
            window.location.origin +
            window.location.pathname +
            "?roomID=" +
            roomID,
        },
      ],
      scenario: {
        mode: ZegoUIKitPrebuilt.OneONoneCallGroupCall,
      },
    });
  </script>
</html>
