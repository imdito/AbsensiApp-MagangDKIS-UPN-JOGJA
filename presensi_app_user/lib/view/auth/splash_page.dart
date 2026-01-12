import 'package:flutter/material.dart';
import 'package:get/get.dart';

import '../../controller/auth/splash_controller.dart';

class SplashPage extends StatelessWidget {
  const SplashPage({super.key});

  @override
  Widget build(BuildContext context) {
    Get.put(SplashController());

    return Scaffold(
      backgroundColor: Colors.white,
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            const Image(image: AssetImage('../assets/logoDKIS.png'), height: 120),
            const SizedBox(height: 20),
            const CircularProgressIndicator(), // Loading muter
            const SizedBox(height: 20),
            const Text("Sedang memuat data...")
          ],
        ),
      ),
    );
  }
}