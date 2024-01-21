@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Payment Processing') }}</div>

                <div class="card-body">
                    <form action="{{ route('pay') }}" method="POST" id="paymentForm">
                        @csrf
                        <div class="row">
                            <div class="col-auto">
                                <label>$20 a month</label>
                                <input type="hidden" value="12" name="value" class="form-control">
                            </div>
                            <div class="col-auto">
                                <label>Currency</label>
                                <select name="currency" >
                                    @foreach($currencies as $currency)
                                        <option value="{{$currency->iso}}" @if($currency->iso = 'usd') selected  @endif>{{strToUpper($currency->iso)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <small class="text-muted">Muted text</small>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label>Select the desirec payment platform</label>
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
                    {{-- @if ($session->has('success'))
                    <div class="alert alert-success" role="alert">
                        <ul>
                            @foreach($session->get('success') as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
