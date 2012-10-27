<?php
	//Libs
	require('NFO.php');
	require('Template.php');

	//Configuration
	$content = 'index.txt';
	$template = 'index.tmpl';
	$title = 'Warg - warg.loupsgris.fr';

	//Checks site integrity
	if (!file_exists($content)) {
		die("Please create a $content text file with your content.");
	}

	if (!file_exists($template)) {
		die("Please create a $template HTML file with your template. Replace the content by %%CONTENT%% and the site title by %%TITLE%%.");
	}

	//HTML output
	$nfo = new NFO($content);
	$nfo->lineLength = 32;

	$template = new Template($template);
	$template->set('CONTENT', $nfo);
	$template->set('TITLE', $title);
	$template->display();
?>