import { Authorization } from '../components'

export default [

    {
        path: '/authorization',
        component: Authorization,
        name: 'authorization',
        meta: {
            needsAuth: true
        }
    },

]