import { Authorization } from '../components'

export default [

    {
        path: '/system/authorization',
        component: Authorization,
        name: 'authorization',
        namespace: 'setting',
        meta: {
            needsAuth: true
        }
    },

]