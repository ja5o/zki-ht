import { __ } from '@wordpress/i18n';

export default class SiteNavigation {
	constructor( element, options = {} ) {
		// Bind methods.
		this.listenerSubmenuClick = this.listenerSubmenuClick.bind( this );
		this.listenerMenuToggleClick =
			this.listenerMenuToggleClick.bind( this );
		this.listenerMenuCloseClick = this.listenerMenuCloseClick.bind( this );
		this.listenerDocumentClick = this.listenerDocumentClick.bind( this );
		this.trapFocus = this.trapFocus.bind( this );

		// Settings.
		this.settings = { ...options };
		// Navigation container element.
		this.$nav = document.querySelector( element );

		// Bail out if there is no menu.
		if ( ! this.$nav ) {
			console.error( 'Site Navigation: Target not found.' );
			return;
		}

		// Menu toggler.
		this.$menuToggle = this.$nav.querySelector(
			'.site-navigation-mobile-trigger'
		);

		// Bail out if there is no menu toggler.
		if ( ! this.$nav ) {
			console.error( 'Site Navigation: Menu toggler not found.' );
			return;
		}

		this.$menuClose = this.$nav.querySelector( '.site-navigation-close' );

		// Naviation Container.
		this.$navContainer = this.$nav.querySelector(
			'.site-navigation-container'
		);

		// Menu Items.
		this.$menuItems = this.$nav.querySelectorAll(
			'.menu-item-has-children'
		);

		// Setup.
		this.setupListeners();
	}

	setupListeners() {
		// Menu Toggler.
		this.$menuToggle.addEventListener(
			'click',
			this.listenerMenuToggleClick
		);

		// Close navigation.
		this.$menuClose.addEventListener(
			'click',
			this.listenerMenuCloseClick
		);

		// Sub menus.
		this.$menuItems.forEach( ( el ) => {
			el.querySelector( 'a' ).addEventListener(
				'click',
				this.listenerSubmenuClick
			);
		} );

		// Close submenus on document click.
		document.addEventListener( 'click', this.listenerDocumentClick );
	}

	listenerMenuToggleClick( event ) {
		const isExpanded =
			this.$menuToggle.getAttribute( 'aria-expanded' ) === 'true';

		// Don't bubble.
		event.stopPropagation();

		// If is currently open.
		if ( isExpanded ) {
			this.closeNavigation();
		} else {
			this.openNavigation();
		}
	}

	listenerMenuCloseClick() {
		this.closeNavigation();
	}

	listenerDocumentClick( event ) {
		const $expandedSubmenus = this.$nav.querySelectorAll(
			'.menu-item a[aria-expanded=true] + .sub-menu'
		);

		if (
			$expandedSubmenus.length === 0 ||
			event.target.getAttribute( 'aria-expanded' ) === 'true'
		) {
			return;
		}

		$expandedSubmenus.forEach( ( $submenu ) => {
			$submenu.parentNode.classList.remove( 'open' );
			$submenu.previousElementSibling.setAttribute(
				'aria-expanded',
				'false'
			);
		} );
	}

	listenerSubmenuClick( event ) {
		const $anchor = event.target;
		const isClosed = ! $anchor.parentNode.classList.contains( 'open' );

		if (
			$anchor.parentNode.classList.contains( 'menu-item-has-children' ) &&
			isClosed
		) {
			$anchor.parentNode.classList.add( 'open' );
			$anchor.setAttribute( 'aria-expanded', 'true' );
		} else {
			$anchor.parentNode.classList.remove( 'open' );
			$anchor.setAttribute( 'aria-expanded', 'false' );
		}
		event.preventDefault();
		return false;
	}

	openNavigation() {
		// Update ARIA Attributes.
		this.$menuToggle.setAttribute( 'aria-expanded', 'true' );
		this.$navContainer.setAttribute( 'aria-modal', 'true' );
		this.$navContainer.setAttribute(
			'aria-label',
			__( 'Main menu', 'zki-ht' )
		);
		this.$navContainer.setAttribute( 'role', 'dialog' );

		// Update Nav container class.
		this.$navContainer.classList.add( 'is-nav-open' );

		// Update html to prevent scroll.
		document.querySelector( 'html' ).classList.add( 'has-nav-open' );

		// Get focusable elements inside the navigation.
		this.focusableElements = Array.from(
			this.$navContainer.querySelectorAll(
				'a, button, input, textarea, select, [tabindex]:not([tabindex="-1"])'
			)
		);

		if ( this.focusableElements.length > 0 ) {
			this.focusableElements[ 0 ].focus(); // Set focus to the first element
			this.$navContainer.addEventListener( 'keydown', this.trapFocus );
		}
	}

	closeNavigation() {
		// Update ARIA Attributes.
		this.$menuToggle.setAttribute( 'aria-expanded', 'false' );
		this.$navContainer.removeAttribute( 'aria-modal' );
		this.$navContainer.removeAttribute( 'role' );
		this.$navContainer.removeAttribute( 'aria-label' );

		// Update Nav container class.
		this.$navContainer.classList.remove( 'is-nav-open' );

		// Update html to prevent scroll.
		document.querySelector( 'html' ).classList.remove( 'has-nav-open' );

		// Set focus on toggler.
		this.$menuToggle.focus();

		// Remove focus trap event listener.
		this.$navContainer.removeEventListener( 'keydown', this.trapFocus );
	}

	trapFocus( event ) {
		const focusableElements = Array.from(
			this.$navContainer.querySelectorAll(
				'a, button, input, textarea, select, [tabindex]:not([tabindex="-1"])'
			)
		).filter( ( el ) => el.offsetParent !== null ); // Exclude hidden elements

		if ( focusableElements.length === 0 ) {
			return;
		}

		const $firstElement = focusableElements[ 0 ];
		const $lastElement = focusableElements[ focusableElements.length - 1 ];

		if ( event.key === 'Tab' ) {
			if ( event.shiftKey && document.activeElement === $firstElement ) {
				event.preventDefault();
				$lastElement.focus();
			} else if (
				! event.shiftKey &&
				document.activeElement === $lastElement
			) {
				event.preventDefault();
				$firstElement.focus();
			}
		}
	}
}
