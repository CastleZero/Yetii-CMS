var OxOc455=["inp_type","inp_name","inp_value","row_txt1","inp_Size","row_txt2","inp_MaxLength","row_img","inp_src","btnbrowse","row_img2","sel_Align","optNotSet","optLeft","optRight","optTexttop","optAbsMiddle","optBaseline","optAbsBottom","optBottom","optMiddle","optTop","inp_Border","row_img3","inp_width","inp_height","row_img4","inp_HSpace","inp_VSpace","row_img5","AlternateText","inp_id","row_txt3","inp_access","row_txt4","inp_index","row_chk","inp_checked","row_txt5","inp_Disabled","row_txt6","inp_Readonly","onclick","value","Name","name","id","src","type","checked","disabled","readOnly","tabIndex","","accessKey","size","maxLength","width","height","vspace","hspace","border","align","alt","text","display","style","none","password","hidden","radio","checkbox","submit","reset","button","image","className","class"];var inp_type=Window_GetElement(window,OxOc455[0],true);var inp_name=Window_GetElement(window,OxOc455[1],true);var inp_value=Window_GetElement(window,OxOc455[2],true);var row_txt1=Window_GetElement(window,OxOc455[3],true);var inp_Size=Window_GetElement(window,OxOc455[4],true);var row_txt2=Window_GetElement(window,OxOc455[5],true);var inp_MaxLength=Window_GetElement(window,OxOc455[6],true);var row_img=Window_GetElement(window,OxOc455[7],true);var inp_src=Window_GetElement(window,OxOc455[8],true);var btnbrowse=Window_GetElement(window,OxOc455[9],true);var row_img2=Window_GetElement(window,OxOc455[10],true);var sel_Align=Window_GetElement(window,OxOc455[11],true);var optNotSet=Window_GetElement(window,OxOc455[12],true);var optLeft=Window_GetElement(window,OxOc455[13],true);var optRight=Window_GetElement(window,OxOc455[14],true);var optTexttop=Window_GetElement(window,OxOc455[15],true);var optAbsMiddle=Window_GetElement(window,OxOc455[16],true);var optBaseline=Window_GetElement(window,OxOc455[17],true);var optAbsBottom=Window_GetElement(window,OxOc455[18],true);var optBottom=Window_GetElement(window,OxOc455[19],true);var optMiddle=Window_GetElement(window,OxOc455[20],true);var optTop=Window_GetElement(window,OxOc455[21],true);var inp_Border=Window_GetElement(window,OxOc455[22],true);var row_img3=Window_GetElement(window,OxOc455[23],true);var inp_width=Window_GetElement(window,OxOc455[24],true);var inp_height=Window_GetElement(window,OxOc455[25],true);var row_img4=Window_GetElement(window,OxOc455[26],true);var inp_HSpace=Window_GetElement(window,OxOc455[27],true);var inp_VSpace=Window_GetElement(window,OxOc455[28],true);var row_img5=Window_GetElement(window,OxOc455[29],true);var AlternateText=Window_GetElement(window,OxOc455[30],true);var inp_id=Window_GetElement(window,OxOc455[31],true);var row_txt3=Window_GetElement(window,OxOc455[32],true);var inp_access=Window_GetElement(window,OxOc455[33],true);var row_txt4=Window_GetElement(window,OxOc455[34],true);var inp_index=Window_GetElement(window,OxOc455[35],true);var row_chk=Window_GetElement(window,OxOc455[36],true);var inp_checked=Window_GetElement(window,OxOc455[37],true);var row_txt5=Window_GetElement(window,OxOc455[38],true);var inp_Disabled=Window_GetElement(window,OxOc455[39],true);var row_txt6=Window_GetElement(window,OxOc455[40],true);var inp_Readonly=Window_GetElement(window,OxOc455[41],true);btnbrowse[OxOc455[42]]=function btnbrowse_onclick(){function Ox4c7(Ox2a6){if(Ox2a6){inp_src[OxOc455[43]]=Ox2a6;SyncTo(element);} ;} ;editor.SetNextDialogWindow(window);if(Browser_IsSafari()){editor.ShowSelectImageDialog(Ox4c7,inp_src.value,inp_src);} else {editor.ShowSelectImageDialog(Ox4c7,inp_src.value);} ;} ;UpdateState=function UpdateState_Input(){} ;SyncToView=function SyncToView_Input(){if(element[OxOc455[44]]){inp_name[OxOc455[43]]=element[OxOc455[44]];} ;if(element[OxOc455[45]]){inp_name[OxOc455[43]]=element[OxOc455[45]];} ;inp_id[OxOc455[43]]=element[OxOc455[46]];inp_value[OxOc455[43]]=(element[OxOc455[43]]).trim();inp_src[OxOc455[43]]=element[OxOc455[47]];inp_type[OxOc455[43]]=element[OxOc455[48]];inp_checked[OxOc455[49]]=element[OxOc455[49]];inp_Disabled[OxOc455[49]]=element[OxOc455[50]];inp_Readonly[OxOc455[49]]=element[OxOc455[51]];if(element[OxOc455[52]]==0){inp_index[OxOc455[43]]=OxOc455[53];} else {inp_index[OxOc455[43]]=element[OxOc455[52]];} ;if(element[OxOc455[54]]){inp_access[OxOc455[43]]=element[OxOc455[54]];} ;if(element[OxOc455[55]]){if(element[OxOc455[55]]==20){inp_Size[OxOc455[43]]=OxOc455[53];} else {inp_Size[OxOc455[43]]=element[OxOc455[55]];} ;} ;if(element[OxOc455[56]]){if(element[OxOc455[56]]==2147483647||element[OxOc455[56]]<=0){inp_MaxLength[OxOc455[43]]=OxOc455[53];} else {inp_MaxLength[OxOc455[43]]=element[OxOc455[56]];} ;} ;if(element[OxOc455[57]]){inp_width[OxOc455[43]]=element[OxOc455[57]];} ;if(element[OxOc455[58]]){inp_height[OxOc455[43]]=element[OxOc455[58]];} ;if(element[OxOc455[59]]){inp_HSpace[OxOc455[43]]=element[OxOc455[59]];} ;if(element[OxOc455[60]]){inp_VSpace[OxOc455[43]]=element[OxOc455[60]];} ;if(element[OxOc455[61]]){inp_Border[OxOc455[43]]=element[OxOc455[61]];} ;if(element[OxOc455[62]]){sel_Align[OxOc455[43]]=element[OxOc455[62]];} ;if(element[OxOc455[63]]){alt[OxOc455[43]]=element[OxOc455[63]];} ;switch((element[OxOc455[48]]).toLowerCase()){case OxOc455[64]:;case OxOc455[68]:row_img[OxOc455[66]][OxOc455[65]]=OxOc455[67];row_img2[OxOc455[66]][OxOc455[65]]=OxOc455[67];row_img3[OxOc455[66]][OxOc455[65]]=OxOc455[67];row_img4[OxOc455[66]][OxOc455[65]]=OxOc455[67];row_img5[OxOc455[66]][OxOc455[65]]=OxOc455[67];row_chk[OxOc455[66]][OxOc455[65]]=OxOc455[67];break ;;case OxOc455[69]:row_img[OxOc455[66]][OxOc455[65]]=OxOc455[67];row_img2[OxOc455[66]][OxOc455[65]]=OxOc455[67];row_img3[OxOc455[66]][OxOc455[65]]=OxOc455[67];row_img4[OxOc455[66]][OxOc455[65]]=OxOc455[67];row_img5[OxOc455[66]][OxOc455[65]]=OxOc455[67];row_chk[OxOc455[66]][OxOc455[65]]=OxOc455[67];row_txt1[OxOc455[66]][OxOc455[65]]=OxOc455[67];row_txt2[OxOc455[66]][OxOc455[65]]=OxOc455[67];row_txt3[OxOc455[66]][OxOc455[65]]=OxOc455[67];row_txt4[OxOc455[66]][OxOc455[65]]=OxOc455[67];row_txt5[OxOc455[66]][OxOc455[65]]=OxOc455[67];row_txt6[OxOc455[66]][OxOc455[65]]=OxOc455[67];break ;;case OxOc455[70]:;case OxOc455[71]:row_img[OxOc455[66]][OxOc455[65]]=OxOc455[67];row_img2[OxOc455[66]][OxOc455[65]]=OxOc455[67];row_img3[OxOc455[66]][OxOc455[65]]=OxOc455[67];row_img4[OxOc455[66]][OxOc455[65]]=OxOc455[67];row_img5[OxOc455[66]][OxOc455[65]]=OxOc455[67];row_txt1[OxOc455[66]][OxOc455[65]]=OxOc455[67];row_txt2[OxOc455[66]][OxOc455[65]]=OxOc455[67];row_txt6[OxOc455[66]][OxOc455[65]]=OxOc455[67];break ;;case OxOc455[72]:;case OxOc455[73]:;case OxOc455[74]:row_chk[OxOc455[66]][OxOc455[65]]=OxOc455[67];row_img[OxOc455[66]][OxOc455[65]]=OxOc455[67];row_img2[OxOc455[66]][OxOc455[65]]=OxOc455[67];row_img3[OxOc455[66]][OxOc455[65]]=OxOc455[67];row_img4[OxOc455[66]][OxOc455[65]]=OxOc455[67];row_img5[OxOc455[66]][OxOc455[65]]=OxOc455[67];row_txt1[OxOc455[66]][OxOc455[65]]=OxOc455[67];row_txt2[OxOc455[66]][OxOc455[65]]=OxOc455[67];row_txt6[OxOc455[66]][OxOc455[65]]=OxOc455[67];break ;;case OxOc455[75]:row_chk[OxOc455[66]][OxOc455[65]]=OxOc455[67];row_txt1[OxOc455[66]][OxOc455[65]]=OxOc455[67];row_txt2[OxOc455[66]][OxOc455[65]]=OxOc455[67];row_txt6[OxOc455[66]][OxOc455[65]]=OxOc455[67];break ;;} ;} ;SyncTo=function SyncTo_Input(element){element[OxOc455[45]]=inp_name[OxOc455[43]];if(element[OxOc455[44]]){element[OxOc455[44]]=inp_name[OxOc455[43]];} else {if(element[OxOc455[45]]){element.removeAttribute(OxOc455[45],0);element[OxOc455[44]]=inp_name[OxOc455[43]];} else {element[OxOc455[44]]=inp_name[OxOc455[43]];} ;} ;element[OxOc455[46]]=inp_id[OxOc455[43]];if(inp_src[OxOc455[43]]){element[OxOc455[47]]=inp_src[OxOc455[43]];} ;element[OxOc455[49]]=inp_checked[OxOc455[49]];element[OxOc455[43]]=inp_value[OxOc455[43]];element[OxOc455[50]]=inp_Disabled[OxOc455[49]];element[OxOc455[51]]=inp_Readonly[OxOc455[49]];element[OxOc455[54]]=inp_access[OxOc455[43]];element[OxOc455[52]]=inp_index[OxOc455[43]];element[OxOc455[56]]=inp_MaxLength[OxOc455[43]];element[OxOc455[57]]=inp_width[OxOc455[43]];element[OxOc455[58]]=inp_height[OxOc455[43]];element[OxOc455[59]]=inp_HSpace[OxOc455[43]];element[OxOc455[60]]=inp_VSpace[OxOc455[43]];element[OxOc455[61]]=inp_Border[OxOc455[43]];element[OxOc455[62]]=sel_Align[OxOc455[43]];element[OxOc455[63]]=AlternateText[OxOc455[43]];try{element[OxOc455[55]]=inp_Size[OxOc455[43]];} catch(e){element[OxOc455[55]]=20;} ;if(element[OxOc455[52]]==OxOc455[53]){element.removeAttribute(OxOc455[52]);} ;if(element[OxOc455[54]]==OxOc455[53]){element.removeAttribute(OxOc455[54]);} ;if(element[OxOc455[56]]==OxOc455[53]){element.removeAttribute(OxOc455[56]);} ;if(element[OxOc455[55]]==0){element.removeAttribute(OxOc455[55]);} ;if(element[OxOc455[57]]==0){element.removeAttribute(OxOc455[57]);} ;if(element[OxOc455[58]]==0){element.removeAttribute(OxOc455[58]);} ;if(element[OxOc455[60]]==OxOc455[53]){element.removeAttribute(OxOc455[60]);} ;if(element[OxOc455[59]]==OxOc455[53]){element.removeAttribute(OxOc455[59]);} ;if(element[OxOc455[46]]==OxOc455[53]){element.removeAttribute(OxOc455[46]);} ;if(element[OxOc455[44]]==OxOc455[53]){element.removeAttribute(OxOc455[44]);} ;if(element[OxOc455[63]]==OxOc455[53]){element.removeAttribute(OxOc455[63]);} ;if(element[OxOc455[62]]==OxOc455[53]){element.removeAttribute(OxOc455[62]);} ;if(element[OxOc455[76]]==OxOc455[53]){element.removeAttribute(OxOc455[77]);} ;if(element[OxOc455[76]]==OxOc455[53]){element.removeAttribute(OxOc455[76]);} ;switch((element[OxOc455[48]]).toLowerCase()){case OxOc455[64]:;case OxOc455[68]:;case OxOc455[69]:;case OxOc455[70]:;case OxOc455[71]:;case OxOc455[72]:;case OxOc455[73]:;case OxOc455[74]:element.removeAttribute(OxOc455[58]);element.removeAttribute(OxOc455[61]);element.removeAttribute(OxOc455[47]);break ;;case OxOc455[75]:break ;;} ;} ;