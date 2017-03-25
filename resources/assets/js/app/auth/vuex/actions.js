export const register = ({ dispatch }, { payload }) => {
    return axios.post('/api/v1/users', payload).then(response => {
                console.log(response)
            }).catch(error => {
                console.error(error);
            })
}