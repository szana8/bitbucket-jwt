import Vue from 'vue'
import Vuex from 'vuex'
import auth from '../app/auth/vuex'
import metadata from '../app/metadata/vuex'
import listofvalues from '../app/listofvalues/vuex'
import authorization from '../app/authorization/vuex'
import locations from '../app/locations/vuex'

import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import 'vuetify/dist/vuetify.min.js'

Vue.use(Vuetify)
Vue.use(Vuex)

import * as VueGoogleMaps from 'vue2-google-maps';
Vue.use(VueGoogleMaps, {
    load: {
        key: 'AIzaSyD0rXXI4-Ba1uUU8qNs_9Jhxds-wQbUTiM',
        v: null,
        // libraries: 'places', //// If you need to use place input
    }
});

export default new Vuex.Store({
    modules: {
        auth: auth,
        metadata: metadata,
        listofvalues: listofvalues,
        authorization: authorization,
        locations: locations,
    }
})