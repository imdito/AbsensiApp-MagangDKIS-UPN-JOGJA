import 'package:flutter/material.dart';
import 'package:flutter_test/flutter_test.dart';
import 'package:presensi_app_user/main.dart';

void main() {
  group('Widget Tests - Aplikasi Presensi', () {
    testWidgets('Test 1: Cek apakah aplikasi bisa dibuka', (WidgetTester tester) async {
      // Build aplikasi
      await tester.pumpWidget(const MyApp());

      // Pump untuk menangani frame awal
      await tester.pump();

      // Skip timer dari SplashController (2 detik)
      await tester.pump(const Duration(seconds: 2));

      // Cek apakah ada MaterialApp
      expect(find.byType(MaterialApp), findsOneWidget);
    });

    testWidgets('Test 2: Cek apakah GetMaterialApp termuat', (WidgetTester tester) async {
      await tester.pumpWidget(const MyApp());
      await tester.pump();
      await tester.pump(const Duration(seconds: 2));

      // Verifikasi aplikasi menggunakan GetMaterialApp
      expect(find.byType(MaterialApp), findsOneWidget);
    });

    testWidgets('Test 3: Cek tema aplikasi menggunakan Material 3', (WidgetTester tester) async {
      await tester.pumpWidget(const MyApp());
      await tester.pump();
      await tester.pump(const Duration(seconds: 2));

      final materialApp = tester.widget<MaterialApp>(find.byType(MaterialApp));
      expect(materialApp.theme?.useMaterial3, true);
    });

    testWidgets('Test 4: Cek title aplikasi', (WidgetTester tester) async {
      await tester.pumpWidget(const MyApp());
      await tester.pump();
      await tester.pump(const Duration(seconds: 2));

      final materialApp = tester.widget<MaterialApp>(find.byType(MaterialApp));
      expect(materialApp.title, 'Presensi QR');
    });

    testWidgets('Test 5: Cek debug banner dimatikan', (WidgetTester tester) async {
      await tester.pumpWidget(const MyApp());
      await tester.pump();
      await tester.pump(const Duration(seconds: 2));

      final materialApp = tester.widget<MaterialApp>(find.byType(MaterialApp));
      expect(materialApp.debugShowCheckedModeBanner, false);
    });
  });
}
