var OxO97ae=["","sel_position","sel_display","sel_float","sel_clear","tb_top","sel_top_unit","tb_height","sel_height_unit","tb_left","sel_left_unit","tb_width","sel_width_unit","tb_cliptop","sel_cliptop_unit","tb_clipbottom","sel_clipbottom_unit","tb_clipleft","sel_clipleft_unit","tb_clipright","sel_clipright_unit","sel_overflow","tb_zindex","sel_pagebreakbefore","sel_pagebreakafter","outer","div_demo","cssText","style","value","position","display","styleFloat","cssFloat","clear","left","top","width","height","length","tb_","sel_","_unit","selectedIndex","options","right","bottom","clip","tb_clip","sel_clip","currentStyle","overflow","zIndex","pageBreakBefore","pageBreakAfter"];function ParseFloatToString(Oxb){var Ox2fe=parseFloat(Oxb);if(isNaN(Ox2fe)){return OxO97ae[0];} ;return Ox2fe+OxO97ae[0];} ;var sel_position=Window_GetElement(window,OxO97ae[1],true);var sel_display=Window_GetElement(window,OxO97ae[2],true);var sel_float=Window_GetElement(window,OxO97ae[3],true);var sel_clear=Window_GetElement(window,OxO97ae[4],true);var tb_top=Window_GetElement(window,OxO97ae[5],true);var sel_top_unit=Window_GetElement(window,OxO97ae[6],true);var tb_height=Window_GetElement(window,OxO97ae[7],true);var sel_height_unit=Window_GetElement(window,OxO97ae[8],true);var tb_left=Window_GetElement(window,OxO97ae[9],true);var sel_left_unit=Window_GetElement(window,OxO97ae[10],true);var tb_width=Window_GetElement(window,OxO97ae[11],true);var sel_width_unit=Window_GetElement(window,OxO97ae[12],true);var tb_cliptop=Window_GetElement(window,OxO97ae[13],true);var sel_cliptop_unit=Window_GetElement(window,OxO97ae[14],true);var tb_clipbottom=Window_GetElement(window,OxO97ae[15],true);var sel_clipbottom_unit=Window_GetElement(window,OxO97ae[16],true);var tb_clipleft=Window_GetElement(window,OxO97ae[17],true);var sel_clipleft_unit=Window_GetElement(window,OxO97ae[18],true);var tb_clipright=Window_GetElement(window,OxO97ae[19],true);var sel_clipright_unit=Window_GetElement(window,OxO97ae[20],true);var sel_overflow=Window_GetElement(window,OxO97ae[21],true);var tb_zindex=Window_GetElement(window,OxO97ae[22],true);var sel_pagebreakbefore=Window_GetElement(window,OxO97ae[23],true);var sel_pagebreakafter=Window_GetElement(window,OxO97ae[24],true);var outer=Window_GetElement(window,OxO97ae[25],true);var div_demo=Window_GetElement(window,OxO97ae[26],true);UpdateState=function UpdateState_Layout(){div_demo[OxO97ae[28]][OxO97ae[27]]=element[OxO97ae[28]][OxO97ae[27]];} ;SyncToView=function SyncToView_Layout(){sel_position[OxO97ae[29]]=element[OxO97ae[28]][OxO97ae[30]];sel_display[OxO97ae[29]]=element[OxO97ae[28]][OxO97ae[31]];if(Browser_IsWinIE()){sel_float[OxO97ae[29]]=element[OxO97ae[28]][OxO97ae[32]];} else {sel_float[OxO97ae[29]]=element[OxO97ae[28]][OxO97ae[33]];} ;sel_clear[OxO97ae[29]]=element[OxO97ae[28]][OxO97ae[34]];var arr=[OxO97ae[35],OxO97ae[36],OxO97ae[37],OxO97ae[38]];for(var Ox35f=0;Ox35f<arr[OxO97ae[39]];Ox35f++){var Ox27d=arr[Ox35f];var Ox2b8=document.getElementById(OxO97ae[40]+Ox27d);var Ox234=document.getElementById(OxO97ae[41]+Ox27d+OxO97ae[42]);Ox234[OxO97ae[43]]=0;if(ParseFloatToString(element[OxO97ae[28]][Ox27d])){Ox2b8[OxO97ae[29]]=ParseFloatToString(element[OxO97ae[28]][Ox27d]);for(var i=0;i<Ox234[OxO97ae[44]][OxO97ae[39]];i++){var Ox2aa=Ox234[OxO97ae[44]][i][OxO97ae[29]];if(Ox2aa&&element[OxO97ae[28]][Ox27d].indexOf(Ox2aa)!=-1){Ox234[OxO97ae[43]]=i;break ;} ;} ;} ;} ;var arr=[OxO97ae[35],OxO97ae[36],OxO97ae[45],OxO97ae[46]];for(var Ox35f=0;Ox35f<arr[OxO97ae[39]];Ox35f++){var Ox27d=arr[Ox35f];var Ox746=OxO97ae[47]+Ox27d.charAt(0).toUpperCase()+Ox27d.substring(1);var Ox2b8=document.getElementById(OxO97ae[48]+Ox27d);var Ox234=document.getElementById(OxO97ae[49]+Ox27d+OxO97ae[42]);Ox234[OxO97ae[43]]=0;var Ox747;if(Browser_IsWinIE()){Ox747=element[OxO97ae[50]][Ox746];} else {Ox747=element[OxO97ae[28]][Ox746];} ;if(ParseFloatToString(Ox747)){Ox2b8[OxO97ae[29]]=ParseFloatToString(Ox747);for(var i=0;i<Ox234[OxO97ae[44]][OxO97ae[39]];i++){var Ox2aa=Ox234[OxO97ae[44]][i][OxO97ae[29]];if(Ox2aa&&Ox747.indexOf(Ox2aa)!=-1){Ox234[OxO97ae[43]]=i;break ;} ;} ;} ;} ;sel_overflow[OxO97ae[29]]=element[OxO97ae[28]][OxO97ae[51]];tb_zindex[OxO97ae[29]]=element[OxO97ae[28]][OxO97ae[52]];sel_pagebreakbefore[OxO97ae[29]]=element[OxO97ae[28]][OxO97ae[53]];sel_pagebreakafter[OxO97ae[29]]=element[OxO97ae[28]][OxO97ae[54]];} ;SyncTo=function SyncTo_Layout(element){element[OxO97ae[28]][OxO97ae[30]]=sel_position[OxO97ae[29]];element[OxO97ae[28]][OxO97ae[31]]=sel_display[OxO97ae[29]];if(Browser_IsWinIE()){element[OxO97ae[28]][OxO97ae[32]]=sel_float[OxO97ae[29]];} else {element[OxO97ae[28]][OxO97ae[33]]=sel_float[OxO97ae[29]];} ;element[OxO97ae[28]][OxO97ae[34]]=sel_clear[OxO97ae[29]];var arr=[OxO97ae[35],OxO97ae[36],OxO97ae[37],OxO97ae[38]];for(var Ox35f=0;Ox35f<arr[OxO97ae[39]];Ox35f++){var Ox27d=arr[Ox35f];var Ox2b8=document.getElementById(OxO97ae[40]+Ox27d);if(ParseFloatToString(Ox2b8.value)){element[OxO97ae[28]][Ox27d]=ParseFloatToString(Ox2b8.value)+document.all(OxO97ae[41]+Ox27d+OxO97ae[42])[OxO97ae[29]];} else {element[OxO97ae[28]][Ox27d]=OxO97ae[0];} ;} ;var arr=[OxO97ae[35],OxO97ae[36],OxO97ae[45],OxO97ae[46]];for(var Ox35f=0;Ox35f<arr[OxO97ae[39]];Ox35f++){var Ox27d=arr[Ox35f];var Ox746=OxO97ae[47]+Ox27d.charAt(0).toUpperCase()+Ox27d.substring(1);var Ox2b8=document.getElementById(OxO97ae[48]+Ox27d);if(ParseFloatToString(Ox2b8.value)){element[OxO97ae[28]][Ox746]=ParseFloatToString(Ox2b8.value)+document.all(OxO97ae[49]+Ox27d+OxO97ae[42])[OxO97ae[29]];} else {element[OxO97ae[28]][Ox746]=OxO97ae[0];} ;} ;element[OxO97ae[28]][OxO97ae[51]]=sel_overflow[OxO97ae[29]];element[OxO97ae[28]][OxO97ae[52]]=ParseFloatToString(tb_zindex.value);element[OxO97ae[28]][OxO97ae[53]]=sel_pagebreakbefore[OxO97ae[29]];element[OxO97ae[28]][OxO97ae[54]]=sel_pagebreakafter[OxO97ae[29]];} ;