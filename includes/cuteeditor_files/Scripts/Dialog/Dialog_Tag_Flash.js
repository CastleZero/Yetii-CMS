var OxO10ce=["flash_preview","btnbrowse","inp_src","onclick","value","cssText","style","Movie"];var flash_preview=Window_GetElement(window,OxO10ce[0],true);var btnbrowse=Window_GetElement(window,OxO10ce[1],true);var inp_src=Window_GetElement(window,OxO10ce[2],true);btnbrowse[OxO10ce[3]]=function btnbrowse_onclick(){function Ox4c7(Ox2a6){if(Ox2a6){inp_src[OxO10ce[4]]=Ox2a6;} ;} ;editor.SetNextDialogWindow(window);editor.ShowSelectFileDialog(Ox4c7,inp_src.value);} ;UpdateState=function UpdateState_Flash(){flash_preview[OxO10ce[6]][OxO10ce[5]]=element[OxO10ce[6]][OxO10ce[5]];flash_preview.mergeAttributes(element);} ;SyncToView=function SyncToView_Flash(){inp_src[OxO10ce[4]]=element[OxO10ce[7]];} ;SyncTo=function SyncTo_Flash(element){element[OxO10ce[7]]=inp_src[OxO10ce[4]];} ;