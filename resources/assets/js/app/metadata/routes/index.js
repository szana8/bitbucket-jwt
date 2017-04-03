import { Metadata, Create } from '../components'

export default [
    {
        path: '/system/metadata',
        component: Metadata,
        name: 'metadata',
        meta: {
            needsAuth: true
        }
    },

    {
        path: '/system/metadata/create',
        component: Create,
        name: 'CreateMetadata',
        meta: {
            needsAuth: true
        }
    },

    {
        path: '/system/metadata/:id/edit',
        component: Create,
        name: 'EditMetadata',
        meta: {
            needsAuth: true
        }
    }
]
