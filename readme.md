# Kirby tinyThumb

It compresses thumbnails with [TinyPNG](https://tinypng.com/) generated with Kirby CMS.

## Instructions

### 1. Copy the files

Copy the plugin files to `site/plugins`.

Download [cacert.pem](http://curl.haxx.se/ca/cacert.pem) and add it to `site/plugins/tiny-thumb/`.

### 2. Add your API key

Add `c::set('tinypngKey', 'Your_TinyPNG_API_Key');` to your config file with your tinypng API key.

### 3. Replace thumb function

Replace your thumb function with the `tinyThumb()` function, like this:

```php
echo tinyThumb( $page->image( '1.png' ), array( 'width' => 300 ) );
```

...or get data from it, with the same function call as the original thumb function...

```php
$thumb = tinyThumb( $page->image( '1.png' ), array( 'width' => 300 ) );
echo $thumb->width();
```

## Notices

### 1. Arguments

It uses the same arguments as the built in [thumb()](http://getkirby.com/docs/cheatsheet/helpers/thumb) function.

### 2. When file could not be compressed

When a file is not compressed, it will try again the next time the page loads. It will fallback to show the visitor the original thumbnail if the compressed one could not be generated. That way it will always return an image to the visitor.

### 3. When file is already compressed

If a page loads and the thumbnail has been compressed, it will not be compressed again on each page load, only the first time.

It simply check if the compressed file exist or not.

### 4. thumbs.filename and thumbs folder path

If the `thumbs.filename` is or the thumbs folder path is changed in the config, this plugin will respect your setting.