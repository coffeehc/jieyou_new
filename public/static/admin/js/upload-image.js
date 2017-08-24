$(function() {
    // 图片上传
    $("#file_upload").uploadifive({
        'uploadScript': SCOPE.uploadScript,
        'buttonText': '图片上传',
        'fileType': 'Image files',
        'fileObjName': 'file',
        'fileTypeExts': '*gif; *.jpg; *.png',
        'onUploadComplete': function(file, data, response) {
            var obj = JSON.parse(data);
            if (obj.code == 1) {
                $("#upload_org_code_img").attr("src", obj.data);
                $("#file_upload_image").attr("value", obj.data);
                $("#upload_org_code_img").show();
            }
        },
        onCancel: function(file) {
            if (file) {
                $("#upload_org_code_img").attr("src", '');
                $("#file_upload_image").attr("value", '');
                $("#upload_org_code_img").hide();
            }
        }
    });

    $("#file_upload_other").uploadifive({
        'uploadScript': SCOPE.uploadScript,
        'buttonText': '图片上传',
        'fileType': 'Image files',
        'fileObjName': 'file',
        'fileTypeExts': '*gif; *.jpg; *.png',
        'onUploadComplete': function(file, data, response) {
            var obj = JSON.parse(data);
            if (obj.code == 1) {
                $("#upload_org_code_img_other").attr("src", obj.data);
                $("#file_upload_image_other").attr("value", obj.data);
                $("#upload_org_code_img_other").show();
            }
        },
        onCancel: function(file) {
            if (file) {
                $("#upload_org_code_img_other").attr("src", '');
                $("#file_upload_image_other").attr("value", '');
                $("#upload_org_code_img_other").hide();
            }
        }
    });

    $("#file_upload_pic2").uploadifive({
        'uploadScript': SCOPE.uploadScript,
        'buttonText': '图片上传',
        'fileType': 'Image files',
        'fileObjName': 'file',
        'fileTypeExts': '*gif; *.jpg; *.png',
        'onUploadComplete': function(file, data, response) {
            var obj = JSON.parse(data);
            if (obj.code == 1) {
                $("#upload_org_code_img_pic2").attr("src", obj.data);
                $("#file_upload_image_pic2").attr("value", obj.data);
                $("#upload_org_code_img_pic2").show();
            }
        },
        onCancel: function(file) {
            if (file) {
                $("#upload_org_code_img_pic2").attr("src", '');
                $("#file_upload_image_pic2").attr("value", '');
                $("#upload_org_code_img_pic2").hide();
            }
        }
    });

    $("#file_upload_pic3").uploadifive({
        'uploadScript': SCOPE.uploadScript,
        'buttonText': '图片上传',
        'fileType': 'Image files',
        'fileObjName': 'file',
        'fileTypeExts': '*gif; *.jpg; *.png',
        'onUploadComplete': function(file, data, response) {
            var obj = JSON.parse(data);
            if (obj.code == 1) {
                $("#upload_org_code_img_pic3").attr("src", obj.data);
                $("#file_upload_image_pic3").attr("value", obj.data);
                $("#upload_org_code_img_pic3").show();
            }
        },
        onCancel: function(file) {
            if (file) {
                $("#upload_org_code_img_pic3").attr("src", '');
                $("#file_upload_image_pic3").attr("value", '');
                $("#upload_org_code_img_pic3").hide();
            }
        }
    });

    $("#file_upload_pic4").uploadifive({
        'uploadScript': SCOPE.uploadScript,
        'buttonText': '图片上传',
        'fileType': 'Image files',
        'fileObjName': 'file',
        'fileTypeExts': '*gif; *.jpg; *.png',
        'onUploadComplete': function(file, data, response) {
            var obj = JSON.parse(data);
            if (obj.code == 1) {
                $("#upload_org_code_img_pic4").attr("src", obj.data);
                $("#file_upload_image_pic4").attr("value", obj.data);
                $("#upload_org_code_img_pic4").show();
            }
        },
        onCancel: function(file) {
            if (file) {
                $("#upload_org_code_img_pic4").attr("src", '');
                $("#file_upload_image_pic4").attr("value", '');
                $("#upload_org_code_img_pic4").hide();
            }
        }
    });

    $("#file_upload_picmax").uploadifive({
        'uploadScript': SCOPE.uploadScript,
        'buttonText': '图片上传',
        'fileType': 'Image files',
        'fileObjName': 'file',
        'fileTypeExts': '*gif; *.jpg; *.png',
        'onUploadComplete': function(file, data, response) {
            var obj = JSON.parse(data);
            if (obj.code == 1) {
                $("#upload_org_code_img_picmax").attr("src", obj.data);
                $("#file_upload_image_picmax").attr("value", obj.data);
                $("#upload_org_code_img_picmax").show();
            }
        },
        onCancel: function(file) {
            if (file) {
                $("#upload_org_code_img_picmax").attr("src", '');
                $("#file_upload_image_picmax").attr("value", '');
                $("#upload_org_code_img_picmax").hide();
            }
        }
    });
});
