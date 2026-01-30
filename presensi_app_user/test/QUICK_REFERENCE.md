# 🎯 Quick Reference - Testing Cheat Sheet

## 📋 Quick Commands

```bash
# Run all tests
flutter test

# Run with details
flutter test -r expanded

# Run specific file
flutter test test/model_test.dart

# Run with coverage
flutter test --coverage

# Use test runner script
./test/run_tests.sh all
./test/run_tests.sh widget
./test/run_tests.sh coverage
```

---

## 📂 Test Files Overview

| File | Tests | Purpose |
|------|-------|---------|
| `widget_test.dart` | 5 | UI & Widget testing |
| `model_test.dart` | 8 | Data model testing |
| `controller_test.dart` | 9 | Business logic testing |
| `utility_test.dart` | 19 | Helper functions testing |

**Total: 41 tests ✅**

---

## 🧪 Common Test Patterns

### Basic Test Structure
```dart
test('Test description', () {
  // Arrange
  final data = setupData();
  
  // Act
  final result = doSomething(data);
  
  // Assert
  expect(result, expectedValue);
});
```

### Widget Test Pattern
```dart
testWidgets('Widget test', (WidgetTester tester) async {
  // Build widget
  await tester.pumpWidget(MyWidget());
  
  // Interact
  await tester.tap(find.byType(Button));
  await tester.pump();
  
  // Verify
  expect(find.text('Result'), findsOneWidget);
});
```

### Async Test Pattern
```dart
test('Async test', () async {
  final result = await asyncFunction();
  expect(result, isNotNull);
});
```

---

## 🔍 Common Expectations

```dart
// Equality
expect(actual, expected);
expect(actual, equals(expected));

// Boolean
expect(value, isTrue);
expect(value, isFalse);

// Null checks
expect(value, isNull);
expect(value, isNotNull);

// Type checks
expect(value, isA<String>());

// Numeric
expect(value, greaterThan(0));
expect(value, lessThan(100));
expect(value, inRange(1, 10));

// Strings
expect(text, contains('substring'));
expect(text, startsWith('prefix'));
expect(text, endsWith('suffix'));
expect(text, isEmpty);
expect(text, isNotEmpty);

// Collections
expect(list, isEmpty);
expect(list, hasLength(3));
expect(list, contains(item));

// Exceptions
expect(() => throwError(), throwsException);
expect(() => throwError(), throwsA(isA<TypeError>()));

// Widget finders
expect(find.text('Login'), findsOneWidget);
expect(find.byType(TextField), findsWidgets);
expect(find.byKey(Key('myKey')), findsNothing);
```

---

## 🎨 Testing Widgets

### Find Widgets
```dart
// By text
find.text('Hello')

// By type
find.byType(TextField)

// By key
find.byKey(Key('submit'))

// By icon
find.byIcon(Icons.add)

// By widget
find.byWidget(myWidget)
```

### Interact with Widgets
```dart
// Tap
await tester.tap(finder);

// Enter text
await tester.enterText(finder, 'text');

// Drag
await tester.drag(finder, Offset(0, -200));

// Long press
await tester.longPress(finder);
```

### Pump Methods
```dart
// Single frame
await tester.pump();

// With duration
await tester.pump(Duration(seconds: 1));

// Until settled
await tester.pumpAndSettle();

// Multiple frames
await tester.pump(Duration.zero, EnginePhase.layout);
```

---

## 🛠️ Testing GetX Controllers

```dart
test('GetX controller test', () {
  // Setup
  Get.testMode = true;
  final controller = MyController();
  
  // Test
  controller.increment();
  expect(controller.count.value, 1);
  
  // Cleanup
  Get.reset();
});
```

---

## 📅 Testing Date/Time

```dart
test('Date formatting', () {
  final date = DateTime(2026, 1, 27);
  final formatter = DateFormat('dd/MM/yyyy');
  expect(formatter.format(date), '27/01/2026');
});

test('Time comparison', () {
  final now = DateTime.now();
  final later = now.add(Duration(hours: 1));
  expect(later.isAfter(now), isTrue);
});
```

---

## 🔐 Testing Validation

```dart
test('Email validation', () {
  bool isValidEmail(String email) {
    return RegExp(r'^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$')
        .hasMatch(email);
  }
  
  expect(isValidEmail('test@example.com'), isTrue);
  expect(isValidEmail('invalid'), isFalse);
});
```

---

## 🎯 Testing Models

```dart
test('Model serialization', () {
  // From JSON
  final json = {'id': 1, 'name': 'Test'};
  final model = MyModel.fromJson(json);
  expect(model.id, 1);
  expect(model.name, 'Test');
  
  // To JSON
  final result = model.toJson();
  expect(result['id'], 1);
  expect(result['name'], 'Test');
});
```

---

## 🐛 Common Issues & Solutions

### Issue: Timer Pending
```dart
// ❌ Problem
await tester.pumpWidget(MyApp());

// ✅ Solution
await tester.pumpWidget(MyApp());
await tester.pump();
await tester.pump(Duration(seconds: 2));
```

### Issue: Locale Not Initialized
```dart
// ✅ Solution
setUpAll(() async {
  await initializeDateFormatting('id_ID', null);
});
```

### Issue: GetX Not Initialized
```dart
// ✅ Solution
setUp(() {
  Get.testMode = true;
});

tearDown(() {
  Get.reset();
});
```

---

## 📊 Test Organization

```dart
void main() {
  group('Feature Group', () {
    setUp(() {
      // Runs before each test
    });
    
    tearDown(() {
      // Runs after each test
    });
    
    setUpAll(() {
      // Runs once before all tests
    });
    
    tearDownAll(() {
      // Runs once after all tests
    });
    
    test('Test 1', () { });
    test('Test 2', () { });
  });
}
```

---

## 🎓 Best Practices

### ✅ DO
- Write descriptive test names
- Test one thing per test
- Use arrange-act-assert pattern
- Clean up after tests
- Test edge cases
- Mock external dependencies

### ❌ DON'T
- Don't test implementation details
- Don't make tests dependent on each other
- Don't ignore failing tests
- Don't skip edge cases
- Don't hardcode values that should be configurable

---

## 📈 Coverage Goals

| Category | Target | Current |
|----------|--------|---------|
| Models | 90%+ | ✅ High |
| Controllers | 80%+ | ✅ High |
| Utilities | 90%+ | ✅ High |
| Widgets | 70%+ | ✅ Good |

---

## 🚀 Quick Start

1. **Install dependencies**
   ```bash
   flutter pub get
   ```

2. **Run all tests**
   ```bash
   flutter test
   ```

3. **View results**
   ```bash
   flutter test -r expanded
   ```

4. **Generate coverage**
   ```bash
   flutter test --coverage
   ```

---

## 📞 Need Help?

- Check `test/README.md` for detailed docs
- View `test/TEST_SUMMARY.md` for results
- Review example tests in test files
- Check Flutter testing docs: https://flutter.dev/docs/testing

---

**Last Updated:** 27 Januari 2026

