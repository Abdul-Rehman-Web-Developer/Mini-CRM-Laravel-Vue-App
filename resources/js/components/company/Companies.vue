<template>
    <div class="mt-3">
        <div class="spinner-border text-primary clearfix text-align-center" v-if='loadingComapnies' role="status">
          <span class="sr-only"></span>
        </div>
        <div v-else >
            <div  v-for="(company,index) in companies.data" :key="index">
                 <div class="mb-2">
                    <div :class=" ['card' , 'company-card' , active_el == index ? 'active' : '' ] "  @click="activate($event,index,company.id)"  >
                        <img :src="company.logo">
                        <div class="card-body text-center">
                            <h4 class="card-title font-weight-bold" style="color:black !important">
                             {{company.name}}
                            </h4>
                            <p>
                                {{company.email}}
                            </p>
                            <a :href="company.website">
                                {{company.website}}
                            </a>
                        </div>
                    </div>
                </div>                
            </div>
            <pagination @click.native="pageChanged" align="center" :data="companies" @pagination-change-page="getCompanies"></pagination>
           
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
                companies: {},
                loadingComapnies: false,
                active_el:null
            }
        },
        mounted(){
            this.getCompanies()
        },
        methods: {
            activate(event,key,companyId){
                this.active_el = key
                EventBus.$emit("companyChanged",companyId)
            },
            pageChanged(){
                EventBus.$emit("companyChanged",null)
            },
            async getCompanies(page=1){
                
                this.loadingComapnies=true;
                this.active_el=null;
                await axios 
                            .get(window.baseUrl+`/companies?page=${page}`)
                            .then(response => {
                                this.loadingComapnies=false  
                                this.companies = response.data   
                                            
                            })
                            .catch(error => {
                                try{
                                    
                                }catch (e) {}
                                this.loadingComapnies=false
                                
                            })
                
            },
        }
        
    }
</script>