@extends('admin.common.base')

@section('css')
<link rel="stylesheet" type="text/css" href="/lib/left-side/css/left-side-menu.css">
<link rel="stylesheet" type="text/css" href="/lib/left-side/font/iconfont.css">
<style>
    #nav{
        left:0;right:0;top:0;
        background-color: #1b6d85;

        height: 65px;
    }

    #content{
       background-color: white;width:100%;height: calc(100% - 65px);
    }
    .pl220{
        padding-left: 220px;
    }
    .left-side-menu{
        height: 100%;
        overflow:hidden;
        float:left;
    }
    .lsm-scroll,.lsm-sidebar{
        height: 100%;
    }
    .lsm-sidebar-item li>a:hover, .lsm-popup>div>ul>li>a:hover{
        background-color: #c55b03;
    }


</style>
@endsection

@section('js')
<script src="/lib/left-side/js/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="/lib/left-side/js/left-side-menu.js"></script>

<script type="module">
    import * as common from "/js/common.js?v={{ config('view.jsversion') }}";
    if(!window.common){
        window.common = common;
    }
</script>
@endsection



@section('content')



    <div class="left-side-menu" >
        <div class="lsm-expand-btn">
            <div class="lsm-mini-btn">
                <label>
                    <input type="checkbox" checked="checked">
                    <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="50" cy="50" r="30" />
                        <path class="line--1" d="M0 40h62c18 0 18-20-17 5L31 55" />
                        <path class="line--2" d="M0 50h80" />
                        <path class="line--3" d="M0 60h62c18 0 18 20-17-5L31 45" />
                    </svg>
                </label>

            </div>

        </div>
        <div class="lsm-container">
            <div class="lsm-scroll" >
                <div class="lsm-sidebar">
                    <ul>
                        <li class="lsm-sidebar-item">
                            <a href="javascript:;"><i class="my-icon lsm-sidebar-icon icon_1"></i><span>系统设置</span><i class="my-icon lsm-sidebar-more"></i></a>
                            <ul>
                                <li ><a href="javascript:;" class="aside-item" data-url="/admin/layout/index/index.html"><span>首页</span></a></li>
                                <li><a href="javascript:;" class="aside-item" data-url="/admin/layout/admin/index.html"><span>用户列表</span></a></li>
                                <li><a href="javascript:;" class="aside-item" data-url="/admin/layout/role/index.html"><span>角色列表</span></a></li>
                                <li><a href="javascript:;"  class="aside-item" data-url="/admin/layout/video/index.html"><span>在线视频</span></a></li>
                                <li class="lsm-sidebar-item">
                                    <a href="javascript:;"><i class="my-icon lsm-sidebar-icon "></i><span>二级菜单11</span><i class="my-icon lsm-sidebar-more"></i></a>
                                    <ul>
                                        <li><a href="javascript:;"><span>地爆天星</span></a></li>
                                        <li><a href="javascript:;"><span>无线月读</span></a></li>
                                        <li><a href="javascript:;"><span>一乐拉面</span></a></li>
                                        <li><a href="javascript:;"><span>血继限界</span></a></li>
                                        <li><a href="javascript:;"><span>秽土转生</span></a></li>
                                    </ul>
                                </li>


                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
    <nav id="nav" class="pl220">

    </nav>
    <div id="content" class="pl220"></div>


@endsection


@section('footer')
<script>
    $(function(){

        $('.aside-item').on('click',function(){
            let n = $(this);
            if(n.hasClass('active')){
                return;
            }
            $('.aside-item.active').removeClass('active');
            n.addClass('active');
            common.getTpl($('#content'),n.attr('data-url'));
        });

        let a = window.location.href;
        let s = a.substr(a.indexOf('#')+1);
        $('aside div[data-url="'+ s +'"').click();

    });
</script>

@endsection
