import {setHttpToken} from '../../../helpers'

export const register = ({ dispatch }, { payload }) => {
    payload.form.post('/api/v1/users').then(data => {
        console.log(data)
    }).catch(error => {
        console.log(error)
    });
}

export const login = ({ dispatch }, { payload }) => {
    payload.form.post('/api/v1/authentication/database/login').then(data => {
        console.log(data)
        dispatch('setToken', data.meta.token).then(() => {
            dispatch('fetchUser')
        })

    }).catch(error => {
        console.log(error)
    });
}

export const fetchUser = ({ commit }) => {
    var form = new Form()

    return form.get('/api/v1/authentication/getUserByToken').then(response => {
        commit('setAuthenticated', true)
        commit('setUserData', response.data)
    }).catch(error => {
        console.log(error)
    })
}

export const setToken = ({ commit, dispatch }, token) => {
    commit('setToken', token);
    setHttpToken(token)
}