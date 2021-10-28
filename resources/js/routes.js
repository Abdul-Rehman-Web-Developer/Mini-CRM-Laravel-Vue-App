import Vue from 'vue'
import VueRouter from 'vue-router'

import Dashboard from './components/Dashboard'
import Login from './components/Login'
import AddCompany from './components/company/AddCompany'
import AddEmployee from './components/employee/AddEmployee'
import EditEmployee from './components/employee/EditEmployee'
import EditCompany from './components/company/EditCompany'

Vue.use(VueRouter)

export default new VueRouter({
		mode: 'hash',
		
		routes: [
			{
				path: '/',
				component: Dashboard,
				name: 'Dashboard',
				beforeEnter: (to,from,next)=>{
	                axios
	                    .get(window.baseUrl+'/user')
	                    .then(response => {
	                        next()                        
	                    })
	                    .catch(error => {
	                        return next({name:'Login'})
	                    })
	            }            
				
			},
			{
				path: '/login',
				component: Login,
				name: 'Login',
				beforeEnter: (to,from,next)=>{

	                axios
	                    .get(window.baseUrl+'/user')
	                    .then(response => {
	                        return next({name:'Dashboard'})                          
	                    })
	                    .catch(error => {
	                      next() 
	                    })
	            }
	           
			},
			{
				path: '/add-company',
				component: AddCompany,
				name: 'AddCompany',
				beforeEnter: (to,from,next)=>{
	                axios
	                    .get(window.baseUrl+'/user')
	                    .then(response => {
	                        next()                        
	                    })
	                    .catch(error => {
	                        return next({name:'Login'})
	                    })
	            }            
				
			},
			{
				path: '/add-employee',
				component: AddEmployee,
				name: 'AddEmployee',
				beforeEnter: (to,from,next)=>{
	                axios
	                    .get(window.baseUrl+'/user')
	                    .then(response => {
	                        next()                        
	                    })
	                    .catch(error => {
	                        return next({name:'Login'})
	                    })
	            }            
				
			},
			{
				path: '/edit-company',
				component: EditCompany,
				name: 'EditCompany',
				beforeEnter: (to,from,next)=>{
	                axios
	                    .get(window.baseUrl+'/user')
	                    .then(response => {
	                        next()                        
	                    })
	                    .catch(error => {
	                        return next({name:'Login'})
	                    })
	            }            
				
			},
			{
				path: '/edit-employee',
				component: EditEmployee,
				name: 'EditEmployee',
				beforeEnter: (to,from,next)=>{
	                axios
	                    .get(window.baseUrl+'/user')
	                    .then(response => {
	                        next()                        
	                    })
	                    .catch(error => {
	                        return next({name:'Login'})
	                    })
	            }            
				
			},
		]
	})

