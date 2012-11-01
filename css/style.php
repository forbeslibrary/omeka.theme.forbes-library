<?php
class Color {
        const background = '#FFFFF7';
        const backgroundAccent1 = '#DDDDD0';
        const backgroundAccent2 = '#EEEEE0';
        const bodyText = '#333';
        const headerBackground = '#fff';
        const textAccent1 = '#606';
        const link = '#606';
        const linkActive = '#A0A';
        const linkHover = '#808';
        const alertText = '#D00';
}
class Font {
        const headingFont = '2em Palatino, Times, serif';
        const bodyFont = '75% "Helvetica Neue",Helvetica, Arial, sans-serif;';
}
?>
/* ==== Generic rules ====================================================== */
a img { border:none; }
hgroup>h1, /* remove vertical margins from header tags in hgroups */
hgroup>h2,
hgroup>h3,
hgroup>h4,
hgroup>h5,
hgroup>h6 {
    margin-top:0;
    margin-bottom:0;
}
footer {
	clear:both;
	padding:0.25ex .5em;
}
hgroup { /* hgroup vertical margins */
    margin-top:1em;
    margin-bottom:1em;
}
img { max-width:100%; }
dt {
	display:inline;
	font-weight:bold;
}
dd { display:inline; }
html { height:100%; }
body {
	font:<?php echo Font::bodyFont; ?>;
	color:<?php echo Color::bodyText; ?>;
	background:<?php echo Color::background; ?>;
	margin:0;
	height:100%;
}
p,
span,
ul,
ol,
dl {
	font-size:1em;
	line-height:1.6em;
}
abbr,
acronym {
	border:none;
	font-style: normal;
}
img a {	border:none; }
blockquote { font-style:italic; }
/* Headings */
h1,
h2,
h3 {
	font-family:'Trebuchet MS',sans-serif;
	font-weight:normal;
	clear:none;
	line-height: 1em;
}
h1 { font-size:2em; }
h2 { font-size:1.75em; }
h3 { font-size: 1.5em; }
@media(max-width: 600px) {
        h1 { font-size:1.75em; }
        h2 { font-size:1.6em; }
        h3 { font-size:1.4em; }        
}
h4,
h5,
h6 {
	font-size:1.2em;
	line-height:1.25em;
	margin:.75em 0 0;
}
h5,
h6 {
	font-weight:normal;
}
h6 {
	font-style:italic;
}

/* Links */
a:link,
a:visited { color:<?php echo Color::link; ?>; }
a:hover { color:<?php echo Color::linkHover; ?>; }
a:active { color:<?php echo Color::linkActive; ?>; }
h1 a, 
h2 a,
h3 a,
h4 a { text-decoration:none; }

h4 a { padding:.25em 0; }

/* Forms */
fieldset {
	border:0;
	padding:0;
}
legend {
	font-size:1.5em;
	line-height:1em;
	margin:1em 0 0 ;
}
input.textinput { margin-bottom:1em; }
    #submit_search_advanced {
        width:100%;
        margin-top:1em;
    }
    #advanced-search-page .field {
		padding:0.75em 0;
		overflow:hidden;
		}
    @media (min-width: 40em) { /* use grid on large screens */
	#advanced-search-page .field {
		width:19em;
		padding:0.75em;
		display:inline-block;
	}
    }
    }
    #advanced-search-page .field label,
    #advanced-search-page .field .label{
		float:left;
		font-weight:normal;
		clear:left;
		}
    #advanced-search-page .field .textinput,
    #advanced-search-page .field input,
	.field select {
		float:right;
		width:90%;
		background:#fff;
		}
    #advanced-search-page .field select {
		width: 92%;
		}
	#advanced-search-page .field button {
		float:right;
		}
    #advanced-search-page input.submitinput {
		margin-top:1em;
		}
    #advanced-search-page #search-submit {
	width:100%;
    }
    #primary .radioinputs label {
		display:block;
		float:left;
		width:48%;
		clear:none;
		}
    #primary .search-entry select {
		margin-bottom:.5em;
		}
    #primary #submit_search {
		margin:.5em 0 0 458px;
		}

/* Tables */
th,
td {
	margin:0;
	padding:0.25em 0.5em 0.25em 0;
	}
th {
	text-align:left;
	}
/* === Reusable classes ==================================================== */
.clear { clear:both; }
.hide { /* hide content on screen but not screen readers */
	text-indent:-1000em;
	width:0;
	height:0;
	overflow:hidden;
	}
.navigation {
	list-style:none;
	margin:0;
	padding:0;
}
.navigation>li {
        padding:0 0.9em 0 0em;
        margin:0;
        display:inline;
}
.navigation>li>a {
        text-decoration:none;
}
.navigation>li>a:link, 
.navigation>li>a:visited {
	color:<?php echo Color::bodyText; ?>;
}
.navigation>li>a:hover {
	color:<?php echo Color::linkHover; ?>;
}
.navigation>li.current a {
	color:<?php echo Color::textAccent1; ?>;
	font-weight:bold;
}
/* === collections/browse.php ============================================== */
.collections-browse-collection-list {
    padding:0;
}
.collections-browse-collection-entry {
    overflow: hidden;
}
.collections-browse-collection-entry>a {
    text-decoration:none;
}
.collections-browse-collection-entry h2 {
    background:<?php echo Color::backgroundAccent1; ?>;
    padding:0.5ex 0.5em;
    border-top:0.25ex solid <?php echo Color::textAccent1; ?>;
}
.collections-browse-collection-entry figure {
        float: left;
        max-width: 30%;
        margin: 0 2em 1ex 0;
}
/* === collections/show.php ================================================ */
.collections-show-more-items-line {
	font-weight: bold;
	clear: both;
}
#collections-show-item-list {
        margin-top:2em;
        border-top:dashed <?php echo Color::bodyText; ?> 0.25em;
}
#collections-show-item-list>h2:first-child {
        margin-top:0.5em;
}
#collections-show-item-list>ul{
    padding-left:0;
    list-style-type:none;
}
/* === common/header.php =================================================== */
#content {
	padding:0 1em;
	clear:both;
	margin-bottom:2em;
	min-height:90%;
}
#page-header {
	margin:0;
	padding:0;
	width:100%;
	background-color: <?php echo Color::headerBackground; ?>;
	overflow:hidden;
}

#page-header>#simple-search {
    text-align:right;
    padding:0.5em;
    margin:0;
    display:inline-block;
    width:50%;
    height:2em;
    position:relative;
    vertical-align:middle;
}
#search.textinput {
    position:absolute;
    left:0;
    right:6em;
}
#submit_search {
    position:absolute;
    width:5.5em;
    right:0;
}

#site-logo {
    vertical-align:middle;
    padding:0 1em;
    margin:0;
    display:inline-block;
}
#top-level-nav {
	padding:0 1em;
	overflow:hidden;
	font-size:larger;
	background-color:<?php echo Color::backgroundAccent1; ?>;
}	
#top-level-nav:focus {
    outline:none;
}
#top-level-nav>.navigation-label {
        display:none;
}
#top-level-nav .nav-jump-to-content {
    display:none;
}
@media (max-width: 600px) { /* Modify style for narrow screens */
   #page-header { display:table; }
   #page-header>* {
        display:table-cell;
        vertical-align:middle;
    }
   #page-header>#simple-search {
        width:auto;
   }
   #page-header>#simple-search>.textinput {
        position:static;
        display:inline-block;
   }
   #page-header>#simple-search>#submit_search {
        display:none;
   }
   /*#simple-search {
        display:block;
        width:100%;
        height:5ex;
    }
    #search.textinput {
        position:absolute;
        left:0;
        right:6em;
        font-size:2em;
    }
    #submit_search {
        position:absolute;
        width:5.5em;
        right:0;
        font-size:2em;
	}*/
    #site-logo { padding: 0 0.25em; }
    #top-level-nav {
        margin:0;
        padding:0;
        height:100%;
        background:<?php echo Color::bodyText; ?>;
    }
    #top-level-nav>.navigation-label {
        display:block;
        color:<?php echo Color::background; ?>;
        margin:0em;
        padding:1em 0.5em;
        text-decoration:none;
        font-weight:bold;
        font-size:75%;
        cursor:pointer;
        text-align:center;
    }
    #top-level-nav:focus .nav-jump-to-content {
        display:block;
        width:0; /* we give this zero size, but make the link big */
        height:0;
        padding:0;
    }
    #top-level-nav:focus .nav-jump-to-content>a {
        /* make link invisible */
        background: transparent;
        border: 0;
        text-indent: -999em;
        /* make link fill screen */
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        /* ensure it sits behind the other links */
        z-index:0;
        /* make the pointer look like it's not pointing at a link */
        cursor:default;
    }
    #top-level-nav>ul {
        display:none;
    }
    #top-level-nav:focus>ul {
        margin:0;
        margin-top:1em;
        display:block;
        position:fixed;
        left:0;
        right:0;
        z-index:99;
        background:<?php echo Color::bodyText; ?>;
    }
    #top-level-nav:focus>ul>li {
        display:block;
        background:<?php echo Color::backgroundAccent1; ?>;
        padding:0.5ex 1em;
        margin:1px;
    }
    #top-level-nav:focus>ul>li>a {
        display:block;
        width:100%;
        height:100%;
        position:relative;
        z-index:100;
    }
}				
/* === common/pagination-control.php ======================================= */
.common-pagination-control {
	margin:1em 0;
	font-weight:bold;
}
.common-pagination-control-summary {
    margin-right:1em;
}

/* === index.php =========================================================== */
#site-title {
    text-align:center;
    width:100%;
    font:<?php echo Font::headingFont; ?>;
}
#home #content {	
	margin-left: auto;
	margin-right: auto;
}
#home #simple-search {
        max-width:80em;
        width:100%;
        height: 4ex;
        position: relative;
        margin: 7ex auto;
}
#home #simple-search #search {
        position:absolute;
        left:0;
        right:6em;
        font-size:2.5ex;
    }
#home #simple-search #submit_search {
        position:absolute;
        width:5.5em;
        right:0;
        font-size:2.5ex;
	}
#featured-content {
        margin:5ex 0 2ex 0;
        width:100%:
}
#featured-content>section {
        position:relative;
}
#link-from-feature-to-items,
#link-from-feature-to-collections,
#link-from-feature-to-exhibits {
        float:right;
        position:absolute;
        right:1em;
        top:2em;
}
#featured-content>section {
        overflow:auto; /* expand section to fit content */
}
@media (min-width: 62em) { /* put featured content in a row on large screens */
        #featured-content.two-sections, #featured-content.three-sections {
                border-spacing:2em 0;
                margin:0 -2em;
                display:table;        
        }
        #featured-content.two-sections>section {
                display:table-cell;
                width:50%;
                max-width:50%;
        }
        #featured-content.three-sections>section {
                display:table-cell;
                width:33%;
                max-width:33%;
        }
}
#featured-content>section h2 {
        background-color:<?php echo Color::backgroundAccent1; ?>;
        padding:0.5ex 0.5em;
        border-top:0.25ex solid <?php echo Color::textAccent1; ?>;
}
#featured-content>section h3 {
        background-color:<?php echo Color::backgroundAccent2; ?>;
        padding:0.5ex 0.5em;
}
#featured-content>section>figure {
        float:left;
        margin:0 1em 1ex 0;
        max-width:33%;
}
/* === items/advanced-search.php =========================================== */
.items-advanced-search-special-permissions {
	background-color:<?php echo Color::backgroundAccent1; ?>;
	color:<?php echo Color::textAccent1; ?>;
}
/* == items/browse.php ============== */
#items-browse-loop {
	clear:both;
}
#items-browse-summary-line a {
	font-weight:bold;
}
.items-browse-warning-line {
	color:<?php echo Color::alertText; ?>;
	font-weight:bold;
	margin: 1em 0;
}
/* == items/browse-navigation.php =========================================== */
#items-browse-nav {
	margin:0;
	width:100%;
	overflow:hidden;
}
#items-browse-nav>ul>li {
        float:left;
}
/* == items/item-metadata.php ======= */
.element-set {
	margin-bottom:2em;
}
.element-set-name {
	font-weight: bold;
	font-size:large;
}
.element-name {
	font-weight: bold;
	padding-right: 1em;
	vertical-align:top;
	width:1em;
	white-space:nowrap;
}

/* == items/show.php ======= */
#files-container {
	margin: 0 1em 0 0;
}
#files-container img.thumb {
	width: 16em;
}
#items-show-description-box{
	min-width:16em;
}
#items-show-description {
	margin: 0 1em 1em 0;
}
#items-show-id {
	margin: 0 1em 1em 0;
	font-weight: bold;
}
#items-show-collection {
	margin: 0 1em 1em 0;
}
#items-show-collection a {
	font-weight:bold;
}
#items-show-tags ul {
	padding-left: 2em;
}
#item-show-plugin-addtions {
    margin: 1em 0;
}

/* == items/show-in-browse.php ======= */
.items-show-in-browse {
	display:block;
	margin-left:0;
	overflow:hidden;
}
.items-show-in-browse>h2 {
    background:<?php echo Color::backgroundAccent1; ?>;
    padding:0.5ex 0.5em;
    border-top:0.25ex solid <?php echo Color::textAccent1; ?>;
}
.items-show-in-browse figure {
    margin:0 1em 1em 0;
    float:left;
}
.items-show-in-browse-details {
    font-weight: bold;
}
.items-show-in-browse-description {
    font-weight: normal;
    margin-top: 1.5em;
    margin-bottom: 1.5em;
}
/* ====== Structure ====== */
#secondary {
	clear:both;
	margin:3em 0 0;
	}
#primary {
	height:100%; 
	margin:0 auto;
	}
#recent-items {
	clear:both;
	overflow:hidden;
	margin: 1.5em 0;
}
#tagcloud {
	margin-top: 2em;
}

/* Search */
#simple-search {
	font-size: .9em;
	}
#simple-search input {
	margin:0 0.25em;
	padding:0.25em;
	}
#search-container a {
	float:right;
	font-size: 1em;
	padding: 1em 0em;
	}
#searchwrap h3 {
	text-transform:uppercase;
	font-size:1em;
	margin:0;
	}

/* Footer Navigation */

footer ul.navigation {
	padding:0;
	margin:0 0 0.25em;
	}
    footer ul.navigation li {
	padding-right:0.25em;
	}
		
/* Thumbnails */
span.thumb {
	margin:0 0 2em;
	}
span.thumb a img {
	border:1px solid #ccc;
	} 

/* Browse and Item Pages */
.pagination,
.item-pagination {
	font-size:.9em;
	width:auto;
	padding:0;
	clear:both;
	}
	.pagination li,
	.item-pagination li {
		display:inline;
		padding:0 .25em;
		}
	.pagination a,
.pagination ul {
	display:inline;
	margin: 0;
	padding: 0;
}	
.desc p {
	margin:.5em 0 0;
	}

.item {
	overflow:hidden;
	width:100%;
	padding:0;
	margin:0;
	clear:both;
	border-bottom:0.125em solid #eee;
	padding-bottom:18px;
	}
	.item .item-content {
		float:right;
		margin-left:18px;
		margin-bottom:18px;
		}
	.item .item-meta {
		float:left;
		width:100%;
		}
 	.item span {
		line-height:1.5em;
		margin-bottom:1.5em;
		}
	.item span.thumb {
		float: right;
		}
	.item div.item-img {
		padding-left:0.5em;
		float:right;
		}
.hentry {
	margin:1em 0;
	}

.item-description {
	display:block;
	margin:0 0 1em;
	}
ul.tags {
	padding-left:0;
	}
ul.tags li {
	display:inline;
	padding:0 .5em 0 0;
	}

/* Collections */
.collection {
	margin:1em 0;
	padding:1em 0;
	border-bottom:0.125em solid #ddd;
	}
.collection ul {
	margin: 0 0 1em 1em;
	}

/*=== Microformats ==========================================================*/
.hTagcloud ul {
	list-style:none;
	margin-left:0;
	padding-left:0;
	}
	.hTagcloud li {
		display:inline;
		}
	.popular,
	.-popular {
		font-size:120%;
		}
	.v-popular {
		font-size:140%;
		}
	.vv-popular {
		font-size:180%;
		}
	.vvv-popular {
		font-size:220%;
		}
	.vvvv-popular {
		font-size:260%;
		}
	.vvvvv-popular {
		font-size:300%;
		}
	.vvvvvv-popular {
		font-size:320%;
		}
	.vvvvvvv-popular {
		font-size:340%;
		}
	.vvvvvvvv-popular {
		font-size:360%;
		}
	.popular a,
	.popular a:visited {
		color: #ccc;
		}
	.-popular a,
	.-popular a:visited {
		color: #ccc;
		}
	.v-popular a,
	.v-popular a:visited {
		color: #ccc;
		}
	.vv-popular a,
	.vv-popular a:visited {
		color: #bebebe;
		}
	.vvv-popular a,
	.vvv-popular a:visited {
		color: #b1b1b1;
		}
	.vvvv-popular a,
	.vvvv-popular a:visited {
		color: #a3a3a3;
		}
	.vvvvv-popular a,
	.vvvvv-popular a:visited {
		color: #959595;
		}
	.vvvvvv-popular a,
	.vvvvvv-popular a:visited {
		color: #888;
		}
	.vvvvvvv-popular a,
	.vvvvvvv-popular a:visited {
		color: #7a7a7a;
		}
	.vvvvvvvv-popular a,
	.vvvvvvvv-popular a:visited {
		color: #6d6d6d;
		}

	.popular a:hover,
	.-popular a:hover {
		color: #4B0049;
		}
	.v-popular a:hover {
		color: #5B175A;
		}
	.vv-popular a:hover {
		color: #6C2E6A;
		}
	.vvv-popular a:hover {
		color: #7C467B;
		}
	.vvvv-popular a:hover {
		color: #8C5D8B;
		}
	.vvvvv-popular a:hover {
		color: #9D749C;
		}
	.vvvvvv-popular a:hover {
		color: #AD8BAC;
		}
	.vvvvvvv-popular a:hover {
		color: #BEA2BD;
		}
	.vvvvvvvv-popular a:hover {
		color: #CEB9CD;
		}
/* === Exhibit Styles ====================================================== */
#exhibits p,
#exhibits .tags {
	margin-bottom: 1em;
	}
	#exhibits .exhibit h3 {
		text-transform:uppercase;
		padding-top:.5em;
		}
	#exhibits .exhibit h3 a {
		text-decoration:none;
		}
	#exhibits .exhibit {
		border-bottom:0.125em solid #ccc;
		margin-bottom:1em;
		}
#exhibit-header {
	clear: both;
	}
		#exhibits h2 {
			text-transform:uppercase;
			margin-bottom:0;
			}
		#exhibits h2 a {
			text-decoration:none;
			} 
		#exhibits h3 {
			clear:both;
			float:left;
			margin: 0;
			}
#nav-container {
	overflow:hidden;
	zoom:1;
	}
.exhibit-section-nav {
	overflow:hidden;
	padding:0;
	margin-left:0;
	}
	.exhibit-section-nav li {
		list-style-type:none;
		float:left;
		text-transform:uppercase;
		letter-spacing:0.14em;
		padding:0 2em 0 0;
		}
	.exhibit-section-nav li a {
		float:left;
		text-decoration:none;
		display:block;
		color:#a580a4;
		border-bottom:2px solid #fff;
		}
	.exhibit-section-nav li a:visited {
		color:#a580a4;
		}
	.exhibit-section-nav li a:hover {
		color:#92278f;
		border-bottom:2px solid #92278f;
		}
	.exhibit-section-nav li a.current {
		border-bottom:2px solid <?php echo Color::textAccent1; ?>;
		color:<?php echo Color::textAccent1; ?>;
		}
	
.exhibit-page-nav {
	clear:left;
	float:left;
	overflow:hidden;
	width:100%;
	border-bottom:1px solid #ddd;
	padding:0 1em 0 0;
	margin-bottom:.5em;
	margin-left:0;
	}
	.exhibit-page-nav li {
		float:left;
		display:inline;
		padding:0 2px 0 0;
		margin:0;
		}
	.exhibit-page-nav li a {
		display:inline;
		padding:5px 1em .5em 0;
		text-decoration:none;
		}
	.exhibit-page-nav li.current a {
		text-decoration:none;
		font-weight:bold;
		}
#exhibit-page-navigation {
	clear:both;
	margin-bottom:1em;
	float:right;
	}
#exhibit-page-navigation .next-page {
	margin-left:2em;
	}
.summary {
	margin-bottom:0;
	}
.exhibit-item {
	overflow:hidden;
	}
.exhibit-item a {
	text-decoration:none;
	}
.gallery-thumbnails-text-bottom {
	clear: both;
	}
#content .gallery-thumbnails-text-bottom .primary .exhibit-item {
	margin-right:9px;
	}
