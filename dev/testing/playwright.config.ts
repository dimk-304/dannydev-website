import { defineConfig, devices } from '@playwright/test';

/**
 * URL del sitio Local / staging. Ejemplo: http://dannydev.local
 * export PLAYWRIGHT_BASE_URL="http://tu-sitio.local" npm run test:e2e
 */
const baseURL = process.env.PLAYWRIGHT_BASE_URL ?? 'http://dannydev.local';

export default defineConfig({
	testDir: './tests/e2e',
	fullyParallel: true,
	forbidOnly: !!process.env.CI,
	retries: process.env.CI ? 2 : 0,
	reporter: [['list'], ['html', { open: 'never' }]],
	use: {
		baseURL,
		trace: 'on-first-retry',
		screenshot: 'only-on-failure',
		video: 'off',
	},
	projects: [
		{ name: 'chromium', use: { ...devices['Desktop Chrome'] } },
		{ name: 'mobile', use: { ...devices['iPhone 13'] } },
	],
});
