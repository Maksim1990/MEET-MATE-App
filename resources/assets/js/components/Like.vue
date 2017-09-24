<template>
    <div>
        <hr>
        <p class="text-center" v-for="like in post.likes">
            <img v-if="like.user.photo!=null" :src="like.user.photo.path" alt="" width="40px" height="40px" class="avatar-like">
            <img v-else src="/images/noimage.png" alt="" width="40px" height="40px" class="avatar-like">

        </p>
        <hr>
        <button class="btn btn-primary btn-xs" v-if="!auth_user_likes_post" @click="like()">
            Like this post
        </button>
        <button class="btn btn-danger btn-xs" v-else @click="unlike()">
            Unlike this post
        </button>
    </div>
</template>

<script>
    export default {
        mounted() {

        },
        props: ['id'],
        computed: {
            likers() {
                var likers = []

                this.post.likes.forEach( (like) => {
                    likers.push(like.user.id)
            })

                return likers
            },
            auth_user_likes_post() {
                var check_index = this.likers.indexOf(
                        this.$store.state.auth_user.id
                )

                if (check_index === -1)
                    return false
                else
                    return true
            },
            post() {
                return this.$store.state.posts.find( (post) => {
                            return post.id === this.id
                        })
            }
        },
        methods: {
            like() {
                this.$http.get('/like/' + this.id)
                        .then( (resp) => {
                    this.$store.commit('update_post_likes', {
                    id: this.id,
                    like: resp.body
                })

                new Noty({
                    type: 'success',
                    layout: 'bottomLeft',
                    text: 'You like this post!'

                }).show();
            })
            },
            unlike() {
                this.$http.get('/unlike/' + this.id)
                        .then( (response) => {

                    this.$store.commit('unlike_post', {
                    post_id: this.id,
                    like_id: response.body
                })

                new Noty({
                    type: 'success',
                    layout: 'bottomLeft',
                    text: 'You unlike this post!'

                }).show();
            })
            }

        }
    }
</script>


<style>
    .avatar-like{
        border-radius: 50%;
    }
</style>