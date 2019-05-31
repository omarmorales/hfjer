<template>
    <div>
        <form @submit.prevent="createQuestion()">
            <div class="form-group">
                <label for="title">Título de la duda</label>
                <input v-model="form.title" type="text" name="title"
                placeholder=""
                class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                <has-error :form="form" field="title"></has-error>
            </div>
            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea v-model="form.description" name="description" id="description"
                placeholder=""
                class="form-control" :class="{ 'is-invalid': form.errors.has('description') }"></textarea>
                <has-error :form="form" field="description"></has-error>
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary btn-width">Enviar</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        data: () => ({
            user: [],
            form: new Form({
                id: '',
                title : '',
                description: '',
                user_id: '',
            })
        }),
        methods: {
            loadUser(){
                this.form.reset();
                axios.get("api/profile")
                    .then(({ data }) => (
                        this.user = data,
                        this.form.user_id = data.id
                    )
                );
            },
            createQuestion(){
                this.$Progress.start();

                this.form.post('/api/question')
                .then(()=>{
                    $('#helpdesk').modal('hide')

                    toast({
                    type: 'success',
                    title: 'Duda enviada correctamente.'
                    })
                    this.$Progress.finish();
                })
                .catch(()=>{
                    this.$Progress.fail();
                    toast({
                    type: 'error',
                    title: 'Error al enviar duda.'
                    })
                })
            }
        },
        created(){
            this.loadUser();
        }
    }
</script>

<style lang="scss" scoped>
    .btn-width{
        width: 10rem;
    }
</style>