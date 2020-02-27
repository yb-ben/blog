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
    import * as common from "/js/common.js?v={{ config('view.jsversion') }}";

    window.login =()=> {

        let data = common.getFormData('form1');
        common.httpUtil.apiRequest('/admin/login/loginPwd', data,'post')
            .then((res)=>{

                common.redirect('/admin/index.html');
            }).catch(res=>{
                console.log(res.msg);
            });
    }

</script>

@endsection

