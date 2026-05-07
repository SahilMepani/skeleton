// Reference implementation for the wp-block-preview-generator skill.
//
// Copy this file to the project root as `.preview-capture.js`, fill in the
// CONFIGURE block with project-specific values, then run:
//
//     playwright-cli run-code "$(cat .preview-capture.js)"
//
// The script must remain a single arrow-function expression — do NOT add a
// trailing semicolon after the closing brace. `require()` is not available
// in the run-code sandbox, so every filesystem fact (slug whitelist, existing
// previews, URL list) must be embedded as a constant.

async (page) => {
	// =====================================================================
	// CONFIGURE — fill in for the target project
	// =====================================================================

	// Absolute path template; {slug} is replaced per component. Use forward
	// slashes even on Windows.
	const OUTPUT_TEMPLATE = 'E:/Local Sites/one-one/app/public/wp-content/themes/one-one/blocks/{slug}/preview.png';

	const VIEWPORT = { width: 1440, height: 900 };
	const MAX_HEIGHT = 900;

	// Selector for the per-component wrapper element on each page.
	const SECTION_SELECTOR = 'section[class*="-section"]';

	// Function returning the slug for a matched element, or null to skip.
	const SLUG_FROM_ELEMENT = (el) => {
		const cls = el.className.split(/\s+/).find(c => /-section$/.test(c) && c !== 'section');
		return cls ? cls.replace(/-section$/, '') : null;
	};

	// Selector for the locator used to take the screenshot. {slug} is
	// substituted into this template per component.
	const LOCATOR_TEMPLATE = 'section.{slug}-section';

	// Pages to walk.
	const urls = [
		'http://localhost:3000/',
		// 'http://localhost:3000/about/',
	];

	// Whitelist of valid component slugs (folders). Generated via:
	//     ls blocks/   # or equivalent
	const allSlugs = [
		// 'home-hero', 'product-showcase', ...
	];

	// Slugs that already have a preview file — skipped.
	const existing = new Set([
		// 'faqs', 'spacer', ...
	]);

	// =====================================================================
	// END CONFIGURE
	// =====================================================================

	const captured = new Set();
	const log = [];

	await page.setViewportSize(VIEWPORT);

	for (const url of urls) {
		log.push(`\n=== ${url} ===`);
		try {
			await page.goto(url, { waitUntil: 'domcontentloaded', timeout: 30000 });
		} catch (e) {
			log.push(`  goto failed: ${e.message}`);
			continue;
		}
		await page.waitForLoadState('networkidle', { timeout: 15000 }).catch(() => {});

		const slugs = await page.evaluate(({ selector, fnSrc }) => {
			const slugFn = new Function('el', `return (${fnSrc})(el)`);
			const out = [];
			const seen = new Set();
			document.querySelectorAll(selector).forEach(el => {
				const slug = slugFn(el);
				if (!slug || seen.has(slug)) return;
				seen.add(slug);
				out.push(slug);
			});
			return out;
		}, { selector: SECTION_SELECTOR, fnSrc: SLUG_FROM_ELEMENT.toString() });

		log.push(`  found: ${slugs.join(', ')}`);

		for (const slug of slugs) {
			if (captured.has(slug)) { log.push(`  skip ${slug} (already captured this run)`); continue; }
			if (existing.has(slug)) { log.push(`  skip ${slug} (preview exists)`); continue; }
			if (allSlugs.length && !allSlugs.includes(slug)) { log.push(`  skip ${slug} (no component folder)`); continue; }

			const locatorSelector = LOCATOR_TEMPLATE.replace('{slug}', slug);
			const locator = page.locator(locatorSelector).first();

			try {
				await locator.scrollIntoViewIfNeeded({ timeout: 5000 });
			} catch (e) {
				log.push(`  ${slug}: scrollIntoView failed: ${e.message}`);
				continue;
			}
			await page.waitForTimeout(600);

			// Wait for in-section images to load (lazy/async).
			await page.evaluate(async (sel) => {
				const el = document.querySelector(sel);
				if (!el) return;
				const imgs = Array.from(el.querySelectorAll('img'));
				await Promise.all(imgs.map(img => img.complete ? null : new Promise(r => {
					img.addEventListener('load', r, { once: true });
					img.addEventListener('error', r, { once: true });
					setTimeout(r, 2500);
				})));
			}, locatorSelector);

			let box = await locator.boundingBox();
			if (!box) { log.push(`  ${slug}: no bounding box`); continue; }

			const outPath = OUTPUT_TEMPLATE.replace('{slug}', slug);

			try {
				if (box.height <= MAX_HEIGHT) {
					await locator.screenshot({ path: outPath, scale: 'css' });
					log.push(`  ${slug}: captured ${Math.round(box.width)}x${Math.round(box.height)}`);
				} else {
					await page.evaluate((sel) => {
						const el = document.querySelector(sel);
						if (el) el.scrollIntoView({ block: 'start' });
					}, locatorSelector);
					await page.waitForTimeout(300);
					box = await locator.boundingBox();
					if (!box) { log.push(`  ${slug}: lost box after scroll`); continue; }
					await page.screenshot({
						path: outPath,
						scale: 'css',
						clip: {
							x: box.x,
							y: Math.max(0, box.y),
							width: box.width,
							height: MAX_HEIGHT,
						},
					});
					log.push(`  ${slug}: captured ${Math.round(box.width)}x${MAX_HEIGHT} (clipped from ${Math.round(box.height)})`);
				}
				captured.add(slug);
			} catch (e) {
				log.push(`  ${slug}: screenshot failed: ${e.message}`);
			}
		}
	}

	const neverSeen = allSlugs.filter(s => !captured.has(s) && !existing.has(s));
	log.push('');
	log.push('=== SUMMARY ===');
	log.push(`Captured (${captured.size}): ${[...captured].join(', ')}`);
	log.push(`Already had preview (${existing.size}): ${[...existing].join(', ')}`);
	log.push(`Never seen (${neverSeen.length}): ${neverSeen.join(', ')}`);

	return log.join('\n');
}
