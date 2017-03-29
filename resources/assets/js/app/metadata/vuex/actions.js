

export const create = ({dispatch}, {payload, context, error}) => {
    return new Promise((resolve, reject) => {
        payload.form.post('/api/v1/metadata').then(response => {
            resolve(response)
        }).catch(error => {
            reject(error)
        })
    })
}