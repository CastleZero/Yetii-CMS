var OxOaa09=["onload","onclick","btnCancel","btnOK","onkeyup","txtHSB_Hue","onkeypress","txtHSB_Saturation","txtHSB_Brightness","txtRGB_Red","txtRGB_Green","txtRGB_Blue","txtHex","btnWebSafeColor","rdoHSB_Hue","rdoHSB_Saturation","rdoHSB_Brightness","pnlGradient_Top","onmousemove","onmousedown","onmouseup","pnlVertical_Top","pnlWebSafeColor","pnlWebSafeColorBorder","pnlOldColor","lblHSB_Hue","lblHSB_Saturation","lblHSB_Brightness","length","\x5C{","\x5C}","BadNumber","A number between {0} and {1} is required. Closest value inserted.","Title","Color Picker","SelectAColor","Select a color:","OKButton","OK","CancelButton","Cancel","AboutButton","About","Recent","WebSafeWarning","Warning: not a web safe color","WebSafeClick","Click to select web safe color","HsbHue","H:","HsbHueTooltip","Hue","HsbHueUnit","%","HsbSaturation","S:","HsbSaturationTooltip","Saturation","HsbSaturationUnit","HsbBrightness","B:","HsbBrightnessTooltip","Brightness","HsbBrightnessUnit","RgbRed","R:","RgbRedTooltip","Red","RgbGreen","G:","RgbGreenTooltip","Green","RgbBlue","RgbBlueTooltip","Blue","Hex","#","RecentTooltip","Recent:","\x0D\x0ALewies Color Pickerversion 1.1\x0D\x0A\x0D\x0AThis form was created by Lewis Moten in May of 2004.\x0D\x0AIt simulates the color picker in a popular graphics application.\x0D\x0AIt gives users a visual way to choose colors from a large and dynamic palette.\x0D\x0A\x0D\x0AVisit the authors web page?\x0D\x0Awww.lewismoten.com\x0D\x0A","lblSelectColorMessage","lblRecent","lblRGB_Red","lblRGB_Green","lblRGB_Blue","lblHex","lblUnitHSB_Hue","lblUnitHSB_Saturation","lblUnitHSB_Brightness","pnlHSB_Hue","pnlHSB_Saturation","pnlHSB_Brightness","pnlRGB_Red","pnlRGB_Green","pnlRGB_Blue","frmColorPicker","Color","","FFFFFF","value","checked","ColorMode","ColorType","RecentColors","pnlRecent","border","style","0px","http://www.lewismoten.com","_blank","backgroundColor","target","rgb","(",")",",","display","none","title","innerHTML","backgroundPosition","px ","px","pnlGradientHsbHue_Hue","pnlGradientHsbHue_Black","pnlGradientHsbHue_White","pnlVerticalHsbHue_Background","pnlVerticalHsbSaturation_Hue","pnlVerticalHsbSaturation_White","pnlVerticalHsbBrightness_Hue","pnlVerticalHsbBrightness_Black","pnlVerticalRgb_Start","pnlVerticalRgb_End","pnlGradientRgb_Base","pnlGradientRgb_Invert","pnlGradientRgb_Overlay1","pnlGradientRgb_Overlay2","src","imgGradient","../Images/cpns_ColorSpace1.png","../Images/cpns_ColorSpace2.png","../Images/cpns_Vertical1.png","#000000","../Images/cpns_Vertical2.png","#ffffff","01234567879","which","abcdef","01234567879ABCDEF","opener","pnlGradientPosition","pnlNewColor","0123456789ABCDEFabcdef","000000","0","id","top","pnlVerticalPosition","backgroundImage","url(../Images/cpns_GradientPositionDark.gif)","url(../Images/cpns_GradientPositionLight.gif)","cancelBubble","pageX","pageY","className","GradientNormal","GradientFullScreen","_isverdown","=","; path=/;"," expires=",";","cookie","search","location","\x26","00336699CCFF","0x","do_select","frm","__cphex"];var POSITIONADJUSTX=22;var POSITIONADJUSTY=52;var POSITIONADJUSTZ=48;var ColorMode=1;var GradientPositionDark= new Boolean(false);var frm= new Object();var msg= new Object();var _xmlDocs= new Array();var _xmlIndex=-1;var _xml=null;LoadLanguage();window[OxOaa09[0]]=window_load;function initialize(){frm[OxOaa09[2]][OxOaa09[1]]=btnCancel_Click;frm[OxOaa09[3]][OxOaa09[1]]=btnOK_Click;frm[OxOaa09[5]][OxOaa09[4]]=Hsb_Changed;frm[OxOaa09[5]][OxOaa09[6]]=validateNumber;frm[OxOaa09[7]][OxOaa09[4]]=Hsb_Changed;frm[OxOaa09[7]][OxOaa09[6]]=validateNumber;frm[OxOaa09[8]][OxOaa09[4]]=Hsb_Changed;frm[OxOaa09[8]][OxOaa09[6]]=validateNumber;frm[OxOaa09[9]][OxOaa09[4]]=Rgb_Changed;frm[OxOaa09[9]][OxOaa09[6]]=validateNumber;frm[OxOaa09[10]][OxOaa09[4]]=Rgb_Changed;frm[OxOaa09[10]][OxOaa09[6]]=validateNumber;frm[OxOaa09[11]][OxOaa09[4]]=Rgb_Changed;frm[OxOaa09[11]][OxOaa09[6]]=validateNumber;frm[OxOaa09[12]][OxOaa09[4]]=Hex_Changed;frm[OxOaa09[12]][OxOaa09[6]]=validateHex;frm[OxOaa09[13]][OxOaa09[1]]=btnWebSafeColor_Click;frm[OxOaa09[14]][OxOaa09[1]]=rdoHsb_Hue_Click;frm[OxOaa09[15]][OxOaa09[1]]=rdoHsb_Saturation_Click;frm[OxOaa09[16]][OxOaa09[1]]=rdoHsb_Brightness_Click;document.getElementById(OxOaa09[17])[OxOaa09[1]]=pnlGradient_Top_Click;document.getElementById(OxOaa09[17])[OxOaa09[18]]=pnlGradient_Top_MouseMove;document.getElementById(OxOaa09[17])[OxOaa09[19]]=pnlGradient_Top_MouseDown;document.getElementById(OxOaa09[17])[OxOaa09[20]]=pnlGradient_Top_MouseUp;document.getElementById(OxOaa09[21])[OxOaa09[1]]=pnlVertical_Top_Click;document.getElementById(OxOaa09[21])[OxOaa09[18]]=pnlVertical_Top_MouseMove;document.getElementById(OxOaa09[21])[OxOaa09[19]]=pnlVertical_Top_MouseDown;document.getElementById(OxOaa09[21])[OxOaa09[20]]=pnlVertical_Top_MouseUp;document.getElementById(OxOaa09[22])[OxOaa09[1]]=btnWebSafeColor_Click;document.getElementById(OxOaa09[23])[OxOaa09[1]]=btnWebSafeColor_Click;document.getElementById(OxOaa09[24])[OxOaa09[1]]=pnlOldClick_Click;document.getElementById(OxOaa09[25])[OxOaa09[1]]=rdoHsb_Hue_Click;document.getElementById(OxOaa09[26])[OxOaa09[1]]=rdoHsb_Saturation_Click;document.getElementById(OxOaa09[27])[OxOaa09[1]]=rdoHsb_Brightness_Click;frm[OxOaa09[5]].focus();window.focus();} ;function formatString(Ox419){Ox419= new String(Ox419);for(var i=1;i<arguments[OxOaa09[28]];i++){Ox419=Ox419.replace( new RegExp(OxOaa09[29]+(i-1)+OxOaa09[30]),arguments[i]);} ;return Ox419;} ;function AddValue(Ox41b,Ox289){Ox289= new String(Ox289).toLowerCase();for(var i=0;i<Ox41b[OxOaa09[28]];i++){if(Ox41b[i]==Ox289){return ;} ;} ;Ox41b[Ox41b[OxOaa09[28]]]=Ox289;} ;function SniffLanguage(Oxd){} ;function LoadNextLanguage(){} ;function LoadLanguage(){msg[OxOaa09[31]]=OxOaa09[32];msg[OxOaa09[33]]=OxOaa09[34];msg[OxOaa09[35]]=OxOaa09[36];msg[OxOaa09[37]]=OxOaa09[38];msg[OxOaa09[39]]=OxOaa09[40];msg[OxOaa09[41]]=OxOaa09[42];msg[OxOaa09[43]]=OxOaa09[43];msg[OxOaa09[44]]=OxOaa09[45];msg[OxOaa09[46]]=OxOaa09[47];msg[OxOaa09[48]]=OxOaa09[49];msg[OxOaa09[50]]=OxOaa09[51];msg[OxOaa09[52]]=OxOaa09[53];msg[OxOaa09[54]]=OxOaa09[55];msg[OxOaa09[56]]=OxOaa09[57];msg[OxOaa09[58]]=OxOaa09[53];msg[OxOaa09[59]]=OxOaa09[60];msg[OxOaa09[61]]=OxOaa09[62];msg[OxOaa09[63]]=OxOaa09[53];msg[OxOaa09[64]]=OxOaa09[65];msg[OxOaa09[66]]=OxOaa09[67];msg[OxOaa09[68]]=OxOaa09[69];msg[OxOaa09[70]]=OxOaa09[71];msg[OxOaa09[72]]=OxOaa09[60];msg[OxOaa09[73]]=OxOaa09[74];msg[OxOaa09[75]]=OxOaa09[76];msg[OxOaa09[77]]=OxOaa09[78];msg[OxOaa09[42]]=OxOaa09[79];} ;function AssignLanguage(){} ;function localize(){SetHTML(document.getElementById(OxOaa09[80]),msg.SelectAColor,document.getElementById(OxOaa09[81]),msg.Recent,document.getElementById(OxOaa09[25]),msg.HsbHue,document.getElementById(OxOaa09[26]),msg.HsbSaturation,document.getElementById(OxOaa09[27]),msg.HsbBrightness,document.getElementById(OxOaa09[82]),msg.RgbRed,document.getElementById(OxOaa09[83]),msg.RgbGreen,document.getElementById(OxOaa09[84]),msg.RgbBlue,document.getElementById(OxOaa09[85]),msg.Hex,document.getElementById(OxOaa09[86]),msg.HsbHueUnit,document.getElementById(OxOaa09[87]),msg.HsbSaturationUnit,document.getElementById(OxOaa09[88]),msg.HsbBrightnessUnit);SetValue(frm.btnCancel,msg.CancelButton,frm.btnOK,msg.OKButton,frm.btnAbout,msg.AboutButton);SetTitle(frm.btnWebSafeColor,msg.WebSafeWarning,document.getElementById(OxOaa09[22]),msg.WebSafeClick,document.getElementById(OxOaa09[89]),msg.HsbHueTooltip,document.getElementById(OxOaa09[90]),msg.HsbSaturationTooltip,document.getElementById(OxOaa09[91]),msg.HsbBrightnessTooltip,document.getElementById(OxOaa09[92]),msg.RgbRedTooltip,document.getElementById(OxOaa09[93]),msg.RgbGreenTooltip,document.getElementById(OxOaa09[94]),msg.RgbBlueTooltip);} ;function window_load(Ox2b8){frm=document.getElementById(OxOaa09[95]);localize();initialize();var Ox29b=GetQuery(OxOaa09[96]).toUpperCase();if(Ox29b==OxOaa09[97]){Ox29b=OxOaa09[98];} ;if(Ox29b[OxOaa09[28]]==7){Ox29b=Ox29b.substr(1,6);} ;frm[OxOaa09[12]][OxOaa09[99]]=Ox29b;Hex_Changed(Ox2b8);Ox29b=Form_Get_Hex();SetBg(document.getElementById(OxOaa09[24]),Ox29b);frm[OxOaa09[102]][ new Number(GetCookie(OxOaa09[101])||0)][OxOaa09[100]]=true;ColorMode_Changed(Ox2b8);var Ox40e=GetCookie(OxOaa09[103])||OxOaa09[97];var Ox420=msg[OxOaa09[77]];for(var i=1;i<33;i++){if(Ox40e[OxOaa09[28]]/6>=i){Ox29b=Ox40e.substr((i-1)*6,6);var Ox421=HexToRgb(Ox29b);var title=formatString(msg.RecentTooltip,Ox29b,Ox421[0],Ox421[1],Ox421[2]);SetBg(document.getElementById(OxOaa09[104]+i),Ox29b);SetTitle(document.getElementById(OxOaa09[104]+i),title);document.getElementById(OxOaa09[104]+i)[OxOaa09[1]]=pnlRecent_Click;} else {document.getElementById(OxOaa09[104]+i)[OxOaa09[106]][OxOaa09[105]]=OxOaa09[107];} ;} ;} ;function btnAbout_Click(){if(confirm(msg.About)){window.open(OxOaa09[108],OxOaa09[109]);} ;} ;function pnlRecent_Click(Ox2b8){var Ox296=Ox2b8[OxOaa09[111]][OxOaa09[106]][OxOaa09[110]];if(Ox296.indexOf(OxOaa09[112])!=-1){var Ox421= new Array();Ox296=Ox296.substr(Ox296.indexOf(OxOaa09[113])+1);Ox296=Ox296.substr(0,Ox296.indexOf(OxOaa09[114]));Ox421[0]= new Number(Ox296.substr(0,Ox296.indexOf(OxOaa09[115])));Ox296=Ox296.substr(Ox296.indexOf(OxOaa09[115])+1);Ox421[1]= new Number(Ox296.substr(0,Ox296.indexOf(OxOaa09[115])));Ox421[2]= new Number(Ox296.substr(Ox296.indexOf(OxOaa09[115])+1));Ox296=RgbToHex(Ox421);} else {Ox296=Ox296.substr(1,6).toUpperCase();} ;frm[OxOaa09[12]][OxOaa09[99]]=Ox296;Hex_Changed(Ox2b8);} ;function pnlOldClick_Click(Ox2b8){frm[OxOaa09[12]][OxOaa09[99]]=document.getElementById(OxOaa09[24])[OxOaa09[106]][OxOaa09[110]].substr(1,6).toUpperCase();Hex_Changed(Ox2b8);} ;function rdoHsb_Hue_Click(Ox2b8){frm[OxOaa09[14]][OxOaa09[100]]=true;ColorMode_Changed(Ox2b8);} ;function rdoHsb_Saturation_Click(Ox2b8){frm[OxOaa09[15]][OxOaa09[100]]=true;ColorMode_Changed(Ox2b8);} ;function rdoHsb_Brightness_Click(Ox2b8){frm[OxOaa09[16]][OxOaa09[100]]=true;ColorMode_Changed(Ox2b8);} ;function Hide(){for(var i=0;i<arguments[OxOaa09[28]];i++){if(arguments[i]){arguments[i][OxOaa09[106]][OxOaa09[116]]=OxOaa09[117];} ;} ;} ;function Show(){for(var i=0;i<arguments[OxOaa09[28]];i++){if(arguments[i]){arguments[i][OxOaa09[106]][OxOaa09[116]]=OxOaa09[97];} ;} ;} ;function SetValue(){for(var i=0;i<arguments[OxOaa09[28]];i+=2){arguments[i][OxOaa09[99]]=arguments[i+1];} ;} ;function SetTitle(){for(var i=0;i<arguments[OxOaa09[28]];i+=2){arguments[i][OxOaa09[118]]=arguments[i+1];} ;} ;function SetHTML(){for(var i=0;i<arguments[OxOaa09[28]];i+=2){arguments[i][OxOaa09[119]]=arguments[i+1];} ;} ;function SetBg(){for(var i=0;i<arguments[OxOaa09[28]];i+=2){if(arguments[i]){arguments[i][OxOaa09[106]][OxOaa09[110]]=OxOaa09[76]+arguments[i+1];} ;} ;} ;function SetBgPosition(){for(var i=0;i<arguments[OxOaa09[28]];i+=3){arguments[i][OxOaa09[106]][OxOaa09[120]]=arguments[i+1]+OxOaa09[121]+arguments[i+2]+OxOaa09[122];} ;} ;function ColorMode_Changed(Ox2b8){for(var i=0;i<3;i++){if(frm[OxOaa09[102]][i][OxOaa09[100]]){ColorMode=i;} ;} ;SetCookie(OxOaa09[101],ColorMode,60*60*24*365);Hide(document.getElementById(OxOaa09[123]),document.getElementById(OxOaa09[124]),document.getElementById(OxOaa09[125]),document.getElementById(OxOaa09[126]),document.getElementById(OxOaa09[127]),document.getElementById(OxOaa09[128]),document.getElementById(OxOaa09[129]),document.getElementById(OxOaa09[130]),document.getElementById(OxOaa09[131]),document.getElementById(OxOaa09[132]),document.getElementById(OxOaa09[133]),document.getElementById(OxOaa09[134]),document.getElementById(OxOaa09[135]),document.getElementById(OxOaa09[136]));switch(ColorMode){case 0:document.getElementById(OxOaa09[138])[OxOaa09[137]]=OxOaa09[139];Show(document.getElementById(OxOaa09[123]),document.getElementById(OxOaa09[124]),document.getElementById(OxOaa09[125]),document.getElementById(OxOaa09[126]));Hsb_Changed(Ox2b8);break ;;case 1:document.getElementById(OxOaa09[138])[OxOaa09[137]]=OxOaa09[140];document.getElementById(OxOaa09[127])[OxOaa09[137]]=OxOaa09[141];Show(document.getElementById(OxOaa09[123]),document.getElementById(OxOaa09[127]));document.getElementById(OxOaa09[123])[OxOaa09[106]][OxOaa09[110]]=OxOaa09[142];Hsb_Changed(Ox2b8);break ;;case 2:document.getElementById(OxOaa09[138])[OxOaa09[137]]=OxOaa09[140];document.getElementById(OxOaa09[127])[OxOaa09[137]]=OxOaa09[143];Show(document.getElementById(OxOaa09[123]),document.getElementById(OxOaa09[127]));document.getElementById(OxOaa09[123])[OxOaa09[106]][OxOaa09[110]]=OxOaa09[144];Hsb_Changed(Ox2b8);break ;;default:break ;;} ;} ;function btnWebSafeColor_Click(Ox2b8){var Ox421=HexToRgb(frm[OxOaa09[12]].value);Ox421=RgbToWebSafeRgb(Ox421);frm[OxOaa09[12]][OxOaa09[99]]=RgbToHex(Ox421);Hex_Changed(Ox2b8);} ;function checkWebSafe(){var Ox421=Form_Get_Rgb();if(RgbIsWebSafe(Ox421)){Hide(frm.btnWebSafeColor,document.getElementById(OxOaa09[22]),document.getElementById(OxOaa09[23]));} else {Ox421=RgbToWebSafeRgb(Ox421);SetBg(document.getElementById(OxOaa09[22]),RgbToHex(Ox421));Show(frm.btnWebSafeColor,document.getElementById(OxOaa09[22]),document.getElementById(OxOaa09[23]));} ;} ;function validateNumber(Ox2b8){var Ox436=String.fromCharCode(Ox2b8.which);if(IgnoreKey(Ox2b8)){return ;} ;if(OxOaa09[145].indexOf(Ox436)!=-1){return ;} ;Ox2b8[OxOaa09[146]]=0;} ;function validateHex(Ox2b8){if(IgnoreKey(Ox2b8)){return ;} ;var Ox436=String.fromCharCode(Ox2b8.which);if(OxOaa09[147].indexOf(Ox436)!=-1){return ;} ;if(OxOaa09[148].indexOf(Ox436)!=-1){return ;} ;} ;function IgnoreKey(Ox2b8){var Ox436=String.fromCharCode(Ox2b8.which);var Ox439= new Array(0,8,9,13,27);if(Ox436==null){return true;} ;for(var i=0;i<5;i++){if(Ox2b8[OxOaa09[146]]==Ox439[i]){return true;} ;} ;return false;} ;function btnCancel_Click(){if(window[OxOaa09[149]]){window[OxOaa09[149]].focus();} ;top.close();} ;function btnOK_Click(){var Ox29b= new String(frm[OxOaa09[12]].value);if(window[OxOaa09[149]]){try{window[OxOaa09[149]].ColorPicker_Picked(Ox29b);} catch(e){} ;window[OxOaa09[149]].focus();} ;recent=GetCookie(OxOaa09[103])||OxOaa09[97];for(var i=0;i<recent[OxOaa09[28]];i+=6){if(recent.substr(i,6)==Ox29b){recent=recent.substr(0,i)+recent.substr(i+6);i-=6;} ;} ;if(recent[OxOaa09[28]]>31*6){recent=recent.substr(0,31*6);} ;recent=frm[OxOaa09[12]][OxOaa09[99]]+recent;SetCookie(OxOaa09[103],recent,60*60*24*365);top.close();} ;function SetGradientPosition(Ox2b8,Ox367,Ox337){Ox367=Ox367-POSITIONADJUSTX+5;Ox337=Ox337-POSITIONADJUSTY+5;Ox367-=7;Ox337-=27;Ox367=Ox367<0?0:Ox367>255?255:Ox367;Ox337=Ox337<0?0:Ox337>255?255:Ox337;SetBgPosition(document.getElementById(OxOaa09[150]),Ox367-5,Ox337-5);switch(ColorMode){case 0:var Ox43d= new Array(0,0,0);Ox43d[1]=Ox367/255;Ox43d[2]=1-(Ox337/255);frm[OxOaa09[7]][OxOaa09[99]]=Math.round(Ox43d[1]*100);frm[OxOaa09[8]][OxOaa09[99]]=Math.round(Ox43d[2]*100);Hsb_Changed(Ox2b8);break ;;case 1:var Ox43d= new Array(0,0,0);Ox43d[0]=Ox367/255;Ox43d[2]=1-(Ox337/255);frm[OxOaa09[5]][OxOaa09[99]]=Ox43d[0]==1?0:Math.round(Ox43d[0]*360);frm[OxOaa09[8]][OxOaa09[99]]=Math.round(Ox43d[2]*100);Hsb_Changed(Ox2b8);break ;;case 2:var Ox43d= new Array(0,0,0);Ox43d[0]=Ox367/255;Ox43d[1]=1-(Ox337/255);frm[OxOaa09[5]][OxOaa09[99]]=Ox43d[0]==1?0:Math.round(Ox43d[0]*360);frm[OxOaa09[7]][OxOaa09[99]]=Math.round(Ox43d[1]*100);Hsb_Changed(Ox2b8);break ;;} ;} ;function Hex_Changed(Ox2b8){var Ox29b=Form_Get_Hex();var Ox421=HexToRgb(Ox29b);var Ox43d=RgbToHsb(Ox421);Form_Set_Rgb(Ox421);Form_Set_Hsb(Ox43d);SetBg(document.getElementById(OxOaa09[151]),Ox29b);SetupCursors(Ox2b8);SetupGradients();checkWebSafe();} ;function Rgb_Changed(Ox2b8){var Ox421=Form_Get_Rgb();var Ox43d=RgbToHsb(Ox421);var Ox29b=RgbToHex(Ox421);Form_Set_Hsb(Ox43d);Form_Set_Hex(Ox29b);SetBg(document.getElementById(OxOaa09[151]),Ox29b);SetupCursors(Ox2b8);SetupGradients();checkWebSafe();} ;function Hsb_Changed(Ox2b8){var Ox43d=Form_Get_Hsb();var Ox421=HsbToRgb(Ox43d);var Ox29b=RgbToHex(Ox421);Form_Set_Rgb(Ox421);Form_Set_Hex(Ox29b);SetBg(document.getElementById(OxOaa09[151]),Ox29b);SetupCursors(Ox2b8);SetupGradients();checkWebSafe();} ;function Form_Set_Hex(Ox29b){frm[OxOaa09[12]][OxOaa09[99]]=Ox29b;} ;function Form_Get_Hex(){var Ox29b= new String(frm[OxOaa09[12]].value);for(var i=0;i<Ox29b[OxOaa09[28]];i++){if(OxOaa09[152].indexOf(Ox29b.substr(i,1))==-1){Ox29b=OxOaa09[153];frm[OxOaa09[12]][OxOaa09[99]]=Ox29b;alert(formatString(msg.BadNumber,OxOaa09[153],OxOaa09[98]));break ;} ;} ;while(Ox29b[OxOaa09[28]]<6){Ox29b=OxOaa09[154]+Ox29b;} ;return Ox29b;} ;function Form_Get_Hsb(){var Ox43d= new Array(0,0,0);Ox43d[0]= new Number(frm[OxOaa09[5]].value)/360;Ox43d[1]= new Number(frm[OxOaa09[7]].value)/100;Ox43d[2]= new Number(frm[OxOaa09[8]].value)/100;if(Ox43d[0]>1||isNaN(Ox43d[0])){Ox43d[0]=1;frm[OxOaa09[5]][OxOaa09[99]]=360;alert(formatString(msg.BadNumber,0,360));} ;if(Ox43d[1]>1||isNaN(Ox43d[1])){Ox43d[1]=1;frm[OxOaa09[7]][OxOaa09[99]]=100;alert(formatString(msg.BadNumber,0,100));} ;if(Ox43d[2]>1||isNaN(Ox43d[2])){Ox43d[2]=1;frm[OxOaa09[8]][OxOaa09[99]]=100;alert(formatString(msg.BadNumber,0,100));} ;return Ox43d;} ;function Form_Set_Hsb(Ox43d){SetValue(frm.txtHSB_Hue,Math.round(Ox43d[0]*360),frm.txtHSB_Saturation,Math.round(Ox43d[1]*100),frm.txtHSB_Brightness,Math.round(Ox43d[2]*100));} ;function Form_Get_Rgb(){var Ox421= new Array(0,0,0);Ox421[0]= new Number(frm[OxOaa09[9]].value);Ox421[1]= new Number(frm[OxOaa09[10]].value);Ox421[2]= new Number(frm[OxOaa09[11]].value);if(Ox421[0]>255||isNaN(Ox421[0])||Ox421[0]!=Math.round(Ox421[0])){Ox421[0]=255;frm[OxOaa09[9]][OxOaa09[99]]=255;alert(formatString(msg.BadNumber,0,255));} ;if(Ox421[1]>255||isNaN(Ox421[1])||Ox421[1]!=Math.round(Ox421[1])){Ox421[1]=255;frm[OxOaa09[10]][OxOaa09[99]]=255;alert(formatString(msg.BadNumber,0,255));} ;if(Ox421[2]>255||isNaN(Ox421[2])||Ox421[2]!=Math.round(Ox421[2])){Ox421[2]=255;frm[OxOaa09[11]][OxOaa09[99]]=255;alert(formatString(msg.BadNumber,0,255));} ;return Ox421;} ;function Form_Set_Rgb(Ox421){frm[OxOaa09[9]][OxOaa09[99]]=Ox421[0];frm[OxOaa09[10]][OxOaa09[99]]=Ox421[1];frm[OxOaa09[11]][OxOaa09[99]]=Ox421[2];} ;function SetupCursors(Ox2b8){var Ox43d=Form_Get_Hsb();var Ox421=Form_Get_Rgb();if(RgbToYuv(Ox421)[0]>=0.5){SetGradientPositionDark();} else {SetGradientPositionLight();} ;if(Ox2b8[OxOaa09[111]]!=null){if(Ox2b8[OxOaa09[111]][OxOaa09[155]]==OxOaa09[17]){return ;} ;if(Ox2b8[OxOaa09[111]][OxOaa09[155]]==OxOaa09[21]){return ;} ;} ;var Ox367;var Ox337;var Ox448;if(ColorMode>=0&&ColorMode<=2){for(var i=0;i<3;i++){Ox43d[i]*=255;} ;} ;switch(ColorMode){case 0:Ox367=Ox43d[1];Ox337=Ox43d[2];Ox448=Ox43d[0]==0?1:Ox43d[0];break ;;case 1:Ox367=Ox43d[0]==0?1:Ox43d[0];Ox337=Ox43d[2];Ox448=Ox43d[1];break ;;case 2:Ox367=Ox43d[0]==0?1:Ox43d[0];Ox337=Ox43d[1];Ox448=Ox43d[2];break ;;} ;Ox337=255-Ox337;Ox448=255-Ox448;SetBgPosition(document.getElementById(OxOaa09[150]),Ox367-5,Ox337-5);document.getElementById(OxOaa09[157])[OxOaa09[106]][OxOaa09[156]]=(Ox448+27)+OxOaa09[122];} ;function SetupGradients(){var Ox43d=Form_Get_Hsb();var Ox421=Form_Get_Rgb();switch(ColorMode){case 0:SetBg(document.getElementById(OxOaa09[123]),RgbToHex(HueToRgb(Ox43d[0])));break ;;case 1:SetBg(document.getElementById(OxOaa09[127]),RgbToHex(HsbToRgb( new Array(Ox43d[0],1,Ox43d[2]))));break ;;case 2:SetBg(document.getElementById(OxOaa09[127]),RgbToHex(HsbToRgb( new Array(Ox43d[0],Ox43d[1],1))));break ;;default:;} ;} ;function SetGradientPositionDark(){if(GradientPositionDark){return ;} ;GradientPositionDark=true;document.getElementById(OxOaa09[150])[OxOaa09[106]][OxOaa09[158]]=OxOaa09[159];} ;function SetGradientPositionLight(){if(!GradientPositionDark){return ;} ;GradientPositionDark=false;document.getElementById(OxOaa09[150])[OxOaa09[106]][OxOaa09[158]]=OxOaa09[160];} ;function pnlGradient_Top_Click(Ox2b8){Ox2b8[OxOaa09[161]]=true;SetGradientPosition(Ox2b8,Ox2b8[OxOaa09[162]]-5,Ox2b8[OxOaa09[163]]-5);document.getElementById(OxOaa09[17])[OxOaa09[164]]=OxOaa09[165];_down=false;} ;var _down=false;function pnlGradient_Top_MouseMove(Ox2b8){Ox2b8[OxOaa09[161]]=true;if(!_down){return ;} ;SetGradientPosition(Ox2b8,Ox2b8[OxOaa09[162]]-5,Ox2b8[OxOaa09[163]]-5);} ;function pnlGradient_Top_MouseDown(Ox2b8){Ox2b8[OxOaa09[161]]=true;_down=true;SetGradientPosition(Ox2b8,Ox2b8[OxOaa09[162]]-5,Ox2b8[OxOaa09[163]]-5);document.getElementById(OxOaa09[17])[OxOaa09[164]]=OxOaa09[166];} ;function pnlGradient_Top_MouseUp(Ox2b8){_down=false;Ox2b8[OxOaa09[161]]=true;SetGradientPosition(Ox2b8,Ox2b8[OxOaa09[162]]-5,Ox2b8[OxOaa09[163]]-5);document.getElementById(OxOaa09[17])[OxOaa09[164]]=OxOaa09[165];} ;function Document_MouseUp(){e[OxOaa09[161]]=true;document.getElementById(OxOaa09[17])[OxOaa09[164]]=OxOaa09[165];} ;function SetVerticalPosition(Ox2b8,Ox448){var Ox448=Ox448-POSITIONADJUSTZ;if(Ox448<27){Ox448=27;} ;if(Ox448>282){Ox448=282;} ;document.getElementById(OxOaa09[157])[OxOaa09[106]][OxOaa09[156]]=Ox448+OxOaa09[122];Ox448=1-((Ox448-27)/255);switch(ColorMode){case 0:if(Ox448==1){Ox448=0;} ;frm[OxOaa09[5]][OxOaa09[99]]=Math.round(Ox448*360);Hsb_Changed(Ox2b8);break ;;case 1:frm[OxOaa09[7]][OxOaa09[99]]=Math.round(Ox448*100);Hsb_Changed(Ox2b8);break ;;case 2:frm[OxOaa09[8]][OxOaa09[99]]=Math.round(Ox448*100);Hsb_Changed(Ox2b8);break ;;} ;} ;function pnlVertical_Top_Click(Ox2b8){SetVerticalPosition(Ox2b8,Ox2b8[OxOaa09[163]]-5);Ox2b8[OxOaa09[161]]=true;} ;function pnlVertical_Top_MouseMove(Ox2b8){if(!window[OxOaa09[167]]){return ;} ;if(Ox2b8[OxOaa09[146]]!=1){return ;} ;SetVerticalPosition(Ox2b8,Ox2b8[OxOaa09[163]]-5);Ox2b8[OxOaa09[161]]=true;} ;function pnlVertical_Top_MouseDown(Ox2b8){window[OxOaa09[167]]=true;SetVerticalPosition(Ox2b8,Ox2b8[OxOaa09[163]]-5);Ox2b8[OxOaa09[161]]=true;} ;function pnlVertical_Top_MouseUp(Ox2b8){window[OxOaa09[167]]=false;SetVerticalPosition(Ox2b8,Ox2b8[OxOaa09[163]]-5);Ox2b8[OxOaa09[161]]=true;} ;function SetCookie(name,Ox289,Ox28a){var Ox28b=name+OxOaa09[168]+escape(Ox289)+OxOaa09[169];if(Ox28a){var Ox272= new Date();Ox272.setSeconds(Ox272.getSeconds()+Ox28a);Ox28b+=OxOaa09[170]+Ox272.toUTCString()+OxOaa09[171];} ;document[OxOaa09[172]]=Ox28b;} ;function GetCookie(name){var Ox28d=document[OxOaa09[172]].split(OxOaa09[171]);for(var i=0;i<Ox28d[OxOaa09[28]];i++){var Ox28e=Ox28d[i].split(OxOaa09[168]);if(name==Ox28e[0].replace(/\s/g,OxOaa09[97])){return unescape(Ox28e[1]);} ;} ;} ;function GetCookieDictionary(){var Ox290={};var Ox28d=document[OxOaa09[172]].split(OxOaa09[171]);for(var i=0;i<Ox28d[OxOaa09[28]];i++){var Ox28e=Ox28d[i].split(OxOaa09[168]);Ox290[Ox28e[0].replace(/\s/g,OxOaa09[97])]=unescape(Ox28e[1]);} ;return Ox290;} ;function GetQuery(name){var i=0;while(window[OxOaa09[174]][OxOaa09[173]].indexOf(name+OxOaa09[168],i)!=-1){var Ox289=window[OxOaa09[174]][OxOaa09[173]].substr(window[OxOaa09[174]][OxOaa09[173]].indexOf(name+OxOaa09[168],i));Ox289=Ox289.substr(name[OxOaa09[28]]+1);if(Ox289.indexOf(OxOaa09[175])!=-1){if(Ox289.indexOf(OxOaa09[175])==0){Ox289=OxOaa09[97];} else {Ox289=Ox289.substr(0,Ox289.indexOf(OxOaa09[175]));} ;} ;return unescape(Ox289);} ;return OxOaa09[97];} ;function RgbIsWebSafe(Ox421){var Ox29b=RgbToHex(Ox421);for(var i=0;i<3;i++){if(OxOaa09[176].indexOf(Ox29b.substr(i*2,2))==-1){return false;} ;} ;return true;} ;function RgbToWebSafeRgb(Ox421){var Ox458= new Array(Ox421[0],Ox421[1],Ox421[2]);if(RgbIsWebSafe(Ox421)){return Ox458;} ;var Ox459= new Array(0x00,0x33,0x66,0x99,0xCC,0xFF);for(var i=0;i<3;i++){for(var Ox22c=1;Ox22c<6;Ox22c++){if(Ox458[i]>Ox459[Ox22c-1]&&Ox458[i]<Ox459[Ox22c]){if(Ox458[i]-Ox459[Ox22c-1]>Ox459[Ox22c]-Ox458[i]){Ox458[i]=Ox459[Ox22c];} else {Ox458[i]=Ox459[Ox22c-1];} ;break ;} ;} ;} ;return Ox458;} ;function RgbToYuv(Ox421){var Ox45b= new Array();Ox45b[0]=(Ox421[0]*0.299+Ox421[1]*0.587+Ox421[2]*0.114)/255;Ox45b[1]=(Ox421[0]*-0.169+Ox421[1]*-0.332+Ox421[2]*0.500+128)/255;Ox45b[2]=(Ox421[0]*0.500+Ox421[1]*-0.419+Ox421[2]*-0.0813+128)/255;return Ox45b;} ;function RgbToHsb(Ox421){var Ox45d= new Array(Ox421[0],Ox421[1],Ox421[2]);var Ox45e= new Number(1);var Ox45f= new Number(0);var Ox460= new Number(1);var Ox43d= new Array(0,0,0);var Ox461= new Array();for(var i=0;i<3;i++){Ox45d[i]=Ox421[i]/255;if(Ox45d[i]<Ox45e){Ox45e=Ox45d[i];} ;if(Ox45d[i]>Ox45f){Ox45f=Ox45d[i];} ;} ;Ox460=Ox45f-Ox45e;Ox43d[2]=Ox45f;if(Ox460==0){return Ox43d;} ;Ox43d[1]=Ox460/Ox45f;for(var i=0;i<3;i++){Ox461[i]=(((Ox45f-Ox45d[i])/6)+(Ox460/2))/Ox460;} ;if(Ox45d[0]==Ox45f){Ox43d[0]=Ox461[2]-Ox461[1];} else {if(Ox45d[1]==Ox45f){Ox43d[0]=(1/3)+Ox461[0]-Ox461[2];} else {if(Ox45d[2]==Ox45f){Ox43d[0]=(2/3)+Ox461[1]-Ox461[0];} ;} ;} ;if(Ox43d[0]<0){Ox43d[0]+=1;} else {if(Ox43d[0]>1){Ox43d[0]-=1;} ;} ;return Ox43d;} ;function HsbToRgb(Ox43d){var Ox421=HueToRgb(Ox43d[0]);var Ox234=Ox43d[2]*255;for(var i=0;i<3;i++){Ox421[i]=Ox421[i]*Ox43d[2];Ox421[i]=((Ox421[i]-Ox234)*Ox43d[1])+Ox234;Ox421[i]=Math.round(Ox421[i]);} ;return Ox421;} ;function RgbToHex(Ox421){var Ox29b= new String();for(var i=0;i<3;i++){Ox421[2-i]=Math.round(Ox421[2-i]);Ox29b=Ox421[2-i].toString(16)+Ox29b;if(Ox29b[OxOaa09[28]]%2==1){Ox29b=OxOaa09[154]+Ox29b;} ;} ;return Ox29b.toUpperCase();} ;function HexToRgb(Ox29b){var Ox421= new Array();for(var i=0;i<3;i++){Ox421[i]= new Number(OxOaa09[177]+Ox29b.substr(i*2,2));} ;return Ox421;} ;function HueToRgb(Ox466){var Ox467=Ox466*360;var Ox421= new Array(0,0,0);var Ox468=(Ox467%60)/60;if(Ox467<60){Ox421[0]=255;Ox421[1]=Ox468*255;} else {if(Ox467<120){Ox421[1]=255;Ox421[0]=(1-Ox468)*255;} else {if(Ox467<180){Ox421[1]=255;Ox421[2]=Ox468*255;} else {if(Ox467<240){Ox421[2]=255;Ox421[1]=(1-Ox468)*255;} else {if(Ox467<300){Ox421[2]=255;Ox421[0]=Ox468*255;} else {if(Ox467<360){Ox421[0]=255;Ox421[2]=(1-Ox468)*255;} ;} ;} ;} ;} ;} ;return Ox421;} ;function CheckHexSelect(){if(window[OxOaa09[178]]&&window[OxOaa09[179]]&&frm[OxOaa09[12]]){var Ox296=OxOaa09[76]+frm[OxOaa09[12]][OxOaa09[99]];if(Ox296[OxOaa09[28]]==7){if(window[OxOaa09[180]]!=Ox296){window[OxOaa09[180]]=Ox296;window.do_select(Ox296);} ;} ;} ;} ;setInterval(CheckHexSelect,10);