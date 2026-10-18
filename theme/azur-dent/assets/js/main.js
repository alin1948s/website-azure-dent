(function () {
	'use strict';

	document.documentElement.classList.add('has-js');

	var prefersReducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	var config = window.azurDent || {};

	function normalizeText(str) {
		return String(str || '')
			.toLowerCase()
			.normalize('NFD')
			.replace(/[\u0300-\u036f]/g, '');
	}

	/* ==========================================================================
	   1. Mobile Navigation Menu
	   ========================================================================== */
	var menuToggle = document.querySelector('.menu-toggle');
	var navigation = document.getElementById('primary-navigation');

	function closeMenu() {
		if (!menuToggle || !navigation) return;
		menuToggle.setAttribute('aria-expanded', 'false');
		document.body.classList.remove('menu-is-open');
	}

	if (menuToggle && navigation) {
		menuToggle.addEventListener('click', function () {
			var isOpen = menuToggle.getAttribute('aria-expanded') === 'true';
			menuToggle.setAttribute('aria-expanded', String(!isOpen));
			document.body.classList.toggle('menu-is-open', !isOpen);
			if (!isOpen) {
				var firstLink = navigation.querySelector('a');
				if (firstLink && window.matchMedia('(max-width: 820px)').matches) firstLink.focus();
			}
		});
		navigation.addEventListener('click', function (event) {
			if (event.target.closest('a')) closeMenu();
		});
		document.addEventListener('keydown', function (event) {
			if (event.key === 'Escape') closeMenu();
		});
		window.addEventListener('resize', function () {
			if (window.matchMedia('(min-width: 821px)').matches) closeMenu();
		});
	}

	/* ==========================================================================
	   2. Sticky Header Scroll State, Progress Bar & Floating Quick Bar
	   ========================================================================== */
	var header = document.querySelector('[data-sticky-header]');
	var progressBar = document.querySelector('.site-header__progress-bar');
	var floatingBar = document.querySelector('[data-floating-bar]');
	var floatingCta = floatingBar && floatingBar.querySelector('.azur-floating-bar__cta');
	var isBookingPage = Boolean(document.querySelector('.azur-booking-form'));

	if (floatingCta && isBookingPage) {
		floatingCta.hidden = true;
	}

	function updateScrollUI() {
		var scrollY = window.scrollY || window.pageYOffset || 0;
		if (header) {
			header.classList.toggle('is-scrolled', scrollY > 20);
		}
		if (progressBar) {
			var docHeight = document.documentElement.scrollHeight - window.innerHeight;
			var progress = docHeight > 40 ? Math.min(100, Math.max(0, (scrollY / docHeight) * 100)) : 0;
			progressBar.style.width = progress.toFixed(1) + '%';
		}
		if (floatingBar) {
			floatingBar.hidden = scrollY < 320;
		}
	}

	window.addEventListener('scroll', updateScrollUI, { passive: true });
	updateScrollUI();

	document.querySelectorAll('[data-scroll-top]').forEach(function (button) {
		button.addEventListener('click', function () {
			window.scrollTo({
				top: 0,
				behavior: prefersReducedMotion ? 'auto' : 'smooth'
			});
		});
	});

	/* ==========================================================================
	   3. One-Click Clipboard Copy Buttons
	   ========================================================================== */
	function copyToClipboard(text) {
		if (navigator.clipboard && typeof navigator.clipboard.writeText === 'function') {
			return navigator.clipboard.writeText(text);
		}
		return new Promise(function (resolve, reject) {
			try {
				var area = document.createElement('textarea');
				area.value = text;
				area.style.position = 'fixed';
				area.style.opacity = '0';
				document.body.appendChild(area);
				area.select();
				document.execCommand('copy');
				document.body.removeChild(area);
				resolve();
			} catch (err) {
				reject(err);
			}
		});
	}

	document.querySelectorAll('[data-copy-text]').forEach(function (button) {
		var originalLabel = button.textContent;
		var timer = null;
		button.addEventListener('click', function () {
			var text = button.getAttribute('data-copy-text');
			if (!text) return;
			copyToClipboard(text).then(function () {
				if (timer) clearTimeout(timer);
				button.classList.add('is-copied');
				button.textContent = config.copied || 'Copiat ✓';
				timer = setTimeout(function () {
					button.classList.remove('is-copied');
					button.textContent = originalLabel;
				}, 2200);
			});
		});
	});

	/* ==========================================================================
	   4. Interactive Process Stepper (Home Page)
	   ========================================================================== */
	document.querySelectorAll('[data-process-stepper]').forEach(function (stepper) {
		var tabs = Array.prototype.slice.call(stepper.querySelectorAll('[data-step-target]'));
		var panels = Array.prototype.slice.call(stepper.querySelectorAll('[data-step-panel]'));
		if (!tabs.length || !panels.length) return;

		function activateStep(index) {
			tabs.forEach(function (tab, i) {
				var active = i === index;
				tab.classList.toggle('is-active', active);
				tab.setAttribute('aria-selected', String(active));
			});
			panels.forEach(function (panel, i) {
				var active = i === index;
				panel.classList.toggle('is-active', active);
				panel.hidden = !active;
			});
		}

		tabs.forEach(function (tab, index) {
			tab.addEventListener('click', function () {
				activateStep(index);
			});
			tab.addEventListener('keydown', function (event) {
				if (event.key === 'ArrowRight') {
					event.preventDefault();
					var next = (index + 1) % tabs.length;
					tabs[next].focus();
					activateStep(next);
				} else if (event.key === 'ArrowLeft') {
					event.preventDefault();
					var prev = (index - 1 + tabs.length) % tabs.length;
					tabs[prev].focus();
					activateStep(prev);
				}
			});
		});
	});

	/* ==========================================================================
	   5. Interactive Services Filter & Live Search (Services Page)
	   ========================================================================== */
	var serviceRows = Array.prototype.slice.call(document.querySelectorAll('.azur-service-row'));
	var serviceFilterButtons = Array.prototype.slice.call(document.querySelectorAll('.azur-services-toolbar .azur-filter-pill'));
	var serviceSearchInput = document.querySelector('[data-service-search]');
	var serviceCountEl = document.querySelector('[data-service-count]');
	var serviceEmptyEl = document.querySelector('[data-services-empty]');
	var activeServiceCategory = 'all';

	function filterServices() {
		if (!serviceRows.length) return;
		var query = serviceSearchInput ? normalizeText(serviceSearchInput.value.trim()) : '';
		var visibleCount = 0;

		serviceRows.forEach(function (row) {
			var matchesCategory = activeServiceCategory === 'all' || row.classList.contains('azur-service-cat-' + activeServiceCategory);
			var textContent = normalizeText(row.textContent);
			var matchesSearch = !query || textContent.indexOf(query) !== -1;
			var isVisible = matchesCategory && matchesSearch;
			row.hidden = !isVisible;
			if (isVisible) visibleCount++;
		});

		if (serviceCountEl) {
			serviceCountEl.textContent = visibleCount === 1 ? '1 categorie' : visibleCount + ' categorii';
		}
		if (serviceEmptyEl) {
			serviceEmptyEl.hidden = visibleCount > 0;
		}
	}

	if (serviceFilterButtons.length) {
		serviceFilterButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				activeServiceCategory = button.getAttribute('data-filter') || 'all';
				serviceFilterButtons.forEach(function (btn) {
					btn.classList.toggle('is-active', btn === button);
				});
				filterServices();
			});
		});
	}

	if (serviceSearchInput) {
		serviceSearchInput.addEventListener('input', filterServices);
	}

	/* ==========================================================================
	   6. Interactive Gallery Filter & Enhanced Lightbox
	   ========================================================================== */
	var galleryFilterWrap = document.querySelector('[data-gallery-filter]');
	var galleryItems = Array.prototype.slice.call(document.querySelectorAll('.azur-gallery .azur-gallery__item'));

	if (galleryFilterWrap && galleryItems.length) {
		var galleryButtons = Array.prototype.slice.call(galleryFilterWrap.querySelectorAll('.azur-filter-pill'));
		galleryButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				var filter = button.getAttribute('data-filter') || 'all';
				galleryButtons.forEach(function (btn) {
					btn.classList.toggle('is-active', btn === button);
				});
				galleryItems.forEach(function (item) {
					var show = filter === 'all' || item.classList.contains('azur-gallery__cat-' + filter);
					item.hidden = !show;
				});
			});
		});
	}

	var allGalleryLinks = Array.prototype.slice.call(document.querySelectorAll('a[data-azur-lightbox]'));
	var lightbox = document.querySelector('.azur-lightbox');
	var lightboxImage = lightbox && lightbox.querySelector('.azur-lightbox__image');
	var lightboxCaption = lightbox && lightbox.querySelector('.azur-lightbox__caption');
	var lightboxCounter = lightbox && lightbox.querySelector('.azur-lightbox__counter');
	var lightboxDots = lightbox && lightbox.querySelector('.azur-lightbox__dots');
	var currentImage = 0;

	function getVisibleGalleryLinks() {
		return allGalleryLinks.filter(function (link) {
			var figure = link.closest('figure');
			return !figure || !figure.hidden;
		});
	}

	function renderLightboxDots(links) {
		if (!lightboxDots) return;
		lightboxDots.replaceChildren();
		if (links.length <= 1) return;
		links.forEach(function (_, idx) {
			var dot = document.createElement('button');
			dot.type = 'button';
			dot.className = 'azur-lightbox__dot' + (idx === currentImage ? ' is-active' : '');
			dot.setAttribute('aria-label', 'Imaginea ' + (idx + 1));
			dot.addEventListener('click', function () {
				showGalleryImage(idx);
			});
			lightboxDots.appendChild(dot);
		});
	}

	function showGalleryImage(index) {
		var links = getVisibleGalleryLinks();
		if (!links.length || !lightboxImage) return;
		currentImage = (index + links.length) % links.length;
		var link = links[currentImage];
		var sourceImage = link.querySelector('img');
		var figure = link.closest('figure');
		var caption = figure ? figure.querySelector('figcaption') : null;
		lightboxImage.src = link.href;
		lightboxImage.alt = sourceImage ? sourceImage.alt : '';
		if (lightboxCaption) {
			lightboxCaption.textContent = caption ? caption.textContent : (sourceImage ? sourceImage.alt : '');
		}
		if (lightboxCounter) {
			lightboxCounter.textContent = (currentImage + 1) + ' / ' + links.length;
		}
		renderLightboxDots(links);
	}

	if (allGalleryLinks.length && lightbox && lightboxImage && typeof lightbox.showModal === 'function') {
		allGalleryLinks.forEach(function (link) {
			link.addEventListener('click', function (event) {
				event.preventDefault();
				var visibleLinks = getVisibleGalleryLinks();
				var idx = visibleLinks.indexOf(link);
				showGalleryImage(idx >= 0 ? idx : 0);
				lightbox.showModal();
				var closeButton = lightbox.querySelector('.azur-lightbox__close');
				if (closeButton) closeButton.focus();
			});
		});
		var closeButton = lightbox.querySelector('.azur-lightbox__close');
		var previousButton = lightbox.querySelector('.azur-lightbox__nav--previous');
		var nextButton = lightbox.querySelector('.azur-lightbox__nav--next');
		if (closeButton) closeButton.addEventListener('click', function () { lightbox.close(); });
		if (previousButton) previousButton.addEventListener('click', function () { showGalleryImage(currentImage - 1); });
		if (nextButton) nextButton.addEventListener('click', function () { showGalleryImage(currentImage + 1); });
		lightbox.addEventListener('click', function (event) {
			if (event.target === lightbox) lightbox.close();
		});
		lightbox.addEventListener('keydown', function (event) {
			if (event.key === 'ArrowLeft') showGalleryImage(currentImage - 1);
			if (event.key === 'ArrowRight') showGalleryImage(currentImage + 1);
		});
		var startX = null;
		lightboxImage.addEventListener('touchstart', function (event) {
			if (event.touches.length === 1) startX = event.touches[0].clientX;
		}, { passive: true });
		lightboxImage.addEventListener('touchend', function (event) {
			if (startX === null || !event.changedTouches.length) return;
			var distance = event.changedTouches[0].clientX - startX;
			if (Math.abs(distance) > 45) showGalleryImage(currentImage + (distance < 0 ? 1 : -1));
			startX = null;
		}, { passive: true });
	}

	/* ==========================================================================
	   7. Interactive FAQ Toggle-All Control
	   ========================================================================== */
	document.querySelectorAll('[data-faq-toggle-all]').forEach(function (toggleBtn) {
		var section = toggleBtn.closest('.azur-home-faq, .azur-faq') || document;
		var detailsList = Array.prototype.slice.call(section.querySelectorAll('.azur-faq-list details'));
		if (!detailsList.length) return;

		function syncFaqButton() {
			var allOpen = detailsList.every(function (d) { return d.open; });
			toggleBtn.setAttribute('aria-expanded', String(allOpen));
			toggleBtn.textContent = allOpen ? 'Ascunde răspunsurile' : 'Afișează toate răspunsurile';
		}

		toggleBtn.addEventListener('click', function () {
			var allOpen = detailsList.every(function (d) { return d.open; });
			detailsList.forEach(function (d) {
				d.open = !allOpen;
			});
			syncFaqButton();
		});

		detailsList.forEach(function (d) {
			d.addEventListener('toggle', syncFaqButton);
		});
	});

	/* ==========================================================================
	   8. Interactive Booking Form (Pre-fill, Live Preview, Date/Time Chips, Progress)
	   ========================================================================== */
	function addDaysISO(baseIso, days) {
		var parts = String(baseIso || '').split('-');
		var date = parts.length === 3
			? new Date(Number(parts[0]), Number(parts[1]) - 1, Number(parts[2]))
			: new Date();
		date.setDate(date.getDate() + Number(days || 0));
		var yyyy = date.getFullYear();
		var mm = String(date.getMonth() + 1).padStart(2, '0');
		var dd = String(date.getDate()).padStart(2, '0');
		return yyyy + '-' + mm + '-' + dd;
	}

	document.querySelectorAll('.azur-booking-form').forEach(function (form) {
		var shell = form.closest('.azur-form-shell') || form.parentElement;
		var summary = form.querySelector('.azur-form-summary');
		var serviceSelect = form.elements['azur_service'];
		var dateInput = form.elements['azur_date'];
		var timeSelect = form.elements['azur_time'];
		var previewBox = form.querySelector('[data-service-preview]');
		var previewText = form.querySelector('[data-service-preview-text]');
		var progressBarFill = shell && shell.querySelector('[data-progress-bar]');
		var progressText = shell && shell.querySelector('[data-progress-text]');
		var stepItems = Array.prototype.slice.call(document.querySelectorAll('.azur-step-list__item'));
		var dateChips = Array.prototype.slice.call(form.querySelectorAll('[data-date-offset]'));
		var timePills = Array.prototype.slice.call(form.querySelectorAll('[data-time-value]'));

		// 8a. URL ?serviciu= parameter pre-selection
		try {
			var params = new URLSearchParams(window.location.search);
			var requestedService = params.get('serviciu');
			if (requestedService && serviceSelect && !serviceSelect.value) {
				var optionExists = Array.prototype.some.call(serviceSelect.options, function (opt) {
					return opt.value === requestedService;
				});
				if (optionExists) {
					serviceSelect.value = requestedService;
				}
			}
		} catch (e) {
			// Ignore URLSearchParams errors on older browsers
		}

		// 8b. Dynamic Service Description Preview
		function updateServicePreview() {
			if (!serviceSelect || !previewBox || !previewText) return;
			var key = serviceSelect.value;
			var descriptions = config.serviceDescriptions || {};
			if (key && descriptions[key]) {
				previewText.textContent = descriptions[key];
				previewBox.hidden = false;
			} else {
				previewBox.hidden = true;
			}
		}

		if (serviceSelect) {
			serviceSelect.addEventListener('change', updateServicePreview);
			updateServicePreview();
		}

		// 8c. Quick Date Shortcuts
		if (dateInput && dateChips.length) {
			dateChips.forEach(function (chip) {
				chip.addEventListener('click', function () {
					var offset = Number(chip.getAttribute('data-date-offset') || 1);
					var baseDate = config.today || dateInput.getAttribute('min') || '';
					var targetDate = addDaysISO(baseDate, offset);
					dateInput.value = targetDate;
					dateChips.forEach(function (c) {
						c.classList.toggle('is-active', c === chip);
					});
					dateInput.dispatchEvent(new Event('input', { bubbles: true }));
					dateInput.dispatchEvent(new Event('change', { bubbles: true }));
				});
			});
			dateInput.addEventListener('input', function () {
				var baseDate = config.today || dateInput.getAttribute('min') || '';
				dateChips.forEach(function (chip) {
					var offset = Number(chip.getAttribute('data-date-offset') || 1);
					chip.classList.toggle('is-active', dateInput.value === addDaysISO(baseDate, offset));
				});
			});
		}

		// 8d. Visual Time-of-Day Pills
		function syncTimePills() {
			if (!timeSelect || !timePills.length) return;
			var currentVal = timeSelect.value;
			timePills.forEach(function (pill) {
				pill.classList.toggle('is-active', pill.getAttribute('data-time-value') === currentVal);
			});
		}

		if (timeSelect && timePills.length) {
			timePills.forEach(function (pill) {
				pill.addEventListener('click', function () {
					timeSelect.value = pill.getAttribute('data-time-value') || '';
					syncTimePills();
					timeSelect.dispatchEvent(new Event('change', { bubbles: true }));
				});
			});
			timeSelect.addEventListener('change', syncTimePills);
			syncTimePills();
		}

		// 8e. Live Form Progress & Field Validation State
		var requiredNames = ['azur_name', 'azur_phone', 'azur_service', 'azur_date', 'azur_time', 'azur_consent'];

		function isFieldComplete(name) {
			var field = form.elements[name];
			if (!field) return false;
			if (field.type === 'checkbox') return field.checked;
			if (name === 'azur_phone') {
				var digits = String(field.value || '').replace(/\D+/g, '');
				return digits.length >= 8 && digits.length <= 15;
			}
			if (name === 'azur_name') {
				return String(field.value || '').trim().length >= 2;
			}
			return Boolean(String(field.value || '').trim());
		}

		function updateFormProgress() {
			var completed = 0;
			requiredNames.forEach(function (name) {
				var valid = isFieldComplete(name);
				if (valid) completed++;
				var field = form.elements[name];
				var wrapper = field && field.closest('.azur-field');
				if (wrapper) {
					wrapper.classList.toggle('is-valid', valid);
				}
			});
			var pct = Math.round((completed / requiredNames.length) * 100);
			if (progressBarFill) progressBarFill.style.width = pct + '%';
			if (progressText) progressText.textContent = pct + '%';
		}

		form.addEventListener('input', updateFormProgress);
		form.addEventListener('change', updateFormProgress);
		updateFormProgress();

		// 8f. Confirmation Summary Drawer before final submit
		if (!summary) return;

		function fieldValue(name) {
			var field = form.elements[name];
			if (!field) return '';
			if (field.tagName === 'SELECT') return field.options[field.selectedIndex] ? field.options[field.selectedIndex].text : '';
			return field.value || '';
		}

		function addSummaryRow(list, label, value) {
			if (!value) return;
			var term = document.createElement('dt');
			var description = document.createElement('dd');
			term.textContent = label;
			description.textContent = value;
			list.appendChild(term);
			list.appendChild(description);
		}

		form.addEventListener('submit', function (event) {
			if (form.dataset.confirmed === 'true') return;
			if (!form.reportValidity()) return;
			event.preventDefault();
			summary.replaceChildren();
			var title = document.createElement('h3');
			title.textContent = 'Verifică solicitarea înainte de trimitere';
			var list = document.createElement('dl');
			addSummaryRow(list, 'Nume', fieldValue('azur_name'));
			addSummaryRow(list, 'Telefon', fieldValue('azur_phone'));
			addSummaryRow(list, 'Email', fieldValue('azur_email'));
			addSummaryRow(list, 'Serviciu', fieldValue('azur_service'));
			addSummaryRow(list, 'Zi preferată', fieldValue('azur_date'));
			addSummaryRow(list, 'Interval', fieldValue('azur_time'));
			var note = document.createElement('p');
			note.textContent = 'Solicitarea va fi confirmată ulterior de cabinet.';
			var actions = document.createElement('div');
			actions.className = 'azur-form-summary__actions';
			var confirmButton = document.createElement('button');
			confirmButton.type = 'button';
			confirmButton.className = 'button button--dark';
			confirmButton.textContent = 'Confirmă și trimite';
			confirmButton.addEventListener('click', function () {
				form.dataset.confirmed = 'true';
				form.requestSubmit();
			});
			var editButton = document.createElement('button');
			editButton.type = 'button';
			editButton.className = 'azur-form-summary__cancel';
			editButton.textContent = 'Revizuiește datele';
			editButton.addEventListener('click', function () {
				summary.hidden = true;
				if (stepItems.length >= 2) {
					stepItems[1].classList.remove('is-active');
				}
				var firstField = form.querySelector('input[name="azur_name"]');
				if (firstField) firstField.focus();
			});
			actions.appendChild(confirmButton);
			actions.appendChild(editButton);
			summary.appendChild(title);
			summary.appendChild(list);
			summary.appendChild(note);
			summary.appendChild(actions);
			summary.hidden = false;
			if (stepItems.length >= 2) {
				stepItems[0].classList.add('is-active');
				stepItems[1].classList.add('is-active');
			}
			summary.focus();
		});
	});

	/* ==========================================================================
	   9. Interactive Contact Map Mode Switcher (Hartă / Satelit)
	   ========================================================================== */
	document.querySelectorAll('[data-map-widget]').forEach(function (widget) {
		var iframe = widget.querySelector('[data-map-iframe]');
		var buttons = Array.prototype.slice.call(widget.querySelectorAll('[data-map-src]'));
		if (!iframe || !buttons.length) return;

		buttons.forEach(function (button) {
			button.addEventListener('click', function () {
				var targetSrc = button.getAttribute('data-map-src');
				if (targetSrc && iframe.getAttribute('src') !== targetSrc) {
					iframe.setAttribute('src', targetSrc);
				}
				buttons.forEach(function (btn) {
					btn.classList.toggle('is-active', btn === button);
				});
			});
		});
	});

	/* ==========================================================================
	   10. Scroll-Reveal Observer
	   ========================================================================== */
	if (!prefersReducedMotion && 'IntersectionObserver' in window) {
		var revealTargets = document.querySelectorAll(
			'.azur-service-columns .wp-block-column, .azur-service-row, .azur-gallery__item, .azur-appointment-band, .azur-note-panel, .azur-contact-layout > .wp-block-column'
		);
		var observer = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('is-revealed');
					observer.unobserve(entry.target);
				}
			});
		}, { threshold: 0.08, rootMargin: '0px 0px -24px 0px' });

		revealTargets.forEach(function (el) {
			el.classList.add('azur-reveal');
			observer.observe(el);
		});
	}
}());
