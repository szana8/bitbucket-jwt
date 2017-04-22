import { Workflow } from '../components'

export default [
    {
        path: '/system/workflow',
        component: Workflow,
        name: 'workflow',
        meta: {
            needsAuth: true
        }
    }
]
