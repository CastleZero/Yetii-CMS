var OxO49cf=["=","; path=/;"," expires=",";","cookie","length","","#ffffff","CECC","onmouseover","event","srcElement","target","className","colordiv","style","onmouseout","onclick","CheckboxColorNames","checked","cname","backgroundColor","cvalue","colorpicker.php?UC=","Culture","\x26setting=","EditorSetting","dialogWidth:500px;dialogHeight:420px;help:0;status:0;resizable:1","dialogArguments","object","onchange","color","editor","divpreview","value","#","RecentColors","SPAN","ValidColor"];function SetCookie(name,Ox289,Ox28a){var Ox28b=name+OxO49cf[0]+escape(Ox289)+OxO49cf[1];if(Ox28a){var Ox272= new Date();Ox272.setSeconds(Ox272.getSeconds()+Ox28a);Ox28b+=OxO49cf[2]+Ox272.toUTCString()+OxO49cf[3];} ;document[OxO49cf[4]]=Ox28b;} ;function GetCookie(name){var Ox28d=document[OxO49cf[4]].split(OxO49cf[3]);for(var i=0;i<Ox28d[OxO49cf[5]];i++){var Ox28e=Ox28d[i].split(OxO49cf[0]);if(name==Ox28e[0].replace(/\s/g,OxO49cf[6])){return unescape(Ox28e[1]);} ;} ;} ;function GetCookieDictionary(){var Ox290={};var Ox28d=document[OxO49cf[4]].split(OxO49cf[3]);for(var i=0;i<Ox28d[OxO49cf[5]];i++){var Ox28e=Ox28d[i].split(OxO49cf[0]);Ox290[Ox28e[0].replace(/\s/g,OxO49cf[6])]=unescape(Ox28e[1]);} ;return Ox290;} ;function GetCookieArray(){var arr=[];var Ox28d=document[OxO49cf[4]].split(OxO49cf[3]);for(var i=0;i<Ox28d[OxO49cf[5]];i++){var Ox28e=Ox28d[i].split(OxO49cf[0]);var Ox28b={name:Ox28e[0].replace(/\s/g,OxO49cf[6]),value:unescape(Ox28e[1])};arr[arr[OxO49cf[5]]]=Ox28b;} ;return arr;} ;var __defaultcustomlist=[OxO49cf[7],OxO49cf[7],OxO49cf[7],OxO49cf[7],OxO49cf[7],OxO49cf[7],OxO49cf[7],OxO49cf[7]];function GetCustomColors(){var Ox295=__defaultcustomlist.concat();for(var i=0;i<18;i++){var Ox296=GetCustomColor(i);if(Ox296){Ox295[i]=Ox296;} ;} ;return Ox295;} ;function GetCustomColor(Ox298){return GetCookie(OxO49cf[8]+Ox298);} ;function SetCustomColor(Ox298,Ox296){SetCookie(OxO49cf[8]+Ox298,Ox296,60*60*24*365);} ;var _origincolor=OxO49cf[6];document[OxO49cf[9]]=function (Ox332){Ox332=window[OxO49cf[10]]||Ox332;var Ox2ba=Ox332[OxO49cf[11]]||Ox332[OxO49cf[12]];if(Ox2ba[OxO49cf[13]]==OxO49cf[14]){firecolorchange(Ox2ba[OxO49cf[15]].backgroundColor);} ;} ;document[OxO49cf[16]]=function (Ox332){Ox332=window[OxO49cf[10]]||Ox332;var Ox2ba=Ox332[OxO49cf[11]]||Ox332[OxO49cf[12]];if(Ox2ba[OxO49cf[13]]==OxO49cf[14]){firecolorchange(_origincolor);} ;} ;document[OxO49cf[17]]=function (Ox332){Ox332=window[OxO49cf[10]]||Ox332;var Ox2ba=Ox332[OxO49cf[11]]||Ox332[OxO49cf[12]];if(Ox2ba[OxO49cf[13]]==OxO49cf[14]){var Ox405=document.getElementById(OxO49cf[18])&&document.getElementById(OxO49cf[18])[OxO49cf[19]];if(Ox405){do_select(Ox2ba.getAttribute(OxO49cf[20])||Ox2ba[OxO49cf[15]][OxO49cf[21]]);} else {do_select(Ox2ba.getAttribute(OxO49cf[22])||Ox2ba[OxO49cf[15]][OxO49cf[21]]);} ;} ;} ;var _editor;function firecolorchange(Ox408){} ;function ShowColorDialog(Ox398){var Ox2a4=OxO49cf[23]+editor.GetScriptProperty(OxO49cf[24])+OxO49cf[25]+editor.GetScriptProperty(OxO49cf[26]);var Ox40a=OxO49cf[27];var Ox2a6=showModalDialog(Ox2a4,null,Ox40a);if(Ox2a6!=null&&Ox2a6!==false){Ox398(Ox2a6);} ;} ;if(top[OxO49cf[28]]){if( typeof (top[OxO49cf[28]])==OxO49cf[29]){if(top[OxO49cf[28]][OxO49cf[30]]){firecolorchange=top[OxO49cf[28]][OxO49cf[30]];_origincolor=top[OxO49cf[28]][OxO49cf[31]];_editor=top[OxO49cf[28]][OxO49cf[32]];} ;} ;} ;var _selectedcolor=null;function do_select(Ox296){_selectedcolor=Ox296;firecolorchange(Ox296);var Ox10=document.getElementById(OxO49cf[33]);if(Ox10){Ox10[OxO49cf[34]]=Ox296;} ;} ;function do_saverecent(Ox296){if(!Ox296){return ;} ;if(Ox296[OxO49cf[5]]!=7){return ;} ;if(Ox296.substring(0,1)!=OxO49cf[35]){return ;} ;var Ox29b=Ox296.substring(1,7);var Ox40e=GetCookie(OxO49cf[36]);if(!Ox40e){Ox40e=OxO49cf[6];} ;if((Ox40e[OxO49cf[5]]%6)!=0){Ox40e=OxO49cf[6];} ;for(var i=0;i<Ox40e[OxO49cf[5]];i+=6){if(Ox40e.substr(i,6)==Ox29b){Ox40e=Ox40e.substr(0,i)+Ox40e.substr(i+6);i-=6;} ;} ;if(Ox40e[OxO49cf[5]]>31*6){Ox40e=Ox40e.substr(0,31*6);} ;Ox40e=Ox29b+Ox40e;SetCookie(OxO49cf[36],Ox40e,60*60*24*365);} ;function do_insert(){var Ox296;var divpreview=document.getElementById(OxO49cf[33]);if(divpreview){Ox296=divpreview[OxO49cf[34]];} else {Ox296=_selectedcolor;} ;try{document.createElement(OxO49cf[37])[OxO49cf[15]][OxO49cf[31]]=Ox296;do_saverecent(Ox296);Window_SetDialogReturnValue(window,Ox296);Window_CloseDialog(window);} catch(x){alert(CE_GetStr(OxO49cf[38]));divpreview[OxO49cf[34]]=OxO49cf[6];return false;} ;} ;