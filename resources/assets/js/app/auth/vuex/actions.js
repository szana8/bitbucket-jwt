import { isEmpty } from 'lodash'
import {setHttpToken} from '../../../helpers'
import localforage from 'localforage'
import reouter from '../../../router'

export const register = ({ dispatch }, { payload }) => {
    payload.form.post('/api/v1/users').then(data => {
        console.log(data)
    }).catch(error => {
        console.log(error)
    });
}

export const login = ({ dispatch }, { payload }) => {
    payload.form.post('/api/v1/authentication/database/login').then(data => {
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
    })
}

export const logout = ({ dispatch }) => {
    var form = new Form()

    return form.get('/api/v1/authentication/logout').then(response => {
        dispatch('clearAuth')
    })
}

export const setToken = ({ commit, dispatch }, token) => {
    if (isEmpty(token))
    {
        return dispatch('checkTokenExists').then((token) => {
            setHttpToken(token)
        })
    }
    commit('setToken', token);
    setHttpToken(token)
}

export const checkTokenExists = ({ commit, dispatch }, token) => {
    return localforage.getItem('authtoken').then((token) => {
        if (isEmpty(token)) {
            return Promise.reject('NO_STORAGE_TOKEN');
        }

        return Promise.resolve(token)
    })
}

export const clearAuth = ({ commit }, token) => {
    commit('setAuthenticated', false)
    commit('setUserData', null)
    commit('setToken', null)
    setHttpToken(null)
}