import { test, expect } from '@playwright/test';

/**
 * Regresión: el panel del menú móvil debe ocupar el ancho del viewport (no quedar
 * “encogido” por backdrop-filter en el nav, que crea bloque de contención para fixed).
 */
test.describe('Navegación móvil', () => {
	test.use({ viewport: { width: 390, height: 844 } });

	test('menú hamburguesa: panel visible a ancho completo y enlaces accesibles', async ({
		page,
	}) => {
		await page.goto('/', { waitUntil: 'domcontentloaded' });
		await page.locator('.kinetic-nav__toggle').click();
		await expect(page.locator('.kinetic-nav')).toHaveClass(/is-open/);
		await expect(page.locator('body')).toHaveClass(/kinetic-menu-open/);

		const menu = page.locator('#kinetic-nav-menu');
		await expect(menu).toBeVisible();
		const firstLink = menu.locator('a').first();
		await expect(firstLink).toBeVisible();

		const box = await menu.boundingBox();
		expect(box, 'bounding box del <ul>').toBeTruthy();
		if (box) {
			expect(box.width, 'ancho ≈ viewport').toBeGreaterThan(360);
			expect(box.height, 'altura del panel suficiente para varios enlaces').toBeGreaterThan(200);
		}
	});

	test('sección #portfolio: sin desborde horizontal al hacer scroll', async ({ page }) => {
		await page.goto('/', { waitUntil: 'domcontentloaded' });
		await page.locator('#portfolio').scrollIntoViewIfNeeded();
		const docWide = await page.evaluate(
			() => document.documentElement.scrollWidth - document.documentElement.clientWidth,
		);
		expect(docWide, 'scroll horizontal del documento').toBeLessThanOrEqual(2);
	});
});
