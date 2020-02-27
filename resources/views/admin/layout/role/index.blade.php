@extends('admin.common.treeview')
<div class="container">

    <div id="role-index-list-div">

    </div>
</div>
<script type="module">
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
