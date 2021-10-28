<template>
<div class="container-fluid">
<Header></Header>
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2>
            Edit Company
            </h2>
            <hr>
            <div class="btn-group btn-group-lg mb-5">
              <button type="button" :class=" ['btn', 'mr-2' , showBasicInfoForm ? 'btn-default' : 'btn-primary' ] " @click="show('basic_info_form')">Update Basic Info</button>
              <button type="button" :class=" ['btn', 'mr-2' , showLogoForm ? 'btn-default' : 'btn-primary' ] " @click="show('logo_form')">Update Logo</button>
            </div> 
            
                <div v-if="showBasicInfoForm">
                    <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="basicInfoUpdated">
                        Company basic info successfuly updated.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    

                    <form method="POST" action="" @submit.prevent="updateBasicInfo">
                        
                        <div class="form-group">
                            <label class="form-label">Company Id</label>
                            <input
                            type="text"
                            name='company_id'
                            v-model="basicInfoForm.company_id"
                            :class=" ['form-control' , basicInfoErrors.company_id ? 'is-invalid' : '' ] "
                            :disabled='submittingBasicInfo'
                            placeholder="Company Id *"
                            disabled
                            >
                            <span class="invalid-feedback" role="alert" v-show="basicInfoErrors.company_id">
                                {{basicInfoErrors.company_id}}
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Name</label>
                            <input
                            type="text"
                            name='name'
                            v-model="basicInfoForm.name"
                            :class=" ['form-control' , basicInfoErrors.name ? 'is-invalid' : '' ] "
                            @input="resetBasicInfoErrors('name')"
                            :disabled='submittingBasicInfo'
                            placeholder="Name*"
                            autofocus>
                            
                            <span class="invalid-feedback" role="alert" v-show="basicInfoErrors.name">
                                {{basicInfoErrors.name}}
                            </span>
                            
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input
                            type="email"
                            name='email'
                            v-model="basicInfoForm.email"
                            :class=" ['form-control' , basicInfoErrors.email ? 'is-invalid' : '' ] "
                            @input="resetBasicInfoErrors('email')"
                            :disabled='submittingBasicInfo'
                            placeholder="Email *"
                            autofocus>
                            
                            <span class="invalid-feedback" role="alert" v-show="basicInfoErrors.email">
                                {{basicInfoErrors.email}}
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Website</label>
                            <input
                            type="text"
                            name='website'
                            v-model="basicInfoForm.website"
                            :class=" ['form-control' , basicInfoErrors.website ? 'is-invalid' : '' ] "
                            @input="resetBasicInfoErrors('website')"
                            :disabled='submittingBasicInfo'
                            placeholder="Website *"
                            >
                            <span class="invalid-feedback" role="alert" v-show="basicInfoErrors.website">
                                {{basicInfoErrors.website}}
                            </span>
                        </div>
                        <div class="form-group mt-5">
                            <button type="submit" class="btn-primary btnSubmit" :disabled='submittingBasicInfo'>
                            <b>Update</b>
                            <div class="spinner-border text-white ml-2" role="status" v-if='submittingBasicInfo'  style="width: 15px; height: 15px;">
                                <span class="sr-only"></span>
                            </div>
                            </button>
                            
                        </div>
                        
                    </form>
                </div>
                <div v-if="showLogoForm">
                    <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="logoUpdated">
                        Company logo successfuly updated.                       
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <form method="POST" action="" @submit.prevent="updateLogo" enctype="multipart/form-data">
                                           
                        <div class="form-group">
                            <label class="form-label">Company Id</label>
                            <input
                            type="text"
                            name='company_id'
                            v-model="logoForm.company_id"
                            :class=" ['form-control' , logoErrors.company_id ? 'is-invalid' : '' ] "
                            :disabled='submittingLogo'
                            placeholder="Company Id *"
                            disabled
                            >
                            <span class="invalid-feedback" role="alert" v-show="logoErrors.company_id">
                                {{logoErrors.company_id}}
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Logo</label>
                            <input
                            type="file"
                            name='logo'
                            ref='logo'
                            @change="changeFile( $event )"
                            :class=" ['form-control' , logoErrors.logo ? 'is-invalid' : '' ] "
                            :disabled='submittingLogo'
                            placeholder="Logo *"
                            >
                            <span class="invalid-feedback" role="alert" v-show="logoErrors.logo">
                                {{logoErrors.logo}}
                            </span>
                        </div>
                        <div class="form-group mt-5">
                            <button type="submit" class="btn-primary btnSubmit" :disabled='submittingLogo'>
                            <b>Update</b>
                            <div class="spinner-border text-white ml-2" role="status" v-if='submittingLogo'  style="width: 15px; height: 15px;">
                                <span class="sr-only"></span>
                            </div>
                            </button>
                            
                        </div>
                        
                    </form>
                </div>
            
            
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
                basicInfoForm: {
                    name: '',
                    email: '',
                    website: '',
                    company_id: ''
                },
                logoForm: {
                    logo: '',
                    company_id: ''
                },
                basicInfoErrors:{
                    name:'',
                    email:'',
                    website: '',
                    company_id: ''
                },
                logoErrors:{
                    logo:'',
                    company_id: ''
                },
                submittingBasicInfo: false,
                submittingLogo: false,
                basicInfoUpdated: false,
                logoUpdated: false,
                file:"",
                showBasicInfoForm:true,
                showLogoForm:false,
                companyId:null

            }
        },
        created(){
            this.basicInfoForm.company_id=this.$route.query.company_id
            this.logoForm.company_id=this.$route.query.company_id
            this.companyId=this.$route.query.company_id
            this.getCompany()
        },
        methods: {
            show(val){
                
                if(val=='basic_info_form'){
                    this.showBasicInfoForm=true
                    this.showLogoForm=false
                }else{
                    this.showLogoForm=true
                    this.showBasicInfoForm=false
                }
            },
        	changeFile(event){
        		this.file = event.target.files[0];
        		this.logoErrors.logo = "";
        	},
            async getCompany(){

                this.submittingBasicInfo=true;
                await axios 
                            .get(window.baseUrl+`/companies/${this.companyId}`)
                            .then(response => {
                                this.submittingBasicInfo=false 
                                this.basicInfoForm.name = response.data.name   
                                this.basicInfoForm.email = response.data.email   
                                this.basicInfoForm.website = response.data.website   
                                this.submittingBasicInfo=false
                              
                            })
                            .catch(error => {
                                try{
                                    console.log(error)
                                }catch (e) {}
                                this.submittingBasicInfo=false
                                
                            })
                
            },
            async updateBasicInfo(){
                
                this.submittingBasicInfo=true;
                this.basicInfoUpdated=false;
                this.resetBasicInfoErrors()
                await axios 
                            .put(window.baseUrl+`/companies/${this.companyId}`,this.basicInfoForm)
                            .then(response => {
                                this.submittingBasicInfo=false  
                                this.basicInfoUpdated = true                 
                            })
                            .catch(error => {
                                try{
                                    if(error.response.data.name){
                                        this.basicInfoErrors.name=error.response.data.name[0]
                                    }
                                    if(error.response.data.email){
                                        this.basicInfoErrors.email=error.response.data.email[0]
                                    }
                                    if(error.response.data.website){
                                        this.basicInfoErrors.website=error.response.data.website[0]
                                    }
                                    if(error.response.data.company_id){
                                        this.basicInfoErrors.company_id=error.response.data.company_id[0]
                                    }
                                }catch (e) {}
                                this.submittingBasicInfo=false
                                
                            })
                
            },
            async updateLogo(){
            	
                this.submittingLogo=true;
                this.logoUpdated=false;
                this.resetLogoErrors()
                const formData = new FormData();
                formData.append('logo',this.file)
                formData.append('company_id',this.logoForm.company_id)
                await axios 
                            .post(window.baseUrl+`/companies/update_logo`,formData)
                            .then(response => {
                                this.submittingLogo=false  
                            	this.resetLogoField()                            
                                this.logoUpdated = true                 
                            })
                            .catch(error => {
                                try{
                                    if(error.response.data.logo){
                                        this.logoErrors.logo=error.response.data.logo[0]
                                    }
                                    if(error.response.data.company_id){
                                        this.logoErrors.company_id=error.response.data.company_id[0]
                                    }
                                }catch (e) {}
                                this.submittingLogo=false
                                
                            })
                
            },
            resetBasicInfoErrors(field){
                switch(field) {
                    case 'name':
                        this.basicInfoErrors.name = ""
                      break;
                    case 'email':
                        this.basicInfoErrors.email = ""
                      break;
                    case 'website':
                        this.basicInfoErrors.website = ""
                      break; 
                    case 'company_id':
                        this.basicInfoErrors.company_id = ""
                      break;                    
                }
            },
            resetLogoErrors(field){
                 this.logoErrors.logo = ""
                 this.logoErrors.company_id = ""
            },
            resetLogoField(){
                this.$refs.logo.value=null;
                
            },
        }
        
    }
</script>