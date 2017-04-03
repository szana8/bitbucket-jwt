import { ListOfValues, Create } from '../components'

export default [
    
    {
        path: '/system/list-of-values',
        component: ListOfValues,
        name: 'listofvalues',
        meta: {
            needsAuth: true
        }
    },

    {
        path: '/system/list-of-values/create',
        component: Create,
        name: 'CreateListOfValue',
        meta: {
            needsAuth: true
        }
    },

    {
        path: '/system/list-of-values/:id/edit',
        component: Create,
        name: 'EditListOfValue',
        meta: {
            needsAuth: true
        }
    }

]
