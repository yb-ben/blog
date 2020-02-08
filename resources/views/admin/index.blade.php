@extends('admin.common.base')

<style>
    #nav{
        left:0;right:0;top:0;position: fixed;z-index:1037;
        background-color: #1b6d85;
        margin-left: 250px;
        height: 50px;
    }
    #aside{
        bottom: 0;float: none;left:0;position: fixed;top:0;min-height: 100%;
        box-shadow: 0 14px 28px rgba(0,0,0,.25),0 10px 10px rgba(0,0,0,.22)!important;
        background-color: #343a40;
        width:250px;
        padding-top:50px;
    }
    #content{
        padding-left: 250px;padding-top:50px;background-color: white;width:100%;height: 100%;
    }
    .aside-item{
        color:white;
        font-size: 30px;
        line-height: 50px;
        padding-left: 20px ;
    }
    .aside-item:hover{
        background-color: #2b669a;
    }

    .aside-item-selected{
        background-color: #2b669a;
    }
</style>
@section('content')

<div class="">
    <nav id="nav">

    </nav>
    <aside id="aside">

        <div class="aside-item" data-url="/admin/layout/index/index.html">首页</div>
        <div class="aside-item" data-url="/admin/layout/admin/index.html">用户列表</div>
        <div class="aside-item" data-url="/admin/layout/role/index.html">角色列表</div>
    </aside>
    <div id="content"></div>
</div>

@endsection


@section('footer')

<script type="module">
    import * as common from "/js/common.js?v={{ config('view.jsversion') }}";

    $('.aside-item').on('click',function(){
        let n = $(this);
        if(n.hasClass('aside-item-selected')){
            return;
        }
        $('.aside-item-selected').removeClass('aside-item-selected');
        n.addClass('aside-item-selected');
        common.getTpl($('#content'),n.attr('data-url'));
    });

    let a = window.location.href;
    let s = a.substr(a.indexOf('#')+1);
    $('aside div[data-url="'+ s +'"').click();




</script>

@endsection
