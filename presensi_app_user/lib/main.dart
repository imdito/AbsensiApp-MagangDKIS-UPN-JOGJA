import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:get/get_navigation/src/root/get_material_app.dart';
import 'package:presensi_app_user/view/auth/splash_page.dart';
import 'package:flutter_dotenv/flutter_dotenv.dart';
import 'package:intl/date_symbol_data_local.dart';

Future<void> main() async {
 await dotenv.load(fileName: ".env");
 await initializeDateFormatting('id_ID', null);
 runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return GetMaterialApp(
      debugShowCheckedModeBanner: false, // Hilangkan banner debug di pojok kanan
      title: 'Presensi QR',
      theme: ThemeData(
        colorScheme: ColorScheme.fromSeed(seedColor: Colors.blue),
        useMaterial3: true, // Gunakan desain Material 3 (lebih modern)
      ),
      // Halaman pertama yang muncul saat aplikasi dibuka
      home: const SplashPage(),
    );
  }
}