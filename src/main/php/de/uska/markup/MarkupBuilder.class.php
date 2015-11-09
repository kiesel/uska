<?php namespace de\uska\markup;

use lang\Object;
use text\StringTokenizer;

/**
 * Markup builder based on regular expressions
 *
 * @purpose  Plain text to markup converter
 */
class MarkupBuilder extends Object {
  public
    $patterns= [
      '#&(?![a-z0-9\#]+;)#',
      '#(^| )_([^_]+)_([ \.,]|$)#', 
      '#(^| )\*([^*]+)\*([ \.,]|$)#',
      '#(^| )/([^/]+)/([ \.,]|$)#',
      '#(https?://[^\)\s\t\r\n]+)#',
      '#mailto:([^@]+@.+\.[a-z]{2,8})#',
      '#(_|=|-){10,}#'
    ],
    $replacements= [
      '&amp;',
      '$1<u>$2</u>$3', 
      '$1<b>$2</b>$3',
      '$1<i>$2</i>$3',
      '<link href="$1"/>',
      '<mailto recipient="$1"/>',
      '<hr/>'
    ];

  /**
   * Retrieve markup for specified text
   *
   * @param   string text
   * @return  string
   */
  public function markupFor($text) {
    static $nl2br= ["\r" => '', "\n" => "<br/>\n"];

    $patterns= $this->patterns;
    $replacements= $this->replacements;

    $st= new StringTokenizer($text, '<>', $returnDelims= true);
    $out= '';
    $translation= $nl2br;
    while ($st->hasMoreTokens()) {
      if ('<' == ($token= $st->nextToken())) {
        
        // Found beginning of tag
        $tag= $st->nextToken('>');
        switch (strtolower($tag)) {
          case 'pre':
            $translation= [];
            $patterns= ['#[\s\t]+\n#', '#&(?![a-z0-9\#]+;)#'];
            $replacements= ["\n", '&amp;'];
            break;

          case '/pre':
            $translation= $nl2br;
            $patterns= $this->patterns;
            $replacements= $this->replacements;
            break;
        }

        $out.= '<'.$tag;
        continue;
      }
      $out.= strtr(preg_replace(
        $patterns, 
        $replacements, 
        $token
      ), $translation);
    }

    return $out;
  }
}