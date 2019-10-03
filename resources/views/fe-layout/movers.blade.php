@extends('fe-layout.main.app')

@section('title', 'Top Movers')

@section('content')
<div class="bg-inverse">
		<h4> &nbsp; Top Movers</h4>
	</div>	      
<div class="container" id="topMovers">

	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<li class="active">
			<a data-toggle="tab" href="#gainers" role="tab">
				Gainers
			</a>
		</li>
		<li class="nav-item">
			<a data-toggle="tab" href="#losers" role="tab">
				Losers
			</a>
		</li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane active" id="gainers" role="tabpanel">
			<ul class="list-group">
				<!--titleheader-->
				<li class="list-group-item tab-header">
					<div class="row">
						<div class="col-md-2 col-sm-2 col-xs-12 stock">
							<label>Symbol</label>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12 stock">
							<label>Company name</label>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2 stock">
							<label>Price</label>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2 stock">
							<label>Gain</label>
						</div>
					</div>
				</li>
				<li class="list-group-item">
					<div class="row">
						<div class="col-md-2 col-sm-2 col-xs-12 remove_padding">
							<label>THR</label>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12 remove_padding">
							<label>THOR MINING PLC</label>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2 remove_padding">
							<label>3.3¢</label>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-10 remove_padding">
							<label class="label label-success">50.0%</label>
						</div>
					</div>
				</li>
				<li class="list-group-item">
					<div class="row">
						<div class="col-md-2 col-sm-2 col-xs-12 remove_padding">
							<label>THR</label>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12 remove_padding">
							<label>THOR MINING PLC</label>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2 remove_padding">
							<label>3.3¢</label>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-10 remove_padding">
							<label class="label label-success">50.0%</label>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</div>
</div>


@endsection        

@section('page-js')
<!-- Controller JS -->
<script type="text/javascript" src="/app/fe-app/controllers/article.js"></script>
<!-- Factory Js -->
<script type="text/javascript" src="/app/fe-app/factories/article.js"></script>
@endsection