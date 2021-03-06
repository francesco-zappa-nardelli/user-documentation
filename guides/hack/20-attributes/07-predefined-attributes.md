The following attributes are defined:
* [__AcceptDisposable](#__acceptdisposable)
* [__AllowStatic](#__allowstatic)
* [__ConsistentConstruct](#__consistentconstruct)
* [__Deprecated](#__deprecated)
* [__DynamicallyCallable](#__dynamicallycallable)
* [__DynamicallyConstructible](#__dynamicallyconstructible)
* [__Enforceable](#__enforceable)
* [__EntryPoint](#__entrypoint)
* [__Explicit](#__explicit)
* [__LateInit](#__lateinit)
* [__Memoize](#__memoize)
* [__MemoizeLSB](#__memoizelsb)
* [__MockClass](#__mockclass)
* [__Override](#__override)
* [__PHPStdLib](#__phpstdlib)
* [__ReturnDisposable](#__returndisposable)
* [__Sealed](#__sealed)
* [__Enforceable](#__sealed)

## __AcceptDisposable

This attribute can be applied to a function parameter that has a type that implements interface `IDisposable` or `IAsyncDisposable`.

See [object disposal](../classes/object-disposal.md) for an example of its use.

## __ConsistentConstruct

When a method is overridden in a derived class, it must have exactly the same number, type, and order of parameters as that in the base
class. However, that is not usually the case for constructors. Having a family of constructors with different signatures can cause a problem,
however, especially when using `new static`.

This attribute can be applied to classes; it has no attribute values.  Consider the following example:

```Hack
<<__ConsistentConstruct>>
class Base {
  public function __construct() { ... }

  public static function make(): this {
    return new static();
  }
}

class Derived extends Base {
  public function __construct() {
    ...
    parent::__construct();
  }
}

$v2 = Derived::make();
```

When `make` is called on a `Derived` object, `new static` results in `Derived`'s constructor being called knowing only the parameter list
of `Base`'s constructor. As such, `Derived`'s constructor must either have the exact same signature as `Base`'s constructor, or the same
plus an ellipsis indicating a trailing variable-argument list.

## __Deprecated

This attribute can be applied to a function to indicate that it has been *deprecated*; that is, it is obsolete, and calls to it should be
revised. This attribute has two possible attribute values.  Consider the following example:

```Hack
<<__Deprecated("This function has been replaced by do_that", 7)>>
function do_this(): void { /* ... */ }

```

The presence of this attribute on a function has no effect, unless that function is actually called, in which case, for each call to that
function, the type checker issues a diagnostic containing the text from the first attribute value.  The optional `int`-typed second attribute
value (in this case, 7) indicates a *sample rate*. Assuming the program will still execute, every 1/sample-rate calls (as in, 1/7) to that
function will be diagnosed at runtime.

## __DynamicallyCallable

Allows a function or method to be called dynamically, based on a
string of its name. HHVM will warn on error (depending on
configuration) on dynamic calls to functions or methods without this attribute.

## __DynamicallyConstructible

Allows this class to be instantiated dynamically, based on a string of
its name. HHVM will warn on error (depending on configuration) on
dynamic instantiations of classes without this attribute.

## __Enforceable

Ensure that a type is enforceable. Enforceable types can be used with
`is` and `as`. This forbids usage of function types and erased (not
reified) generics.

## __Explicit

Requires callers to explicitly specify the value for a generic
type. Normally Hack allows generics to be inferred at the call site.

@@ predefined-attributes-examples/explicit.php @@

## __EntryPoint

A Hack program begins execution at a top-level function referred to as the *entry-point function*. A top-level function can be designated as such using this attribute, which
has no attribute values. For example:

```Hack
<<__EntryPoint>>
function main(): void {
  \printf("Hello, World!\n");
}
```

Note: An entry-point function will *not* be automatically executed if the file containing such a function is included via require or the autoloader.

## __LateInit

Hack normally requires properties to be initialized, either with an
initial value on the property definition or inside the constructor.

`__LateInit` disables this check.

```Hack
class Foo {}

class Bar {
  <<__LateInit>> private Foo $f;

  public function trustMeThisIsCalledEarly(): void {
    $this->f = new Foo();
  }
}
```

**This is intended for testing**, where it's common to have a setup
function that initializes values.

Accessing a property that is not initialized produces a runtime error.

`__LateInit` can also be used with static properties.

```Hack
class Foo {}

class Bar {
  <<__LateInit>> private static Foo $f;

  public static function trustMeThisIsCalledEarly(): void {
    self::$f = new Foo();
  }
}
```

It may be clearer to write your code using a memoized static method
instead of a static property with `__LateInit`.

## __Memoize

The presence of this attribute causes the designated method to automatically cache each value it looks up and returns, so future calls with
the same parameters can be retrieved more efficiently. The set of parameters is hashed into a single hash key, so changing the type, number,
and/or order of the parameters can change that key.

This attribute can be applied to functions and static or instance methods; it has no attribute values.  Consider the following example:

```Hack
class Item {
  <<__Memoize>>
  public static function get_name_from_product_code(int $productCode): string {
    if (name-in-cache) {
      return name-from-cache
    } else {
      return Item::get_name_from_storage($productCode);
    }
  }
  private static function get_name_from_storage(int $productCode): string {
    // get name from alternate store
    return ...;
  }
}
```

`Item::get_name_from_storage` will only be called if the given product code is not in the cache.

The types of the parameters are restricted to the following: `null`, `bool`, `int`, `float`, `string`, any object type that implements
`IMemoizeParam`, enum constants, tuples, shapes, and arrays/collections containing any supported element type.

The interface type `IMemoizeParam` assists with memorizing objects passed to async functions.

### Limitations

- If an exception is thrown, this is not memoized.
- Functions with variadic parameters can not be memoized

## __MemoizeLSB

This is like [<<__Memoize>>](#__memoize), but the cache has Late Static Binding. Each subclass has its own memoize cache.

## __MockClass

Mock classes are useful in testing frameworks when you want to test functionality provided by a legitimate, user-accessible class,
by creating a new class (many times a child class) to help with the testing. However, what if a class is marked as `final` or a method in a
class is marked as `final`? Your mocking framework would generally be out of luck.

The `__MockClass` attribute allows you to override the restriction of `final` on a class or method within a class, so that a
mock class can exist.

@@ predefined-attributes-examples/mock.php @@

Mock classes *cannot* extend types `vec`, `dict`, and `keyset`, or the Hack legacy types `Vector`, `Map`, and `Set`.

## __Override

Methods marked with `__Override` must be used with inheritance.

For classes, `__Override` ensures that a parent class has a method
with the same name.

```Hack
class Button {
  // If we rename 'draw' to 'render' in the parent class,
  public function draw(): void { /* ... */ }
}
class CustomButton extends Button {
  // then the child class would get a type error.
  <<__Override>>
  public function draw(): void { /* ... */ }
}
```

For traits, `__Override` ensures that trait users have a method that
is overridden.

```Hack
class Button {
  public function draw(): void { /* ... */ }
}

trait MyButtonTrait {
  <<__Override>>
  public function draw(): void { /* ... */ }
}

class ExampleButton extends Button {
  // If ExampleButton did not have an inherited method
  // called 'draw', this would be an error.
  use MyButtonTrait;
}
```

It is often clearer to use constraints on traits instead. The above
trait could also be written like this.

```Hack
class Button {
  public function draw(): void { /* ... */ }
}

trait MyButtonTrait {
  // This makes the relationship with Button explicit.
  require extends Button;

  public function draw(): void { /* ... */ }
}

class ExampleButton extends Button {
  use MyButtonTrait;
}
```

## __PHPStdLib

This attribute tells the type checker to ignore a function or class,
so type errors are reported on any code that uses it.

This is useful when gradually deprecating PHP features.

`__PHPStdLib` only applies on `.hhi` files by default, but can apply
everywhere with the option `deregister_php_stdlib`.

## __ReturnDisposable

This attribute can be applied to a function that returns a value whose type implements interface `IDisposable` or `IAsyncDisposable`.

See [object disposal](../classes/object-disposal.md) for an example of its use.

## __Sealed

A class that is *sealed* can be extended directly only by the classes named in the attribute value list. Similarly, an interface that is sealed
can be implemented directly only by the classes named in the attribute value list. Classes named in the attribute value list can themselves be
extended arbitrarily unless they are final or also sealed. In this way, sealing provides a single-level restraint on inheritance.
For example:

```Hack
<<__Sealed(X::class, Y::class)>>
abstract class A { ... }

<<__Sealed(Z::class)>>
interface I { ... }
```

Only classes `X` and `Y` can directly extend class `A`, and only class `Z` can directly implement interface `I`.

## __Enforceable

This attribute is used to annotate abstract type constants so they can be used in `is` and `as` expressions. The attribute restricts deriving type constants to values that are valid for a type test.

@@ predefined-attributes-examples/enforceable.php.type-errors @@

This attribute can also be used for reified generics, and it similarly allows the generic to be used in a type test expression.
