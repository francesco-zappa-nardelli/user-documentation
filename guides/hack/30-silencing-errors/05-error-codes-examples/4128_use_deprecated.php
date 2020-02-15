<?hh

<<__Deprecated("Don't use this function")>>
function foo(): void {}

function bar(): void {
  /* HH_FIXME[4128] Calling a deprecated function. */
  foo();
}
