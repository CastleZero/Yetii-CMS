﻿/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.protectedSource.push( /<\?[\s\S]*?\?>/g );   // PHP Code
	config.protectedSource.push( /<\?php[\s\S]*?\?>/g );   // PHP Code
	config.entities = false;
};
