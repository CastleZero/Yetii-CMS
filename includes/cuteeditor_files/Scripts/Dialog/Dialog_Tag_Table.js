var OxO7cdf=["","removeNode","parentNode","firstChild","nodeName","TABLE","length","Can\x27t Get The Position ?","Map","RowCount","ColCount","rows","cells","Unknown Error , pos ",":"," already have cell","rowSpan","colSpan","Unknown Error , Unable to find bestpos","inp_cellspacing","inp_cellpadding","inp_id","inp_border","inp_bgcolor","inp_bordercolor","sel_rules","inp_collapse","inp_summary","btn_editcaption","btn_delcaption","btn_insthead","btn_instfoot","inp_class","inp_width","sel_width_unit","inp_height","sel_height_unit","sel_align","sel_textalign","sel_float","inp_tooltip","onclick","tHead","tFoot","caption","innerHTML","innerText","Unable to delete the caption. Please remove it in HTML source.","display","style","none","disabled","value","cellSpacing","cellPadding","id","border","borderColor","backgroundColor","bgColor","checked","borderCollapse","collapse","rules","summary","className","width","options","selectedIndex","height","align","styleFloat","cssFloat","textAlign","title","bordercolor","0","%","class","CaptionTable"];function ParseFloatToString(Oxb){var Ox2fe=parseFloat(Oxb);if(isNaN(Ox2fe)){return OxO7cdf[0];} ;return Ox2fe+OxO7cdf[0];} ;function Element_RemoveNode(element,Ox656){if(element[OxO7cdf[1]]){element.removeNode(Ox656);return ;} ;var p=element[OxO7cdf[2]];if(!p){return ;} ;if(Ox656){p.removeChild(element);return ;} ;while(true){var Ox3a5=element[OxO7cdf[3]];if(!Ox3a5){break ;} ;p.insertBefore(Ox3a5,element);} ;p.removeChild(element);} ;function Table_GetTable(Ox2b8){for(;Ox2b8!=null;Ox2b8=Ox2b8[OxO7cdf[2]]){if(Ox2b8[OxO7cdf[4]]==OxO7cdf[5]){return Ox2b8;} ;} ;return null;} ;function Table_GetCellPositionFromMap(Ox650,Ox7){for(var Ox337=0;Ox337<Ox650[OxO7cdf[6]];Ox337++){var Ox653=Ox650[Ox337];for(var Ox367=0;Ox367<Ox653[OxO7cdf[6]];Ox367++){if(Ox653[Ox367]==Ox7){return {rowIndex:Ox337,cellIndex:Ox367};} ;} ;} ;throw ( new Error(-1,OxO7cdf[7]));} ;function Table_GetCellMap(Ox4){return Table_CalculateTableInfo(Ox4)[OxO7cdf[8]];} ;function Table_GetRowCount(Ox2b8){return Table_CalculateTableInfo(Ox2b8)[OxO7cdf[9]];} ;function Table_GetColCount(Ox2b8){return Table_CalculateTableInfo(Ox2b8)[OxO7cdf[10]];} ;function Table_CalculateTableInfo(Ox2b8){var Ox4=Table_GetTable(Ox2b8);var Ox663=Ox4[OxO7cdf[11]];for(var Ox26=Ox663[OxO7cdf[6]]-1;Ox26>=0;Ox26--){var Ox664=Ox663.item(Ox26);if(Ox664[OxO7cdf[12]][OxO7cdf[6]]==0){Element_RemoveNode(Ox664,true);continue ;} ;} ;var Ox665=Ox663[OxO7cdf[6]];var Ox666=0;var Ox667= new Array(Ox663.length);for(var Ox668=0;Ox668<Ox665;Ox668++){Ox667[Ox668]=[];} ;function Ox669(Ox26,Ox3a5,Ox7){while(Ox26>=Ox665){Ox667[Ox665]=[];Ox665++;} ;var Ox66a=Ox667[Ox26];if(Ox3a5>=Ox666){Ox666=Ox3a5+1;} ;if(Ox66a[Ox3a5]!=null){throw ( new Error(-1,OxO7cdf[13]+Ox26+OxO7cdf[14]+Ox3a5+OxO7cdf[15]));} ;Ox66a[Ox3a5]=Ox7;} ;function Ox66b(Ox26,Ox3a5){var Ox66a=Ox667[Ox26];if(Ox66a){return Ox66a[Ox3a5];} ;} ;for(var Ox668=0;Ox668<Ox663[OxO7cdf[6]];Ox668++){var Ox664=Ox663.item(Ox668);var Ox66c=Ox664[OxO7cdf[12]];for(var Ox11=0;Ox11<Ox66c[OxO7cdf[6]];Ox11++){var Ox7=Ox66c.item(Ox11);var Ox66d=Ox7[OxO7cdf[16]];var Ox66e=Ox7[OxO7cdf[17]];var Ox66a=Ox667[Ox668];var Ox66f=-1;for(var Ox670=0;Ox670<Ox666+Ox66e+1;Ox670++){if(Ox66d==1&&Ox66e==1){if(Ox66a[Ox670]==null){Ox66f=Ox670;break ;} ;} else {var Ox671=true;for(var Ox672=0;Ox672<Ox66d;Ox672++){for(var Ox673=0;Ox673<Ox66e;Ox673++){if(Ox66b(Ox668+Ox672,Ox670+Ox673)!=null){Ox671=false;break ;} ;} ;} ;if(Ox671){Ox66f=Ox670;break ;} ;} ;} ;if(Ox66f==-1){throw ( new Error(-1,OxO7cdf[18]));} ;if(Ox66d==1&&Ox66e==1){Ox669(Ox668,Ox66f,Ox7);} else {for(var Ox672=0;Ox672<Ox66d;Ox672++){for(var Ox673=0;Ox673<Ox66e;Ox673++){Ox669(Ox668+Ox672,Ox66f+Ox673,Ox7);} ;} ;} ;} ;} ;var Ox2a6={};Ox2a6[OxO7cdf[9]]=Ox665;Ox2a6[OxO7cdf[10]]=Ox666;Ox2a6[OxO7cdf[8]]=Ox667;for(var Ox26=0;Ox26<Ox665;Ox26++){var Ox66a=Ox667[Ox26];for(var Ox3a5=0;Ox3a5<Ox666;Ox3a5++){} ;} ;return Ox2a6;} ;var inp_cellspacing=Window_GetElement(window,OxO7cdf[19],true);var inp_cellpadding=Window_GetElement(window,OxO7cdf[20],true);var inp_id=Window_GetElement(window,OxO7cdf[21],true);var inp_border=Window_GetElement(window,OxO7cdf[22],true);var inp_bgcolor=Window_GetElement(window,OxO7cdf[23],true);var inp_bordercolor=Window_GetElement(window,OxO7cdf[24],true);var sel_rules=Window_GetElement(window,OxO7cdf[25],true);var inp_collapse=Window_GetElement(window,OxO7cdf[26],true);var inp_summary=Window_GetElement(window,OxO7cdf[27],true);var btn_editcaption=Window_GetElement(window,OxO7cdf[28],true);var btn_delcaption=Window_GetElement(window,OxO7cdf[29],true);var btn_insthead=Window_GetElement(window,OxO7cdf[30],true);var btn_instfoot=Window_GetElement(window,OxO7cdf[31],true);var inp_class=Window_GetElement(window,OxO7cdf[32],true);var inp_width=Window_GetElement(window,OxO7cdf[33],true);var sel_width_unit=Window_GetElement(window,OxO7cdf[34],true);var inp_height=Window_GetElement(window,OxO7cdf[35],true);var sel_height_unit=Window_GetElement(window,OxO7cdf[36],true);var sel_align=Window_GetElement(window,OxO7cdf[37],true);var sel_textalign=Window_GetElement(window,OxO7cdf[38],true);var sel_float=Window_GetElement(window,OxO7cdf[39],true);var inp_tooltip=Window_GetElement(window,OxO7cdf[40],true);function insertOneRow(Ox767,Ox553){var Ox664=Ox767.insertRow(-1);for(var i=0;i<Ox553;i++){Ox664.insertCell();} ;} ;btn_insthead[OxO7cdf[41]]=function btn_insthead_onclick(){if(element[OxO7cdf[42]]){element.deleteTHead();} else {var Ox769=Table_GetColCount(element);var Ox76a=element.createTHead();insertOneRow(Ox76a,Ox769);} ;} ;btn_instfoot[OxO7cdf[41]]=function btn_instfoot_onclick(){if(element[OxO7cdf[43]]){element.deleteTFoot();} else {var Ox769=Table_GetColCount(element);var Ox76c=element.createTFoot();insertOneRow(Ox76c,Ox769);} ;} ;btn_editcaption[OxO7cdf[41]]=function btn_editcaption_onclick(){var Ox76e=element[OxO7cdf[44]];if(Ox76e!=null){var Ox3e6=editor.EditInWindow(Ox76e.innerHTML,window);if(Ox3e6!=null&&Ox3e6!==false){Ox76e[OxO7cdf[45]]=Ox3e6;} ;} else {var Ox76e=element.createCaption();if(Browser_IsGecko()){Ox76e[OxO7cdf[45]]=Caption;} else {Ox76e[OxO7cdf[46]]=Caption;} ;} ;} ;btn_delcaption[OxO7cdf[41]]=function btn_delcaption_onclick(){if(element[OxO7cdf[44]]!=null){alert(OxO7cdf[47]);} ;} ;UpdateState=function UpdateState_Table(){if(Browser_IsGecko()){btn_insthead[OxO7cdf[45]]=element[OxO7cdf[42]]?Delete:Insert;btn_instfoot[OxO7cdf[45]]=element[OxO7cdf[43]]?Delete:Insert;} else {btn_insthead[OxO7cdf[46]]=element[OxO7cdf[42]]?Delete:Insert;btn_instfoot[OxO7cdf[46]]=element[OxO7cdf[43]]?Delete:Insert;} ;if(element[OxO7cdf[44]]!=null){if(Browser_IsGecko()){btn_editcaption[OxO7cdf[45]]=Edit;} else {btn_editcaption[OxO7cdf[46]]=Edit;} ;btn_editcaption[OxO7cdf[49]][OxO7cdf[48]]=OxO7cdf[50];btn_delcaption[OxO7cdf[51]]=false;} else {if(Browser_IsGecko()){btn_editcaption[OxO7cdf[45]]=Insert;} else {btn_editcaption[OxO7cdf[46]]=Insert;} ;btn_delcaption[OxO7cdf[51]]=true;} ;} ;var t_inp_width=OxO7cdf[0];var t_inp_height=OxO7cdf[0];SyncToView=function SyncToView_Table(){inp_cellspacing[OxO7cdf[52]]=element.getAttribute(OxO7cdf[53])||OxO7cdf[0];inp_cellpadding[OxO7cdf[52]]=element.getAttribute(OxO7cdf[54])||OxO7cdf[0];inp_id[OxO7cdf[52]]=element.getAttribute(OxO7cdf[55])||OxO7cdf[0];inp_border[OxO7cdf[52]]=element.getAttribute(OxO7cdf[56])||OxO7cdf[0];inp_bordercolor[OxO7cdf[52]]=element.getAttribute(OxO7cdf[57])||OxO7cdf[0];inp_bordercolor[OxO7cdf[49]][OxO7cdf[58]]=inp_bordercolor[OxO7cdf[52]];inp_bgcolor[OxO7cdf[52]]=element.getAttribute(OxO7cdf[59])||element[OxO7cdf[49]][OxO7cdf[58]]||OxO7cdf[0];inp_bgcolor[OxO7cdf[49]][OxO7cdf[58]]=inp_bgcolor[OxO7cdf[52]];inp_collapse[OxO7cdf[60]]=element[OxO7cdf[49]][OxO7cdf[61]]==OxO7cdf[62];sel_rules[OxO7cdf[52]]=element.getAttribute(OxO7cdf[63])||OxO7cdf[0];inp_summary[OxO7cdf[52]]=element.getAttribute(OxO7cdf[64])||OxO7cdf[0];inp_class[OxO7cdf[52]]=element[OxO7cdf[65]];if(element.getAttribute(OxO7cdf[66])){t_inp_width=element.getAttribute(OxO7cdf[66]);} else {if(element[OxO7cdf[49]][OxO7cdf[66]]){t_inp_width=element[OxO7cdf[49]][OxO7cdf[66]];} ;} ;if(t_inp_width){inp_width[OxO7cdf[52]]=ParseFloatToString(t_inp_width);for(var i=0;i<sel_width_unit[OxO7cdf[67]][OxO7cdf[6]];i++){var Ox2aa=sel_width_unit[OxO7cdf[67]][i][OxO7cdf[52]];if(Ox2aa&&t_inp_width.indexOf(Ox2aa)!=-1){sel_width_unit[OxO7cdf[68]]=i;break ;} ;} ;} ;if(element.getAttribute(OxO7cdf[69])){t_inp_height=element.getAttribute(OxO7cdf[69]);} else {if(element[OxO7cdf[49]][OxO7cdf[69]]){t_inp_height=element[OxO7cdf[49]][OxO7cdf[69]];} ;} ;if(t_inp_height){inp_height[OxO7cdf[52]]=ParseFloatToString(t_inp_height);for(var i=0;i<sel_height_unit[OxO7cdf[67]][OxO7cdf[6]];i++){var Ox2aa=sel_height_unit[OxO7cdf[67]][i][OxO7cdf[52]];if(Ox2aa&&t_inp_height.indexOf(Ox2aa)!=-1){sel_height_unit[OxO7cdf[68]]=i;break ;} ;} ;} ;sel_align[OxO7cdf[52]]=element[OxO7cdf[70]];if(Browser_IsWinIE()){sel_float[OxO7cdf[52]]=element[OxO7cdf[49]][OxO7cdf[71]];} else {sel_float[OxO7cdf[52]]=element[OxO7cdf[49]][OxO7cdf[72]];} ;sel_textalign[OxO7cdf[52]]=element[OxO7cdf[49]][OxO7cdf[73]];inp_tooltip[OxO7cdf[52]]=element[OxO7cdf[74]];} ;SyncTo=function SyncTo_Table(element){if(Browser_IsWinIE()){element[OxO7cdf[57]]=inp_bordercolor[OxO7cdf[52]];} else {element.setAttribute(OxO7cdf[75],inp_bordercolor.value);} ;if(inp_bgcolor[OxO7cdf[52]]){if(element[OxO7cdf[49]][OxO7cdf[58]]){element[OxO7cdf[49]][OxO7cdf[58]]=inp_bgcolor[OxO7cdf[52]];} else {element[OxO7cdf[59]]=inp_bgcolor[OxO7cdf[52]];} ;} else {element.removeAttribute(OxO7cdf[59]);} ;element[OxO7cdf[49]][OxO7cdf[61]]=inp_collapse[OxO7cdf[60]]?OxO7cdf[62]:OxO7cdf[0];element[OxO7cdf[63]]=sel_rules[OxO7cdf[52]]||OxO7cdf[0];element[OxO7cdf[64]]=inp_summary[OxO7cdf[52]];element[OxO7cdf[65]]=inp_class[OxO7cdf[52]];element[OxO7cdf[53]]=inp_cellspacing[OxO7cdf[52]];element[OxO7cdf[54]]=inp_cellpadding[OxO7cdf[52]];var Ox4e2=/[^a-z\d]/i;if(Ox4e2.test(inp_id.value)){alert(ValidID);return ;} ;element[OxO7cdf[55]]=inp_id[OxO7cdf[52]];if(inp_border[OxO7cdf[52]]==OxO7cdf[0]){element[OxO7cdf[56]]=OxO7cdf[76];} else {element[OxO7cdf[56]]=inp_border[OxO7cdf[52]];} ;if(inp_width[OxO7cdf[52]]==OxO7cdf[0]){element.removeAttribute(OxO7cdf[66]);element[OxO7cdf[49]][OxO7cdf[66]]=OxO7cdf[0];} else {try{t_inp_width=inp_width[OxO7cdf[52]];if(sel_width_unit[OxO7cdf[52]]==OxO7cdf[77]){t_inp_width=inp_width[OxO7cdf[52]]+sel_width_unit[OxO7cdf[52]];} ;if(element[OxO7cdf[49]][OxO7cdf[66]]&&element[OxO7cdf[66]]){element[OxO7cdf[49]][OxO7cdf[66]]=t_inp_width;element[OxO7cdf[66]]=t_inp_width;} else {if(element[OxO7cdf[49]][OxO7cdf[66]]){element[OxO7cdf[49]][OxO7cdf[66]]=t_inp_width;} else {element[OxO7cdf[66]]=t_inp_width;} ;} ;} catch(x){} ;} ;if(inp_height[OxO7cdf[52]]==OxO7cdf[0]){element.removeAttribute(OxO7cdf[69]);element[OxO7cdf[49]][OxO7cdf[69]]=OxO7cdf[0];} else {try{t_inp_height=inp_height[OxO7cdf[52]];if(sel_height_unit[OxO7cdf[52]]==OxO7cdf[77]){t_inp_height=inp_height[OxO7cdf[52]]+sel_height_unit[OxO7cdf[52]];} ;t_inp_height=inp_height[OxO7cdf[52]]+sel_height_unit[OxO7cdf[52]];if(element[OxO7cdf[49]][OxO7cdf[69]]&&element[OxO7cdf[69]]){element[OxO7cdf[49]][OxO7cdf[69]]=t_inp_height;element[OxO7cdf[69]]=t_inp_height;} else {if(element[OxO7cdf[49]][OxO7cdf[69]]){element[OxO7cdf[49]][OxO7cdf[69]]=t_inp_height;} else {element[OxO7cdf[69]]=t_inp_height;} ;} ;} catch(x){} ;} ;element[OxO7cdf[70]]=sel_align[OxO7cdf[52]];if(Browser_IsWinIE()){element[OxO7cdf[49]][OxO7cdf[71]]=sel_float[OxO7cdf[52]];} else {element[OxO7cdf[49]][OxO7cdf[72]]=sel_float[OxO7cdf[52]];} ;element[OxO7cdf[49]][OxO7cdf[73]]=sel_textalign[OxO7cdf[52]];element[OxO7cdf[74]]=inp_tooltip[OxO7cdf[52]];if(element[OxO7cdf[74]]==OxO7cdf[0]){element.removeAttribute(OxO7cdf[74]);} ;if(element[OxO7cdf[64]]==OxO7cdf[0]){element.removeAttribute(OxO7cdf[64]);} ;if(element[OxO7cdf[65]]==OxO7cdf[0]){element.removeAttribute(OxO7cdf[65]);} ;if(element[OxO7cdf[65]]==OxO7cdf[0]){element.removeAttribute(OxO7cdf[78]);} ;if(element[OxO7cdf[55]]==OxO7cdf[0]){element.removeAttribute(OxO7cdf[55]);} ;if(element[OxO7cdf[70]]==OxO7cdf[0]){element.removeAttribute(OxO7cdf[70]);} ;if(element[OxO7cdf[63]]==OxO7cdf[0]){element.removeAttribute(OxO7cdf[63]);} ;} ;inp_bgcolor[OxO7cdf[41]]=function inp_bgcolor_onclick(){SelectColor(inp_bgcolor);} ;inp_bordercolor[OxO7cdf[41]]=function inp_bordercolor_onclick(){SelectColor(inp_bordercolor);} ;if(!Browser_IsWinIE()){Window_GetElement(window,OxO7cdf[79],true)[OxO7cdf[49]][OxO7cdf[48]]=OxO7cdf[50];} ;