<?php
defined('CONTACT_DETAILS') or die('Access denied');
?>
var CallBtn = (function() {
var css = '#btnCallback {\
width: 50px;\
display: none;\
height: 50px;\
position: fixed;\
top: <?php
    $pos = $this->getPosition();
    if(empty($pos[0])) {
        echo 'auto';
    } else {
        echo $pos[0];
    }
?>;\
right: <?php
    if(empty($pos[1])) {
        echo 'auto';
    } else {
        echo $pos[1];
    }
?>;\
bottom: <?php
    if(empty($pos[2])) {
        echo 'auto';
    } else {
        echo $pos[2];
    }
?>;\
cursor: pointer;\
left: <?php
    if(empty($pos[3])) {
        echo 'auto';
    } else {
        echo $pos[3];
    }
?>;\
background-image: url("data:image/svg+xml;utf8,<svg enable-background=\'new 0 0 40 40\' height=\'50px\' id=\'flatHandset\' version=\'1.1\' viewBox=\'0 0 40 40\' width=\'50px\' xml:space=\'preserve\' xmlns=\'http://www.w3.org/2000/svg\' xmlns:xlink=\'http://www.w3.org/1999/xlink\'><g><g><g><g><path d=\'M20,2c9.925,0,18,8.075,18,18s-8.075,18-18,18c-9.925,0-18-8.075-18-18S10.075,2,20,2 M20,0C8.955,0,0,8.954,0,20c0,11.047,8.955,20,20,20c11.047,0,20-8.953,20-20C40,8.954,31.047,0,20,0L20,0z\' fill=\'<?php echo $this->getColorRing();?>\' /></g></g></g><path clip-rule=\'evenodd\' d=\'M14.371,9.793c1.207-0.228,1.998,1.133,2.6,2.072c0.586,0.912,1.307,1.982,1.016,3.169c-0.162,0.666-0.764,1.029-1.219,1.422c-0.449,0.388-1.133,0.744-1.299,1.34c-0.271,0.967,0.322,1.982,0.689,2.56c0.834,1.306,1.842,2.483,3.129,3.534c0.623,0.51,1.488,1.191,2.355,1.016 c1.295-0.262,1.637-1.859,3.047-2.072c1.342-0.203,2.25,0.77,3.008,1.422c0.73,0.631,1.908,1.439,1.828,2.52 c-0.047,0.621-0.545,1.006-0.977,1.381c-0.439,0.383-0.824,0.813-1.258,1.096c-1.051,0.686-2.34,1.022-3.82,0.976 c-1.451-0.045-2.607-0.538-3.656-1.097c-2.051-1.094-3.672-2.633-5.199-4.348c-1.502-1.686-2.889-3.682-3.656-5.889 c-0.957-2.756-0.451-5.587,1.098-7.353c0.262-0.3,0.676-0.613,1.055-0.935C13.49,10.284,13.84,9.893,14.371,9.793z\' fill=\'<?php echo $this->getColorTube();?>\' fill-rule=\'evenodd\' /></g></svg>");\
}\
#btnCallback:hover {\
margin-top:-5px;\
margin-bottom:5px;\
}\
#btnCallback {\
-webkit-transition: all 0.15s ease-in-out;\
-moz-transition: all 0.15s ease-in-out;\
-o-transition: all 0.15s ease-in-out;\
transition: all 0.15s ease-in-out;\
}';
<?php 
    if($this->getSoundBtn()) {
?>
    function getCookie(cookie_name) {
        var results = document.cookie.match ('(^|;) ?' + cookie_name + '=([^;]*)(;|$)');
        if(results) {
            return (unescape(results[2]));
        } else {
            return null;
        }
    }
<?php
    }
?>
    function createCallBtn() {
        <?php 
            if($this->getSoundBtn()) {
        ?>
        var signal = document.getElementById('callBtnSignal');
        if(signal != null) {
            signal.play();
            document.cookie = "callBtnSignal=true";
        }
        <?php
            }
        ?>
        var btnSimpleForm = document.createElement('a');
        btnSimpleForm.id = "btnCallback";
        document.body.appendChild(btnSimpleForm);
        btnSimpleForm.onclick = function() {
            if(!document.getElementById('formFillCD')) {
                WinContacts.show();
            }
            return false;
        }
        WidgetsInit.fadeIn(btnSimpleForm);
    }
    
    return {
        getCSS: function() {
            return css;
        },
        init: function() {
            <?php 
                if($this->getSoundBtn()) {
            ?>
            if(getCookie('callBtnSignal') === null) {
                var audio = document.createElement('audio');
                audio.id = "callBtnSignal";
                var source = document.createElement('source');
                source.src = "<?php echo SITE_PROTOCOL.'://'.DOMAIN_SITE.'/sounds/callSignal.mp3';?>";
                source.type = "audio/mp3";
                document.body.appendChild(audio);
                audio.appendChild(source);
            }
            <?php
                }
            ?>
            setTimeout(createCallBtn, <?php echo $this->getDelayedBtn()*1000;?>);
        }
    }
}());