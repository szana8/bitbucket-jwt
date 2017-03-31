import { ListOfValues, Create } from '../components'

export default [
    
    {
        path: '/list-of-values',
        component: ListOfValues,
        name: 'listofvalues',
        meta: {
            needsAuth: true
        }
    },

    {
        path: '/list-of-values/create',
        component: Create,
        name: 'CreateListOfValue',
        meta: {
            needsAuth: true
        }
    },

    {
        path: '/list-of-values/:id/edit',
        component: Create,
        name: 'EditListOfValue',
        meta: {
            needsAuth: true
        }
    }

]
