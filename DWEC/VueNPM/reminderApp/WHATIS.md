# What am I using for this project? 
## Vue - And what about vue that are not self explanatory? 

### Ref

Long story short: allows us to obtain a direct reference to a specific DOM element or child component instance after it's mounted.
What? - Let me code you:

    <script setup>
        import { useTemplateRef, onMounted } from 'vue'

        // the first argument must match the ref value in the template
        const input = useTemplateRef('my-input')

        onMounted(() => {
        input.value.focus()
        })
    </script>

    <template>
        <input ref="my-input" />
    </template>

Note that you can only access the ref after the component is mounted. If you try to access input in a template expression, it will be null on the first render. This is because the element doesn't exist until after the first render

### Computed

Imagine we have an array containing Books and His author such as:
    
    const author = reactive({
        name: 'John Doe',
        books: [
            'Vue 2 - Advanced Guide',
            'Vue 3 - Basic Guide',
            'Vue 4 - The Mystery'
        ]
    })

now lets say i'd like to display dynamically the if an author has published or not a book, I could do this:
    <p>Has published books:</p>
    <span>{{ author.books.length > 0 ? 'Yes' : 'No' }}</span>
 
and there's nothing wrong with that - but following the proper guideliness of Vue documentation:
"That's why for complex logic that includes reactive data, it is recommended to use a computed property."

#### So what is Computed?

Computed is:
    <script setup>
    import { reactive, computed } from 'vue';

    const author = reactive({
    name: 'John Doe',
    books: [
        'Vue 2 - Advanced Guide',
        'Vue 3 - Basic Guide',
        'Vue 4 - The Mystery'
    ]
    })

    // a computed ref
    const publishedBooksMessage = computed(() => {
    return author.books.length > 0 ? 'Yes' : 'No'
    })
    </script>

    <template>
    <p>Has published books:</p>
    <span>{{ publishedBooksMessage }}</span>
    </template>
 
 
As you can see a Computed function automatically tracks its reactive dependencies, so it will update any bindings that depend on publishedBooksMessage when author.books changes.

### OnMounted
What is a Mounted Component?
A component is considered mounted after:
Its own DOM tree has been created and inserted into the parent container. 
 
Thus, onMounted comes in handy when we need to make sure the element we are trying to access is fully loaded. 
Here's an example of the Official Documentation:

    <script setup>
        import { ref, onMounted } from 'vue'

        const el = ref()

        onMounted(() => {
            var divValue = el.value // <div>
        })
    </script>

    <template>
        <div ref="el">Hello I'm Jesus</div>
    </template>

This way we can: Accessing an element via template ref, on this case divValue would be = "Hello I'm Jesus" - this way you can access value of elements and do great things such as: 

    onMounted(() => {
        const savedNotes = localStorage.getItem('notes');
        if (savedNotes) {
            notes.value = JSON.parse(savedNotes);
        }
    })

Once the DOM is rendered, if we have a cookie set to 'notes' it will load it and assign it to saves noted - Also you can notices the first param is a callback so you better now about [Callbacks](https://www.w3schools.com/js/js_callback.asp)



### Watch

Computed properties comes in handy to access elements - but not to change them (Mutating the DOM), that's where the *Watch* function comes in handy as well. 

So what does it do? - easy:
It triggers a callback whenever a piece of reactive state changes - WHAT? easy:

    <script setup>
        import { ref, watch } from 'vue'

        const question = ref('')
        const answer = ref('Questions usually contain a question mark. ;-)')
        const loading = ref(false)

        // watch works directly on a ref
        watch(question, async (newQuestion, oldQuestion) => {
        if (newQuestion.includes('?')) {
            loading.value = true
            answer.value = 'Thinking...'
            try {
            const res = await fetch('https://yesno.wtf/api')
            answer.value = (await res.json()).answer
            } catch (error) {
            answer.value = 'Error! Could not reach the API. ' + error
            } finally {
            loading.value = false
            }
        }
        })
    </script>

    <template>
        <p>
            Ask a yes/no question:
            <input v-model="question" :disabled="loading" />
        </p>
        <p>{{ answer }}</p>
    </template>


This one could be a little shady so notice because of async and stuff but the logic is quite simple - im watching a question and the async(newQuestion). So what happens is that once my newQuestion inclues a '?' im gonna trigger an API petition (this is where it becomes shady), but for instance I use it on my code like this:

    watch(notes, (newNotes) => {
            localStorage.setItem('notes', JSON.stringify(newNotes));
        }, { deep: true })

So here i'm watching 'notes', once 'notes' changes im gonna trigger a callback to persist that new 'note' into my localStorage.


### Worth Mentioning
#### DefineProps 
Vue components require explicit props declaration so that Vue knows what external props passed to the component should be treated as fallthrough attributes. I.E.:
    <script setup>
        const props = defineProps(['foo'])

        console.log(props.foo)
    </script>

I mean, thats the concept so what else should i explain lol

#### emit
Important: We are talking about Declared Emitted Events and not only Emitting and Listening to Events
A component can explicitly declare the events it will emit using the defineEmits() macro

    <script setup>
        defineEmits(['inFocus', 'submit'])
    </script>

The $emit method that we used in the <template> isn't accessible within the script setup section of a component, but defineEmits() returns an equivalent function that we can use instead:

    <script setup>
        const emit = defineEmits(['inFocus', 'submit'])

        function buttonClick() {
        emit('submit')
        }
    </script>

