const app = Vue.createApp({
    data(){ 
        return{
            message: 'Hola mundo',
            title: 'Primera prueba con  Vue',
            age: 21,
            showAge: false   
        }
    }
})

app.mount('#app');