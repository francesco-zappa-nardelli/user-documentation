The Hack type checker reports errors on specific lines. These errors
can be controlled with `HH_FIXME` and `HH_IGNORE_ERROR` comments.

## Error Categories

1XXX Parsing

2XXX Naming

3XXX Well-formed code (Nast check)

4XXX Typing

## Silencing Errors

Example of HH_FIXME.

Line oriented, so affects all occurrences.

No runtime consequences.

Error codes are stable. Will not be reused.

Best practice: provide a reason.

Can't disable if specified in .hhconfig.

## HH_FIXME

Code smell, but sometimes necessary.

Decl vs expression fixmes.

## HH_IGNORE_ERROR

Best avoided.
