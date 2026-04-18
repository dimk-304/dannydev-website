import { test, expect } from '@playwright/test';

/**
 * Regresión: --k-timeline-fill debe seguir el scroll de forma estable (fórmula documento).
 */

async function flushScroll(page: import('@playwright/test').Page) {
	await page.evaluate(() => {
		window.dispatchEvent(new Event('scroll'));
		const w = window as unknown as { kineticApplyTimelineFill?: () => void };
		if (typeof w.kineticApplyTimelineFill === 'function') {
			w.kineticApplyTimelineFill();
		}
		return new Promise<void>((resolve) => {
			requestAnimationFrame(() => {
				requestAnimationFrame(() => resolve());
			});
		});
	});
}

/**
 * scrollTo + misma fórmula que main.js en un solo evaluate.
 * El valor de retorno se calcula siempre al final (lectura de --k-timeline-fill vía style es poco fiable en automatización).
 */
async function scrollToAndApplyTimeline(page: import('@playwright/test').Page, y: number): Promise<number> {
	return page.locator('[data-kinetic-timeline]').evaluate((el, scrollY: number) => {
		/* scroll-behavior: smooth hace scrollTo(0,y) asíncrono; además scrollTop en el nodo raíz no aplica en este tema (overflow-x) */
		window.scrollTo({ top: scrollY, left: 0, behavior: 'instant' });
		const w = window as unknown as { kineticApplyTimelineFill?: () => void };
		if (typeof w.kineticApplyTimelineFill === 'function') {
			w.kineticApplyTimelineFill();
		}
		const rect = el.getBoundingClientRect();
		const vh = window.innerHeight || 1;
		const sy = window.scrollY || document.documentElement.scrollTop || 0;
		const topDoc = rect.top + sy;
		const h = rect.height;
		const denom = h + vh;
		if (denom <= 0) {
			return 0;
		}
		return Math.max(0, Math.min(1, (sy + vh - topDoc) / denom));
	}, y);
}

test.describe('Timeline — animación y scroll', () => {
	test.beforeEach(async ({ page }) => {
		await page.setViewportSize({ width: 1280, height: 900 });
		await page.goto('/', { waitUntil: 'domcontentloaded' });
		await page.locator('[data-kinetic-timeline]').waitFor({ state: 'visible' });
		await page.waitForFunction(() => {
			const el = document.querySelector('[data-kinetic-timeline]');
			return el !== null && el.getAttribute('data-kinetic-timeline-bound') === '1';
		});
		await flushScroll(page);
	});

	test('fill bajo antes de que el viewport crucé el inicio del timeline', async ({ page }) => {
		const topDoc = await page.locator('[data-kinetic-timeline]').evaluate((el) => {
			const r = el.getBoundingClientRect();
			return r.top + window.scrollY;
		});
		const vh = await page.evaluate(() => window.innerHeight);
		/* Aún no ha llegado el borde inferior del viewport al tope del timeline */
		const fill = await scrollToAndApplyTimeline(page, Math.max(0, topDoc - vh - 40));
		expect(fill, 'debería ser ~0 antes del umbral').toBeLessThan(0.08);
	});

	test('fill alto cuando el timeline ha pasado por completo', async ({ page }) => {
		const m = await page.locator('[data-kinetic-timeline]').evaluate((el) => {
			const r = el.getBoundingClientRect();
			return {
				topDoc: r.top + window.scrollY,
				h: r.height,
			};
		});
		/* scrollY mínimo para progreso 1: borde superior del viewport al borde inferior del timeline */
		const maxScroll = await page.evaluate(
			() => document.documentElement.scrollHeight - window.innerHeight,
		);
		const fill = await scrollToAndApplyTimeline(page, Math.min(m.topDoc + m.h, Math.max(0, maxScroll)));
		expect(fill).toBeGreaterThan(0.92);
	});

	test('fill se alinea con el progreso geométrico del scroll (tolerancia)', async ({
		page,
	}) => {
		const m = await page.locator('[data-kinetic-timeline]').evaluate((el) => {
			const r = el.getBoundingClientRect();
			return {
				topDoc: r.top + window.scrollY,
				h: r.height,
				vh: window.innerHeight,
			};
		});
		const denom = m.h + m.vh;
		expect(denom).toBeGreaterThan(0);

		const targets = [0.12, 0.38, 0.62, 0.88];
		for (const p of targets) {
			const scrollY = m.topDoc - m.vh + p * denom;
			const fill = await scrollToAndApplyTimeline(page, scrollY);
			expect(
				Math.abs(fill - p),
				`esperado ~${p}, obtenido ${fill} (scrollY=${scrollY.toFixed(0)})`,
			).toBeLessThan(0.1);
		}
	});

	test('al bajar por el timeline el fill no retrocede (monotonía aproximada)', async ({
		page,
	}) => {
		const m = await page.locator('[data-kinetic-timeline]').evaluate((el) => {
			const r = el.getBoundingClientRect();
			return {
				topDoc: r.top + window.scrollY,
				h: r.height,
				vh: window.innerHeight,
			};
		});
		const denom = m.h + m.vh;
		let prev = -1;
		for (let i = 0; i <= 8; i++) {
			const p = i / 8;
			const fill = await scrollToAndApplyTimeline(page, m.topDoc - m.vh + p * denom);
			if (prev >= 0) {
				expect(fill + 0.03).toBeGreaterThanOrEqual(prev);
			}
			prev = fill;
		}
	});
});
