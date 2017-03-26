export const setHttpToken = (token) => {
    if ( ! token ) {
        window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + null
    }

    window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
}