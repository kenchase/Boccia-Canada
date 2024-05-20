document.addEventListener('DOMContentLoaded', function () {
  // Getting main menu elements
  const menuContainer = document.querySelector('.ccpsa-main-nav-wrap');
  const menuToggle = menuContainer.querySelector('.ccpsa-main-nav-button');
  const menuItemsWithChildren = document.querySelectorAll('.menu-item-has-children > a');
  const siteHeaderMenu = menuContainer.querySelector('#site-header-menu');
  const siteNavigation = menuContainer.querySelector('#site-navigation');

  // If the menu toggle button exists, set up its behaviors
  if (menuToggle) {
    // Initial ARIA attribute setup for accessibility
    menuToggle.setAttribute('aria-expanded', 'false');
    siteNavigation.setAttribute('aria-expanded', 'false');

    // Event listener for main menu toggle button
    menuToggle.addEventListener('click', function () {
      // Toggle visual states for the button and menu
      this.classList.toggle('toggled-on');
      siteHeaderMenu.classList.toggle('toggled-on');

      // Determine and set the new expanded state for ARIA
      const isExpanded = this.getAttribute('aria-expanded') === 'true';
      const newExpandedState = isExpanded ? 'false' : 'true';
      let menuLabel = this.getAttribute('aria-label');
      const icon = this.querySelector('i');
      let iconClass = icon.getAttribute('class');

      // Update ARIA attributes
      this.setAttribute('aria-expanded', newExpandedState);
      siteNavigation.setAttribute('aria-expanded', newExpandedState);

      // Update Menu Label
      menuLabel = menuLabel === 'Open menu' ? 'Close menu' : 'Open menu';
      this.setAttribute('aria-label', menuLabel);

      // Update Menu Icon
      iconClass = iconClass === 'fa-solid fa-bars' ? 'fa-solid fa-xmark' : 'fa-solid fa-bars';
      icon.setAttribute('class', iconClass);
    });
  }

  // Set up dropdown toggle buttons for menu items with children
  menuItemsWithChildren.forEach(function (item) {
    const linkText = item.textContent;

    // Create the dropdown toggle button
    const dropdownToggle = document.createElement('button');
    dropdownToggle.className = 'dropdown-toggle';
    dropdownToggle.setAttribute('aria-expanded', 'false');

    // Set ARIA label for accessibility
    dropdownToggle.setAttribute('aria-label', linkText + ' submenu');

    // Insert the dropdown button after the menu item
    item.insertAdjacentElement('afterend', dropdownToggle);

    // Set up behavior when the dropdown button is clicked
    dropdownToggle.addEventListener('toggle', function () {
      // Determine the expanded state of the dropdown
      const isExpanded = this.getAttribute('aria-expanded');
      // Toggle the dropdown's expanded state
      isExpanded ? true : false;
      this.setAttribute('aria-expanded', isExpanded);
    });
  });

  // Toggle dropdowns behavior
  const dropdownToggles = siteHeaderMenu.querySelectorAll('.dropdown-toggle');
  dropdownToggles.forEach(function (toggle) {
    toggle.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation(); // Prevent event from bubbling

      // Toggle the clicked dropdown
      this.classList.toggle('toggled-on');
      const nextSubMenu = this.nextElementSibling;
      if (nextSubMenu && nextSubMenu.classList.contains('sub-menu')) {
        nextSubMenu.classList.toggle('toggled-on');
      }

      // Update the ARIA expanded state of the dropdown
      const isExpanded = this.getAttribute('aria-expanded') === 'false' ? 'true' : 'false';

      this.setAttribute('aria-expanded', isExpanded);

      // Close other dropdowns on the same level to avoid multiple open dropdowns
      const siblingToggles = Array.from(this.parentElement.parentElement.children)
        .map((el) => el.querySelector('.dropdown-toggle'))
        .filter((el) => el !== null && el !== this);
      siblingToggles.forEach((sibToggle) => {
        sibToggle.classList.remove('toggled-on');
        const sibSubMenu = sibToggle.nextElementSibling;
        if (sibSubMenu && sibSubMenu.classList.contains('sub-menu')) {
          sibSubMenu.classList.remove('toggled-on');
        }
        sibToggle.setAttribute('aria-expanded', 'false');
      });
    });
  });

  // Indicate that a menu has a sub-menu
  const subMenus = document.querySelectorAll('.sub-menu .menu-item-has-children');
  subMenus.forEach(function (subMenu) {
    subMenu.parentElement.classList.add('has-sub-menu');
  });

  // Keyboard navigation setup for menu
  const menuLinksAndDropdownToggles = document.querySelectorAll('.menu-item a, button.dropdown-toggle');
  menuLinksAndDropdownToggles.forEach(function (element) {
    element.addEventListener('keydown', function (e) {
      const key = e.keyCode;
      const parentDropdown = this.closest('ul').previousElementSibling;
      const prevSibling = this.parentElement.previousElementSibling;
      const prevElem = this.parentElement.previousElementSibling;
      let closestUl = '';
      let firstChildLink = '';

      // Key handling for improved keyboard navigation
      if (![27, 37, 38, 39, 40].includes(key)) {
        return;
      }

      // Handle different keys for navigation
      switch (key) {
        case 27: // Escape: Close dropdown or main menu
          e.preventDefault();
          e.stopPropagation();

          if (parentDropdown && parentDropdown.classList.contains('dropdown-toggle') && parentDropdown.classList.contains('toggled-on')) {
            parentDropdown.focus();
            parentDropdown.click();
          } else if (!parentDropdown) {
            // If no parent dropdown found, close the main menu.
            if (menuToggle && menuToggle.classList.contains('toggled-on')) {
              menuToggle.click();
              menuToggle.focus();
            }
          }
          break;

        case 37: // Left arrow: Move focus to the previous item
          e.preventDefault();
          if (this.classList.contains('dropdown-toggle')) {
            this.previousElementSibling.focus();
          } else {
            if (prevSibling && prevSibling.querySelector('button.dropdown-toggle')) {
              prevSibling.querySelector('button.dropdown-toggle').focus();
            } else if (prevSibling && prevSibling.querySelector('a')) {
              prevSibling.querySelector('a').focus();
            }
          }
          break;

        case 39: // Right arrow: Move focus to the next item or enter a submenu
          e.preventDefault();
          if (this.nextElementSibling && this.nextElementSibling.matches('button.dropdown-toggle')) {
            this.nextElementSibling.focus();
          } else {
            const nextSibling = this.parentElement.nextElementSibling;
            if (nextSibling) {
              nextSibling.querySelector('a').focus();
            }
          }
          if (this.matches('ul.sub-menu .dropdown-toggle.toggled-on')) {
            this.parentElement.querySelector('ul.sub-menu li:first-child a').focus();
          }
          break;

        case 40: // Down arrow: Move focus to the next item or submenu
          e.preventDefault();
          if (this.nextElementSibling) {
            firstChildLink = this.nextElementSibling.querySelector('li:first-child a');
            if (firstChildLink) {
              firstChildLink.focus();
            }
          } else {
            const nextElem = this.parentElement.nextElementSibling;
            if (nextElem) {
              nextElem.querySelector('a').focus();
            }
          }
          break;

        case 38: // Up arrow: Move focus to the previous item or exit a submenu
          e.preventDefault();
          if (prevElem) {
            prevElem.querySelector('a').focus();
          } else {
            closestUl = this.closest('ul');
            if (closestUl && closestUl.previousElementSibling.matches('.dropdown-toggle.toggled-on')) {
              closestUl.previousElementSibling.focus();
            }
          }
          break;
      }
    });
  });
  // Hide sub-menus on lost focus
  const menuLinksTopLevel = document.querySelectorAll('.menu > .menu-item > a, .menu button.dropdown-toggle');
  const openSubMenus = document.querySelectorAll('.sub-menu');
  menuLinksTopLevel.forEach(function (element) {
    element.addEventListener(
      'focus',
      (e) => {
        if (e.target.getAttribute('aria-expanded') === 'false') {
          menuLinksTopLevel.forEach(function (element) {
            element.setAttribute('aria-expanded', false);
            element.classList.remove('toggled-on');
          });
          openSubMenus.forEach(function (element) {
            element.classList.remove('toggled-on');
          });
        }
      },
      false
    );
  });
});
