<template>
    <div class="container-fluid">
        <Header></Header>
        <div class="container login-container">
            <div class="row">
                <div class="col-md-6 offset-md-3 login-form-1">
                    <h3>Account Login </h3>
                    <form method="POST" action="" @submit.prevent="login">

                        <div class="alert alert-info mb-4" role="alert">
                          <h5>Admin Login Credentials:</h5>
                          <hr>
                          <p>
                              Email: <b>admin@admin.com</b>
                          </p>
                          <p>
                              Password: <b>password</b>
                          </p>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input
                            type="text"
                            name='email'
                            v-model="form.email"
                            :class=" ['form-control' , errors.email ? 'is-invalid' : '' ] "
                             @input="resetError('email')"
                             :disabled='submitting'
                            placeholder="Your Email *"
                            autofocus>
                            
                            <span class="invalid-feedback" role="alert" v-show="errors.email">
                                    {{errors.email}}
                            </span>
                            
                        </div>
                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <input
                            type="password"
                            name='password'
                            v-model="form.password"
                            :class=" ['form-control' , errors.password ? 'is-invalid' : '' ] "
                             @input="resetError('password')"
                             :disabled='submitting'
                            placeholder="Password *"
                            >
                            <span class="invalid-feedback" role="alert" v-show="errors.password">
                                    {{errors.password}}
                            </span>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btnSubmit" :disabled='submitting'>                                
                                Login
                                <div class="spinner-border text-white ml-2" role="status" v-if='submitting'  style="width: 15px; height: 15px;">
                                  <span class="sr-only"></span>
                                </div>
                            </button>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>    
</template>

<script>
    import Header from './layouts/Header';

    export default {
        components: {
            Header
        },
        data(){
            return {
                form: {
                    email: '',
                    password: ''
                },
                errors:{
                    email:'',
                    password: ''
                },
                submitting: false

            }
        },
        methods: {
            async login(){
                this.submitting=true
                this.resetErrors()
                await axios
                            .post(window.baseUrl+'/login',this.form)
                            .then(response => {                              
                                this.$router.push({name: "Dashboard"})                        
                            })
                            .catch(error => {
                                try{
                                    if(error.response.data.email){
                                        this.errors.email=error.response.data.email[0]
                                    }
                                    if(error.response.data.password){
                                        this.errors.password=error.response.data.password[0]
                                    }
                                }catch (e) {}
                                this.submitting=false
                                
                            })
                
            },
            resetErrors(){
                this.errors.email=""
                this.errors.password=""
            },
            resetError(field){
                switch(field) {
                    case 'email':
                        this.errors.email = ""
                      break;
                    case 'password':
                        this.errors.password = ""
                      break;                        
                }
            }
        }
        
    }
</script>
