import { Locations, Show } from '../components'

export default [

    {
        path: '/setup/organizations/locations',
        component: Locations,
        name: 'locations',
        meta: {
            needsAuth: true
        }
    },

    {
        path: '/setup/organizations/locations/show/:id',
        component: Show,
        name: 'ShowLocation',
        meta: {
            needsAuth: true
        }
    }

]
