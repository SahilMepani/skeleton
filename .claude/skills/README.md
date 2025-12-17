# Claude Skills - Skeleton WordPress Theme

This directory contains Claude Skills files that document design patterns and best practices for this WordPress theme.

## Files

- `design-patterns.md` - Comprehensive patterns for SCSS, PHP, JavaScript, and component architecture

## How to Reference This File

### For Claude (Anthropic)

Claude automatically discovers and uses files in `.claude/skills/` directory. You can also explicitly reference it in prompts:

**Example prompts:**
```
Please follow the design patterns documented in .claude/skills/design-patterns.md when creating this component.

Reference the SCSS patterns in .claude/skills/design-patterns.md for responsive styling.

When building this feature, use the PHP patterns from .claude/skills/design-patterns.md.
```

### For Cursor IDE

Cursor can reference these files through:

1. **Direct file reference in prompts:**
   ```
   Follow the patterns in .claude/skills/design-patterns.md
   ```

2. **Through Cursor Rules** (see `.cursor/rules/` folder)

3. **In chat/composer:**
   ```
   @.claude/skills/design-patterns.md Please use these patterns
   ```

### For Other AI Models

**GPT-4 / ChatGPT:**
```
Please read and follow the design patterns in .claude/skills/design-patterns.md
```

**GitHub Copilot:**
Reference the file path directly in comments:
```php
// Follow patterns from .claude/skills/design-patterns.md
```

## Best Practices

1. **Always reference the file** when starting new components or features
2. **Update the file** when establishing new patterns
3. **Link to specific sections** when asking about particular patterns:
   ```
   Use the SCSS fluid() patterns from the "SCSS Patterns" section
   ```

## File Sections

The design patterns file is organized into:
- Critical Rules (NEVER violate)
- SCSS Patterns (fluid(), breakpoints, BEM)
- PHP Patterns (WordPress standards, escaping, hooks)
- JavaScript Patterns (IIFE, DOM, async)
- Component Architecture
- Accessibility Standards
