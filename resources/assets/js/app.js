
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./bootstrap');

//window.Vue = require('vue');

//window.var1 = ['data', 'datamanen'];

// Echo.channel('channelDemoEvent')
//     	.listen('eventTrigger', (e) =>{
//             var fe_receiver_id = localStorage.getItem('fe_userid');
//             var p_receiver_id = e.data.receiver_id;
           
//             if(fe_receiver_id){
//                if(fe_receiver_id == p_receiver_id){
//                    console.log(fe_receiver_id,p_receiver_id)
//                  $("#inputList").val(JSON.stringify(e)).trigger('input');
//                }     
//             }
// });
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));

// const app = new Vue({
//     el: '#app'
// });


import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'b0267c27e1d7664447f9',
    cluster: 'ap1',
    encrypted: true
});