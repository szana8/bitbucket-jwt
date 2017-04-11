

export const create = ({dispatch}, {payload, context, error}) => {
    return new Promise((resolve, reject) => {
        payload.form.post('/api/v1/locations').then(response => {
            resolve(response)
        }).catch(error => {
            reject(error)
        })
    })
}

export const update = ({dispatch}, {payload, context, error}) => {
    return new Promise((resolve, reject) => {
        payload.form.patch('/api/v1/locations/' + payload.id).then(response => {
            resolve(response)
        }).catch(error => {
            reject(error)
        })
    })
}


export const destroy = ({dispatch}, {id, context, error}) => {
    return new Promise((resolve, reject) => {
        axios.delete('/api/v1/locations/' + id).then(response => {
            resolve(response.data)
        }).catch(error => {
            reject(error)
        })
    })
}