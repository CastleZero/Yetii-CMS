var OxO9921=["SetStyle","length","","GetStyle","GetText",":",";","cssText","sel_font","div_font_detail","sel_fontfamily","cb_decoration_under","cb_decoration_over","cb_decoration_through","cb_style_bold","cb_style_italic","sel_fontTransform","sel_fontsize","inp_fontsize","sel_fontsize_unit","inp_color","inp_color_Preview","outer","div_demo","disabled","selectedIndex","style","value","font","fontFamily","color","backgroundColor","textDecoration","checked","overline","underline","line-through","fontWeight","bold","fontStyle","italic","fontSize","options","textTransform","font-family","overline ","underline ","line-through ","onclick"];function pause(Ox5e4){var Ox565= new Date();var Ox5e5=Ox565.getTime()+Ox5e4;while(true){Ox565= new Date();if(Ox565.getTime()>Ox5e5){return ;} ;} ;} ;function StyleClass(Ox363){var Ox5e7=[];var Ox5e8={};if(Ox363){Ox5ed();} ;this[OxO9921[0]]=function SetStyle(name,Ox289,Ox5ea){name=name.toLowerCase();for(var i=0;i<Ox5e7[OxO9921[1]];i++){if(Ox5e7[i]==name){break ;} ;} ;Ox5e7[i]=name;Ox5e8[name]=Ox289?(Ox289+(Ox5ea||OxO9921[2])):OxO9921[2];} ;this[OxO9921[3]]=function GetStyle(name){name=name.toLowerCase();return Ox5e8[name]||OxO9921[2];} ;this[OxO9921[4]]=function Ox5ec(){var Ox363=OxO9921[2];for(var i=0;i<Ox5e7[OxO9921[1]];i++){var Ox27d=Ox5e7[i];var p=Ox5e8[Ox27d];if(p){Ox363+=Ox27d+OxO9921[5]+p+OxO9921[6];} ;} ;return Ox363;} ;function Ox5ed(){var arr=Ox363.split(OxO9921[6]);for(var i=0;i<arr[OxO9921[1]];i++){var p=arr[i].split(OxO9921[5]);var Ox27d=p[0].replace(/^\s+/g,OxO9921[2]).replace(/\s+$/g,OxO9921[2]).toLowerCase();Ox5e7[Ox5e7[OxO9921[1]]]=Ox27d;Ox5e8[Ox27d]=p[1];} ;} ;} ;function GetStyle(Ox2a0,name){return  new StyleClass(Ox2a0.cssText).GetStyle(name);} ;function SetStyle(Ox2a0,name,Ox289,Ox5ee){var Ox5ef= new StyleClass(Ox2a0.cssText);Ox5ef.SetStyle(name,Ox289,Ox5ee);Ox2a0[OxO9921[7]]=Ox5ef.GetText();} ;function ParseFloatToString(Oxb){var Ox2fe=parseFloat(Oxb);if(isNaN(Ox2fe)){return OxO9921[2];} ;return Ox2fe+OxO9921[2];} ;var sel_font=Window_GetElement(window,OxO9921[8],true);var div_font_detail=Window_GetElement(window,OxO9921[9],true);var sel_fontfamily=Window_GetElement(window,OxO9921[10],true);var cb_decoration_under=Window_GetElement(window,OxO9921[11],true);var cb_decoration_over=Window_GetElement(window,OxO9921[12],true);var cb_decoration_through=Window_GetElement(window,OxO9921[13],true);var cb_style_bold=Window_GetElement(window,OxO9921[14],true);var cb_style_italic=Window_GetElement(window,OxO9921[15],true);var sel_fontTransform=Window_GetElement(window,OxO9921[16],true);var sel_fontsize=Window_GetElement(window,OxO9921[17],true);var inp_fontsize=Window_GetElement(window,OxO9921[18],true);var sel_fontsize_unit=Window_GetElement(window,OxO9921[19],true);var inp_color=Window_GetElement(window,OxO9921[20],true);var inp_color_Preview=Window_GetElement(window,OxO9921[21],true);var outer=Window_GetElement(window,OxO9921[22],true);var div_demo=Window_GetElement(window,OxO9921[23],true);UpdateState=function UpdateState_Font(){inp_fontsize[OxO9921[24]]=sel_fontsize_unit[OxO9921[24]]=(sel_fontsize[OxO9921[25]]>0);div_font_detail[OxO9921[24]]=sel_font[OxO9921[25]]>0;div_demo[OxO9921[26]][OxO9921[7]]=element[OxO9921[26]][OxO9921[7]];} ;SyncToView=function SyncToView_Font(){sel_font[OxO9921[27]]=element[OxO9921[26]][OxO9921[28]].toLowerCase()||null;sel_fontfamily[OxO9921[27]]=element[OxO9921[26]][OxO9921[29]];inp_color[OxO9921[27]]=element[OxO9921[26]][OxO9921[30]];inp_color[OxO9921[26]][OxO9921[31]]=inp_color[OxO9921[27]];var Ox729=element[OxO9921[26]][OxO9921[32]].toLowerCase();cb_decoration_over[OxO9921[33]]=Ox729.indexOf(OxO9921[34])!=-1;cb_decoration_under[OxO9921[33]]=Ox729.indexOf(OxO9921[35])!=-1;cb_decoration_through[OxO9921[33]]=Ox729.indexOf(OxO9921[36])!=-1;cb_style_bold[OxO9921[33]]=element[OxO9921[26]][OxO9921[37]]==OxO9921[38];cb_style_italic[OxO9921[33]]=element[OxO9921[26]][OxO9921[39]]==OxO9921[40];sel_fontsize[OxO9921[27]]=element[OxO9921[26]][OxO9921[41]];sel_fontsize_unit[OxO9921[25]]=0;if(sel_fontsize[OxO9921[25]]==-1){if(ParseFloatToString(element[OxO9921[26]].fontSize)){sel_fontsize[OxO9921[27]]=ParseFloatToString(element[OxO9921[26]].fontSize);for(var i=0;i<sel_fontsize_unit[OxO9921[42]][OxO9921[1]];i++){var Ox2aa=sel_fontsize_unit.options(i)[OxO9921[27]];if(Ox2aa&&element[OxO9921[26]][OxO9921[41]].indexOf(Ox2aa)!=-1){sel_fontsize_unit[OxO9921[25]]=i;break ;} ;} ;} ;} ;sel_fontTransform[OxO9921[27]]=element[OxO9921[26]][OxO9921[43]];} ;SyncTo=function SyncTo_Font(element){SetStyle(element.style,OxO9921[28],sel_font.value);if(sel_fontfamily[OxO9921[27]]){element[OxO9921[26]][OxO9921[29]]=sel_fontfamily[OxO9921[27]];} else {SetStyle(element.style,OxO9921[44],OxO9921[2]);} ;try{element[OxO9921[26]][OxO9921[30]]=inp_color[OxO9921[27]]||OxO9921[2];} catch(x){element[OxO9921[26]][OxO9921[30]]=OxO9921[2];} ;var Ox72b=cb_decoration_over[OxO9921[33]];var Ox72c=cb_decoration_under[OxO9921[33]];var Ox72d=cb_decoration_through[OxO9921[33]];if(!Ox72b&&!Ox72c&&!Ox72d){element[OxO9921[26]][OxO9921[32]]=OxO9921[2];} else {var Ox272=OxO9921[2];if(Ox72b){Ox272+=OxO9921[45];} ;if(Ox72c){Ox272+=OxO9921[46];} ;if(Ox72d){Ox272+=OxO9921[47];} ;element[OxO9921[26]][OxO9921[32]]=Ox272.substr(0,Ox272[OxO9921[1]]-1);} ;element[OxO9921[26]][OxO9921[37]]=cb_style_bold[OxO9921[33]]?OxO9921[38]:OxO9921[2];element[OxO9921[26]][OxO9921[39]]=cb_style_italic[OxO9921[33]]?OxO9921[40]:OxO9921[2];element[OxO9921[26]][OxO9921[43]]=sel_fontTransform[OxO9921[27]]||OxO9921[2];if(sel_fontsize[OxO9921[25]]>0){element[OxO9921[26]][OxO9921[41]]=sel_fontsize[OxO9921[27]];} else {if(ParseFloatToString(inp_fontsize.value)){element[OxO9921[26]][OxO9921[41]]=ParseFloatToString(inp_fontsize.value)+sel_fontsize_unit[OxO9921[27]];} else {element[OxO9921[26]][OxO9921[41]]=OxO9921[2];} ;} ;} ;inp_color[OxO9921[48]]=inp_color_Preview[OxO9921[48]]=function inp_color_onclick(){SelectColor(inp_color,inp_color_Preview);} ;