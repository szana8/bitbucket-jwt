import Vue from 'vue'
import Vuex from 'vuex'
import auth from '../app/auth/vuex'
import VueMaterial from 'vue-material'
import 'vue-material/dist/vue-material.css'


Vue.use(VueMaterial)
Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        auth: auth
    }
})