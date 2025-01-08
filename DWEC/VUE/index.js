const app = Vue.createApp({
    data(){ 
        return{
            message: 'Hola mundo',
            title: 'Primera prueba con  Vue',
            age: 21,
            showAge: false,
            inContent: '',
            people: [
                {
                    name: 'Juan',
                    age: 21,
                    gender: 'Male'
                },
                {
                    name: 'Ana',
                    age: 19,
                    gender: 'Female'
                },
                {
                    name: 'Jose',
                    age: 40,
                    gender: 'Male'
                }
            ]
        }
    },
    methods:{
        pressedButton(){
            // this.people.push({`name: ${this.inContent}`});
            this.people.push({ name: this.inContent });
            this.inContent = '';
        },
        eraseButton(i){
            this.people.splice(i, 1);
        }
    }
})

app.mount('#app');