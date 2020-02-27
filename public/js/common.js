


let MyAxios = function(){

};
MyAxios.prototype =  axios.create();
MyAxios.prototype.defaults.headers.post['Content-Type'] = 'application/json';
MyAxios.prototype.defaults.headers.post['Accept'] = 'application/json';

MyAxios.prototype.httpGet = function(url,params = {}){
    return this.get(url,params);
};

MyAxios.prototype.httpPost = function(url,params = {}){
    return this.post(url,params);
};




MyAxios.prototype.getTpl = function(elem,url,params = {}){

    this.get(url, params).then(function (resp) {
        elem.html(resp);
        history.pushState({},'','#'+url);
    }).catch(function (error) {
        alert('404 NotFound !');
    });
};
MyAxios.prototype.apiRequest = function(url,data = {} , method= 'get'){

    return this.request({
        method:method,
        url:url,
        data:data,
    }).then(function(resp){
        console.log(resp);
        if(resp.data &&  resp.data.code === 0){
            return resp.data;
        }
        return Promise.reject(resp);
    });
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

const httpUtil = new MyAxios();
export {httpUtil,redirect,getFormData,queryString};
