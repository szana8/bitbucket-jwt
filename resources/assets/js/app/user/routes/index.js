import { User } from '../components'

export default [
    {
        path: '/system/user',
        component: User,
        name: 'user',
        meta: {
            needsAuth: true
        }
    }
]
