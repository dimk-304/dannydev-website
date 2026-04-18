import { test, expect } from '@playwright/test';

/**
 * Matriz de viewports: móvil pequeño, móvil, tablet, laptop, FHD, 1440p.
 * Solo Chromium para tiempo de CI predecible (mismo motor que desktop).
 */

const VIEWPORTS = [
	{ name: 'mobile-small', width: 360, height: 780 },
	{ name: 'mobile', width: 390, height: 844 },
	{ name: 'tablet-portrait', width: 834, height: 1112 },
	{ name: 'tablet-landscape', width: 1024, height: 768 },
	{ name: 'laptop', width: 1366, height: 768 },
	{ name: 'desktop-fhd', width: 1920, height: 1080 },
	{ name: 'ultra-tv', width: 2560, height: 1440 },
] as const;

test.describe('Landing — viewports', () => {
	for (const vp of VIEWPORTS) {
		test(`sin desborde horizontal grave — ${vp.name} (${vp.width}×${vp.height})`, async ({
			page,
		}, testInfo) => {
			test.skip(testInfo.project.name !== 'chromium', 'matriz en Chromium únicamente');

			await page.setViewportSize({ width: vp.width, height: vp.height });
			await page.goto('/', { waitUntil: 'domcontentloaded' });

			const extraWidth = await page.evaluate(() => {
				const el = document.documentElement;
				return el.scrollWidth - el.clientWidth;
			});

			expect(
				extraWidth,
				`[${vp.name}] scrollWidth − clientWidth demasiado alto (revisar overflow)`,
			).toBeLessThanOrEqual(12);

			await expect(page.locator('#experience')).toBeVisible();
			await expect(page.locator('#contact')).toBeVisible();
			await expect(page.locator('.kinetic-hero')).toBeVisible();
		});
	}
});
