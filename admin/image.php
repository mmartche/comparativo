<!DOCTYPE html>
<html>
<head>
<title>Image Preview</title>
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<style type="text/css">
    * {
        box-sizing: border-box;
        position: relative;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
    }
 
    body {
        background:#fff;
        font-family:helvetica, arial, sans-serif;
        color:#222;
        font-size:16px;
    }
 
    form {
        margin:3em;
    }
 
    form div.row {
        width:400px;
        padding:1em;
        overflow:hidden;
        background:#ededed;
        border-radius:0.5em;
        -moz-border-radius:0.5em;
        -webkit-border-radius:0.5em;
    }
 
    form div.file-preview {
        background:#ccc;
        border:5px solid #fff;
        box-shadow:0 0 4px rgba(0, 0, 0, 0.5);
        -moz-box-shadow:0 0 4px rgba(0, 0, 0, 0.5);
        -webkit-box-shadow:0 0 4px rgba(0, 0, 0, 0.5);
        display:inline-block;
        float:left;
        margin-right:1em;
        width:60px;
        height:60px;
        text-align:center;
    }
 
    form div.row label {
        font-weight:bold;
        display:block;
        margin-bottom:0.25em;
    }
</style>
</head>
<body>
<form action="blah" method="post" enctype="multipart/form-data">
    <h1>Upload Image Preview</h1>
    <p>Here's a little demo of how to display a small, cropped thumbnail preview on image uploads.</p>
    <div class="row">
        <div class="file-preview"></div>
        <label for="file-input">Select a File:</label>
        <input id="file-input" type="file" name="file">
    </div>
</form>
 
<script type="text/javascript">
    $('input[type=file]').change(function(e) {
        if(typeof FileReader == "undefined") return true;
 
        var elem = $(this);
        var files = e.target.files;
 
        for (var i = 0, f; f = files[i]; i++) {
            if (f.type.match('image.*')) {
                var reader = new FileReader();
                reader.onload = (function(theFile) {
                    return function(e) {
                        var image = e.target.result;
                        previewDiv = $('.file-preview', elem.parent());
                        bg_width = previewDiv.width() * 2;
                        previewDiv.css({
                            "background-size":bg_width + "px, auto",
                            "background-position":"50%, 50%",
                            "background-image":"url("+image+")",
                        });
                    };
                })(f);
                reader.readAsDataURL(f);
            }
        }
    });
</script>
</body>
</html>