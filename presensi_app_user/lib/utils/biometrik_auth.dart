import 'package:flutter/services.dart';
import 'package:local_auth/local_auth.dart';

class BiometrikAuth {
  // Buat instance-nya
  final LocalAuthentication _auth = LocalAuthentication();

  // Fungsi untuk mengecek ketersediaan biometrik
  Future<bool> get isBiometricAvailable async {
    try {
      final bool canCheck = await _auth.canCheckBiometrics;
      final bool isSupported = await _auth.isDeviceSupported();
      return canCheck && isSupported;
    } on PlatformException catch (e) {
      print("Error saat cek biometrik: $e");
      return false;
    }
  }

  Future<bool> authenticate(String reason) async {
    try {
      // 1. Cek dulu apakah tersedia
      if (!await isBiometricAvailable) {
        print("Biometrik tidak tersedia atau tidak didukung.");
        return false;
      }

      // 2. Jika tersedia, jalankan autentikasi
      return await _auth.authenticate(
        localizedReason: reason, // Teks yang akan dilihat pengguna
        biometricOnly: false,   // Izinkan fallback (PIN/Pola) jika diatur

      );
    } on PlatformException catch (e) {
      print("Error saat autentikasi: ${e.message}");
      return false; // Gagal karena error
    } catch (e) {
      print("Error tidak terduga: $e");
      return false; // Gagal karena error lain
    }
  }
}