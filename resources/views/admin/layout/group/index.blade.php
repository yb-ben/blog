@extends('admin.common.treeview')
<div class="container">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>组名</th>
            <th>描述</th>
        </tr>
        </thead>
        <tbody  id="group-index-list-tbody">

        </tbody>
    </table>
</div>
<script type="module">
    import * as common from "/js/common.js?v={{ config('view.jsversion') }}";
    let mod = {
        data : null,

        getRoleList :function(){
            return common.apiRequest(myRoute.group.list.url).then((resp)=>{

                this.data = resp;
            });

        },
        render : function(elem){
            // let html = '';
            // console.log(this);
            // for(let v of this.data.data){
            //    html += '<tr><td>'+ v.id +'</td><td>'+ v.name
            //        +'</td><td>'+ v.desc
            //        +'</td><td>'+ v.path + '</td></tr>';
            // }
            // elem.html(html);
            elem.treeview({data:})
        }
    };


    mod.getRoleList().then(function(resp){
        mod.render($('#admin-index-list-tbody'));
    });
    window.mod = mod;
</script>
