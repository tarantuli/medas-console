# medas-console

Part of the [Medas framework](https://github.com/tarantuli/medas-core).

## Description

Provides the building blocks for CLI applications: a command definition system, a richly formatted output model, and a `Printer` interface that implementations (such as `medas-console-printer`) render to the terminal.

**Command system:**

Commands are grouped under `ConsoleCommandGroup` instances using a `group:name` path convention (e.g. `config-options:list`). Each command is a class implementing `ConsoleCommand` — typically by extending `BaseConsoleCommand` — and declares its name, description, accepted arguments, and options. The framework discovers all registered commands automatically via the service container.

`CommandInput` carries the parsed arguments (one-based indexed) and options passed at invocation. Options are declared as `Option` objects with three modes: `noValue` (flag), `valueAllowed` (optional value), and `valueRequired` (mandatory value). `Range` constrains the minimum and maximum number of positional arguments a command accepts; passing `false` as the max allows an unlimited number.

**Output model:**

Everything printed is a `Printable`. The package ships several concrete types:

| Class    | Purpose                                                           |
|----------|-------------------------------------------------------------------|
| `Text`   | A string with zero or more `Format` values (colour, style)        |
| `Table`  | A header row and data rows of `Printable` cells                   |
| `Tree`   | A recursive node structure rendered as an indented tree           |
| `Diff`   | A pre-formatted diff string rendered with standard diff colouring |
| `Blocks` | A flat container of multiple `Printable` values                   |

**Formatting:**

`Format` is a marker interface. Three implementations are available:

| Class / Enum | Description                                                           |
|--------------|-----------------------------------------------------------------------|
| `SafeColor`  | Named foreground colours defined as hex strings; the preferred choice |
| `HexColor`   | Arbitrary `#rrggbb` foreground colour                                 |
| `BgColor`    | Named background colours                                              |
| `Style`      | `Bold`, `Dim`, `Underlined`                                           |

`Color` is also present but marked `@deprecated` — use `SafeColor` instead.

A built-in `console:command-list` command lists all registered commands with their aliases and descriptions, with an optional filter argument.

## Usage

### Package developer context

Register the package and implement `ConsoleCommand` to add new CLI commands:

```php
use Medas\Console\ConsolePackage;

ConsolePackage::instance();
```

**Defining a command group:**

```php
use Medas\Console\Commands\{BaseConsoleCommandGroup, ConsoleCommandGroup};
use Medas\Core\Attributes\Service;

#[Service]
readonly class ReportsGroup extends BaseConsoleCommandGroup
{
    public function parent(): ConsoleCommandGroup|null
    {
        // null = top-level group; path is just 'reports'
        return null;
    }

    public function name(): string
    {
        return 'reports';
    }
}
```

Groups can be nested — return another group from `parent()` and `BaseConsoleCommandGroup::path()` builds the full colon-separated path automatically.

**Defining a command:**

```php
use Medas\Console\Commands\{BaseConsoleCommand, CommandInput, ConsoleCommandGroup, Option, Range};
use Medas\Core\Attributes\Service;

#[Service]
readonly class GenerateReport extends BaseConsoleCommand
{
    public function __construct(
        private ReportsGroup    $group,
        private ReportGenerator $generator,
    ) {}

    public function group(): ConsoleCommandGroup
    {
        return $this->group;
    }

    public function name(): string
    {
        return 'generate';
    }

    public function description(): string
    {
        return 'Generates a report for the given period'
    }

    public function options(): array
    {
        return [
            // --format=pdf  or  -f pdf  (value required)
            Option::valueRequired('format', 'f'),
            // --verbose  or  -v  (no value, acts as a flag)
            Option::noValue('verbose', 'v'),
        ];
    }

    public function allowedArgumentCount(): Range
    {
        // Requires exactly one positional argument (the period)
        return new Range(1);
    }

    public function process(CommandInput $input): void
    {
        $period  = $input->getArgument(1);
        $format  = $input->getOption('format') ?? 'pdf';
        $verbose = $input->hasOption('verbose');

        $this->generator->generate($period, $format, $verbose);
    }
}
```

Invoking: `php bin/medas reports:generate 2026-05 --format=csv --verbose`

**Using `Range` for flexible argument counts:**

```php
// Exactly two arguments
return new Range(2);

// One to three arguments
return new Range(1, 3);

// At least one argument, no upper limit
return new Range(1, false);

// Zero arguments (default in BaseConsoleCommand)
return new Range(0);
```

**Aliases** — a short word that invokes the command without typing the group prefix:

```php
public function aliases(): array
{
    // Callable as just 'report' instead of 'reports:generate'
    return ['report'];
}
```

**Building output with `Printer`:**

```php
use Medas\Console\{Printer, Table, Text, Tree};
use Medas\Console\Formats\{SafeColor, Style};
use Medas\Core\Attributes\Service;

#[Service]
readonly class MyCommand extends BaseConsoleCommand
{
    public function __construct(
        private Printer $printer,
        // ...
    ) {}

    public function process(CommandInput $input): void
    {
        // Plain line
        $this->printer->printLine(Text::create('Done.'));

        // Colored and styled text
        $this->printer->printLine(
            Text::create('Warning: ', SafeColor::Orange, Style::Bold),
            Text::create('something looks off', SafeColor::LightGray),
        );

        // Table
        $this->printer->printLine(Table::create(
            headers: ['Name', 'Status'],
            data: [
                [Text::create('report-2026-05', SafeColor::Green), Text::create('OK')],
                [Text::create('report-2026-04', SafeColor::LightRed), Text::create('Missing')],
            ],
        ));

        // Arbitrary hex color
        $this->printer->printLine(Text::create('Custom colour', HexColor::create('#ff6600')));
    }
}
```

**Rendering a tree:**

```php
use Medas\Console\{Text, Tree};
use Medas\Console\Formats\SafeColor;

$tree = new Tree(
    rootNode: $rootCategory,
    label: fn($node) => Text::create($node->name(), SafeColor::LightYellow),
    children: fn($node) => $node->children(),
);

$this->printer->printLine($tree);
```

### Backend user context

**Listing all available commands:**

```bash
php bin/medas console:command-list

# Filter by a substring of the command name, alias, or description
php bin/medas console:command-list report
```

**Invoking a command:**

```bash
# Full group:name form
php bin/medas reports:generate 2026-05 --format=csv

# Via alias (if defined)
php bin/medas report 2026-05
```

**Options syntax:**

```bash
# Long form with value
php bin/medas reports:generate 2026-05 --format=csv

# Short form with value
php bin/medas reports:generate 2026-05 -f csv

# Flag (no value)
php bin/medas reports:generate 2026-05 --verbose
php bin/medas reports:generate 2026-05 -v
```
