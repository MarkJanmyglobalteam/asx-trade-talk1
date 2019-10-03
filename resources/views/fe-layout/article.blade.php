@extends('fe-layout.main.app')

@section('title', 'Articles')

@section('content')	            
<div class="col-md-12 col-xs-12 right-section m-top-10" data-ng-controller="articleCtrl" id="article">
	<div class="bg-inverse ">
		<h4> &nbsp; Articles</h4>
	</div>

 <section>

   <div class="container">

     <div class="row">
       <div class="col-sm-4">
         <div class="card" >
          <img class="card-img-top img-responsive" src="/img/1.jpg" alt="Card image cap">
          <div class="card-block">
            <h4 class="card-title">Card title</h4>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
          </div>
        </div>
      </div>

       <div class="col-sm-4">
         <div class="card" >
          <img class="card-img-top img-responsive" src="/img/1.jpg" alt="Card image cap">
          <div class="card-block">
            <h4 class="card-title">Card title</h4>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
          </div>
        </div>
      </div>

       <div class="col-sm-4">
         <div class="card" >
          <img class="card-img-top img-responsive" src="/img/1.jpg" alt="Card image cap">
          <div class="card-block">
            <h4 class="card-title">Card title</h4>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
          </div>
        </div>
      </div>
       <div class="col-sm-4">
         <div class="card" >
          <img class="card-img-top img-responsive" src="/img/1.jpg" alt="Card image cap">
          <div class="card-block">
            <h4 class="card-title">Card title</h4>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
          </div>
        </div>
      </div>
       <div class="col-sm-4">
         <div class="card" >
          <img class="card-img-top img-responsive" src="/img/1.jpg" alt="Card image cap">
          <div class="card-block">
            <h4 class="card-title">Card title</h4>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
          </div>
        </div>
      </div>

       <div class="col-sm-4">
         <div class="card" >
          <img class="card-img-top img-responsive" src="/img/1.jpg" alt="Card image cap">
          <div class="card-block">
            <h4 class="card-title">Card title</h4>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
          </div>
        </div>
      </div>

       <div class="col-sm-4">
         <div class="card" >
          <img class="card-img-top img-responsive" src="/img/1.jpg" alt="Card image cap">
          <div class="card-block">
            <h4 class="card-title">Card title</h4>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
          </div>
        </div>
      </div>
       <div class="col-sm-4">
         <div class="card" >
          <img class="card-img-top img-responsive" src="/img/1.jpg" alt="Card image cap">
          <div class="card-block">
            <h4 class="card-title">Card title</h4>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

</div>
@endsection        

@section('page-js')
<!-- Controller JS -->
<script type="text/javascript" src="/app/fe-app/controllers/article.js"></script>
<!-- Factory Js -->
<script type="text/javascript" src="/app/fe-app/factories/article.js"></script>
@endsection
