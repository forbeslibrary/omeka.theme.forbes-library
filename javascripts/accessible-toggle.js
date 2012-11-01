jQuery(document).ready(function ($) {
  //The following substituions prevent javascript specific CSS from being used
  // when javascript is not present.
  // Replace the '_toggle' class with 'toggle'. 
  $('._toggle').
    removeClass('_toggle').
    addClass('toggle');
    
  // Replace the '_toggle_button' class with 'toggle_button'. 
  $('._toggle_button').
    removeClass('_toggle_button').
    addClass('toggle_button');
  
  // Replace the '_expand_on_hover' class with 'expand_on_hover'.
  $('._expand_on_hover').
    removeClass('_expand_on_hover').
    addClass('expand_on_hover');
  
  
  // Hide all toggle elements that aren't specified as expanded
  $('.toggle:not(.expanded)').hide();
  
  // Add a link to each toggle button
  $('.toggle_button').each(add_link);
  
  // Add a click event handler to all toggle buttons.
  $('.toggle_button').click(toggle);
  
  // Remove the focus from the link tag when accessed with a mouse.
  $('toggle_button a').mouseup(remove_focus);

  // Add event handlers for expand_on_hover
  $(".expand_on_hover").on("mouseenter focusin", expand_on_hover);
});

var create_name = function(text) {
  // Convert text to lower case.
  var name = text.toLowerCase();
  
  // Remove leading and trailing spaces, and any non-alphanumeric
  // characters except for ampersands, spaces and dashes.
  name = name.replace(/^\s+|\s+$|[^a-z0-9&\s-]/g, '');
  
  // Replace '&' with 'and'.
  name = name.replace(/&/g, 'and');
  
  // Replaces spaces with dashes.
  name = name.replace(/\s/g, '-');
  
  // Squash any duplicate dashes.
  name = name.replace(/(-)+\1/g, "$1");
  
  return name;
};

var add_link = function() {
  // Convert the element text into a value that
  // is safe to use in a name attribute.
  var name = create_name(jQuery(this).text());
  
  // Create a name attribute in the following div.toggle
  // to act as a fragment anchor.
  jQuery(this).next('div.toggle').attr('name', name);
  
  // Replace the toggle element with a link to the
  // fragment anchor.  Use the text to create the
  // link title attribute.
  jQuery(this).html(
    '<a href="#' + name + '" title="Reveal ' +
    jQuery(this).text() + ' content">' +
    jQuery(this).html() + '</a>');
};

var toggle = function(event) {
  event.preventDefault();

  // Toggle the 'expanded' class of the toggle
  // element, then apply the slideToggle effect
  // to div.toggle siblings.
  jQuery(this).
    toggleClass('expanded').
    nextAll('div.toggle').slideToggle('fast');
};

var remove_focus = function() {
  // Use the blur() method to remove focus.
  jQuery(this).blur();
};

// First catch the mouse enter, grab position, make new element, append it, then animate
var expand_on_hover = function(event) {
	jQuery(".over").remove(); // remove any existing hover expansions
	var float = jQuery(this).clone();
	float.toggleClass("over")
		.toggleClass("expand_on_hover")
		.children('.toggle').toggle();
	float.appendTo(jQuery("body")).position({
		"my" : "center center",
		"at" : "center center",
		"of" : jQuery(this),
		"collision": "fit"
		});
	float.on("mouseleave focusout", function() {
	  jQuery(this).remove()
	  });
};
