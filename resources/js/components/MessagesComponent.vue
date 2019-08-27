<template>
    <div class="card">
        <div class="card-header"> Utilisateur</div>
        <div class="card-body">
            Mes messages
        </div>
    </div>
</template>

<script>
export default {
    mounted (){
        this.$store.dispatch('loadMessaages', this.$route.paarams.id)
    }
}
</script>
