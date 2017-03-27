import {isEmpty} from 'lodash'
import {setHttpToken} from '../../../helpers'
import localforage from 'localforage'
import reouter from '../../../router'

/**
 * Register the user than login with the given credentials and redirect to the home page
 * @param dispatch
 * @param payload
 */
export const register = ({dispatch}, {payload}) =>
{
    payload.form.post('/api/v1/users').then(data =>
    {
        console.log(data)
    }).catch(error =>
    {
        console.log(error)
    });
}


/**
 * Login the user with the given credentials
 * @param dispatch
 * @param payload
 */
export const login = ({dispatch}, {payload, context, error}) =>
{
    return new Promise((resolve, reject) => {
        payload.form.post('/api/v1/authentication/database/login').then(data =>
        {
            dispatch('setToken', data.meta.token).then(() =>
            {
                dispatch('fetchUser')
            })

            resolve()

        }).catch(error => {
            reject(error)
        })
    });

}


/**
 * Fetch the user data by the token
 * @param commit
 */
export const fetchUser = ({commit}) =>
{
    var form = new Form()

    return form.get('/api/v1/authentication/getUserByToken').then(response =>
    {
        commit('setAuthenticated', true)
        commit('setUserData', response.data)
    })
}


/**
 * Logout the user
 * @param dispatch
 */
export const logout = ({dispatch}) =>
{
    var form = new Form()

    return form.get('/api/v1/authentication/logout').then(response =>
    {
        dispatch('clearAuth')
    })
}


/**
 * Set the token to the localforge
 * @param commit
 * @param dispatch
 * @param token
 */
export const setToken = ({commit, dispatch}, token) =>
{
    if (isEmpty(token)) {
        return dispatch('checkTokenExists').then((token) =>
        {
            setHttpToken(token)
        })
    }

    commit('setToken', token);
    setHttpToken(token)
}


/**
 *
 * @param commit
 * @param dispatch
 * @param token
 */
export const checkTokenExists = ({commit, dispatch}, token) =>
{
    return localforage.getItem('authtoken').then((token) =>
    {
        if (isEmpty(token)) {
            return Promise.reject('NO_STORAGE_TOKEN');
        }

        return Promise.resolve(token)
    })
}


/**
 *
 * @param commit
 * @param token
 */
export const clearAuth = ({commit}, token) =>
{
    commit('setAuthenticated', false)
    commit('setUserData', null)
    commit('setToken', null)
    setHttpToken(null)
}