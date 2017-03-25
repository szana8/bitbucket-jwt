import { Metadata } from '../components'

export default [
    {
        path: '/metadata',
        component: Metadata,
        name: 'metadata',
        meta: {
            guest: false,
            needsAuth: true
        }
    }
]
