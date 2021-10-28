<template>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      
      <router-link to="/"class="navbar-brand">
        <b>Mini CRM </b> - Laravel Vue App
      </router-link>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item" v-if="user">
            <router-link to="/"class="nav-link">
              Dashboard
            </router-link>
          </li>
          <li class="nav-item dropdown" v-if="user">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{user.name}}
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#" >
                {{user.email}}
              </a>
              <a class="dropdown-item" href="" @click.prevent="logout">
                Logout
              </a>
            </div>
          </li>          
          <li class="nav-item" v-if="!user">
            <router-link to="/login"class="nav-link">
              Login
            </router-link>
          </li>          
        </ul>
      </div>
    </div>
  </nav>

</template>

<script>
    export default {
        data(){
            return {
                user :null
            }
        },
        async mounted(){
          await axios
                    .get(window.baseUrl+'/user')
                    .then(response => {
                        this.user = response.data                        
                    })
                    .catch(error => {
                      try{
                        let temp=error
                      }catch (e) {}
                    })
        },
        methods: {
          async logout(){
            await axios
                    .get(window.baseUrl+'/logout') 
                    .then(response => {
                        this.$router.push({name: "Login"})                         
                    })
          }
        }
    }
</script>