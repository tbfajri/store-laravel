@extends('layouts.dashboard')

@section('title')
    Account Dashboard
@endsection

@section('content')
    <div id="page-content-wrapper">
      <div
        class="section-content section-dashboard-home"
        data-aos="fade-up"
      >
        <div class="container-fluid">
          <div class="dashboard-heading">
            <h2 class="dashboard-title">My Account</h2>
            <p class="dashboard-subtitle">Update your current profile</p>
          </div>
          <div class="dashboard-content">
            <div class="row">
              <div class="col-12">
                <form action="{{ route('dashboard-settings-redirect', 'dashboard-settings-account')}}" method="POST" enctype="multipart/form-data" id="locations">
                  @csrf
                  <input type="hidden" value="{{ $user->provinces_id }}" id="provinces_id">
                  <input type="hidden" value="{{ $user->regencies_id }}" id="regencies_id">
                  <div class="card">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="name">Your Name</label>
                            <input
                              type="text"
                              class="form-control"
                              name="name"
                              id="name"
                              value="{{ $user->name }}"
                            />
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="Email">Your Email</label>
                            <input
                              type="email"
                              class="form-control"
                              name="email"
                              id="email"
                              value="{{ $user->email }}"
                            />
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="address_one">Address 1</label>
                            <input
                              type="text"
                              class="form-control"
                              name="address_one"
                              id="address_one"
                              value="{{ $user->address_one}}"
                            />
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="address_two">Address 2</label>
                            <input
                              type="text"
                              class="form-control"
                              name="address_two"
                              id="address_two"
                              value="{{ $user->address_two }}"
                            />
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="province">Province</label>
                             <select name="provinces_id" id="provinces_id" class="form-control" v-if="provinces" v-model="provinces_id">
                              <option v-for="province in provinces" :value="province.id" {{ ($user->provinces_id == "province.id") ? 'selected' : ''  }}>@{{ province.name }}</option>
                            </select>
                            <select v-else class="form-control">
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="city">City</label>
                            <select name="regencies_id" id="regencies_id" class="form-control" v-if="regencies" v-model="regencies_id">
                              <option v-for="regency in regencies" :value="regency.id"  >@{{ regency.name }}</option>
                            </select>
                            <select v-else class="form-control"></select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="zip_code">Postal Code</label>
                            <input
                              type="text"
                              class="form-control"
                              name="zip_code"
                              id="zip_code"
                              value="{{ $user->zip_code}}"
                            />
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="country">Country</label>
                            <input
                              type="text"
                              class="form-control"
                              name="country"
                              id="country"
                              value="Setra Duta Cemara"
                            />
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="phone_number">Mobile</label>
                            <input
                              type="text"
                              class="form-control"
                              name="phone_number"
                              id="phone_number"
                              value="+628 2020 1111"
                            />
                          </div>
                        </div>
                      </div>
                      <div class="row mt-5">
                        <div class="col text-right">
                          <button
                            type="submit"
                            class="btn btn-success px-5"
                          >
                            Save Now
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
      var provinces_id = $("#provinces_id").val();
      var regencies_id = $("#regencies_id").val();
      var locations = new Vue({
        el: "#locations",
        mounted() {
          AOS.init();
          this.getProvincesData();
          this.getRegenciesData();
        },
        data: {
          provinces: null,
          regencies: null,
          provinces_id: this.provinces_id,
          regencies_id: this.regencies_id
        },
        methods: {
            getProvincesData(){
              var self = this;
              axios.get('{{ route('api-provinces') }}')
                .then(function(response) {
                  self.provinces = response.data;
                });
            },
            getRegenciesData(){
              var self = this;
              axios.get('{{ url('api/regencies') }}/' + self.provinces_id )
                .then(function(response) {
                  self.regencies = response.data;
                });
            }
        },
        watch: {
          provinces_id: function(val, oldVal) {
            this.regencies_id = null;
            this.getRegenciesData();
          }
        }
      });
    </script>
@endpush