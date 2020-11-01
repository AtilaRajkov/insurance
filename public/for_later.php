<?php

$url = "posts/index&column=name&order=desc";
$new_url =  str_replace_first('&', '?', $url);

$query_str = parse_url($new_url, PHP_URL_QUERY);
parse_str($query_str, $query_params);
print_r($query_params);

echo '<pre>' . $query_params['column'] . '</pre>';


function str_replace_first($from, $to, $content)
{
  $from = '/'.preg_quote($from, '/').'/';

  return preg_replace($from, $to, $content, 1);
}
// $new_URL =  str_replace_first('&', '?', $url);
// // outputs '123def abcdef abcdef'