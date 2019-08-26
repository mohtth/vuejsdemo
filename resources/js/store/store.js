import Vuex from 'vuex'
import Vue from 'vue'

Vue.use(Vuex)

const get = function (url) {
    fetch('/api/user', {
        credentials: 'same-origin',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
}

/**
 *{
 *  1:{
 *      id: 1,
 *      name: 'Utilisateur Num 1',
 *      unread: 0,
 *      count: 100,
 *      messages:  [{
 *          id,
 *          from_id,
 *          to_id,
 *          ...
 *      }]
 *  }
 *}
*/

export default new Vuex.Store({
    strict: true,
    state: {
        conversations: {
        },
    },

    actions: {
        loadConversations: function (context) {
            get('/api/conversations')
        }
    }

})
