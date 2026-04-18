/**
 * Kinetic theme — interacciones ligeras
 */
(function () {
	'use strict';

	var nav = document.querySelector('.kinetic-nav');
	var toggle = document.querySelector('.kinetic-nav__toggle');
	var menu = document.getElementById('kinetic-nav-menu');

	var backdrop = document.querySelector('.kinetic-nav__backdrop');

	function setMobileMenuOpen(open) {
		document.body.classList.toggle('kinetic-menu-open', open);
		document.body.style.overflow = open ? 'hidden' : '';
	}

	if (toggle && nav && menu) {
		toggle.addEventListener('click', function () {
			var open = nav.classList.toggle('is-open');
			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
			if (window.matchMedia('(max-width: 767px)').matches) {
				setMobileMenuOpen(open);
			}
		});

		if (backdrop) {
			backdrop.addEventListener('click', function () {
				nav.classList.remove('is-open');
				toggle.setAttribute('aria-expanded', 'false');
				setMobileMenuOpen(false);
			});
		}

		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && nav.classList.contains('is-open')) {
				nav.classList.remove('is-open');
				toggle.setAttribute('aria-expanded', 'false');
				setMobileMenuOpen(false);
			}
		});

		menu.querySelectorAll('a').forEach(function (link) {
			link.addEventListener('click', function () {
				if (window.matchMedia('(max-width: 767px)').matches) {
					nav.classList.remove('is-open');
					toggle.setAttribute('aria-expanded', 'false');
					setMobileMenuOpen(false);
				}
			});
		});

		window.addEventListener('resize', function () {
			if (!window.matchMedia('(max-width: 767px)').matches && nav.classList.contains('is-open')) {
				nav.classList.remove('is-open');
				toggle.setAttribute('aria-expanded', 'false');
				setMobileMenuOpen(false);
			}
		});
	}

	/* Carrusel horizontal portfolio */
	var track = document.querySelector('[data-kinetic-carousel]');
	if (track) {
		var prev = document.querySelector('[data-kinetic-carousel-prev]');
		var next = document.querySelector('[data-kinetic-carousel-next]');
		var step = function (dir) {
			var first = track.querySelector('.kinetic-project');
			var stride;
			if (first) {
				var cs = window.getComputedStyle(track);
				var gapRaw = cs.columnGap || cs.gap || '0';
				var gap = parseFloat(gapRaw) || 0;
				stride = first.offsetWidth + gap;
			} else {
				stride = Math.min(track.clientWidth * 0.85, 480);
			}
			track.scrollBy({ left: dir * stride, behavior: 'smooth' });
		};
		if (prev) {
			prev.addEventListener('click', function () {
				step(-1);
			});
		}
		if (next) {
			next.addEventListener('click', function () {
				step(1);
			});
		}
	}

	/* Copiar email */
	var copyBtn = document.querySelector('[data-kinetic-copy]');
	if (copyBtn && navigator.clipboard && navigator.clipboard.writeText) {
		var copyBtnDefault = copyBtn.textContent.trim();
		copyBtn.addEventListener('click', function () {
			var text = copyBtn.getAttribute('data-kinetic-copy') || '';
			var copiedMsg = copyBtn.getAttribute('data-copied-label');
			navigator.clipboard.writeText(text).then(function () {
				if (copiedMsg) {
					copyBtn.textContent = copiedMsg;
				}
				window.setTimeout(function () {
					copyBtn.textContent = copyBtnDefault;
				}, 2000);
			});
		});
	}

	/* Barra de progreso del blog */
	var blogProgress = document.querySelector('[data-blog-progress]');
	if (blogProgress) {
		var updateProgress = function () {
			var top = window.scrollY || document.documentElement.scrollTop;
			var height = document.documentElement.scrollHeight - window.innerHeight;
			var ratio = height > 0 ? (top / height) * 100 : 0;
			blogProgress.style.width = Math.max(0, Math.min(100, ratio)) + '%';
		};
		window.addEventListener('scroll', updateProgress, { passive: true });
		updateProgress();
	}

	/* Línea de tiempo CV: relleno según scroll + entradas al entrar en vista */
	function kineticInitTimeline() {
		var timelineRoot = document.querySelector('[data-kinetic-timeline]');
		if (!timelineRoot || timelineRoot.getAttribute('data-kinetic-timeline-bound') === '1') {
			return !!timelineRoot;
		}
		timelineRoot.setAttribute('data-kinetic-timeline-bound', '1');

		var timelineReduce =
			typeof window.matchMedia === 'function' &&
			window.matchMedia('(prefers-reduced-motion: reduce)').matches;

		/*
		 * Progreso 0→1 al atravesar la sección (posición estable con el scroll del documento):
		 * t = (scrollY + vh - topDoc) / (height + vh)
		 */
		var setTimelineFill = function () {
			var rect = timelineRoot.getBoundingClientRect();
			var vh = window.innerHeight || 1;
			var scrollY = window.scrollY || document.documentElement.scrollTop || 0;
			var topDoc = rect.top + scrollY;
			var h = rect.height;
			var denom = h + vh;
			var t = 0;
			if (denom > 0) {
				t = (scrollY + vh - topDoc) / denom;
			}
			timelineRoot.style.setProperty('--k-timeline-fill', String(Math.max(0, Math.min(1, t))));
		};

		/* Cuando el centro del punto cruza la línea de lectura (~42% del viewport), el punto “se enciende” */
		var updateTimelineDotsLit = function () {
			var vh = window.innerHeight || 1;
			var activateY = vh * 0.42;
			timelineRoot.querySelectorAll('[data-kinetic-timeline-entry]').forEach(function (el) {
				var dot = el.querySelector('.kinetic-timeline__dot');
				if (!dot) {
					return;
				}
				var rect = dot.getBoundingClientRect();
				var centerY = rect.top + rect.height * 0.5;
				if (centerY <= activateY) {
					el.classList.add('kinetic-timeline__entry--dot-lit');
				} else {
					el.classList.remove('kinetic-timeline__entry--dot-lit');
				}
			});
		};

		var syncTimeline = function () {
			setTimelineFill();
			updateTimelineDotsLit();
		};

		/* Expuesto para tests E2E y depuración (scroll programático a veces no dispara listeners a tiempo) */
		window.kineticApplyTimelineFill = syncTimeline;

		var timelineRafPending = false;
		var onTimelineScroll = function () {
			if (timelineRafPending) {
				return;
			}
			timelineRafPending = true;
			window.requestAnimationFrame(function () {
				syncTimeline();
				timelineRafPending = false;
			});
		};

		if (timelineReduce) {
			timelineRoot.style.setProperty('--k-timeline-fill', '1');
			timelineRoot.querySelectorAll('[data-kinetic-timeline-entry]').forEach(function (el) {
				el.classList.add('kinetic-timeline__entry--in-view');
				el.classList.add('kinetic-timeline__entry--dot-lit');
			});
		} else {
			window.addEventListener('scroll', onTimelineScroll, { passive: true });
			window.addEventListener('resize', onTimelineScroll, { passive: true });
			window.addEventListener('load', onTimelineScroll, { once: true });
			syncTimeline();

			var timelineIo = new IntersectionObserver(
				function (entries) {
					entries.forEach(function (entry) {
						if (entry.isIntersecting) {
							entry.target.classList.add('kinetic-timeline__entry--in-view');
						}
					});
				},
				{ rootMargin: '0px 0px -6% 0px', threshold: [0, 0.08, 0.15] }
			);

			timelineRoot.querySelectorAll('[data-kinetic-timeline-entry]').forEach(function (el) {
				timelineIo.observe(el);
			});
		}

		return true;
	}

	if (!kineticInitTimeline()) {
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', kineticInitTimeline);
		}
		window.addEventListener('load', kineticInitTimeline);
	}
})();
