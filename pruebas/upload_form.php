<!DOCTYPE html>
<html>
<body>

    <style>
        .fileToUp2load {width: 500px;
        font-size: 100px;
        background-color: #008CBA;
        }
        .fileToUp2load input {width: 500px;
        font-size: 100px;
        background-color: #008CBA;
        }
       #fileToUp2load {width: 500px;
        font-size: 100px;
        background-color: #008CBA;
        }
        
         #fileToUp2load.input {width: 500px;
        font-size: 100px;
        background-color: #008CBA;
        }
    </style>
    
<form action="upload.php" method="post" enctype="multipart/form-data" >
    Select image to upload:
    <!--<input type="file" style="width: 400px; height: 400px;" name="fileToUpload" id="fileToUpload">-->
    <input class="fileToUpload" type="file"  width="480" height="480" name="fileToUpload[]" id="fileToUpload"><br>
   <input class="fileToUpload" type="file"  width="480" height="480" name="fileToUpload[]" id="fileToUpload"><br>
   <input type="text" name="p" style="width: 400px; height: 400px;" draggable dropzone>
    <input type="submit" value="Upload Image" name="submit">
</form>

<?php require '../include/footer.php'; ?>
</BODY>
</html>