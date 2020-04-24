<!DOCTYPE html>
<html>
  <head>
    <title>Instascan</title>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js" ></script>
  </head>
  <body>

        <video id="preview"></video>

        <script>
            let scanner = new Instascan.Scanner(
                {
                    video: document.getElementById('preview')
                }
            );
            scanner.addListener('scan', function(content) {
                window.open(content, "_blank");
                window.location.href='Traitement_qrcode.php?variable=' + content;

            });
            Instascan.Camera.getCameras().then(cameras =>
            {
                if(cameras.length > 0){
                    scanner.start(cameras[0]);
                } else {
                    console.error("Caméra ");
                }
            });
            </script>

          </body>
          </html>
