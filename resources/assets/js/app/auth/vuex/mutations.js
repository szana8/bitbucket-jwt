import localforage from 'localforage'
import {isEmpty} from 'lodash'

/**
 *
 * @param state
 * @param token
 */
export const setToken = (state, token) =>
{
    if (isEmpty(token)) {
        localforage.removeItem('authtoken', token)
        return
    }

    localforage.setItem('authtoken', token)
}

/**
 *
 * @param state
 * @param isAuthenticated
 */
export const setAuthenticated = (state, isAuthenticated) =>
{
    state.user.authenticated = isAuthenticated
}

/**
 *
 * @param state
 * @param data
 */
export const setUserData = (state, data) =>
{
    state.user.data = data
}