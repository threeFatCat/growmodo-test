(function() {
    'use strict';

    const topBanner = document.querySelector('.top-banner');
    const bannerClose = document.querySelector('.banner-close');
    const menuToggle = document.querySelector('.menu-toggle');
    const navMenu = document.querySelector('.nav-menu');
    const navArrows = document.querySelectorAll('.nav-arrow');
    const testimonialSlider = document.querySelector('.testimonials-slider');
    const faqSlider = document.querySelector('.faqs-grid');

    if (bannerClose) {
        bannerClose.addEventListener('click', function() {
            if (topBanner) {
                topBanner.classList.add('hidden');
                localStorage.setItem('estatein_banner_closed', 'true');
            }
        });
    }

    if (topBanner && localStorage.getItem('estatein_banner_closed') === 'true') {
        topBanner.classList.add('hidden');
    }

    const navButtonsContainer = document.querySelector('.nav-buttons-container');
    const menuBackdrop = document.querySelector('.menu-backdrop');
    const body = document.body;
    
    let scrollPosition = 0;
    let bannerWasCollapsed = false;
    
    function updateScrollState() {
        scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
        const isScrolled = scrollPosition > 0;
        body.classList.toggle('is-scrolled', isScrolled);
    }
    
    function isBannerVisible() {
        if (!topBanner) return false;
        const isHidden = topBanner.classList.contains('hidden');
        const rect = topBanner.getBoundingClientRect();
        const isInViewport = rect.height > 0 && rect.top >= 0 && rect.bottom > 0;
        return !isHidden && isInViewport;
    }
    
    window.addEventListener('scroll', updateScrollState);
    updateScrollState();
    
    function openMenu() {
        const bannerVisible = isBannerVisible();
        const isScrolled = scrollPosition > 0;
        const siteHeader = document.querySelector('.site-header');
        
        // Ensure header is positioned correctly when menu opens
        if (siteHeader && isScrolled) {
            // Force reflow to ensure fixed positioning is applied
            siteHeader.style.top = '0';
            siteHeader.style.position = 'fixed';
        }
        
        if (navButtonsContainer) {
            navButtonsContainer.classList.add('active');
            // Disable transition first to prevent animation
            navButtonsContainer.style.setProperty('transition', 'none', 'important');
            // Force reflow to ensure transition is disabled
            navButtonsContainer.offsetHeight;
            // Set padding using shorthand to override CSS padding: 24px
            // Format: padding: top right bottom left
            navButtonsContainer.style.setProperty('padding', '68px 24px 24px 24px', 'important');
            // Force another reflow to ensure padding is applied
            navButtonsContainer.offsetHeight;
            // Keep transition disabled - we don't need it for padding
        }
        if (menuBackdrop) {
            menuBackdrop.classList.add('active');
            // Force backdrop to be visible immediately - disable transition temporarily
            menuBackdrop.style.transition = 'none';
            menuBackdrop.style.opacity = '1';
            menuBackdrop.style.visibility = 'visible';
            // Re-enable transition after a brief moment
            setTimeout(function() {
                if (menuBackdrop) {
                    menuBackdrop.style.transition = '';
                }
            }, 10);
        }
        if (menuToggle) menuToggle.setAttribute('aria-expanded', 'true');
        body.classList.add('menu-open');
        
        // Force page padding if not scrolled
        const pageElement = document.getElementById('page');
        if (pageElement) {
            if (!isScrolled) {
                // Disable transition first
                pageElement.style.setProperty('transition', 'none', 'important');
                // Force reflow to ensure transition is disabled
                pageElement.offsetHeight;
                // Now set padding-top
                const bannerVisible = isBannerVisible();
                const paddingValue = (bannerVisible && topBanner && !topBanner.classList.contains('menu-collapsed')) ? '131px' : '68px';
                pageElement.style.setProperty('padding-top', paddingValue, 'important');
                // Force another reflow to ensure padding is applied
                pageElement.offsetHeight;
                // Keep transition disabled - we don't need it for padding
            } else {
                // When scrolled, ensure padding-top is 0 on #page
                pageElement.style.setProperty('padding-top', '0', 'important');
            }
        }
        
        // Set body padding-top when scrolled
        if (isScrolled) {
            // Disable transition first
            body.style.setProperty('transition', 'none', 'important');
            // Force reflow to ensure transition is disabled
            body.offsetHeight;
            // Set padding-top to 66px when scrolled
            body.style.setProperty('padding-top', '66px', 'important');
            // Force another reflow to ensure padding is applied
            body.offsetHeight;
            // Keep transition disabled - we don't need it for padding
        } else {
            // When at top, ensure body padding-top is 0
            body.style.setProperty('padding-top', '0', 'important');
        }
        
        if (topBanner && bannerVisible && !isScrolled) {
            bannerWasCollapsed = true;
            topBanner.classList.add('menu-collapsed');
        } else {
            bannerWasCollapsed = false;
        }
    }
    
    function closeMenu() {
        
        // Remove body padding-top when menu closes
        body.style.setProperty('padding-top', '0', 'important');
        
        // Remove #page padding-top when menu closes
        const pageElement = document.getElementById('page');
        if (pageElement) {
            pageElement.style.setProperty('padding-top', '0', 'important');
        }
        
        if (navButtonsContainer) {
            navButtonsContainer.classList.remove('active');
            navButtonsContainer.style.paddingTop = '';
        }
        if (menuBackdrop) {
            menuBackdrop.classList.remove('active');
            menuBackdrop.style.opacity = '';
            menuBackdrop.style.visibility = '';
        }
        if (menuToggle) menuToggle.setAttribute('aria-expanded', 'false');
        body.classList.remove('menu-open');
        
        if (topBanner && bannerWasCollapsed) {
            topBanner.classList.remove('menu-collapsed');
            bannerWasCollapsed = false;
        }
    }
    
    if (menuToggle && navButtonsContainer) {
        menuToggle.addEventListener('click', function() {
            const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
            if (isExpanded) {
                closeMenu();
            } else {
                openMenu();
            }
        });

        if (menuBackdrop) {
            menuBackdrop.addEventListener('click', function() {
                closeMenu();
            });
        }

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            if (navButtonsContainer && navButtonsContainer.classList.contains('active')) {
                if (!menuToggle.contains(event.target) && 
                    !navButtonsContainer.contains(event.target) && 
                    !menuBackdrop.contains(event.target)) {
                    closeMenu();
                }
            }
        });

        // Close menu on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && navButtonsContainer && navButtonsContainer.classList.contains('active')) {
                closeMenu();
            }
        });
    }

    navArrows.forEach(function(arrow) {
        arrow.addEventListener('click', function() {
            const slider = this.closest('.section-header')?.nextElementSibling;
            if (!slider) return;

            const cards = slider.querySelectorAll('.testimonial-card, .faq-card');
            if (cards.length === 0) return;

            const isNext = this.classList.contains('nav-next');
            const scrollAmount = slider.offsetWidth;
            const currentScroll = slider.scrollLeft || 0;
            const newScroll = isNext 
                ? currentScroll + scrollAmount 
                : currentScroll - scrollAmount;

            slider.scrollTo({
                left: newScroll,
                behavior: 'smooth'
            });
        });
    });

    const propertyCards = document.querySelectorAll('.property-card');
    propertyCards.forEach(function(card) {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    const featureCards = document.querySelectorAll('.feature-card');
    featureCards.forEach(function(card) {
        card.addEventListener('click', function() {
            const link = this.querySelector('.feature-link');
            if (link && link.href) {
                window.location.href = link.href;
            }
        });
    });

    const forms = document.querySelectorAll('form');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                const firstInvalid = form.querySelector(':invalid');
                if (firstInvalid) {
                    firstInvalid.focus();
                    firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
    });

    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    const animatedElements = document.querySelectorAll('.property-card, .testimonial-card, .faq-card, .feature-card');
    animatedElements.forEach(function(el) {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });

    window.addEventListener('load', function() {
        document.body.classList.add('loaded');
    });

    // Properties Slider
    (function initPropertiesSlider() {
        const sliderWrapper = document.querySelector('.properties-slider-wrapper');
        if (!sliderWrapper) {
            return;
        }

        const slider = sliderWrapper.querySelector('.properties-slider');
        if (!slider) {
            return;
        }

        const track = slider.querySelector('.properties-slider-track');
        if (!track) {
            return;
        }

        const prevBtn = sliderWrapper.querySelector('.nav-prev');
        const nextBtn = sliderWrapper.querySelector('.nav-next');
        const currentSlideEl = sliderWrapper.querySelector('.pagination-current');
        const postsPerSlide = parseInt(slider.dataset.postsPerSlide) || 3;
        let currentSlide = parseInt(slider.dataset.currentSlide) || 1;

        const slides = track.querySelectorAll('.properties-slide');
        const cards = track.querySelectorAll('.property-card');
        
        // Detect mobile mode and calculate total slides accordingly
        function isMobile() {
            return window.innerWidth <= 1024;
        }
        
        function getTotalSlides() {
            if (isMobile()) {
                // In mobile, each card is its own slide
                return cards.length;
            } else {
                // In desktop, use the server-calculated total slides
                return parseInt(slider.dataset.totalSlides) || 1;
            }
        }
        
        let totalSlides = getTotalSlides();

        // Set track width based on number of slides
        function initializeTrack() {
            const sliderWidth = slider.offsetWidth;
            const slides = track.querySelectorAll('.properties-slide');
            // Recalculate cards for mobile
            const currentCards = isMobile() ? track.querySelectorAll('.property-card') : cards;
            totalSlides = getTotalSlides();
            
            if (sliderWidth > 0) {
                if (isMobile()) {
                    // In mobile, each card is its own slide
                    // Calculate total width needed for all cards
                    track.style.width = `${currentCards.length * sliderWidth}px`;
                    
                    // Make each card take full width
                    currentCards.forEach((card) => {
                        card.style.width = `${sliderWidth}px`;
                        card.style.minWidth = `${sliderWidth}px`;
                        card.style.maxWidth = `${sliderWidth}px`;
                        card.style.flexShrink = '0';
                        card.style.position = 'relative';
                        card.style.left = 'auto';
                    });
                    
                    // Make slides width based on their card count and position them
                    slides.forEach((slide) => {
                        const cardsInSlide = slide.querySelectorAll('.property-card');
                        const slideWidth = cardsInSlide.length * sliderWidth;
                        slide.style.width = `${slideWidth}px`;
                        slide.style.minWidth = `${slideWidth}px`;
                        slide.style.maxWidth = `${slideWidth}px`;
                        slide.style.display = 'flex';
                        slide.style.flexDirection = 'row';
                        slide.style.flexShrink = '0';
                        slide.style.position = 'relative';
                    });
                } else {
                    // In desktop, use grouped slides
                    track.style.width = `${totalSlides * sliderWidth}px`;
                    
                    // Reset card styles for desktop
                    currentCards.forEach((card) => {
                        card.style.width = '';
                        card.style.minWidth = '';
                        card.style.maxWidth = '';
                        card.style.position = '';
                        card.style.left = '';
                    });
                    
                    // Ensure each slide is exactly the slider width
                    slides.forEach((slide) => {
                        slide.style.width = `${sliderWidth}px`;
                        slide.style.minWidth = `${sliderWidth}px`;
                        slide.style.maxWidth = `${sliderWidth}px`;
                        slide.style.display = '';
                        slide.style.flexDirection = '';
                        slide.style.position = '';
                    });
                }
            }
            
        }

        function updateSlider() {
            const sliderWidth = slider.offsetWidth;
            if (sliderWidth === 0) {
                // Slider not ready yet, try again
                setTimeout(updateSlider, 100);
                return;
            }
            
            totalSlides = getTotalSlides();
            
            // Recalculate cards for mobile
            const currentCards = isMobile() ? track.querySelectorAll('.property-card') : cards;
            
            // Calculate translateX in pixels
            let translateX = -(currentSlide - 1) * sliderWidth;
            
            // Ensure we don't go beyond the track width
            if (isMobile()) {
                const maxTranslate = -(currentCards.length - 1) * sliderWidth;
                if (translateX < maxTranslate) {
                    translateX = maxTranslate;
                }
                // Also ensure currentSlide doesn't exceed card count
                if (currentSlide > currentCards.length) {
                    currentSlide = currentCards.length;
                    translateX = -(currentSlide - 1) * sliderWidth;
                }
            }
            
            track.style.transform = `translateX(${translateX}px)`;
            track.style.transition = 'transform 0.5s ease';

            // Update pagination
            if (currentSlideEl) {
                currentSlideEl.textContent = String(currentSlide).padStart(2, '0');
            }
            
            // Update pagination total
            const totalSlidesEl = sliderWrapper.querySelector('.pagination-total');
            if (totalSlidesEl) {
                totalSlidesEl.textContent = String(totalSlides).padStart(2, '0');
            }

            // Update button states
            if (prevBtn) {
                prevBtn.disabled = currentSlide === 1;
            }
            if (nextBtn) {
                nextBtn.disabled = currentSlide >= totalSlides;
            }

            // Update data attribute
            slider.dataset.currentSlide = currentSlide;
        }

        function goToSlide(slide) {
            if (slide < 1 || slide > totalSlides) return;
            currentSlide = slide;
            updateSlider();
        }

        function nextSlide() {
            if (currentSlide < totalSlides) {
                goToSlide(currentSlide + 1);
            }
        }

        function prevSlide() {
            if (currentSlide > 1) {
                goToSlide(currentSlide - 1);
            }
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', function(e) {
                e.preventDefault();
                prevSlide();
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', function(e) {
                e.preventDefault();
                nextSlide();
            });
        }

        // Store previous mobile state for comparison
        let previousMobileState = isMobile();
        
        // Initialize on load and resize
        function handleResize() {
            const currentMobileState = isMobile();
            
            // Force complete re-initialization
            initializeTrack();
            
            // Force a reflow to ensure styles are applied before calculating positions
            track.offsetHeight;
            
            // Recalculate total slides after track initialization
            totalSlides = getTotalSlides();
            
            // Reset to first slide if switching between mobile/desktop
            if (previousMobileState !== currentMobileState) {
                currentSlide = 1;
            }
            
            // Update previous state for next comparison
            previousMobileState = currentMobileState;
            
            // Ensure currentSlide is valid for new layout
            if (currentSlide > totalSlides) {
                currentSlide = totalSlides;
            }
            if (currentSlide < 1) {
                currentSlide = 1;
            }
            
            // Small delay to ensure browser has applied style changes, then update
            setTimeout(function() {
                updateSlider();
            }, 10);
            
        }

        // Initialize
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(handleResize, 100);
            });
        } else {
            setTimeout(handleResize, 100);
        }

        window.addEventListener('resize', function() {
            clearTimeout(window.resizeTimeout);
            window.resizeTimeout = setTimeout(function() {
                handleResize();
            }, 250);
        });

        // Keyboard navigation
        slider.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft') {
                e.preventDefault();
                prevSlide();
            } else if (e.key === 'ArrowRight') {
                e.preventDefault();
                nextSlide();
            }
        });

        // Touch/swipe support
        let startX = 0;
        let currentX = 0;
        let isDragging = false;

        track.addEventListener('touchstart', function(e) {
            startX = e.touches[0].clientX;
            isDragging = true;
        }, { passive: true });

        track.addEventListener('touchmove', function(e) {
            if (!isDragging) return;
            currentX = e.touches[0].clientX;
        }, { passive: true });

        track.addEventListener('touchend', function() {
            if (!isDragging) return;
            isDragging = false;
            const diffX = startX - currentX;
            const threshold = 50;

            if (Math.abs(diffX) > threshold) {
                if (diffX > 0) {
                    nextSlide();
                } else {
                    prevSlide();
                }
            }
        }, { passive: true });
    })();
    // #endregion

    // #region Testimonials Slider
    (function initTestimonialsSlider() {
        const sliderWrapper = document.querySelector('.testimonials-slider-wrapper');
        if (!sliderWrapper) return;

        const slider = sliderWrapper.querySelector('.testimonials-slider');
        if (!slider) return;

        const track = slider.querySelector('.testimonials-slider-track');
        if (!track) return;

        const prevBtn = sliderWrapper.querySelector('.nav-prev');
        const nextBtn = sliderWrapper.querySelector('.nav-next');
        const currentSlideEl = sliderWrapper.querySelector('.pagination-current');
        const testimonialsPerSlide = parseInt(slider.dataset.testimonialsPerSlide) || 3;
        let currentSlide = parseInt(slider.dataset.currentSlide) || 1;

        const slides = track.querySelectorAll('.testimonials-slide');
        const cards = track.querySelectorAll('.testimonial-card');
        
        // Detect mobile mode and calculate total slides accordingly
        function isMobile() {
            return window.innerWidth <= 1024;
        }
        
        function getTotalSlides() {
            if (isMobile()) {
                // In mobile, each card is its own slide
                // Recalculate cards to ensure we have the latest count
                const currentCards = track.querySelectorAll('.testimonial-card');
                return currentCards.length > 0 ? currentCards.length : 1;
            } else {
                // In desktop, use the server-calculated total slides
                return parseInt(slider.dataset.totalSlides) || 1;
            }
        }
        
        let totalSlides = getTotalSlides();

        // Set track width based on number of slides
        function initializeTrack() {
            const sliderWidth = slider.offsetWidth;
            // Recalculate cards for mobile
            const currentCards = isMobile() ? track.querySelectorAll('.testimonial-card') : cards;
            totalSlides = getTotalSlides();
            
            if (sliderWidth > 0) {
                if (isMobile()) {
                    // In mobile, restructure: each card gets its own slide position
                    // Calculate total width needed for all cards
                    track.style.width = `${currentCards.length * sliderWidth}px`;
                    
                    // Position each card at its own slide position
                    slides.forEach((slide, slideIndex) => {
                        const cardsInSlide = slide.querySelectorAll('.testimonial-card');
                        
                        // Set slide width to accommodate all its cards
                        const slideWidth = cardsInSlide.length * sliderWidth;
                        slide.style.width = `${slideWidth}px`;
                        slide.style.minWidth = `${slideWidth}px`;
                        slide.style.maxWidth = `${slideWidth}px`;
                        slide.style.display = 'flex';
                        slide.style.flexDirection = 'row';
                        slide.style.flexShrink = '0';
                        slide.style.overflow = 'visible';
                        slide.style.position = 'relative';
                        
                        // Position each card - they flow naturally in flex
                        cardsInSlide.forEach((card, cardIndex) => {
                            card.style.width = `${sliderWidth}px`;
                            card.style.minWidth = `${sliderWidth}px`;
                            card.style.maxWidth = `${sliderWidth}px`;
                            card.style.flexShrink = '0';
                            card.style.display = 'flex';
                            card.style.visibility = 'visible';
                        });
                    });
                } else {
                    // In desktop, use grouped slides
                    track.style.width = `${totalSlides * sliderWidth}px`;
                    
                    // Reset card styles for desktop (clear mobile-specific styles)
                    currentCards.forEach((card) => {
                        card.style.width = '';
                        card.style.minWidth = '';
                        card.style.maxWidth = '';
                        card.style.flexShrink = '';
                        card.style.display = '';
                        card.style.visibility = '';
                        card.style.position = '';
                        card.style.left = '';
                    });
                    
                    // Ensure each slide is exactly the slider width and reset mobile styles
                    slides.forEach((slide) => {
                        slide.style.width = `${sliderWidth}px`;
                        slide.style.minWidth = `${sliderWidth}px`;
                        slide.style.maxWidth = `${sliderWidth}px`;
                        slide.style.display = '';
                        slide.style.flexDirection = '';
                        slide.style.overflow = '';
                        slide.style.position = '';
                    });
                }
            } else {
                setTimeout(initializeTrack, 100); // Retry if sliderWidth is 0
            }
        }

        function updateSlider() {
            const sliderWidth = slider.offsetWidth;
            if (sliderWidth === 0) {
                setTimeout(updateSlider, 100); // Slider not ready yet, try again
                return;
            }
            
            totalSlides = getTotalSlides();
            
            // Recalculate cards for mobile
            const currentCards = isMobile() ? track.querySelectorAll('.testimonial-card') : cards;
            
            // Calculate translateX in pixels
            let translateX = -(currentSlide - 1) * sliderWidth;
            
            // Ensure we don't go beyond the track width
            if (isMobile()) {
                // In mobile, calculate translateX based on card index and slide structure
                let cardIndexToShow = currentSlide - 1; // 0-based card index
                let cardsProcessed = 0;
                let targetSlideIndex = -1;
                let cardOffsetInSlide = 0;
                
                // Find which slide contains the target card and the card's offset within that slide
                slides.forEach((slide, slideIndex) => {
                    const cardsInSlide = slide.querySelectorAll('.testimonial-card');
                    if (cardIndexToShow >= cardsProcessed && cardIndexToShow < cardsProcessed + cardsInSlide.length) {
                        targetSlideIndex = slideIndex;
                        cardOffsetInSlide = cardIndexToShow - cardsProcessed;
                    }
                    cardsProcessed += cardsInSlide.length;
                });
                
                // Calculate translateX: move to the slide, then offset by the card position within the slide
                // Each slide is cardsInSlide.length * sliderWidth wide
                let slideOffset = 0;
                cardsProcessed = 0;
                slides.forEach((slide, slideIndex) => {
                    if (slideIndex < targetSlideIndex) {
                        const cardsInSlide = slide.querySelectorAll('.testimonial-card');
                        slideOffset += cardsInSlide.length * sliderWidth;
                        cardsProcessed += cardsInSlide.length;
                    }
                });
                
                // translateX = slide position + card offset within slide
                translateX = -(slideOffset + cardOffsetInSlide * sliderWidth);
                
                const maxTranslate = -(currentCards.length - 1) * sliderWidth;
                if (translateX < maxTranslate) {
                    translateX = maxTranslate;
                }
                // Also ensure currentSlide doesn't exceed card count
                if (currentSlide > currentCards.length) {
                    currentSlide = currentCards.length;
                    translateX = -(currentSlide - 1) * sliderWidth;
                }
            }
            
            track.style.transform = `translateX(${translateX}px)`;
            track.style.transition = 'transform 0.5s ease';

            // Update pagination
            if (currentSlideEl) {
                currentSlideEl.textContent = String(currentSlide).padStart(2, '0');
            }
            
            // Update pagination total
            const totalSlidesEl = sliderWrapper.querySelector('.pagination-total');
            if (totalSlidesEl) {
                totalSlidesEl.textContent = String(totalSlides).padStart(2, '0');
            }

            // Update button states
            if (prevBtn) {
                prevBtn.disabled = currentSlide === 1;
            }
            if (nextBtn) {
                nextBtn.disabled = currentSlide >= totalSlides;
            }

            // Update data attribute
            slider.dataset.currentSlide = currentSlide;
        }

        function goToSlide(slide) {
            if (slide < 1 || slide > totalSlides) return;
            currentSlide = slide;
            updateSlider();
        }

        function nextSlide() {
            if (currentSlide < totalSlides) {
                goToSlide(currentSlide + 1);
            }
        }

        function prevSlide() {
            if (currentSlide > 1) {
                goToSlide(currentSlide - 1);
            }
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', function(e) {
                e.preventDefault();
                prevSlide();
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', function(e) {
                e.preventDefault();
                nextSlide();
            });
        }

        // Store previous mobile state for comparison
        let previousMobileState = isMobile();
        
        // Initialize on load and resize
        function handleResize() {
            const currentMobileState = isMobile();
            
            // Force complete re-initialization
            initializeTrack();
            
            // Force a reflow to ensure styles are applied before calculating positions
            track.offsetHeight;
            
            // Recalculate total slides after track initialization
            totalSlides = getTotalSlides();
            
            // Reset to first slide if switching between mobile/desktop
            if (previousMobileState !== currentMobileState) {
                currentSlide = 1;
            }
            
            // Update previous state for next comparison
            previousMobileState = currentMobileState;
            
            // Ensure currentSlide is valid for new layout
            if (currentSlide > totalSlides) {
                currentSlide = totalSlides;
            }
            if (currentSlide < 1) {
                currentSlide = 1;
            }
            
            // Small delay to ensure browser has applied style changes, then update
            setTimeout(function() {
                updateSlider();
            }, 10);
            
        }

        // Initialize
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(handleResize, 100);
            });
        } else {
            setTimeout(handleResize, 100);
        }

        window.addEventListener('resize', function() {
            clearTimeout(window.testimonialsResizeTimeout);
            window.testimonialsResizeTimeout = setTimeout(function() {
                handleResize();
            }, 250);
        });

        // Keyboard navigation
        slider.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft') {
                e.preventDefault();
                prevSlide();
            } else if (e.key === 'ArrowRight') {
                e.preventDefault();
                nextSlide();
            }
        });

        // Touch/swipe support
        let startX = 0;
        let currentX = 0;
        let isDragging = false;

        track.addEventListener('touchstart', function(e) {
            startX = e.touches[0].clientX;
            isDragging = true;
        }, { passive: true });

        track.addEventListener('touchmove', function(e) {
            if (!isDragging) return;
            currentX = e.touches[0].clientX;
        }, { passive: true });

        track.addEventListener('touchend', function() {
            if (!isDragging) return;
            isDragging = false;
            const diffX = startX - currentX;
            const threshold = 50;

            if (Math.abs(diffX) > threshold) {
                if (diffX > 0) {
                    nextSlide();
                } else {
                    prevSlide();
                }
            }
        }, { passive: true });
    })();
    // #endregion

    // FAQs Slider
    (function initFaqsSlider() {
        const sliderWrapper = document.querySelector('.faqs-slider-wrapper');
        if (!sliderWrapper) return;

        const slider = sliderWrapper.querySelector('.faqs-slider');
        if (!slider) return;

        const track = slider.querySelector('.faqs-slider-track');
        if (!track) return;

        const prevBtn = sliderWrapper.querySelector('.nav-prev');
        const nextBtn = sliderWrapper.querySelector('.nav-next');
        const currentSlideEl = sliderWrapper.querySelector('.pagination-current');
        const faqsPerSlide = parseInt(slider.dataset.faqsPerSlide) || 3;
        let currentSlide = parseInt(slider.dataset.currentSlide) || 1;

        const slides = track.querySelectorAll('.faqs-slide');
        const cards = track.querySelectorAll('.faq-card');
        
        // Detect mobile mode and calculate total slides accordingly
        function isMobile() {
            return window.innerWidth <= 1024;
        }
        
        function getTotalSlides() {
            if (isMobile()) {
                // In mobile, each card is its own slide
                // Recalculate cards to ensure we have the latest count
                const currentCards = track.querySelectorAll('.faq-card');
                return currentCards.length > 0 ? currentCards.length : 1;
            } else {
                // In desktop, use the server-calculated total slides
                return parseInt(slider.dataset.totalSlides) || 1;
            }
        }
        
        let totalSlides = getTotalSlides();

        // Set track width based on number of slides
        function initializeTrack() {
            const sliderWidth = slider.offsetWidth;
            // Recalculate cards for mobile
            const currentCards = isMobile() ? track.querySelectorAll('.faq-card') : cards;
            totalSlides = getTotalSlides();
            
            if (sliderWidth > 0) {
                if (isMobile()) {
                    // In mobile, keep slides in flex layout but ensure cards are positioned correctly
                    // Calculate total width needed for all cards plus gaps
                    const gapSize = 20; // Gap between FAQ cards
                    let totalTrackWidth = 0;
                    slides.forEach((slide) => {
                        const cardsInSlide = slide.querySelectorAll('.faq-card');
                        totalTrackWidth += cardsInSlide.length * sliderWidth + (cardsInSlide.length - 1) * gapSize;
                    });
                    track.style.width = `${totalTrackWidth}px`;
                    
                    // Position each card at its own slide position
                    slides.forEach((slide, slideIndex) => {
                        const cardsInSlide = slide.querySelectorAll('.faq-card');
                        
                        // Set slide width to accommodate all its cards plus gaps
                        // Each card is sliderWidth wide, with gapSize gap between them
                        const slideWidth = cardsInSlide.length * sliderWidth + (cardsInSlide.length - 1) * gapSize;
                        slide.style.width = `${slideWidth}px`;
                        slide.style.minWidth = `${slideWidth}px`;
                        slide.style.maxWidth = `${slideWidth}px`;
                        slide.style.display = 'flex';
                        slide.style.flexDirection = 'row';
                        slide.style.flexShrink = '0';
                        slide.style.overflow = 'visible';
                        slide.style.position = 'relative';
                        
                        // Position each card - they flow naturally in flex
                        cardsInSlide.forEach((card, cardIndex) => {
                            card.style.width = `${sliderWidth}px`;
                            card.style.minWidth = `${sliderWidth}px`;
                            card.style.maxWidth = `${sliderWidth}px`;
                            card.style.flexShrink = '0';
                            card.style.display = 'flex';
                            card.style.visibility = 'visible';
                        });
                    });
                } else {
                    // In desktop, use grouped slides
                    track.style.width = `${totalSlides * sliderWidth}px`;
                    
                    // Reset card styles for desktop (clear mobile-specific styles)
                    currentCards.forEach((card) => {
                        card.style.width = '';
                        card.style.minWidth = '';
                        card.style.maxWidth = '';
                        card.style.flexShrink = '';
                        card.style.display = '';
                        card.style.visibility = '';
                        card.style.position = '';
                        card.style.left = '';
                    });
                    
                    // Ensure each slide is exactly the slider width and reset mobile styles
                    slides.forEach((slide) => {
                        slide.style.width = `${sliderWidth}px`;
                        slide.style.minWidth = `${sliderWidth}px`;
                        slide.style.maxWidth = `${sliderWidth}px`;
                        slide.style.display = '';
                        slide.style.flexDirection = '';
                        slide.style.overflow = '';
                        slide.style.position = '';
                    });
                }
            } else {
                setTimeout(initializeTrack, 100); // Retry if sliderWidth is 0
            }
        }

        function updateSlider() {
            const sliderWidth = slider.offsetWidth;
            if (sliderWidth === 0) {
                setTimeout(updateSlider, 100); // Slider not ready yet, try again
                return;
            }
            
            totalSlides = getTotalSlides();
            
            // Recalculate cards for mobile
            const currentCards = isMobile() ? track.querySelectorAll('.faq-card') : cards;
            
            // Calculate translateX in pixels
            let translateX = -(currentSlide - 1) * sliderWidth;
            
            // Ensure we don't go beyond the track width
            if (isMobile()) {
                // In mobile, calculate translateX based on card index and slide structure
                const gapSize = 20; // Gap between FAQ cards - declare once for this block
                let cardIndexToShow = currentSlide - 1; // 0-based card index
                let cardsProcessed = 0;
                let targetSlideIndex = -1;
                let cardOffsetInSlide = 0;
                
                // Find which slide contains the target card and the card's offset within that slide
                slides.forEach((slide, slideIndex) => {
                    const cardsInSlide = slide.querySelectorAll('.faq-card');
                    if (cardIndexToShow >= cardsProcessed && cardIndexToShow < cardsProcessed + cardsInSlide.length) {
                        targetSlideIndex = slideIndex;
                        cardOffsetInSlide = cardIndexToShow - cardsProcessed;
                    }
                    cardsProcessed += cardsInSlide.length;
                });
                
                // Calculate translateX: move to the slide, then offset by the card position within the slide
                // Each slide is (cardsInSlide.length * sliderWidth + (cardsInSlide.length - 1) * gapSize) wide
                let slideOffset = 0;
                cardsProcessed = 0;
                slides.forEach((slide, slideIndex) => {
                    if (slideIndex < targetSlideIndex) {
                        const cardsInSlide = slide.querySelectorAll('.faq-card');
                        // Slide width = cards * sliderWidth + gaps between cards
                        slideOffset += cardsInSlide.length * sliderWidth + (cardsInSlide.length - 1) * gapSize;
                        cardsProcessed += cardsInSlide.length;
                    }
                });
                
                // translateX = slide position + card offset within slide (including gaps)
                // Card offset = cardIndex * (sliderWidth + gapSize)
                const cardOffset = cardOffsetInSlide * (sliderWidth + gapSize);
                // Center the card in the viewport
                // Card center should be at viewport center: window.innerWidth / 2
                // Card left in viewport = card center - sliderWidth/2 = window.innerWidth/2 - sliderWidth/2
                // Card left in track coordinates (before translation) = slideOffset + cardOffset
                // After translation, card left in viewport = wrapperLeft + slideOffset + cardOffset + translateX
                // So: wrapperLeft + slideOffset + cardOffset + translateX + sliderWidth/2 = window.innerWidth/2
                // Solving for translateX: translateX = window.innerWidth/2 - sliderWidth/2 - wrapperLeft - slideOffset - cardOffset
                const wrapperLeft = sliderWrapper.getBoundingClientRect().left;
                translateX = window.innerWidth / 2 - sliderWidth / 2 - wrapperLeft - slideOffset - cardOffset;
                
                // Calculate maxTranslate accounting for gaps and centering
                // Max translate should allow the last card to be centered
                // gapSize is already declared above
                let totalTrackWidth = 0;
                slides.forEach((slide) => {
                    const cardsInSlide = slide.querySelectorAll('.faq-card');
                    totalTrackWidth += cardsInSlide.length * sliderWidth + (cardsInSlide.length - 1) * gapSize;
                });
                // Last card position in track = totalTrackWidth - sliderWidth
                // To center last card: translateX = window.innerWidth/2 - sliderWidth/2 - wrapperLeft - (totalTrackWidth - sliderWidth)
                const wrapperLeftForMax = sliderWrapper.getBoundingClientRect().left;
                const maxTranslate = window.innerWidth / 2 - sliderWidth / 2 - wrapperLeftForMax - (totalTrackWidth - sliderWidth);
                
                if (translateX < maxTranslate) {
                    translateX = maxTranslate;
                }
                // Also ensure currentSlide doesn't exceed card count
                if (currentSlide > currentCards.length) {
                    currentSlide = currentCards.length;
                    // Recalculate translateX for the last card using centering logic
                    const lastCardIndex = currentCards.length - 1;
                    let cardsProcessed = 0;
                    let lastSlideIndex = -1;
                    let lastCardOffsetInSlide = 0;
                    slides.forEach((slide, slideIndex) => {
                        const cardsInSlide = slide.querySelectorAll('.faq-card');
                        if (lastCardIndex >= cardsProcessed && lastCardIndex < cardsProcessed + cardsInSlide.length) {
                            lastSlideIndex = slideIndex;
                            lastCardOffsetInSlide = lastCardIndex - cardsProcessed;
                        }
                        cardsProcessed += cardsInSlide.length;
                    });
                    let lastSlideOffset = 0;
                    cardsProcessed = 0;
                    slides.forEach((slide, slideIndex) => {
                        if (slideIndex < lastSlideIndex) {
                            const cardsInSlide = slide.querySelectorAll('.faq-card');
                            lastSlideOffset += cardsInSlide.length * sliderWidth + (cardsInSlide.length - 1) * gapSize;
                            cardsProcessed += cardsInSlide.length;
                        }
                    });
                    const lastCardOffset = lastCardOffsetInSlide * (sliderWidth + gapSize);
                    translateX = window.innerWidth / 2 - sliderWidth / 2 - wrapperLeftForMax - lastSlideOffset - lastCardOffset;
                }
            }
            
            track.style.transform = `translateX(${translateX}px)`;
            track.style.transition = 'transform 0.5s ease';

            // Update pagination
            if (currentSlideEl) {
                currentSlideEl.textContent = String(currentSlide).padStart(2, '0');
            }
            
            // Update pagination total
            const totalSlidesEl = sliderWrapper.querySelector('.pagination-total');
            if (totalSlidesEl) {
                totalSlidesEl.textContent = String(totalSlides).padStart(2, '0');
            }

            // Update button states
            if (prevBtn) {
                prevBtn.disabled = currentSlide === 1;
            }
            if (nextBtn) {
                nextBtn.disabled = currentSlide >= totalSlides;
            }

            // Update data attribute
            slider.dataset.currentSlide = currentSlide;
        }

        function goToSlide(slide) {
            if (slide < 1 || slide > totalSlides) return;
            currentSlide = slide;
            updateSlider();
        }

        function nextSlide() {
            if (currentSlide < totalSlides) {
                goToSlide(currentSlide + 1);
            }
        }

        function prevSlide() {
            if (currentSlide > 1) {
                goToSlide(currentSlide - 1);
            }
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', function(e) {
                e.preventDefault();
                prevSlide();
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', function(e) {
                e.preventDefault();
                nextSlide();
            });
        }

        // Store previous mobile state for comparison
        let previousMobileState = isMobile();
        
        // Initialize on load and resize
        function handleResize() {
            const currentMobileState = isMobile();
            
            // Force complete re-initialization
            initializeTrack();
            
            // Force a reflow to ensure styles are applied before calculating positions
            track.offsetHeight;
            
            // Recalculate total slides after track initialization
            totalSlides = getTotalSlides();
            
            // Reset to first slide if switching between mobile/desktop
            if (previousMobileState !== currentMobileState) {
                currentSlide = 1;
            }
            
            // Update previous state for next comparison
            previousMobileState = currentMobileState;
            
            // Ensure currentSlide is valid for new layout
            if (currentSlide > totalSlides) {
                currentSlide = totalSlides;
            }
            if (currentSlide < 1) {
                currentSlide = 1;
            }
            
            // Small delay to ensure browser has applied style changes, then update
            setTimeout(function() {
                updateSlider();
            }, 10);
            
        }

        // Initialize
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(handleResize, 100);
            });
        } else {
            setTimeout(handleResize, 100);
        }

        window.addEventListener('resize', function() {
            clearTimeout(window.faqsResizeTimeout);
            window.faqsResizeTimeout = setTimeout(function() {
                handleResize();
            }, 250);
        });

        // Keyboard navigation
        slider.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft') {
                e.preventDefault();
                prevSlide();
            } else if (e.key === 'ArrowRight') {
                e.preventDefault();
                nextSlide();
            }
        });

        // Touch/swipe support
        let startX = 0;
        let currentX = 0;
        let isDragging = false;

        track.addEventListener('touchstart', function(e) {
            startX = e.touches[0].clientX;
            isDragging = true;
        }, { passive: true });

        track.addEventListener('touchmove', function(e) {
            if (!isDragging) return;
            currentX = e.touches[0].clientX;
        }, { passive: true });

        track.addEventListener('touchend', function() {
            if (!isDragging) return;
            isDragging = false;
            const diffX = startX - currentX;
            const threshold = 50;

            if (Math.abs(diffX) > threshold) {
                if (diffX > 0) {
                    nextSlide();
                } else {
                    prevSlide();
                }
            }
        }, { passive: true });
    })();
    // #endregion

})();

