<?php
require_once('individual.php');  

/**
 * Clase Población.
 *
 */
class Population {

  /**
   * propiedades de la clase.
   * 
   * La clase Poblacion tiene un array de individuos.
   */
  public $people=array();
	
  /**
   * Constructor
   * 
   * Crea una poblacion.
   */
  function __construct($populationSize, $initialise=false) {
    if (!isset($populationSize) || $populationSize == 0){ 
      die("Deberias elegir un tamaño mayor para la poblacion inicial");
    }
    /**
     * inicializando el array de la clase, añadimos un individuo por vuelta.
     */
     for ($i = 0; $i < $populationSize; $i++){
      $this->people[$i] = new individual();
    }
    // Initialise population
    if ($initialise) {
    // Loop and create individuals
      for ($i = 0; $i < count($this->people); $i++) {
        $new_person = new individual();
        $new_person->generateIndividual(count(fitnesscalc::$solution));
        $this->saveIndividual($i, $new_person );
      }
    }
  } // function __construct($populationSize,$initialise=false) 

	/**
   * getFittest()
   * 
   * Encuentra al individuo más apto de la población y lo devuelve.
   * 
   * @return $fittest el mas apto
   */
  public function getFittest() {
    $fittest = $this->people[0];  //
    for ($i = 0; $i < $this->size(); $i++) {
      if ($fittest->getFitness() >= $this->people[$i]->getFitness() ) {
        $fittest = $this->people[$i];
      }
		} 
    return $fittest;
  }

  /**
   * getIndividual($index)
   * 
   * encuentra el individuo que se encuentra en el array en la
   * posicion que se le pasa como parametro y lo devuelve
   * 
   * @param $index indice en el que se encuentra el individuo que buscamos
   * @return $this->people[$index] devuelve el individuo en un indice del array.
   */
  public function getIndividual($index) {
    return  $this->people[$index];
  }
	
  /**
   * size()
   * 
   * devuelve el tamaño de la poblacion.
   * 
   * @return $this->people devuelve el tamaño de la población.
   */
  public function size() {
    return count($this->people);
  }

  /**
   * saveIndividual()
   * 
   * Guardar individuo.
   * 
   * @param $index indice donde se debe guardar el individuo.
   * @param $indiv individuo a guradar.
   */
  public function saveIndividual($index, $indiv) {
      $this->people[$index] = $indiv;
  }
	
  /**
   * compareFitness($a, $b)
   * compara el fitnes de dos individuos.
   *
   * @param $a primer individuo
   * 
   * @param $b segundo individuo
   * 
   * @return devuelve -1 si el fitnes de a es menor que el de b, en caso contrario devuelve 1. si se da el caso de que los fitnes son iguales devuelve 0.
   */
	function compareFitness($a, $b) { 
    if($a->getFitness() == $b->getFitness()) {
      return 0;
    } 
    return ($a->getFitness() < $b->getFitness()) ? -1 : 1;
	}

  /**
   * sortPopulation()
   *
   * ordena Una poblacion por el fittnes.
   *
   * La condición física aquí es una función de costo, por lo tanto, menor es mejor
   * condición física.
   *
   * @return $this->people el array people ordenado.
   */
  function sortPopulation() {
    return usort($this->people,array('population',"compareFitness"));
	}

  /**
   * __toString()
   * 
   * Imprime la poblacion y el fitnes para usos de debug.
   *
   * @return $population_string 
   */
  public function __toString() {
    $population_string=null;
    for ($i = 0; $i <  count($this->people); $i++) {
      $population_string.="\n Individual: ".$this->people[$i]." Fitness:".$this->people[$i]->getFitness();
    }
    return $population_string;    
  }
  		
} // fin de la calse población

?>