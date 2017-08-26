$(function() {
    // 文件上传
    $("#file_upload").uploadifive({
        'uploadScript': SCOPE.uploadScript,
        'buttonText': '上传FLASH',
        'fileType': 'Flash files',
        'fileObjName': 'file',
        'fileTypeExts': '*swf;',
        'onUploadComplete': function(file, data, response) {
            var obj = JSON.parse(data);
            if (obj.code == 1) {
                $("#file_upload_swf").attr("value", obj.data);
            }
        },
        onCancel: function(file) {
            if (file) {
                $("#file_upload_swf").attr("value", '');
            }
        }
    });
});
