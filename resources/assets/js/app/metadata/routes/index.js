import { Metadata, Create } from '../components'

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
        path: '/metadata/create',
        component: Create,
        name: 'CreateMetadata',
        meta: {
            needsAuth: true
        }
    }
]
