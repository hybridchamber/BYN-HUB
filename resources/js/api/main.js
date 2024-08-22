import { createApp } from 'vue'
import App from './App.vue'
import { createGoogleMapsPlugin } from '@fawmi/vue-google-maps'

const app = createApp(App)

app.use(createGoogleMapsPlugin({
    load: {
        apiKey: 'AIzaSyBTou7SZEbSRKX37-awgtPfz48wSnlWUp0',
    },
}))

app.mount('#app')
