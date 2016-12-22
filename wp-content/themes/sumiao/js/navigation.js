/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
( function() {
	var container, button, menu, links, subMenus, i, len, body, subBttn, childNode;

	body = document.getElementsByTagName( 'body' )[0];
	container = document.getElementById( 'site-navigation' );
	mast = document.getElementById( 'masthead' );
	if ( ! container ) {
		return;
	}

	button = mast.getElementsByTagName( 'button' )[0];
	
	if ( 'undefined' === typeof button ) {
		return;
	}

	subBttn = container.getElementsByClassName('dropdown');
	menu = container.getElementsByTagName( 'ul' )[0];

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	menu.setAttribute( 'aria-expanded', 'false' );
	if ( -1 === menu.className.indexOf( 'nav-menu' ) ) {
		menu.className += ' nav-menu';
	}

	button.onclick = function() {
		if ( -1 !== container.className.indexOf( 'toggled' ) ) {
			body.className = body.className.replace( ' toggled', '' );
			container.className = container.className.replace( ' toggled', '' );
			button.setAttribute( 'aria-expanded', 'false' );
			menu.setAttribute( 'aria-expanded', 'false' );
		} else {
			body.className += ' toggled';
			container.className += ' toggled';
			button.setAttribute( 'aria-expanded', 'true' );
			menu.setAttribute( 'aria-expanded', 'true' );
		}
	};

	// Get all the link elements within the menu.
	links    = menu.getElementsByTagName( 'a' );
	subMenus = menu.getElementsByTagName( 'ul' );

	// Set menu items with submenus to aria-haspopup="true".
	for ( i = 0, len = subMenus.length; i < len; i++ ) {
		subMenus[i].parentNode.setAttribute( 'aria-haspopup', 'true' );
	}

	// For Submenus icon
	
	for (var i = 0, len = subBttn.length; i < len; i++) {
		subBttn[i].onclick = function() {
			var parent = this.parentNode;
			if (-1 !== parent.className.indexOf('expanded')) {
				parent.className = parent.className.replace( ' expanded', '');
			} else {
				parent.className += ' expanded';
			}
		}
	}

	// Each time a menu link is focused or blurred, toggle focus.
	for ( i = 0, len = links.length; i < len; i++ ) {
		links[i].addEventListener( 'focus', toggleFocus, true );
		links[i].addEventListener( 'blur', toggleFocus, true );
	}

	// child nav menus 

	childNode = document.getElementsByClassName('sub-page-wrap');

	if (childNode.length != 0) {
		 for (var i = 0, len = childNode.length; i < len; i++) {
		 	var togBttn = childNode[i].getElementsByClassName('toggle');
		 	for (var x = 0; x < togBttn.length; x++) {
		 		togBttn[x].onclick = function() {
		 			var parent = this.parentElement;
		 			if (-1 !== parent.className.indexOf('expanded')) {
						parent.className = parent.className.replace( ' expanded', '');
					} else {
						parent.className += ' expanded';
					}
		 		}
		 	}
		 }
	}

	/**
	 * Sets or removes .focus class on an element.
	 */
	function toggleFocus() {
		var self = this;

		// Move up through the ancestors of the current link until we hit .nav-menu.
		while ( -1 === self.className.indexOf( 'nav-menu' ) ) {

			// On li elements toggle the class .focus.
			if ( 'li' === self.tagName.toLowerCase() ) {
				if ( -1 !== self.className.indexOf( 'focus' ) ) {
					self.className = self.className.replace( ' focus', '' );
				} else {
					self.className += ' focus';
				}
			}

			self = self.parentElement;
		}
	}

	/**
	 * Toggles `focus` class to allow submenu access on tablets.
	 */
	( function( container ) {
		var touchStartFn, i,
			parentLink = container.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

		if ( 'ontouchstart' in window ) {
			touchStartFn = function( e ) {
				var menuItem = this.parentNode, i;

				if ( ! menuItem.classList.contains( 'focus' ) ) {
					e.preventDefault();
					for ( i = 0; i < menuItem.parentNode.children.length; ++i ) {
						if ( menuItem === menuItem.parentNode.children[i] ) {
							continue;
						}
						menuItem.parentNode.children[i].classList.remove( 'focus' );
					}
					menuItem.classList.add( 'focus' );
				} else {
					menuItem.classList.remove( 'focus' );
				}
			};

			for ( i = 0; i < parentLink.length; ++i ) {
				parentLink[i].addEventListener( 'touchstart', touchStartFn, false );
			}
		}
	}( container ) );
} )();
