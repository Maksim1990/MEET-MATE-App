<template>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <input type="text" class="form-control" placeholder="search for other users" v-model="query" @keyup.enter="search()">
                <br>
                <div class="row" v-if="results.length">
                    <div class="text-center" v-for="user in results">
                        <img v-if="user.photo!=null" :src="user.photo.path" alt="" width="50px" height="50px" class="searched-user">
                        <img v-else src="/images/noimage.png" alt="" width="50px" height="50px" class="searched-user">
                        <a :href="url+user.id">
                            <h4 class="text-center">{{ user.name }}</h4>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    var algoliasearch = require('algoliasearch')

    var client = algoliasearch('VKAQASH4DZ', 'afd6ec04e124d1c9b3b471ae161f075e')

    var index = client.initIndex('users')

    export default {
        mounted() {

        },
        data() {
            return {
                query: '',
                url: 'users/',
                results: []
            }
        },
        methods: {
            search() {
                index.search(this.query, (err, content) => {
                    console.log(content.hits);
                    this.results = content.hits
            })
            }
        },
        computed: {

        }
    }
</script>

<style>
    .searched-user{
        border-radius: 50%;
    }
</style>