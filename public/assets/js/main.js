/**
* Template Name: thinksvy
* Updated: Sep 18 2023 with Bootstrap v5.3.2
* Template URL: https://bootstrapmade.com/thinksvy-free-multi-purpose-html-template/
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
*/
(function() {
  "use strict";

  /**
   * Easy selector helper function
   */
  const select = (el, all = false) => {
    el = el.trim()
    if (all) {
      return [...document.querySelectorAll(el)]
    } else {
      return document.querySelector(el)
    }
  }

  /**
   * Easy event listener function
   */
  const on = (type, el, listener, all = false) => {
    let selectEl = select(el, all)
    if (selectEl) {
      if (all) {
        selectEl.forEach(e => e.addEventListener(type, listener))
      } else {
        selectEl.addEventListener(type, listener)
      }
    }
  }

  /**
   * Easy on scroll event listener 
   */
  const onscroll = (el, listener) => {
    el.addEventListener('scroll', listener)
  }

  /**
   * Navbar links active state on scroll
   */
  let navbarlinks = select('#navbar .scrollto', true)
  const navbarlinksActive = () => {
    let position = window.scrollY + 200
    navbarlinks.forEach(navbarlink => {
      if (!navbarlink.hash) return
      let section = select(navbarlink.hash)
      if (!section) return
      if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
        navbarlink.classList.add('active')
      } else {
        navbarlink.classList.remove('active')
      }
    })
  }
  window.addEventListener('load', navbarlinksActive)
  onscroll(document, navbarlinksActive)

  /**
   * Scrolls to an element with header offset
   */
  const scrollto = (el) => {
    let header = select('#header')
    let offset = header.offsetHeight

    if (!header.classList.contains('header-scrolled')) {
      offset -= 20
    }

    let elementPos = select(el).offsetTop
    window.scrollTo({
      top: elementPos - offset,
      behavior: 'smooth'
    })
  }

  /**
   * Toggle .header-scrolled class to #header when page is scrolled
   */
  let selectHeader = select('#header')
  if (selectHeader) {
    const headerScrolled = () => {
      if (window.scrollY > 100) {
        selectHeader.classList.add('header-scrolled')
      } else {
        selectHeader.classList.remove('header-scrolled')
      }
    }
    window.addEventListener('load', headerScrolled)
    onscroll(document, headerScrolled)
  }

  /**
   * Back to top button
   */
  let backtotop = select('.back-to-top')
  if (backtotop) {
    const toggleBacktotop = () => {
      if (window.scrollY > 100) {
        backtotop.classList.add('active')
      } else {
        backtotop.classList.remove('active')
      }
    }
    window.addEventListener('load', toggleBacktotop)
    onscroll(document, toggleBacktotop)
  }

  /**
   * Mobile nav toggle
   */
  on('click', '.mobile-nav-toggle', function(e) {
    select('#navbar').classList.toggle('navbar-mobile')
    this.classList.toggle('bi-list')
    this.classList.toggle('bi-x')
  })

  /**
   * Mobile nav dropdowns activate
   */
  on('click', '.navbar .dropdown > a', function(e) {
    if (select('#navbar').classList.contains('navbar-mobile')) {
      e.preventDefault()
      this.nextElementSibling.classList.toggle('dropdown-active')
    }
  }, true)

  /**
   * Scrool with ofset on links with a class name .scrollto
   */
  on('click', '.scrollto', function(e) {
    if (select(this.hash)) {
      e.preventDefault()

      let navbar = select('#navbar')
      if (navbar.classList.contains('navbar-mobile')) {
        navbar.classList.remove('navbar-mobile')
        let navbarToggle = select('.mobile-nav-toggle')
        navbarToggle.classList.toggle('bi-list')
        navbarToggle.classList.toggle('bi-x')
      }
      scrollto(this.hash)
    }
  }, true)

  /**
   * Scroll with ofset on page load with hash links in the url
   */
  window.addEventListener('load', () => {
    if (window.location.hash) {
      if (select(window.location.hash)) {
        scrollto(window.location.hash)
      }
    }
  });

  /**
   * Preloader
   */
  let preloader = select('#preloader');
  if (preloader) {
    window.addEventListener('load', () => {
      preloader.remove()
    });
  }

  /**
   * Initiate glightbox 
   */
  const glightbox = GLightbox({
    selector: '.glightbox'
  });

  /**
   * Testimonials slider
   */
  new Swiper('.testimonials-slider', {
    speed: 600,
    loop: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false
    },
    slidesPerView: 'auto',
    pagination: {
      el: '.swiper-pagination',
      type: 'bullets',
      clickable: true
    }
  });

  function getCurrentScroll() {
    return window.pageYOffset || document.documentElement.scrollTop;
  }

  /**
   * Porfolio isotope and filter with Search and Load More
   */
  window.addEventListener('load', () => {

    let portfolioContainer = select('.portfolio-container');

    if (portfolioContainer) {
      let portfolioIsotope = new Isotope(portfolioContainer, {
        itemSelector: '.portfolio-item'
      });

      let portfolioFilters = select('#portfolio-flters li', true);
      let searchInput = select('#portfolio-search-input');
      let loadMoreBtn = select('#btn-load-more');
      let noResultsMsg = select('#portfolio-no-results');
      let currentFilter = '*';
      let itemsToShow = 6;
      let itemsIncrement = 6;

      // Function to get all items matching current filter
      function getFilteredItems() {
        let allItems = select('.portfolio-item', true);
        if (currentFilter === '*') {
          return allItems;
        }
        return allItems.filter(item => item.classList.contains(currentFilter.replace('.', '')));
      }

      // Function to apply search filter
      function applySearchFilter() {
        let searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
        let allItems = select('.portfolio-item', true);
        let visibleCount = 0;

        allItems.forEach((item, index) => {
          let name = item.getAttribute('data-name') || '';
          let description = item.getAttribute('data-description') || '';
          let matchesSearch = searchTerm === '' || name.includes(searchTerm) || description.includes(searchTerm);
          let matchesFilter = currentFilter === '*' || item.classList.contains(currentFilter.replace('.', ''));
          let withinLimit = index < itemsToShow || searchTerm !== '';

          if (matchesSearch && matchesFilter) {
            if (withinLimit || searchTerm !== '') {
              item.classList.remove('portfolio-hidden');
              item.style.display = '';
              visibleCount++;
            } else {
              item.classList.add('portfolio-hidden');
            }
          } else {
            item.classList.add('portfolio-hidden');
          }
        });

        // Show/hide no results message
        if (noResultsMsg) {
          noResultsMsg.style.display = visibleCount === 0 ? 'block' : 'none';
        }

        // Update load more button visibility
        updateLoadMoreButton();

        // Relayout isotope
        portfolioIsotope.arrange({
          filter: function(itemElem) {
            return !itemElem.classList.contains('portfolio-hidden');
          }
        });

        portfolioIsotope.on('arrangeComplete', function() {
          AOS.refresh();
        });
      }

      // Function to update load more button
      function updateLoadMoreButton() {
        if (!loadMoreBtn) return;

        let searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
        
        // Hide when searching
        if (searchTerm !== '') {
          loadMoreBtn.style.display = 'none';
          return;
        }

        let filteredItems = getFilteredItems();
        let hiddenItems = filteredItems.filter(item => item.classList.contains('portfolio-hidden'));

        if (hiddenItems.length > 0) {
          loadMoreBtn.style.display = 'inline-flex';
        } else {
          loadMoreBtn.style.display = 'none';
        }
      }

      // Initial setup - show only first 6 items
      function initializePortfolio() {
        let allItems = select('.portfolio-item', true);
        allItems.forEach((item, index) => {
          if (index >= itemsToShow) {
            item.classList.add('portfolio-hidden');
          } else {
            item.classList.remove('portfolio-hidden');
          }
        });
        updateLoadMoreButton();
        portfolioIsotope.arrange();
      }

      initializePortfolio();

      // Category filter click handler
      on('click', '#portfolio-flters li', function(e) {
        e.preventDefault();
        portfolioFilters.forEach(function(el) {
          el.classList.remove('filter-active');
        });
        this.classList.add('filter-active');

        currentFilter = this.getAttribute('data-filter');
        itemsToShow = itemsIncrement; // Reset items count when changing category

        // Clear search when changing category
        if (searchInput) {
          searchInput.value = '';
        }

        // Reset all items first
        let allItems = select('.portfolio-item', true);
        let filteredCount = 0;
        
        allItems.forEach((item) => {
          let matchesFilter = currentFilter === '*' || item.classList.contains(currentFilter.replace('.', ''));
          
          if (matchesFilter) {
            if (filteredCount < itemsToShow) {
              item.classList.remove('portfolio-hidden');
            } else {
              item.classList.add('portfolio-hidden');
            }
            filteredCount++;
          } else {
            item.classList.add('portfolio-hidden');
          }
        });

        updateLoadMoreButton();

        portfolioIsotope.arrange({
          filter: function(itemElem) {
            return !itemElem.classList.contains('portfolio-hidden');
          }
        });
        
        portfolioIsotope.on('arrangeComplete', function() {
          AOS.refresh();
        });

      }, true);

      // Search input handler
      if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
          clearTimeout(searchTimeout);
          searchTimeout = setTimeout(applySearchFilter, 300); // Debounce
        });
      }

      // Load more button handler
      if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
          itemsToShow += itemsIncrement;
          
          let filteredItems = getFilteredItems();
          let shownCount = 0;

          filteredItems.forEach((item) => {
            if (shownCount < itemsToShow) {
              if (item.classList.contains('portfolio-hidden')) {
                item.classList.remove('portfolio-hidden');
                item.style.animation = 'fadeIn 0.5s ease forwards';
              }
            }
            if (!item.classList.contains('portfolio-hidden')) {
              shownCount++;
            }
          });

          updateLoadMoreButton();

          portfolioIsotope.arrange({
            filter: function(itemElem) {
              return !itemElem.classList.contains('portfolio-hidden');
            }
          });

          portfolioIsotope.on('arrangeComplete', function() {
            AOS.refresh();
          });
        });
      }
    }

  });

  /**
   * Initiate portfolio lightbox 
   */
  const portfolioLightbox = GLightbox({
    selector: '.portfolio-lightbox'
  });

  /**
   * Portfolio details slider
   */
  new Swiper('.portfolio-details-slider', {
    speed: 400,
    loop: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false
    },
    pagination: {
      el: '.swiper-pagination',
      type: 'bullets',
      clickable: true
    }
  });

  /**
   * Animation on scroll
   */
  window.addEventListener('load', () => {
    AOS.init({
      duration: 1000,
      easing: "ease-in-out",
      once: true,
      mirror: false
    });
  });

  /**
   * Initiate Pure Counter 
   */
  new PureCounter();

})()