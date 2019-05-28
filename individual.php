<?php
require_once('fitnesscalc.php');

/**
 * Clase Individuo.
 * 
 */
class individual {

  /**
   * propiedades de la clase.
   * 
   * La clase Individuo tiene un string estático con todos 
   * los posibles caracteres.
   * El tamaño por defecto de los genes sera de 64.
   * Un array que contendra los genes.
   * Y un valor de fitness que denotara lo bueno que es un individuo.
   */
  public static $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-+,. ';
  public $defaultGeneLength = 64;
  public $genes = array();
  public $fitness = 0;

  /**
   * random()
   * 
   * Devuelve un numero aleatorio en punto flotante.
   * 
   * @return
   */
  public function random() {
    return (float)rand() / (float)getrandmax();
  }

  /**
   * generateIndividual($size)
   * 
   * genera un individuo con un tamaño que se le pasa por parametro, este
   * tamaño sera el resultante para el array de genes al que le pondra un 
   * caracter por cada indice segun el tamaño pasado,eligiendolo 
   * aleatoriamente desde el string characters.
   * 
   * @param $size tamaño establecido para el individuo
   */
  public function generateIndividual($size) {
    for ($i = 0; $i < $size; $i++) {
      $this->genes[$i] = individual::$characters[rand(0, strlen(individual::$characters) - 1)];
    }
  }

  /**
   * setDefaultGeneLength($length)
   * 
   * esteblece el tamaño por defecto de la cadena de genes a un valor
   * que le pasamos por parametro
   * 
   * @param $length
   */
  public function setDefaultGeneLength($length) {
    $this->defaultGeneLength = $length;
  }

  /**
   * getGene($index)
   * 
   * devuelve el valor de un gen en un indice determinado de la cadena
   * 
   * @param $index indice del que se recoge el valor de un gen
   * @return $this->genes[$index] el valor de dicho gen es ese indice
   */
  public function getGene($index) {
    return $this->genes[$index];
  }

  /**
   * setGene($index, $value)
   * 
   * establece el valor de un gen en un indice determinado de la cadena.
   * 
   * @param $index indice en el que se establece el valor de un gen
   * @param $value valor al que se establece el gen
   */
  public function setGene($index, $value) {
    $this->genes[$index] = $value;
    $this->fitness = 0;
  }

  /**
   * size()
   * 
   * devuelve el tamaño de los genes de un individuo.
   * 
   * @return count($this->genes) tamaño del atributo genes
   */
  public function size() {
    return count($this->genes);
  }

  /**
   * getFitness()
   * 
   * devuelve el fitnes de un individuo
   * 
   * @return $this->fitness fitness del individuo 
   */
  public function getFitness() {
    if ($this->fitness == 0) {
      $this->fitness = FitnessCalc::getFitness($this);
    }
    return $this->fitness;
  }

  /**
   * __toString()
   * 
   * @return $geneString
   */
  public function __toString() {
    $geneString = null;
    for ($i = 0; $i <  count($this->genes); $i++) {
      $geneString .= $this->getGene($i);
    }
    return $geneString;
  }
}// fin de la clase idividuo.
