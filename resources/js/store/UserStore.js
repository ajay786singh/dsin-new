import { defineStore } from 'pinia';
import router from '../router';

export const UserStore = defineStore({
    id: 'UserStoreId',

    state: () => ({
        token: localStorage.getItem('token') || 0,
        authUser:null,
       /*  name:null,
        email: localStorage.getItem('email') || 0, */
      /*   user: {} || 0 */

    }),
    getters: {

         getToken: state => state.token,
       /*  getName: state => state.name, */
        /* getEmail: state => state.email, */
       /*  getUser: state => state.user,  */

        user: (state) => state.authUser,
        
    },
    actions: {

        async fetchUser() {
            if(localStorage.getItem('token')){
                const res = await  axios.get('/api/user', {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token'),
                    },
    
                }).then( ({data})=>{
                    this.authUser = data;
                    
                   
                   
                      
                }); 
            }
             
   
           
          },

        login(email, password) {
            axios.post('/api/login', {
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token'),
                },
                email: email,
                password: password,
              
            }).then(res => {
                this.authUser = res.data.user;
                  

            });
        },


        /* setUser: function () {
            this.user = {id:1,first_name:'sergios'}; */
           
          //  return new Promise((resolve, reject) => {
             /*    axios.get('/api/user', {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token'),
                    },
                }).then(res => {
                    this.user = res.data.user;
                    console.log(res.data.user);
                    console.log("loading......setter");
                    resolve(res)
                }); */
            //});
       /*  }, */



        setToken: function (token) {
            this.token = token
            localStorage.setItem('token', token);
        },


        /*  setName: function (name) {
            this.name = name
            localStorage.setItem('name', name);
        },  */

        /* setName: function () {
          return "helo";
            // localStorage.setItem('name', name);
        }, */


       /*  setEmail: function (email) {
            this.email = email
            localStorage.setItem('email', email);
        }, */


        removeToken: function () {
            this.token = 0;
            // this.email = 0;
            // this.name = 0;
            localStorage.removeItem('token');
            // localStorage.removeItem('name');
            // localStorage.removeItem('email');

        }
    },
	persist: true
});
