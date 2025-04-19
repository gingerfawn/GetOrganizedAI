<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        <p>I'm an example component.</p>
                        <form @submit.prevent="addNote">
                            <div class="form-group">
                                <label for="note">Add a Note:</label>
                                <input type="text" v-model="newNote" class="form-control" id="note" placeholder="Enter note">
                            </div>
                            <button type="submit" class="btn btn-primary">Add Note</button>
                        </form>
                        <ul class="list-group mt-3">
                            <li v-for="(note, index) in notes" :key="index" class="list-group-item">
                                {{ note }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ExampleComponent',
    data() {
        return {
            newNote: '',
            notes: []
        };
    },
    methods: {
        addNote() {
            if (this.newNote.trim() !== '') {
                this.notes.push(this.newNote.trim());
                this.newNote = '';
            }
        }
    },
    mounted() {
        console.log('Component mounted.');
    }
}
</script>

<style scoped>
/* Add any component-specific styles here */
</style>
