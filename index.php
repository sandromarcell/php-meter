<!--
   Copyright 2016 Sandro Marcell <smarcell@mail.com>

   This program is free software; you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation; either version 2 of the License, or
   (at your option) any later version.

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with this program; if not, write to the Free Software
   Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
   MA 02110-1301, USA.
-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>php-meter</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="author" content="Sandro Marcell" />
	<meta name="generator" content="Geany 1.24.1" />
	<link rel="stylesheet" type="text/css" href="css/styles.css" />
	<link rel="icon" type="image/x-icon" href="images/favicon.ico" />
	<script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>
	<script type="text/javascript" src="js/raphael-2.1.4.min.js"></script>
	<script type="text/javascript" src="js/justgage.js"></script>
	<script type="text/javascript">
		<?php
		require 'include/config.inc.php';
		echo 'var link = ' . LINK . ';';
		?>

		$(window).load(function() {
			var download = new JustGage({
				id: "download",
				value: 0,
				min: 0,
				max: link,
				pointer: true,
				humanFriendly: true,
				title: "Download",
				label: "Mbit/s"
			});

			var upload = new JustGage({
				id: "upload",
				value: 0,
				min: 0,
				max: link,
				pointer: true,
				humanFriendly: true,
				title: "Upload",
				label: "Mbit/s"
			});

			// Self-invoking function every 1s for update value
			(function getValues() {
				$.ajax({
					url: "stats.php",
					type: "GET",
					cache: false,
					async: true,
					dataType: "json",
					success: function(data) {
						download.refresh(data.download);
						upload.refresh(data.upload);
					}
				});
				setTimeout(getValues, 1000);
			})();
		});
    </script>
</head>
<?php flush(); ?>
<body>
	<div id="content">
		<div id="download" title="Approximate download rate on the link."></div>
		<div id="upload" title="Approximate upload rate on the link."></div>
	</div>
	<div id="footer">
		<hr class="line">
		<p>php-meter &copy; 2016-<?php echo date('Y'); ?> <a href="https://gitlab.com/smarcell">Sandro Marcell</a></p>
	</div>
</body>

</html>
