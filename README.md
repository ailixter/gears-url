# gears-url
Yet another URL class implementation.

``` php
$url = new URL('http://httpbin.org/get');
$url->setQueryParam('p', 'test');
echo $url->path;
print_r($url->query);
$url->path = 'post';
echo $url;
```

``` php
echo (new URL)
  ->setScheme('http')
  ->setHost('httpbin.org')
  ->setQuery(['p' -> 'test'])
  ;
```
