<template>
<div>
    <header class="white pt-3 relative shadow">
            <div class="container-fluid">
                <div class="row p-t-b-10 ">
                    <div class="col">
                        <div class="pb-3">
                            <div class="image mr-3  float-left">
                                <img class="user_avatar no-b no-p" src="/goukur/img/dummy/u1.png" alt="User Image">
                            </div>
                            <div>
                                <h6 class="p-t-10">Ardan</h6>
                                ardan@atrbpn.go.id
                            </div>
                        </div>
                    </div>
                </div>

              <!-- <div class="row">
                  <ul class="nav nav-material responsive-tab" id="v-pills-tab" role="tablist">
                      <li>
                          <a class="nav-link active" id="v-pills-tab1-tab" data-toggle="pill" href="#v-pills-tab1" role="tab" aria-controls="v-pills-tab1">
                              <i class="icon icon-home2"></i>Home
                          </a>
                      </li>
                  </ul>
              </div> -->

            </div>
        </header>

        <div class="container-fluid animatedParent animateOnce my-3">
            <div class="animated fadeInUpShort go">
           <div class="tab-content" id="v-pills-tabContent">
               <div class="tab-pane fade show active" id="v-pills-tab1" role="tabpanel" aria-labelledby="v-pills-home-tab">
                   <div class="row">
                       <div class="col-md-9">

                           <div class="row">
                               <div class="col-lg-4">
                                   <div class="card r-3">
                                       <div class="p-4">
                                           <div class="float-right">
                                               <span class="icon-award text-light-blue s-48"></span>
                                           </div>
                                           <div class="counter-title">Ranking</div>
                                           <h5 class="sc-counter mt-3">5th</h5>
                                       </div>
                                   </div>
                               </div>
                               <div class="col-lg-4">
                                   <div class="card r-3">
                                       <div class="p-4">
                                           <div class="float-right"><span class="icon-stop-watch3 s-48"></span>
                                           </div>
                                           <div class="counter-title ">Jatuh Tempo</div>
                                           <h5 class="sc-counter mt-3">12</h5>
                                       </div>
                                   </div>
                               </div>
                               <div class="col-lg-4">
                                   <div class="white card">
                                       <div class="p-4">
                                           <div class="float-right"><span class="icon-orders s-48"></span>
                                           </div>
                                           <div class="counter-title">Nilai Keseluruhan</div>
                                           <h5 class="sc-counter mt-3">92.67%</h5>
                                       </div>
                                   </div>
                               </div>
                           </div>

                           <div class="row my-3">
                               <!-- bar charts group -->
                               <div class="col-md-12">
                                   <div class="card">
                                       <div class="card-header white">
                                           <h6>Perfomance <small>Sessions</small></h6>
                                       </div>
                                       <div class="card-body">
                                           <div id="graphx" class="height-300"></div>
                                       </div>
                                   </div>
                               </div>
                               <!-- /bar charts group -->
                           </div>
                       </div>

                       <div class="col-md-3">
                           <div class="card ">

                               <ul class="list-group list-group-flush">
                                   <li class="list-group-item"><i class="icon icon-mobile text-primary"></i><strong class="s-12">Phone</strong> <span class="float-right s-12">+91 333470 456 99</span></li>
                                   <li class="list-group-item"><i class="icon icon-mail text-success"></i><strong class="s-12">Email</strong> <span class="float-right s-12">abc@atrbpn.go.id</span></li>
                                   <li class="list-group-item"><i class="icon icon-address-card-o text-warning"></i><strong class="s-12">Address</strong> <span class="float-right s-12">Banda Aceh, Aceh</span></li>
                               </ul>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
        </div>
</div>
</template>
