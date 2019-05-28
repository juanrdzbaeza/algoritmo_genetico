<?php
	/************************************************************************
	/ GA : Genetic Algorithms  main page
	/
	/************************************************************************/

	require_once('individual.php');		//supporting individual 
	require_once('population.php');		//supporting population 
	require_once('fitnesscalc.php');	//supporting fitnesscalc 
	require_once('algorithm.php');		//supporting fitnesscalc 


	$solution_phrase= isset($_REQUEST['solution'] )? $_REQUEST['solution'] : "Hello World!";

	header('Content-Type: text/event-stream');
	header('Cache-Control: no-cache');

	/**
	 * Construye el formato de datos SSE y vacía esos datos al cliente.
	 *
	 * @param $id Marca de tiempo / id de esta conexión.
	 * @param $msg Línea de texto que debe ser transmitida.
	 */
	function sendMsg($id, $json_msg) {
		echo "id: $id" . PHP_EOL;
		echo "event: update" . PHP_EOL;
		echo "data: $json_msg" . PHP_EOL;
		echo PHP_EOL;
		ob_flush();
		flush();
		//usleep(10000);
	}

	algorithm::$tasaCruce			= 0.50;
	algorithm::$tasaMutacion	= 0.05;
	algorithm::$tamCruce			= 15;
	$initial_population_size	= 75;
	algorithm::$maxNumGen			= 200;
	algorithm::$elitismo			= true;
	$lowest_time_s						= 100.00;
	$generationCount 					= 0;
	$generation_stagnant			= 0; 
	$most_fit 								= 0;
	$most_fit_last						= 400;



	$response = array();  // retiene el objeto JSON para ser devuelto
	$response['done']=false; // asumir no hecho

	// Establecer una clase estática de solución candidata
	fitnesscalc::setSolution($solution_phrase);

	// Crear una población inicial.
	$time1 = microtime(true);
	$myPop = new population($initial_population_size, true);

	// Evolucionar a nuestra población hasta llegar a una solución óptima.

	while ($myPop->getFittest()->getFitness() > fitnesscalc::getMaxFitness()) {
		$response['stagnant']=0;
		$generationCount++;
		$most_fit=$myPop->getFittest()->getFitness();          
		$myPop = algorithm::evolvePopulation($myPop); // crear una nueva generación.
		
		if ($most_fit < $most_fit_last) {
			// echo " *** MOST FIT ".$most_fit." Most fit last".$most_fit_last;
			$response['generation'] =$generationCount;
			$response['stagnant']=$generation_stagnant;
			$response['best_fittest_value']=$most_fit;
			$response['best_individual']= "".$myPop->getFittest();
			$most_fit_last=$most_fit;
			$generation_stagnant=0; // restablecer contador de generación estancada

			$time2 = microtime(true);
			$response['elapsed'] = round($time2-$time1,2)."s";
			$response['message'] = "<strong>Srervidor PHP Trabajando...</strong>";
			$serverTime = microtime();
			
			sendMsg($serverTime,json_encode($response) );
		} else {
			$generation_stagnant++;
		}  
		
		if ( $generation_stagnant > algorithm::$maxNumGen) {
			$response['stagnant']=$generation_stagnant;
			$response['message'] = "<strong><font color='red'>ALGORITMO DETENIDO, demasiadas</font></strong> (".algorithm::$maxNumGen.") generaciones estancadas. Mostrando el mejor esfuerzo <br>";
			break;
		}
	}  //end of while loop
	
	// LISTO ------------------------------------------
	$time2 = microtime(true);
	$response['best_fittest_value']=$most_fit;
	$response['best_individual']= "".$myPop->getFittest();
	$response['elapsed'] = round($time2-$time1,2)."s";
	$response['message'].="<strong><font color='green'>Done!</font></strong>, Algoritmo genético completado.";
	$response['done']=true;
	$serverTime = microtime();			
	sendMsg($serverTime,json_encode($response) );
	exit;

?>
