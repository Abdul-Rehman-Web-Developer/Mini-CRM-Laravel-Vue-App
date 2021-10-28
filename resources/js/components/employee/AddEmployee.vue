<template>
	<div class="container-fluid">
		<Header></Header>
		<div class="container mt-5 mb-5">
			<div class="row">
				<div class="col-md-6 offset-md-3">
					<h2>
						Add Employee
					</h2>
					<hr>
					<div class="alert alert-success alert-dismissible fade show" role="alert" v-if="employeeAdded">               
                        Employee successfuly added.                        
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>                        
                    </div>                
					<form method="POST" action="" @submit.prevent="addEmployee">
						
						<div class="form-group" v-if='companies'>
                            <label class="form-label">Company</label>
                            <select
                            type="text"
                            name='company_id'
                            v-model="form.company_id"
                            :class=" ['form-control' , errors.company_id ? 'is-invalid' : '' ] "
                            @input="resetError('company_id')"
                            :disabled='submitting'
                            placeholder="Select Company"
                            autofocus>
                                <option value="">Select Company</option>
                                <option v-for="(company,index) in companies" :key="index" :value="company.id">
                                    {{company.name}}
                                </option>
                            </select>
                            
                            <span class="invalid-feedback" role="alert" v-show="errors.company_id">
                                {{errors.company_id}}
                            </span>
                            
                        </div>
                        <div class="form-group">
                            <label class="form-label">First Name</label>
                            <input
                            type="text"
                            name='first_name'
                            v-model="form.first_name"
                            :class=" ['form-control' , errors.first_name ? 'is-invalid' : '' ] "
                            @input="resetError('first_name')"
                            :disabled='submitting'
                            placeholder="First Name*"
                            autofocus>
                            
                            <span class="invalid-feedback" role="alert" v-show="errors.first_name">
                                {{errors.first_name}}
                            </span>
                            
                        </div>
                        <div class="form-group">
							<label class="form-label">Last Name</label>
							<input
							type="text"
							name='last_name'
							v-model="form.last_name"
							:class=" ['form-control' , errors.last_name ? 'is-invalid' : '' ] "
							@input="resetError('last_name')"
							:disabled='submitting'
							placeholder="Last Name*"
							autofocus>
							
							<span class="invalid-feedback" role="alert" v-show="errors.last_name">
								{{errors.last_name}}
							</span>
							
						</div>
						<div class="form-group">
                            <label class="form-label">Email</label>
                            <input
                            type="email"
                            name='email'
                            v-model="form.email"
                            :class=" ['form-control' , errors.email ? 'is-invalid' : '' ] "
                             @input="resetError('email')"
                             :disabled='submitting'
                            placeholder="Email *"
                            autofocus>
                            
                            <span class="invalid-feedback" role="alert" v-show="errors.email">
                                    {{errors.email}}
                            </span>                            
                        </div>
                        <div class="form-group">
                            <label class="form-label">Phone</label>
                            <input
                            type="text"
                            name='phone'
                            v-model="form.phone"
                            :class=" ['form-control' , errors.phone ? 'is-invalid' : '' ] "
                            @input="resetError('phone')"
                             :disabled='submitting'
                            placeholder="Phone *"
                            >
                            <span class="invalid-feedback" role="alert" v-show="errors.phone">
                                    {{errors.phone}}
                            </span>
                        </div>
                        <div class="form-group mt-5">
                            <button type="submit" class="btn-primary btnSubmit" :disabled='submitting'>                                
                                <b>Add Employee</b>
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
    import Header from '../layouts/Header';

    export default {
        components: {
            Header
        },
        data(){
            return {
                companies:[],
                form: {
                    first_name: '',
                    last_name: '',
                    email: '',
                    phone: '',
                    company_id: ''
                },
                errors:{
                    first_name:'',
                    last_name:'',
                    email:'',
                    phone:'',
                    company_id:''
                },
                submitting: false,
                employeeAdded: false

            }
        },
        mounted(){
                
                this.form.company_id=this.$route.query.company_id
                this.getCompanies()
        },
        methods: {
            
            async addEmployee(){
                this.submitting=true;
                this.employeeAdded=false;
                this.resetErrors()
                
                await axios 
                            .post(window.baseUrl+'/employees',this.form)
                            .then(response => {
                                this.submitting=false  
                            	this.resetFields()                            
                                this.employeeAdded = true                 
                            })
                            .catch(error => {
                                try{
                                    if(error.response.data.first_name){
                                        this.errors.first_name=error.response.data.first_name[0]
                                    }
                                    if(error.response.data.last_name){
                                        this.errors.last_name=error.response.data.last_name[0]
                                    }
                                    if(error.response.data.email){
                                        this.errors.email=error.response.data.email[0]
                                    }
                                    if(error.response.data.phone){
                                        this.errors.phone=error.response.data.phone[0]
                                    }
                                    if(error.response.data.company_id){
                                        this.errors.company_id=error.response.data.company_id[0]
                                    }
                                }catch (e) {}
                                this.submitting=false
                                
                            })
                
            },
            async getCompanies(){
                
                this.submitting=true;
                await axios 
                            .get(window.baseUrl+'/companies?all=true')
                            .then(response => {
                                this.submitting=false  
                                this.companies = response.data  
                            })
                            .catch(error => {
                                try{
                                console.log(error)        
                                }catch (e) {}
                                this.submitting=false
                                
                            })
                
            },
            resetErrors(){
                this.errors.first_name=""
                this.errors.last_name=""
                this.errors.email=""
                this.errors.phone=""
            },
            resetError(field){
                switch(field) {
                    case 'first_name':
                        this.errors.first_name = ""
                      break;
                    case 'last_name':
                        this.errors.last_name = ""
                      break;
                    case 'email':
                        this.errors.email = ""
                      break;
                    case 'phone':
                        this.errors.phone = ""
                      break;                    
                }
            },
            resetFields(){
                this.form.first_name=""
            	this.form.last_name=""
                this.form.email=""
                this.form.phone=""                
            }
        }
        
    }
</script>