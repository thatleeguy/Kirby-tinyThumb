# Kirby tinyThumb

It compresses thumbnails with [TinyPNG](https://tinypng.com/) generated with Kirby CMS.

## Instructions

### 1. Copy the files

Copy the plugin files to `site/plugins`.

Download [cacert.pem](http://curl.haxx.se/ca/cacert.pem) and add it to `site/plugins/tiny-thumb/`.

### 2. Add your API key

Add `c::set('tinypngKey', 'Your_TinyPNG_API_Key');` to your config file with your tinypng API key.

### 3. `tinyThumb()` instead of `thumb()`

Replace your `thumb()` function with the `tinyThumb()` function, like this:

```php
echo tinyThumb( $page->image( '1.png' ), array( 'width' => 300 ) );
```

You can get data from it, with the same functions as the `thumb()` like this:

```php
$thumb = tinyThumb( $page->image( '1.png' ), array( 'width' => 300 ) );
echo $thumb->width();
```

### 4. Get data from the original `thumb()`

You can get data from the original `thumb()` like this:

```php
$thumb = tinyThumb( $page->image( '1.png' ), array( 'width' => 300 ) )->thumb();
echo $thumb->filename();
```

### 5. Get data from the original `image()`

You can get data from the original `image()` like this:

```php
$thumb = tinyThumb( $page->image( '1.png' ), array( 'width' => 300 ) )->image();
echo $image->filename();
```

## Other information

### 1. Arguments

It uses the same arguments as the built in [thumb()](http://getkirby.com/docs/cheatsheet/helpers/thumb) function.

### 2. When file could not be compressed

When a file is not compressed, it will try again the next time the page loads. It will fallback to show the original thumbnail if the compressed one could not be generated. That way it will always show an image to the visitor.

### 3. When file is already compressed

If a page loads and the thumbnail has already been compressed, it will not be compressed again on each page load, only the first time.

It simply check if the compressed file already exist or not.

### 4. thumbs.filename and thumbs folder path

If the `thumbs.filename` or the thumbs folder path is changed in the config, this plugin will respect your setting and work with them.

## Version 1

Initial release

## Future features (maybe)

1. Prefix config to change "-min" that is added to compressed files
1. Add a similar plugin for images, `tinyImage()`

## Needed

1. Bug reports with detailed information how to reproduce the issue
1. Code or suggestions on code improvements
1. Requested features
1. Feedback