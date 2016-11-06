var CbkRightWin = (function() {
  var cbkWinR;
  var hideHappened;
  var heightForGlideBlock;
  var cbkNumber;
  var cbkPerson;
  var cbkH2;
  var cbkH3;
  var glideBlock;
  
  
  /*
  <div id="cbkWinR">
	    <div id="reservHeight">
	        <a id="cbkFormClose"></a>
	    </div>
	    <div id="glideBlock"></div>
		<div class="cbkPerson"></div>
		<div class="cbkContent">
			<h2 id="cbkH2">Закажите обратный звонок</h2>
			<h3 id="cbkH3">Наш лучший специалист свяжется с вами в течении 30 секунд.</h3>
			<p><input id="cbkNumber" placeholder="+79261234567"></p>
			<p><a id="cbkSend">ЖДУ ЗВОНКА</a></p>
			<p><span id="cbkInfo">Некорректно введен номер телефона</span></p>
		</div>
	</div>
	В офисе ни души, уточните удобное время для звонка

Вам подарок! Закажите звонок, чтобы узнать больше


ОК
  */
  
  function buildHtml() {
    var cbkWinR = document.createElement("div");
    cbkWinR.id = "cbkWinR";
    //cbkWinR.style.display = "none";
    var reservHeight = document.createElement("div");
    reservHeight.id = "reservHeight";
    var cbkFormClose = document.createElement("a");
    cbkFormClose.id = "cbkFormClose";
    cbkFormClose.onclick = function() {
      CbkRightWin.hide();
    };
    reservHeight.appendChild(cbkFormClose);
    cbkWinR.appendChild(reservHeight);
    var glideBlock = document.createElement("div");
    glideBlock.id = "glideBlock";
    cbkWinR.appendChild(glideBlock);
    var cbkPerson = document.createElement("div");
    cbkPerson.setAttribute("class", "cbkPerson");
    cbkWinR.appendChild(cbkPerson);
    var cbkContent = document.createElement("div");
    cbkContent.setAttribute('class', "cbkContent");
    cbkWinR.appendChild(cbkContent);
    var cbkH2 = document.createElement("h2");
    cbkH2.id = "cbkH2";
    cbkH2.innerText = "Закажите обратный звонок";
    cbkH2.textContent = cbkH2.innerText;
    cbkContent.appendChild(cbkH2);
    var cbkH3 = document.createElement("h3");
    cbkH3.id = "cbkH3";
    cbkH3.innerText = "Наш лучший специалист свяжется с вами в течении 30 секунд.";
    cbkH3.textContent = cbkH3.innerText;
    cbkContent.appendChild(cbkH3);
    var pForInput = document.createElement("p");
    var input = document.createElement("input");
    input.id = "cbkNumber";
    input.setAttribute("placeholder","+79261234567");
    pForInput.appendChild(input);
    cbkContent.appendChild(pForInput);
    var pForA = document.createElement("p");
    var cbkSend = document.createElement("a");
    cbkSend.id = "cbkSend";
    cbkSend.innerText = "ЖДУ ЗВОНКА";
    cbkSend.textContent = cbkSend.innerText;
    pForA.appendChild(cbkSend);
    cbkContent.appendChild(pForA);
    var pForSpan = document.createElement("p");
    var cbkInfo = document.createElement("span");
    cbkInfo.id = "cbkInfo";
    //cbkInfo.innerText = "Некорректно введен номер телефона";
    //cbkInfo.textContent = cbkInfo.innerText;
    pForSpan.appendChild(cbkInfo);
    cbkContent.appendChild(pForSpan);
    document.body.appendChild(cbkWinR);
    cbkSend.onclick = function() {
      var _onclick = cbkSend.onclick;
      cbkSend.onclick = null;
      cbkInfo.innerText = "";
      cbkInfo.textContent = cbkInfo.innerText;
      cbkInfo.classList.add('preload');
      cbkSend.classList.add('btnLoading');
      setTimeout(function() {
        cbkSend.onclick = _onclick;
        cbkInfo.classList.add('success');
        cbkInfo.classList.remove('preload');
        cbkSend.classList.remove('btnLoading');
        cbkInfo.innerText = "Ожидайте звонка!";
        cbkInfo.textContent = cbkInfo.innerText;
      }, 3000);
    };
  }
  
  return {
    CbkRightWin: function() {
      buildHtml();
      cbkWinR = document.getElementById("cbkWinR");
      cbkNumber = document.querySelector("#cbkWinR #cbkNumber");
      cbkPerson = document.querySelector("#cbkWinR .cbkPerson");
      cbkH2 = document.querySelector("#cbkWinR #cbkH2");
      cbkH3 = document.querySelector("#cbkWinR #cbkH3");
      glideBlock = document.querySelector("#cbkWinR #glideBlock");
      var cbkPersonH = cbkPerson.offsetHeight;
      heightForGlideBlock = (cbkPersonH==0?0:(cbkPersonH+20)) + cbkH2.offsetHeight + cbkH3.offsetHeight;
      glideBlock.classList.add('transitionALL3s');
      glideBlock.setAttribute("style", "height: "+heightForGlideBlock+"px;");
      
      cbkNumber.onfocus = function() {
        setTimeout(function() {
          if(window.innerHeight <= 455) {
            var cbkPersonH = cbkPerson.offsetHeight;
            heightForGlideBlock = (cbkPersonH==0?0:(cbkPersonH+20)) + cbkH2.offsetHeight + cbkH3.offsetHeight;
            glideBlock.classList.add('transitionALL3s');
            glideBlock.setAttribute("style", "height: "+heightForGlideBlock+"px;");
            cbkPerson.classList.add('hideElement');
            cbkH2.classList.add('hideElement');
            cbkH3.classList.add('hideElement');
            glideBlock.classList.add('glideBlockHide');
            glideBlock.classList.add('posStatic');
            hideHappened = true;
          }
        }, 500);
      };
      
      cbkNumber.onblur = function() {
        if(hideHappened) {
          glideBlock.setAttribute("style", "height: "+heightForGlideBlock+"px;");
          glideBlock.classList.remove('glideBlockHide');
          setTimeout(function() {
            glideBlock.classList.remove('transitionALL3s');
            glideBlock.classList.remove('posStatic');
            cbkPerson.classList.remove('hideElement');
            cbkH2.classList.remove('hideElement');
            cbkH3.classList.remove('hideElement');
            hideHappened = false;
          }, 300);
        }
      };
    },
    show: function() {
      cbkWinR.style.right = "0";
    //  cbkWinR.style.display = "block";
    },
    hide: function() {
     // cbkWinR.style.display = "none";
      cbkWinR.style.right = "-300px";
    }
  }
}());


document.addEventListener("DOMContentLoaded", function(e) {
 // CbkRightWin.CbkRightWin();
});