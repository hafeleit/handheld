@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="row">
              <div class="col-xl-6">
                  <div class="row">

                    <div class="col-auto">
                      <a href="{{ROUTE('picking')}}">
                        <div class="avatar avatar-xl position-relative">
                          <img src="/img/picking.png" alt="profile_image" class="w-100 border-radius-lg shadow-sm" style="padding: 2px;">
                        </div>
                        <div class="text-uppercase text-center text-sm">
                          Picking
                        </div>
                      </a>
                    </div>

                    <div class="col-auto" style="text-align:center">
                      <a href="#">
                        <div class="avatar avatar-xl position-relative">
                          <img src="/img/pgh.png" alt="profile_image" class="w-100 border-radius-lg shadow-sm" style="padding: 2px;">
                        </div>
                        <div class="text-uppercase text-center text-sm">
                          pigeonhole
                        </div>
                      </a>
                    </div>
                  </div>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
