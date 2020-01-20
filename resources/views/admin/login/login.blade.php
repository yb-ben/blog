@extends('admin.common.base')


@section('content')
    <div class="container">
        <form id="form1">
            <div class="form-group">
                <label>用户名</label>
                <input class="form-control" type="text" id="usn" name="usn">
            </div>
            <div class="form-group">
                <label>密码</label>
                <input class="form-control" type="password" id="password" name="pwd">
            </div>
            <button type="button" class="btn btn-default" onclick="login()">提交</button>
        </form>
    </div>
@endsection

@section('footer')

<script type="module">
    import * as common from "/js/common.js";

    window.login =()=> {

        let data = common.getFormData('form1');

        common.httpPost('/admin/login/loginPwd', data).then(res => {
            console.log(res);
            if(res.code !== 0){
                alert(res.msg);
            }else{
                common.redirect('/admin/index.html');
            }
        });
    }

</script>

@endsection

