<div class="container">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Username</th>
            <th>created_at</th>
            <th>updated_at</th>

        </tr>
        </thead>
        <tbody  id="admin-index-list-tbody">

        </tbody>
    </table>
</div>
<script type="module">
    let mod = {
        data : null,

        getAdminList :function(){
           return common.apiRequest(myRoute.admin.list.url).then((resp)=>{

                this.data = resp;
            });

        },
        render : function(elem){
            let html = '';
            console.log(this);
            for(let v of this.data.data){
               html += '<tr><td>'+ v.id +'</td><td>'+ v.usn
                   +'</td><td>'+ v.created_at
                   +'</td><td>'+ v.updated_at + '</td></tr>';
            }
            elem.html(html);
        }
    };


    mod.getAdminList().then(function(resp){
        mod.render($('#admin-index-list-tbody'));
    });
    window.mod = mod;
</script>
