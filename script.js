
function run_server_ga(solution)
{
     console.log("Calling Server looking for JSON in "+solution);

	 if (!!window.EventSource) {
 
var source= new EventSource("ga_sse_server.php?solution="+solution);
 
   source.addEventListener('update', function(e)
   {
   // console.log("Receiving JSON server side events");
     var data = JSON.parse(e.data);
	  $('#best_individual').html(data.best_individual); // Clear various <spans>
		$('#best_fittest_value').text(data.best_fittest_value); //
		$('#generation').text(data.generation);
	    $('#stagnant').text(data.stagnant);
        $('#max_fitness').text(data.max_fitness);
		$('#message').html(data.message);
		$('#elapsed').text(data.elapsed);
		
		 if (data.done==true)
			source.close();
		
}, false);

source.onerror = function(e) {
  $('#message').html("EventSource failed.");
};

} else {
  $('#message').html("<strong>Sorry your Browser doesn't support SERVER SIDE Events , needed to stream the live results.</strong>-<br>Supported browsers see here: <a href='http://caniuse.com/#feat=eventsource'>http://caniuse.com/</a> ");
}

}
  
$(document).ready(function() {
  console.log("document.ready");

// When any <submit > button  is clicked 
 $('#btnRun').click( function() { 
    var solution = $("#my_solution").text();
   run_server_ga(solution); //lets go to the server and look for this string
    return false; // keeps the page form  not refreshing 
  }); //end of event handler

 });  //end document.ready