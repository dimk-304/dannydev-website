import { test, expect } from '@playwright/test';

/**
 * Comprueba regresiones de maquetación en la portada (tema Kinetic).
 * No sustituye una revisión visual humana; documenta desalineaciones medibles.
 */

test.describe('Landing — diseño y alineación', () => {
	test.beforeEach(async ({ page }) => {
		await page.goto('/', { waitUntil: 'domcontentloaded' });
	});

	test('no hay scroll horizontal accidental en viewport desktop', async ({ page }, testInfo) => {
		test.skip(testInfo.project.name !== 'chromium', 'solo viewport desktop fijo');
		await page.setViewportSize({ width: 1280, height: 900 });
		const extraWidth = await page.evaluate(() => {
			const el = document.documentElement;
			return el.scrollWidth - el.clientWidth;
		});
		expect(extraWidth, 'scrollWidth no debería superar clientWidth').toBeLessThanOrEqual(2);
	});

	test('móvil: scroll horizontal contenido (umbral relajado)', async ({ page }, testInfo) => {
		test.skip(testInfo.project.name !== 'mobile', 'solo proyecto mobile');
		await page.setViewportSize({ width: 390, height: 844 });
		const extraWidth = await page.evaluate(() => {
			const el = document.documentElement;
			return el.scrollWidth - el.clientWidth;
		});
		/* WordPress / plugins a veces añaden 1–4px; falla si hay desbordes claros */
		expect(extraWidth).toBeLessThanOrEqual(8);
	});

	test('secciones principales del landing están presentes', async ({ page }) => {
		await expect(page.locator('#experience')).toBeVisible();
		await expect(page.locator('#tooling')).toBeVisible();
		await expect(page.locator('#contact')).toBeVisible();
	});

	test('timeline: centro de cada punto coincide con el eje de la línea vertical', async ({
		page,
	}) => {
		await page.setViewportSize({ width: 1280, height: 900 });
		const line = page.locator('.kinetic-timeline__line--bg').first();
		const dots = page.locator('.kinetic-timeline__dot');

		await expect(line).toBeVisible();
		const n = await dots.count();
		expect(n).toBeGreaterThan(0);

		const lineBox = await line.boundingBox();
		expect(lineBox).not.toBeNull();
		const lineCenterX = lineBox!.x + lineBox!.width / 2;

		const toleranciaPx = 4;
		for (let i = 0; i < n; i++) {
			const box = await dots.nth(i).boundingBox();
			expect(box, `dot ${i}`).not.toBeNull();
			const dotCenterX = box!.x + box!.width / 2;
			expect(
				Math.abs(dotCenterX - lineCenterX),
				`Punto ${i}: centro ${dotCenterX.toFixed(1)} vs línea ${lineCenterX.toFixed(1)}`,
			).toBeLessThanOrEqual(toleranciaPx);
		}
	});

	test('bento CV: tarjetas visibles y sin altura cero', async ({ page }) => {
		await page.setViewportSize({ width: 1280, height: 900 });
		const cards = [
			'.kinetic-bento__bio',
			'.kinetic-bento__stack',
			'.kinetic-bento__timeline',
		];
		for (const sel of cards) {
			const loc = page.locator(sel).first();
			await expect(loc).toBeVisible();
			const box = await loc.boundingBox();
			expect(box?.height ?? 0).toBeGreaterThan(48);
		}
	});

	test('grid de iconos del stack: celdas cuadradas coherentes', async ({ page }) => {
		await page.setViewportSize({ width: 1280, height: 900 });
		const cells = page.locator('.kinetic-stack-cell');
		const count = await cells.count();
		expect(count).toBeGreaterThan(0);
		for (let i = 0; i < count; i++) {
			const box = await cells.nth(i).boundingBox();
			expect(box).not.toBeNull();
			const ratio = box!.width > 0 ? box!.height / box!.width : 0;
			expect(ratio, `celda ${i} aspect-ratio ~1`).toBeGreaterThan(0.92);
			expect(ratio).toBeLessThan(1.08);
		}
	});
});
