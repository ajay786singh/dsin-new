<template>
  <div class="container">
    <div class="row">
      <div class="col-sm-6">
        <div class="back-billing">
          <label for="inputAddress" class="form-label-biling"
            >Billing Detail</label
          >
          <br>
          <div class="alert_billing">
          <b-alert show variant="danger" v-if='create_error'><b>{{create_error}}</b></b-alert>
        </div>
          <!-- <b-alert show variant="danger" v-if='create_error'>{{create_error}}</b-alert> -->
            <!-- <div :class="['form-group m-1 p-3', (successful ? 'alert-success' : '')]" v-show="successful">
              <span v-if="successful" class="label label-sucess">Transaction Detail Enter Sucessfully</span>
            </div> -->
          <div class="row g-3">
            <div class="row g-3">
              <div class="col">
                <label for="inputAddress" class="form-label"
                  ><b>First Name</b></label
                >
                <input
                  type="text"
                  required="required"
                  v-model="first_name"
                  class="form-control"
                  placeholder="First name"
                  aria-label="First name"
                />
              </div>
              <div class="col">
                <label for="inputAddress" class="form-label"
                  ><b>Last Name</b></label
                >
                <input
                  type="text"
                  required="required"
                  v-model="second_name"
                  class="form-control"
                  placeholder="Last name"
                  aria-label="Last name"
                />
              </div>
            </div>

            <div class="col-12">
              <label for="inputAddress" class="form-label"
                ><b>Company Name (Optional)</b></label
              >
              <input
                type="text"
                v-model="company_name"
                required="required"
                class="form-control"
                id="inputcompany"
                placeholder="Enter Company Name"
              />
            </div>
            <div class="col-12">
              <label for="inputAddress" class="form-label"
                ><b>Address</b></label
              >
              <input
                type="text"
                required="required"
                v-model="address"
                class="form-control"
                id="inputAddress"
                placeholder="House No and Street Number"
              />
            </div>
            <div class="col-12">
              <label for="inputAddress2" class="form-label"
                ><b>Address 2</b></label
              >
              <input
                type="text"
                required="required"
                v-model="address2"
                class="form-control"
                id="inputAddress2"
                placeholder="Area"
              />
            </div>
            <!-- ------------------------------ -->
            <div class="row g-3">
              <div class="col-md-4">
                <label for="inputAddress2" class="form-label"
                ><b>Country</b></label
              >
                  <select class="form-select" v-model="selectedCountry" @change="getStates" id="country" name="country">
                    <option >Select Country</option>
                    <option v-for="country in countries" :key="country.id" :value="country.id">{{ country.name }}</option>
                  </select>
                <!-- <select class="form-select" aria-label="Default select example" @change="getstate()">
                  <option selected>Select Country</option>
                  <option value="101">India</option>
                </select> -->
              </div>
              <div class="col-md-4">
                <label for="inputAddress2" class="form-label"
                ><b>State</b></label
              >
                <select class="form-select" v-model="selectedState" @change="getCities" id="state" name="state">
                  <option value="">Select State</option>
                  <option v-for="state in states" :key="state.id" :value="state.id">{{ state.name }}</option>
                </select>
              </div>
              <div class="col-md-4">
                <label for="inputAddress2" class="form-label"
                ><b>City</b></label
              >
                  <select class="form-select" v-model="selectedCity" id="city" name="city">
                    <option value="">Select City</option>
                    <option v-for="city in cities" :key="city.id" :value="city.id">{{ city.name }}</option>
                  </select>
              </div>
            </div>
            <div class="row g-3">
              <div class="col-md-4">
                <label for="inputAddress" class="form-label"
                  ><b>Phone</b></label
                >
                <input
                  type="text"
                  required="required"
                  v-model="phone"
                  maxlength="10"
                  class="form-control"
                  placeholder="Enter Phone no "
                  aria-label="First name"
                />
              </div>
              <div class="col-md-4">
                <label for="inputAddress" class="form-label"
                  ><b>Email</b></label
                >
                <input
                  type="text"
                  required="required"
                  v-model="email"
                  @blur="validateEmail"
                  class="form-control"
                  placeholder="Enter Email"
                  aria-label="Last name"
                />
              </div>
              <div class="col-md-4">
                <label for="inputAddress" class="form-label"><b>ZIP</b></label>
                <input
                  type="text"
                  v-model="zip"
                  required="required"
                  class="form-control"
                  placeholder="Enter Zip"
                  aria-label="Zip"
                />
              </div>
            </div>
            <!-- <div class="row g-3">
            <div class="col-sm-6">
              <div class="beck-billing-billing">
                <input type="radio" value="cod" v-model="payment_mode" checked />
                <label for="one"> Cash On Delivery</label>
                 <br>
                <input type="radio" value="prepaid" v-model="payment_mode" />
                <label for="two"> Prepaid</label>
              </div>
            </div>
            </div> -->
          </div>
          <!-- </div> -->
        </div>
      </div>
      <div class="col-sm-6">
        <div class="back-billing">
          <label for="inputAddress" class="form-label-biling">Your Order</label>
          <table class="table cart-table">
            <thead>
              <tr class="table-head">
                <!-- <th scope="col">Image</th> -->
                <th scope="col"><b>Product</b></th>
                <th scope="col"><b>Subtotal</b></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <!-- <td>{{ item.image }}</td> -->
                <!-- <tr> -->
                <!-- <td>
                        
                        <img :src="product.file_name" alt="" v-if="product.file_name">
                     <img src="https://vue.pixelstrap.com/voxo/_nuxt/img/3.4faefb8.jpg" alt="" v-if="!product.file_name">
                      </td> -->
                <td>
                  {{ product.product_title }} <b>x {{ quantity }}</b>
                </td>
                <td>&#8377; {{ total }}</td>
                <!-- <td>{{quantity}}</td>
                <td>{{total}}</td> -->
              </tr>
              <tr>
                <td><b>Subtotal</b></td>
                <td>
                  <b>&#8377; {{ total }}</b>
                </td>
              </tr>
              <tr>
                <td><b>Total</b></td>
                <td>
                  <b>&#8377; {{ total }}</b>
                </td>
              </tr>
            </tbody>
          </table>

          <label class="container2"
            >Cash on Delivery
            <input
              type="radio"
              checked="checked"
              value="cod"
              v-model="payment_mode" @change="getPayMode('cod')"
            />

            <span class="checkmark"></span>
          </label>

          <label class="container2"
            >Prepaid
            <input type="radio" value="prepaid" v-model="payment_mode" @change="getPayMode('prepaid')"/>

            <span class="checkmark"></span>
          </label>
          <br />

          <button id="btn_pay1" type="submit" class="block" @click="handleDealerRegistration">
            PAY
          </button>
          <!-- <p v-if="paymentSuccessful">{{paymentSuccessful}}</p> -->
          <form id="payment-form" style="display: none;">
            <div id="payment-element">
              <!-- Stripe will create form elements here -->
            </div>
          <br>
            <button type="submit" class="block" @click="handleSubmit">
              PAY
            </button>
          </form>
          <!-- <div class="col-12">
            <button type="submit" @submit.prevent="handleDealerRegistration" class="btn btn-primary">Pay</button>
            <p v-if="paymentSuccessful"><h3><b>Payment successful! Thank you for your purchase.</b></h3></p>
          </div> -->
        </div>
      </div>
    </div>

    
  </div>
  <div class="container">
    <div class="row"></div>
  </div>
</template>
<script>
// import state from "../../api/state.js";
// import city from "../../api/city.js";
import { ref, onMounted } from "vue";
const token = ref(null);
const stripe = ref(null);
const elements = ref(null);
import Swal from "sweetalert2";
import axios from "axios";
export default {
  props: ["pid"],
  data() {
    return {
      countries: [],
      states: [],
      cities: [],
      selectedCountry: 0,
      selectedState: 0,
      selectedCity: 0,
      items: [],
      address: "",
      quantity: 1,
      isLoggedIn: null,
      product: [],
      company_name: "",
      address2: "",
      zip: "",
      first_name: "",
      second_name: "",
      payment_mode: "",
      phone: "",
      successful: false,
      sortBy: "date",
      errors_create: [],
      create_error: "",
      email: "",
      total: 0,
      // paymentSuccessful: false,
      paymentMethod: "cashOnDelivery",
      cartData: [],
    };
  },
  mounted() {
    axios
      .get("/api/country")
      .then((response) => {
        this.countries = response.data;
        this.selectedCountry = response.data[0].id;
        console.log(this.selectedCountry);
        this.getStates();
      });

      // .catch(error => console.log(error));
      
    //   .then((res) => {
    //   this.id = res.data[0].id;
    //   console.log(res.data[0].id);
    // });
    this.isLoggedIn = sessionStorage.getItem("token") != null;
    if (sessionStorage.getItem("token")) {
      this.getUser();
      this.getbilling_detail();
    }
  },

  beforeMount() {
    var cartData;
    /* Code to detect if localstora ge is supported*/
    cartData = localStorage.getItem("cart_items");
    cartData = JSON.parse(cartData);
    cartData = cartData["0"];
    // console.log("cartData: " + JSON.stringify(cartData));
    // console.log("cartData: " + cartData.id);
    axios.get(`/api/products/${cartData.id}`).then((res) => {
      this.product = res.data.response;
      this.product_id = cartData.id;
      this.product_amount = res.data.response.unit_price;

      this.quantity = cartData.quantity;
      this.total = this.quantity * res.data.response.unit_price;
      console.log(this.product);
      this.onMounted(this.total);
      // console.log(this.total);
      // console.log(cartData.quantity);
      // console.log(res.data.response.product_title);
    });
    //   .then((res) => (this.product = response.data));
    // console.data(response.data);
    // console.log(JSON.stringify(this.product));
    // if (localStorage.getItem("bigStore.jwt") != null) {
    //   this.user = JSON.parse(localStorage.getItem("bigStore.user"));
    //   axios.defaults.headers.common["Content-Type"] = "application/json";
    //   axios.defaults.headers.common["Authorization"] =
    //     "Bearer " + localStorage.getItem("bigStore.jwt");
    // }
  },
  created() {
    // this.getCartItems();
  },

  methods: {
    onMounted(total_price) {
      let amt = total_price;
      console.log(amt);
      axios
        .post("/api/payment/initiate", {
          amount: amt,
          currency: "USD",
        })
        .then((response) => {
          token.value = response.data.token; // Use to identify the payment
          stripe.value = Stripe(
            "pk_test_51Mq90NSHdhhC06MMLhksJw4DVQDLJZldw6EWVaitAsKvcDic9DrnD9rAeGDCHOL909XOIm7vjRA0UuBC8ftQ4yun00EQiXwcx7"
          );
          const options = {
            clientSecret: response.data.client_secret,
          };
          elements.value = stripe.value.elements(options);
          const paymentElement = elements.value.create("payment");
          paymentElement.mount("#payment-element");
        })
        .catch((error) => {
          // throw error
        });
    },
    getPayMode(val){  
      console.log(val);
      if(val == 'cod'){
        var x = document.getElementById("payment-form");
        var x1 = document.getElementById("btn_pay1");
        x1.style.display = "block";
        x.style.display = "none";
      }
      if(val == 'prepaid'){
        var x = document.getElementById("payment-form");
        var x1 = document.getElementById("btn_pay1");
        x.style.display = "block";
        x1.style.display = "none";
      }
    },
    paymentSuccessful() {
      Swal.fire({
        icon: "success",
        title: "Payment Success!",
        text: "Your Order is Placed .",
        confirmButtonText: "OK",
      });
    },
    async handleSubmit(e) {
      e.preventDefault();

      if (this.authUser == 'undefined' || this.authUser == undefined) {
        alert("Please create your account first.");
      }else{
        const { error } = await stripe.value.confirmPayment({
          elements: elements.value,
          redirect: "if_required",
        });

        if (error === undefined) {
          this.handleDealerRegistration();
          axios.post("/api/payment/complete", {
            token: token.value,
          });
        } else {
          axios.post("/api/payment/failure", {
            token: token.value,
            code: error.code,
            description: error.message,
          });
        }
      }
    },
    async getUser() {
      console.log(sessionStorage.getItem("token"));
      if (sessionStorage.getItem("token")) {
        const res = await axios
          .get("/api/user", {
            headers: {
              Authorization: "Bearer " + sessionStorage.getItem("token"),
            },
          })
          .then(({ data }) => {
            console.log(data);
            this.authUser = data;
            this.first_name = data.first_name;
            this.second_name = data.last_name;
            this.phone = data.mobile;
            this.email = data.email;
            this.address = data.address;
            this.id = data.id;
            // this.getbilling_detail(data.id);
          });
      }
    },
    login() {
      this.$router.push({
        name: "Login",
        params: { nextUrl: this.$route.fullPath },
      });
    },
    register() {
      this.$router.push({
        name: "Register",
        params: { nextUrl: this.$route.fullPath },
      });
    },
    placeOrder(e) {
      e.preventDefault();

      let address = this.address;
      let product_id = this.product.id;
      let quantity = this.quantity;

      axios
        .post("api/orders/", { address, quantity, product_id })
        .then((response) => this.$router.push("/confirmation"));
    },
    checkUnits(e) {
      if (this.quantity > this.product.product_stocks) {
        this.quantity = this.product.product_stocks;
      }
    },
    // getcountry()
    // {
      
    //   country.getCountries()
    //   .then(( response ) => {
    //       this.country_id_array=response.data.data;
    //   })
    //   .catch(error => {
    //     console.log(error);
    //     if (error.response.status == 422){
    //      this.errors_create = error.response.data.errors;
    //     } 
    //   })
    // },
     getCities() {
        axios
          .post("/api/city",{
            state_id:this.selectedState,})
          .then((response) => {
            this.cities = response.data
          })
          .catch((error) => {

          });
      
    },
    getStates() {
        axios
          .post("/api/state",{
            country_id:this.selectedCountry,})
          .then((response) => {
          // this.statedata = response.data;
          this.states = response.data
          console.log(this.statedata);
        })
        .catch((error) => {
          // console.log(error);
          // if (error.response.status == 422) {
          //   this.errors_create = error.response.data.errors;
        });
      // }
    },
    handleDealerRegistration() {
      // console.log(this.authUser);
      if (this.authUser == 'undefined' || this.authUser == undefined) {
        alert("Please create your account first.");
      }else{
        this.create_error = "";
        if (!this.first_name) {
          this.create_error += "Enter First Name,";
        }
        if (!this.second_name) {
          this.create_error += "Enter Last Name,";
        }
        if (!this.company_name) {
            this.create_error += "Enter Company Name,";
          }
          if (!this.address) {
            this.create_error += "Enter Address,";
          }
          if (!this.address2) {
            this.create_error += "Enter Address 2,";
          }
          if (!this.selectedCountry) {
            this.create_error += "Enter Country,";
          }
          if (!this.selectedState) {
            this.create_error += "Enter State,";
          }
          if (!this.selectedCity) {
            this.create_error += "Enter City,";
          }
          if (!this.phone) {
            this.create_error += "Enter Phone No.,";
          }
          if (!this.email) {
            this.create_error += "Enter Email,";
          }
          if (!this.zip) {
            this.create_error += "Enter Company Pincode,";
          }
        if (this.create_error != "") {
          return false;
        }
      axios
        .post("/api/order_place_detail", {
          uid: this.authUser.id,
          first_name: this.first_name,
          second_name: this.second_name,
          company_name: this.company_name,
          address: this.address,
          address2: this.address2,
          selectedCountry: this.selectedCountry,
          selectedState: this.selectedState,
          selectedCity: this.selectedCity,
          zip: this.zip,
          phone: this.phone,
          email: this.email,
          payment_mode: this.payment_mode,
          product_id: this.product_id,
          quantity: this.quantity,
          amount: this.product_amount,
          total: this.total,
        })
        .then((response) => {
          // this.isLoading = false;
          // this.showForm = false;
          // this.submitStatus = "Success";
          this.msg = response.data;
          this.address = response.data.address;
          this.uid = response.data.id;
           this.successful = true;
            this.error = true;

          console.log(this.address);
          this.paymentSuccessful();
          localStorage.removeItem("cart_items");
          setTimeout(function () {
            window.location.href = "/";
          }, 2000);
          console.log(this.msg);
          //alert(response.data.msg);
        })
        .catch((error) => {
          console.log(error);
          if (error.response.status == 422) {
            this.errors_create = error.response.data.errors;
          }
        });
      }
    },
    //     getbilling_detail()
    //     {
    // axios.get("/api/billing_detail",{uid})
    // .then((response) => {
    // 				this.our_products = response.data;
    // 				console.log(this.our_products);
    // 			});
    //     },
    async getbilling_detail() {
      //AXIOS GETTING AUTHENTICATED USER_ID
      try {
        await axios
          .get("/api/user", {
            headers: {
              Authorization: localStorage.getItem("token"),
            },
          })
          .then((userresponse) => {
            axios
              .post("/api/billing_detail", {
                id: userresponse.data.id,
              })
              .then((res) => {
                // var data = JSON.parse(res.data[0].data);
                console.log(res.data[0].address);
                console.log(res.data[0].address2);

                this.address = res.data[0].address;
                this.address2 = res.data[0].address2;
                this.zip = res.data[0].zip;
              });
          });
      } catch (error) {
        console.log(error);
      } finally {
        this.loading = false;
      }

      /  /;
    },
    validateEmail() {
      if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.email)) {
        this.msg["email"] = "Please enter a valid email address";
      } else {
        this.msg["email"] = "";
      }
    },
  },
};
</script>
<style>
.back-billing {
  margin-bottom: 40px;
}
.box {
  background-color: #f5f5f5;
  height: 50px;
  width: 200px;
  border: 1px solid #ccc;
  padding: 10px;
  margin: 10px;
  text-align: center;
  background-color: rgba(82, 153, 235);
}
.container {
  margin-left: 100px;
}
.back-billing {
  background-color: rgba(248, 249, 250);
  padding: 5%;
}
.form-label-biling {
  font-weight: bold;
  font-size: 20px;
  margin-bottom: 15px;
  color: #3c80d2;
}
.beck-billing-billing {
  background-color: rgba(248, 249, 250);
  padding: 5%;
  color: black;
}
.payment_class {
  font-weight: bold;
  font-size: 15px;
  margin-bottom: 15px;
  color: #3c80d2;
  width: 700px;
}
.cart-section .cart-table {
  overflow: hidden;
  margin-bottom: 0;
}

.cart-section .cart-table thead th {
  border-bottom-width: 1px;
  font-weight: 600;
  color: #212529;
  text-transform: uppercase;
  font-size: 15px;
  border-top: 0;
  text-align: center;
  border-bottom: 1px solid #eff2f7 !important;
  padding: 12px;
  background-color: #eff2f7;
}

.cart-section tbody tr td {
  vertical-align: middle;
  color: #212529;
  border-top: 0;
  border-bottom: 1px solid #c7c7c5 !important;
  text-align: center;
  min-width: 175px;
}

.cart-table tbody tr td a {
  color: #7e7e7e;
  white-space: nowrap;
  font-weight: 400;
  font-size: 14px;
  text-transform: capitalize;
  margin-bottom: 0;
  display: inline-block;
}

.cart-table tbody tr td a.remove-cart-porduct {
  font-size: 20px;
  font-weight: bold;
  margin-right: 10px;
}

.cart-section tbody tr td a img {
  height: 80px;
}

.cart-section tbody tr td .mobile-cart-content {
  display: none;
  justify-content: center;
  margin-top: 10px;
}

.cart-section tbody tr td h2 {
  font-size: 20px;
  color: var(--color-primary);
  font-weight: 400;
}

.cart-section tbody tr td .qty-box .input-group {
  display: block;
}

.cart-section tbody tr td .qty-box .input-group .form-control {
  width: 75px;
  margin: 0 auto;
  text-align: center;
  padding: 5px;
  height: 50px;
}

.cart-section .left-side-button {
  display: flex;
  align-items: center;
}

.cart-section .cart-checkout-section {
  margin-top: 30px;
}

.cart-section .cart-checkout-section .checkout-button {
  text-align: right;
}

.cart-section .cart-checkout-section .cart-checkout-box {
  background-color: #eff2f7;
  border-radius: 10px;
  overflow: hidden;
  padding: 0;
}

.cart-section
  .cart-checkout-section
  .cart-checkout-box
  .cart-box-details
  .total-details
  .top-details {
  border-bottom: 1px solid #c7c7c5;
  padding: 22px;
  margin-bottom: 0;
}

.cart-section
  .cart-checkout-section
  .cart-checkout-box
  .cart-box-details
  .total-details
  .top-details
  h6 {
  line-height: 1.9;
  color: #212529;
}

.cart-section
  .cart-checkout-section
  .cart-checkout-box
  .cart-box-details
  .total-details
  span {
  float: right;
}

.cart-section
  .cart-checkout-section
  .cart-checkout-box
  .cart-box-details
  .total-details
  .bottom-details
  a {
  background-color: #0163d2;
  background-color: var(--color-primary);
  width: 100%;
  display: block;
  padding: 12px 0;
  text-align: center;
  color: #fff;
  font-weight: 500;
  letter-spacing: 1.2px;
}
.block {
  display: block;
  width: 100%;
  border: none;
  background-color: black;
  color: white;
  padding: 8px 28px;
  font-size: 25px;
  cursor: pointer;
  text-align: center;
  border-radius: 12px;
}

.block:hover {
  background-color: green;
  color: black;
}

/* The container */
.container2 {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 16px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default radio button */
.container2 input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

/* Create a custom radio button */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;
  border-radius: 50%;
}

/* On mouse-over, add a grey background color */
.container2:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.container2 input:checked ~ .checkmark {
  background-color: #2196f3;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the indicator (dot/circle) when checked */
.container2 input:checked ~ .checkmark:after {
  display: block;
}

/* Style the indicator (dot/circle) */
.container2 .checkmark:after {
  top: 9px;
  left: 9px;
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: white;
}
.alert_billing {
padding: 8px;
color: red;
}
</style>
