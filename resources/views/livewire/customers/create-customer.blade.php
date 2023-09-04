

    <div class="bs-stepper checkout-tab-steps">
  <div class="bs-stepper-header">
    <div class="step" data-target="#customer-details">
      <button type="button" class="step-trigger">
        <span class="bs-stepper-box">
          <i data-feather="user" class="font-medium-3"></i>
        </span>
        <span class="bs-stepper-label">
          <span class="bs-stepper-title">Customer Details</span>
          <span class="bs-stepper-subtitle">Customers Information</span>
        </span>
      </button>
    </div>
    <div class="line">
      <i data-feather="chevron-right" class="font-medium-2"></i>
    </div>
    <div class="step" data-target="#step-address">
      <button type="button" class="step-trigger">
        <span class="bs-stepper-box">
          <i data-feather="home" class="font-medium-3"></i>
        </span>
        <span class="bs-stepper-label">
          <span class="bs-stepper-title">Address</span>
          <span class="bs-stepper-subtitle">Enter Your Address</span>
        </span>
      </button>
    </div>
    <div class="line">
      <i data-feather="chevron-right" class="font-medium-2"></i>
    </div>
    <div class="step" data-target="#step-payment">
      <button type="button" class="step-trigger">
        <span class="bs-stepper-box">
          <i data-feather="credit-card" class="font-medium-3"></i>
        </span>
        <span class="bs-stepper-label">
          <span class="bs-stepper-title">Submit</span>
          <span class="bs-stepper-subtitle">Save & Submit</span>
        </span>
      </button>
    </div>
  </div>


  <div wire:ignore.self class="bs-stepper-content">
  <div id="customer-details" class="content">
      <form id="checkout-address" class="list-view product-checkout">
     
        <div class="card">
          <div class="card-header flex-column align-items-start">
            <h4 class="card-title">Customer information</h4>
            <p class="card-text text-muted mt-25">Be sure to enter correct information</p>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6 col-sm-12">
                <div class="form-group mb-2">
                  <label for="checkout-name">Customer Name:</label>
                  <input type="text" id="name" class="form-control" name="name" placeholder="Outlet Name" />
                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="form-group mb-2">
                  <label for="checkout-name">Contact Person Name:</label>
                  <input type="text" id="name" class="form-control" name="name" placeholder="Full Name" />
                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="form-group mb-2">
                  <label for="checkout-number">Contact Person Phone Number:</label>
                  <input
                    type="number"
                    id="phone_number"
                    class="form-control"
                    name="phone_number"
                    placeholder="0123456789"
                  />
                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="form-group mb-2">
                  <label for="checkout-number">Alternative Contact Person Phone Number:</label>
                  <input
                    type="number"
                    id="telephone"
                    class="form-control"
                    name="telephone"
                    placeholder="0123456789"
                  />
                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="form-group mb-2">
                  <label for="checkout-number"> Email:</label>
                  <input
                    type="email"
                    id="telephone"
                    class="form-control"
                    name="email"
                    placeholder="Email"
                  />
                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="form-group mb-2">
                  <label for="add-type">Manufacturer Number:</label>
                  <input
                    type="text"
                    id="manufacturer_number"
                    class="form-control"
                    name="manufacturer_number"
                    placeholder="Manufacturer Number"
                  />
                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="form-group mb-2">
                  <label for="add-type">VAT Number:</label>
                  <input
                    type="text"
                    id="vat_number"
                    class="form-control"
                    name="vat_number"
                    placeholder="VAT Number"
                  />
                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="form-group mb-2">
                  <label for="add-type">Customer Group:</label>
                  <select class="form-control" id="add-type">
                         <option>Select</option>
                    @foreach ($outlets as $outlet)
                        <option value="{{ $outlet->outlet_name }}">{{ $outlet->outlet_name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

             
              <div class="col-12 d-flex justify-content-center">
                    <button type="button" class="btn btn-primary btn-next delivery-address"> Next </button>
                </div>
            </div>
          </div>
        </div>


   
      </form>
    </div>
   

    <div wire:ignore.self id="step-address" class="content" >
      <form wire:ignore.self id="checkout-address" class="list-view product-checkout">

        <div class="card">
          <div class="card-header flex-column align-items-start">
            <h4 class="card-title">Add New Address</h4>
            <p class="card-text text-muted mt-25">Be sure to check "Deliver to this address" when you have finished</p>
          </div>
          <div class="card-body">
            <div class="row">
            <div class="col-md-6 col-sm-12">
                                    <div class="form-group mb-2">
                                      <label for="add-type">Address:</label>
                                      <input
                                        type="text"
                                        id="address"
                                        class="form-control"
                                        name="address"
                                        placeholder="Address"
                                      />
                                    </div>
                                  </div>

                                  <div class="col-md-6 col-sm-12">
                                    <div class="form-group mb-2">
                                      <label for="add-type">Postal Zipcode:</label>
                                      <input
                                        type="text"
                                        id="address"
                                        class="form-control"
                                        name="address"
                                        placeholder="Address"
                                      />
                                    </div>
                                  </div>

                                  <div class="col-md-6 col-sm-12">
                                    <div class="form-group mb-2">
                                      <label for="add-type"> City:</label>
                                      <input
                                        type="text"
                                        id="address"
                                        class="form-control"
                                        name="address"
                                        placeholder="Address"
                                      />
                                    </div>
                                  </div>


                                  <div class="col-md-6 col-sm-12">
                                    <div class="form-group mb-2">
                                      <label for="add-type"> Latitude:</label>
                                      <input
                                        type="text"
                                        id="address"
                                        class="form-control"
                                        name="address"
                                        placeholder="Address"
                                      />
                                    </div>
                                  </div>


                                  <div class="col-md-6 col-sm-12">
                                    <div class="form-group mb-2">
                                      <label for="add-type"> Longitude:</label>
                                      <input
                                        type="text"
                                        id="address"
                                        class="form-control"
                                        name="address"
                                        placeholder="Address"
                                      />
                                    </div>
                                  </div>
          <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="region"> Country</label>
                                        <select wire:model="selectedRegion" id="region" class="form-control">
                                            <option value="">Select Country</option>
                                            @foreach ($regions as $region)
                                                <option value="{{ $region->id }}">{{ $region->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @if ($subregions && $subregions->count() > 0)
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="subregion"> County: </label>
                                            <select wire:model="selectedSubregion" id="subregion" class="form-control">
                                                <option value="">Select County</option>
                                                @foreach ($subregions as $subregion)
                                                    <option value="{{ $subregion->id }}">{{ $subregion->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif

                                @if ($areas && $areas->count() > 0)
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="area"> Route: </label>
                                            <select wire:model="selectedArea" id="area" class="form-control">
                                                <option value="">Select Route</option>
                                                @foreach ($areas as $area)
                                                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif

                               
                         
              <div class="col-12 d-flex justify-content-center">
                      <button type="button" class="btn btn-primary  btn-next delivery-address mt-2">
                        Next
                      </button>
                </div>
            </div>
          </div>
        </div>
    

      
      </form>
    </div>

    <div wire:ignore.self id="step-payment" class="content">
      <form id="checkout-payment" class="list-view product-checkout" onsubmit="return false;">
        <div class="payment-type">
          <div class="card">
            <div class="card-header flex-column align-items-start">
              <h4 class="card-title"> Customer Status</h4>
              <p class="card-text text-muted mt-25">Be sure to click on correct Status option</p>
            </div>
            <div class="card-body">
       
   
              <hr class="my-2" />
              <ul class="other-payment-options list-unstyled">
                <li class="py-50">
                  <div class="custom-control custom-radio">
                    <input type="radio" id="customColorRadio2" name="Active" class="custom-control-input" />
                    <label class="custom-control-label" for="customColorRadio2"> Activate </label>
                  </div>
                </li>
                <li class="py-50">
                  <div class="custom-control custom-radio">
                    <input type="radio" id="customColorRadio3" name="Suspend" class="custom-control-input" />
                    <label class="custom-control-label" for="customColorRadio3"> Disable </label>
                  </div>
                </li>
                
              </ul>
              <hr class="my-2" />
              <div class="col-12 d-flex justify-content-center" >
                  <button type="button" class="btn btn-primary btn-next delivery-address mr-2">Save</button>
                  <a href="{{ route('customer') }}" class="btn btn-outline-secondary">Cancel</a>
              </div>


            </div>
          </div>
        </div>

      </form>
    </div>
  </div>
</div>

