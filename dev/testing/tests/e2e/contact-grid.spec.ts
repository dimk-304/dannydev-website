import { test, expect } from '@playwright/test';

/**
 * Rejilla de contacto (4 columnas en tablet+): sin desborde horizontal por min-content.
 */
test.describe('Contacto — rejilla', () => {
	test('iPad Air (~820px): #contact sin scroll horizontal en el documento', async ({
		page,
	}) => {
		await page.setViewportSize({ width: 820, height: 1180 });
		await page.goto('/', { waitUntil: 'domcontentloaded' });
		await page.locator('#contact').scrollIntoViewIfNeeded();
		const extra = await page.evaluate(
			() => document.documentElement.scrollWidth - document.documentElement.clientWidth,
		);
		expect(extra, 'documento sin overflow X').toBeLessThanOrEqual(4);
	});

	test('grid encaja en el contenedor (ancho útil de la sección)', async ({ page }) => {
		await page.setViewportSize({ width: 820, height: 1180 });
		await page.goto('/', { waitUntil: 'domcontentloaded' });
		await page.locator('#contact').scrollIntoViewIfNeeded();
		const ok = await page.evaluate(() => {
			const section = document.querySelector('#contact');
			const grid = document.querySelector('.kinetic-contact-grid');
			if (!section || !grid) {
				return false;
			}
			const cs = getComputedStyle(section);
			const pl = parseFloat(cs.paddingLeft) || 0;
			const pr = parseFloat(cs.paddingRight) || 0;
			const inner = section.clientWidth - pl - pr;
			/* clientWidth del grid (caja) vs área útil; scrollWidth puede incluir hijos desbordados */
			return grid.clientWidth <= inner + 3;
		});
		expect(ok, '.kinetic-contact-grid dentro del área de contenido de #contact').toBe(true);
	});
});
