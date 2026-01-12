import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:google_fonts/google_fonts.dart';

import '../../controller/auth/login_controller.dart';

class LoginPage extends StatelessWidget {
  const LoginPage({super.key});

  @override
  Widget build(BuildContext context) {
    // Inisialisasi Controller
    final LoginController controller = Get.put(LoginController());

    // Definisi Warna Tema (Sama dengan Web)
    const Color primaryColor = Color(0xFF4F46E5); // Indigo 600
    const Color grayBg = Color(0xFFF9FAFB);       // Gray 50
    const Color grayText = Color(0xFF6B7280);     // Gray 500
    const Color grayBorder = Color(0xFFE5E7EB);   // Gray 200

    return Scaffold(
      backgroundColor: Colors.white,
      body: SafeArea(
        child: Center(
          child: SingleChildScrollView(
            padding: const EdgeInsets.symmetric(horizontal: 24.0),
            child: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              crossAxisAlignment: CrossAxisAlignment.stretch,
              children: [
                // --- LOGO ---
                Center(
                  child: Container(
                    height: 80,
                    width: 80,
                    child: Ink.image(image: AssetImage('../assets/logoDKIS.png'), fit: BoxFit.contain)
                  ),
                ),
                const SizedBox(height: 24),

                // --- HEADER ---
                Text(
                  'Selamat Datang',
                  textAlign: TextAlign.center,
                  style: GoogleFonts.inter(
                    fontSize: 28,
                    fontWeight: FontWeight.bold,
                    color: const Color(0xFF111827),
                  ),
                ),
                const SizedBox(height: 8),
                Text(
                  'Silakan masuk untuk melanjutkan presensi',
                  textAlign: TextAlign.center,
                  style: GoogleFonts.inter(
                    fontSize: 14,
                    color: grayText,
                  ),
                ),
                const SizedBox(height: 40),

                // --- EMAIL INPUT ---
                Text(
                  'Alamat Email',
                  style: GoogleFonts.inter(
                    fontSize: 14,
                    fontWeight: FontWeight.w500,
                    color: const Color(0xFF374151),
                  ),
                ),
                const SizedBox(height: 8),
                TextFormField(
                  controller: controller.emailController, // Sambungkan Controller
                  keyboardType: TextInputType.emailAddress,
                  style: GoogleFonts.inter(),
                  decoration: InputDecoration(
                    hintText: 'nama@instansi.com',
                    hintStyle: GoogleFonts.inter(color: Colors.grey.shade400),
                    filled: true,
                    fillColor: grayBg,
                    contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 16),
                    prefixIcon: const Icon(Icons.email_outlined, color: grayText, size: 20),
                    enabledBorder: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(12),
                      borderSide: const BorderSide(color: grayBorder),
                    ),
                    focusedBorder: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(12),
                      borderSide: const BorderSide(color: primaryColor, width: 2),
                    ),
                  ),
                ),
                const SizedBox(height: 24),

                // --- PASSWORD INPUT (Reactive dengan Obx) ---
                Text(
                  'Kata Sandi',
                  style: GoogleFonts.inter(
                    fontSize: 14,
                    fontWeight: FontWeight.w500,
                    color: const Color(0xFF374151),
                  ),
                ),
                const SizedBox(height: 8),
                // Gunakan Obx hanya di widget yang berubah (Password Field)
                Obx(() => TextFormField(
                  controller: controller.passwordController, // Sambungkan Controller
                  obscureText: controller.isObscure.value,   // Baca value dari .obs
                  style: GoogleFonts.inter(),
                  decoration: InputDecoration(
                    hintText: '••••••••',
                    hintStyle: GoogleFonts.inter(color: Colors.grey.shade400),
                    filled: true,
                    fillColor: grayBg,
                    contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 16),
                    prefixIcon: const Icon(Icons.lock_outline, color: grayText, size: 20),
                    suffixIcon: IconButton(
                      icon: Icon(
                        controller.isObscure.value
                            ? Icons.visibility_off_outlined
                            : Icons.visibility_outlined,
                        color: grayText,
                        size: 20,
                      ),
                      onPressed: () {
                        // Panggil fungsi di controller
                        controller.togglePasswordVisibility();
                      },
                    ),
                    enabledBorder: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(12),
                      borderSide: const BorderSide(color: grayBorder),
                    ),
                    focusedBorder: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(12),
                      borderSide: const BorderSide(color: primaryColor, width: 2),
                    ),
                  ),
                )),

                // --- FORGOT PASSWORD ---
                Align(
                  alignment: Alignment.centerRight,
                  child: TextButton(
                    onPressed: () {},
                    child: Text(
                      'Lupa sandi?',
                      style: GoogleFonts.inter(
                        color: primaryColor,
                        fontWeight: FontWeight.w600,
                        fontSize: 14,
                      ),
                    ),
                  ),
                ),
                const SizedBox(height: 24),

                // --- LOGIN BUTTON ---
                SizedBox(
                  width: double.infinity,
                  height: 52,
                  child: ElevatedButton(
                    onPressed: () {
                      controller.login();
                    },
                    style: ElevatedButton.styleFrom(
                      backgroundColor: primaryColor,
                      foregroundColor: Colors.white,
                      elevation: 0,
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(12),
                      ),
                    ),
                    child: Text(
                      'Masuk Aplikasi',
                      style: GoogleFonts.inter(
                        fontSize: 16,
                        fontWeight: FontWeight.w600,
                      ),
                    ),
                  ),
                ),

                const SizedBox(height: 40),
                Center(
                  child: Text(
                    '© 2025 Sistem Presensi Mobile',
                    style: GoogleFonts.inter(
                      fontSize: 12,
                      color: Colors.grey.shade400,
                    ),
                  ),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}