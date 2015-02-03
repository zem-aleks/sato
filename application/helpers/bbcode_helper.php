<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Конвертирует тэги BBCode в HTML.
 * 
 * @author Alexander Makarov
 * @link http://rmcreative.ru/
 * @param String $markup
 */
function bbcode($markup){
    $markup = str_replace('&', '&', $markup);
    $markup = str_replace('<', '<', $markup);
    $markup = str_replace('>', '>', $markup);
    $preg = array(     
          // Text arrtibutes
          '~\[s\](.*?)\[\/s\]~si'        => '<del>$1</del>',
          '~\[b\](.*?)\[\/b\]~si'                 => '<strong>$1</strong>',
          '~\[i\](.*?)\[\/i\]~si'                 => '<em>$1</em>',
          '~\[u\](.*?)\[\/u\]~si'                 => '<u>$1</u>',
          '~\[color=(.*?)\](.*?)\[\/color\]~si'   => '<span style="color:$1">$2</span>',
          
          //align
          '~\[leftfloat\](.*?)\[\/leftfloat\]~si' => '<div style="float: left">$1</div>',
          '~\[rightfloat\](.*?)\[\/rightfloat\]~si' => '<div style="float: right">$1</div>',
          '~\[center\](.*?)\[\/center\]~si'       => '<div style="text-align: center">$1</div>',
          '~\[left\](.*?)\[\/left\]~si'           => '<div style="text-align: left">$1</div>',
          '~\[right\](.*?)\[\/right\]~si'         => '<div style="text-align: right">$1</div>',
          //headers
          '~\[h1\](.*?)\[\/h1\]~si'               => '<h3>$1</h3>',
          '~\[h2\](.*?)\[\/h2\]~si'               => '<h4>$1</h4>',
          '~\[h3\](.*?)\[\/h3\]~si'               => '<h5>$1</h5>',
          '~\[h4\](.*?)\[\/h1\]~si'               => '<h6>$1</h6>',
          '~\[h5\](.*?)\[\/h2\]~si'               => '<h6>$1</h6>',
          '~\[h6\](.*?)\[\/h3\]~si'               => '<h6>$1</h6>',

          // [code=language][/code]
          '~\[code\](.*?)\[\/code\]~si'              => '<pre><code class="no-highlight">$1</code></pre>',         
          '~\[code=(.*?)\](.*?)\[\/code\]~si'     => '<pre><code class="$1">$2</code></pre>',               

          // email with indexing prevention & @ replacement
          '~\[email\](.*?)\[\/email\]~sei'         => "'<a rel=\"noindex\" href=\"mailto:'.str_replace('@', '.at.','$1').'\">'.str_replace('@', '.at.','$1').'</a>'",
          '~\[email=(.*?)\](.*?)\[\/email\]~sei'   => "'<a rel=\"noindex\" href=\"mailto:'.str_replace('@', '.at.','$1').'\">$2</a>'",
          
          // links
          '~\[url\]www\.(.*?)\[\/url\]~si'        => '<a href="http://www.$1">$1</a>',
          '~\[url\](.*?)\[\/url\]~si'             => '<a href="$1">$1</a>',
          '~\[url=(.*?)?\](.*?)\[\/url\]~si'      => '<a href="$1">$2</a>',
          // images
          '~\[img\](.*?)\[\/img\]~si'             => '<img src="$1" alt="$1"/>',
          '~\[img=(.*?)x(.*?)\](.*?)\[\/img\]~si' => '<img src="$3" alt="$3" style="width: $1px; height: $2px"/>',
          // quoting
          '~\[quote\](.*?)\[\/quote\]~si'         => '<span class="quote">$1</span>',
          '~\[quote=(?:"|"|\')?(.*?)["\']?(?:"|"|\')?\](.*?)\[\/quote\]~si'   => '<span class="quote"><strong class="src">$1:</strong>$2</span>',

          //new line to <br>
          '~\n~' => '<br/>',
  );
  
  return preg_replace(array_keys($preg), array_values($preg), $markup);
}