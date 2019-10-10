<template>
    <div class="">
        <div class="row justify-content-center my-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Add Employee</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 offset-2">
                                <form @submit.prevent="onSubmit">
                                    
                                    <div class="form-group">
                                        <label for="first_name">First Name</label>
                                        <input type="text" class="form-control" name="first_name" id="first_name" v-model="first_name" placeholder="Enter first name ...  ">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">E-mail</label>
                                        <input type="email" class="form-control" name="email" id="email" v-model="email" placeholder="name@example.com">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" name="password" id="password" v-model="password" placeholder="secret">
                                    </div>
                                    <button type="submit" class="btn btn-primary" v-bind:class="{ 'is-loading' : isLoading }">Add Employee</button>
                                </form>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                
                    first_name: '',
                    email: '',
                    password: '',
                
                isLoading: false
            }
        },
        methods: {
            onSubmit(){
                let uri = 'http://127.0.0.1:8000/api/users';
                this.axios.post(uri, {
                    data: {
                        first_name: this.first_name,
                        email:  this.email,
                        password:  this.email,
                    }
                })
                .then((response) => {
                    
                    this.isLoading = false
                    this.$emit('completed', response.data.data)
                })
                .catch(error => {
                    // handle authentication and validation errors here
                    
                    this.isLoading = false
                })
            }
        }
    }   
</script>
