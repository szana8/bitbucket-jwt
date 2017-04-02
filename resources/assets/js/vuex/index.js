import Vue from 'vue'
import Vuex from 'vuex'
import auth from '../app/auth/vuex'
import metadata from '../app/metadata/vuex'
import listofvalues from '../app/listofvalues/vuex'
import authorization from '../app/authorization/vuex'

import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import 'vuetify/dist/vuetify.js'

Vue.use(Vuetify)
Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        namepsace: 'setting',
        auth: auth,
        metadata: metadata,
        listofvalues: listofvalues,
        authorization: authorization,
    }
})