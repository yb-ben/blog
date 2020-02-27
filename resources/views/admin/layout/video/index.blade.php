<link href="/lib/webuploader/webuploader.css" type="text/css" rel="stylesheet">
<script src="/lib/webuploader/webuploader.min.js"></script>


<div id="uploader" class="wu-example">
    <!--用来存放文件信息-->
    <div id="thelist" class="uploader-list"></div>
    <div class="btns">
        <div id="picker">选择文件</div>
        <button id="ctlBtn" class="btn btn-default">开始上传</button>
        <button id="ctlBtnRetry" class="btn btn-default">重新上传</button>
    </div>
</div>
<script>
    let shardSize = 30 * 1024 * 1024;//30M

    WebUploader.Uploader.register(
        {
            'add-file':'addFile',
            'before-send-file':'beforeSendFile',
            'before-send':'beforeSend',
            'after-send-file':'afterSendFile',
        },{
            addFile:function(files){
                console.log(files);
            },
            beforeSendFile: function (file) {
                console.log(file);
            },
            beforeSend:function (block) {

                console.log(block);
                var defered = WebUploader.Deferred();
                common.httpPost('/admin/test/check',{'chunks':block.chunks,'md5Value':block.file.md5Value,'size':block.blob.size ,'chunk':block.chunk})
                    .then(function (resp) {
                        console.log(resp);
                        if(resp.code === 40000){
                            defered.reject();
                        }else{
                            defered.resolve();
                        }

                    });
                return defered.promise();
            },
            afterSendFile:function (file) {
                console.log(file);
                var defered = WebUploader.Deferred();
                common.httpPost('/admin/test/mergeChunk',{'md5Value':file.md5Value,'size':file.size})
                    .then(function (resp) {
                        console.log(resp);
                        if(resp.code === 40000){
                            defered.reject();
                        }else{
                            defered.resolve();
                        }
                    });
                return defered.promise();
            }
        });

    var uploader = WebUploader.create({

        // swf文件路径
        swf:   'http://blog/lib/webuploader/Uploader.swf',

        // 文件接收服务端。
        server: 'http://blog/admin/test/_chunkUpload?XDEBUG_SESSION_START=PHPSTORM',

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#picker',

        // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
        resize: false,
        chunked:true,
        threads: 3,

    });

    // 当有文件被添加进队列的时候
    uploader.on( 'fileQueued', function( file ) {
        uploader.md5File(file).progress(function(percentage) {
            console.log('Percentage:', percentage);
        }).then(function(val) {
            console.log('md5 result:', val);
            file.md5Value = val;

            console.log(file);

            $('#thelist').append( '<div id="' + file.id + '" class="item">' +
                '<h4 class="info">' + file.name + '</h4>' +
                '<p class="state">等待上传...</p>' +
                '</div>' );
        });
    });

    // 文件上传过程中创建进度条实时显示。
    uploader.on( 'uploadProgress', function( file, percentage ) {
        var $li = $( '#'+file.id ),
            $percent = $li.find('.progress .progress-bar');

        // 避免重复创建
        if ( !$percent.length ) {
            $percent = $('<div class="progress progress-striped active">' +
                '<div class="progress-bar" role="progressbar" style="width: 0%">' +
                '</div>' +
                '</div>').appendTo( $li ).find('.progress-bar');
        }

        $li.find('p.state').text('上传中');

        $percent.css( 'width', percentage * 100 + '%' );
    });

    uploader.on( 'uploadSuccess', function( file ) {
        console.log(file);
        $( '#'+file.id ).find('p.state').text('已上传');
    });

    uploader.on('uploadBeforeSend', function (object,ret) {

        console.log(ret);
        ret.md5Value = object.file.md5Value;
    });

    uploader.on('uploadAccept', function (obj,ret) {
        console.log(obj,ret);
    });
    uploader.on( 'uploadError', function( file ) {
        console.log(file);
        $( '#'+file.id ).find('p.state').text('上传出错');
    });

    uploader.on( 'uploadComplete', function( file ) {
        $( '#'+file.id ).find('.progress').fadeOut();
        $('#ctlBtnRetry').on('click',function () {
            uploader.upload(file);
        })
    });
    uploader.on('error', function (type) {
        console.log(type);
    });

    $('#ctlBtn').on('click', function () {
        uploader.upload();
    });

</script>
