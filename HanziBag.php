<?php namespace HanziBag;

class HanziBag {

  public $characters;

  public function __construct($input)
  {
    if (is_array($input))
    {
      $this->characters = implode('', $this->sanitizeArray($input));
    }
    else
    {
      $this->characters = $this->sanitizeInput($input);
    }
  }

  /**
   * sanitizes an array of items, unsets all non-Chinese
   * 
   * @param  array $input
   * @return array
   */
  protected function sanitizeArray(array $input)
  {
    foreach($input as $key => $value)
    {
      $sanitized = $this->sanitizeInput($value);
      if($sanitized !== '')
      {
        $input[$key] = $sanitized;
      }
      else
      {
        unset($input[$key]);
      }
      
    }
    return $input;
  }

  /**
   * sanitizes the user input
   * 
   * @param  string $input
   * @return string
   */
  protected function sanitizeInput($input)
  {
    return $this->stripNonChinese(trim($input));
  }

  /**
   * removes all non-Chinese characters from the string
   * 
   * @param  string $input
   * @return string
   */
  protected function stripNonChinese($input)
  {
    return preg_replace('/[^\x{4e00}-\x{9fa5}]/u', '', $input);
  }

  /**
   * converts the string of Chinese characters into an array
   * 
   * @return array
   */
  protected function toArray()
  {
    return str_split($this->characters, 3);
  }

  /**
   * returns whether a character exists in the collection
   * 
   * @param  string $character
   * @return boolean
   */
  public function contains($character)
  {
    return strpos($this->characters, $character) !== false;
  }

  /**
   * returns a new instance of the class with just the unique characters
   * 
   * @return array
   */
  public function unique()
  {
    return new static(array_unique($this->toArray()));
  }

  /**
   * returns the characters in json format
   * 
   * @return string json
   */
  public function toJson()
  {
    return json_encode($this);
  }

  /**
   * returns the characters are a string
   * 
   * @param  string $delimiter
   * @return string
   */
  public function toString($delimiter = '')
  {
    return implode($delimiter, $this->toArray());
  }

}