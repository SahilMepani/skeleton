# Claude Skills Directory

This directory contains Claude Skills files that document design patterns and best practices for the Skeleton WordPress theme.

## Files

- `skills/design-patterns.md` - Comprehensive front-end design patterns guide
- `skills/README.md` - How to use and reference skills files

## How Claude Skills Work

Claude Skills files are automatically discovered by Claude when they're in the `.claude/skills/` directory. They serve as a knowledge base that Claude can reference when helping with code.

## Using with Different AI Models

### Claude (Anthropic) - Automatic Discovery
Claude automatically finds and uses files in `.claude/skills/`. You can also explicitly reference:
```
Follow patterns in .claude/skills/design-patterns.md
```

### Cursor IDE - Multiple Methods

**Method 1: @ Mention**
```
@.claude/skills/design-patterns.md Use these patterns
```

**Method 2: Direct Path**
```
Reference .claude/skills/design-patterns.md
```

**Method 3: Through Rules**
The `.cursor/rules/` files in the project reference the skills file.

### Other Models (GPT-4, Copilot, etc.)

**Explicit Reference:**
```
Read and follow .claude/skills/design-patterns.md
```

**In Comments:**
```php
// Patterns: .claude/skills/design-patterns.md
```

## Best Practices

1. **Always reference** the skills file when starting new work
2. **Be specific** - mention which section you need
3. **Update** the file when establishing new patterns
4. **Use @ mentions** in Cursor for easy file access

## File Structure

```
.claude/
├── README.md (this file)
├── plan/           # Task planning documents
├── progress/       # Progress tracking
└── skills/
    ├── README.md
    └── design-patterns.md
```

## Working with Plan & Progress Folders

### Plan Folder
Use for task breakdown and planning:
```
.claude/plan/feature-name.md
```

### Progress Folder
Track progress on ongoing work:
```
.claude/progress/feature-name.md
```
