<?php
require_once('individual.php');

/**
 * Clase Fitnesscalc.
 * 
 */
class fitnesscalc {

  /**
   * propiedades de la clase.
   * 
   * La clase Fitnesscalc tiene un array de individuos posible solución.
   */
  public static  $solution =  array();

  /**
   * setSolution($newSolution)
   * 
   * establece como posible solución la que se le pasa como parametro
   */
  static function setSolution($newSolution) {
    fitnesscalc::$solution = str_split($newSolution);
    // print_r(fitnesscalc::$solution);
  }

  /**
   * getFitness($individual)
   * 
   * Calcula el fitness de un individuo comparandolo con los de 
   * la solucion candidata.
   * los valores de condición física bajos son mejores, 
   * 0 = la condición física meta es realmente una función 
   * de costo en este caso. METER
   * 
   * @param $individual individuo a comparar.
   * @return $fitness fitness comparado.
   */
  static function  getFitness($individual) {
    $fitness = 0;
    $sol_count = count(fitnesscalc::$solution);

    // Recorre los genes de nuestros individuos y compara con nuestros candidatos.
    for ($i = 0; $i < $individual->size() && $i < $sol_count; $i++) {
      $char_diff = 0;
      $char_diff = abs(ord($individual->getGene($i)) - ord(fitnesscalc::$solution[$i]));
      $fitness += $char_diff; // mejor fitness cuanto mas bajo.
    }
    return $fitness;
  }

  /**
   * getMaxFitness()
   * 
   */
  static function getMaxFitness() {
    $maxFitness = 0; // las coincidencias máximas suponen que cada personaje exacto produce fitness 1
    return $maxFitness;
  }
}  //end class
