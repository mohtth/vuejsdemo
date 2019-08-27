<template>
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a class="list-group-item d-flex justify-content-between align-items-center">
                    UtilisateurNum  {{ user }}
                    <span class="badge badge-pill badge-primary">
                            0
                    </span>
                </a>
            </div>
            {{ conversations }}
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'
    export default {
        props: {
            user: Number
        },
        computed: {
            ...mapGetters(['conversations'])
        },
        mounted() {
            this.$store.dispatch('loadConversations')
        }
    }
</script>
