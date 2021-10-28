<template>
	<div class="container-fluid">
		<Header></Header>
		<div class="container mt-5">
			<div class="row">
				<div class="col-md-6 offset-md-3">
					<h2>
						Add Company
					</h2>
					<hr>
					<div class="alert alert-success alert-dismissible fade show" role="alert" v-if="companyAdded">               
                        Company successfuly added.                        
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>                      
                    </div>
                
					<form method="POST" action="" @submit.prevent="addCompany" enctype="multipart/form-data">
						
						<div class="form-group">
							<label class="form-label">Name</label>
							<input
							type="text"
							name='name'
							v-model="form.name"
							:class=" ['form-control' , errors.name ? 'is-invalid' : '' ] "
							@input="resetError('name')"
							:disabled='submitting'
							placeholder="Name*"
							autofocus>
							
							<span class="invalid-feedback" role="alert" v-show="errors.name">
								{{errors.name}}
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
                            <label class="form-label">Logo</label>
                            <input
                            type="file"
                            name='logo'
                            ref='logo'
                            @change="changeFile( $event )"                            
                            :class=" ['form-control' , errors.logo ? 'is-invalid' : '' ] "
                             :disabled='submitting'
                            placeholder="Logo *"
                            >
                            <span class="invalid-feedback" role="alert" v-show="errors.logo">
                                    {{errors.logo}}
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Website</label>
                            <input
                            type="text"
                            name='website'
                            v-model="form.website"
                            :class=" ['form-control' , errors.website ? 'is-invalid' : '' ] "
                            @input="resetError('website')"
                             :disabled='submitting'
                            placeholder="Website *"
                            >
                            <span class="invalid-feedback" role="alert" v-show="errors.website">
                                    {{errors.website}}
                            </span>
                        </div>
                        <div class="form-group mt-5">
                            <button type="submit" class="btn-primary btnSubmit" :disabled='submitting'>                                
                                <b>Add Company</b>
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
                form: {
                    name: '',
                    email: '',
                    website: ''
                },
                errors:{
                    name:'',
                    email:'',
                    logo:'',
                    website: ''
                },
                submitting: false,
                file:"",
                companyAdded: false

            }
        },
        methods: {
        	changeFile(event){
        		this.file = event.target.files[0];
        		this.errors.logo = "";
        	},
            async addCompany(){
            	
                this.submitting=true;
                this.companyAdded=false;
                this.resetErrors()
                const formData = new FormData();
                formData.append('logo',this.file)
                for ( var key in this.form ) {
				    formData.append(key, this.form[key]);
				}

                await axios 
                            .post(window.baseUrl+'/companies',formData)
                            .then(response => {
                                this.submitting=false  
                            	this.resetFields()                            
                                this.companyAdded = true                 
                            })
                            .catch(error => {
                                try{
                                    if(error.response.data.name){
                                        this.errors.name=error.response.data.name[0]
                                    }
                                    if(error.response.data.email){
                                        this.errors.email=error.response.data.email[0]
                                    }
                                    if(error.response.data.logo){
                                        this.errors.logo=error.response.data.logo[0]
                                    }
                                    if(error.response.data.website){
                                        this.errors.website=error.response.data.website[0]
                                    }
                                }catch (e) {}
                                this.submitting=false
                                
                            })
                
            },
            resetErrors(){
                this.errors.name=""
                this.errors.email=""
                this.errors.logo=""
                this.errors.website=""
            },
            resetError(field){
                switch(field) {
                    case 'name':
                        this.errors.name = ""
                      break;
                    case 'email':
                        this.errors.email = ""
                      break;
                    case 'logo':
                        this.errors.logo = ""
                      break;                    
                }
            },
            resetFields(){
            	this.form.name=""
                this.form.email=""
                this.form.website=""
                this.$refs.logo.value=null;
                
            }
        }
        
    }
</script>