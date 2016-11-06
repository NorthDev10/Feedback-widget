<?php
defined('CONTACT_DETAILS') or die('Access denied');
?>
var WinContacts = (function() {
var css = '#formFillCD, #formFillCD p a, #formFillCD input, #formFillCD p a:hover, #formFillCD p a:active, #formFillCD h3, #formFillCD h4 {\
color: <?php echo $this->getFontColor();?>;\
}\
#formFillCD {\
position: fixed;\
top: 0px;\
left: 0px;\
right: 0px;\
bottom: 0px;\
z-index: 10000;\
display:none;\
background-color: <?php echo $this->getBgColor();?>;\
text-align: center;\
padding-top: 10%;\
height: 100%;\
}\
#formFillCD, #formFillCD > a {\
-webkit-transition: all 0.15s ease-in-out;\
-moz-transition: all 0.15s ease-in-out;\
-o-transition: all 0.15s ease-in-out;\
transition: all 0.15s ease-in-out;\
}\
#formFillCD, #formFillCD p a {\
-webkit-user-select: none;\
-moz-user-select: none;\
-ms-user-select: none;\
user-select: none;\
}\
#formFillCD input {\
text-align: center;\
outline: none;\
width: 100%;\
border: none;\
font-family: inherit;\
font-size: 36px;\
line-height: 48px;\
padding: 0px;\
border-radius: 0px;\
background-color: transparent;\
}\
#formFillCD p a {\
background-color: <?php echo $this->getColorBtn()[0];?>;\
border-color: <?php echo $this->getColorBtn()[2];?>;\
text-decoration: none;\
display: inline-block;\
margin-top: 8px;\
padding: 10px 16px;\
font-size: 18px;\
line-height: 1.33;\
border-radius: 6px;\
font-weight: normal;\
text-align: center;\
vertical-align: middle;\
cursor: pointer;\
background-image: none;\
border: 1px solid transparent;\
white-space: nowrap;\
padding: 6px 12px;\
font-size: 14px;\
line-height: 1.42857143;\
border-radius: 4px;\
}\
#formFillCD p a:hover {\
background-color: <?php echo $this->getColorBtn()[1];?>;\
border-color: <?php echo $this->getColorBtn()[3];?>;\
}\
#formFillCD input::-ms-clear {\
display: none;\
}\
#formFillCD input:-moz-placeholder { color: rgba(<?php echo $this->getHexToRgb($this->getFontColor());?>, 0.3); }\
#formFillCD input::-moz-placeholder { color: rgba(<?php echo $this->getHexToRgb($this->getFontColor());?>, 0.3); }\
#formFillCD input::-webkit-input-placeholder { color: rgba(<?php echo $this->getHexToRgb($this->getFontColor());?>, 0.3); }\
#formFillCD input:-ms-input-placeholder { color: rgba(<?php echo $this->getHexToRgb($this->getFontColor());?>, 0.3); }\
#formFillCD > a {\
width: 45px;\
display: block;\
height: 45px;\
cursor: pointer;\
position: absolute;\
top: 48px;\
right: 48px;\
opacity: 0.3;\
background-image: url("data:image/svg+xml;utf8,<svg height=\'45px\' fill=\'<?php echo $this->getColorCross();?>\' version=\'1.1\' viewBox=\'0 0 512 512\' width=\'45px\' xml:space=\'preserve\' xmlns=\'http://www.w3.org/2000/svg\' xmlns:xlink=\'http://www.w3.org/1999/xlink\'><path d=\'M437.5,386.6L306.9,256l130.6-130.6c14.1-14.1,14.1-36.8,0-50.9c-14.1-14.1-36.8-14.1-50.9,0L256,205.1L125.4,74.5 c-14.1-14.1-36.8-14.1-50.9,0c-14.1,14.1-14.1,36.8,0,50.9L205.1,256L74.5,386.6c-14.1,14.1-14.1,36.8,0,50.9 c14.1,14.1,36.8,14.1,50.9,0L256,306.9l130.6,130.6c14.1,14.1,36.8,14.1,50.9,0C451.5,423.4,451.5,400.6,437.5,386.6z\'/></svg>");\
}\
#formFillCD h3 {\
font-size: 24px;\
}\
#formFillCD h4 {\
font-size: 18px;\
}\
#formFillCD #infoCallBtn {\
font-size: 14px;\
}\
@media screen and (max-width: 500px) {\
#formFillCD > a {\
top: 10px;\
right: 20px;\
}\
#formFillCD h3 {\
font-size: 12px;\
}\
#formFillCD h4 {\
font-size: 8px;\
}\
#formFillCD input {\
font-size: 25px;\
}\
}\
#formFillCD > a:hover {\
-webkit-transform: rotate(90deg);\
-ms-transform: rotate(90deg);\
transform: rotate(90deg);\
opacity: 1;\
}\
#formFillCD p a:active, #formFillCD p a:focus {\
outline: 0;\
background-image: none;\
-webkit-box-shadow: inset 0 3px 5px rgba(0,0,0,.125);\
box-shadow: inset 0 3px 5px rgba(0,0,0,.125);\
}';
    
    function sendNumberPhone(data) {
        if(document.all && !window.atob) { // IE9
            var request = new XDomainRequest();
        } else {
            var request = new XMLHttpRequest();
        }
        request.open("GET", window.location.protocol+"//<?php echo DOMAIN_SITE;?>/?q=add-contacts&"+data, true);
        var formFillCD = document.getElementById('formFillCD');
        request.onload = function() {
            if(formFillCD) {
                formFillCD.parentNode.removeChild(formFillCD);
            }
        }
        
        request.onerror = function() {
            if(formFillCD) {
                var infoCallBtn = document.getElementById('infoCallBtn');
                if(!infoCallBtn) {
                    infoCallBtn = document.createElement('strong');
                    infoCallBtn.id = "infoCallBtn";
                    infoCallBtn.style.display = "none";
                    infoCallBtn.innerText = "Не удалось отправить";
                    infoCallBtn.textContent = infoCallBtn.innerText;
                    formFillCD.appendChild(infoCallBtn);
                    WidgetsInit.fadeIn(infoCallBtn);
                } else {
                    infoCallBtn.innerText = "Не удалось отправить";
                    infoCallBtn.textContent = infoCallBtn.innerText;
                }
            }
        }
        request.send();
    }
    
    return {
        getCSS: function() {
            return css;
        },
        show: function() {
            var formFillCD = document.createElement('div');
            formFillCD.id = "formFillCD";
            document.body.appendChild(formFillCD);
            var exit = document.createElement('a');
            exit.onclick = function() {
                formFillCD.parentNode.removeChild(formFillCD);
                return false;
            }
            formFillCD.appendChild(exit);
            var h3 = document.createElement('h3');
            h3.innerText = "<?php echo $this->getTitle();?>";
            h3.textContent = h3.innerText;
            formFillCD.appendChild(h3);
            var h4 = document.createElement('h4');
            h4.innerText = "<?php echo $this->getSubtitle();?>";
            h4.textContent = h4.innerText;
            formFillCD.appendChild(h4);
            var input = document.createElement('input');
            input.placeholder = "<?php echo $this->getTextPrompts();?>";
            formFillCD.appendChild(input);
            var p = document.createElement('p');
            formFillCD.appendChild(p);
            var send = document.createElement('a');
            send.innerText = "<?php echo $this->getBtnText();?>";
            send.textContent = send.innerText;
            send.onclick = function() {
                if(/^\+\d{3,24}$/.test(input.value)) {
                    if(document.getElementsByTagName('title')) {
                        var title = document.getElementsByTagName('title')[0].innerText || document.getElementsByTagName('title')[0].textContent;
                    }
                    var data = {
                        ApiKey:'<?php echo $this->ProjectInfo->getApiKey();?>',
                        title:encodeURIComponent(title),
                        url:encodeURIComponent(window.location.href),
                        PhoneNumber:encodeURIComponent(input.value)
                    };
                    sendNumberPhone('ApiKey='+data.ApiKey+'&title='+data.title+'&url='+data.url+'&PhoneNumber='+data.PhoneNumber);
                } else {
                    if(!document.getElementById('infoCallBtn')) {
                        var info = document.createElement('strong');
                        info.id = "infoCallBtn";
                        info.style.display = "none";
                        info.innerText = "<?php echo $this->getInputError();?>";
                        info.textContent = info.innerText;
                        formFillCD.appendChild(info);
                        WidgetsInit.fadeIn(info);
                    }
                }
                return false;
            }
            p.appendChild(send);
            WidgetsInit.fadeIn(formFillCD, 0);
        }
    }
}());