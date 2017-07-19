<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>文件上传</title>
</head>
<body>
<form action="/test/upload/images" method="post" enctype="multipart/form-data">
{{csrf_field()}}
<input name="file1" type="file"><br>
<input name="file2" type="file"><br>
<input name="file3" type="file"><br>
<input name="file4" type="file"><br>
<input  type="submit"><br>
</form>
</body>
</html>