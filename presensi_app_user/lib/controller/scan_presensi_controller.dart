import 'package:flutter/material.dart';
import 'package:flutter_dotenv/flutter_dotenv.dart';
import 'package:get/get.dart';
import 'package:http/http.dart' as http;
import 'package:mobile_scanner/mobile_scanner.dart';

import '../utils/notif_presensi.dart';

class ScanPresensiController extends GetxController {
  final MobileScannerController cameraController = MobileScannerController();
  var idUser = Get.arguments;
  // Variabel untuk mencegah pemindaian berulang (spam)
  var isScanning = false.obs;
  var isLoading = false.obs;
  String baseUrl = dotenv.env['BASE_URL'] ?? 'fallback_url';


  @override
  void onClose() {
    cameraController.dispose();
    super.onClose();
  }

  // Fungsi yang dipanggil saat QR terdeteksi
  void onDetect(BarcodeCapture capture) async {
    // 1. Cek apakah sedang memproses data? Jika ya, hentikan (return)
    if (isScanning.value || isLoading.value) return;

    final List<Barcode> barcodes = capture.barcodes;

    if (barcodes.isNotEmpty) {
      final code = barcodes.first.rawValue;

      if (code != null) {
        // 2. Kunci scanner agar tidak scan ulang
        isScanning.value = true;
        // 3. Panggil fungsi proses ke backend
        await processAbsence(code);
      }
    }
  }

  // Simulasi kirim data ke Backend
  Future<void> processAbsence(String qrCode) async {
    try {
      isLoading.value = true;

      // Tampilkan Loading Dialog
      Get.dialog(
        const Center(child: CircularProgressIndicator()),
        barrierDismissible: false,
      );

      await http.post(Uri.parse('$baseUrl/api/presensiViaQR'),
        body: {
          'qr_token' : qrCode,
          'user_id' : idUser.toString(),
          'tanggal' : DateTime.now().toIso8601String(),
          'status' : 'Hadir',
          'jam_masuk' : TimeOfDay.now().format(Get.context!),
        });

      // Tutup Loading
      Get.back();


      // Tampilkan Sukses
      // Get.snackbar(
      //   "Berhasil",
      //   "Presensi tercatat untuk kode: $qrCode",
      //   backgroundColor: Colors.green,
      //   colorText: Colors.white,
      //   snackPosition: SnackPosition.BOTTOM,
      //   margin: const EdgeInsets.all(10),
      // );

    } catch (e) {
      // Tutup Loading jika error
      Get.back();

      // Tampilkan Error
      // Get.snackbar(
      //   "Gagal",
      //   e.toString(),
      //   backgroundColor: Colors.red,
      //   colorText: Colors.white,
      //   snackPosition: SnackPosition.BOTTOM,
      //   margin: const EdgeInsets.all(10),
      // );

      // Reset agar user bisa mencoba scan lagi segera
      isScanning.value = false;
    } finally {
      isLoading.value = false;
    }
  }

  // Fungsi Toggle Flash (Opsional, dipindah dari View ke sini)
  void toggleFlash() {
    cameraController.toggleTorch();
  }
}