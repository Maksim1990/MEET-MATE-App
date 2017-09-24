
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('chat-log', require('./components/ChatLog'));
Vue.component('chat-composer', require('./components/ChatComposer'));
Vue.component('chat-message', require('./components/ChatMessage.vue'));
Vue.component('friend', require('./components/Friend.vue'));
Vue.component('notification', require('./components/Notification.vue'));
Vue.component('unread-note', require('./components/UnreadNot.vue'));
Vue.component('post', require('./components/Post.vue'));
Vue.component('feed', require('./components/Feed.vue'));
Vue.component('like', require('./components/Like.vue'));
Vue.component('init', require('./components/Init.vue'));
Vue.component('search', require('./components/Search.vue'));
Vue.component('example', require('./components/Example.vue'));

import { store } from './store';
var today = new Date();
var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
var dateTime = date+' '+time;
Vue.http.options.emulateJSON = true;
const app = new Vue({
    el: '#app',
    store,
    data:{
        messages:[
        ],
        usersInChat:[],
        noImage: null
    },
    methods:{
        addMessage(message){
           this.messages.push(message);
            axios.post('/messages',message);

            
        }
    },
    created(){
        axios.get('/messages').then(response=>{
            
            this.messages=response.data;
    });
        Echo.join('chatroom')
            .here((users)=>{
                this.usersInChat=users;
            })
            .joining((users)=>{
                this.usersInChat.push(users);
            })
            .leaving((users)=>{
                this.usersInChat=this.usersInChat.filter(u=> u!=users);
            })
            .listen('MessageSent', (e)=>{
                
               this.messages.push({
                   message:e.message.message,
                   user:e.user,
                   path:e.message.path,
                   created_at:dateTime
               });
                console.log(this.messages);
        });

    }
});
