import 'package:flutter/material.dart';
import 'package:flutter_test/flutter_test.dart';

// Ganti import ini sesuai nama package aplikasi Anda
import 'package:presensi_app_user/main.dart';

void main() {
  testWidgets('Cek apakah aplikasi bisa dibuka', (WidgetTester tester) async {
    // 1. Build aplikasi Anda
    await tester.pumpWidget(const MyApp());

    // 2. Cek apakah ada Widget tertentu di layar awal (Misal teks 'Login' atau Gambar Logo)
    // Sesuaikan 'Login' dengan teks yang BENAR-BENAR ada di halaman awal Anda
    find.text('Masuk Aplikasi'); //artinya mencari widget Text yang isinya "Login"

    // Contoh: Jika di halaman awal ada tulisan "Presensi App"
    // expect(find.text('Presensi App'), findsOneWidget);

    // Atau cek apakah ada setidaknya satu widget Scaffold (tanda halaman termuat)
    expect(find.byType(Scaffold), findsOneWidget);
  });
} 