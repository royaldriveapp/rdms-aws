<div class="row">
     <div class="col-md-3 col-sm-4 col-xs-6">
          <div class="card card-stats">
               <!-- Card body -->
               <div class="card-body">
                    <div class="row">
                         <div class="col">
                              <h5 class="card-title text-uppercase text-muted mb-0">Total Inbound</h5>
                              <span class="h2 font-weight-bold mb-0"><?php echo count($pbxDailyCalls['total']); ?></span>
                         </div>
                         <div class="col-auto">
                              <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                   <i class="fa fa-arrow-down"></i>
                              </div>
                         </div>
                    </div>
<!--                                             <p class="mt-3 mb-0 text-sm">
                         <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                         <span class="text-nowrap">Since last month</span>
                    </p>-->
               </div>
          </div>
     </div>
     <div class="col-md-3 col-sm-4 col-xs-6">
          <div class="card card-stats">
               <!-- Card body -->
               <div class="card-body">
                    <div class="row">
                         <div class="col">
                              <h5 class="card-title text-uppercase text-muted mb-0">Connected</h5>
                              <span class="h2 font-weight-bold mb-0"><?php echo count($pbxDailyCalls['connected']); ?></span>
                         </div>
                         <div class="col-auto">
                              <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                   <i class="fa fa-chain"></i>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
     <div class="col-md-3 col-sm-4 col-xs-6">
          <div class="card card-stats">
               <!-- Card body -->
               <div class="card-body">
                    <div class="row">
                         <div class="col">
                              <h5 class="card-title text-uppercase text-muted mb-0">Missed</h5>
                              <span class="h2 font-weight-bold mb-0"><?php echo count($pbxDailyCalls['noanswer']); ?></span>
                         </div>
                         <div class="col-auto">
                              <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                   <i class="fa fa-phone"></i>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
     <div class="col-md-3 col-sm-4 col-xs-6">
          <div class="card card-stats">
               <!-- Card body -->
               <div class="card-body">
                    <div class="row">
                         <div class="col">
                              <h5 class="card-title text-uppercase text-muted mb-0">Cancel</h5>
                              <span class="h2 font-weight-bold mb-0"><?php echo count($pbxDailyCalls['cancel']); ?></span>
                         </div>
                         <div class="col-auto">
                              <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                   <i class="fa fa-phone"></i>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
     <div class="col-md-3 col-sm-4 col-xs-6">
          <div class="card card-stats">
               <!-- Card body -->
               <div class="card-body">
                    <div class="row">
                         <div class="col">
                              <h5 class="card-title text-uppercase text-muted mb-0">Not connected</h5>
                              <span class="h2 font-weight-bold mb-0"><?php echo count($pbxDailyCalls['notconnected']); ?></span>
                         </div>
                         <div class="col-auto">
                              <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                   <i class="fa fa-phone"></i>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
     <div class="col-md-3 col-sm-4 col-xs-6">
          <div class="card card-stats">
               <!-- Card body -->
               <div class="card-body">
                    <div class="row">
                         <div class="col">
                              <h5 class="card-title text-uppercase text-muted mb-0">Chanel unavailable</h5>
                              <span class="h2 font-weight-bold mb-0"><?php echo count($pbxDailyCalls['chanlunavl']); ?></span>
                         </div>
                         <div class="col-auto">
                              <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                   <i class="fa fa-phone"></i>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
     <div class="col-md-3 col-sm-4 col-xs-6">
          <div class="card card-stats">
               <!-- Card body -->
               <div class="card-body">
                    <div class="row">
                         <div class="col">
                              <h5 class="card-title text-uppercase text-muted mb-0">Congestion</h5>
                              <span class="h2 font-weight-bold mb-0"><?php echo count($pbxDailyCalls['congestion']); ?></span>
                         </div>
                         <div class="col-auto">
                              <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                   <i class="fa fa-phone"></i>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
     <div class="col-md-3 col-sm-4 col-xs-6">
          <div class="card card-stats">
               <!-- Card body -->
               <div class="card-body">
                    <div class="row">
                         <div class="col">
                              <h5 class="card-title text-uppercase text-muted mb-0">Busy</h5>
                              <span class="h2 font-weight-bold mb-0"><?php echo count($pbxDailyCalls['busy']); ?></span>
                         </div>
                         <div class="col-auto">
                              <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                   <i class="fa fa-phone"></i>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
     
     <!-- DID Based -->
     <div class="col-md-3 col-sm-4 col-xs-6">
          <div class="card card-stats">
               <!-- Card body -->
               <div class="card-body">
                    <div class="row">
                         <div class="col">
                              <h5 class="card-title text-uppercase text-muted mb-0">914847136855</h5>
                              <span class="h2 font-weight-bold mb-0"><?php echo count($pbxDailyCalls['did1']); ?></span>
                         </div>
                         <div class="col-auto">
                              <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                   <i class="fa fa-phone"></i>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
     
     <div class="col-md-3 col-sm-4 col-xs-6">
          <div class="card card-stats">
               <!-- Card body -->
               <div class="card-body">
                    <div class="row">
                         <div class="col">
                              <h5 class="card-title text-uppercase text-muted mb-0">914847136856</h5>
                              <span class="h2 font-weight-bold mb-0"><?php echo count($pbxDailyCalls['did2']); ?></span>
                         </div>
                         <div class="col-auto">
                              <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                   <i class="fa fa-phone"></i>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
     
     <div class="col-md-3 col-sm-4 col-xs-6">
          <div class="card card-stats">
               <!-- Card body -->
               <div class="card-body">
                    <div class="row">
                         <div class="col">
                              <h5 class="card-title text-uppercase text-muted mb-0">914847136682</h5>
                              <span class="h2 font-weight-bold mb-0"><?php echo count($pbxDailyCalls['did3']); ?></span>
                         </div>
                         <div class="col-auto">
                              <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                   <i class="fa fa-phone"></i>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>