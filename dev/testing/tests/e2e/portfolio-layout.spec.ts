import { test, expect } from '@playwright/test';

/**
 * Portafolio: alineación con .kinetic-container y modo una slide hasta 1024px de ancho.
 */
test.describe('Portafolio layout', () => {
	test('1024px: sin desborde horizontal del documento en #portfolio', async ({ page }) => {
		await page.setViewportSize({ width: 1024, height: 768 });
		await page.goto('/', { waitUntil: 'domcontentloaded' });
		await page.locator('#portfolio').scrollIntoViewIfNeeded();
		const overflow = await page.evaluate(
			() => document.documentElement.scrollWidth - document.documentElement.clientWidth,
		);
		expect(overflow, 'scroll horizontal del documento').toBeLessThanOrEqual(2);
	});

	test('1024px: la primera tarjeta ocupa el ancho útil del track (una slide)', async ({
		page,
	}) => {
		await page.setViewportSize({ width: 1024, height: 768 });
		await page.goto('/', { waitUntil: 'domcontentloaded' });
		await page.locator('#portfolio').scrollIntoViewIfNeeded();
		const dims = await page.evaluate(() => {
			const track = document.querySelector('[data-kinetic-carousel]');
			const first = document.querySelector('#portfolio .kinetic-project');
			if (!track || !first) {
				return null;
			}
			return {
				trackClient: (track as HTMLElement).clientWidth,
				projectWidth: (first as HTMLElement).offsetWidth,
			};
		});
		expect(dims, 'track y proyecto presentes').not.toBeNull();
		if (!dims) {
			return;
		}
		expect(dims.projectWidth, 'slide ≈ ancho del track').toBeGreaterThanOrEqual(
			dims.trackClient * 0.98,
		);
		expect(dims.projectWidth, 'slide no más ancha que el track').toBeLessThanOrEqual(
			dims.trackClient + 2,
		);
	});

	test('1280px: sin desborde horizontal del documento', async ({ page }) => {
		await page.setViewportSize({ width: 1280, height: 800 });
		await page.goto('/', { waitUntil: 'domcontentloaded' });
		await page.locator('#portfolio').scrollIntoViewIfNeeded();
		const overflow = await page.evaluate(
			() => document.documentElement.scrollWidth - document.documentElement.clientWidth,
		);
		expect(overflow).toBeLessThanOrEqual(2);
	});
});
