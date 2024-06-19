@extends('layout.main')

@section('content')

@include('include.nav')

<div class="container-fluid" style="padding: 0; min-height: 100vh; display: flex; flex-direction: column;">
    <div class="row justify-content-center flex-grow-1" style="margin: 0;">
        <div class="col-md-12" style="padding: 0;">
            <div class="form-container" style="background: linear-gradient(to right, rgba(255, 235, 59, 1), rgba(0, 0, 0, 1)); padding: 20px; min-height: 100vh;">
                <h1 class="mb-4" style="color: white; font-weight: bold;">Edit Information</h1>
                
                <form method="POST" action="{{ route('transactions.update', ['id' => $transaction->transaction_id]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        
                        <div class="col-md-3">
                            <label for="total_amount" class="form-label" style="color: white; font-weight: bold;">Total Amount</label>
                            <input type="text" class="form-control" id="total_amount" name="total_amount" value="{{ old('total_amount', $transaction->total_amount) }}" />
                            @error('total_amount') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="tendered" class="form-label" style="color: white; font-weight: bold;">Tendered</label>
                            <input type="text" class="form-control" id="tendered" name="tendered" value="{{ old('tendered', $transaction->tendered) }}" />
                            @error('tendered') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="change" class="form-label" style="color: white; font-weight: bold;">change</label>
                            <input type="text" class="form-control" id="change" name="change" value="{{ old('change', $transaction->change) }}" />
                            @error('change') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        
                        <div class="col-md-2">
                            <label for="pmethod_id" class="form-label" style="color: white; font-weight: bold;">Category</label>
                            <select class="form-select" id="pmethod_id" name="pmethod_id">
                                <option value="" selected>Select Category</option>
                                @foreach($paymentmethods as $paymentmethods)
                                <option value="{{ $paymentmethods->pmethod_id }}" {{ old('pmethod_id', $transaction->pmethod_id) == $paymentmethods->pmethod_id ? 'selected' : '' }}>{{ $paymentmethods->paymentmethods }}</option>
                                @endforeach
                            </select>
                            @error('pmethod_id') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button class="btn btn-primary" href="{{ route('transactions.index') }}">Return</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
