<template>

        <div>
            <p  v-if="loading">
                Loading...
            </p>
            <p>
                <span class="text-success" v-if="status=='friends'">You are friend with this user</span>
                <span class="text-success" v-if="status=='waiting'">Friend request is sent</span>
                <button class="btn btn-success" v-if="status==0" @click="add_friend">Add Friend</button>
                <button class="btn btn-success" v-if="status=='pending'" @click="accept_friend">Accept Friend</button>

            </p>

    </div>
</template>

<script>
    export default {
        mounted() {
            this.$http.get('/check_relationship_status/'+ this.current_user_id)
                    .then((responce)=>{
                console.log(responce);
            this.status=responce.body.status;
            this.loading=false;
            })
        },
        props:['current_user_id'],
        data(){
            return {
                status: '',
                loading: true
            }
        },
        methods:{
            add_friend(){
                this.loading=true
                this.$http.get('/add_friend/'+ this.current_user_id)
                        .then((responce)=>{
                    if(responce.body==1)
                new Noty({
                    type: 'success',
                    layout: 'bottomLeft',
                    text: 'Friend request sent!'

                }).show();
                this.status='waiting'
                this.loading=false
            })
            },
            accept_friend(){
                this.loading=true
                this.$http.get('/accept_friend/'+ this.current_user_id)
                        .then((responce)=>{
                    if(responce.body==1)
                new Noty({
                    type: 'success',
                    layout: 'bottomLeft',
                    text: 'Friend request accepted!'

                }).show();
                this.status='friends'
                this.loading=false
                                         })
                            }
            }

    }
</script>
