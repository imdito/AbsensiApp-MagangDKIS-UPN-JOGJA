import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:mobile_scanner/mobile_scanner.dart';

class ScanPresensiController extends GetxController {
  final MobileScannerController cameraController = MobileScannerController();

  // Variabel untuk mencegah pemindaian berulang (spam)
  var isScanning = false.obs;
  var isLoading = false.obs;

  @override
  void onClose() {
    // Hapus controller kamera saat halaman ditutup untuk hemat memori
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

        debugPrint("QR Found: $code");

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

      // --- SIMULASI API CALL (Ganti ini nanti dengan logic HTTP/Dio) ---
      await Future.delayed(const Duration(seconds: 2));

      // Anggap validasi: QR harus berawalan "ABSEN-"
      if (!qrCode.startsWith("ABSEN-")) {
        throw "QR Code tidak valid!";
      }
      // ---------------------------------------------------------------

      // Tutup Loading
      Get.back();

      // Tampilkan Sukses
      Get.snackbar(
        "Berhasil",
        "Presensi tercatat untuk kode: $qrCode",
        backgroundColor: Colors.green,
        colorText: Colors.white,
        snackPosition: SnackPosition.BOTTOM,
        margin: const EdgeInsets.all(10),
      );

      // Opsi A: Balik ke halaman Home setelah sukses
      // Get.back();

      // Opsi B: Tetap di halaman scan, tapi reset agar bisa scan lagi setelah delay
      await Future.delayed(const Duration(seconds: 2));
      isScanning.value = false;

    } catch (e) {
      // Tutup Loading jika error
      Get.back();

      // Tampilkan Error
      Get.snackbar(
        "Gagal",
        e.toString(),
        backgroundColor: Colors.red,
        colorText: Colors.white,
        snackPosition: SnackPosition.BOTTOM,
        margin: const EdgeInsets.all(10),
      );

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