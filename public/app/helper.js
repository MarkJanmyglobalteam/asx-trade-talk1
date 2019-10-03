'use strict';

(function(){
     console.log('sample')	
     var helper = {
     	  layout : "/app/resources/views/" 
     }
	
	 // Initialize Firebase
	  var config = {
	    apiKey: "AIzaSyC-SrOxmcSdM6wh0rWAGknvOg3CKg0XdVY",
	    authDomain: "asx-tradetalk.firebaseapp.com",
	    databaseURL: "https://asx-tradetalk.firebaseio.com",
	    projectId: "asx-tradetalk",
	    storageBucket: "asx-tradetalk.appspot.com",
	    messagingSenderId: "863180129303"
	  };

	  firebase.initializeApp(config);
	  
})();
           