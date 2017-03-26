<template>
    <p>{{ index }}</p>
</template>

<script>
    export default {

        data() {
            return {
                index: null
            }
        },

        mounted () {
            axios.get('/api/v1/metadata').then(response => {
                this.index = response.data
            })
        }
    }
</script>