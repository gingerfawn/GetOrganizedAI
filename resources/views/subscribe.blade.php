@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card payment-form-no-radio">
                <div class="card-header">Subscribe</div>

                <div class="card-body">
                    <form action="{{ route('subscribe.store') }}" method="POST" id="paymentForm">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <label>Select your plan</label>
                                <div class="form-group">
                                    <div class="btn-group" data-bs-toggle="buttons">
                                        @foreach($plans as $plan)
                                            <label 
                                                class='btn btn-outline-secondary rounded m-2 p-3'>
                                            <input 
                                                type="radio" 
                                                name='plan'
                                                value="{{ $plan->slug }}">
                                            <p class="h2 font-weight-bold text-capitalize">{{ $plan->slug }}</p>
                                            <p class="display-4 text-capitalize">
                                                {{ $plan->visual_price }}
                                            </p>
                                        </label>
                                        @endforeach
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label>Select the desired payment platform</label>
                                <div class="form-group" id="toggler">
                                    <div class="btn-group btn-group-toggle" data-bs-toggle="buttons">
                                        @foreach($paymentPlatforms as $paymentPlatform)
                                            <label 
                                                class='btn btn-outline-secondary rounded m-2 p-1' 
                                                data-bs-target="#{{ $paymentPlatform->name }}Collapse"
                                                data-bs-toggle="collapse">
                                            <input 
                                                type="radio" 
                                                name='payment_platform'
                                                value="{{ $paymentPlatform->id }}">
                                            <img class="img-thumbnail-cc" src="{{ asset($paymentPlatform->image)}}">
                                        </label>
                                        @endforeach
                                    </div>
                                    @foreach($paymentPlatforms as $paymentPlatform)
                                        <div 
                                            id="{{ $paymentPlatform->name }}Collapse"
                                            class="collapse"
                                            data-bs-parent="#toggler">
                                            @includeIf('components.'. strToLower($paymentPlatform->name) .'-collapse')
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <button type="submit" class="btn" id="payButton">Subscribe</button>
                        </div>
                    </form>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (isset($errors) && $errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        <ul>
                            @foreach(session()->get('success') as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
