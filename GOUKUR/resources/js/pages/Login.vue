<template>
<div class="page parallel">
    <div class="d-flex row">
        <div class="col-md-4 white" style="z-index: 100">
            <div class="p-5 mt-5">
                <h1 class="font-weight-bold"><i class="icon-room"></i> GO-UKUR.</h1>
            </div>
            <div class="p-5">
                <h3>Welcome Back</h3>
                <p>Hey Soldier welcome back signin now there is lot of
                    new stuff waiting
                    for you</p>
                <div class="alert alert-danger pb-0" v-if="has_error">
                    <p>Error.</p>
                </div>
                <form action="index.html">
                    <div class="form-group has-icon"><i class="icon-envelope-o"></i>
                        <input type="text" v-model="email" class="form-control form-control-lg"
                               placeholder="Email Address">
                    </div>
                    <div class="form-group has-icon"><i class="icon-user-secret"></i>
                        <input type="password" v-model="password" class="form-control form-control-lg"
                               placeholder="Password">
                    </div>
                    <input v-if="hasLogin" type="button" @click="login" class="btn btn-success btn-lg btn-block" value="Log In">
                    <router-link :to="{ name: 'daftar' }" class="btn btn-secondary btn-lg btn-block">Form Daftar</router-link>
                </form>
            </div>
        </div>
        <div class="col-md-8 height-full align-self-center text-center d-none d-lg-block" data-bg-repeat="false" data-bg-possition="center">
            <ul class="cb-slideshow">
                <li><span>Image 01</span><div></div></li>
                <li><span>Image 02</span><div></div></li>
                <li><span>Image 03</span><div></div></li>
                <li><span>Image 04</span><div></div></li>
                <li><span>Image 05</span><div></div></li>
                <li><span>Image 06</span><div></div></li>
            </ul>
        </div>
    </div>
</div>
</template>

<script>
import router from '../router'
export default {
    data() {
        return {
            email: null,
            password: null,
            has_error: false,
            hasLogin: true
        }
    },
    mounted() {
        console.log(this.$auth)
    },
    methods: {
        login() {
            // get the redirect object
            this.hasLogin = false
            var redirect = this.$auth.redirect()
            var app = this
            this.$auth.login({
                params: {
                    email: app.email,
                    password: app.password
                },
                success: (res) => {
                    setTimeout(() => {
                        console.log(this.$auth.user())
                        const redirectTo = this.$auth.user().hak_akses == 1 ? 'dashboard' : this.$auth.user().hak_akses == 2 ? 'dashboard-operator' : this.$auth.user().hak_akses == 3 ? 'dashboard-petugas' : this.$auth.user().hak_akses == 4 ? 'berkas-ppat' : '/'
                        
                        if (redirectTo != '/') {
                            this.$router.push({
                                name: redirectTo
                            })
                        } else {
                            app.has_error = true
                            app.hasLogin = true
                        }
                        
                    }, 2000);
                },
                error: function () {
                    app.has_error = true
                    app.hasLogin = true
                },
                rememberMe: true,
                fetchUser: true
            })
        }
    }
}
</script>

<style>
    .background {
        background-image: url("https://cdn.stocksnap.io/img-thumbs/960w/foggy-mountain_ID16LRJKNW.jpg");

        /* Full height */
        height: 100%;

        /* Center and scale the image nicely */
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    .cb-slideshow,
.cb-slideshow:after { 
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0px;
    left: 0px;
    z-index: 0; 
}
.cb-slideshow:after { 
    content: '';
    background: transparent url('') repeat top left; 
}
.cb-slideshow li span { 
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0px;
    left: 200px;
    color: transparent;
    background-size: cover;
    background-position: 50% 50%;
    background-repeat: none;
    opacity: 0;
    z-index: 0;
	-webkit-backface-visibility: hidden;
    -webkit-animation: imageAnimation 36s linear infinite 0s;
    -moz-animation: imageAnimation 36s linear infinite 0s;
    -o-animation: imageAnimation 36s linear infinite 0s;
    -ms-animation: imageAnimation 36s linear infinite 0s;
    animation: imageAnimation 36s linear infinite 0s; 
}
.cb-slideshow li div { 
    z-index: 1000;
    position: absolute;
    bottom: 30px;
    left: 0px;
    width: 100%;
    text-align: center;
    opacity: 0;
    color: #fff;
    -webkit-animation: titleAnimation 36s linear infinite 0s;
    -moz-animation: titleAnimation 36s linear infinite 0s;
    -o-animation: titleAnimation 36s linear infinite 0s;
    -ms-animation: titleAnimation 36s linear infinite 0s;
    animation: titleAnimation 36s linear infinite 0s; 
}
.cb-slideshow li div h3 { 
    font-family: 'BebasNeueRegular', 'Arial Narrow', Arial, sans-serif;
    font-size: 240px;
    padding: 0;
    line-height: 200px; 
}
.cb-slideshow li:nth-child(1) span { 
    background-image: url('https://www.datawisata.com/wp-content/uploads/2018/02/puncak-gunung-Geurute-Aceh-Jaya.jpg') 
}
.cb-slideshow li:nth-child(2) span { 
    background-image: url('http://www.pasirpantai.com/wp-content/uploads/2014/07/panorama-resort-anoi-itam-659x436.jpg');
    -webkit-animation-delay: 6s;
    -moz-animation-delay: 6s;
    -o-animation-delay: 6s;
    -ms-animation-delay: 6s;
    animation-delay: 6s; 
}
.cb-slideshow li:nth-child(3) span { 
    background-image: url('https://cdn.stocksnap.io/img-thumbs/960w/fog-mountain_ZKN6UKFKEO.jpg');
    -webkit-animation-delay: 12s;
    -moz-animation-delay: 12s;
    -o-animation-delay: 12s;
    -ms-animation-delay: 12s;
    animation-delay: 12s; 
}
.cb-slideshow li:nth-child(4) span { 
    background-image: url('https://cdn.stocksnap.io/img-thumbs/960w/dark-trees_TU32SMFSBL.jpg');
    -webkit-animation-delay: 18s;
    -moz-animation-delay: 18s;
    -o-animation-delay: 18s;
    -ms-animation-delay: 18s;
    animation-delay: 18s; 
}
.cb-slideshow li:nth-child(5) span { 
    background-image: url('https://cdn.stocksnap.io/img-thumbs/960w/fog-mountain_OLGRLKRE4Z.jpg');
    -webkit-animation-delay: 24s;
    -moz-animation-delay: 24s;
    -o-animation-delay: 24s;
    -ms-animation-delay: 24s;
    animation-delay: 24s; 
}
.cb-slideshow li:nth-child(6) span { 
    background-image: url('https://cdn.stocksnap.io/img-thumbs/960w/fishing-village_UQSCIYTHV0.jpg');
    -webkit-animation-delay: 30s;
    -moz-animation-delay: 30s;
    -o-animation-delay: 30s;
    -ms-animation-delay: 30s;
    animation-delay: 30s; 
}
.cb-slideshow li:nth-child(2) div { 
    -webkit-animation-delay: 6s;
    -moz-animation-delay: 6s;
    -o-animation-delay: 6s;
    -ms-animation-delay: 6s;
    animation-delay: 6s; 
}
.cb-slideshow li:nth-child(3) div { 
    -webkit-animation-delay: 12s;
    -moz-animation-delay: 12s;
    -o-animation-delay: 12s;
    -ms-animation-delay: 12s;
    animation-delay: 12s; 
}
.cb-slideshow li:nth-child(4) div { 
    -webkit-animation-delay: 18s;
    -moz-animation-delay: 18s;
    -o-animation-delay: 18s;
    -ms-animation-delay: 18s;
    animation-delay: 18s; 
}
.cb-slideshow li:nth-child(5) div { 
    -webkit-animation-delay: 24s;
    -moz-animation-delay: 24s;
    -o-animation-delay: 24s;
    -ms-animation-delay: 24s;
    animation-delay: 24s; 
}
.cb-slideshow li:nth-child(6) div { 
    -webkit-animation-delay: 30s;
    -moz-animation-delay: 30s;
    -o-animation-delay: 30s;
    -ms-animation-delay: 30s;
    animation-delay: 30s; 
}
/* Animation for the slideshow images */
@-webkit-keyframes imageAnimation { 
    0% { opacity: 0;
    -webkit-animation-timing-function: ease-in; }
    8% { opacity: 1;
         -webkit-animation-timing-function: ease-out; }
    17% { opacity: 1 }
    25% { opacity: 0 }
    100% { opacity: 0 }
}
@-moz-keyframes imageAnimation { 
    0% { opacity: 0;
    -moz-animation-timing-function: ease-in; }
    8% { opacity: 1;
         -moz-animation-timing-function: ease-out; }
    17% { opacity: 1 }
    25% { opacity: 0 }
    100% { opacity: 0 }
}
@-o-keyframes imageAnimation { 
    0% { opacity: 0;
    -o-animation-timing-function: ease-in; }
    8% { opacity: 1;
         -o-animation-timing-function: ease-out; }
    17% { opacity: 1 }
    25% { opacity: 0 }
    100% { opacity: 0 }
}
@-ms-keyframes imageAnimation { 
    0% { opacity: 0;
    -ms-animation-timing-function: ease-in; }
    8% { opacity: 1;
         -ms-animation-timing-function: ease-out; }
    17% { opacity: 1 }
    25% { opacity: 0 }
    100% { opacity: 0 }
}
@keyframes imageAnimation { 
    0% { opacity: 0;
    animation-timing-function: ease-in; }
    8% { opacity: 1;
         animation-timing-function: ease-out; }
    17% { opacity: 1 }
    25% { opacity: 0 }
    100% { opacity: 0 }
}
/* Animation for the title */
@-webkit-keyframes titleAnimation { 
    0% { opacity: 0 }
    8% { opacity: 1 }
    17% { opacity: 1 }
    19% { opacity: 0 }
    100% { opacity: 0 }
}
@-moz-keyframes titleAnimation { 
    0% { opacity: 0 }
    8% { opacity: 1 }
    17% { opacity: 1 }
    19% { opacity: 0 }
    100% { opacity: 0 }
}
@-o-keyframes titleAnimation { 
    0% { opacity: 0 }
    8% { opacity: 1 }
    17% { opacity: 1 }
    19% { opacity: 0 }
    100% { opacity: 0 }
}
@-ms-keyframes titleAnimation { 
    0% { opacity: 0 }
    8% { opacity: 1 }
    17% { opacity: 1 }
    19% { opacity: 0 }
    100% { opacity: 0 }
}
@keyframes titleAnimation { 
    0% { opacity: 0 }
    8% { opacity: 1 }
    17% { opacity: 1 }
    19% { opacity: 0 }
    100% { opacity: 0 }
}
/* Show at least something when animations not supported */
.no-cssanimations .cb-slideshow li span{
	opacity: 1;
}

@media screen and (max-width: 1140px) { 
    .cb-slideshow li div h3 { font-size: 140px }
}
@media screen and (max-width: 600px) { 
    .cb-slideshow li div h3 { font-size: 80px }
}
</style>