import { Authorization } from '../components'

export default [

    {
        path: '/authorization',
        component: Authorization,
        name: 'authorization',
        namespace: 'setting',
        meta: {
            needsAuth: true
        }
    },

]