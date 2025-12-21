# SCSS Cleanup Script

A Node.js script to automatically remove unused SCSS files and empty directories from your WordPress theme.

## What it does

1. **Analyzes imports**: Reads `src/sass/style.scss` and identifies all imported SCSS files (ignoring commented imports)
2. **Finds unused files**: Scans `src/sass/partials/` and identifies files that are not imported
3. **Deletes unused files**: Removes all unused SCSS files
4. **Removes empty directories**: Cleans up directories that no longer contain any SCSS files

## Usage

Simply run the script from your theme root directory:

```bash
node cleanup-unused-scss.cjs
```

## Requirements

- Node.js (any recent version)
- The script expects:
  - `src/sass/style.scss` - Main stylesheet with imports
  - `src/sass/partials/` - Directory containing SCSS partial files

## How it works

The script:
- Parses `@import` statements in `style.scss` (skips commented lines)
- Converts import paths to actual file paths (e.g., `partials/mixins/rem` → `mixins/_rem.scss`)
- Compares imported files with all existing SCSS files
- Deletes files that are not in the imported list
- Removes empty directories recursively

## Example Output

```
🧹 Starting SCSS cleanup...

ℹ️  Step 1: Analyzing imports in style.scss...
   Found 17 imported files
ℹ️  Step 2: Scanning for all SCSS files...
   Found 68 total SCSS files
ℹ️  Step 3: Identifying unused files...
   Found 51 unused files:
     - acf-blocks/_hero-slider.scss
     - components/_header.scss
     ...

ℹ️  Step 4: Deleting unused files...
   Deleted: acf-blocks/_hero-slider.scss
   ...
✅ Deleted 51 unused file(s)

ℹ️  Step 5: Removing empty directories...
   Removed 6 empty directory(ies):
     - acf-blocks
     - components
     ...
✅ Removed 6 empty directory(ies)

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
✨ Cleanup complete!
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
```

## Safety

- The script only deletes files in `src/sass/partials/`
- It preserves all files that are imported in `style.scss`
- It provides detailed output of what will be deleted
- Always commit your changes before running cleanup scripts

## Customization

To use with different paths, edit the configuration at the top of the script:

```javascript
const STYLE_SCSS_PATH = 'src/sass/style.scss';
const PARTIALS_DIR = 'src/sass/partials';
```
