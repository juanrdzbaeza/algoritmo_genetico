<?php
require_once('individual.php');
require_once('population.php');

/**
 * Clase Algorithm.
 * 
 */
class algorithm {
  
  /**
   * Inicializacion de parametros del AG
   * 
   * Valores por defecto:
   * * $tasaCruce      = 0.5;
   * * $tasaMutacion   = 0.20;
   * * $tamCruce       = 10;
   * * $maxNumGen      = 200;
   * * $elitismo       = true;
   */
  public static $tasaCruce      = 0.5;
  public static $tasaMutacion   = 0.20;
  public static $tamCruce       = 10;
  public static $maxNumGen      = 200;
  public static $elitismo       = true;

  
  /**
   * random()
   * 
   * genera números aleatorios entre 0 y 1 y lo devuelve.
   * @return float entre 0 y 1.
   */
  private static function random() {
    return (float)rand()/(float)getrandmax();
  }
  
  /**
   * evolvePopulation($pop)
   * 
   * Función de evolución. Nuestras poblaciones tienen en cuenta
   * el elitismo, salvaguardando al mejor individuo de cada
   * población (podemos descartar esta opción estableciendo el
   * valor de la propiedad $elitismo a false).
   * 
   * Para evolucionar, primero se cruzan los individuos de la 
   * actual población atendiendo al factor de cruce, y una vez 
   * obtenida la nueva generación, se pasa por la opción de 
   * mutación que atiende al factor de mutación.
   * 
   * @param Population $pop generación actual.
   * @return Population $newPopulation nueva generación.
   */
  public static function evolvePopulation($pop) {
    // estableciendo la nueva generación
    $newPopulation = new population($pop->size(), false);
    
    /*
     * si se ha marcado la propiedad de elitismo como verdadera,
     * en la nueva población se guardará el mejor individuo de la
     * actual en la primera posicion de la siguiente.
     */

    if (algorithm::$elitismo) {
      $newPopulation->saveIndividual(0, $pop->getFittest());
	  }

    /**
     * establecemos la propiedad $evolucionElitista a 0 por defecto, 
     * si la propiedad elitismo de la clase es true este valor se
     * modifica para ponerlo a 1, si no se deja a 0 
     */
    $evolucionElitista = 0;
    if (algorithm::$elitismo) {
      $evolucionElitista = 1;
    } else {
      $evolucionElitista = 0;
    }
    
    /**
     * Recorre el tamaño de la población y crea nuevos
     * individuos cruzando a los de la generacion
     * actual utilizando las funcion de seleccion 
     * poolSelection() y la de cruce crossover().
     * Se tiene en cuenta el elitismo.
     */
    for ($i = $evolucionElitista; $i < $pop->size(); $i++) {	 
      $indiv1 = algorithm::poolSelection($pop);
      $indiv2 = algorithm::poolSelection($pop);
      $newIndiv = algorithm::crossover($indiv1, $indiv2);
      $newPopulation->saveIndividual($i, $newIndiv);
    }
    /**
     * Recorre el tamaño de la nueva población y muta los
     * individuos utilizando la funcion mutate().
     * Se tiene en cuenta el elitismo.
     */
    for ($i = $evolucionElitista; $i < $newPopulation->size(); $i++) {
      algorithm::mutate($newPopulation->getIndividual($i));
    }

    //devolvemos la nueva generacion
    return $newPopulation;
  } // fin de la evolución.

  /**
   * crossover($indiv1, $indiv2)
   * 
   * Función de cruce. Recibe dos individuos como parámetros, establece una
   * nueva solución vacía, e itera sobre los genes del primer individuo,
   * se pide un numero aleatorio a la funcion random, y si ese numero
   * es menor o igual que la tasa de cruce, se selecciona el gen que corresponda
   * al numero de vuelta para el individuo 1 y se añade a la nueva solucion,
   * en caso contrario se seleccionará el gen que corresponda al individuo 2.
   * Por ultimo se devuelve la nueva solución. METER
   * 
   * @param Individual $indiv1 primer padre.
   * @param Individual $indiv2 segundo padre.
   * @return Individual $newSol nueva solucion descendencia obtenida del cruce.
   * 
   */
  private static function crossover($indiv1, $indiv2) {
    $newSol = new individual();  // nueva descendencia.
    // Recorrer los genes.
    for ($i=0; $i < $indiv1->size(); $i++) {
      if (  algorithm::random() <= algorithm::$tasaCruce) {
        $newSol->setGene($i, $indiv1->getGene($i) );
      } else {
        $newSol->setGene($i, $indiv2->getGene($i));
      }
    }
    return $newSol;
  }

  /**
   * mutate($indiv)
   * 
   * Función de mutación. Recibe un individuo como parámetro, e itera
   * sobre sus genes, después se pide un número aleatorio a random(), y
   * si ese número es menor o igual que la tasa de mutación, se genera
   * un nuevo gen aleatorio llamando a la propiedad $characters de la 
   * clase Individual y se sustituye para el individuo en gen que 
   * corresponda al numero de vuelta. METER
   * 
   * @param individual $indiv individuo que puede ser mutado.
   * 
   */
  private static function mutate($indiv) {
    // Recorrer los genes.
    for ($i=0; $i < $indiv->size(); $i++) {
      if (algorithm::random() <= algorithm::$tasaMutacion) {
        // crea gen aleatorio
        $gene = individual::$characters[rand(0, strlen(individual::$characters) - 1)];
        //substitute the gene into the individual  
        $indiv->setGene($i, $gene); 
      }
    }
  }

  /**
   * poolSelection($pop)
   * 
   * Función de selección. se crea una nueva población de selección
   * , y se itera atendiendo al tamaño del cruce sobre la generación
   * actual, para sacar de esta los individuos que actuaran en el cruce
   * al azar, estos individuos seleccionados se añaden a la población
   * de selección, después se saca de esta selección el mejor.
   * 
   * @param Population $pop poblacion actual.
   * @return individual $fittest individuo mas apto de la selección.
   */
  private static function poolSelection($pop) {
    $pool = new population(algorithm::$tamCruce, false);
    for ($i=0; $i < algorithm::$tamCruce; $i++) {
      $randomId = rand(0, $pop->size()-1 ); // Obtener un individuo al azar desde cualquier lugar de la población
			$pool->saveIndividual($i, $pop->getIndividual($randomId));
    }
    // Get the fittest
    $fittest = $pool->getFittest();
    return $fittest;
  }

}  //class
?>