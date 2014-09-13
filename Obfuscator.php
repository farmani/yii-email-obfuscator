<?php
/**
 * Class to obfuscate email addresses, then defuscate them with jQuery
 *
 * Contains an edited version of
 * Email Defuscator - jQuery plugin 1.0 alpha Copyright (c) 2007 Joakim Stai
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 *
 * Contains jQuery rot13 function from
 *   http://onehackoranother.com/projects/jquery/jquery-grab-bag/
 *
 * @package Obfuscator
 * @author Ramin Farnani <ramin.farmani@gmail.com>
 * @copyright (C) 2014 Ramin Farmani
 * @version 0.1
 */
namespace farmani\yii\email;
class Obfuscator extends CWidget {

    public $email;

    public function init() {
        parent::init();

        if (!$this->email || !(new CEmailValidator())->validateValue($this->email)) {
            throw new HttpException(500, 'The email you specified is not valid.');
        }
    }

    public function run() {
        $email = CHtml::encode($this->email);
        $at_index = strpos($email, '@');
        $email = str_replace('@', '', $email);
        $rot_mail = str_rot13($email);

        echo '<script type="text/javascript">
var action=":otliam".split("").reverse().join("");
var href="'.$rot_mail.'".replace(/[a-zA-Z]/g, function(c){return String.fromCharCode((c<="Z"?90:122)>=(c=c.charCodeAt(0)+13)?c:c-26);});
href=href.substr(0, '.$at_index.') + String.fromCharCode(4*2*2*4) + href.substr('.$at_index.');
var a = "<a href=\""+action+href+"\">"+href+"</a>";
document.write(a);
</script>';
    }

}