Full list of error codes: error_map.ml

The most common error codes are documented below.

## 2049: Unbound name

@@ error-codes-examples/2049_unbound_name.php @@

Why it's bad: This is usually a sign that a name is incorrect.

It may be useful for calling parts of the PHP standard library that
the global name check is not aware of.

Suggestions: Check your spelling. Use safe Hack APIs rather than
legacy PHP APIs.

## 4005: Array accessing a value that doesn't support indexing

@@ error-codes-examples/4005_array_access.php @@

Why it's bad: Indexing values that don't support values can produce
surprising behavior. The runtime will log a warning and return null,
leading to runtime type errors later.

Suggestions: Refactor the code to use a Hack array or a `KeyedContainer`.

## 4053: Member not found

@@ error-codes-examples/4053_member_not_found.php @@

Why it's bad: Accessing a non-existent method will cause a runtime
error. Accessing a non-existent property will log a notice and return null.

Suggestions: Ensure that the object you're accessing actuall has the
type you're expecting.

## 4063: Nullable container access

@@ error-codes-examples/4063_null_container.php @@

Why it's bad: indexing in a null container returns null, leading to
runtime type errors later.

Suggestions: Check that the value is non-null with `nullthrows` or
assert with `$x as vec<_>`.

## 4107: Unbound name (type checking)

@@ error-codes-examples/4107_unbound_name_typing.php @@

Why it's bad: This is usually a sign that a name is incorrect.

It may be useful for calling parts of the PHP standard library that
the type checker is not aware of.

Suggestions: Check your spelling. Use safe Hack APIs rather than
legacy PHP APIs.

## 4110: Bad type in expression

@@ error-codes-examples/4110_bad_type.php @@

Why it's bad: Using the wrong type can result in runtime errors (for
enforced types), errors later (for unenforced types, such as erased
generics) or surprising coercions (e.g. for arithmetic).

Suggestions:

If the type is too broad (e.g. using `mixed`), use `as SpecificType`
to assert the specific runtime type. If you're not sure of the type,
consider using `<<__Soft>>` type hints on function signatures.

If the type is coming from very dynamic code, consider using the
`dynamic` type.

## 4128: Using deprecated code

@@ error-codes-examples/4128_use_deprecated.php @@

Why it's bad: Using functions or classes that have been marked as
deprecated prevents cleanup of old APIs.

Suggestions: `__Deprecated` takes a message for its first
argument. Consult that message to learn the new API.

## 4193

Illegal XHP child.

## 4297

Unknown type.

## 4323

Type constraint violation.

## 4343

XhpAttributeValueDoesNotMatchHint
