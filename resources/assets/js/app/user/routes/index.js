import { User } from '../components'

export default [
    {
        path: '/user',
        component: User,
        name: 'user',
        meta: {
            needsAuth: true
        }
    }
]
