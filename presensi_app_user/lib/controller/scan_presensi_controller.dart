import 'package:flutter/material.dart';
import 'package:geolocator/geolocator.dart'; // Import ini untuk handling setting
import 'package:get/get.dart';
import 'package:mobile_scanner/mobile_scanner.dart';
import '../services/location_service.dart';
import '../services/presensi_api_service.dart';
import '../utils/notif_presensi.dart';

class ScanPresensiController extends GetxController {
  final LocationService _locationService = LocationService();
  final PresensiApiService _apiService = PresensiApiService();
  final MobileScannerController cameraController = MobileScannerController();

  var idUser = Get.arguments;
  var isScanning = false.obs;
  var isLoading = false.obs;
  var latitude = 0.0.obs;
  var longitude = 0.0.obs;
  var message = ''.obs;

  @override
  void onClose() {
    cameraController.dispose();
    super.onClose();
  }

  void onDetect(BarcodeCapture capture, BuildContext context) async {
    if (isScanning.value || isLoading.value) return;

    final List<Barcode> barcodes = capture.barcodes;
    if (barcodes.isNotEmpty && barcodes.first.rawValue != null) {
      isScanning.value = true;
      final code = barcodes.first.rawValue!;
      await _handlePresensiProcess(code, context);
    }
  }

  Future<void> _handlePresensiProcess(String qrCode, BuildContext context) async {
    // Tampilkan Loading
    _showLoadingDialog();

    try {
      isLoading.value = true;

      // 1. Ambil Lokasi (Akan throw error jika GPS mati/Ditolak)
      final position = await _locationService.getCurrentLocation();

      // Update state
      latitude.value = position.latitude;
      longitude.value = position.longitude;

      // 2. Hitung Jarak
      double jarak = _locationService.getDistanceFromOffice(latitude.value, longitude.value);

      if (!_locationService.isWithinOfficeRadius(jarak)) {
        throw "Jarak terlalu jauh: ${jarak.toStringAsFixed(2)} meter. (Maks 50m)";
      }

      // 3. Kirim API
      final response = await _apiService.submitPresensi(
        qrCode: qrCode,
        userId: idUser.toString(),
        latitude: latitude.value,
        longitude: longitude.value,
        context: context,
      );

      // 4. Sukses
      _closeLoadingDialog(); // Tutup loading dulu

      if (response.statusCode == 200 || response.statusCode == 201) {
        // Handle sukses visual disini (misal pindah halaman atau snackbar sukses)
        message.value = "Presensi Berhasil!";
        notifPresensi(context, message.value, true);
        Get.back();
      } else if(response.statusCode == 500){
        throw "Maaf, Presensi Telah Ditutup";
      }else {

        print("Response Body: ${response.body}");
        throw "Gagal dari server: ${response.statusCode}";
      }

    } catch (e) {

      _closeLoadingDialog(); // 1. TUTUP LOADING

      // 2. tampilkan pesan error/snackbar
      String errorMsg = e.toString();

      // Handle khusus jika permission denied forever
      if (errorMsg.contains('location_denied_forever')) {
        Get.defaultDialog(
            title: "Izin Lokasi",
            middleText: "Izin lokasi dimatikan permanen. Mohon nyalakan di pengaturan.",
            textConfirm: "Buka Pengaturan",
            textCancel: "Batal",
            onConfirm: () {
              Geolocator.openAppSettings();
              Get.back(); // Tutup dialog konfirmasi
            }
        );
      } else {
        // Tampilkan Snackbar Error biasa
        print("Error : $errorMsg");
        notifPresensi(context, errorMsg.replaceAll("Exception: ", ""), false);
      }
      await Future.delayed(const Duration(seconds: 2));
      // 3. Reset scanning agar bisa scan lagi
      isScanning.value = false;

    } finally {
      isLoading.value = false;
    }
  }

  // --- Helper UI ---

  void _showLoadingDialog() {
    Get.dialog(
      const PopScope(
        canPop: false, // Mencegah user menutup loading dengan tombol back
        child: Center(child: CircularProgressIndicator()),
      ),
      barrierDismissible: false,
    );
  }

  void _closeLoadingDialog() {
    // Cek apakah dialog sedang terbuka (untuk menghindari menutup halaman lain)
    if (Get.isDialogOpen == true) {
      Get.back();
    }
  }

  void toggleFlash() => cameraController.toggleTorch();
}