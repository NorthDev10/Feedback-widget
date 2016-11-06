var FlatHandset = (function() {
  var css = '#flatHandset {position:absolute;}\
  #flatHandset:hover {\
  margin-top: -5px;\
  margin-bottom: 5px;\
  }\
  #flatHandset{\
  -webkit-transition: all 0.15s ease-in-out;\
  -moz-transition: all 0.15s ease-in-out;\
  -o-transition: all 0.15s ease-in-out;\
  transition: all 0.15s ease-in-out;\
  }';
  
  return {
  FlatHandset: function(config) {
    if(document.getElementById('flatHandset')==null) {
    var svgBtn = '<svg enable-background="new 0 0 40 40" height="50px" id="flatHandset" version="1.1" viewBox="0 0 40 40" width="50px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><g><g><g><path d="M20,2c9.925,0,18,8.075,18,18s-8.075,18-18,18c-9.925,0-18-8.075-18-18S10.075,2,20,2 M20,0C8.955,0,0,8.954,0,20c0,11.047,8.955,20,20,20c11.047,0,20-8.953,20-20C40,8.954,31.047,0,20,0L20,0z" fill="'+config['colorRing']+'" /></g></g></g><path clip-rule="evenodd" d="M14.371,9.793c1.207-0.228,1.998,1.133,2.6,2.072c0.586,0.912,1.307,1.982,1.016,3.169c-0.162,0.666-0.764,1.029-1.219,1.422c-0.449,0.388-1.133,0.744-1.299,1.34c-0.271,0.967,0.322,1.982,0.689,2.56c0.834,1.306,1.842,2.483,3.129,3.534c0.623,0.51,1.488,1.191,2.355,1.016   c1.295-0.262,1.637-1.859,3.047-2.072c1.342-0.203,2.25,0.77,3.008,1.422c0.73,0.631,1.908,1.439,1.828,2.52   c-0.047,0.621-0.545,1.006-0.977,1.381c-0.439,0.383-0.824,0.813-1.258,1.096c-1.051,0.686-2.34,1.022-3.82,0.976   c-1.451-0.045-2.607-0.538-3.656-1.097c-2.051-1.094-3.672-2.633-5.199-4.348c-1.502-1.686-2.889-3.682-3.656-5.889   c-0.957-2.756-0.451-5.587,1.098-7.353c0.262-0.3,0.676-0.613,1.055-0.935C13.49,10.284,13.84,9.893,14.371,9.793z" fill="'+config['colorTube']+'" fill-rule="evenodd" /></g></svg>';
    $("#btnHandset").html(svgBtn);
    }
    if(config['position'][0] != '') {
    $("#flatHandset").css('top', config['position'][0]);
    }
    if(config['position'][1] != '') {
    $("#flatHandset").css('right', config['position'][1]);
    }
    if(config['position'][2] != '') {
    $("#flatHandset").css('bottom', config['position'][2]);
    }
    if(config['position'][3] != '') {
    $("#flatHandset").css('left', config['position'][3]);
    }
    $("#btnHandset").css('display','block');
  },
  getCSS: function() {
    return css;
  },
  getData: function() {
    var obj = {};
    obj['btnType'] = $("#btnType").val();
    obj['delayedBtn'] = $("#delayDisplayBtn").val();
    obj['positionID'] = $('#FHbtnPos').val();
    obj['position'] = [
    $("#FHtopInset").val(), $("#FHrightInset").val(),
    $("#FHbottomInset").val(), $("#FHleftInset").val()
    ];
    obj['colorRing'] = $("#FHColorRing input").val();
    obj['colorTube'] = $("#colorHandset input").val();
    obj['soundBtn'] = $("#soundShowBtn").prop("checked");
    return obj;
  }
  }  
}());

var OnlyPhoneNumber = (function() {
  var styleForBtn = '';
  var styleForCross = '';
  var styleForBG = '';
  var styleForFontColor = '';
  var styleForPlaceholder = '';
  var baseStyle = '#formFillCD,\
#formFillCD p a,\
#formFillCD input,\
#formFillCD p a:hover,\
#formFillCD p a:active,\
#formFillCD h3,\
#formFillCD h4 {\
color: white;\
}\
#formFillCD h3, #formFillCD h4, #formFillCD p a, #formFillCD strong {\
border: 1px dotted white!important;\
outline: none;\
display: inline-block;\
}\
#formFillCD {\
position: absolute;\
top: 0px;\
left: 0px;\
right: 0px;\
bottom: 0px;\
z-index: 1;\
text-align: center;\
padding-top: 10%;\
height: 100%;\
}\
#formFillCD,\
#formFillCD > a {\
-webkit-transition: all 0.15s ease-in-out;\
-moz-transition: all 0.15s ease-in-out;\
-o-transition: all 0.15s ease-in-out;\
transition: all 0.15s ease-in-out;\
}\
#formFillCD,\
#formFillCD p a {\
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
#formFillCD input::-ms-clear {\
display: none;\
}\
#formFillCD > a {\
width: 45px;\
display: block;\
height: 45px;\
cursor: pointer;\
position: absolute;\
top: 48px;\
right: 48px;\
opacity: 0.3;\
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
  return {
  OnlyPhoneNumber: function(config) {
    if(document.getElementById('formFillCD')==null) {
      var mW = '<div id="formFillCD"><a></a><h3 contenteditable>'+config["title"]+'</h3><h4 contenteditable>'+config["subtitle"]+'</h4><input placeholder="'+config["textPrompts"]+'"><p><a contenteditable>'+config["btnText"]+'</a></p><strong contenteditable>'+config["inputError"]+'</strong></div>';
      $("#feedbackForm").html(mW);
      this.updateBG(config['bgColor']);
      this.updateCssCross(config['colorCross']);
      this.updateCssBtn(config['colorBtn'][0], config['colorBtn'][1], config['colorBtn'][2], config['colorBtn'][3]);
      this.updateCssPlaceholder(config['fontColor']);
      this.updateCssFontColor(config['fontColor']);
    }
    $("#feedbackForm").css('display','block');
  },
  getCSS: function() {
    return baseStyle+styleForBtn+styleForCross+styleForPlaceholder+styleForBG+styleForFontColor;
  },
  updateBG: function(bgColor) {
    styleForBG = '#formFillCD {background-color: '+bgColor+';}';
  },
  updateCssFontColor: function(color) {
    styleForFontColor = '#formFillCD h3, #formFillCD h4, #formFillCD p a, #formFillCD strong {color: '+color+'}';
  },
  updateCssCross: function(crossColor) {
    styleForCross = '#formFillCD > a {background-image: url(\'data:image/svg+xml;utf8,<svg height="45px" fill="'+crossColor+'" version="1.1" viewBox="0 0 512 512" width="45px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M437.5,386.6L306.9,256l130.6-130.6c14.1-14.1,14.1-36.8,0-50.9c-14.1-14.1-36.8-14.1-50.9,0L256,205.1L125.4,74.5 c-14.1-14.1-36.8-14.1-50.9,0c-14.1,14.1-14.1,36.8,0,50.9L205.1,256L74.5,386.6c-14.1,14.1-14.1,36.8,0,50.9 c14.1,14.1,36.8,14.1,50.9,0L256,306.9l130.6,130.6c14.1,14.1,36.8,14.1,50.9,0C451.5,423.4,451.5,400.6,437.5,386.6z"/></svg>\');}';
  },// bg, bgh, bord, bordh
  updateCssBtn: function(btnBgColor, btnBgColorH, btnBordColor, btnBordColorH) {
    if(btnBgColorH == undefined) {
    var btnBgColorH = tinycolor(btnBgColor).toHsv();
    btnBgColorH.s += 0.07;
    btnBgColorH.v -= 0.08;
    btnBgColorH = '#'+tinycolor(btnBgColorH).toHex();
    }
    $('#OPNbtnSendColorOther input:first-child').val(btnBgColorH);
    if(btnBordColor == undefined) {
    var btnBordColor = tinycolor(btnBgColor).toHsv();
    btnBordColor.s += 0.06;
    btnBordColor.v -= 0.04;
    btnBordColor = '#'+tinycolor(btnBordColor).toHex();
    }
    $('#OPNbtnSendColorOther input:nth-child(2)').val(btnBordColor);
    if(btnBordColorH == undefined) {
    var btnBordColorH = tinycolor(btnBgColor).toHsv();
    btnBordColorH.s += 0.07;
    btnBordColorH.v -= 0.20;
    btnBordColorH = '#'+tinycolor(btnBordColorH).toHex();
    }
    $('#OPNbtnSendColorOther input:last-child').val(btnBordColorH);
    styleForBtn = '#formFillCD p a {\
    background-color: '+btnBgColor+';\
    border-color: '+btnBordColor+';\
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
    background-color: '+btnBgColorH+';\
    border-color: '+btnBordColorH+';\
    }';
  },
  updateCssPlaceholder: function(pColor) {
    var pColor = tinycolor(pColor).toRgb();
    styleForPlaceholder = '#formFillCD input:-moz-placeholder {\
    color: rgba('+pColor.r+', '+pColor.g+', '+pColor.b+', 0.3);\
    }\
    #formFillCD input::-moz-placeholder {\
    color: rgba('+pColor.r+', '+pColor.g+', '+pColor.b+', 0.3);\
    }\
    #formFillCD input::-webkit-input-placeholder {\
    color: rgba('+pColor.r+', '+pColor.g+', '+pColor.b+', 0.3);\
    }\
    #formFillCD input:-ms-input-placeholder {\
    color: rgba('+pColor.r+', '+pColor.g+', '+pColor.b+', 0.3);\
    }';
  },
  getData: function() {
    var obj = {};
    obj['winType'] = $("#modalWinType").val();
    obj['bgColor'] = $("#OPNBgColor input").val();
    obj['fontColor'] = $("#OPNfontColor input").val();
    obj['colorCross'] = $("#OPNcolorCross input").val();
    var color = $("#OPNbtnSendColorOther input[type=hidden]");
    obj['colorBtn'] = [
    $("#OPNbtnSendColor input").val(),
    color[0].value,
    color[1].value,
    color[2].value
    ];
    obj['textPrompts'] = $("#OPNPlaceholder input").val();
    obj['title'] = $("#formFillCD h3").text();
    obj['subtitle'] = $("#formFillCD h4").text();
    obj['btnText'] = $("#formFillCD p a").text();
    obj['inputError'] = $("#formFillCD strong").text();
    return obj;
  }
  }
}());

var WidgetSettings = (function() {
  
  var wSObj = '';
  var css = '';
  
  function getWSObj() {
  try {
    var obj = {'ajax':''};
    if(window.location.pathname == "/new-project") {
    obj['newProject'] = '';
    } else {
    obj['projectID'] = $("#projectID").val();
    obj['userID'] = $("#userID").val();
    }
    $.ajax({
    url: "/json-widget-settings/",
    method: "POST",
    data: obj,
    success: function(data, status, request) {
      if(request.getResponseHeader('location') != null) {
      window.location.href = request.getResponseHeader('location');
      }
      try {
      if(data['error'] != undefined) {
        throw data['error'];
      } else {
        wSObj = JSON.parse(data);
        WidgetSettings.showModalWindow();
        WidgetSettings.showDecorBtn();
      }
      } catch (e) {
      $("#infoPanel").html('<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+e+'</div>');
      }
    }
    });
  } catch (e) {
    $("#infoPanel").html('<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+e+'</div>');
  }
  }
  
  return {
  WidgetSettings: function() {
    if(document.getElementById('btnHandset')==null) {
    $("#boardExample").append('<div id="btnHandset"></div>');
    }
    if(document.getElementById('feedbackForm')==null) {
    $("#boardExample").append('<div id="feedbackForm"></div>');
    }
    getWSObj();
  },
  generateWidgetJSFileMIN: function() {
    try {
    $("#codeGenerationText").button('loading');
    $.ajax({
      url: "/gen-code-widget/",
      method: "POST",
      data: {
      'ajax':'',
      'projectID':$("#projectID").val(),
      'userID':$("#userID").val()
      },
      success: function(data, status, request) {
      if(request.getResponseHeader('location') != null) {
        window.location.href = request.getResponseHeader('location');
      }
      try {
        var result = JSON.parse(data);
        if(result['error'] != undefined) {
        throw result['error'];
        } else {
        $("#widgetCode").text(result);
        }
      } catch (e) {
        $("#infoPanel").html('<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+e+'</div>');
      }
      },
      complete: function() {
      $("#codeGenerationText").button('reset');
      }
    });
    } catch (e) {
    $("#infoPanel").html('<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+e+'</div>');
    }
  },
  hideAll: function() {
    $("#btnHandset").css('display','none');
    $("#feedbackForm").css('display','none');
  },
  showDecorBtn: function() {
    console.log(wSObj);
    this.hideAll();
    switch(wSObj[0]['btnType']) {
    case 0:
      FlatHandset.FlatHandset(wSObj[0]);
    break;
    }
    this.applyStyles();
  },
  showModalWindow: function() {
    this.hideAll();
    switch(wSObj[1]['winType']) {
    case 0:
      OnlyPhoneNumber.OnlyPhoneNumber(wSObj[1]);
    break;
    }
    this.applyStyles();
  },
  applyStyles: function() {
    if(document.getElementById('formFillCDStyle') == null) {
    $('head').append('<style id="formFillCDStyle"></style>');
    }
    var formFillCDStyle = document.getElementById('formFillCDStyle');
    switch(wSObj[0]['btnType']) {
    case 0:
      css += FlatHandset.getCSS();
    break;
    }
    switch(wSObj[1]['winType']) {
    case 0:
      css += OnlyPhoneNumber.getCSS();
    break;
    }
    formFillCDStyle.innerText = css;
    formFillCDStyle.textContent = formFillCDStyle.innerText;
    css = '';
  },
  saveData: function() {
    var obj = {};
    obj['ajax'] = '';
    obj['userID'] = $("#userID").val();
    obj['projectID'] = $("#projectID").val();
    obj['url'] = $("#websiteAddress").val();
    obj['managerPhone'] = $("#managerPhone").val();
    obj['timeZone'] = $("#timeZone").val();
    obj['daylightSavingTime'] = $("#daylightSavingTime").prop("checked");
    obj['timeZoneId'] = $("#timeZone option:selected").attr('id');
    obj['workingDays'] = [
    [
      $("#cMonday").prop("checked"),
      $("#cMondayHour input:first-of-type").val(),
      $("#cMondayHour input:last-of-type").val()
    ],
    [
      $("#cTuesday").prop("checked"),
      $("#cTuesdayHour input:first-of-type").val(),
      $("#cTuesdayHour input:last-of-type").val()  
    ],
    [
      $("#cWednesday").prop("checked"),
      $("#cWednesdayHour input:first-of-type").val(),
      $("#cWednesdayHour input:last-of-type").val()
    ],
    [
      $("#cThursday").prop("checked"),
      $("#cThursdayHour input:first-of-type").val(),
      $("#cThursdayHour input:last-of-type").val()
    ],
    [
      $("#cFriday").prop("checked"),
      $("#cFridayHour input:first-of-type").val(),
      $("#cFridayHour input:last-of-type").val()
    ],
    [
      $("#cSaturday").prop("checked"),
      $("#cSaturdayHour input:first-of-type").val(),
      $("#cSaturdayHour input:last-of-type").val()
    ],
    [
      $("#cSunday").prop("checked"),
      $("#cSundayHour input:first-of-type").val(),
      $("#cSundayHour input:last-of-type").val()
    ]
    ];
    obj['widgetSettings'] = {};
    if(window.location.pathname == "/new-project") {
    obj['newProject'] = '';
    }
    switch($("#btnType").val()) {
    case '0':
      obj['widgetSettings'][0] = FlatHandset.getData();
    break;
    }
    switch($("#modalWinType").val()) {
    case '0':
      obj['widgetSettings'][1] = OnlyPhoneNumber.getData();
    break;
    }
    console.log(obj);
    try {
    $("#saveProjectSettings").button('loading');
    $.ajax({
      url: "/save-project/",
      method: "POST",
      data: obj,
      success: function(data, status, request) {
      if(request.getResponseHeader('location') != null) {
        window.location.href = request.getResponseHeader('location');
      }
      try {
        var result = JSON.parse(data);
        if(result[0] == 'true') {
        $("#saveProjectSettings").removeClass("btn-info");
        $("#saveProjectSettings").removeClass("btn-warning");
        $("#saveProjectSettings").addClass("btn-success");
        if(result['projectID'] != undefined) {
          $("#projectID").val(result['projectID']);
        }
        throw 'Данные успешно сохранены';
        } else if(result['error'] != undefined) {
        $("#saveProjectSettings").removeClass("btn-info");
        $("#saveProjectSettings").removeClass("btn-success");
        $("#saveProjectSettings").addClass("btn-warning");
        throw result['error'];
        }
      } catch (e) {
        $("#infoPanel").html('<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+e+'</div>');
      }
      },
      complete: function() {
      $("#saveProjectSettings").button('reset');
      }
    });
    } catch (e) {
    $("#infoPanel").html('<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+e+'</div>');
    }
  }
  }
}());
$(document).ready(function() {
  WidgetSettings.WidgetSettings();
  $("#saveProjectSettings").click(function(){
  WidgetSettings.saveData();
  });
  $("#codeGenerationText").click(function(){
  WidgetSettings.generateWidgetJSFileMIN();
  });
  $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
  if(e.target.hash == '#getCode') {
    $('#saveProjectSettings').css('display', 'none');
  } else {
    $('#saveProjectSettings').css('display', 'inline-block');
  }
  })
});