<template>
    <div class="chat-message" v-bind:class="classMessage">
        <p>{{message.message}}</p>

        <small v-if="message.path!=noImage"><img  height="40" v-bind:src="message.path"  alt=""></small>
        <small v-if="message.path==noImage"><img  height="40" src="/images/noimage.png"  alt=""></small>

        <small>{{message.user.name}} || {{message.created_at}}</small>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                currentUserId:$('#loggedName span').data('userid')
            }
        },
        computed: {
            classMessage: function () {
                if(this.currentUserId==this.message.user.id){
                    return {

                        'messageRight':'w3-display-right'
                    }
                }

            }
        },
      props:['message','noImage']


    }
</script>
<style>
</style>