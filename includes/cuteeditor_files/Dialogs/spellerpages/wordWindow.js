var OxO3a49=["_forms","_getWordObject","_wordInputStr","_adjustIndexes","_isWordChar","_lastPos","wordChar","windowType","wordWindow","originalSpellings","suggestions","checkWordBgColor","pink","normWordBgColor","white","text","","textInputs","indexes","resetForm","totalMisspellings","totalWords","totalPreviousWords","getTextVal","setFocus","removeFocus","setText","writeBody","printForHtml","length","value","type","backgroundColor","style","size","document","\x3Cform name=\x22textInput","\x22\x3E","\x3Cdiv class=\x22plainText\x22\x3E","\x3C/div\x3E","\x3C/form\x3E","forms","elements","\x3Cinput readonly ","class=\x22blend\x22 type=\x22text\x22 value=\x22","\x22 size=\x22"];function wordWindow(){this[OxO3a49[0]]=[];this[OxO3a49[1]]=_getWordObject;this[OxO3a49[2]]=_wordInputStr;this[OxO3a49[3]]=_adjustIndexes;this[OxO3a49[4]]=_isWordChar;this[OxO3a49[5]]=_lastPos;this[OxO3a49[6]]=/[a-zA-Z]/;this[OxO3a49[7]]=OxO3a49[8];this[OxO3a49[9]]= new Array();this[OxO3a49[10]]= new Array();this[OxO3a49[11]]=OxO3a49[12];this[OxO3a49[13]]=OxO3a49[14];this[OxO3a49[15]]=OxO3a49[16];this[OxO3a49[17]]= new Array();this[OxO3a49[18]]= new Array();this[OxO3a49[19]]=resetForm;this[OxO3a49[20]]=totalMisspellings;this[OxO3a49[21]]=totalWords;this[OxO3a49[22]]=totalPreviousWords;this[OxO3a49[23]]=getTextVal;this[OxO3a49[24]]=setFocus;this[OxO3a49[25]]=removeFocus;this[OxO3a49[26]]=setText;this[OxO3a49[27]]=writeBody;this[OxO3a49[28]]=printForHtml;} ;function resetForm(){if(this[OxO3a49[0]]){for(var i=0;i<this[OxO3a49[0]][OxO3a49[29]];i++){this[OxO3a49[0]][i].reset();} ;} ;return true;} ;function totalMisspellings(){var Ox262=0;for(var i=0;i<this[OxO3a49[17]][OxO3a49[29]];i++){Ox262+=this.totalWords(i);} ;return Ox262;} ;function totalWords(Ox264){return this[OxO3a49[9]][Ox264][OxO3a49[29]];} ;function totalPreviousWords(Ox264,Ox266){var Ox262=0;for(var i=0;i<=Ox264;i++){for(var Ox22c=0;Ox22c<this.totalWords(i);Ox22c++){if(i==Ox264&&Ox22c==Ox266){break ;} else {Ox262++;} ;} ;} ;return Ox262;} ;function getTextVal(Ox264,Ox266){var Ox268=this._getWordObject(Ox264,Ox266);if(Ox268){return Ox268[OxO3a49[30]];} ;} ;function setFocus(Ox264,Ox266){var Ox268=this._getWordObject(Ox264,Ox266);if(Ox268){if(Ox268[OxO3a49[31]]==OxO3a49[15]){Ox268.focus();Ox268[OxO3a49[33]][OxO3a49[32]]=this[OxO3a49[11]];} ;} ;} ;function removeFocus(Ox264,Ox266){var Ox268=this._getWordObject(Ox264,Ox266);if(Ox268){if(Ox268[OxO3a49[31]]==OxO3a49[15]){Ox268.blur();Ox268[OxO3a49[33]][OxO3a49[32]]=this[OxO3a49[13]];} ;} ;} ;function setText(Ox264,Ox266,Ox25c){var Ox268=this._getWordObject(Ox264,Ox266);var Ox26c;var Ox26d;if(Ox268){var Ox26e=this[OxO3a49[18]][Ox264][Ox266];var Ox26f=Ox268[OxO3a49[30]];Ox26c=this[OxO3a49[17]][Ox264].substring(0,Ox26e);Ox26d=this[OxO3a49[17]][Ox264].substring(Ox26e+Ox26f[OxO3a49[29]],this[OxO3a49[17]][Ox264].length);this[OxO3a49[17]][Ox264]=Ox26c+Ox25c+Ox26d;var Ox270=Ox25c[OxO3a49[29]]-Ox26f[OxO3a49[29]];this._adjustIndexes(Ox264,Ox266,Ox270);Ox268[OxO3a49[34]]=Ox25c[OxO3a49[29]];Ox268[OxO3a49[30]]=Ox25c;this.removeFocus(Ox264,Ox266);} ;} ;function writeBody(){var Ox272=window[OxO3a49[35]];var Ox273=false;Ox272.open();for(var Ox274=0;Ox274<this[OxO3a49[17]][OxO3a49[29]];Ox274++){var Ox275=0;var Ox276=0;Ox272.writeln(OxO3a49[36]+Ox274+OxO3a49[37]);var Ox277=this[OxO3a49[17]][Ox274];this[OxO3a49[18]][Ox274]=[];if(Ox277){var Ox278=this[OxO3a49[9]][Ox274];if(!Ox278){break ;} ;Ox272.writeln(OxO3a49[38]);for(var i=0;i<Ox278[OxO3a49[29]];i++){do{Ox276=Ox277.indexOf(Ox278[i],Ox275);Ox275=Ox276+Ox278[i][OxO3a49[29]];if(Ox276==-1){break ;} ;var Ox279=Ox277.charAt(Ox276-1);var Ox27a=Ox277.charAt(Ox275);} while(this._isWordChar(Ox279)||this._isWordChar(Ox27a));;this[OxO3a49[18]][Ox274][i]=Ox276;for(var Ox22c=this._lastPos(Ox274,i);Ox22c<Ox276;Ox22c++){Ox272.write(this.printForHtml(Ox277.charAt(Ox22c)));} ;Ox272.write(this._wordInputStr(Ox278[i]));if(i==Ox278[OxO3a49[29]]-1){Ox272.write(printForHtml(Ox277.substr(Ox275)));} ;} ;Ox272.writeln(OxO3a49[39]);} ;Ox272.writeln(OxO3a49[40]);} ;this[OxO3a49[0]]=Ox272[OxO3a49[41]];Ox272.close();} ;function _lastPos(Ox274,Ox24c){if(Ox24c>0){return this[OxO3a49[18]][Ox274][Ox24c-1]+this[OxO3a49[9]][Ox274][Ox24c-1][OxO3a49[29]];} else {return 0;} ;} ;function printForHtml(Ox27d){return Ox27d;} ;function _isWordChar(Ox27f){if(Ox27f.search(this.wordChar)==-1){return false;} else {return true;} ;} ;function _getWordObject(Ox264,Ox266){if(this[OxO3a49[0]][Ox264]){if(this[OxO3a49[0]][Ox264][OxO3a49[42]][Ox266]){return this[OxO3a49[0]][Ox264][OxO3a49[42]][Ox266];} ;} ;return null;} ;function _wordInputStr(Ox268){var Oxb=OxO3a49[43];Oxb+=OxO3a49[44]+Ox268+OxO3a49[45]+Ox268[OxO3a49[29]]+OxO3a49[37];return Oxb;} ;function _adjustIndexes(Ox264,Ox266,Ox270){for(var i=Ox266+1;i<this[OxO3a49[9]][Ox264][OxO3a49[29]];i++){this[OxO3a49[18]][Ox264][i]=this[OxO3a49[18]][Ox264][i]+Ox270;} ;} ;