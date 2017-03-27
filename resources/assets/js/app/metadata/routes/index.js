import { Metadata } from '../components'

export default [
    {
        path: '/metadata',
        component: Metadata,
        name: 'metadata',
        meta: {
            needsAuth: true
        }
    },
    {
        path: '/metadata/:page',
        component: Metadata,
        name: 'metadataPage',
        meta: {
            needsAuth: true
        }
    }
]
