var OxO55dc=[""," ","=\x22","\x22","src","^[a-z]*:[/][/][^/]*","Edit","\x3CIMG border=\x220\x22 align=\x22absmiddle\x22 src=\x22","\x22 src_cetemp=\x22","\x22\x3E","ImageTable","IMG","length","className","dialogButton","onmouseover","CuteEditor_ColorPicker_ButtonOver(this)","onclick","insert(this)"];var editor=Window_GetDialogArguments(window);function attr(name,Ox289){if(!Ox289||Ox289==OxO55dc[0]){return OxO55dc[0];} ;return OxO55dc[1]+name+OxO55dc[2]+Ox289+OxO55dc[3];} ;function insert(img){if(img){var src=img[OxO55dc[4]];src=src.replace( new RegExp(OxO55dc[5],OxO55dc[0]),OxO55dc[0]);var Ox4a4=OxO55dc[0];if(editor.GetActiveTab()==OxO55dc[6]){Ox4a4=OxO55dc[7]+src+OxO55dc[8]+src+OxO55dc[9];} else {Ox4a4=OxO55dc[7]+src+OxO55dc[9];} ;editor.PasteHTML(Ox4a4);Window_CloseDialog(window);} ;} ;function do_Close(){Window_CloseDialog(window);} ;var ImageTable=Window_GetElement(window,OxO55dc[10],true);var images=ImageTable.getElementsByTagName(OxO55dc[11]);var len=images[OxO55dc[12]];for(var i=0;i<len;i++){var img=images[i];img[OxO55dc[13]]=OxO55dc[14];img[OxO55dc[15]]= new Function(OxO55dc[16]);img[OxO55dc[17]]= new Function(OxO55dc[18]);} ;