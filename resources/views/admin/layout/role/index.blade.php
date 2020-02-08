@extends('admin.common.treeview')
<div class="container">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>角色名</th>
            <th>描述</th>
            <th>路径</th>

        </tr>
        </thead>
        <tbody  id="role-index-list-tbody">

        </tbody>
    </table>
    <div id="role-index-list-div">

    </div>
</div>
<script type="module">
    import * as common from "/js/common.js?v={{ config('view.jsversion') }}";
    let mod = {
        data : null,

        getRoleList :function(){
           return common.apiRequest(myRoute.role.list.url).then((resp)=>{
                this.data = resp;
            });
        },
        render : function(elem){
            console.log(this.data);
           // elem.treeview({data:this.data.data});

            elem.treeview({data:this.data.data});
        }
    };


    mod.getRoleList().then(function(resp){
        mod.render($('#role-index-list-div'));
    });
    window.mod = mod;
</script>
