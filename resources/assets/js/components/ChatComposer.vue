<template>
    <div class="chat-composer">
<input type="text" placeholder="Start type your message" v-model="messageText" @keyup.enter="sendMessage">
        <button class="btn btn-success" @click="sendMessage">Send</button>
    </div>
</template>

<script>
    var today = new Date();
    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    var dateTime = date+' '+time;
    export default {
        data(){
        return{
            messageText:''
        }
        },
        methods:{
            sendMessage(){
                this.$emit('messagesent',{
                   message: this.messageText,
                    created_at:dateTime,
                    user:{name:$('#loggedName span').text()},
                    path:$('#loggedName img').data('imagepath')
                });
                this.messageText='';
            }
        }
    }
</script>
<style lang="css">
    .chat-composer{
        display:flex;
    }
    .chat-composer input {
        flex:1 auto;
    }
</style>