<?php
defined('CONTACT_DETAILS') or die('Access denied');
?>
var WidgetsInit = (function() {
    var workingDays = <?php echo $this->getWorkingDaysJSON();?>;
    function getEuropeDay(date) {
      var dayOfWeek = date.getDay();
      return (dayOfWeek == 0)?7:dayOfWeek;
    }
    function timeInTimeZone(hour) {
      var localTime = new Date();
      var timeDifference = ((hour<?php 
        if($this->getDaylightSavingTime()) {
          echo '+transferClockOneHour()';
        }
      ?>)*60+localTime.getTimezoneOffset())*60000;
      return new Date(localTime.getTime()+timeDifference);
    }
    function isWorkingDay(date) {
      var Day = getCurrentDay(date);
      if(Day[0] == 1) {
        var fromTime = Day[1].split(':');
        var toTime = Day[2].split(':');
    	if((date.getHours() >= fromTime[0]) && (date.getHours() <= toTime[0])) {
    		if((date.getHours() == fromTime[0]) && (date.getMinutes() < fromTime[1])) {
    		  return false;
    		}
    		if((date.getHours() == toTime[0]) && (date.getMinutes() > toTime[1])) {
    		  return false;
    		}
    		return true;
    	}
      }
    }
    function getCurrentDay(date) {
      return workingDays[getEuropeDay(date)-1];
    }
    <?php
        if($this->getDaylightSavingTime()) {
    ?>
    function getLastDayOfWeek(year, month, dayOfWeek) {
      var date, i = 0;
      do {
        date = new Date(year, month, i--);
      } while(date.getDay() != dayOfWeek);
      return date.getDate();
    }
    function transferClockOneHour() {
      var date = new Date();
      if ((date.getUTCMonth() > 2) && (date.getUTCMonth() < 9)) {
        return 1;
      } else if ((date.getUTCMonth() > 9) || (date.getUTCMonth() < 2)) {
        return -1;
      } else {
        if (date.getUTCMonth() == 2) {
          var lastSundayMar = getLastDayOfWeek(date.getUTCFullYear(), 3, 0);
          if (date.getUTCDate() < lastSundayMar) {
            return -1;
          } else {
            if (date.getUTCDate() == lastSundayMar) {
              if (date.getUTCHours() >= 1) {
                return 1;
              } else {
                return -1;
              }
            } else {
              return 1;
            }
          }
        } else {
          var lastSundayOct = getLastDayOfWeek(date.getUTCFullYear(), 10, 0);
          if (date.getUTCDate() < lastSundayOct) {
            return 1;
          } else {
            if (date.getUTCDate() == lastSundayOct) {
              if (date.getUTCHours() >= 2) {
                return -1;
              } else {
                return 1;
              }
            } else {
              return -1;
            }
          }
        }
      }
    }
    <?php
        }
    ?>
    function setCss() {
        var head = document.head || document.getElementsByTagName('head')[0],
        style = document.createElement('style');
        style.type = 'text/css';
        if (style.styleSheet){
            style.styleSheet.cssText = CallBtn.getCSS()+WinContacts.getCSS();
        } else {
            style.appendChild(document.createTextNode(CallBtn.getCSS()+WinContacts.getCSS()));
        }
        head.appendChild(style);
    }
    return {
        main: function() {
            document.addEventListener("DOMContentLoaded", function(event) {
                var time = timeInTimeZone(<?php echo $this->getTimeZone();?>);
                if(isWorkingDay(time)) {
                    setCss();
                    CallBtn.init();
                }
            });
        },
        fadeIn: function(el, speed) {
            if(speed == undefined) speed = 50;
            el.style.opacity = 0;
            el.style.display = "block";
            (function fade() {
                var val = parseFloat(el.style.opacity);
                if (!((val += .1) > 1)) {
                    el.style.MozOpacity = val;
                    el.style.opacity = val;
                    window.setTimeout(fade, speed);
                }
            })();
        }
    }
}());
WidgetsInit.main();