<template>
<div class="mt-3">
    <h4>
    About Company
    <div class="spinner-border text-primary clearfix float-right" v-if='loadingEmployees' role="status">
          <span class="sr-only"></span>
    </div>
    </h4>
    <hr>
    <div class="clearfix mb-2" v-if="companyId">
        <router-link :to="{ name: 'EditCompany', query: { company_id: companyId }}" class="btn btn-primary mr-2">
        Edit Company
        </router-link>
        <button class="btn btn-danger" @click="deleteCompany">
        Delete Company
        </button>
    </div>
    <div style="min-height:150px" >
        <div class="card" v-if="companyId">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4 col-md-12">
                        <img
                        :src="company.logo"
                        style="min-width:100px;max-width:200px;margin:30px auto">
                    </div>
                    <div class="col-lg-8 col-md-12">
                        <div class="table-responsive">
                            <table class="table mt-4">
                                <tr>
                                    <th>
                                        Name
                                    </th>
                                    <td>
                                        {{company.name}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Email
                                    </th>
                                    <td>
                                        {{company.email}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Website
                                    </th>
                                    <td>
                                        <a href="#">
                                            {{company.website}}
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <h4 class="mt-5">
    Company Employees
    <div class="spinner-border text-primary clearfix float-right" v-if='loadingEmployees' role="status">
          <span class="sr-only"></span>
    </div>
    </h4>
    <hr>
    <div class="clearfix mb-2" v-if="companyId">
        <router-link :to="{ name: 'AddEmployee', query: { company_id: companyId }}" class="btn btn-success"  >
         Add Employee
        </router-link>
    </div>
    <div style="min-height:150px" v-if="companyId">
        <div class="table-responsive card">
            <table class="table ">
                <thead>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <tr  v-for="(employee,index) in employees.data" :key="index">
                        <td>
                            {{employee.first_name}}
                        </td>
                        <td>
                            {{employee.last_name}}
                        </td>
                        <td>
                            {{employee.email}}
                        </td>
                        <td>
                            {{employee.phone}}
                        </td>
                        <td>
                            <router-link :to="{ name: 'EditEmployee', query: { employee_id: employee.id }}" class="btn btn-primary btn-sm mr-2">
                            Edit
                            </router-link>
                            <button class="btn btn-danger btn-sm" @click="deleteEmployee(employee.id)">
                            Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
                
            </table>
        </div>
        <pagination  align="left" class='mt-2' :data="employees" @pagination-change-page="getEmployees"></pagination>
    </div>
</div>
</template>

<script>
   import {EventBus} from '../../app';
   import pagination from 'laravel-vue-pagination';
    export default {        
        components:{
            pagination
        },        
        data(){
            return {
                company:{
                    name:'',
                    email:'',
                    website:'',
                    logo:''
                },
                employees: {},
                loadingEmployees: false,
                companyId:null,
            }
        },
        created(){
            EventBus.$on('companyChanged',(data) =>{
                this.companyId = data
                this.getEmployees()
                this.getCompany()
            })      
            
        },
        methods: {
            
            async getCompany(){

                this.loadingEmployees=true;
                await axios 
                            .get(window.baseUrl+`/companies/${this.companyId}`)
                            .then(response => {
                                this.loadingEmployees=false 
                                this.company.name = response.data.name   
                                this.company.email = response.data.email   
                                this.company.website = response.data.website   
                                this.company.logo = response.data.logo   
                                this.loadingEmployees=false
                              
                            })
                            .catch(error => {
                                try{
                                    console.log(error)
                                }catch (e) {}
                                this.loadingEmployees=false
                                
                            })
                
            },
            async getEmployees(page=1){
                this.loadingEmployees=true;
                await axios 
                            .get(window.baseUrl+`/employees?page=${page}&company_id=${this.companyId}`)
                            .then(response => {
                                this.loadingEmployees=false  
                                this.employees = response.data   
                                            
                            })
                            .catch(error => {
                                try{
                                    console.log(error)
                                }catch (e) {}
                                this.loadingEmployees=false
                                
                            })
                
            },
            async deleteEmployee(id){
                if (confirm("Do you realy want to delete this employee?")) {
                    
                    this.loadingEmployees=true;
                    await axios 
                                .delete(window.baseUrl+`/employees/${id}`)
                                .then(response => {
                                    this.loadingEmployees=false 
                                    this.getEmployees()                                           
                                })
                                .catch(error => {
                                    try{
                                        console.log(error)
                                    }catch (e) {}
                                    this.loadingEmployees=false
                                    
                                })
                }
            },
            async deleteCompany(){
                if (confirm("Do you realy want to delete this company along with all its employees?")) 
                {
                    this.loadingEmployees=true;
                    await axios 
                                .delete(window.baseUrl+`/companies/${this.companyId}`)
                                .then(response => {
                                    this.loadingEmployees=false 
                                    location.reload()                                          
                                })
                                .catch(error => {
                                    try{
                                        console.log(error)
                                    }catch (e) {}
                                    this.loadingEmployees=false                                    
                                })
                }
            },
        }
        
    }
</script>