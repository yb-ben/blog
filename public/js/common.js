
const httpPost = (url,data)=>{
   return fetch(url,{
       body: JSON.stringify(data,),
       method:'POST',
       headers:{
           'Content-Type':'application/json',
            'Accept':'application/json'
       }
   }).then(response => response.json())
};


const httpGet = (url,data = null)=>{

    if(data){
        url += '?'+ queryString(data);
    }
    return fetch(url ,{
        method:'GET',
    });
};

const getTpl = (elem,url,data = null) =>{

    httpGet(url,data).then((resp)=>{
        return resp.text();
    }).then(resp =>{
        elem.html(resp);
        history.pushState({},'','#'+url)
    }).catch(resp=>{
        alert('404 NotFound !');
    });
};

const apiRequest = (url,data = null , method= 'get') =>{
    let p = null;
    switch (method) {
        case 'get':
            p = httpGet(url,data).then(resp => resp.json());
        break;
    }
    return p.then( resp => {
        if(resp.code !== 0){
            return Promise.reject(resp);
        }
        return Promise.resolve(resp);
    }).catch((resp)=>{
        alert(resp.msg);
    })
};

const getFormData = (formId) => {

    let formData = new FormData(document.getElementById(formId));

    let jsonData = {};
    formData.forEach((value,key)=>{
        jsonData[key] = value;
    });
    return jsonData;
};

const redirect = (url) => {
    window.location.href = url;
};

const queryString = (data) => {
    let s = [];
    data.forEach((value, key) => {
        s.push( key + '=' + value);
    });
    return s.join('&');
};


export  {httpGet,httpPost,getFormData,redirect,getTpl,apiRequest};
