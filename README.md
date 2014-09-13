yii-email-obfuscator
=====================

Email obfuscatior plugin for Yii.

This plugin combines some Email obfuscation technics.

 * The @ char is removed and only its index is passed on. It will be reinserted using the expression String.fromCharCode(4*2*2*4).
 * The address itself will be transmitted as a ROT13 transformed string which will be retransformed by Javascript.
 * The "mailto:" prefix is decoded as a reversed string which gets unreversed by Javascript. 

The Email address "mail@example.com" will result in the following code:

```js
<script type="text/javascript">
var action=":otliam".split("").reverse().join("");
var href="znvyrknzcyr.pbz".replace(/[a-zA-Z]/g, function(c){return String.fromCharCode((c<="Z"?90:122)>=(c=c.charCodeAt(0)+13)?c:c-26);});
href=href.substr(0, 4) + String.fromCharCode(4*2*2*4) + href.substr(4);
var a = "<a href=\""+action+href+"\">"+href+"</a>";
document.write(a);
</script>
```

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require "farmani/yii-email-obfuscator" "dev-master"
```

or add

```
"farmani/yii-email-obfuscator": "dev-master"
```

to the require section of your `composer.json` file.


Usage
-----

Simply insert this in your template:
```php
<?= Yii::app()->obfuscator->disguise('email@example.com',true); ?>
```