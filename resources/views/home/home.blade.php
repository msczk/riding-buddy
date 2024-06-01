@extends('layout.layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Coming trips</h1>
            </div>
        </div>
        <div class="row">
            @forelse ($coming_trips as $coming_trip)
              <x-Trip.TripThumbnail :trip=$coming_trip />
            @empty
              <div class="col">
                <p class="text-center">No coming trips for the moment</p>
              </div>
            @endforelse
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col">
                <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
                    <h1 class="display-4 fw-normal text-body-emphasis">Pricing</h1>
                    <p class="fs-5 text-body-secondary">Quickly build an effective pricing table for your potential customers with this Bootstrap example. It’s built with default Bootstrap components and utilities with little customization.</p>
                </div>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
            <div class="col">
              <div class="card mb-4 rounded-3 shadow-sm">
                <div class="card-header py-3">
                  <h4 class="my-0 fw-normal">Free</h4>
                </div>
                <div class="card-body">
                  <h1 class="card-title pricing-card-title">$0<small class="text-body-secondary fw-light">/mo</small></h1>
                  <ul class="list-unstyled mt-3 mb-4">
                    <li>10 users included</li>
                    <li>2 GB of storage</li>
                    <li>Email support</li>
                    <li>Help center access</li>
                  </ul>
                  <button type="button" class="w-100 btn btn-lg btn-outline-primary">Sign up for free</button>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card mb-4 rounded-3 shadow-sm">
                <div class="card-header py-3">
                  <h4 class="my-0 fw-normal">Pro</h4>
                </div>
                <div class="card-body">
                  <h1 class="card-title pricing-card-title">$15<small class="text-body-secondary fw-light">/mo</small></h1>
                  <ul class="list-unstyled mt-3 mb-4">
                    <li>20 users included</li>
                    <li>10 GB of storage</li>
                    <li>Priority email support</li>
                    <li>Help center access</li>
                  </ul>
                  <button type="button" class="w-100 btn btn-lg btn-primary">Get started</button>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card mb-4 rounded-3 shadow-sm border-primary">
                <div class="card-header py-3 text-bg-primary border-primary">
                  <h4 class="my-0 fw-normal">Enterprise</h4>
                </div>
                <div class="card-body">
                  <h1 class="card-title pricing-card-title">$29<small class="text-body-secondary fw-light">/mo</small></h1>
                  <ul class="list-unstyled mt-3 mb-4">
                    <li>30 users included</li>
                    <li>15 GB of storage</li>
                    <li>Phone and email support</li>
                    <li>Help center access</li>
                  </ul>
                  <button type="button" class="w-100 btn btn-lg btn-primary">Contact us</button>
                </div>
              </div>
            </div>
          </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Last users</h1>
            </div>
        </div>
        <div class="row">
            @forelse ($last_users as $last_user)
            <x-Profile.ProfileThumbnail :user=$last_user />
            @empty
            <div class="col">
              <p class="text-center">No new users for the moment</p>
            </div>
            @endforelse
        </div>
    </div>
@endsection