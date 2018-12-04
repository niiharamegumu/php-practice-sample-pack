<?php
class FormHelper {
  protected $values = array();

  public function __construct ( $values = [] ) {
    if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
      $this->values = $_POST;
    } else {
      $this->values = $values;
    }
  }

  public function input ( $type, $attributes = [], $isMultiple = false ) {
    $attributes['type'] = $type;
    if ( ($type === 'radio') || ($type === 'checkbox') ) {
      if ( $this->isOptionSelected($attributes['name'] ?? Null, $attributes['value'] ?? Null) ) {
        $attributes['checked'] = true;
      }
    }
    return $this->tag('input', $attributes, $isMultiple);
  }

  public function select ( $options, $attributes = [] ) {
    $multiple = $attributes['multiple'] ?? false;
    return
      $this->start('select', $attributes, $multiple) .
      $this->options($attributes['name'] ?? Null, $options) .
      $this->end('select');
  }

  public function textarea ( $attributes = [] ) {
    $name = $attributes['name'] ?? Null;
    $value = $this->values['name'] ?? '';
    return
      $this->start('textarea', $attributes) .
      htmlentities($value) .
      $this->end('textarea');
  }

  public function tag ( $tag, $attributes = [], $isMultiple = false ) {
    return "<$tag {$this->attributes($attributes, $isMultiple)}>";
  }

  public function start ( $tag, $attributes = [], $isMultiple = false ) {
    $valueAttrivute = ( !(($tag === 'select') || ( $tag === 'textarea' )) );
    $attrs = $this->attributes($attributes, $isMultiple, $valueAttrivute);
    return "<$tag $attrs>";
  }

  public function end ( $tag ) {
    return "</$tag>";
  }

  protected function attributes ( $attributes, $isMultiple, $valueAttrivute = true ) {
    $tmp = [];
    if ( $valueAttrivute && isset($attributes['name'])
         && array_key_exists($attributes['name'], $this->values) ) {
      $attributes['value'] = $this->values[$attributes['name']];
    }
    foreach ( $attributes as $k => $v ) {
      if ( is_bool($v) ) {
        if ( $v ) { $tmp[] = $this->encode($k); }
      } else {
        $value = $this->encode($v);
        if ( $isMultiple && ($k === 'name') ) {
          $value .= '[]';
        }
        $tmp[] = "$k=\"$value\"";
      }
    }
    return implode(' ', $tmp);
  }

  protected function options ( $name, $options ) {
    $tmp = [];
    foreach ( $options as $k => $v ) {
      $s = "<option value=\"{$this->encode($k)}\"";
      if ( $this->isOptionSelected($name, $k) ) {
        $s .= ' selected';
      }
      $s .= ">{$this->encode($v)}</option>";
      $tmp[] = $s;
    }
    return implode('', $tmp);
  }

  protected function isOptionSelected ( $name, $value ) {
    if ( !isset($this->values[$name]) ) {
      return false;
    } elseif ( is_array($this->values[$name]) ) {
      return in_array($value, $this->values[$name]);
    } else {
      return $value === $this->values[$name];
    }
  }

  public function encode ( $s ) {
    return htmlentities($s);
  }

}
