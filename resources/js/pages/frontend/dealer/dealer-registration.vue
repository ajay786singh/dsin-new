<script>
import axios from "axios";
import useVuelidate from "@vuelidate/core";
import { required, minLength, maxLength,helpers, alphaNum, numeric, sameAs } from "@vuelidate/validators";
import "intl-tel-input/build/css/intlTelInput.css";
import intlTelInput from "intl-tel-input";
export default {
    name: "App",
    data() {
        return {
            number: 1,
            showForm: true,
            registration_type: "individual",
            first_name: "",
            last_name: "",
            nric_no: "",
            company_name: "",
            company_registration_no: "",
            address: "",
            mobile: "",
            occupation: "",
            acceptance: "",
            showAll: false,
            submitStatus: null
        };
    },
    validations () {
        const localRules = {
            address: {
                required: helpers.withMessage("Address is required.", required),
            },
            mobile: {
                required: helpers.withMessage("Mobile/Telephone is required.", required),
                numeric: helpers.withMessage("Mobile/Telephone must contain only numbers.", numeric),
                minLength: helpers.withMessage("Mobile/Telephone must be atleast 10 digits.", minLength(10)),
                maxLength: helpers.withMessage("Mobile/Telephone should not be greater than 11 charactors.", maxLength(11)),
            },
            occupation: {
                required: helpers.withMessage("Occupation is required.", required),
            },
            acceptance: {
                sameAs: helpers.withMessage("You must accept.", sameAs(true)),
            },
        }
        if (this.registration_type=='individual') {
            localRules.first_name = {
                required: helpers.withMessage("First Name is required.", required),
                minLength: helpers.withMessage("First Name must be atleast 2 charactors.", minLength(2)),
                maxLength: helpers.withMessage("First Name should not be greater than 10 charactors.", maxLength(10)),
            },
            localRules.last_name= {
                maxLength: helpers.withMessage("Last Name should not be greater than 10 charactors.", maxLength(10)),
            },
            localRules.nric_no= {
                required: helpers.withMessage("NRIC No. is required.", required),
                alphaNum: helpers.withMessage("NRIC No. must contain only alphabets and numbers.", alphaNum),
            }
        } else {
            localRules.company_name = {
                required: helpers.withMessage("Company Name is required.", required),
            },
            localRules.company_registration_no = {
                required: helpers.withMessage("Company Registration No. is required.", required),
                alphaNum: helpers.withMessage("Company Registration No. must contain only alphabets and numbers.", alphaNum),
            }
        }
        return localRules
    },
    setup: () => ({ v$: useVuelidate() }),
    mounted() {
        const input = document.querySelector("#mobile");
        intlTelInput(input, {
            // any initialisation options go here
            preferredCountries: ["my", "us", "ca"],
        });
    },
    methods: {
        handleDealerRegistration(values, actions) {
            // display form values on success
            // values
            //this.showForm = false;
            //alert('SUCCESS!! :-)\n\n' + JSON.stringify(values, null, 4));
            //actions.resetForm()

            console.log('submit!')
            this.submitStatus = 'Submit'
            this.v$.$touch()
            if(this.v$.$invalid) {
                this.submitStatus = 'Error'
            }else {
                // do your submit logic here
                this.submitStatus = 'Pending'
                setTimeout(() => {
                    this.submitStatus = 'Success'
                }, 500)
            }

        }
    }
};
</script>
<style scoped>
.form-group.required .control-label:after {
    content: "*";
    color: red;
}
</style>
<template>
    <section class="box-plr-75">
        <div class="container">
            <div class="row">
                <div class="col-xxl-12">
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <router-link :to="{ name: '/' }">Home</router-link>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Dealer Registration
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Dealer Registration Form Starts-->
    <section class="pb-50">
        <div class="container">
            <div class="row">
                <!-- Left Box Ends -->
                <div class="col-md-8 col-lg-8 col-xl-8 offset-md-2">
                    <div class="page-heading">
                        <h4>Dealer Registration Form</h4>
                    </div>
                    <!-- Change password form starts -->
                    <form @submit.prevent="handleDealerRegistration" v-if="showForm">
                        <!-- Email input -->
                        <!--<div class="form-outline my-4 row mb-3">
                                                            <div class="col-md-12">
                                                                <label class="form-label" for="email">Email</label>
                                                                <input type="email" readonly v-model="email" id="email" name="email"
                                                                    class="form-control" />
                                                            </div>
                                                        </div>-->
                        <!-- Registration Type -->
                        <div class="form-outline row my-4 mb-3">
                            <div class="col-md-12 form-group required">
                                <label class="form-label row control-label" for="">Registration Type</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" v-model="registration_type"
                                        id="registration_type_individual" name="registration_type" value="individual"
                                        checked />
                                    <label class="form-check-label" for="registration_type_individual">Individual</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" v-model="registration_type"
                                        id="registration_type_company" name="registration_type" value="company" />
                                    <label class="form-check-label" for="registration_type_company">Company</label>
                                </div>
                            </div>
                        </div>
                        <!-- Personal Information Starts-->
                        <div id="personal-information-box" v-if="registration_type == 'individual'">
                            <div class="form-outline row my-4 mb-0">
                                <div class="col-md-12">
                                    <h5>Personal Information</h5>
                                    <hr />
                                </div>
                            </div>
                            <!-- Name input -->
                            <div class="form-outline mb-3 row">
                                <div class="col-md-6 form-group required">
                                    <label class="form-label control-label" for="first_name">First Name</label>
                                    <input type="text" class="form-control" name="first_name" v-model="v$.first_name.$model"  :class="{ valid: !v$.first_name.$error && v$.first_name.$dirty, 'is-invalid': v$.first_name.$error }" />
                                    <div class="invalid-feedback" v-for="(error, index) in v$.first_name.$errors" :key="index">
                                      {{ error.$message }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="last_name">Last Name</label>
                                    <input type="text" class="form-control" placeholder="" name="last_name" v-model="v$.last_name.$model"  :class="{ valid: !v$.last_name.$error && v$.last_name.$dirty, 'is-invalid': v$.last_name.$error }"  />
                                    <div class="invalid-feedback" v-for="(error, index) in v$.last_name.$errors" :key="index">
                                      {{ error.$message }}
                                    </div>
                                </div>
                            </div>
                            <!-- Gender -->
                            <!---<div class="form-outline row mb-3">
                                                                <div class="col-md-12">
                                                                    <label class="form-label row" for="">Gender</label>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="gender" id="gender-male"
                                                                            value="male">
                                                                        <label class="form-check-label" for="gender-male">Male</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="gender" id="gender-female"
                                                                            value="female">
                                                                        <label class="form-check-label" for="gender-female">Female</label>
                                                                    </div>
                                                                </div>
                                                            </div>-->
                            <!-- NRIC -->
                            <div class="form-outline row mb-3">
                                <div class="col-md-12 form-group required">
                                    <label class="form-label control-label" for="nric_no">NRIC No</label>
                                    <input type="text" id="nric_no" name="nric_no" class="form-control" v-model="v$.nric_no.$model"  :class="{ valid: !v$.nric_no.$error && v$.nric_no.$dirty, 'is-invalid': v$.nric_no.$error }" />
                                    <div class="invalid-feedback" v-for="(error, index) in v$.nric_no.$errors" :key="index">
                                      {{ error.$message }}
                                    </div>
                                </div>
                            </div>
                            <!-- Profile Picture input -->
                            <!--<div class="form-outline row mb-3">
                                                                <div class="col-md-12">
                                                                    <label class="form-label" for="profile_pic">NRIC Front Picture</label>
                                                                    <input type="file" id="nric_front" name="nric_front" class="form-control" />
                                                                </div>
                                                            </div>
                                                            <div class="form-outline row mb-3">
                                                                <div class="col-md-12">
                                                                    <label class="form-label" for="profile_pic">NRIC Back Picture</label>
                                                                    <input type="file" id="nric_back" name="nric_back" class="form-control" />
                                                                </div>
                                                            </div>-->
                        </div>
                        <!-- Personal Information Ends-->
                        <!-- Company Information Starts-->
                        <div id="company-information-box" v-if="registration_type == 'company'">
                            <div class="form-outline row my-4 mb-0">
                                <div class="col-md-12">
                                    <h5>Company Information</h5>
                                    <hr />
                                </div>
                            </div>
                            <!-- Company Name -->
                            <div class="form-outline row mb-3">
                                <div class="col-md-12 form-group required">
                                    <label class="form-label control-label" for="company_name">Company Name</label>
                                    <input type="text" id="company_name" name="company_name"
                                        class="form-control" v-model="v$.company_name.$model" :class="{ valid: !v$.company_name.$error && v$.company_name.$dirty, 'is-invalid': v$.company_name.$error }" />
                                    <div class="invalid-feedback" v-for="(error, index) in v$.company_name.$errors" :key="index">
                                      {{ error.$message }}
                                    </div>
                                </div>
                            </div>
                            <!-- Company Registration No -->
                            <div class="form-outline row mb-3">
                                <div class="col-md-12 form-group required">
                                    <label class="form-label control-label" for="company_registration_no">Company
                                        Registration No</label>
                                    <input type="text" id="company_registration_no"
                                        name="company_registration_no" class="form-control" v-model="v$.company_registration_no.$model" :class="{ valid: !v$.company_registration_no.$error && v$.company_registration_no.$dirty, 'is-invalid': v$.company_registration_no.$error }" />
                                    <div class="invalid-feedback" v-for="(error, index) in v$.company_registration_no.$errors" :key="index">
                                      {{ error.$message }}
                                    </div>
                                </div>
                            </div>
                            <!-- Company SSM Certificate of Incorporation -->
                            <!-- 
                                                            <div class="form-outline row mb-3">
                                                                <div class="col-md-12">
                                                                    <label class="form-label" for="company_ssm_certificate">Please upload company SSM
                                                                        Certificate of Incorporation</label>
                                                                    <input type="file" id="company_ssm_certificate" name="company_ssm_certificate"
                                                                        class="form-control" />
                                                                </div>
                                                            </div>-->
                        </div>
                        <!-- Address -->
                        <div class="form-outline row mb-3">
                            <div class="col-md-12 form-group required">
                                <label class="form-label control-label" for="address"
                                    v-if="registration_type == 'individual'">Mailing Address</label>
                                <label class="form-label control-label" for="address"
                                    v-if="registration_type == 'company'">Company Correspondence Address</label>
                                <textarea as="textarea" id="address" name="address"
                                    class="form-control" v-model="v$.address.$model" :class="{ valid: !v$.address.$error && v$.address.$dirty, 'is-invalid': v$.address.$error }"></textarea>
                                    <div class="invalid-feedback" v-for="(error, index) in v$.address.$errors" :key="index">
                                      {{ error.$message }}
                                    </div>
                            </div>
                        </div>
                        <!-- Mobile -->
                        <div class="form-outline row mb-3">
                            <div class="col-md-12 form-group required">
                                <label class="form-label control-label" for="smobile"
                                    v-if="registration_type == 'individual'">Mobile</label>
                                <label class="form-label control-label" for="smobile"
                                    v-if="registration_type == 'company'">Company Telephone</label>
                                <label class="form-label" for="mobile"></label>
                                <input type="text" id="mobile" name="mobile" class="form-control" v-model="v$.mobile.$model" :class="{ valid: !v$.mobile.$error && v$.mobile.$dirty, 'is-invalid': v$.mobile.$error }" />
                                <div class="invalid-feedback" v-if="v$.mobile.$dirty && v$.mobile.$error"  :class="{ 'd-block': v$.mobile.$dirty && v$.mobile.$error }" v-for="(error, index) in v$.mobile.$errors" :key="index">
                                    {{ error.$message }}
                                </div>
                            </div>
                        </div>
                        <!-- Occupation -->
                        <div class="form-outline row mb-3">
                            <div class="col-md-12 form-group required">
                                <label class="form-label control-label" for="occupation">Occupation</label>
                                <input type="text" id="occupation" name="occupation"
                                    class="form-control" v-model="v$.occupation.$model" :class="{ valid: !v$.occupation.$error && v$.occupation.$dirty, 'is-invalid': v$.occupation.$error }" />
                                <div class="invalid-feedback" v-for="(error, index) in v$.occupation.$errors" :key="index">
                                    {{ error.$message }}
                                </div>
                            </div>
                        </div>
                        <!-- Company Information Ends-->
                        <!-- Appointment Starts -->
                        <!--
                                                        <div class="form-outline row my-4 mb-0">
                                                            <div class="col-md-12">
                                                                <h5>APPOINTMENT</h5>
                                                                <hr>
                                                                <p>Please let us know when it's the best time we can arrange our sales team to meet you
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="form-outline row mb-3">
                                                            <div class="col-md-12">
                                                                <label class="form-label row mb-1" for="company_ssm_certificate">First Preferred
                                                                    Date/Time</label>
                                                                <div class="form-check-inline">
                                                                    <input type="date" id="company_ssm_certificate" name="company_ssm_certificate"
                                                                        class="form-control" />
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input type="time" id="company_ssm_certificate" name="company_ssm_certificate"
                                                                        class="form-control" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-outline row mb-3">
                                                            <div class="col-md-12">
                                                                <label class="form-label row mb-1" for="company_ssm_certificate">Second Preferred
                                                                    Date/Time</label>
                                                                <div class="form-check-inline">
                                                                    <input type="date" id="company_ssm_certificate" name="company_ssm_certificate"
                                                                        class="form-control" />
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input type="time" id="company_ssm_certificate" name="company_ssm_certificate"
                                                                        class="form-control" />
                                                                </div>
                                                            </div>
                                                        </div>-->
                        <!-- Appointment Ends -->
                        <!-- Declaration Starts -->
                        <div class="form-outline row my-4 mb-0">
                            <div class="col-md-12 form-group required">
                                <h5 class="control-label">
                                    DECLARATION & NOTES
                                </h5>
                                <hr />
                            </div>
                        </div>
                        <div class="form-outline row mb-3">
                            <div class="col-md-12">
                                <label class="form-label row mb-1" for="company_ssm_certificate">Notes / Comments:</label>
                                <p>
                                    Please feel free to leave us a note /
                                    comment in regards to this registration
                                    application
                                </p>
                                <textarea id="notes" name="notes" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-outline row mb-3">
                            <div class="col-md-12">
                                <label class="form-label row mb-1" for="company_ssm_certificate">
                                    We / I hereby declare that the details
                                    furnished above are true and correct to the
                                    best of my / our knowledge and belief and
                                    we/ I undertake to inform DSASB of any
                                    changes therein, immediately. In case any of
                                    the above information is found to be false
                                    or untrue or misleading or misrepresenting,
                                    we/ I am aware that we/ I may be held liable
                                    for it.
                                </label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="acceptance" id="acceptance"
                                        value="yes" v-model="v$.acceptance.$model" :class="{ valid: !v$.acceptance.$error && v$.acceptance.$dirty, 'is-invalid': v$.acceptance.$error }"  />
                                    <label class="form-check-label" for="acceptance">Yes, and proceed to submit</label>
                                    <div class="invalid-feedback" v-for="(error, index) in v$.acceptance.$errors" :key="index">
                                        {{ error.$message }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Declaration Ends -->
                        <div class="text-lg-start mt-4 pt-2 row">
                            <div class="col-md-12">
                                <button type="submit" class="site-btn">
                                    Submit
                                </button>
                            </div>
                        </div>
                        <div class="text-info" v-if="submitStatus =='Submit'">
                            {{ submitStatus }}
                        </div>
                        <div class="text-danger" v-if="submitStatus =='Error'">
                            {{ submitStatus }}
                        </div>
                        <div class="text-warning" v-if="submitStatus =='Pending'">
                            {{ submitStatus }}
                        </div>
                        <div class="text-success" v-if="submitStatus =='Success'">
                            {{ submitStatus }}
                        </div>
                    </form>
                    <!-- Change password form ends -->
                </div>
            </div>
        </div>
    </section>
<!-- Dealer Registration Form Ends-->
</template>