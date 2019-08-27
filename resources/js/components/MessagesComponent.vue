<template>
    <div class="card">
        <div class="card-header"> Utilisateur</div>
        <div class="card-body">
            <Message :message="message" v-for="message in messages" :user="user"/>
        </div>
    </div>


    <form action="" method="POST">
        <div class="form-group">
            <textarea name="content" v-model="content" placeholder="Ecrivez votre message" class="form-control" @keypress.enter="sendMessage"></textarea>
            <div class="invalid-feedback">
                Une erreur
            </div>
        </div>
    </form>


</template>


<script>
import Message from './MessageComponent'
import {mapGetters} from 'vuex'

export default {
    components: {Message},
    data() {
        return {
            content: ''
        }
    },
    computed: {
        ...mapGetters(['user']),
        messages: function() {
            return this.$store.getters.messages(this.$route.params.id)
        }
    },
    mounted (){
        this.$store.dispatch('loadMessages', this.$route.params.id)
    },
    watch: {
        '$route.params.id': function () {
            this.loadMessages()
        }
    },
    methods: {
        loadMessages () {
            this.$store.dispatch('loadMessages', this.$route.params.id)
        },
        sendMessage (e) {
            if (e.shiftKey === false) {
                this.$store.dispatch('sendMessage', {
                    content: this.content, 
                    userId: $route.params.id,
                })
            }
        }
    }
}
</script>
