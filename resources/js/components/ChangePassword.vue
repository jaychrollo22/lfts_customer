<template>
    <div>
        <div class="row">
            <div class="col-md-5">
                <div class="card ">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="card-title"><i class="fa fa-fw fa-cogs"></i> Change Password</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body mb-5 pb-5">
                        <div class="row">
                            <div class="col-12">
                                <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="nav-link-icon fa fa-key"></i></span></div>
                                        <input v-model="user.new_password" placeholder="Password" type="password" class="form-control">
                                        
                                </div>
                                <div>
                                    <span class="text-danger" v-if="errors.new_password"> {{ errors.new_password[0] }} </span>
                                </div>
                                
                            </div>
                            <div class="col-12">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="nav-link-icon fa fa-key"></i></span></div>
                                    <input v-model="user.new_password_confirmation" placeholder="Confirm Password" type="password" class="form-control">
                                    </div>
                                    <div>
                                        <span class="text-danger" v-if="errors.new_password_confirmation"> {{ errors.new_password_confirmation[0] }} </span>
                                    </div>
                                </div>
                                
                                
                            </div>
                            <div class="col-12">
                                <button class="btn btn-sm btn-primary" @click="changePassword(user)">Change Password</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</template>

<script>
    import Swal from 'sweetalert2'
    export default {
        data(){
            return {
                userData: [],
                user: [],
                errors: [],
            }
        },
        created(){
            this.fetchUser();
        },
        methods:{
            fetchUser(){
                axios.get('/user-data')
                .then(response => { 
                    this.userData = response.data;
                })
                .catch(error => { 
                    this.errors = error;
                })
            },
            resetForm(){
                this.errors = [];
                this.user = [];
            },
            changePassword(user){
                axios.post('/change-password', {
                    user_id: this.userData.id,
                    new_password: user.new_password,
                    new_password_confirmation: user.new_password_confirmation
                })
                .then(response => {
                    this.resetForm();
                    Swal.fire({
                        title: 'Success!',
                        text: 'Your Password has been Updated Successfully.',
                        icon: 'success',
                        confirmButtonText: 'Okay'
                    })
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                    console.log(this.errors);
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Unable to save user. Please try again.',
                        icon: 'warning',
                        confirmButtonText: 'Okay'
                    })
                })
            },
        }
    }
</script>
