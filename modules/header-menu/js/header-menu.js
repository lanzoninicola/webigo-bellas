(function (webigoHelper, d) {
  const _event = webigoHelper?.eventManager;
  const _dom = webigoHelper?.domManager;

  const menuOpenMobileButton = _dom.el(".wbg-nav-hamburger");
  const menuCloseMobileButton = _dom.el(".wbg-nav-toggle");
  const menuContent = _dom.el(".wbg-nav-menu-content");
  const navItems = _dom.el(".wbg-nav-item");
  const rootNavItems = _dom.el(
    ".wbg-nav-items[data-nav-level='1'] .wbg-nav-item"
  );
  const secondLevelNavItems = _dom.el(
    ".wbg-nav-items[data-nav-level='2'] .wbg-nav-item"
  );

  let isMobileViewport = false;

  init();

  function init() {
    handleResponsivness();

    _dom.styleElements();

    _event.attachEvent({
      el: menuOpenMobileButton,
      ev: _event.type.click,
      cb: openMobileMenu,
    });

    _event.attachEvent({
      el: menuCloseMobileButton,
      ev: _event.type.click,
      cb: closeMobileMenu,
    });

    _event.bulkAttachEvent({
      el: navItems,
      ev: _event.type.click,
      cb: toggleNavItem,
    });
  }

  function handleResponsivness() {
    isMobile();

    window.addEventListener("resize", function () {
      isMobile();

      if (isMobileViewport) {
        handleMenuMobile();
      } else {
        handleMenuTabletDesktop();
      }
    });

    if (isMobileViewport) {
      handleMenuMobile();
    } else {
      handleMenuTabletDesktop();
    }

    function isMobile() {
      isMobileViewport = window.innerWidth < 478 ? true : false;
    }
  }

  function handleMenuTabletDesktop() {
    _event.bulkAttachEvent({
      el: rootNavItems,
      ev: "mouseover",
      cb: overedParentMenu,
    });

    _event.bulkAttachEvent({
      el: rootNavItems,
      ev: "mouseleave",
      cb: leavedParentMenu,
    });

    if (menuOpenMobileButton) {
      _dom.hide(menuOpenMobileButton);
    }

    if (menuContent) {
      _dom.show(menuContent);
    }
  }

  function handleMenuMobile() {
    d.removeEventListener("mouseover", overedParentMenu);
    d.removeEventListener("mouseleave", leavedParentMenu);

    if (menuOpenMobileButton) {
      _dom.show(menuOpenMobileButton);
    }

    if (menuCloseMobileButton) {
      _dom.show(menuCloseMobileButton);
    }

    if (menuContent) {
      _dom.hide(menuContent);
    }
  }

  function getSubmenu(parent) {
    const categoryToggled = parent.getAttribute("data-category-id");

    return _dom.el(
      ".wbg-nav-item[data-category-id='" + categoryToggled + "'] > ul"
    );
  }

  function toggleNavItem(e) {
    this.classList.toggle("selected");

    const navChildren = getSubmenu(this);

    _dom.toggleVisibility(navChildren);
    console.log(navChildren);
    e.stopPropagation();
  }

  function closeMobileMenu() {
    if (menuContent) {
      if (_dom.shouldVisible(menuContent)) {
        _dom.hide(menuContent);
      }
    }
  }

  function openMobileMenu() {
    if (menuContent) {
      if (_dom.shouldHidden(menuContent)) {
        _dom.show(menuContent);
      }
    }
  }

  function overedParentMenu() {
    this.classList.add("selected");
    const navChildren = getSubmenu(this);

    // _dom.setState({
    //   currentOveredMenu: this,
    // });

    _dom.show(navChildren);
  }

  function leavedParentMenu() {
    this.classList.remove("selected");

    const navChildren = getSubmenu(this);

    _dom.hide(navChildren);
  }
})(webigoHelper, document);

/*
(function (webigoHelper, d) {
  const _event = webigoHelper?.eventManager;
  const _dom = webigoHelper?.domManager;

  const catMenuItems = d.querySelectorAll(
    ".product-cats-nav-menu li.product-cat"
  );
  const subCatMenuWrappers = d.querySelectorAll(
    ".product-cats-nav-menu li.product-cat .product-subcats"
  );

  let catIdTargeted = false; // int
  let subcatIdTargeted = false; // int
  let subcatElTargeted = false; // element object
  let subcatElTargetedVisibilityStatus = "hidden"; // hidden ,  visible

  // catMenuItems.forEach((item) => {
  //   item.addEventListener("mouseover", showSubMenu);
  // });

  // subCatMenuWrappers.forEach((item) => {
  //   item.addEventListener("mouseleave", hideSubMenu);
  // });

  function showSubMenu() {
    const el = this;

    if (subcatElTargeted) {
      hideSubMenu();
    }

    catIdTargeted = el.getAttribute("data-product-cat");
    subcatIdTargeted = catIdTargeted;
    subCatMenuWrappers.forEach((subCatItem) => {
      if (subCatItem.getAttribute("data-product-cat") == subcatIdTargeted) {
        subcatElTargeted = subCatItem;
      }
    });
    subcatElTargetedVisibilityStatus = "visible";

    if (subcatElTargetedVisibilityStatus === "visible" && subcatElTargeted) {
      _dom.show(subcatElTargeted);
    }
  }

  function hideSubMenu() {
    if (subcatElTargeted) {
      _dom.hide(subcatElTargeted);
    }
  }

  // mobile menu management
  const navMenuMobile = d.querySelectorAll(".product-cats-nav-menu")[0];

  const closeMobileMenuButton = d.querySelectorAll(
    ".product-cats-nav-menu .ion-md-close"
  )[0];

  const openMobileMenuButton = d.getElementById("hamburger-mobile-menu");

  if (closeMobileMenuButton) {
    closeMobileMenuButton.addEventListener("click", hideMobileMenu);
  }

  if (openMobileMenuButton) {
    openMobileMenuButton.addEventListener("click", showMobileMenu);
  }

  function showMobileMenu() {
    if (navMenuMobile) {
      navMenuMobile.setAttribute("data-mobile-visibility", "visible");
    }

    if (closeMobileMenuButton) {
      closeMobileMenuButton.setAttribute("data-mobile-visibility", "visible");
    }
  }

  function hideMobileMenu() {
    if (navMenuMobile) {
      navMenuMobile.setAttribute("data-mobile-visibility", "hidden");
    }
  }
})(webigoHelper, document);
*/
