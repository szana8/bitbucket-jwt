import { NotFound } from '../components'

export default [
    {
        path: '*',
        component: NotFound,
        name: 'notfound',
        meta: {
            needsAuth: false
        }
    }
]
