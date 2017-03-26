import localforage from 'localforage'


export const setToken = (state, token) => {
    //check empty and remove token
    if (! token)
    {
        localforage.removeItem('authtoken', token)
    }

    localforage.setItem('authtoken', token)
}

export const setAuthenticated = (state, trueOrFalse) => {
    state.user.authenticated = trueOrFalse
}

export const setUserData = (state, userdata) => {
    console.log(userdata)
    state.user.data = userdata
}