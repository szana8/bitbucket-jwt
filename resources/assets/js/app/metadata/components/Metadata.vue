<template>
    <v-container fluid="fluid">
        <v-row class="mt-5">
            <v-col xs12="xs12">
                <table>
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Key</th>
                            <th>Value</th>
                            <th>Description</th>
                            <th>Enabled</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <template v-for="item in metadata">
                        <tr>
                            <td v-text="item.type"></td>
                            <td v-text="item.key"></td>
                            <td v-text="item.value"></td>
                            <td v-text="item.description"></td>
                            <td v-text="item.enabled"></td>
                            <td>
                                <v-btn icon="icon">
                                    <v-icon class="info--text">edit</v-icon>
                                    <v-icon class="red--text">delete</v-icon>
                                </v-btn>
                            </td>
                        </tr>
                    </template>
                    </tbody>
                </table>
            </v-col>
        </v-row>
        <v-row>
            <v-col xs4="xs4" class="mt-3">
                <v-pagination v-bind:length.number="total_pages" v-model="current_page" />
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import { mapActions } from 'vuex'

    export default {

        data() {
            return {
                metadata: null,
                pagination: null,
                total_pages: null,
                current_page: null,
                axiosPagination: {
                    search: null,
                    page  : null
                }
            }
        },

        mounted () {
            axios.get('/api/v1/metadata').then(response => {
                this.metadata = response.data.data
                this.pagination = response.data.pagination
                this.total_pages = response.data.pagination.total_pages
                this.current_page = response.data.pagination.current_page
            })
        },

        watch: {
            current_page: function (newIndex) {
                this.current_page = newIndex
                this.axiosPagination.page = newIndex

                axios.get('/api/v1/metadata', { params: this.axiosPagination }).then(response => {
                    this.metadata = response.data.data
                    this.pagination = response.data.pagination
                    this.total_pages = response.data.pagination.total_pages
                    this.current_page = response.data.pagination.current_page
                })
                // get next page data...
            }
        },

        methods: {
            ...mapActions({
                register: 'metadata'
            })
        }
    }
</script>