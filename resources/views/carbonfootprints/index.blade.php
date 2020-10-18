@extends('base')
@section('main')
<div class="row">
<div class="col-sm-12">
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}  
    </div>
  @endif
  @if(session()->get('error'))
    <div class="alert alert-danger">
      {{ session()->get('error') }}  
    </div>
  @endif
</div>
 <div class="col-sm-8 offset-sm-2">
    <h1 class="display-3">Carbon Footprint</h1>
  <div>
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
      <form method="post" action="{{ route('carbonfootprint.store') }}">
          @csrf
          <div class="form-group">    
              <label for="activity">Activity:</label>
              <input type="text" class="form-control" name="activity"/>
          </div>
          <div class="form-group">
              <label for="activity_type">Activit Type:</label>
              <select type="text" class="form-control" name="activity_type">
				<option value="miles">Miles</option>
				<option value="fuel">Fuel</option>
			  </select>
          </div>
          <div class="form-group">
              <label for="fuel_type">Fuel Type:</label>
              <select type="text" class="form-control" name="fuel_type">
				<option value="">Select</option>
				<option value="motorGasoline">motorGasoline / petrol</option>
				<option value="diesel">diesel</option>
				<option value="aviationGasoline">aviationGasoline</option>
				<option value="jetFuel">jetFuel</option>
			  </select>
          </div>
          <div class="form-group">
              <label for="mode">Mode:</label>
              <select type="text" class="form-control" name="mode">
				<option value="">Select</option>
				<option value="dieselCar">dieselCar</option>
				<option value="petrolCar">petrolCar</option>
				<option value="anyCar">anyCar</option>
				<option value="taxi">taxi</option>
				<option value="economyFlight">economyFlight</option>
				<option value="businessFlight">businessFlight</option>
				<option value="firstclassFlight">firstclassFlight</option>
				<option value="anyFlight">anyFlight</option>
				<option value="motorbike">motorbike</option>
				<option value="bus">bus</option>
				<option value="transitRail">transitRail</option>
			  </select>
          </div>
          <div class="form-group">
              <label for="country">Country:</label>
              <select type="text" class="form-control" name="country">
				<option value="def">Other countries</option>
				<option value="usa">United States</option>
				<option value="gbr">United Kingdom</option>
			  </select>
          </div>
          <button type="submit" class="btn btn-primary">Get Carbon Footprint</button>
      </form>
  </div>
</div>
</div>
@endsection