import 'package:flutter/material.dart';
import 'package:flutter_dotenv/flutter_dotenv.dart';
import 'package:geolocator/geolocator.dart';
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
  var latitude = 0.0.obs;
  var longitude = 0.0.obs;
  var message = ''.obs;
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
      String type = "QR_Masuk";
      type = barcodes.first.type.name;

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
      print("Memproses presensi untuk kode: $qrCode");
      // Tampilkan Loading Dialog
      Get.dialog(
        const Center(child: CircularProgressIndicator()),
        barrierDismissible: false,
      );

      //ambil lokasi
      await ambilLokasi();

      var response =  await http.post(Uri.parse('$baseUrl/api/presensiViaQR'),
        headers: {
          'Accept': 'application/json',

        },
        body: {
          'qr_token' : qrCode,
          'user_id' : idUser.toString(),
          'tanggal' : DateTime.now().toIso8601String(),
          'status'  : 'Hadir',
          'jam_absen' : TimeOfDay.now().format(Get.context!),
          'Latitude' : latitude.value.toString(),
          'Longitude' : longitude.value.toString(),
        });


      // Tampilkan Sukses
      // Get.snackbar(
      //   "Berhasil",
      //   "Presensi tercatat untuk kode: $qrCode",
      //   backgroundColor: Colors.green,
      //   colorText: Colors.white,
      //   snackPosition: SnackPosition.BOTTOM,
      //   margin: const EdgeInsets.all(10),
      // );
      
      print("Sukses presensi: ${response.body}");

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

      print("Gagal presensi: $e");

      // Reset agar user bisa mencoba scan lagi segera
      isScanning.value = false;
    } finally {
      isLoading.value = false;
    }
  }

  void toggleFlash() {
    cameraController.toggleTorch();
  }

  Future<void> ambilLokasi() async {
    isLoading.value = true;
    try {
      // 1. Cek apakah GPS (Service) Nyala?
      bool serviceEnabled = await Geolocator.isLocationServiceEnabled();
      if (!serviceEnabled) {
        Get.snackbar("Error", "GPS belum aktif. Mohon nyalakan GPS Anda.");
        return;
      }

      // 2. Cek Izin Aplikasi (Permission)
      LocationPermission permission = await Geolocator.checkPermission();

      if (permission == LocationPermission.denied) {
        // Jika belum ada izin, minta user
        permission = await Geolocator.requestPermission();
        if (permission == LocationPermission.denied) {
          Get.snackbar("Gagal", "Izin lokasi ditolak");
          return;
        }
      }

      if (permission == LocationPermission.deniedForever) {
        // Jika user menolak permanen (pilih 'Don't ask again')
        Get.snackbar("Penting", "Izin lokasi dimatikan permanen. Buka pengaturan HP.");
        return; // Opsional: Geolocator.openAppSettings();
      }

      // 3. AMBIL KOORDINAT (Jika semua aman)
      // High accuracy cocok untuk presensi (radius kecil)
      Position position = await Geolocator.getCurrentPosition(
          desiredAccuracy: LocationAccuracy.high
      );

      // Simpan ke variabel
      latitude.value = position.latitude;
      longitude.value = position.longitude;
      message.value = "Lokasi didapat: ${position.latitude}, ${position.longitude}";
      print("Lokasi : ${message.value}");
    } catch (e) {
      Get.snackbar("Error", "Gagal mengambil lokasi: $e");
    } finally {
      isLoading.value = false;
    }
  }
}

