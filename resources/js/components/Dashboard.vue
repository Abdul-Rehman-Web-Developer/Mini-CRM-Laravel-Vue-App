<template>
    <div class="container-fluid">
        <Header></Header>
        <div class="container mt-5 mb-5">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>
                                Companies
                            </h5>
                        </div>
                        <div class="card-body">
                            <div  class="clearfix">
                                <router-link to="/add-company" class="btn btn-success float-right">
                                    Add Company
                                </router-link>
                            </div>
                            <div >
                                <Companies></Companies>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <Employees></Employees>                    
                </div>
            </div>
        </div>
    </div>    
</template>

<script>
    import Header from './layouts/Header';
    import Companies from './company/Companies';
    import Employees from './employee/Employees';

    export default {
        components: {
            Header,
            Companies,
            Employees
        },
        data(){
            return {
                companies: [],
                loadingComapnies: false
            }
        },
        methods: {
            
            async getCompanies(){
                
                this.loadingComapnies=true;
                
                await axios 
                            .get(window.baseUrl+'/companies')
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
