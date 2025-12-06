# Advent Of Code - 2025

## Puzzles 2025 - Timing & Memory

| Day | * Time | * Memory | ** Time | ** Memory |
|-----|--------|----------|---------|-----------|
| 01  | 1.6ms  | 2.8MB    | 2.1ms   | 2.8MB     |
| 02  | 800ms  | 6.5MB    | 5 500ms | 6.5MB     |
| 03  | 0.7ms  | 2.5MB    | 3.0ms   | 2.5MB     |
| 04  | 300ms  | 5.2MB    | 6 200ms | 5.2MB     |
| 05  | 4.5ms  | 2.6MB    | 0.6ms   | 2.6MB     |


## Install

```bash
$ composer install
```

## Add New Puzzle Solver
Do add new Solver for a day, you need to create a new Class `PuzzleDay{Number}.php` in `src/Day/`.
You can copy / paste the `src/Day/PuzzleDay0.php` and rename it to have base class puzzle day solver.

For the input, the data are in `data/` directory. You can also use `data/day-0` as template inputs files.
- `data/day-{d}/inputs.txt`: main input for the puzzle day.
- `data/day-{d}/inputs-part-{p}-example-{n}.txt`: Examples inputs. You can try to verify your solver with example
- `data/day-{d}/inputs-part-{p}-expected-{n}.txt`: Expected results. Here, you can put the expected result for each example.


## Solve puzzle day

### Command
```bash
Use    : bin/aoc solve [OPTION]...
OPTIONS:
  -d ARG, --day=ARG                     Day to solve - MANDATORY
  -e,     --example                     Example Only
  -f,     --functional                  Activate Solve in functional programming style
  -s,     --skip-empty-lines            Remove empty lines from inputs

```

### Example
#### Run base solver
By default, we just use one base solver.

```bash
$ bin/aoc solve --day=1   
------------------------------------------ EXAMPLES ------------------------------------------
*  :  24000 - expected: 24000
** :  45000 - expected: 45000
------------------------------------------- OUTPUT -------------------------------------------
*  : 100000 - [0s] - [2.2MB]
** : 200000 - [0s] - [2.2MB]
```

#### Run functional solver
But you can also try to add solver in functional programmation, by using `velkuns/pipeline` for example 
(or any custom / tiers code).
In this case, you'll need to override `partOneFunctional()` && `partTwoFunctional()` method and put you code here.
Then run the commande with `--functional` option.

It is quite challenging for some part, but for the first days, it very pleasant to also try functional programming :)

```bash
$ bin/aoc solve --day=1 --functional
------------------------------------------ EXAMPLES  (FUNCTIONAL) ------------------------------------------
*  :  24000 - expected: 24000
** :  45000 - expected: 45000
------------------------------------------ OUTPUT  (FUNCTIONAL) ------------------------------------------
*  : 100000 - [0s] - [2.2MB]
** : 200000 - [0s] - [2.2MB]
```
