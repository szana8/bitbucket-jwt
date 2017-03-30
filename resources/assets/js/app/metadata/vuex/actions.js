

export const create = ({dispatch}, {payload, context, error}) => {
    return new Promise((resolve, reject) => {
        payload.form.post('/api/v1/metadata').then(response => {
            resolve(response)
        }).catch(error => {
            reject(error)
        })
    })
}

export const edit = ({dispatch}, {payload, context, error}) => {
    return new Promise((resolve, reject) => {
        axios.get('api/v1/metadata/' + payload.id).then(response => {
            resolve(response)
        }).catch(error => {
            reject(error)
        })
    })
}

export const update = ({dispatch}, {payload, context, error}) => {
    return new Promise((resolve, reject) => {
        payload.form.patch('/api/v1/metadata/' + payload.id).then(response => {
            resolve(response)
        }).catch(error => {
            reject(error)
        })
    })
}
